<?php
require_once __DIR__ . "/../model/tags.php";
require_once  __DIR__ ."/../model/model.php";

$id = $_GET['id_tag'];
$Tags = new Tags();
$Tags = $Tags->delete($id);
if(!isset($id)){
    echo "<script>
    alert('Kategori yang anda cari tidak ditemukan');
    window.location.href = '../pages/index-tag.php';
    </script>";
    die;
}

header("Location: ../pages/index-tag.php");
exit();

