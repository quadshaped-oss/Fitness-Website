<?php
require '../db.php';
require 'auth.php';

$edit_id = 0;
$edit_title = "";
$edit_info = "";

function go($u)
{
    echo '<!DOCTYPE html><html><head><meta charset="utf-8"><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script></head><body><script>location.replace("' . $u . '");</script></body></html>';
    exit;
}

function shortTitle($text)
{
    $words = explode(" ", $text);
    if (count($words) > 6) {
        return implode(" ", array_slice($words, 0, 6)) . "...";
    }
    return $text;
}

if (isset($_POST['add'])) {
    $t = $_POST['title'];
    $i = $_POST['info'];
    $stmt = $conn->prepare("INSERT INTO why(title,info) VALUES(?,?)");
    $stmt->bind_param("ss", $t, $i);
    $stmt->execute();
    go("why.php?added=1");
}
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $t = $_POST['title'];
    $i = $_POST['info'];
    $stmt = $conn->prepare("UPDATE why SET title=?,info=? WHERE id=?");
    $stmt->bind_param("ssi", $t, $i, $id);
    $stmt->execute();
    go("why.php?updated=1");
}
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM why WHERE id=$id");
    go("why.php?deleted=1");
}
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $q = $conn->query("SELECT * FROM why WHERE id=$id");
    if ($q->num_rows) {
        $e = $q->fetch_assoc();
        $edit_id = $e['id'];
        $edit_title = $e['title'];
        $edit_info = $e['info'];
    }
}
$data = $conn->query("SELECT * FROM why ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Why Us</title>
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
                <span class="topbar-title">Why Us</span>
            </div>
            <div class="page-content">
                <div class="page-header">
                    <h1>Why Choose Us</h1>
                    <p>Highlight your key advantages and selling points</p>
                </div>
                <div class="card">
                    <div class="card-title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M9 11l3 3L22 4" />
                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                        </svg>
                        <?php echo $edit_id ? 'Edit Point' : 'Add Point'; ?>
                    </div>
                    <input type="hidden" id="f_id" value="<?php echo $edit_id; ?>">
                    <div class="form-group">
                        <label class="form-label">Title</label>
                        <input type="text" id="f_title" class="form-control" placeholder="e.g. Expert Trainers"
                            value="<?php echo htmlspecialchars($edit_title); ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea id="f_info" class="form-control" placeholder="Explain why this point matters..."
                            required><?php echo htmlspecialchars($edit_info); ?></textarea>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-primary" onclick="submitForm()">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            <?php echo $edit_id == 0 ? 'Add Point' : 'Update Point'; ?>
                        </button>
                        <?php if ($edit_id) { ?><a href="why.php" class="btn btn-secondary">Cancel</a><?php } ?>
                    </div>
                </div>

                <div class="card">
                    <div class="card-title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <line x1="8" y1="6" x2="21" y2="6" />
                            <line x1="8" y1="12" x2="21" y2="12" />
                            <line x1="8" y1="18" x2="21" y2="18" />
                            <line x1="3" y1="6" x2="3.01" y2="6" />
                            <line x1="3" y1="12" x2="3.01" y2="12" />
                            <line x1="3" y1="18" x2="3.01" y2="18" />
                        </svg>
                        All Points
                    </div>
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $data->fetch_assoc()) { ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars(shortTitle($row['title'])); ?></strong></td>
                                        <td
                                            style="color:var(--text-secondary);max-width:240px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                                            <?php echo htmlspecialchars($row['info']); ?></td>
                                        <td>
                                            <div class="table-actions">
                                                <button class="btn-icon btn-edit"
                                                    onclick="location.replace('why.php?edit=<?php echo $row['id']; ?>')"><svg
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
        function submitForm() {
            var fd = new FormData();
            fd.append('title', document.getElementById('f_title').value);
            fd.append('info', document.getElementById('f_info').value);
            var eid = document.getElementById('f_id').value;
            if (eid != '0' && eid != '') { fd.append('id', eid); fd.append('update', '1'); } else { fd.append('add', '1'); }
            fetch('why.php', { method: 'POST', body: fd }).then(r => r.text()).then(t => { document.open(); document.write(t); document.close(); });
        }
        function del(id) {
            Swal.fire({ title: 'Delete this point?', icon: 'warning', showCancelButton: true, confirmButtonText: 'Delete', cancelButtonText: 'Cancel', confirmButtonColor: '#ef4444' }).then(r => { if (r.isConfirmed) location.replace('why.php?delete=' + id); });
        }
<?php if (isset($_GET['added'])) { ?>Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Point Added', showConfirmButton: false, timer: 2000 }).then(() => { location.replace('why.php') }); <?php } ?>
<?php if (isset($_GET['updated'])) { ?>Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Point Updated', showConfirmButton: false, timer: 2000 }).then(() => { location.replace('why.php') }); <?php } ?>
<?php if (isset($_GET['deleted'])) { ?>Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Point Deleted', showConfirmButton: false, timer: 2000 }).then(() => { location.replace('why.php') }); <?php } ?>
    </script>
</body>

</html>