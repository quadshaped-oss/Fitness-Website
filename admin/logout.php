<?php
setcookie('admin', '', time() - 3600, '/');
echo '<!DOCTYPE html><html><head><script>location.replace("login.php")</script></head></html>';
exit;