<?php
require '../db.php';
require 'auth.php';

$edit_id = 0;
$edit_video = "";

function go($u)
{
    echo '<!DOCTYPE html><html><head><meta charset="utf-8"><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script></head><body><script>location.replace("' . $u . '");</script></body></html>';
    exit;
}

function vid($url)
{
    if (preg_match('/(youtu\.be\/|v=|embed\/)([a-zA-Z0-9_-]{11})/', $url, $m)) {
        return $m[2];
    }
    return $url;
}

if (isset($_POST['add'])) {
    $id = vid($_POST['video']);
    $stmt = $conn->prepare("INSERT INTO videos(video_id) VALUES(?)");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    go("videos.php?added=1");
}
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $vid = vid($_POST['video']);
    $stmt = $conn->prepare("UPDATE videos SET video_id=? WHERE id=?");
    $stmt->bind_param("si", $vid, $id);
    $stmt->execute();
    go("videos.php?updated=1");
}
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM videos WHERE id=$id");
    go("videos.php?deleted=1");
}
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $q = $conn->query("SELECT * FROM videos WHERE id=$id");
    if ($q->num_rows) {
        $r = $q->fetch_assoc();
        $edit_id = $r['id'];
        $edit_video = $r['video_id'];
    }
}
$data = $conn->query("SELECT * FROM videos ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Videos</title>
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
                <span class="topbar-title">Videos</span>
            </div>
            <div class="page-content">
                <div class="page-header">
                    <h1>Videos</h1>
                    <p>Add YouTube videos to display on your website</p>
                </div>
                <div class="card">
                    <div class="card-title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <polygon points="23 7 16 12 23 17 23 7" />
                            <rect x="1" y="5" width="15" height="14" rx="2" />
                        </svg>
                        <?php echo $edit_id ? 'Edit Video' : 'Add Video'; ?>
                    </div>
                    <input type="hidden" id="f_id" value="<?php echo $edit_id; ?>">
                    <div class="form-group">
                        <label class="form-label">YouTube URL or Video ID</label>
                        <div style="display:flex;gap:8px">
                            <input type="text" id="f_video" class="form-control"
                                placeholder="https://youtube.com/watch?v=..."
                                value="<?php echo htmlspecialchars($edit_video); ?>" required>
                            <button type="button" class="btn btn-secondary" onclick="previewVideo()"
                                style="white-space:nowrap;flex-shrink:0">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <polygon points="5 3 19 12 5 21 5 3" />
                                </svg>
                                Preview
                            </button>
                        </div>
                    </div>
                    <div class="video-preview-box" id="previewBox" style="display:none;margin-bottom:14px">
                        <iframe id="previewFrame" src="" allowfullscreen></iframe>
                    </div>
                    <?php if ($edit_id) { ?>
                        <div class="video-preview-box" style="margin-bottom:14px">
                            <iframe
                                src="https://www.youtube-nocookie.com/embed/<?php echo htmlspecialchars($edit_video); ?>"
                                allowfullscreen></iframe>
                        </div>
                    <?php } ?>
                    <div class="form-actions">
                        <button type="button" class="btn btn-primary" onclick="submitForm()">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            <?php echo $edit_id == 0 ? 'Add Video' : 'Update Video'; ?>
                        </button>
                        <?php if ($edit_id) { ?><a href="videos.php" class="btn btn-secondary">Cancel</a><?php } ?>
                    </div>
                </div>

                <div class="card">
                    <div class="card-title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <polygon points="23 7 16 12 23 17 23 7" />
                            <rect x="1" y="5" width="15" height="14" rx="2" />
                        </svg>
                        All Videos
                    </div>
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Preview</th>
                                    <th>Video ID</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $data->fetch_assoc()) { ?>
                                    <tr>
                                        <td>
                                            <div
                                                style="width:160px;aspect-ratio:16/9;overflow:hidden;border-radius:6px;border:1px solid var(--border);background:#000">
                                                <iframe width="160" height="90"
                                                    src="https://www.youtube-nocookie.com/embed/<?php echo htmlspecialchars($row['video_id']); ?>"
                                                    allowfullscreen style="border:none;display:block"></iframe>
                                            </div>
                                        </td>
                                        <td style="color:var(--text-secondary);font-family:monospace;font-size:0.85rem">
                                            <?php echo htmlspecialchars($row['video_id']); ?></td>
                                        <td>
                                            <div class="table-actions">
                                                <button class="btn-icon btn-edit"
                                                    onclick="location.replace('videos.php?edit=<?php echo $row['id']; ?>')"><svg
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
        function getId(url) { var m = url.match(/(youtu\.be\/|v=|embed\/)([a-zA-Z0-9_-]{11})/); return m ? m[2] : url; }
        function previewVideo() {
            var id = getId(document.getElementById('f_video').value);
            document.getElementById('previewFrame').src = 'https://www.youtube-nocookie.com/embed/' + id;
            document.getElementById('previewBox').style.display = 'block';
        }
        function submitForm() {
            var fd = new FormData();
            fd.append('video', document.getElementById('f_video').value);
            var eid = document.getElementById('f_id').value;
            if (eid != '0' && eid != '') { fd.append('id', eid); fd.append('update', '1'); } else { fd.append('add', '1'); }
            fetch('videos.php', { method: 'POST', body: fd }).then(r => r.text()).then(t => { document.open(); document.write(t); document.close(); });
        }
        function del(id) {
            Swal.fire({ title: 'Delete this video?', icon: 'warning', showCancelButton: true, confirmButtonText: 'Delete', cancelButtonText: 'Cancel', confirmButtonColor: '#ef4444' }).then(r => { if (r.isConfirmed) location.replace('videos.php?delete=' + id); });
        }
<?php if (isset($_GET['added'])) { ?>Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Video Added', showConfirmButton: false, timer: 2000 }).then(() => { location.replace('videos.php') }); <?php } ?>
<?php if (isset($_GET['updated'])) { ?>Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Video Updated', showConfirmButton: false, timer: 2000 }).then(() => { location.replace('videos.php') }); <?php } ?>
<?php if (isset($_GET['deleted'])) { ?>Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Video Deleted', showConfirmButton: false, timer: 2000 }).then(() => { location.replace('videos.php') }); <?php } ?>
    </script>
</body>

</html>