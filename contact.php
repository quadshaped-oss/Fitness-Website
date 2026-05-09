<?php
require 'db.php';
$email="";$phone="";$address="";$banner="";$favicon="";$title="";
$q=$conn->query("SELECT * FROM contact LIMIT 1");
if($q->num_rows){$r=$q->fetch_assoc();$email=$r['email'];$phone=$r['phone'];$address=$r['address'];}
$q2=$conn->query("SELECT contact_banner,favicon,title FROM info LIMIT 1");
if($q2->num_rows){$r2=$q2->fetch_assoc();$banner=$r2['contact_banner'];$favicon=$r2['favicon'];$title=$r2['title'];}
$map=urlencode($address);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="description" content="Contact <?php echo htmlspecialchars($title); ?> - Get in touch with us by phone, email, or visit our location. Send us a message and we'll get back to you shortly.">
<meta name="keywords" content="contact <?php echo htmlspecialchars($title); ?>, gym contact, fitness studio location, get in touch">
<meta name="robots" content="index,follow">
<meta property="og:title" content="Contact Us - <?php echo htmlspecialchars($title); ?>">
<meta property="og:description" content="Reach out to <?php echo htmlspecialchars($title); ?> for enquiries, bookings, or support.">
<meta property="og:type" content="website">
<meta name="twitter:card" content="summary_large_image">
<title>Contact Us - <?php echo htmlspecialchars($title); ?></title>
<?php if($favicon!=""){ ?><link rel="icon" type="image/x-icon" href="files/<?php echo $favicon; ?>"><?php } ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;800;900&family=Barlow:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{--dark:#1e1e1e;--darker:#111;--card:#252525;--accent:#c8e63c;--text:#fff;--muted:#999;--border:#2e2e2e;--max:1400px;--pad:40px}
html{scroll-behavior:smooth}
body{background:var(--darker);color:var(--text);font-family:'Barlow',sans-serif;overflow-x:hidden}

@keyframes fadeUp{from{opacity:0;transform:translateY(40px)}to{opacity:1;transform:translateY(0)}}
@keyframes slideRight{from{opacity:0;transform:translateX(-50px)}to{opacity:1;transform:translateX(0)}}
@keyframes slideLeft{from{opacity:0;transform:translateX(50px)}to{opacity:1;transform:translateX(0)}}
@keyframes heroBgKen{from{transform:scale(1)}to{transform:scale(1.06)}}
@keyframes accentPulse{0%,100%{opacity:.22}50%{opacity:.48}}
@keyframes mapReveal{from{opacity:0;transform:scaleY(.95)}to{opacity:1;transform:scaleY(1)}}
@keyframes iconBounce{0%,100%{transform:scale(1)}50%{transform:scale(1.15)}}

.anim-ready{opacity:0}
.anim-up{animation:fadeUp .7s cubic-bezier(.22,1,.36,1) forwards}
.anim-right{animation:slideRight .75s cubic-bezier(.22,1,.36,1) forwards}
.anim-left{animation:slideLeft .75s cubic-bezier(.22,1,.36,1) forwards}

#ct-hero{position:relative;min-height:420px;display:flex;align-items:flex-end;overflow:hidden}
#ct-hero ._bg{position:absolute;inset:0;z-index:0}
#ct-hero ._bg img{width:100%;height:100%;object-fit:cover;filter:grayscale(100%);display:block;animation:heroBgKen 14s ease-in-out infinite alternate}
#ct-hero ._bg::after{content:'';position:absolute;inset:0;background:linear-gradient(to right,rgba(10,10,10,.82) 50%,rgba(10,10,10,.3) 100%)}
#ct-hero ._atl{position:absolute;bottom:0;left:0;width:160px;height:160px;z-index:1;pointer-events:none;animation:accentPulse 4s ease-in-out infinite}
#ct-hero ._atl::before{content:'';position:absolute;bottom:0;left:0;width:0;height:0;border-style:solid;border-width:0 0 160px 160px;border-color:transparent transparent rgba(200,230,60,.22) transparent}
#ct-hero ._atr{position:absolute;top:0;right:0;width:200px;height:200px;z-index:1;pointer-events:none;animation:accentPulse 4s 1s ease-in-out infinite}
#ct-hero ._atr::before{content:'';position:absolute;top:0;right:0;width:0;height:0;border-style:solid;border-width:0 200px 200px 0;border-color:transparent rgba(200,230,60,.16) transparent transparent}
#ct-hero ._atr::after{content:'';position:absolute;top:0;right:0;width:0;height:0;border-style:solid;border-width:0 130px 130px 0;border-color:transparent rgba(200,230,60,.1) transparent transparent}
#ct-hero ._hc{position:relative;z-index:2;max-width:var(--max);width:100%;margin:0 auto;padding:120px var(--pad) 48px}
#ct-hero h1{font-family:'Barlow Condensed',sans-serif;font-size:clamp(2.5rem,6vw,4.8rem);font-weight:900;text-transform:uppercase;line-height:1;margin-bottom:18px;animation:fadeUp .9s .1s cubic-bezier(.22,1,.36,1) both}
#ct-hero h1 .ol{color:transparent;-webkit-text-stroke:2px #fff}
#ct-hero ._bc{display:flex;align-items:center;gap:8px;font-size:14px;color:var(--muted);animation:fadeUp .9s .3s cubic-bezier(.22,1,.36,1) both}
#ct-hero ._bc a{color:var(--muted);text-decoration:none;transition:color .2s}
#ct-hero ._bc a:hover{color:var(--accent)}
#ct-hero ._bc span{color:#fff;font-weight:600}

#ct-main{background:var(--dark);padding:80px var(--pad)}
#ct-main ._inner{max-width:var(--max);margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:start}

#ct-main .ct-left h2{font-family:'Barlow Condensed',sans-serif;font-size:clamp(2rem,4vw,3rem);font-weight:900;text-transform:uppercase;line-height:1.05;margin-bottom:40px}
#ct-main .ct-left h2 .ol{color:transparent;-webkit-text-stroke:2px #fff}
#ct-main ._citem{display:flex;align-items:flex-start;gap:18px;margin-bottom:32px;transition:transform .3s}
#ct-main ._citem:hover{transform:translateX(6px)}
#ct-main ._cicon{width:46px;height:46px;border:1px solid var(--border);border-radius:2px;display:flex;align-items:center;justify-content:center;flex-shrink:0;background:var(--card);transition:background .3s,border-color .3s}
#ct-main ._citem:hover ._cicon{background:rgba(200,230,60,.12);border-color:rgba(200,230,60,.4)}
#ct-main ._cicon svg{color:var(--accent);transition:transform .3s}
#ct-main ._citem:hover ._cicon svg{transform:scale(1.2)}
#ct-main ._ctext label{display:block;font-size:11px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);margin-bottom:6px}
#ct-main ._ctext a,#ct-main ._ctext p{font-size:15px;color:#ccc;text-decoration:none;line-height:1.6;transition:color .2s}
#ct-main ._ctext a:hover{color:var(--accent)}

#ct-main .ct-right h2{font-family:'Barlow Condensed',sans-serif;font-size:clamp(2rem,4vw,3rem);font-weight:900;text-transform:uppercase;line-height:1.05;margin-bottom:32px}
#ct-main .ct-right h2 .ol{color:transparent;-webkit-text-stroke:2px #fff}
#ct-main ._frow{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px}
#ct-main ._fi{width:100%;background:#1a1a1a;border:1px solid var(--border);color:#fff;padding:14px 18px;font-family:'Barlow',sans-serif;font-size:14px;outline:none;border-radius:2px;transition:border-color .2s,transform .2s,box-shadow .2s}
#ct-main ._fi::placeholder{color:#555}
#ct-main ._fi:focus{border-color:var(--accent);transform:translateY(-1px);box-shadow:0 4px 12px rgba(200,230,60,.1)}
#ct-main ._ft{width:100%;background:#1a1a1a;border:1px solid var(--border);color:#fff;padding:14px 18px;font-family:'Barlow',sans-serif;font-size:14px;outline:none;border-radius:2px;resize:vertical;min-height:150px;margin-bottom:16px;transition:border-color .2s,box-shadow .2s}
#ct-main ._ft::placeholder{color:#555}
#ct-main ._ft:focus{border-color:var(--accent);box-shadow:0 4px 12px rgba(200,230,60,.1)}
#ct-main ._fsub{width:100%;background:var(--accent);color:#111;border:none;padding:16px;font-family:'Barlow',sans-serif;font-size:14px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;cursor:pointer;border-radius:2px;transition:background .2s,transform .2s,box-shadow .2s}
#ct-main ._fsub:hover{background:#d4ef50;transform:translateY(-3px);box-shadow:0 8px 24px rgba(200,230,60,.3)}
#ct-main ._fsub:active{transform:translateY(0)}

#ct-map{width:100%;height:480px;border:0;display:block;filter:grayscale(100%);opacity:0;animation:mapReveal .8s .4s ease forwards}

@media(max-width:900px){
:root{--pad:24px}
#ct-main ._inner{grid-template-columns:1fr;gap:50px}
}
@media(max-width:600px){
:root{--pad:18px}
#ct-main ._frow{grid-template-columns:1fr}
#ct-map{height:320px}
}
</style>
</head>
<body>

<?php include 'api/nav.php'; ?>

<main>

<section id="ct-hero" aria-label="Contact Hero">
<div class="_bg">
<?php if($banner!=""){ ?>
<img src="./files/<?php echo $banner; ?>" alt="Contact <?php echo htmlspecialchars($title); ?>" loading="eager">
<?php } ?>
</div>
<div class="_atl"></div>
<div class="_atr"></div>
<div class="_hc">
<h1>Meet Our <span class="ol">Fitness</span><br><span class="ol">Experts</span> Here.</h1>
<nav class="_bc" aria-label="Breadcrumb">
<a href="index.php">Home</a>
<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
<span>Contact Us</span>
</nav>
</div>
</section>

<section id="ct-main" aria-label="Contact Details">
<div class="_inner">
<div class="ct-left anim-ready" data-anim="right">
<h2>Get In <span class="ol">Touch</span></h2>
<?php if($email!=""){ ?>
<div class="_citem">
<div class="_cicon">
<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 7l10 7 10-7"/></svg>
</div>
<div class="_ctext">
<label>Email</label>
<a href="mailto:<?php echo $email; ?>"><?php echo htmlspecialchars($email); ?></a>
</div>
</div>
<?php } ?>
<?php if($phone!=""){ ?>
<div class="_citem">
<div class="_cicon">
<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 01-2.18 2A19.79 19.79 0 013.09 5.18 2 2 0 015.07 3h3a2 2 0 012 1.72c.12.96.36 1.9.72 2.81a2 2 0 01-.45 2.11L9.09 10.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.91.36 1.85.6 2.81.72A2 2 0 0122 16.92z"/></svg>
</div>
<div class="_ctext">
<label>Phone</label>
<a href="tel:+91<?php echo $phone; ?>">+91 <?php echo htmlspecialchars($phone); ?></a>
</div>
</div>
<?php } ?>
<?php if($address!=""){ ?>
<div class="_citem">
<div class="_cicon">
<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
</div>
<div class="_ctext">
<label>Address</label>
<p><?php echo htmlspecialchars($address); ?></p>
</div>
</div>
<?php } ?>
</div>

<div class="ct-right anim-ready" data-anim="left">
<h2>Send Us A <span class="ol">Message</span></h2>
<form method="post" action="">
<div class="_frow">
<input class="_fi" type="text" name="name" placeholder="Name" required>
<input class="_fi" type="email" name="email_field" placeholder="Email">
</div>
<textarea class="_ft" name="message" placeholder="Message" required></textarea>
<button class="_fsub" type="submit" name="send">Send Message</button>
</form>
</div>
</div>
</section>

<?php if($address!=""){ ?>
<iframe id="ct-map" src="https://www.google.com/maps?q=<?php echo $map; ?>&output=embed" title="<?php echo htmlspecialchars($title); ?> Location" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
<?php } ?>

<?php include 'api/footer.php'; ?>

</main>

<?php include 'api/top.php'; ?>

<?php
if(isset($_POST['send'])){
$name=$_POST['name'];
$userphone=$phone;
$message=$_POST['message'];
$text="Name: ".$name."%0AMessage: ".$message;
$wa="https://wa.me/91".$userphone."?text=".$text;
echo "<script>location.replace('".addslashes($wa)."')</script>";
}
?>

<script>
(function(){
var io=new IntersectionObserver(function(entries){
entries.forEach(function(e){
if(e.isIntersecting){
var el=e.target;
var anim=el.dataset.anim||'up';
var delay=parseInt(el.dataset.delay||0);
setTimeout(function(){
if(anim==='right') el.classList.add('anim-right');
else if(anim==='left') el.classList.add('anim-left');
else el.classList.add('anim-up');
},delay);
io.unobserve(el);
}
});
},{threshold:.1});
document.querySelectorAll('.anim-ready').forEach(function(el,i){
if(!el.dataset.delay) el.dataset.delay=i*80;
io.observe(el);
});
})();
</script>

</body>
</html>