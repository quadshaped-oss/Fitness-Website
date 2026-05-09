<?php
require 'db.php';
$banner="";
$favicon="";
$site_title="";
$q=$conn->query("SELECT home_banner,favicon,title FROM info LIMIT 1");
if($q->num_rows){$r=$q->fetch_assoc();$banner=$r['home_banner'];$favicon=$r['favicon'];$site_title=$r['title'];}
$details=$conn->query("SELECT * FROM details LIMIT 1");
$portfolio=$conn->query("SELECT * FROM portfolio ORDER BY id DESC");
$reviews=$conn->query("SELECT * FROM reviews ORDER BY id DESC");
$plans=$conn->query("SELECT * FROM plans ORDER BY id DESC");
$why=$conn->query("SELECT * FROM why ORDER BY id DESC");
function trimWords($str,$n=24){$w=explode(' ',trim(strip_tags($str)));return count($w)<=$n?$str:implode(' ',array_slice($w,0,$n)).'...';}
function extractNum($val){preg_match('/[\d,]+/',$val,$m);return isset($m[0])?intval(str_replace(',','',$m[0])):0;}
function extractSuffix($val){preg_match('/[^\d,\s]+$/',$val,$m);return isset($m[0])?trim($m[0]):'';}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="description" content="<?php echo htmlspecialchars($site_title); ?> - Achieve more than just fitness. Combine strength, flexibility, and endurance in a community that values well-rounded health and supportive growth.">
<meta name="keywords" content="gym, fitness, classes, personal training, workout, strength, cardio, yoga, nutrition">
<meta name="robots" content="index,follow">
<meta property="og:title" content="<?php echo htmlspecialchars($site_title); ?> - Achieve More Than Just Fitness">
<meta property="og:description" content="Combine strength, flexibility, and endurance in a community that values well-rounded health.">
<meta property="og:type" content="website">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo htmlspecialchars($site_title); ?>">
<title><?php echo htmlspecialchars($site_title); ?> - Achieve More Than Just Fitness</title>
<?php if($favicon!=""){ ?><link rel="icon" type="image/x-icon" href="files/<?php echo $favicon; ?>"><?php } ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;800;900&family=Barlow:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{--dark:#1e1e1e;--darker:#111;--card:#252525;--card2:#2a2a2a;--accent:#c8e63c;--text:#fff;--muted:#999;--border:#333;--max:1400px;--pad:40px}
html{scroll-behavior:smooth}
body{background:var(--darker);color:var(--text);font-family:'Barlow',sans-serif;overflow-x:hidden}
.ff-section{padding:80px var(--pad);max-width:var(--max);margin:0 auto}
.ff-section-title{text-align:center;margin-bottom:60px}
.ff-section-title h2{font-family:'Barlow Condensed',sans-serif;font-size:clamp(2rem,4.5vw,3.2rem);font-weight:800;text-transform:uppercase;line-height:1.05}
.ff-section-title h2 span{color:transparent;-webkit-text-stroke:2px var(--accent)}
.ff-section-title p{color:var(--muted);margin-top:14px;font-size:15px;max-width:560px;margin-left:auto;margin-right:auto}

@keyframes fadeUp{from{opacity:0;transform:translateY(40px)}to{opacity:1;transform:translateY(0)}}
@keyframes fadeIn{from{opacity:0}to{opacity:1}}
@keyframes slideRight{from{opacity:0;transform:translateX(-40px)}to{opacity:1;transform:translateX(0)}}
@keyframes slideLeft{from{opacity:0;transform:translateX(40px)}to{opacity:1;transform:translateX(0)}}
@keyframes scaleIn{from{opacity:0;transform:scale(.92)}to{opacity:1;transform:scale(1)}}
@keyframes accentPulse{0%,100%{opacity:.22}50%{opacity:.44}}
@keyframes heroBgKen{from{transform:scale(1)}to{transform:scale(1.06)}}
@keyframes statPop{0%{transform:scale(1)}50%{transform:scale(1.2)}100%{transform:scale(1)}}

.anim-ready{opacity:0}
.anim-up{animation:fadeUp .7s cubic-bezier(.22,1,.36,1) forwards}
.anim-right{animation:slideRight .7s cubic-bezier(.22,1,.36,1) forwards}
.anim-left{animation:slideLeft .7s cubic-bezier(.22,1,.36,1) forwards}
.anim-scale{animation:scaleIn .6s cubic-bezier(.22,1,.36,1) forwards}
.anim-fade{animation:fadeIn .7s ease forwards}

#ff-hero{position:relative;min-height:100vh;display:flex;align-items:center;overflow:hidden}
#ff-hero .hero-bg{position:absolute;inset:0;z-index:0}
#ff-hero .hero-bg img{width:100%;height:100%;object-fit:cover;filter:grayscale(100%);display:block;animation:heroBgKen 12s ease-in-out infinite alternate}
#ff-hero .hero-bg::after{content:'';position:absolute;inset:0;background:linear-gradient(to right,rgba(10,10,10,.88) 40%,rgba(10,10,10,.35) 100%)}
#ff-hero .hero-accent{position:absolute;top:0;right:0;width:220px;height:220px;z-index:1;pointer-events:none;animation:accentPulse 4s ease-in-out infinite}
#ff-hero .hero-accent::before{content:'';position:absolute;top:0;right:0;width:0;height:0;border-style:solid;border-width:0 220px 220px 0;border-color:transparent rgba(200,230,60,.18) transparent transparent}
#ff-hero .hero-accent::after{content:'';position:absolute;top:0;right:0;width:0;height:0;border-style:solid;border-width:0 150px 150px 0;border-color:transparent rgba(200,230,60,.1) transparent transparent}
#ff-hero .hero-content{position:relative;z-index:2;padding:120px var(--pad) 80px;max-width:var(--max);margin:0 auto;width:100%}
#ff-hero h1{font-family:'Barlow Condensed',sans-serif;font-size:clamp(2.8rem,6vw,5rem);font-weight:900;line-height:1;text-transform:uppercase;margin-bottom:20px;max-width:680px;animation:fadeUp .9s .1s cubic-bezier(.22,1,.36,1) both}
#ff-hero h1 .outline{color:transparent;-webkit-text-stroke:2px #fff;font-weight:900}
#ff-hero h1 .solid{color:#fff}
#ff-hero .hero-sub{color:#ccc;font-size:15px;line-height:1.7;max-width:480px;margin-bottom:36px;animation:fadeUp .9s .3s cubic-bezier(.22,1,.36,1) both}
#ff-hero .hero-btns{display:flex;gap:16px;flex-wrap:wrap;animation:fadeUp .9s .5s cubic-bezier(.22,1,.36,1) both}
#ff-hero .btn-primary{background:var(--accent);color:#111;text-decoration:none;font-family:'Barlow',sans-serif;font-size:13px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;padding:14px 32px;border-radius:2px;transition:background .2s,transform .2s,box-shadow .2s;display:inline-block}
#ff-hero .btn-primary:hover{background:#d4ef50;transform:translateY(-3px);box-shadow:0 8px 24px rgba(200,230,60,.3)}
#ff-hero .btn-outline{background:transparent;color:#fff;text-decoration:none;font-family:'Barlow',sans-serif;font-size:13px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;padding:14px 32px;border-radius:2px;border:2px solid #fff;transition:background .2s,color .2s,transform .2s;display:inline-block}
#ff-hero .btn-outline:hover{background:#fff;color:#111;transform:translateY(-3px)}

#ff-stats{background:var(--darker);padding:0 var(--pad)}
#ff-stats .stats-inner{max-width:var(--max);margin:0 auto;display:grid;grid-template-columns:repeat(4,1fr);border:1px solid #2e2e2e;background:rgba(30,30,30,.95);position:relative;z-index:3;margin-top:-60px}
#ff-stats .stat-item{padding:36px 30px;border-right:1px solid #2e2e2e;position:relative;transition:background .3s}
#ff-stats .stat-item::after{content:'';position:absolute;bottom:0;left:0;height:3px;width:0;background:var(--accent);transition:width .4s cubic-bezier(.22,1,.36,1)}
#ff-stats .stat-item:hover::after{width:100%}
#ff-stats .stat-item:hover{background:rgba(200,230,60,.04)}
#ff-stats .stat-item:last-child{border-right:none}
#ff-stats .stat-num{font-family:'Barlow Condensed',sans-serif;font-size:clamp(2.2rem,4vw,3rem);font-weight:800;color:#fff;line-height:1;margin-bottom:6px;display:flex;align-items:baseline;gap:1px}
#ff-stats .stat-num .count-val{display:inline-block;min-width:1ch}
#ff-stats .stat-num .count-suffix{display:inline-block}
#ff-stats .stat-num.pop .count-val{animation:statPop .35s cubic-bezier(.22,1,.36,1)}
#ff-stats .stat-label{font-size:14px;font-weight:700;color:#fff;margin-bottom:4px}
#ff-stats .stat-desc{font-size:13px;color:var(--accent)}

#ff-portfolio{background:var(--dark);padding:80px 0}
#ff-portfolio .port-header{max-width:var(--max);margin:0 auto;padding:0 var(--pad);display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:50px;flex-wrap:wrap;gap:20px}
#ff-portfolio .port-header h2{font-family:'Barlow Condensed',sans-serif;font-size:clamp(1.8rem,4vw,3rem);font-weight:800;text-transform:uppercase;line-height:1.05}
#ff-portfolio .port-header h2 span{color:transparent;-webkit-text-stroke:2px var(--accent)}
#ff-portfolio .port-slider-wrap{overflow:hidden;position:relative;padding:0 var(--pad)}
#ff-portfolio .port-slider{display:flex;gap:20px;transition:transform .4s cubic-bezier(.4,0,.2,1);will-change:transform}
#ff-portfolio .port-card{flex:0 0 calc(25% - 15px);min-width:280px;background:var(--card);border-radius:2px;overflow:hidden;cursor:pointer;transition:transform .3s,box-shadow .3s}
#ff-portfolio .port-card:hover{transform:translateY(-6px);box-shadow:0 20px 40px rgba(0,0,0,.4)}
#ff-portfolio .port-card .port-img-wrap{position:relative;aspect-ratio:4/3;overflow:hidden}
#ff-portfolio .port-card img{width:100%;height:100%;object-fit:cover;filter:grayscale(100%);transition:transform .5s,filter .4s}
#ff-portfolio .port-card:hover img{transform:scale(1.07);filter:grayscale(60%)}
#ff-portfolio .port-card .port-overlay{position:absolute;inset:0;background:rgba(0,0,0,.4);display:flex;align-items:center;justify-content:center;opacity:0;transition:opacity .3s}
#ff-portfolio .port-card:hover .port-overlay{opacity:1}
#ff-portfolio .port-card .port-overlay a{border:2px solid #fff;color:#fff;text-decoration:none;font-size:13px;font-weight:700;letter-spacing:.08em;padding:10px 22px;border-radius:2px;transition:background .2s,color .2s,transform .2s;transform:translateY(8px)}
#ff-portfolio .port-card:hover .port-overlay a{transform:translateY(0)}
#ff-portfolio .port-card .port-overlay a:hover{background:#fff;color:#111}
#ff-portfolio .port-card .port-accent{position:absolute;bottom:0;right:0;width:0;height:0;border-style:solid;border-width:0 0 60px 60px;border-color:transparent transparent rgba(200,230,60,.6) transparent}
#ff-portfolio .port-info{padding:18px 20px 22px;background:var(--card2)}
#ff-portfolio .port-info h3{font-family:'Barlow Condensed',sans-serif;font-size:1.15rem;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:#fff;margin-bottom:6px}
#ff-portfolio .port-info p{font-size:13px;color:var(--muted);line-height:1.5}
#ff-portfolio .port-dots{display:flex;justify-content:center;gap:8px;margin-top:36px;padding:0 var(--pad)}
#ff-portfolio .port-dot{width:32px;height:4px;background:#333;border-radius:2px;border:none;cursor:pointer;transition:background .2s,width .3s;padding:0}
#ff-portfolio .port-dot.active{background:var(--accent);width:48px}

#ff-reviews{background:var(--darker);padding:80px var(--pad)}
#ff-reviews .rev-header{max-width:var(--max);margin:0 auto;display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:50px;flex-wrap:wrap;gap:20px}
#ff-reviews .rev-header h2{font-family:'Barlow Condensed',sans-serif;font-size:clamp(1.8rem,4vw,3rem);font-weight:800;text-transform:uppercase;line-height:1.05}
#ff-reviews .rev-header h2 span{color:transparent;-webkit-text-stroke:2px var(--accent)}
#ff-reviews .rev-header a{background:var(--accent);color:#111;text-decoration:none;font-family:'Barlow',sans-serif;font-size:12px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;padding:12px 28px;border-radius:2px;white-space:nowrap;transition:background .2s,transform .2s}
#ff-reviews .rev-header a:hover{background:#d4ef50;transform:translateY(-2px)}
#ff-reviews .rev-grid{max-width:var(--max);margin:0 auto;display:grid;grid-template-columns:repeat(2,1fr);gap:24px}
#ff-reviews .rev-card{background:var(--card);border:1px solid #2e2e2e;border-radius:2px;display:flex;overflow:hidden;min-height:200px;transition:border-color .3s,transform .3s,box-shadow .3s}
#ff-reviews .rev-card:hover{border-color:rgba(200,230,60,.3);transform:translateY(-4px);box-shadow:0 16px 36px rgba(0,0,0,.3)}
#ff-reviews .rev-card .rev-img{width:180px;flex-shrink:0;overflow:hidden}
#ff-reviews .rev-card .rev-img img{width:100%;height:100%;object-fit:cover;filter:grayscale(100%);display:block;transition:transform .5s,filter .4s}
#ff-reviews .rev-card:hover .rev-img img{transform:scale(1.05);filter:grayscale(50%)}
#ff-reviews .rev-card .rev-body{padding:28px 24px;display:flex;flex-direction:column;justify-content:space-between}
#ff-reviews .rev-card .rev-text{font-size:14px;color:#ccc;line-height:1.7;font-style:italic;margin-bottom:16px}
#ff-reviews .rev-stars{display:flex;gap:3px;margin-bottom:8px}
#ff-reviews .rev-stars svg{color:var(--accent);transition:transform .2s}
#ff-reviews .rev-card:hover .rev-stars svg{transform:scale(1.15)}
#ff-reviews .rev-name{font-size:14px;font-weight:700;color:#fff;letter-spacing:.03em}

#ff-plans{background:var(--dark);padding:80px var(--pad)}
#ff-plans .plans-header{text-align:center;margin-bottom:50px}
#ff-plans .plans-header h2{font-family:'Barlow Condensed',sans-serif;font-size:clamp(2rem,4.5vw,3.2rem);font-weight:800;text-transform:uppercase;line-height:1.05}
#ff-plans .plans-header h2 span{color:transparent;-webkit-text-stroke:2px var(--accent)}
#ff-plans .plans-header p{color:var(--muted);margin-top:14px;font-size:15px}
#ff-plans .plans-grid{max-width:var(--max);margin:0 auto;display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
#ff-plans .plan-card{background:var(--card);border:1px solid #2e2e2e;border-radius:2px;padding:0 0 30px;overflow:hidden;display:flex;flex-direction:column;transition:transform .3s,border-color .3s,box-shadow .3s}
#ff-plans .plan-card:hover{transform:translateY(-8px);border-color:rgba(200,230,60,.4);box-shadow:0 24px 48px rgba(0,0,0,.4)}
#ff-plans .plan-head{padding:28px 28px 20px;text-align:center}
#ff-plans .plan-head .plan-type{font-size:12px;font-weight:700;letter-spacing:.15em;text-transform:uppercase;color:var(--muted);margin-bottom:14px}
#ff-plans .plan-head .plan-price{font-family:'Barlow Condensed',sans-serif;font-size:clamp(2.5rem,5vw,3.5rem);font-weight:800;color:var(--accent);line-height:1}
#ff-plans .plan-head .plan-price small{font-size:1rem;font-weight:500;color:var(--muted)}
#ff-plans .plan-period{background:#1a1a1a;padding:12px;text-align:center;font-size:12px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);margin-bottom:24px}
#ff-plans .plan-features{padding:0 28px;flex:1}
#ff-plans .plan-features ul{list-style:none;display:flex;flex-direction:column;gap:12px}
#ff-plans .plan-features ul li{display:flex;align-items:flex-start;gap:10px;font-size:14px;color:#ccc;line-height:1.5}
#ff-plans .plan-features ul li svg{flex-shrink:0;margin-top:2px;transition:transform .2s}
#ff-plans .plan-card:hover .plan-features ul li svg{transform:scale(1.1)}
#ff-plans .plan-footer{padding:28px 28px 0}
#ff-plans .plan-footer a{display:block;text-align:center;background:var(--accent);color:#111;text-decoration:none;font-family:'Barlow',sans-serif;font-size:13px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;padding:14px;border-radius:2px;transition:background .2s,transform .2s,box-shadow .2s}
#ff-plans .plan-footer a:hover{background:#d4ef50;transform:translateY(-2px);box-shadow:0 8px 20px rgba(200,230,60,.25)}

#ff-why{background:var(--darker);padding:80px var(--pad)}
#ff-why .why-inner{max-width:var(--max);margin:0 auto;display:grid;grid-template-columns:1fr 420px;gap:80px;align-items:start}
#ff-why .why-left h2{font-family:'Barlow Condensed',sans-serif;font-size:clamp(2rem,4vw,3rem);font-weight:800;text-transform:uppercase;line-height:1.05;margin-bottom:50px}
#ff-why .why-left h2 span{color:transparent;-webkit-text-stroke:2px var(--accent)}
#ff-why .why-list{display:flex;flex-direction:column;gap:30px}
#ff-why .why-item{display:flex;gap:18px;align-items:flex-start;transition:transform .3s}
#ff-why .why-item:hover{transform:translateX(6px)}
#ff-why .why-icon{width:36px;height:36px;background:var(--accent);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;transition:transform .3s,box-shadow .3s}
#ff-why .why-item:hover .why-icon{transform:scale(1.15);box-shadow:0 0 0 6px rgba(200,230,60,.15)}
#ff-why .why-icon svg{color:#111}
#ff-why .why-text h4{font-size:16px;font-weight:700;color:#fff;margin-bottom:8px}
#ff-why .why-text p{font-size:14px;color:var(--muted);line-height:1.7}
#ff-why .why-img{position:relative;overflow:hidden;border-radius:2px}
#ff-why .why-img img{width:100%;height:500px;object-fit:cover;filter:grayscale(100%);display:block;transition:transform .6s,filter .4s}
#ff-why .why-img:hover img{transform:scale(1.04);filter:grayscale(60%)}

@media(max-width:1100px){
#ff-why .why-inner{grid-template-columns:1fr;gap:50px}
#ff-why .why-img img{height:300px}
#ff-reviews .rev-grid{grid-template-columns:1fr}
}
@media(max-width:900px){
:root{--pad:24px}
#ff-stats .stats-inner{grid-template-columns:repeat(2,1fr)}
#ff-stats .stat-item:nth-child(2){border-right:none}
#ff-stats .stat-item:nth-child(3){border-top:1px solid #2e2e2e}
#ff-stats .stat-item:nth-child(4){border-top:1px solid #2e2e2e;border-right:none}
#ff-plans .plans-grid{grid-template-columns:1fr}
#ff-plans .plans-grid .plan-card{max-width:420px;margin:0 auto;width:100%}
#ff-portfolio .port-card{flex:0 0 calc(50% - 10px);min-width:240px}
#ff-reviews .rev-card{flex-direction:column}
#ff-reviews .rev-card .rev-img{width:100%;height:200px}
}
@media(max-width:600px){
:root{--pad:18px}
#ff-hero .hero-content{padding:100px 18px 60px}
#ff-stats .stats-inner{grid-template-columns:1fr 1fr}
#ff-portfolio .port-card{flex:0 0 calc(100% - 0px);min-width:240px}
#ff-portfolio .port-header{flex-direction:column;align-items:flex-start}
#ff-reviews .rev-header{flex-direction:column;align-items:flex-start}
}
</style>
</head>
<body>

<?php include 'api/nav.php'; ?>

<main>

<section id="ff-hero" aria-label="Hero Banner">
<div class="hero-bg">
<?php if($banner!=""){ ?>
<img src="./files/<?php echo $banner; ?>" alt="<?php echo htmlspecialchars($site_title); ?> Hero" loading="eager">
<?php } ?>
</div>
<div class="hero-accent"></div>
<div class="hero-content">
<h1>
<span class="outline">Achieve</span> <span class="solid">More</span><br>
<span class="solid">Than Just Fitness</span>
</h1>
<p class="hero-sub">Combine strength, flexibility, and endurance in a community that values well-rounded health and supportive growth.</p>
<div class="hero-btns">
<a href="contact.php" class="btn-primary">Start Now</a>
<a href="pay.php" class="btn-outline">Join Free Trial</a>
</div>
</div>
</section>

<?php if($details->num_rows){ $d=$details->fetch_assoc();
$m_num=extractNum($d['members']);
$c_num=extractNum($d['classes']);
$t_num=extractNum($d['trainers']);
$s_num=extractNum($d['satisfaction']);
?>
<div id="ff-stats">
<div class="stats-inner">
<div class="stat-item anim-ready">
<div class="stat-num" data-target="<?php echo $m_num; ?>">
<span class="count-val">0</span><span class="count-suffix">+</span>
</div>
<div class="stat-label">Happy Members</div>
<div class="stat-desc">Our community is growing fast!</div>
</div>
<div class="stat-item anim-ready">
<div class="stat-num" data-target="<?php echo $c_num; ?>">
<span class="count-val">0</span><span class="count-suffix">+</span>
</div>
<div class="stat-label">Weekly Classes</div>
<div class="stat-desc">Pick from various workouts</div>
</div>
<div class="stat-item anim-ready">
<div class="stat-num" data-target="<?php echo $t_num; ?>">
<span class="count-val">0</span><span class="count-suffix">+</span>
</div>
<div class="stat-label">Certified Trainers</div>
<div class="stat-desc">Guidance at every step.</div>
</div>
<div class="stat-item anim-ready">
<div class="stat-num" data-target="<?php echo $s_num; ?>">
<span class="count-val">0</span><span class="count-suffix">%</span>
</div>
<div class="stat-label">Customer Satisfaction</div>
<div class="stat-desc">We ensure your progress satisfaction</div>
</div>
</div>
</div>
<?php } ?>

<section id="ff-portfolio" aria-label="Portfolio">
<div class="port-header">
<h2 class="anim-ready"><span>Choose</span> Our Path<br>To Fitness</h2>
</div>
<div class="port-slider-wrap">
<div class="port-slider" id="portSlider">
<?php while($p=$portfolio->fetch_assoc()){ ?>
<article class="port-card anim-ready">
<div class="port-img-wrap">
<img src="./files/<?php echo $p['image']; ?>" alt="<?php echo htmlspecialchars($p['title']); ?>" loading="lazy">
<div class="port-overlay">
<a href="portfolio.php">View More</a>
</div>
<div class="port-accent"></div>
</div>
<div class="port-info">
<h3><?php echo htmlspecialchars($p['title']); ?></h3>
<p><?php echo htmlspecialchars(trimWords($p['description'],24)); ?></p>
</div>
</article>
<?php } ?>
</div>
</div>
<div class="port-dots" id="portDots"></div>
</section>

<section id="ff-reviews" aria-label="Testimonials">
<div class="rev-header">
<h2 class="anim-ready">Transformations Speak<br><span>Louder</span> Than Words</h2>
<a href="portfolio.php" class="anim-ready">View More</a>
</div>
<div class="rev-grid">
<?php while($rv=$reviews->fetch_assoc()){ ?>
<article class="rev-card anim-ready">
<div class="rev-img">
<img src="./files/<?php echo $rv['image']; ?>" alt="<?php echo htmlspecialchars($rv['name']); ?>" loading="lazy">
</div>
<div class="rev-body">
<p class="rev-text">"<?php echo htmlspecialchars($rv['review']); ?>"</p>
<div class="rev-stars">
<?php $stars=round(floatval($rv['rating']));for($i=1;$i<=5;$i++){ ?>
<svg width="16" height="16" viewBox="0 0 24 24" fill="<?php echo $i<=$stars?'currentColor':'none'; ?>" stroke="currentColor" stroke-width="1.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
<?php } ?>
</div>
<div class="rev-name"><?php echo htmlspecialchars($rv['name']); ?></div>
</div>
</article>
<?php } ?>
</div>
</section>

<section id="ff-plans" aria-label="Pricing Plans">
<div class="plans-header">
<h2 class="anim-ready"><span>Flexible</span> Plans For<br>Every Budget</h2>
<p class="anim-ready">Choose a plan that suits you. No long-term commitments required.</p>
</div>
<div class="plans-grid">
<?php while($pl=$plans->fetch_assoc()){$features=json_decode($pl['features'],true); ?>
<article class="plan-card anim-ready">
<div class="plan-head">
<div class="plan-type"><?php echo htmlspecialchars($pl['plan_type']); ?></div>
<div class="plan-price"><?php echo htmlspecialchars($pl['price']); ?><small> / month</small></div>
</div>
<div class="plan-period"><?php echo htmlspecialchars($pl['period']); ?></div>
<div class="plan-features">
<ul>
<?php if($features){foreach($features as $f){ ?>
<li>
<svg width="18" height="18" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="#c8e63c"/><path d="M8 12l3 3 5-5" stroke="#111" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
<?php echo htmlspecialchars($f); ?>
</li>
<?php }}?>
</ul>
</div>
<div class="plan-footer">
<a href="pay.php">Get Started</a>
</div>
</article>
<?php } ?>
</div>
</section>

<section id="ff-why" aria-label="Why Choose Us">
<div class="why-inner">
<div class="why-left">
<h2 class="anim-ready"><span>Why <?php echo htmlspecialchars($site_title); ?></span> Is Your<br>Ideal Fitness Partner</h2>
<div class="why-list">
<?php $why->data_seek(0);while($w=$why->fetch_assoc()){ ?>
<div class="why-item anim-ready">
<div class="why-icon">
<svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
</div>
<div class="why-text">
<h4><?php echo htmlspecialchars($w['title']); ?></h4>
<p><?php echo htmlspecialchars($w['info']); ?></p>
</div>
</div>
<?php } ?>
</div>
</div>
<div class="why-img anim-ready">
<?php if($banner!=""){ ?>
<img src="./files/<?php echo $banner; ?>" alt="Why <?php echo htmlspecialchars($site_title); ?>" loading="lazy">
<?php } ?>
</div>
</div>
</section>

<?php include 'api/ready.php'; ?>

<?php include 'api/footer.php'; ?>

</main>

<?php include 'api/top.php'; ?>

<script>
(function(){
var slider=document.getElementById('portSlider');
var dotsWrap=document.getElementById('portDots');
if(!slider)return;
var cards=slider.querySelectorAll('.port-card');
var perView=window.innerWidth<=600?1:window.innerWidth<=900?2:4;
var total=cards.length;
var pages=Math.ceil(total/perView);
var cur=0;
function buildDots(){
dotsWrap.innerHTML='';
for(var i=0;i<pages;i++){
var d=document.createElement('button');
d.className='port-dot'+(i===0?' active':'');
d.setAttribute('aria-label','Page '+(i+1));
(function(idx){d.addEventListener('click',function(){goTo(idx);});})(i);
dotsWrap.appendChild(d);
}
}
function goTo(idx){
cur=idx;
var cardW=cards[0].offsetWidth+20;
slider.style.transform='translateX(-'+(cur*perView*cardW)+'px)';
dotsWrap.querySelectorAll('.port-dot').forEach(function(d,i){d.classList.toggle('active',i===cur);});
}
buildDots();
window.addEventListener('resize',function(){
perView=window.innerWidth<=600?1:window.innerWidth<=900?2:4;
pages=Math.ceil(total/perView);
cur=0;
buildDots();
goTo(0);
});
})();

(function(){
function easeOutQuart(t){return 1-Math.pow(1-t,4);}
function runCount(numEl){
var target=parseInt(numEl.getAttribute('data-target'))||0;
var valEl=numEl.querySelector('.count-val');
if(!valEl||numEl.dataset.done)return;
numEl.dataset.done='1';
var duration=1800;
var startTs=null;
function tick(ts){
if(!startTs)startTs=ts;
var p=Math.min((ts-startTs)/duration,1);
var val=Math.round(easeOutQuart(p)*target);
valEl.textContent=val.toLocaleString();
if(p<1){
requestAnimationFrame(tick);
}else{
valEl.textContent=target.toLocaleString();
numEl.classList.add('pop');
}
}
requestAnimationFrame(tick);
}
var statIo=new IntersectionObserver(function(entries){
entries.forEach(function(e){
if(e.isIntersecting){
var item=e.target;
var delay=parseInt(item.dataset.delay||0);
setTimeout(function(){
item.classList.add('anim-up');
var numEl=item.querySelector('.stat-num[data-target]');
if(numEl) runCount(numEl);
},delay);
statIo.unobserve(item);
}
});
},{threshold:.3});
document.querySelectorAll('#ff-stats .stat-item').forEach(function(el,i){
el.dataset.delay=i*120;
statIo.observe(el);
});
})();

(function(){
var io=new IntersectionObserver(function(entries){
entries.forEach(function(e){
if(e.isIntersecting){
var el=e.target;
var delay=el.dataset.delay||0;
setTimeout(function(){el.classList.add('anim-up');},parseInt(delay));
io.unobserve(el);
}
});
},{threshold:.12});
document.querySelectorAll('.anim-ready:not(#ff-stats .stat-item)').forEach(function(el,i){
el.dataset.delay=Math.min(i%4,3)*80;
io.observe(el);
});
})();
</script>

</body>
</html>