<?php
require '../db.php';
require 'auth.php';

$id = 0;
$members = "";
$classes = "";
$trainers = "";
$satisfaction = "";

$q = $conn->query("SELECT * FROM details LIMIT 1");
if ($q->num_rows) {
    $r = $q->fetch_assoc();
    $id = $r['id'];
    $members = $r['members'];
    $classes = $r['classes'];
    $trainers = $r['trainers'];
    $satisfaction = $r['satisfaction'];
}

function go($u)
{
    echo '<!DOCTYPE html><html><head><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script></head><body><script>location.replace("' . $u . '");</script></body></html>';
    exit;
}

if (isset($_POST['add'])) {
    $m = $_POST['members'];
    $c = $_POST['classes'];
    $t = $_POST['trainers'];
    $s = $_POST['satisfaction'];
    $stmt = $conn->prepare("INSERT INTO details(members,classes,trainers,satisfaction) VALUES(?,?,?,?)");
    $stmt->bind_param("iiii", $m, $c, $t, $s);
    $stmt->execute();
    go("details.php?added=1");
}
if (isset($_POST['update'])) {
    $m = $_POST['members'];
    $c = $_POST['classes'];
    $t = $_POST['trainers'];
    $s = $_POST['satisfaction'];
    $stmt = $conn->prepare("UPDATE details SET members=?,classes=?,trainers=?,satisfaction=? WHERE id=?");
    $stmt->bind_param("iiiii", $m, $c, $t, $s, $id);
    $stmt->execute();
    go("details.php?updated=1");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Details</title>
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
                <span class="topbar-title">Details</span>
            </div>
            <div class="page-content">
                <div class="page-header">
                    <h1>Stats &amp; Details</h1>
                    <p>Update your key statistics shown on the website</p>
                </div>
                <div class="card">
                    <div class="card-title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <line x1="18" y1="20" x2="18" y2="10" />
                            <line x1="12" y1="20" x2="12" y2="4" />
                            <line x1="6" y1="20" x2="6" y2="14" />
                        </svg>
                        Statistics
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Total Members</label>
                            <input type="number" id="f_members" class="form-control" placeholder="1000"
                                value="<?php echo htmlspecialchars($members); ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Classes Offered</label>
                            <input type="number" id="f_classes" class="form-control" placeholder="50"
                                value="<?php echo htmlspecialchars($classes); ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Trainers</label>
                            <input type="number" id="f_trainers" class="form-control" placeholder="20"
                                value="<?php echo htmlspecialchars($trainers); ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Satisfaction %</label>
                            <input type="number" id="f_satisfaction" class="form-control" placeholder="98" min="0"
                                max="100" value="<?php echo htmlspecialchars($satisfaction); ?>" required>
                        </div>
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
            fd.append('members', document.getElementById('f_members').value);
            fd.append('classes', document.getElementById('f_classes').value);
            fd.append('trainers', document.getElementById('f_trainers').value);
            fd.append('satisfaction', document.getElementById('f_satisfaction').value);
<?php if ($id == 0) { ?>fd.append('add', '1');<?php } else { ?>fd.append('update', '1'); <?php } ?>
            fetch('details.php', { method: 'POST', body: fd }).then(r => r.text()).then(t => { document.open(); document.write(t); document.close(); });
        }
<?php if (isset($_GET['added'])) { ?>Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Details Saved', showConfirmButton: false, timer: 2000 }).then(() => { location.replace('details.php') }); <?php } ?>
<?php if (isset($_GET['updated'])) { ?>Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Details Updated', showConfirmButton: false, timer: 2000 }).then(() => { location.replace('details.php') }); <?php } ?>
    </script>
</body>

</html>