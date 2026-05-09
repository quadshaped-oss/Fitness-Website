<?php
require '../db.php';
require 'auth.php';

$id=0;$logo="";$favicon="";$title="";$upiid="";
$home_banner="";$about_banner="";$portfolio_banner="";
$contact_banner="";$ready_banner="";$upi_banner="";

$q=$conn->query("SELECT * FROM info LIMIT 1");
if($q->num_rows){
$r=$q->fetch_assoc();
$id=$r['id'];$logo=$r['logo'];$favicon=$r['favicon'];$title=$r['title'];$upiid=$r['upiid'];
$home_banner=$r['home_banner'];$about_banner=$r['about_banner'];$portfolio_banner=$r['portfolio_banner'];
$contact_banner=$r['contact_banner'];$ready_banner=$r['ready_banner'];$upi_banner=$r['upi_banner'];
}

function go($u){echo '<!DOCTYPE html><html><head><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script></head><body><script>location.replace("'.$u.'");</script></body></html>';exit;}

function upload($field,$old=""){
if($_FILES[$field]['name']!=""){
$name=time().'_'.$_FILES[$field]['name'];
$tmp=$_FILES[$field]['tmp_name'];
move_uploaded_file($tmp,"../files/".$name);
if($old!=""&&file_exists("../files/".$old))unlink("../files/".$old);
return $name;
}
return $old;
}

if(isset($_POST['add'])){
$title=$_POST['title'];$upiid=$_POST['upiid'];
$logo=upload("logo");$favicon=upload("favicon");$home_banner=upload("home_banner");
$about_banner=upload("about_banner");$portfolio_banner=upload("portfolio_banner");
$contact_banner=upload("contact_banner");$ready_banner=upload("ready_banner");$upi_banner=upload("upi_banner");
$stmt=$conn->prepare("INSERT INTO info(logo,favicon,title,upiid,home_banner,about_banner,portfolio_banner,contact_banner,ready_banner,upi_banner) VALUES(?,?,?,?,?,?,?,?,?,?)");
$stmt->bind_param("ssssssssss",$logo,$favicon,$title,$upiid,$home_banner,$about_banner,$portfolio_banner,$contact_banner,$ready_banner,$upi_banner);
$stmt->execute();
go("index.php?added=1");
}

if(isset($_POST['update'])){
$title=$_POST['title'];$upiid=$_POST['upiid'];
$logo=upload("logo",$logo);$favicon=upload("favicon",$favicon);$home_banner=upload("home_banner",$home_banner);
$about_banner=upload("about_banner",$about_banner);$portfolio_banner=upload("portfolio_banner",$portfolio_banner);
$contact_banner=upload("contact_banner",$contact_banner);$ready_banner=upload("ready_banner",$ready_banner);$upi_banner=upload("upi_banner",$upi_banner);
$stmt=$conn->prepare("UPDATE info SET logo=?,favicon=?,title=?,upiid=?,home_banner=?,about_banner=?,portfolio_banner=?,contact_banner=?,ready_banner=?,upi_banner=? WHERE id=?");
$stmt->bind_param("ssssssssssi",$logo,$favicon,$title,$upiid,$home_banner,$about_banner,$portfolio_banner,$contact_banner,$ready_banner,$upi_banner,$id);
$stmt->execute();
go("index.php?updated=1");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Site Info</title>
<link rel="stylesheet" href="style.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="admin-layout">
<?php include 'sidebar.php'; ?>
<div class="main-content">
<div class="topbar">
<button class="topbar-menu-btn" onclick="openSidebar()" aria-label="Open menu">
<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="5" r="1"/><circle cx="12" cy="12" r="1"/><circle cx="12" cy="19" r="1"/></svg>
</button>
<span class="topbar-title">Site Info</span>
</div>
<div class="page-content">
<div class="page-header">
<h1>Site Information</h1>
<p>Manage your website's global settings, banners and branding</p>
</div>
<div class="card">
<div class="card-title">
<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
General Settings
</div>
<div id="formInner">
<div class="form-row">
<div class="form-group">
<label class="form-label">Site Title</label>
<input type="text" id="f_title" class="form-control" placeholder="My Website" value="<?php echo htmlspecialchars($title); ?>" required>
</div>
<div class="form-group">
<label class="form-label">UPI ID</label>
<input type="text" id="f_upiid" class="form-control" placeholder="name@upi" value="<?php echo htmlspecialchars($upiid); ?>">
</div>
</div>
<div class="form-row">
<div class="form-group">
<label class="form-label">Logo</label>
<div class="file-upload-area" onclick="document.getElementById('f_logo').click()">
<input type="file" id="f_logo" accept="image/*" style="display:none" onchange="previewImg(this,'prev_logo')">
<span class="file-upload-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></span>
<div class="file-upload-text"><b>Click to upload</b> or drag &amp; drop</div>
</div>
<?php if($logo!=""){ ?><div class="image-preview-box"><img id="prev_logo" class="image-preview" src="../files/<?php echo $logo; ?>"><span style="font-size:0.8rem;color:var(--text-muted)">Current logo</span></div><?php }else{ ?><div class="image-preview-box"><img id="prev_logo" class="image-preview" src="" style="display:none"></div><?php } ?>
</div>
<div class="form-group">
<label class="form-label">Favicon</label>
<div class="file-upload-area" onclick="document.getElementById('f_favicon').click()">
<input type="file" id="f_favicon" accept="image/*" style="display:none" onchange="previewImg(this,'prev_favicon')">
<span class="file-upload-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></span>
<div class="file-upload-text"><b>Click to upload</b> favicon</div>
</div>
<?php if($favicon!=""){ ?><div class="image-preview-box"><img id="prev_favicon" class="image-preview" src="../files/<?php echo $favicon; ?>"><span style="font-size:0.8rem;color:var(--text-muted)">Current favicon</span></div><?php }else{ ?><div class="image-preview-box"><img id="prev_favicon" class="image-preview" src="" style="display:none"></div><?php } ?>
</div>
</div>
</div>
</div>

<div class="card">
<div class="card-title">
<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
Banners
</div>
<?php
$banners=[
['f_home_banner','prev_home','Home Banner',$home_banner],
['f_about_banner','prev_about','About Banner',$about_banner],
['f_portfolio_banner','prev_portfolio','Portfolio Banner',$portfolio_banner],
['f_contact_banner','prev_contact','Contact Banner',$contact_banner],
['f_ready_banner','prev_ready','Ready Banner',$ready_banner],
['f_upi_banner','prev_upi','UPI Banner',$upi_banner],
];
echo '<div class="form-row">';
foreach($banners as $b){
echo '<div class="form-group"><label class="form-label">'.$b[2].'</label>';
echo '<div class="file-upload-area" onclick="document.getElementById(\''.$b[0].'\').click()">';
echo '<input type="file" id="'.$b[0].'" accept="image/*" style="display:none" onchange="previewImg(this,\''.$b[1].'\')">';
echo '<span class="file-upload-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></span>';
echo '<div class="file-upload-text"><b>Upload</b> image</div></div>';
if($b[3]!=""){echo '<div class="image-preview-box"><img id="'.$b[1].'" class="image-preview" src="../files/'.$b[3].'"></div>';}
else{echo '<div class="image-preview-box"><img id="'.$b[1].'" class="image-preview" src="" style="display:none"></div>';}
echo '</div>';
}
echo '</div>';
?>
<div class="form-actions">
<button type="button" class="btn btn-primary" onclick="submitForm()">
<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
<?php echo $id==0?'Save Info':'Update Info'; ?>
</button>
</div>
</div>
</div>
</div>
</div>
</div>

<script>
function previewImg(input,previewId){
var file=input.files[0];
if(file){
var img=document.getElementById(previewId);
img.src=URL.createObjectURL(file);
img.style.display='block';
}
}

function submitForm(){
var fd=new FormData();
fd.append('title',document.getElementById('f_title').value);
fd.append('upiid',document.getElementById('f_upiid').value);
var fields=['f_logo','f_favicon','f_home_banner','f_about_banner','f_portfolio_banner','f_contact_banner','f_ready_banner','f_upi_banner'];
var names=['logo','favicon','home_banner','about_banner','portfolio_banner','contact_banner','ready_banner','upi_banner'];
fields.forEach(function(f,i){
var el=document.getElementById(f);
if(el.files[0])fd.append(names[i],el.files[0]);
});
<?php if($id==0){ ?>
fd.append('add','1');
<?php }else{ ?>
fd.append('update','1');
<?php } ?>
fetch('index.php',{method:'POST',body:fd}).then(function(r){return r.text();}).then(function(t){
document.open();document.write(t);document.close();
});
}

<?php if(isset($_GET['added'])){ ?>
Swal.fire({toast:true,position:'top-end',icon:'success',title:'Info Saved',showConfirmButton:false,timer:2000}).then(()=>{location.replace('index.php')});
<?php } ?>
<?php if(isset($_GET['updated'])){ ?>
Swal.fire({toast:true,position:'top-end',icon:'success',title:'Info Updated',showConfirmButton:false,timer:2000}).then(()=>{location.replace('index.php')});
<?php } ?>
</script>
</body>
</html>