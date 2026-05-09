<?php
require '../db.php';
if (isset($_COOKIE['admin'])) {
    echo '<!DOCTYPE html><html><head><script>location.replace("index.php")</script></head></html>';
    exit;
}
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT * FROM admin WHERE email=? AND password=? LIMIT 1");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $r = $stmt->get_result();
    if ($r->num_rows) {
        setcookie("admin", $email, time() + 86400 * 7, "/");
        echo '<!DOCTYPE html><html><head><script>location.replace("index.php")</script></head></html>';
        exit;
    } else {
        echo '<script>var err=1;</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="login-page">
        <div class="login-card">
            <div class="login-brand">
                <div class="login-brand-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                </div>
                <span class="login-brand-text">AdminPanel</span>
            </div>
            <h1 class="login-heading">Welcome back</h1>
            <p class="login-subheading">Sign in to your admin account</p>
            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="admin@example.com"
                    required autocomplete="email">
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="••••••••"
                    required autocomplete="current-password">
            </div>
            <div style="margin-top:6px">
                <button type="button" class="btn btn-primary" style="width:100%;justify-content:center"
                    onclick="doLogin()">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                        <polyline points="10 17 15 12 10 7" />
                        <line x1="15" y1="12" x2="3" y2="12" />
                    </svg>
                    Sign In
                </button>
            </div>
        </div>
    </div>
    <script>
        function doLogin() {
            var e = document.getElementById('email').value;
            var p = document.getElementById('password').value;
            if (!e || !p) { return; }
            var f = document.createElement('form');
            f.method = 'post';
            var fe = document.createElement('input'); fe.type = 'hidden'; fe.name = 'email'; fe.value = e;
            var fp = document.createElement('input'); fp.type = 'hidden'; fp.name = 'password'; fp.value = p;
            var fb = document.createElement('input'); fb.type = 'hidden'; fb.name = 'login'; fb.value = '1';
            f.appendChild(fe); f.appendChild(fp); f.appendChild(fb);
            document.body.appendChild(f); f.submit();
        }
        document.getElementById('password').addEventListener('keydown', function (e) { if (e.key === 'Enter') doLogin() });
        document.getElementById('email').addEventListener('keydown', function (e) { if (e.key === 'Enter') doLogin() });
        if (typeof err !== "undefined") {
            Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: 'Invalid credentials', showConfirmButton: false, timer: 2500 });
        }
    </script>
</body>

</html>