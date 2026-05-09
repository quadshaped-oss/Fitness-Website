<?php
require '../db.php';
require 'auth.php';

$edit_id = 0;
$edit_type = "";
$edit_price = "";
$edit_period = "";
$edit_features = [];

function go($u)
{
    echo '<!DOCTYPE html><html><head><meta charset="utf-8"><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script></head><body><script>location.replace("' . $u . '");</script></body></html>';
    exit;
}

if (isset($_POST['add'])) {
    $type = $_POST['plan_type'];
    $price = $_POST['price'];
    $period = $_POST['period'];
    $features = json_encode($_POST['features'] ?? []);
    $stmt = $conn->prepare("INSERT INTO plans(plan_type,price,period,features) VALUES(?,?,?,?)");
    $stmt->bind_param("ssss", $type, $price, $period, $features);
    $stmt->execute();
    go("plans.php?added=1");
}
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $type = $_POST['plan_type'];
    $price = $_POST['price'];
    $period = $_POST['period'];
    $features = json_encode($_POST['features'] ?? []);
    $stmt = $conn->prepare("UPDATE plans SET plan_type=?,price=?,period=?,features=? WHERE id=?");
    $stmt->bind_param("ssssi", $type, $price, $period, $features, $id);
    $stmt->execute();
    go("plans.php?updated=1");
}
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM plans WHERE id=$id");
    go("plans.php?deleted=1");
}
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $q = $conn->query("SELECT * FROM plans WHERE id=$id");
    if ($q->num_rows) {
        $r = $q->fetch_assoc();
        $edit_id = $r['id'];
        $edit_type = $r['plan_type'];
        $edit_price = $r['price'];
        $edit_period = $r['period'];
        $edit_features = json_decode($r['features'], true);
    }
}
$data = $conn->query("SELECT * FROM plans ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Plans</title>
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
                <span class="topbar-title">Plans</span>
            </div>
            <div class="page-content">
                <div class="page-header">
                    <h1>Pricing Plans</h1>
                    <p>Create and manage subscription or service plans</p>
                </div>
                <div class="card">
                    <div class="card-title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2"><?php echo $edit_id ? '<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>' : '<line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>'; ?></svg>
                        <?php echo $edit_id ? 'Edit Plan' : 'Add Plan'; ?>
                    </div>
                    <input type="hidden" id="f_id" value="<?php echo $edit_id; ?>">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Plan Type</label>
                            <input type="text" id="f_type" class="form-control" placeholder="e.g. Basic, Pro, Premium"
                                value="<?php echo htmlspecialchars($edit_type); ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Price</label>
                            <input type="text" id="f_price" class="form-control" placeholder="e.g. ₹999"
                                value="<?php echo htmlspecialchars($edit_price); ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Billing Period</label>
                        <input type="text" id="f_period" class="form-control" placeholder="e.g. per month, per year"
                            value="<?php echo htmlspecialchars($edit_period); ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Features</label>
                        <div id="features" class="features-list">
                            <?php if (!empty($edit_features)) {
                                foreach ($edit_features as $f) {
                                    echo '<div class="feature-item"><input type="text" class="form-control" placeholder="Feature..." value="' . htmlspecialchars($f) . '"><button type="button" class="btn-icon btn-delete" onclick="this.parentNode.remove()"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button></div>';
                                }
                            } ?>
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm" style="margin-top:8px"
                            onclick="addFeature()">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5">
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                            Add Feature
                        </button>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-primary" onclick="submitForm()">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            <?php echo $edit_id == 0 ? 'Add Plan' : 'Update Plan'; ?>
                        </button>
                        <?php if ($edit_id) { ?><a href="plans.php" class="btn btn-secondary">Cancel</a><?php } ?>
                    </div>
                </div>

                <div class="card">
                    <div class="card-title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <line x1="12" y1="1" x2="12" y2="23" />
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                        </svg>
                        All Plans
                    </div>
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Plan</th>
                                    <th>Price</th>
                                    <th>Period</th>
                                    <th>Features</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $data2 = $conn->query("SELECT * FROM plans ORDER BY id DESC");
                                while ($row = $data2->fetch_assoc()) {
                                    $feats = json_decode($row['features'], true); ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($row['plan_type']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($row['price']); ?></td>
                                        <td style="color:var(--text-secondary)">
                                            <?php echo htmlspecialchars($row['period']); ?></td>
                                        <td><span class="badge badge-blue"><?php echo count($feats); ?> features</span></td>
                                        <td>
                                            <div class="table-actions">
                                                <button class="btn-icon btn-edit"
                                                    onclick="location.replace('plans.php?edit=<?php echo $row['id']; ?>')"><svg
                                                        width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2">
                                                        <path
                                                            d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                    </svg></button>
                                                <button class="btn-icon btn-delete"
                                                    onclick="del(<?php echo $row['id']; ?>)"><svg width="14" height="14"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2">
                                                        <polyline points="3 6 5 6 21 6" />
                                                        <path d="M19 6l-1 14H6L5 6" />
                                                        <path d="M10 11v6" />
                                                        <path d="M14 11v6" />
                                                        <path d="M9 6V4h6v2" />
                                                    </svg></button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        function addFeature() {
            var div = document.createElement('div'); div.className = 'feature-item';
            div.innerHTML = '<input type="text" class="form-control" placeholder="Feature..."><button type="button" class="btn-icon btn-delete" onclick="this.parentNode.remove()"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>';
            document.getElementById('features').appendChild(div);
        }
        function submitForm() {
            var fd = new FormData();
            fd.append('plan_type', document.getElementById('f_type').value);
            fd.append('price', document.getElementById('f_price').value);
            fd.append('period', document.getElementById('f_period').value);
            document.querySelectorAll('#features .feature-item input').forEach(function (inp) { fd.append('features[]', inp.value); });
            var eid = document.getElementById('f_id').value;
            if (eid != '0' && eid != '') { fd.append('id', eid); fd.append('update', '1'); } else { fd.append('add', '1'); }
            fetch('plans.php', { method: 'POST', body: fd }).then(r => r.text()).then(t => { document.open(); document.write(t); document.close(); });
        }
        function del(id) {
            Swal.fire({ title: 'Delete this plan?', icon: 'warning', showCancelButton: true, confirmButtonText: 'Delete', cancelButtonText: 'Cancel', confirmButtonColor: '#ef4444' }).then(r => { if (r.isConfirmed) location.replace('plans.php?delete=' + id); });
        }
<?php if (isset($_GET['added'])) { ?>Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Plan Added', showConfirmButton: false, timer: 2000 }).then(() => { location.replace('plans.php') }); <?php } ?>
<?php if (isset($_GET['updated'])) { ?>Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Plan Updated', showConfirmButton: false, timer: 2000 }).then(() => { location.replace('plans.php') }); <?php } ?>
<?php if (isset($_GET['deleted'])) { ?>Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Plan Deleted', showConfirmButton: false, timer: 2000 }).then(() => { location.replace('plans.php') }); <?php } ?>
    </script>
</body>

</html>