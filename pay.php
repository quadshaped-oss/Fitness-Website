<?php
require 'db.php';
$title="";$favicon="";$upiid="";$banner="";$logo="";
$q=$conn->query("SELECT * FROM info LIMIT 1");
if($q->num_rows){$r=$q->fetch_assoc();$title=$r['title'];$favicon=$r['favicon'];$upiid=$r['upiid'];$banner=$r['upi_banner'];$logo=$r['logo'];}
$qr="upi://pay?pa=".$upiid;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="description" content="Pay <?php echo htmlspecialchars($title); ?> - Scan the QR code or use our UPI ID to make a secure payment instantly.">
<meta name="keywords" content="pay <?php echo htmlspecialchars($title); ?>, gym payment, UPI payment, fitness membership fee">
<meta name="robots" content="index,follow">
<meta property="og:title" content="Pay - <?php echo htmlspecialchars($title); ?>">
<meta property="og:description" content="Make a secure UPI payment to <?php echo htmlspecialchars($title); ?>.">
<meta property="og:type" content="website">
<meta name="twitter:card" content="summary_large_image">
<title>Pay - <?php echo htmlspecialchars($title); ?></title>
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
@keyframes heroBgKen{from{transform:scale(1)}to{transform:scale(1.06)}}
@keyframes accentPulse{0%,100%{opacity:.22}50%{opacity:.48}}
@keyframes qrReveal{from{opacity:0;transform:scale(.85) rotate(-3deg)}to{opacity:1;transform:scale(1) rotate(0)}}
@keyframes cardFloat{0%,100%{transform:translateY(0)}50%{transform:translateY(-6px)}}
@keyframes upiGlow{0%,100%{box-shadow:0 0 0 0 rgba(200,230,60,0)}50%{box-shadow:0 0 0 6px rgba(200,230,60,.15)}}
@keyframes scanLine{0%{top:0}100%{top:100%}}
@keyframes logoFade{from{opacity:0;transform:translateY(-16px)}to{opacity:1;transform:translateY(0)}}

.anim-ready{opacity:0}
.anim-up{animation:fadeUp .7s cubic-bezier(.22,1,.36,1) forwards}
.anim-up._card-floater{animation:fadeUp .7s cubic-bezier(.22,1,.36,1) forwards}
.anim-up._card-floater ._card-float-inner{animation:cardFloat 6s 1.5s ease-in-out infinite}

#py-hero{position:relative;min-height:420px;display:flex;align-items:flex-end;overflow:hidden}
#py-hero ._bg{position:absolute;inset:0;z-index:0}
#py-hero ._bg img{width:100%;height:100%;object-fit:cover;filter:grayscale(100%);display:block;animation:heroBgKen 14s ease-in-out infinite alternate}
#py-hero ._bg::after{content:'';position:absolute;inset:0;background:linear-gradient(to right,rgba(10,10,10,.82) 50%,rgba(10,10,10,.3) 100%)}
#py-hero ._atl{position:absolute;bottom:0;left:0;width:160px;height:160px;z-index:1;pointer-events:none;animation:accentPulse 4s ease-in-out infinite}
#py-hero ._atl::before{content:'';position:absolute;bottom:0;left:0;width:0;height:0;border-style:solid;border-width:0 0 160px 160px;border-color:transparent transparent rgba(200,230,60,.22) transparent}
#py-hero ._atr{position:absolute;top:0;right:0;width:200px;height:200px;z-index:1;pointer-events:none;animation:accentPulse 4s 1s ease-in-out infinite}
#py-hero ._atr::before{content:'';position:absolute;top:0;right:0;width:0;height:0;border-style:solid;border-width:0 200px 200px 0;border-color:transparent rgba(200,230,60,.16) transparent transparent}
#py-hero ._atr::after{content:'';position:absolute;top:0;right:0;width:0;height:0;border-style:solid;border-width:0 130px 130px 0;border-color:transparent rgba(200,230,60,.1) transparent transparent}
#py-hero ._hc{position:relative;z-index:2;max-width:var(--max);width:100%;margin:0 auto;padding:120px var(--pad) 48px}
#py-hero h1{font-family:'Barlow Condensed',sans-serif;font-size:clamp(2.5rem,6vw,4.8rem);font-weight:900;text-transform:uppercase;line-height:1;margin-bottom:18px;animation:fadeUp .9s .1s cubic-bezier(.22,1,.36,1) both}
#py-hero h1 .ol{color:transparent;-webkit-text-stroke:2px #fff}
#py-hero ._bc{display:flex;align-items:center;gap:8px;font-size:14px;color:var(--muted);animation:fadeUp .9s .3s cubic-bezier(.22,1,.36,1) both}
#py-hero ._bc a{color:var(--muted);text-decoration:none;transition:color .2s}
#py-hero ._bc a:hover{color:var(--accent)}
#py-hero ._bc span{color:#fff;font-weight:600}

#py-pay{background:var(--dark);padding:80px var(--pad)}
#py-pay ._inner{max-width:700px;margin:0 auto;text-align:center}
#py-pay ._inner h2{font-family:'Barlow Condensed',sans-serif;font-size:clamp(2rem,4vw,3rem);font-weight:900;text-transform:uppercase;line-height:1.05;margin-bottom:14px}
#py-pay ._inner h2 .ol{color:transparent;-webkit-text-stroke:2px var(--accent)}
#py-pay ._inner p.sub{color:var(--muted);font-size:15px;margin-bottom:48px}
#py-pay ._card-floater{display:block;width:100%}
#py-pay ._card-float-inner{background:var(--card);border:1px solid var(--border);border-radius:4px;padding:48px 40px;display:inline-flex;flex-direction:column;align-items:center;gap:28px;width:100%;transition:box-shadow .3s}
#py-pay ._card-float-inner:hover{box-shadow:0 32px 64px rgba(0,0,0,.5),0 0 0 1px rgba(200,230,60,.15)}
#py-pay ._logo-wrap{display:flex;align-items:center;gap:14px;margin-bottom:4px;animation:logoFade .8s .6s cubic-bezier(.22,1,.36,1) both}
#py-pay ._logo-wrap img{height:48px;width:auto}
#py-pay ._logo-wrap span{font-family:'Barlow Condensed',sans-serif;font-size:1.6rem;font-weight:800;color:#fff;letter-spacing:.03em}
#py-pay ._qr-wrap{background:#fff;border-radius:4px;padding:16px;display:inline-flex;position:relative;overflow:hidden;animation:qrReveal .7s .8s cubic-bezier(.22,1,.36,1) both}
#py-pay ._qr-wrap::after{content:'';position:absolute;left:0;right:0;height:3px;background:linear-gradient(to right,transparent,rgba(200,230,60,.8),transparent);animation:scanLine 2.5s 1.5s linear infinite}
#py-pay ._qr-wrap img{width:220px;height:220px;display:block}
#py-pay ._upi-label{font-size:12px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--muted);margin-bottom:6px}
#py-pay ._upi-id{font-family:'Barlow Condensed',sans-serif;font-size:1.3rem;font-weight:700;color:var(--accent);letter-spacing:.04em;background:#1a1a1a;border:1px solid var(--border);padding:12px 28px;border-radius:2px;word-break:break-all;animation:upiGlow 3s 2s ease-in-out infinite}
#py-pay ._hint{font-size:13px;color:#666;line-height:1.6;max-width:340px;text-align:center}
#py-pay ._paybtn{display:inline-flex;align-items:center;gap:10px;background:var(--accent);color:#111;text-decoration:none;font-family:'Barlow',sans-serif;font-size:13px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;padding:14px 36px;border-radius:2px;transition:background .2s,transform .2s,box-shadow .2s;margin-top:4px}
#py-pay ._paybtn:hover{background:#d4ef50;transform:translateY(-3px);box-shadow:0 10px 28px rgba(200,230,60,.35)}
#py-pay ._paybtn:active{transform:translateY(0)}

@media(max-width:600px){
:root{--pad:18px}
#py-pay ._card{padding:32px 20px}
#py-pay ._qr-wrap img{width:180px;height:180px}
}
</style>
</head>
<body>

<?php include 'api/nav.php'; ?>

<main>

<section id="py-hero" aria-label="Pay Hero">
<div class="_bg">
<?php if($banner!=""){ ?>
<img src="./files/<?php echo $banner; ?>" alt="Pay - <?php echo htmlspecialchars($title); ?>" loading="eager">
<?php } ?>
</div>
<div class="_atl"></div>
<div class="_atr"></div>
<div class="_hc">
<h1>Secure <span class="ol">Payment</span><br>Made <span class="ol">Easy</span></h1>
<nav class="_bc" aria-label="Breadcrumb">
<a href="index.php">Home</a>
<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
<span>Pay</span>
</nav>
</div>
</section>

<section id="py-pay" aria-label="UPI Payment">
<div class="_inner">
<h2 class="anim-ready">Pay Via <span class="ol">UPI</span></h2>
<p class="sub anim-ready">Scan the QR code below or use the UPI ID to make a secure instant payment.</p>
<div class="_card-floater anim-ready">
<div class="_card-float-inner">
<?php if($logo!=""||$title!=""){ ?>
<div class="_logo-wrap">
<?php if($logo!=""){ ?><img src="./files/<?php echo $logo; ?>" alt="<?php echo htmlspecialchars($title); ?>"><?php } ?>
<?php if($title!=""){ ?><span><?php echo htmlspecialchars($title); ?></span><?php } ?>
</div>
<?php } ?>
<div class="_qr-wrap">
<img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=<?php echo urlencode($qr); ?>" alt="UPI QR Code for <?php echo htmlspecialchars($title); ?>">
</div>
<div>
<p class="_upi-label">UPI ID</p>
<p class="_upi-id"><?php echo htmlspecialchars($upiid); ?></p>
</div>
<p class="_hint">Open any UPI app (GPay, PhonePe, Paytm) and scan this QR code or enter the UPI ID above to complete your payment.</p>
<a href="<?php echo $qr; ?>" class="_paybtn">
<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
Pay Now
</a>
</div>
</div>
</div>
</section>

<?php include 'api/footer.php'; ?>

</main>

<?php include 'api/top.php'; ?>

<script>
(function(){
var io=new IntersectionObserver(function(entries){
entries.forEach(function(e,i){
if(e.isIntersecting){
var el=e.target;
var delay=parseInt(el.dataset.delay||0);
setTimeout(function(){el.classList.add('anim-up');},delay);
io.unobserve(el);
}
});
},{threshold:.12});
document.querySelectorAll('.anim-ready').forEach(function(el,i){
el.dataset.delay=i*120;
io.observe(el);
});
})();
</script>

</body>
</html>