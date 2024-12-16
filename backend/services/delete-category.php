<?php
require_once __DIR__ . "/../model/categories.php";
require_once  __DIR__ ."/../model/model.php";

$id = $_GET['id_category'];
$Categories = new Categories();
$Categories = $Categories->delete($id);
if(!isset($id)){
    echo "<script>
    alert('Kategori yang anda cari tidak ditemukan');
    window.location.href = '../pages/index-category.php';
    </script>";
    die;
}

header("Location: ../pages/index-category.php");
exit();

