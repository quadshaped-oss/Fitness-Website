<?php
require __DIR__.'/../db.php';
$logo="";$title="";$facebook="";$youtube="";$x="";$instagram="";$phone="";$email="";$address="";
$q=$conn->query("SELECT logo,title FROM info LIMIT 1");
if($q->num_rows){$r=$q->fetch_assoc();$logo=$r['logo'];$title=$r['title'];}
$q2=$conn->query("SELECT * FROM social LIMIT 1");
if($q2->num_rows){$r2=$q2->fetch_assoc();$facebook=$r2['facebook_url'];$youtube=$r2['youtube_url'];$x=$r2['x_url'];$instagram=$r2['instagram_url'];}
$q3=$conn->query("SELECT * FROM contact LIMIT 1");
if($q3->num_rows){$r3=$q3->fetch_assoc();$phone=$r3['phone'];$email=$r3['email'];$address=$r3['address'];}
?>
<style>
@import url('https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700&display=swap');
@keyframes _ftFadeUp{from{opacity:0;transform:translateY(28px)}to{opacity:1;transform:translateY(0)}}
@keyframes _ftLineGrow{from{transform:scaleX(0)}to{transform:scaleX(1)}}
@keyframes _socialPop{from{opacity:0;transform:scale(0.6)}to{opacity:1;transform:scale(1)}}
#_footer{background:#1a1a1a;color:#ccc;font-family:'Barlow',sans-serif;padding:60px 40px 30px;border-top:1px solid #2a2a2a}
#_footer ._fg{display:grid;grid-template-columns:repeat(4,1fr);gap:40px;max-width:1400px;margin:0 auto;padding-bottom:40px;border-bottom:1px solid #2a2a2a}
#_footer ._fg>div{opacity:0;transform:translateY(28px);transition:opacity .55s cubic-bezier(.4,0,.2,1),transform .55s cubic-bezier(.4,0,.2,1)}
#_footer ._fg>div.ft-visible{opacity:1;transform:translateY(0)}
#_footer ._fg>div:nth-child(1){transition-delay:.0s}
#_footer ._fg>div:nth-child(2){transition-delay:.1s}
#_footer ._fg>div:nth-child(3){transition-delay:.2s}
#_footer ._fg>div:nth-child(4){transition-delay:.3s}
#_footer h4{color:#fff;font-size:15px;font-weight:700;letter-spacing:.05em;margin-bottom:20px;position:relative;padding-bottom:10px}
#_footer h4::after{content:'';position:absolute;bottom:0;left:0;width:32px;height:2px;background:#c8e63c;border-radius:2px;transform-origin:left;transform:scaleX(0);transition:transform .4s .2s cubic-bezier(.4,0,.2,1)}
#_footer ._fg>div.ft-visible h4::after{transform:scaleX(1)}
#_footer ul{list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:10px}
#_footer ul li{overflow:hidden}
#_footer ul li a{color:#999;text-decoration:none;font-size:14px;transition:color .2s,padding-left .2s;display:block}
#_footer ul li a:hover{color:#c8e63c;padding-left:8px}
#_footer ._contact-col p{font-size:14px;color:#999;line-height:1.7;margin-bottom:6px;transition:color .2s}
#_footer ._contact-col p:hover{color:#ccc}
#_footer ._social{display:flex;gap:10px;margin-top:6px}
#_footer ._social a{display:flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:50%;background:#2a2a2a;color:#aaa;text-decoration:none;transition:background .25s,color .25s,transform .25s;opacity:0;transform:scale(0.6)}
#_footer ._fg>div.ft-visible ._social a{opacity:1;transform:scale(1)}
#_footer ._social a:nth-child(1){transition:background .25s,color .25s,transform .25s,opacity .3s .35s}
#_footer ._social a:nth-child(2){transition:background .25s,color .25s,transform .25s,opacity .3s .42s}
#_footer ._social a:nth-child(3){transition:background .25s,color .25s,transform .25s,opacity .3s .49s}
#_footer ._social a:nth-child(4){transition:background .25s,color .25s,transform .25s,opacity .3s .56s}
#_footer ._social a:hover{background:#c8e63c;color:#111;transform:scale(1.15) translateY(-2px)}
#_footer ._fb{max-width:1400px;margin:0 auto;padding-top:24px;font-size:13px;color:#555;opacity:0;transform:translateY(10px);transition:opacity .5s .4s,transform .5s .4s}
#_footer ._fb.ft-visible{opacity:1;transform:translateY(0)}
@media(max-width:900px){#_footer ._fg{grid-template-columns:repeat(2,1fr)}}
@media(max-width:500px){#_footer ._fg{grid-template-columns:1fr}#_footer{padding:40px 20px 20px}}
</style>
<footer id="_footer">
<div class="_fg">
<div>
<h4>Links</h4>
<ul>
<li><a href="index.php">Home</a></li>
<li><a href="about.php">About</a></li>
<li><a href="portfolio.php">Portfolio</a></li>
<li><a href="pay.php">Pay</a></li>
<li><a href="contact.php">Contact</a></li>
</ul>
</div>
<div class="_contact-col">
<h4>Contact</h4>
<?php if($phone!=""){ ?><p><?php echo htmlspecialchars($phone); ?></p><?php } ?>
<?php if($email!=""){ ?><p><?php echo htmlspecialchars($email); ?></p><?php } ?>
<?php if($address!=""){ ?><p><?php echo htmlspecialchars($address); ?></p><?php } ?>
</div>
<div>
<h4>Social</h4>
<div class="_social">
<?php if($instagram!=""){ ?><a href="<?php echo $instagram; ?>" aria-label="Instagram"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg></a><?php } ?>
<?php if($x!=""){ ?><a href="<?php echo $x; ?>" aria-label="X"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.73-8.835L1.254 2.25H8.08l4.258 5.63zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></a><?php } ?>
<?php if($youtube!=""){ ?><a href="<?php echo $youtube; ?>" aria-label="YouTube"><svg width="16" height="12" viewBox="0 0 24 18" fill="currentColor"><path d="M23.5 2.8A3 3 0 0021.4.7C19.5 0 12 0 12 0S4.5 0 2.6.7A3 3 0 00.5 2.8 31 31 0 000 9a31 31 0 00.5 6.2A3 3 0 002.6 17.3C4.5 18 12 18 12 18s7.5 0 9.4-.7a3 3 0 002.1-2.1A31 31 0 0024 9a31 31 0 00-.5-6.2zM9.6 12.8V5.2L16 9l-6.4 3.8z"/></svg></a><?php } ?>
<?php if($facebook!=""){ ?><a href="<?php echo $facebook; ?>" aria-label="Facebook"><svg width="9" height="16" viewBox="0 0 10 18" fill="currentColor"><path d="M6.5 10.5H9l.5-3H6.5V6c0-.8.4-1.5 1.6-1.5H9.6V1.8S8.5 1.5 7.4 1.5C4.9 1.5 3.3 3 3.3 5.6v1.9H.7v3h2.6V18H6.5V10.5z"/></svg></a><?php } ?>
</div>
</div>
<div>
<h4><?php echo htmlspecialchars($title); ?></h4>
<?php if($logo!=""){ ?><img src="files/<?php echo $logo; ?>" alt="<?php echo htmlspecialchars($title); ?>" style="height:40px;width:auto;margin-bottom:12px;display:block;transition:opacity .2s,transform .2s" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'"><?php } ?>
<p style="font-size:13px;color:#666;line-height:1.6">&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($title); ?>. All rights reserved.</p>
</div>
</div>
<div class="_fb">&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($title); ?>. All rights reserved.</div>
</footer>
<script>
(function(){
var io=new IntersectionObserver(function(entries){
entries.forEach(function(e){
if(e.isIntersecting){e.target.classList.add('ft-visible');io.unobserve(e.target);}
});
},{threshold:.15});
document.querySelectorAll('#_footer ._fg>div').forEach(function(el){io.observe(el);});
var fb=document.querySelector('#_footer ._fb');
if(fb)io.observe(fb);
})();
</script>