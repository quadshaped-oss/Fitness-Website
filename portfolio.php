<?php
require 'db.php';
$banner="";$favicon="";$title="";$phone="";
$q=$conn->query("SELECT portfolio_banner,favicon,title FROM info LIMIT 1");
if($q->num_rows){$r=$q->fetch_assoc();$banner=$r['portfolio_banner'];$favicon=$r['favicon'];$title=$r['title'];}
$q2=$conn->query("SELECT phone FROM contact LIMIT 1");
if($q2->num_rows){$r2=$q2->fetch_assoc();$phone=$r2['phone'];}
$wa="https://wa.me/91".$phone;
$portfolio=$conn->query("SELECT * FROM portfolio ORDER BY id DESC");
$videos=$conn->query("SELECT * FROM videos ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="description" content="Portfolio - <?php echo htmlspecialchars($title); ?>. Explore our fitness classes, training programs, and transformation stories from our community.">
<meta name="keywords" content="portfolio <?php echo htmlspecialchars($title); ?>, fitness classes, gym programs, workout videos, training">
<meta name="robots" content="index,follow">
<meta property="og:title" content="Portfolio - <?php echo htmlspecialchars($title); ?>">
<meta property="og:description" content="Explore our fitness classes, training programs and transformation stories.">
<meta property="og:type" content="website">
<meta name="twitter:card" content="summary_large_image">
<title>Portfolio - <?php echo htmlspecialchars($title); ?></title>
<?php if($favicon!=""){ ?><link rel="icon" type="image/x-icon" href="files/<?php echo $favicon; ?>"><?php } ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;800;900&family=Barlow:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{--dark:#1e1e1e;--darker:#111;--card:#252525;--accent:#c8e63c;--text:#fff;--muted:#999;--border:#2e2e2e;--max:1400px;--pad:40px}
html,body{overflow-x:hidden;max-width:100%}
html{scroll-behavior:smooth}
body{background:var(--darker);color:var(--text);font-family:'Barlow',sans-serif}

@keyframes fadeUp{from{opacity:0;transform:translateY(40px)}to{opacity:1;transform:translateY(0)}}
@keyframes slideRight{from{opacity:0;transform:translateX(-60px)}to{opacity:1;transform:translateX(0)}}
@keyframes slideLeft{from{opacity:0;transform:translateX(60px)}to{opacity:1;transform:translateX(0)}}
@keyframes heroBgKen{from{transform:scale(1)}to{transform:scale(1.06)}}
@keyframes accentPulse{0%,100%{opacity:.22}50%{opacity:.48}}
@keyframes numCount{from{opacity:0;transform:scale(.7)}to{opacity:1;transform:scale(1)}}
@keyframes videoReveal{from{opacity:0;transform:translateY(30px) scale(.97)}to{opacity:1;transform:translateY(0) scale(1)}}

.anim-ready{opacity:0}
.anim-up{animation:fadeUp .7s cubic-bezier(.22,1,.36,1) forwards}
.anim-right{animation:slideRight .75s cubic-bezier(.22,1,.36,1) forwards}
.anim-left{animation:slideLeft .75s cubic-bezier(.22,1,.36,1) forwards}

#pt-hero{position:relative;min-height:420px;display:flex;align-items:flex-end;overflow:hidden}
#pt-hero ._bg{position:absolute;inset:0;z-index:0}
#pt-hero ._bg img{width:100%;height:100%;object-fit:cover;filter:grayscale(100%);display:block;animation:heroBgKen 14s ease-in-out infinite alternate}
#pt-hero ._bg::after{content:'';position:absolute;inset:0;background:linear-gradient(to right,rgba(10,10,10,.82) 50%,rgba(10,10,10,.3) 100%)}
#pt-hero ._atl{position:absolute;bottom:0;left:0;width:160px;height:160px;z-index:1;pointer-events:none;animation:accentPulse 4s ease-in-out infinite}
#pt-hero ._atl::before{content:'';position:absolute;bottom:0;left:0;width:0;height:0;border-style:solid;border-width:0 0 160px 160px;border-color:transparent transparent rgba(200,230,60,.22) transparent}
#pt-hero ._atr{position:absolute;top:0;right:0;width:200px;height:200px;z-index:1;pointer-events:none;animation:accentPulse 4s 1s ease-in-out infinite}
#pt-hero ._atr::before{content:'';position:absolute;top:0;right:0;width:0;height:0;border-style:solid;border-width:0 200px 200px 0;border-color:transparent rgba(200,230,60,.16) transparent transparent}
#pt-hero ._atr::after{content:'';position:absolute;top:0;right:0;width:0;height:0;border-style:solid;border-width:0 130px 130px 0;border-color:transparent rgba(200,230,60,.1) transparent transparent}
#pt-hero ._hc{position:relative;z-index:2;max-width:var(--max);width:100%;margin:0 auto;padding:120px var(--pad) 48px}
#pt-hero h1{font-family:'Barlow Condensed',sans-serif;font-size:clamp(2.5rem,6vw,4.8rem);font-weight:900;text-transform:uppercase;line-height:1;margin-bottom:18px;animation:fadeUp .9s .1s cubic-bezier(.22,1,.36,1) both}
#pt-hero h1 .ol{color:transparent;-webkit-text-stroke:2px #fff}
#pt-hero ._bc{display:flex;align-items:center;gap:8px;font-size:14px;color:var(--muted);animation:fadeUp .9s .3s cubic-bezier(.22,1,.36,1) both}
#pt-hero ._bc a{color:var(--muted);text-decoration:none;transition:color .2s}
#pt-hero ._bc a:hover{color:var(--accent)}
#pt-hero ._bc span{color:#fff;font-weight:600}

#pt-port{padding:80px 0}
#pt-port ._ph{max-width:var(--max);margin:0 auto;padding:0 var(--pad);margin-bottom:60px}
#pt-port ._ph h2{font-family:'Barlow Condensed',sans-serif;font-size:clamp(2rem,4vw,3rem);font-weight:900;text-transform:uppercase;line-height:1.05}
#pt-port ._ph h2 .ol{color:transparent;-webkit-text-stroke:2px var(--accent)}

._prow{display:grid;grid-template-columns:1fr 1fr;min-height:420px;border-top:1px solid var(--border);margin:0 var(--pad)}
._prow:last-child{border-bottom:1px solid var(--border)}
._prow ._piw{position:relative;overflow:hidden}
._prow ._piw img{width:100%;height:100%;object-fit:cover;filter:grayscale(100%);display:block;transition:transform .6s,filter .4s}
._prow:hover ._piw img{transform:scale(1.06);filter:grayscale(50%)}
._prow ._piw ._acc{position:absolute;bottom:0;right:0;width:0;height:0;border-style:solid;border-width:0 0 70px 70px;border-color:transparent transparent rgba(200,230,60,.55) transparent}
._prow.reverse ._piw ._acc{right:auto;left:0;border-width:0 70px 70px 0;border-color:transparent rgba(200,230,60,.55) transparent transparent}
._prow ._ptxt{background:var(--card);display:flex;flex-direction:column;justify-content:center;padding:60px 56px;gap:0}
._prow ._ptxt ._num{font-family:'Barlow Condensed',sans-serif;font-size:4rem;font-weight:900;color:rgba(200,230,60,.1);line-height:1;margin-bottom:8px;letter-spacing:-.02em;transition:color .3s}
._prow:hover ._ptxt ._num{color:rgba(200,230,60,.2)}
._prow ._ptxt h3{font-family:'Barlow Condensed',sans-serif;font-size:clamp(1.6rem,3vw,2.2rem);font-weight:800;text-transform:uppercase;letter-spacing:.03em;color:#fff;margin-bottom:16px;line-height:1.1}
._prow ._ptxt p{font-size:15px;color:var(--muted);line-height:1.8;margin-bottom:32px}
._prow ._ptxt a._wa{display:inline-flex;align-items:center;gap:10px;background:var(--accent);color:#111;text-decoration:none;font-family:'Barlow',sans-serif;font-size:13px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;padding:13px 30px;border-radius:2px;transition:background .2s,transform .2s,box-shadow .2s;align-self:flex-start}
._prow ._ptxt a._wa:hover{background:#d4ef50;transform:translateY(-3px);box-shadow:0 10px 24px rgba(200,230,60,.3)}
._prow.reverse ._piw{order:2}
._prow.reverse ._ptxt{order:1;background:var(--darker)}

#pt-videos{background:var(--darker);padding:80px var(--pad);border-top:1px solid var(--border)}
#pt-videos ._vh{max-width:var(--max);margin:0 auto;margin-bottom:50px}
#pt-videos ._vh h2{font-family:'Barlow Condensed',sans-serif;font-size:clamp(2rem,4vw,3rem);font-weight:900;text-transform:uppercase;line-height:1.05}
#pt-videos ._vh h2 .ol{color:transparent;-webkit-text-stroke:2px var(--accent)}
#pt-videos ._vgrid{max-width:var(--max);margin:0 auto;display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
#pt-videos ._vcard{background:var(--card);border:1px solid var(--border);border-radius:2px;overflow:hidden;aspect-ratio:16/9;transition:transform .3s,box-shadow .3s}
#pt-videos ._vcard:hover{transform:translateY(-6px) scale(1.02);box-shadow:0 20px 40px rgba(0,0,0,.4)}
#pt-videos ._vcard iframe{width:100%;height:100%;border:0;display:block}

@media(max-width:900px){
._prow{grid-template-columns:1fr;margin:0 var(--pad)}
._prow ._piw{aspect-ratio:16/9;min-height:240px}
._prow ._ptxt{padding:36px var(--pad)}
._prow.reverse ._piw{order:0}
._prow.reverse ._ptxt{order:1}
#pt-videos ._vgrid{grid-template-columns:repeat(2,1fr)}
}
@media(max-width:600px){
:root{--pad:18px}
._prow{margin:0}
._prow ._ptxt{padding:32px 18px}
#pt-videos ._vgrid{grid-template-columns:1fr}
}
</style>
</head>
<body>

<?php include 'api/nav.php'; ?>

<main>

<section id="pt-hero" aria-label="Portfolio Hero">
<div class="_bg">
<?php if($banner!=""){ ?>
<img src="./files/<?php echo $banner; ?>" alt="Portfolio - <?php echo htmlspecialchars($title); ?>" loading="eager">
<?php } ?>
</div>
<div class="_atl"></div>
<div class="_atr"></div>
<div class="_hc">
<h1><span class="ol">Our</span> Portfolio<br><span class="ol">&amp;</span> Classes</h1>
<nav class="_bc" aria-label="Breadcrumb">
<a href="index.php">Home</a>
<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
<span>Portfolio</span>
</nav>
</div>
</section>

<?php if($portfolio->num_rows){ ?>
<section id="pt-port" aria-label="Portfolio">
<div class="_ph">
<h2 class="anim-ready"><span class="ol">Explore</span> Our Classes</h2>
</div>
<?php $i=0; while($p=$portfolio->fetch_assoc()){ $i++; $rev=($i%2==0)?'reverse':''; $animDir=($i%2==0)?'left':'right'; ?>
<article class="_prow <?php echo $rev; ?> anim-ready" data-anim="<?php echo $animDir; ?>">
<div class="_piw">
<img src="./files/<?php echo $p['image']; ?>" alt="<?php echo htmlspecialchars($p['title']); ?>" loading="lazy">
<div class="_acc"></div>
</div>
<div class="_ptxt">
<div class="_num"><?php echo str_pad($i,2,'0',STR_PAD_LEFT); ?></div>
<h3><?php echo htmlspecialchars($p['title']); ?></h3>
<p><?php echo htmlspecialchars($p['description']); ?></p>
<a href="<?php echo $wa; ?>" class="_wa">
<svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2 22l4.978-1.421A9.953 9.953 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M8.5 9.5c.2.6.7 1.8 1.6 2.7.9.9 2.1 1.5 2.7 1.7.4.1.7 0 .9-.2l.6-.7c.2-.2.5-.3.7-.2l2 .9c.3.1.4.4.3.7-.3.9-1.1 2.1-2.3 2.1-1.7 0-4.7-1.3-6.5-5.1-.4-.8-.3-1.8.2-2.4.3-.4.8-.5 1.1-.3l.3.1c.2.1.4.3.4.5v.2z" fill="currentColor"/></svg>
Contact Us
</a>
</div>
</article>
<?php } ?>
</section>
<?php } ?>

<?php if($videos->num_rows){ ?>
<section id="pt-videos" aria-label="Videos">
<div class="_vh">
<h2 class="anim-ready"><span class="ol">Watch</span> Our Videos</h2>
</div>
<div class="_vgrid">
<?php while($v=$videos->fetch_assoc()){ ?>
<div class="_vcard anim-ready">
<iframe src="https://www.youtube-nocookie.com/embed/<?php echo $v['video_id']; ?>" title="<?php echo htmlspecialchars($title); ?> Video" allow="accelerometer;autoplay;clipboard-write;encrypted-media;gyroscope;picture-in-picture" allowfullscreen loading="lazy"></iframe>
</div>
<?php } ?>
</div>
</section>
<?php } ?>

<?php include 'api/footer.php'; ?>

</main>

<?php include 'api/top.php'; ?>

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
if(!el.dataset.delay) el.dataset.delay=i%3*100;
io.observe(el);
});
})();
</script>

</body>
</html>