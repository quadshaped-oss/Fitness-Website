<?php
require 'db.php';
$banner="";
$favicon="";
$site_title="";
$q=$conn->query("SELECT about_banner,favicon,title FROM info LIMIT 1");
if($q->num_rows){$r=$q->fetch_assoc();$banner=$r['about_banner'];$favicon=$r['favicon'];$site_title=$r['title'];}
$about_img="";$about_title="";$about_desc="";
$q2=$conn->query("SELECT * FROM about LIMIT 1");
if($q2->num_rows){$r2=$q2->fetch_assoc();$about_img=$r2['image'];$about_title=$r2['title'];$about_desc=$r2['description'];}
$experts=$conn->query("SELECT * FROM expert ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="description" content="About <?php echo htmlspecialchars($site_title); ?> - Meet our expert trainers and learn about our mission to empower your fitness journey through community, inclusivity, and personalized training.">
<meta name="keywords" content="about <?php echo htmlspecialchars($site_title); ?>, gym trainers, fitness experts, fitness community, personalized training">
<meta name="robots" content="index,follow">
<meta property="og:title" content="About <?php echo htmlspecialchars($site_title); ?>">
<meta property="og:description" content="Learn about our mission, core values, and expert team dedicated to your fitness journey.">
<meta property="og:type" content="website">
<meta name="twitter:card" content="summary_large_image">
<title>About Us - <?php echo htmlspecialchars($site_title); ?></title>
<?php if($favicon!=""){ ?><link rel="icon" type="image/x-icon" href="files/<?php echo $favicon; ?>"><?php } ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;800;900&family=Barlow:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{--dark:#1e1e1e;--darker:#111;--card:#252525;--card2:#2a2a2a;--accent:#c8e63c;--text:#fff;--muted:#999;--border:#2e2e2e;--max:1400px;--pad:40px}
html{scroll-behavior:smooth}
body{background:var(--darker);color:var(--text);font-family:'Barlow',sans-serif;overflow-x:hidden}

@keyframes fadeUp{from{opacity:0;transform:translateY(40px)}to{opacity:1;transform:translateY(0)}}
@keyframes fadeIn{from{opacity:0}to{opacity:1}}
@keyframes slideRight{from{opacity:0;transform:translateX(-50px)}to{opacity:1;transform:translateX(0)}}
@keyframes slideLeft{from{opacity:0;transform:translateX(50px)}to{opacity:1;transform:translateX(0)}}
@keyframes scaleIn{from{opacity:0;transform:scale(.9)}to{opacity:1;transform:scale(1)}}
@keyframes heroBgKen{from{transform:scale(1)}to{transform:scale(1.06)}}
@keyframes accentPulse{0%,100%{opacity:.22}50%{opacity:.48}}
@keyframes valIconDrop{from{opacity:0;transform:translateY(-20px)}to{opacity:1;transform:translateY(0)}}

.anim-ready{opacity:0}
.anim-up{animation:fadeUp .7s cubic-bezier(.22,1,.36,1) forwards}
.anim-right{animation:slideRight .75s cubic-bezier(.22,1,.36,1) forwards}
.anim-left{animation:slideLeft .75s cubic-bezier(.22,1,.36,1) forwards}
.anim-scale{animation:scaleIn .65s cubic-bezier(.22,1,.36,1) forwards}

#ab-hero{position:relative;min-height:420px;display:flex;align-items:flex-end;overflow:hidden}
#ab-hero .ab-hero-bg{position:absolute;inset:0;z-index:0}
#ab-hero .ab-hero-bg img{width:100%;height:100%;object-fit:cover;filter:grayscale(100%);display:block;animation:heroBgKen 14s ease-in-out infinite alternate}
#ab-hero .ab-hero-bg::after{content:'';position:absolute;inset:0;background:linear-gradient(to right,rgba(10,10,10,.82) 50%,rgba(10,10,10,.3) 100%)}
#ab-hero .ab-accent-tl{position:absolute;bottom:0;left:0;width:160px;height:160px;z-index:1;pointer-events:none;animation:accentPulse 4s ease-in-out infinite}
#ab-hero .ab-accent-tl::before{content:'';position:absolute;bottom:0;left:0;width:0;height:0;border-style:solid;border-width:0 0 160px 160px;border-color:transparent transparent rgba(200,230,60,.22) transparent}
#ab-hero .ab-accent-tr{position:absolute;top:0;right:0;width:200px;height:200px;z-index:1;pointer-events:none;animation:accentPulse 4s 1s ease-in-out infinite}
#ab-hero .ab-accent-tr::before{content:'';position:absolute;top:0;right:0;width:0;height:0;border-style:solid;border-width:0 200px 200px 0;border-color:transparent rgba(200,230,60,.16) transparent transparent}
#ab-hero .ab-accent-tr::after{content:'';position:absolute;top:0;right:0;width:0;height:0;border-style:solid;border-width:0 130px 130px 0;border-color:transparent rgba(200,230,60,.1) transparent transparent}
#ab-hero .ab-hero-content{position:relative;z-index:2;max-width:var(--max);width:100%;margin:0 auto;padding:120px var(--pad) 48px}
#ab-hero h1{font-family:'Barlow Condensed',sans-serif;font-size:clamp(2.5rem,6vw,4.5rem);font-weight:900;text-transform:uppercase;line-height:1;margin-bottom:18px;animation:fadeUp .9s .1s cubic-bezier(.22,1,.36,1) both}
#ab-hero h1 .outline{color:transparent;-webkit-text-stroke:2px #fff}
#ab-hero .ab-breadcrumb{display:flex;align-items:center;gap:8px;font-size:14px;color:var(--muted);animation:fadeUp .9s .3s cubic-bezier(.22,1,.36,1) both}
#ab-hero .ab-breadcrumb a{color:var(--muted);text-decoration:none;transition:color .2s}
#ab-hero .ab-breadcrumb a:hover{color:var(--accent)}
#ab-hero .ab-breadcrumb span{color:#fff;font-weight:600}
#ab-hero .ab-breadcrumb svg{color:var(--muted)}

#ab-about{background:var(--dark);padding:80px var(--pad)}
#ab-about .about-inner{max-width:var(--max);margin:0 auto;display:grid;grid-template-columns:480px 1fr;gap:80px;align-items:center}
#ab-about .about-imgs{display:grid;grid-template-columns:1fr 1fr;gap:16px;position:relative}
#ab-about .about-imgs .img-wrap{overflow:hidden;border-radius:2px}
#ab-about .about-imgs .img-wrap img{width:100%;height:100%;object-fit:cover;filter:grayscale(100%);display:block;transition:transform .5s,filter .4s}
#ab-about .about-imgs .img-wrap:hover img{transform:scale(1.06);filter:grayscale(50%)}
#ab-about .about-imgs .img-wrap:first-child{aspect-ratio:3/4}
#ab-about .about-imgs .img-wrap:last-child{aspect-ratio:3/4;position:relative}
#ab-about .about-imgs .img-wrap:last-child::after{content:'';position:absolute;bottom:0;left:0;width:100%;height:50%;background:linear-gradient(to bottom,transparent,rgba(200,230,60,.3));pointer-events:none}
#ab-about .about-imgs .img-accent{position:absolute;bottom:-10px;left:50%;transform:translateX(-50%);width:0;height:0;border-style:solid;border-width:0 0 80px 80px;border-color:transparent transparent rgba(200,230,60,.5) transparent;z-index:2}
#ab-about .about-text h2{font-family:'Barlow Condensed',sans-serif;font-size:clamp(2rem,4vw,3rem);font-weight:900;text-transform:uppercase;line-height:1.05;margin-bottom:28px}
#ab-about .about-text h2 .outline{color:transparent;-webkit-text-stroke:2px #fff}
#ab-about .about-text p{font-size:15px;color:#bbb;line-height:1.85}

#ab-values{background:var(--darker);padding:80px var(--pad)}
#ab-values .vals-header{text-align:center;margin-bottom:60px}
#ab-values .vals-header h2{font-family:'Barlow Condensed',sans-serif;font-size:clamp(2rem,4.5vw,3.2rem);font-weight:800;line-height:1.05}
#ab-values .vals-header h2 .outline{color:transparent;-webkit-text-stroke:2px #fff}
#ab-values .vals-header p{color:var(--muted);margin-top:10px;font-size:15px}
#ab-values .vals-grid{max-width:var(--max);margin:0 auto;display:grid;grid-template-columns:repeat(4,1fr);gap:20px}
#ab-values .val-card{background:var(--card);border:1px solid var(--border);border-radius:2px;padding:28px 24px 32px;position:relative;transition:transform .3s,border-color .3s,box-shadow .3s}
#ab-values .val-card:hover{transform:translateY(-8px);border-color:rgba(200,230,60,.35);box-shadow:0 20px 40px rgba(0,0,0,.35)}
#ab-values .val-card .val-icon{width:54px;height:54px;background:var(--accent);border-radius:2px;display:flex;align-items:center;justify-content:center;position:absolute;top:-28px;right:20px;transition:transform .3s,box-shadow .3s}
#ab-values .val-card:hover .val-icon{transform:translateY(-4px) rotate(5deg);box-shadow:0 8px 20px rgba(200,230,60,.3)}
#ab-values .val-card .val-icon svg{color:#111}
#ab-values .val-card h3{font-size:18px;font-weight:700;color:#fff;margin-top:16px;margin-bottom:12px}
#ab-values .val-card p{font-size:14px;color:var(--muted);line-height:1.65}

#ab-experts{background:var(--dark);padding:80px var(--pad)}
#ab-experts .exp-header{max-width:var(--max);margin:0 auto;display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:50px;flex-wrap:wrap;gap:20px}
#ab-experts .exp-header-left h2{font-family:'Barlow Condensed',sans-serif;font-size:clamp(2rem,4vw,3rem);font-weight:900;text-transform:uppercase;line-height:1.05;margin-bottom:10px}
#ab-experts .exp-header-left h2 .outline{color:transparent;-webkit-text-stroke:2px #fff}
#ab-experts .exp-header-left p{font-size:14px;color:var(--muted);max-width:560px;line-height:1.6}
#ab-experts .exp-header a{background:var(--accent);color:#111;text-decoration:none;font-family:'Barlow',sans-serif;font-size:12px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;padding:13px 28px;border-radius:2px;white-space:nowrap;transition:background .2s,transform .2s;align-self:flex-start}
#ab-experts .exp-header a:hover{background:#d4ef50;transform:translateY(-2px)}
#ab-experts .exp-grid{max-width:var(--max);margin:0 auto;display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
#ab-experts .exp-card{background:var(--card);border:1px solid var(--border);border-radius:2px;overflow:hidden;transition:transform .3s,box-shadow .3s}
#ab-experts .exp-card:hover{transform:translateY(-8px);box-shadow:0 24px 48px rgba(0,0,0,.4)}
#ab-experts .exp-card .exp-img-wrap{position:relative;aspect-ratio:3/3.2;overflow:hidden}
#ab-experts .exp-card .exp-img-wrap img{width:100%;height:100%;object-fit:cover;filter:grayscale(100%);display:block;transition:transform .5s,filter .4s}
#ab-experts .exp-card:hover .exp-img-wrap img{transform:scale(1.06);filter:grayscale(50%)}
#ab-experts .exp-card .exp-view{position:absolute;bottom:20px;left:20px;transform:translateY(10px);opacity:0;transition:transform .3s,opacity .3s}
#ab-experts .exp-card:hover .exp-view{transform:translateY(0);opacity:1}
#ab-experts .exp-card .exp-view a{display:inline-block;background:var(--accent);color:#111;text-decoration:none;font-family:'Barlow',sans-serif;font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;padding:10px 22px;border-radius:2px;transition:background .2s}
#ab-experts .exp-card .exp-view a:hover{background:#d4ef50}
#ab-experts .exp-card .exp-info{padding:20px 22px 24px}
#ab-experts .exp-card .exp-info h3{font-size:18px;font-weight:700;color:#fff;margin-bottom:6px}
#ab-experts .exp-card .exp-info p{font-size:13px;color:var(--muted)}

@media(max-width:1100px){
#ab-about .about-inner{grid-template-columns:1fr 1fr;gap:40px}
#ab-values .vals-grid{grid-template-columns:repeat(2,1fr);gap:36px 20px}
#ab-experts .exp-grid{grid-template-columns:repeat(2,1fr)}
}
@media(max-width:768px){
:root{--pad:24px}
#ab-about .about-inner{grid-template-columns:1fr}
#ab-about .about-imgs{max-width:480px}
#ab-experts .exp-header{flex-direction:column}
}
@media(max-width:600px){
:root{--pad:18px}
#ab-values .vals-grid{grid-template-columns:1fr}
#ab-experts .exp-grid{grid-template-columns:1fr}
#ab-hero h1{font-size:2.4rem}
}
</style>
</head>
<body>

<?php include 'api/nav.php'; ?>

<main>

<section id="ab-hero" aria-label="About Hero">
<div class="ab-hero-bg">
<?php if($banner!=""){ ?>
<img src="./files/<?php echo $banner; ?>" alt="About <?php echo htmlspecialchars($site_title); ?>" loading="eager">
<?php } ?>
</div>
<div class="ab-accent-tl"></div>
<div class="ab-accent-tr"></div>
<div class="ab-hero-content">
<h1><span class="outline">About</span> <?php echo htmlspecialchars($site_title); ?></h1>
<nav class="ab-breadcrumb" aria-label="Breadcrumb">
<a href="index.php">Home</a>
<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
<span>About Us</span>
</nav>
</div>
</section>

<?php if($about_title!=""||$about_desc!=""){ ?>
<section id="ab-about" aria-label="About <?php echo htmlspecialchars($site_title); ?>">
<div class="about-inner">
<div class="about-imgs anim-ready" data-anim="right">
<?php if($about_img!=""){ ?>
<div class="img-wrap">
<img src="./files/<?php echo $about_img; ?>" alt="<?php echo htmlspecialchars($about_title); ?>" loading="lazy">
</div>
<div class="img-wrap">
<img src="./files/<?php echo $about_img; ?>" alt="<?php echo htmlspecialchars($about_title); ?>" loading="lazy">
</div>
<?php } ?>
<div class="img-accent"></div>
</div>
<div class="about-text anim-ready" data-anim="left">
<h2><?php
$words=explode(' ',trim($about_title));
$first=implode(' ',array_slice($words,0,1));
$rest=implode(' ',array_slice($words,1));
echo '<span class="outline">'.htmlspecialchars($first).'</span> '.htmlspecialchars($rest);
?></h2>
<p><?php echo nl2br(htmlspecialchars($about_desc)); ?></p>
</div>
</div>
</section>
<?php } ?>

<section id="ab-values" aria-label="Core Values">
<div class="vals-header">
<h2 class="anim-ready"><span class="outline">Our</span> Core Values</h2>
<p class="anim-ready">guide everything we do</p>
</div>
<div class="vals-grid">
<div class="val-card anim-ready">
<div class="val-icon">
<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6.5 6.5h11M6.5 17.5h11M4 12h16M2 8.5C2 7 3 6 4.5 6S7 7 7 8.5 6 11 4.5 11 2 10 2 8.5zM22 8.5C22 7 21 6 19.5 6S17 7 17 8.5 18 11 19.5 11 22 10 22 8.5zM2 15.5C2 14 3 13 4.5 13S7 14 7 15.5 6 18 4.5 18 2 17 2 15.5zM22 15.5C22 14 21 13 19.5 13S17 14 17 15.5 18 18 19.5 18 22 17 22 15.5z"/></svg>
</div>
<h3>Community</h3>
<p>Fostering a sense of belonging and support.</p>
</div>
<div class="val-card anim-ready">
<div class="val-icon">
<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/><path d="M8 14s1.5 2 4 2 4-2 4-2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/></svg>
</div>
<h3>Inclusivity</h3>
<p>Embracing diversity in fitness for all body types and abilities.</p>
</div>
<div class="val-card anim-ready">
<div class="val-icon">
<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
</div>
<h3>Innovation</h3>
<p>Offering cutting-edge workouts and technology.</p>
</div>
<div class="val-card anim-ready">
<div class="val-icon">
<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
</div>
<h3>Personalization</h3>
<p>Tailoring fitness plans to individual needs.</p>
</div>
</div>
</section>

<section id="ab-experts" aria-label="Meet the Experts">
<div class="exp-header">
<div class="exp-header-left anim-ready">
<h2><span class="outline">Meet</span> The Expert</h2>
<p>Each member of our team brings unique expertise to ensure a well-rounded and holistic fitness experience.</p>
</div>
<a href="portfolio.php" class="anim-ready">See More</a>
</div>
<div class="exp-grid">
<?php while($e=$experts->fetch_assoc()){ ?>
<article class="exp-card anim-ready">
<div class="exp-img-wrap">
<img src="./files/<?php echo $e['image']; ?>" alt="<?php echo htmlspecialchars($e['name']); ?>" loading="lazy">
<div class="exp-view">
<a href="about.php">View More</a>
</div>
</div>
<div class="exp-info">
<h3><?php echo htmlspecialchars($e['name']); ?></h3>
<p><?php echo htmlspecialchars($e['description']); ?></p>
</div>
</article>
<?php } ?>
</div>
</section>

<?php include 'api/ready.php'; ?>

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
else if(anim==='scale') el.classList.add('anim-scale');
else el.classList.add('anim-up');
},delay);
io.unobserve(el);
}
});
},{threshold:.12});
document.querySelectorAll('.anim-ready').forEach(function(el,i){
el.dataset.delay=Math.min(i%4,3)*90;
io.observe(el);
});
})();
</script>

</body>
</html>