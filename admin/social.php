<?php
require '../db.php';
require 'auth.php';

$id = 0;
$facebook = "";
$youtube = "";
$x = "";
$instagram = "";

$q = $conn->query("SELECT * FROM social LIMIT 1");
if ($q->num_rows) {
    $r = $q->fetch_assoc();
    $id = $r['id'];
    $facebook = $r['facebook_url'];
    $youtube = $r['youtube_url'];
    $x = $r['x_url'];
    $instagram = $r['instagram_url'];
}

function go($u)
{
    echo '<!DOCTYPE html><html><head><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script></head><body><script>location.replace("' . $u . '");</script></body></html>';
    exit;
}

if (isset($_POST['add'])) {
    $f = $_POST['facebook'] ?? "";
    $y = $_POST['youtube'] ?? "";
    $xurl = $_POST['x'] ?? "";
    $i = $_POST['instagram'] ?? "";
    $stmt = $conn->prepare("INSERT INTO social(facebook_url,youtube_url,x_url,instagram_url) VALUES(?,?,?,?)");
    $stmt->bind_param("ssss", $f, $y, $xurl, $i);
    $stmt->execute();
    go("social.php?added=1");
}
if (isset($_POST['update'])) {
    $f = $_POST['facebook'] ?? "";
    $y = $_POST['youtube'] ?? "";
    $xurl = $_POST['x'] ?? "";
    $i = $_POST['instagram'] ?? "";
    $stmt = $conn->prepare("UPDATE social SET facebook_url=?,youtube_url=?,x_url=?,instagram_url=? WHERE id=?");
    $stmt->bind_param("ssssi", $f, $y, $xurl, $i, $id);
    $stmt->execute();
    go("social.php?updated=1");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Social Links</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="admin-layout">
        <?php include 'sidebar.php'; ?>
        <div class="main-content">
            <div class="topbar">
                <button class="topbar-menu-btn" onclick="openSidebar()">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <circle cx="12" cy="5" r="1" />
                        <circle cx="12" cy="12" r="1" />
                        <circle cx="12" cy="19" r="1" />
                    </svg>
                </button>
                <span class="topbar-title">Social Links</span>
            </div>
            <div class="page-content">
                <div class="page-header">
                    <h1>Social Links</h1>
                    <p>Manage your social media profile URLs</p>
                </div>
                <div class="card">
                    <div class="card-title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="18" cy="5" r="3" />
                            <circle cx="6" cy="12" r="3" />
                            <circle cx="18" cy="19" r="3" />
                            <line x1="8.59" y1="13.51" x2="15.42" y2="17.49" />
                            <line x1="15.41" y1="6.51" x2="8.59" y2="10.49" />
                        </svg>
                        Profiles
                    </div>
                    <div class="form-group">
                        <label class="form-label">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" style="display:inline;margin-right:4px">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                            </svg>
                            Facebook URL
                        </label>
                        <input type="url" id="f_fb" class="form-control" placeholder="https://facebook.com/yourpage"
                            value="<?php echo htmlspecialchars($facebook); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" style="display:inline;margin-right:4px">
                                <path
                                    d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 0 0-1.95 1.96A29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58A2.78 2.78 0 0 0 3.41 19.54C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 0 0 1.95-1.96A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z" />
                                <polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" />
                            </svg>
                            YouTube URL
                        </label>
                        <input type="url" id="f_yt" class="form-control" placeholder="https://youtube.com/@yourchannel"
                            value="<?php echo htmlspecialchars($youtube); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" style="display:inline;margin-right:4px">
                                <path d="M4 4l16 16M4 20L20 4" />
                            </svg>
                            X (Twitter) URL
                        </label>
                        <input type="url" id="f_x" class="form-control" placeholder="https://x.com/yourhandle"
                            value="<?php echo htmlspecialchars($x); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" style="display:inline;margin-right:4px">
                                <rect x="2" y="2" width="20" height="20" rx="5" />
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5" />
                            </svg>
                            Instagram URL
                        </label>
                        <input type="url" id="f_ig" class="form-control" placeholder="https://instagram.com/yourprofile"
                            value="<?php echo htmlspecialchars($instagram); ?>">
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-primary" onclick="submitForm()">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            <?php echo $id == 0 ? 'Save' : 'Update'; ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        function submitForm() {
            var fd = new FormData();
            fd.append('facebook', document.getElementById('f_fb').value);
            fd.append('youtube', document.getElementById('f_yt').value);
            fd.append('x', document.getElementById('f_x').value);
            fd.append('instagram', document.getElementById('f_ig').value);
<?php if ($id == 0) { ?>fd.append('add', '1');<?php } else { ?>fd.append('update', '1'); <?php } ?>
            fetch('social.php', { method: 'POST', body: fd }).then(r => r.text()).then(t => { document.open(); document.write(t); document.close(); });
        }
<?php if (isset($_GET['added'])) { ?>Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Social Links Saved', showConfirmButton: false, timer: 2000 }).then(() => { location.replace('social.php') }); <?php } ?>
<?php if (isset($_GET['updated'])) { ?>Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Social Links Updated', showConfirmButton: false, timer: 2000 }).then(() => { location.replace('social.php') }); <?php } ?>
    </script>
</body>

</html>