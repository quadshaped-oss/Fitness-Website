<?php
?>
<style>
#fitflex-topbtn{display:none;position:fixed;bottom:30px;right:30px;z-index:9999;width:44px;height:44px;background:#c8e63c;border:none;border-radius:3px;cursor:pointer;align-items:center;justify-content:center;transition:background .2s,transform .2s}
#fitflex-topbtn:hover{background:#d4ef50;transform:translateY(-3px)}
@media(max-width:600px){#fitflex-topbtn{bottom:20px;right:20px;width:40px;height:40px}}
</style>

<button id="fitflex-topbtn" aria-label="Back to top">
<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#111" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
<polyline points="18 15 12 9 6 15"/>
</svg>
</button>

<script>
(function(){
var btn=document.getElementById('fitflex-topbtn');
window.addEventListener('scroll',function(){
btn.style.display=(window.scrollY>200)?'flex':'none';
});
btn.addEventListener('click',function(){
window.scrollTo({top:0,behavior:'smooth'});
});
})();
</script>