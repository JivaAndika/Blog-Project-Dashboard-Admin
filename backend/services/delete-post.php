<?php
require_once __DIR__ . "/../model/posts.php";
require_once  __DIR__ ."/../model/model.php";
$id = filter_input(INPUT_GET, 'id_post', FILTER_VALIDATE_INT);
if (!$id) {
    echo "<script>
    alert('Post yang anda cari tidak valid');
    window.location.href = '../pages/index-post.php';
    </script>";
    die;
}

$Posts = new Posts();
$result = $Posts->delete($id);

if (!$result) {
    echo "<script>
    alert('Gagal menghapus postingan');
    window.location.href = '../pages/index-post.php';
    </script>";
    die;
}

// Menampilkan SweetAlert
echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Delete Post</title>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
</head>
<body>
    <script>
    document.addEventListener('DOMContentLoaded', function(){
        Swal.fire({
            icon: 'success',
            title: 'Post berhasil dihapus',
            showConfirmButton: false,
            timer: 1500
        }).then(() => {
            window.location.href = '../pages/index-post.php';
        });
    });
    </script>
</body>
</html>";
?>