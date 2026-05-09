<?php
require __DIR__.'/../db.php';
$banner="";
$phone="";
$title="";
$q=$conn->query("SELECT ready_banner,title FROM info LIMIT 1");
if($q->num_rows){$r=$q->fetch_assoc();$banner=$r['ready_banner'];$title=$r['title'];}
$q2=$conn->query("SELECT phone FROM contact LIMIT 1");
if($q2->num_rows){$r2=$q2->fetch_assoc();$phone=$r2['phone'];}
$wa="https://wa.me/91".$phone;
?>
<style>
@import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;800&family=Barlow:wght@400;500&display=swap');
@keyframes _rdBarGrow{from{clip-path:polygon(0 0,0 0,0 100%,0 100%)}to{clip-path:polygon(0 0,60% 0,100% 100%,0 100%)}}
@keyframes _rdFadeUp{from{opacity:0;transform:translateY(24px)}to{opacity:1;transform:translateY(0)}}
@keyframes _rdBtnIn{from{opacity:0;transform:translateX(-20px)}to{opacity:1;transform:translateX(0)}}
@keyframes _rdImgZoom{from{transform:scale(1.08)}to{transform:scale(1)}}
#_ready{position:relative;overflow:hidden;min-height:340px;display:flex;align-items:center}
#_ready ._rbg{position:absolute;inset:0;z-index:0}
#_ready ._rbg img{width:100%;height:100%;object-fit:cover;display:block;filter:grayscale(100%);animation:_rdImgZoom 1.2s cubic-bezier(.4,0,.2,1) both}
#_ready ._rbg::after{content:'';position:absolute;inset:0;background:linear-gradient(to right,rgba(10,10,10,.15) 0%,rgba(10,10,10,.65) 40%,rgba(10,10,10,.85) 100%)}
#_ready ._rbar{position:absolute;bottom:0;left:0;width:120px;height:100%;background:#c8e63c;clip-path:polygon(0 0,0 0,0 100%,0 100%);opacity:.85;z-index:1}
#_ready ._rbar.rd-visible{animation:_rdBarGrow .7s .1s cubic-bezier(.4,0,.2,1) forwards}
#_ready ._rc{position:relative;z-index:2;max-width:1400px;width:100%;margin:0 auto;padding:60px 40px;display:flex;flex-direction:column;align-items:flex-start;justify-content:center}
#_ready h2{font-family:'Barlow Condensed',sans-serif;font-size:clamp(2.2rem,5vw,3.8rem);font-weight:800;color:#fff;line-height:1.05;text-transform:uppercase;margin-bottom:12px;max-width:580px;opacity:0;transform:translateY(24px)}
#_ready h2.rd-visible{animation:_rdFadeUp .6s .2s cubic-bezier(.4,0,.2,1) forwards}
#_ready h2 span{color:transparent;-webkit-text-stroke:2px #c8e63c;display:block}
#_ready ._rp{font-family:'Barlow',sans-serif;color:#ccc;font-size:16px;margin-bottom:32px;letter-spacing:.03em;opacity:0;transform:translateY(18px)}
#_ready ._rp.rd-visible{animation:_rdFadeUp .5s .38s cubic-bezier(.4,0,.2,1) forwards}
#_ready ._jbtn{display:inline-flex;align-items:center;gap:10px;background:#c8e63c;color:#111;text-decoration:none;font-family:'Barlow',sans-serif;font-size:13px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;padding:14px 36px;border-radius:2px;transition:background .2s,transform .2s,box-shadow .2s;opacity:0}
#_ready ._jbtn.rd-visible{animation:_rdBtnIn .5s .52s cubic-bezier(.4,0,.2,1) forwards}
#_ready ._jbtn:hover{background:#d4ef50;transform:translateY(-3px);box-shadow:0 8px 24px rgba(200,230,60,.3)}
#_ready ._jbtn svg{transition:transform .25s}
#_ready ._jbtn:hover svg{transform:scale(1.15) rotate(-5deg)}
@media(max-width:600px){#_ready ._rc{padding:50px 24px}#_ready ._rbar{width:70px}}
</style>
<section id="_ready">
<div class="_rbg">
<?php if($banner!=""){ ?>
<img src="files/<?php echo $banner; ?>" alt="<?php echo htmlspecialchars($title); ?>">
<?php } ?>
</div>
<div class="_rbar" id="_rdBar"></div>
<div class="_rc">
<h2 id="_rdH2">Ready To Start Your<br>Journey With<span><?php echo htmlspecialchars($title); ?>?</span></h2>
<p class="_rp" id="_rdP">Reserve Your Spot Today!</p>
<a href="<?php echo $wa; ?>" class="_jbtn" id="_rdBtn">
<svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2 22l4.978-1.421A9.953 9.953 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M8.5 9.5c.2.6.7 1.8 1.6 2.7.9.9 2.1 1.5 2.7 1.7.4.1.7 0 .9-.2l.6-.7c.2-.2.5-.3.7-.2l2 .9c.3.1.4.4.3.7-.3.9-1.1 2.1-2.3 2.1-1.7 0-4.7-1.3-6.5-5.1-.4-.8-.3-1.8.2-2.4.3-.4.8-.5 1.1-.3l.3.1c.2.1.4.3.4.5v.2z" fill="currentColor"/></svg>
Join Now
</a>
</div>
</section>
<script>
(function(){
var els=[
document.getElementById('_rdBar'),
document.getElementById('_rdH2'),
document.getElementById('_rdP'),
document.getElementById('_rdBtn')
];
var io=new IntersectionObserver(function(entries){
entries.forEach(function(e){
if(e.isIntersecting){
els.forEach(function(el){if(el)el.classList.add('rd-visible');});
io.disconnect();
}
});
},{threshold:.25});
var sec=document.getElementById('_ready');
if(sec)io.observe(sec);
})();
</script>