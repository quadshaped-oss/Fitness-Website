<?php
require '../db.php';
require 'auth.php';

$id=0;$email="";$phone="";$address="";

$q=$conn->query("SELECT * FROM contact LIMIT 1");
if($q->num_rows){$r=$q->fetch_assoc();$id=$r['id'];$email=$r['email'];$phone=$r['phone'];$address=$r['address'];}

function go($u){echo '<!DOCTYPE html><html><head><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script></head><body><script>location.replace("'.$u.'");</script></body></html>';exit;}

if(isset($_POST['add'])){
$e=$_POST['email'];$p=$_POST['phone'];$a=$_POST['address'];
$stmt=$conn->prepare("INSERT INTO contact(email,phone,address) VALUES(?,?,?)");
$stmt->bind_param("sss",$e,$p,$a);$stmt->execute();go("contact.php?added=1");
}
if(isset($_POST['update'])){
$e=$_POST['email'];$p=$_POST['phone'];$a=$_POST['address'];
$stmt=$conn->prepare("UPDATE contact SET email=?,phone=?,address=? WHERE id=?");
$stmt->bind_param("sssi",$e,$p,$a,$id);$stmt->execute();go("contact.php?updated=1");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Contact</title>
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
<span class="topbar-title">Contact</span>
</div>
<div class="page-content">
<div class="page-header">
<h1>Contact Information</h1>
<p>Update your public contact details</p>
</div>
<div class="card">
<div class="card-title">
<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.62 3.38 2 2 0 0 1 3.62 1.18l3-.03a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.91 8.96a16 16 0 0 0 6 6l.96-.96a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
Contact Details
</div>
<div class="form-group">
<label class="form-label">Email Address</label>
<input type="email" id="f_email" class="form-control" placeholder="contact@example.com" value="<?php echo htmlspecialchars($email); ?>" required>
</div>
<div class="form-group">
<label class="form-label">Phone Number</label>
<input type="text" id="f_phone" class="form-control" placeholder="+91 9876543210" value="<?php echo htmlspecialchars($phone); ?>" required>
</div>
<div class="form-group">
<label class="form-label">Address</label>
<textarea id="f_address" class="form-control" placeholder="Full address..." required><?php echo htmlspecialchars($address); ?></textarea>
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
function submitForm(){
var fd=new FormData();
fd.append('email',document.getElementById('f_email').value);
fd.append('phone',document.getElementById('f_phone').value);
fd.append('address',document.getElementById('f_address').value);
<?php if($id==0){ ?>fd.append('add','1');<?php }else{ ?>fd.append('update','1');<?php } ?>
fetch('contact.php',{method:'POST',body:fd}).then(r=>r.text()).then(t=>{document.open();document.write(t);document.close();});
}
<?php if(isset($_GET['added'])){ ?>Swal.fire({toast:true,position:'top-end',icon:'success',title:'Contact Saved',showConfirmButton:false,timer:2000}).then(()=>{location.replace('contact.php')});<?php } ?>
<?php if(isset($_GET['updated'])){ ?>Swal.fire({toast:true,position:'top-end',icon:'success',title:'Contact Updated',showConfirmButton:false,timer:2000}).then(()=>{location.replace('contact.php')});<?php } ?>
</script>
</body>
</html>