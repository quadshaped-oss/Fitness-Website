<?php
require '../db.php';
require 'auth.php';

$edit_id = 0;
$edit_title = "";
$edit_description = "";
$edit_image = "";

function go($u)
{
    echo '<!DOCTYPE html><html><head><meta charset="utf-8"><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script></head><body><script>location.replace("' . $u . '");</script></body></html>';
    exit;
}

if (isset($_POST['add'])) {
    $t = $_POST['title'];
    $d = $_POST['description'];
    $f = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    $new = time() . '_' . $f;
    move_uploaded_file($tmp, "../files/" . $new);
    $stmt = $conn->prepare("INSERT INTO portfolio(image,title,description) VALUES(?,?,?)");
    $stmt->bind_param("sss", $new, $t, $d);
    $stmt->execute();
    go("portfolio.php?added=1");
}
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $t = $_POST['title'];
    $d = $_POST['description'];
    if ($_FILES['image']['name'] != "") {
        $q = $conn->query("SELECT image FROM portfolio WHERE id=$id");
        $r = $q->fetch_assoc();
        if (file_exists("../files/" . $r['image']))
            unlink("../files/" . $r['image']);
        $f = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        $new = time() . '_' . $f;
        move_uploaded_file($tmp, "../files/" . $new);
        $stmt = $conn->prepare("UPDATE portfolio SET image=?,title=?,description=? WHERE id=?");
        $stmt->bind_param("sssi", $new, $t, $d, $id);
    } else {
        $stmt = $conn->prepare("UPDATE portfolio SET title=?,description=? WHERE id=?");
        $stmt->bind_param("ssi", $t, $d, $id);
    }
    $stmt->execute();
    go("portfolio.php?updated=1");
}
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $q = $conn->query("SELECT image FROM portfolio WHERE id=$id");
    if ($q->num_rows) {
        $img = $q->fetch_assoc()['image'];
        if (file_exists("../files/" . $img))
            unlink("../files/" . $img);
    }
    $conn->query("DELETE FROM portfolio WHERE id=$id");
    go("portfolio.php?deleted=1");
}
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $q = $conn->query("SELECT * FROM portfolio WHERE id=$id");
    if ($q->num_rows) {
        $e = $q->fetch_assoc();
        $edit_id = $e['id'];
        $edit_title = $e['title'];
        $edit_description = $e['description'];
        $edit_image = $e['image'];
    }
}
$data = $conn->query("SELECT * FROM portfolio ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Portfolio</title>
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
                <span class="topbar-title">Portfolio</span>
            </div>
            <div class="page-content">
                <div class="page-header">
                    <h1>Portfolio</h1>
                    <p>Manage your portfolio projects and work samples</p>
                </div>
                <div class="card">
                    <div class="card-title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2"><?php echo $edit_id ? '<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>' : '<line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>'; ?></svg>
                        <?php echo $edit_id ? 'Edit Project' : 'Add Project'; ?>
                    </div>
                    <input type="hidden" id="f_id" value="<?php echo $edit_id; ?>">
                    <div class="form-group">
                        <label class="form-label">Project Image</label>
                        <div class="file-upload-area" onclick="document.getElementById('imgInput').click()">
                            <input type="file" id="imgInput" accept="image/*" style="display:none"
                                onchange="previewImg(this)">
                            <span class="file-upload-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.5">
                                    <rect x="3" y="3" width="18" height="18" rx="2" />
                                    <circle cx="8.5" cy="8.5" r="1.5" />
                                    <polyline points="21 15 16 10 5 21" />
                                </svg></span>
                            <div class="file-upload-text"><b>Click to upload</b> project image</div>
                        </div>
                        <div class="image-preview-box">
                            <img id="preview" class="image-preview"
                                src="<?php echo $edit_image != '' ? '../files/' . $edit_image : ''; ?>"
                                style="<?php echo $edit_image == '' ? 'display:none' : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Project Title</label>
                        <input type="text" id="f_title" class="form-control" placeholder="Project name"
                            value="<?php echo htmlspecialchars($edit_title); ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea id="f_desc" class="form-control" placeholder="Describe the project..."
                            required><?php echo htmlspecialchars($edit_description); ?></textarea>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-primary" onclick="submitForm()">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            <?php echo $edit_id == 0 ? 'Add Project' : 'Update Project'; ?>
                        </button>
                        <?php if ($edit_id) { ?><a href="portfolio.php" class="btn btn-secondary">Cancel</a><?php } ?>
                    </div>
                </div>

                <div class="card">
                    <div class="card-title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <rect x="2" y="7" width="20" height="14" rx="2" />
                            <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2" />
                        </svg>
                        All Projects
                    </div>
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $data->fetch_assoc()) { ?>
                                    <tr>
                                        <td><img class="table-img" src="../files/<?php echo $row['image']; ?>" alt=""></td>
                                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                                        <td
                                            style="color:var(--text-secondary);max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                                            <?php echo htmlspecialchars($row['description']); ?></td>
                                        <td>
                                            <div class="table-actions">
                                                <button class="btn-icon btn-edit"
                                                    onclick="location.replace('portfolio.php?edit=<?php echo $row['id']; ?>')"><svg
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
        function previewImg(input) { if (input.files[0]) { var img = document.getElementById('preview'); img.src = URL.createObjectURL(input.files[0]); img.style.display = 'block'; } }
        function submitForm() {
            var fd = new FormData();
            fd.append('title', document.getElementById('f_title').value);
            fd.append('description', document.getElementById('f_desc').value);
            var img = document.getElementById('imgInput');
            if (img.files[0]) fd.append('image', img.files[0]);
            var eid = document.getElementById('f_id').value;
            if (eid != '0' && eid != '') { fd.append('id', eid); fd.append('update', '1'); } else { fd.append('add', '1'); }
            fetch('portfolio.php', { method: 'POST', body: fd }).then(r => r.text()).then(t => { document.open(); document.write(t); document.close(); });
        }
        function del(id) {
            Swal.fire({ title: 'Delete this project?', icon: 'warning', showCancelButton: true, confirmButtonText: 'Delete', cancelButtonText: 'Cancel', confirmButtonColor: '#ef4444' }).then(r => { if (r.isConfirmed) location.replace('portfolio.php?delete=' + id); });
        }
<?php if (isset($_GET['added'])) { ?>Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Project Added', showConfirmButton: false, timer: 2000 }).then(() => { location.replace('portfolio.php') }); <?php } ?>
<?php if (isset($_GET['updated'])) { ?>Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Project Updated', showConfirmButton: false, timer: 2000 }).then(() => { location.replace('portfolio.php') }); <?php } ?>
<?php if (isset($_GET['deleted'])) { ?>Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Project Deleted', showConfirmButton: false, timer: 2000 }).then(() => { location.replace('portfolio.php') }); <?php } ?>
    </script>
</body>

</html>