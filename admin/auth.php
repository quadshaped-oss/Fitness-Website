<?php
if(!isset($_COOKIE['admin'])){
echo '<script>location.replace("login.php")</script>';
exit;
}
?>