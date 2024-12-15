<?php
ob_start(); // Mulai output buffering
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

include(__DIR__ . '/../koneksi.php');
include(__DIR__ . '/template/header.php');

// Ambil daftar kategori
$query_kategori = "SELECT * FROM kategori ORDER BY nama ASC";
$result_kategori = $koneksi->query($query_kategori);

// Proses untuk menambahkan data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $gambar = $_FILES['gambar']['tmp_name'];
    $caption = $_POST['caption'];
    $status = $_POST['status'];
    $kategori_id = $_POST['kategori_id'];
    
    // Proses kategori baru jika dipilih
    if ($kategori_id == 'new' && !empty($_POST['kategori_baru'])) {
        $kategori_baru = $_POST['kategori_baru'];
        $stmt = $koneksi->prepare("INSERT INTO kategori (nama) VALUES (?)");
        $stmt->bind_param("s", $kategori_baru);
        $stmt->execute();
        $kategori_id = $koneksi->insert_id;
    }

    // Mengupload gambar
    $gambar_blob = file_get_contents($gambar);

    $query = "INSERT INTO mading (judul, gambar, caption, status, kategori_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("ssssi", $judul, $gambar_blob, $caption, $status, $kategori_id);
    
    if ($stmt->execute()) {
        header("Location: index.php?status=success");
        exit();
    } else {
        $error = "Gagal menambahkan data: " . $stmt->error;
    }
}

?>

<!-- Include Quill stylesheet -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Artikel /</span> Tambah Artikel</h4>

    <?php
    if (isset($error)) {
        echo "<div class='alert alert-danger'>$error</div>";
    }
    ?>

    <!-- Form Input -->
    <div class="card mb-4">
        <h5 class="card-header">Tambah Artikel Baru</h5>
        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data" id="articleForm">
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul</label>
                    <input type="text" class="form-control" id="judul" name="judul" required>
                </div>
                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar</label>
                    <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required>
                </div>
                <div class="mb-3">
                    <label for="caption" class="form-label">Caption</label>
                    <div id="editor" style="height: 300px;"></div>
                    <input type="hidden" name="caption" id="captionInput">
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="kategori" class="form-label">Kategori</label>
                    <select class="form-select" id="kategori" name="kategori_id" required>
                        <option value="">Pilih Kategori</option>
                        <?php while ($kategori = $result_kategori->fetch_assoc()): ?>
                            <option value="<?php echo $kategori['id']; ?>"><?php echo htmlspecialchars($kategori['nama']); ?></option>
                        <?php endwhile; ?>
                        <option value="new">+ Tambah Kategori Baru</option>
                    </select>
                </div>
                <div class="mb-3" id="kategoriBaruDiv" style="display:none;">
                    <label for="kategoriBaru" class="form-label">Nama Kategori Baru</label>
                    <input type="text" class="form-control" id="kategoriBaru" name="kategori_baru">
                </div>
                <button type="submit" class="btn btn-primary">Tambah Artikel</button>
            </form>
        </div>
    </div>
</div>
<!-- / Content -->

<!-- Include Quill library -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    var quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'align': [] }],
                ['link', 'image'],
                ['clean']
            ]
        }
    });

    document.getElementById('articleForm').onsubmit = function() {
        document.getElementById('captionInput').value = quill.root.innerHTML;
    };

    // Script untuk menampilkan/menyembunyikan input kategori baru
    document.getElementById('kategori').addEventListener('change', function() {
        const kategoriBaru = document.getElementById('kategoriBaruDiv');
        if (this.value === 'new') {
            kategoriBaru.style.display = 'block';
        } else {
            kategoriBaru.style.display = 'none';
        }
    });
</script>

<?php
include(__DIR__ . '/template/footer.php');
ob_end_flush();
?>
