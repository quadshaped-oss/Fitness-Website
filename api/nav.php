<?php
require __DIR__.'/../db.php';
$logo="";
$title="";
$phone="";
$q=$conn->query("SELECT logo,title FROM info LIMIT 1");
if($q->num_rows){$r=$q->fetch_assoc();$logo=$r['logo'];$title=$r['title'];}
$q2=$conn->query("SELECT phone FROM contact LIMIT 1");
if($q2->num_rows){$r2=$q2->fetch_assoc();$phone=$r2['phone'];}
$wa="https://wa.me/91".$phone;
$cur=basename($_SERVER['PHP_SELF']);
?>
<style>
@import url('https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;700&display=swap');
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{--darker:#111;--accent:#c8e63c;--nav-h:70px}
@keyframes _navSlideDown{from{transform:translateY(-100%);opacity:0}to{transform:translateY(0);opacity:1}}
@keyframes _logoFade{from{opacity:0;transform:translateX(-16px)}to{opacity:1;transform:translateX(0)}}
@keyframes _navLinkFade{from{opacity:0;transform:translateY(-8px)}to{opacity:1;transform:translateY(0)}}
@keyframes _btnPop{from{opacity:0;transform:scale(.85)}to{opacity:1;transform:scale(1)}}
@keyframes _hamLine{from{opacity:0;transform:scaleX(0)}to{opacity:1;transform:scaleX(1)}}
#_nav{position:absolute;top:0;left:0;width:100%;z-index:999;background:transparent;transition:background .35s,box-shadow .35s;animation:_navSlideDown .5s cubic-bezier(.4,0,.2,1) both}
#_nav.scrolled{position:fixed;background:var(--darker);box-shadow:0 2px 20px rgba(0,0,0,.6)}
#_nav ._ni{display:flex;align-items:center;justify-content:space-between;height:var(--nav-h);padding:0 40px;max-width:1400px;margin:0 auto}
#_nav ._logo{animation:_logoFade .5s .15s cubic-bezier(.4,0,.2,1) both}
#_nav ._logo img{height:42px;width:auto;display:block;transition:opacity .2s,transform .2s}
#_nav ._logo img:hover{opacity:.85;transform:scale(1.04)}
#_nav ._logo ._logotxt{font-family:'Barlow',sans-serif;font-size:22px;font-weight:700;color:#fff;text-decoration:none;letter-spacing:.02em;transition:color .2s}
#_nav ._logo ._logotxt:hover{color:var(--accent)}
#_nav ul{list-style:none;display:flex;gap:4px;align-items:center}
#_nav ul li{animation:_navLinkFade .4s both}
#_nav ul li:nth-child(1){animation-delay:.2s}
#_nav ul li:nth-child(2){animation-delay:.27s}
#_nav ul li:nth-child(3){animation-delay:.34s}
#_nav ul li:nth-child(4){animation-delay:.41s}
#_nav ul li:nth-child(5){animation-delay:.48s}
#_nav ul li a{color:#fff;text-decoration:none;font-family:'Barlow',sans-serif;font-size:15px;font-weight:500;letter-spacing:.04em;padding:8px 14px;border-radius:3px;transition:color .2s,background .2s;display:flex;align-items:center;gap:4px;position:relative}
#_nav ul li a::after{content:'';position:absolute;bottom:2px;left:14px;right:14px;height:2px;background:var(--accent);border-radius:2px;transform:scaleX(0);transition:transform .25s cubic-bezier(.4,0,.2,1)}
#_nav ul li a:hover::after,#_nav ul li a.active::after{transform:scaleX(1)}
#_nav ul li a:hover,#_nav ul li a.active{color:var(--accent)}
#_nav ul li a.active{font-weight:700}
#_nav ._cbtn{animation:_btnPop .4s .5s cubic-bezier(.4,0,.2,1) both}
#_nav ._cbtn a{display:flex;align-items:center;gap:8px;border:2px solid #fff;color:#fff;text-decoration:none;font-family:'Barlow',sans-serif;font-size:13px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;padding:10px 22px;border-radius:2px;transition:background .2s,color .2s,border-color .2s,transform .2s}
#_nav ._cbtn a:hover{background:var(--accent);border-color:var(--accent);color:#111;transform:translateY(-2px)}
#_nav ._cbtn a svg{transition:transform .25s}
#_nav ._cbtn a:hover svg{transform:scale(1.15)}
#_nav ._ham{display:none;background:none;border:none;cursor:pointer;padding:6px;flex-direction:column;justify-content:center;align-items:center;gap:5px;width:36px;height:36px;position:relative}
#_nav ._ham span{display:block;width:24px;height:2px;background:#fff;border-radius:2px;position:absolute;left:6px;transform-origin:center;transition:transform .35s cubic-bezier(.4,0,.2,1),opacity .25s cubic-bezier(.4,0,.2,1),top .35s cubic-bezier(.4,0,.2,1),background .2s;animation:_hamLine .4s both;backface-visibility:hidden}
#_nav ._ham span:nth-child(1){top:8px;animation-delay:.3s}
#_nav ._ham span:nth-child(2){top:17px;animation-delay:.38s}
#_nav ._ham span:nth-child(3){top:26px;animation-delay:.46s}
#_nav ._ham:hover span{background:var(--accent)}
#_nav ._ham.is-open span:nth-child(1){top:17px;transform:rotate(45deg);background:var(--accent)}
#_nav ._ham.is-open span:nth-child(2){opacity:0;transform:scaleX(0)}
#_nav ._ham.is-open span:nth-child(3){top:17px;transform:rotate(-45deg);background:var(--accent)}
#_nav ._mob{display:none;position:fixed;top:var(--nav-h);left:0;width:100%;background:var(--darker);padding:20px 0;border-top:1px solid #222;z-index:998;transform:translateY(-10px);opacity:0;transition:transform .3s cubic-bezier(.4,0,.2,1),opacity .3s}
#_nav ._mob.open{display:block;transform:translateY(0);opacity:1}
#_nav ._mob ul{flex-direction:column;display:flex;gap:0}
#_nav ._mob ul li a{display:block;padding:14px 40px;font-size:16px;border-bottom:1px solid #222;color:#fff;text-decoration:none;font-family:'Barlow',sans-serif;font-weight:500;transition:color .2s,padding-left .2s}
#_nav ._mob ul li a:hover{color:var(--accent);padding-left:52px}
#_nav ._mob ul li a.active{color:var(--accent);font-weight:700}
#_nav ._mob ._mwa{padding:20px 40px}
#_nav ._mob ._mwa a{display:inline-flex;align-items:center;gap:8px;border:2px solid var(--accent);color:var(--accent);text-decoration:none;font-family:'Barlow',sans-serif;font-size:13px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;padding:10px 24px;border-radius:2px;transition:background .2s,color .2s}
#_nav ._mob ._mwa a:hover{background:var(--accent);color:#111}
@media(max-width:900px){#_nav ._links,#_nav ._cbtn{display:none}#_nav ._ham{display:flex}}
</style>
<nav id="_nav">
<div class="_ni">
<div class="_logo">
<?php if($logo!=""){ ?>
<img src="files/<?php echo $logo; ?>" alt="<?php echo htmlspecialchars($title); ?>">
<?php }else{ ?>
<a class="_logotxt" href="index.php"><?php echo htmlspecialchars($title); ?></a>
<?php } ?>
</div>
<ul class="_links">
<li><a href="index.php"<?php if($cur=='index.php')echo ' class="active"'; ?>>Home</a></li>
<li><a href="about.php"<?php if($cur=='about.php')echo ' class="active"'; ?>>About</a></li>
<li><a href="portfolio.php"<?php if($cur=='portfolio.php')echo ' class="active"'; ?>>Portfolio</a></li>
<li><a href="pay.php"<?php if($cur=='pay.php')echo ' class="active"'; ?>>Pay</a></li>
<li><a href="contact.php"<?php if($cur=='contact.php')echo ' class="active"'; ?>>Contact</a></li>
</ul>
<div class="_cbtn">
<a href="<?php echo $wa; ?>">
<svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2 22l4.978-1.421A9.953 9.953 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M8.5 9.5c.2.6.7 1.8 1.6 2.7.9.9 2.1 1.5 2.7 1.7.4.1.7 0 .9-.2l.6-.7c.2-.2.5-.3.7-.2l2 .9c.3.1.4.4.3.7-.3.9-1.1 2.1-2.3 2.1-1.7 0-4.7-1.3-6.5-5.1-.4-.8-.3-1.8.2-2.4.3-.4.8-.5 1.1-.3l.3.1c.2.1.4.3.4.5v.2z" fill="currentColor"/></svg>
Contact
</a>
</div>
<button class="_ham" id="_ham" aria-label="Menu">
<span></span>
<span></span>
<span></span>
</button>
</div>
<div class="_mob" id="_mob">
<ul>
<li><a href="index.php"<?php if($cur=='index.php')echo ' class="active"'; ?>>Home</a></li>
<li><a href="about.php"<?php if($cur=='about.php')echo ' class="active"'; ?>>About</a></li>
<li><a href="portfolio.php"<?php if($cur=='portfolio.php')echo ' class="active"'; ?>>Portfolio</a></li>
<li><a href="pay.php"<?php if($cur=='pay.php')echo ' class="active"'; ?>>Pay</a></li>
<li><a href="contact.php"<?php if($cur=='contact.php')echo ' class="active"'; ?>>Contact</a></li>
</ul>
<div class="_mwa"><a href="<?php echo $wa; ?>">WhatsApp</a></div>
</div>
</nav>
<script>
(function(){
var n=document.getElementById('_nav');
var h=document.getElementById('_ham');
var m=document.getElementById('_mob');
window.addEventListener('scroll',function(){n.classList.toggle('scrolled',window.scrollY>10);});
h.addEventListener('click',function(){
var opening=!m.classList.contains('open');
h.classList.toggle('is-open',opening);
if(opening){
m.style.display='block';
requestAnimationFrame(function(){
m.classList.add('open');
m.style.transform='translateY(0)';
m.style.opacity='1';
});
}else{
m.classList.remove('open');
m.style.transform='translateY(-10px)';
m.style.opacity='0';
setTimeout(function(){if(!m.classList.contains('open'))m.style.display='none';},300);
}
});
})();
</script>