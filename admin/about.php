<?php
require '../db.php';
require 'auth.php';

$id=0;$title="";$description="";$image="";

$q=$conn->query("SELECT * FROM about LIMIT 1");
if($q->num_rows){$r=$q->fetch_assoc();$id=$r['id'];$title=$r['title'];$description=$r['description'];$image=$r['image'];}

function go($u){echo '<!DOCTYPE html><html><head><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script></head><body><script>location.replace("'.$u.'");</script></body></html>';exit;}

if(isset($_POST['add'])){
$t=$_POST['title'];$d=$_POST['description'];
$f=$_FILES['image']['name'];$tmp=$_FILES['image']['tmp_name'];
$n=time().'_'.$f;move_uploaded_file($tmp,"../files/".$n);
$stmt=$conn->prepare("INSERT INTO about(image,title,description) VALUES(?,?,?)");
$stmt->bind_param("sss",$n,$t,$d);$stmt->execute();
go("about.php?added=1");
}

if(isset($_POST['update'])){
$t=$_POST['title'];$d=$_POST['description'];
if($_FILES['image']['name']!=""){
$q=$conn->query("SELECT image FROM about WHERE id=$id");$r=$q->fetch_assoc();
if(file_exists("../files/".$r['image']))unlink("../files/".$r['image']);
$f=$_FILES['image']['name'];$tmp=$_FILES['image']['tmp_name'];$n=time().'_'.$f;
move_uploaded_file($tmp,"../files/".$n);
$stmt=$conn->prepare("UPDATE about SET image=?,title=?,description=? WHERE id=?");
$stmt->bind_param("sssi",$n,$t,$d,$id);
}else{
$stmt=$conn->prepare("UPDATE about SET title=?,description=? WHERE id=?");
$stmt->bind_param("ssi",$t,$d,$id);
}
$stmt->execute();go("about.php?updated=1");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>About</title>
<link rel="stylesheet" href="style.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="admin-layout">
<?php include 'sidebar.php'; ?>
<div class="main-content">
<div class="topbar">
<button class="topbar-menu-btn" onclick="openSidebar()">
<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="5" r="1"/><circle cx="12" cy="12" r="1"/><circle cx="12" cy="19" r="1"/></svg>
</button>
<span class="topbar-title">About</span>
</div>
<div class="page-content">
<div class="page-header">
<h1>About Section</h1>
<p>Manage your about page content and image</p>
</div>
<div class="card">
<div class="card-title">
<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
About Content
</div>
<div class="form-group">
<label class="form-label">Image</label>
<div class="file-upload-area" onclick="document.getElementById('imgInput').click()">
<input type="file" id="imgInput" accept="image/*" style="display:none" onchange="previewImg(this)">
<span class="file-upload-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></span>
<div class="file-upload-text"><b>Click to upload</b> or drag &amp; drop</div>
</div>
<div class="image-preview-box">
<img id="preview" class="image-preview" src="<?php echo $image!=''?'../files/'.$image:''; ?>" style="<?php echo $image==''?'display:none':''; ?>">
</div>
</div>
<div class="form-group">
<label class="form-label">Title</label>
<input type="text" id="f_title" class="form-control" placeholder="About title" value="<?php echo htmlspecialchars($title); ?>" required>
</div>
<div class="form-group">
<label class="form-label">Description</label>
<textarea id="f_desc" class="form-control" placeholder="Write about your company..." required><?php echo htmlspecialchars($description); ?></textarea>
</div>
<div class="form-actions">
<button type="button" class="btn btn-primary" onclick="submitForm()">
<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
<?php echo $id==0?'Save':'Update'; ?>
</button>
</div>
</div>
</div>
</div>
</div>
</div>
<script>
function previewImg(input){
if(input.files[0]){
document.getElementById('preview').src=URL.createObjectURL(input.files[0]);
document.getElementById('preview').style.display='block';
}
}
function submitForm(){
var fd=new FormData();
fd.append('title',document.getElementById('f_title').value);
fd.append('description',document.getElementById('f_desc').value);
var img=document.getElementById('imgInput');
if(img.files[0])fd.append('image',img.files[0]);
<?php if($id==0){ ?>fd.append('add','1');<?php }else{ ?>fd.append('update','1');<?php } ?>
fetch('about.php',{method:'POST',body:fd}).then(r=>r.text()).then(t=>{document.open();document.write(t);document.close();});
}
<?php if(isset($_GET['added'])){ ?>Swal.fire({toast:true,position:'top-end',icon:'success',title:'About Saved',showConfirmButton:false,timer:2000}).then(()=>{location.replace('about.php')});<?php } ?>
<?php if(isset($_GET['updated'])){ ?>Swal.fire({toast:true,position:'top-end',icon:'success',title:'About Updated',showConfirmButton:false,timer:2000}).then(()=>{location.replace('about.php')});<?php } ?>
</script>
</body>
</html>