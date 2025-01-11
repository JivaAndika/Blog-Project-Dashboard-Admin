<?php
require_once __DIR__ . "/../model/posts.php";
require_once __DIR__ . "/../model/users.php";
require_once __DIR__ . "/../model/tags.php";
require_once __DIR__ . "/../model/model.php";


if (!isset($_SESSION['full_name'])){
  echo "<script>
  window.location.href = 'login.php';
  </script>";
  exit;
}
$Users = new Users();
$Posts = new Posts();
$Tags = new Tags();
$show_tag = $Tags->show_tag();
$groupedTags = [];
foreach ($show_tag as $tag) {
    $groupedTags[$tag['post_id_pivot']][] = $tag['name_tag'];
}
$id = $_SESSION['id'];
$role = $_SESSION['roles'];



$limit = 3;
$pageActive = (isset($_GET['page'] ))  ? ( $_GET['page']) : 1;
$startData = $limit * $pageActive - $limit;
if (in_array($role, ['admin', 'user'])){
  $length = count($Posts->all());
}
if (in_array($role, ['author'])){
  $length = count($Posts->SelectPostAsAuthor($id));
}
$countPage = ceil($length / $limit);
$num = ($pageActive - 1) * $limit + 1;
$Posts_detail = $Posts->all2($startData, $limit);
$postAsAuthor = $Posts->SelectPostAsRole($id,$startData, $limit);

$prev = ($pageActive > 1) ? $pageActive - 1 : 1;
$next = ($pageActive < $countPage) ? $pageActive + 1 :$countPage ;


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Admin dashboard &mdash; Blog</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="../dist/assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../dist/assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="../dist/assets/modules/prism/prism.js"></link>
  <!-- Template CSS -->
  <link rel="stylesheet" href="../dist/assets/css/style.css">
  <link rel="stylesheet" href="../dist/assets/css/components.css">
  
<!-- Start GA -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-94034622-3');
</script>
<!-- /END GA --></head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
        <!-- Navbar -->
        <div class="navbar-bg"></div>

        <?php include "../components/layout/navbar.php" ?>

        <!-- Sidebar  -->
        
        <?php include "../components/layout/sidebar.php" ?>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
          <?php if (in_array($role, ['admin', 'user'])) : ?>
            <h1>Halaman Post</h1>
            <?php endif;?>
            <?php if (in_array($role, ['author'])) : ?>
              <h1>My Post</h1>
            <?php endif;?>
          </div>
          <div class="section-body">  
          <div class="row">
          <table class="table table-striped">
  <tr>
    <th>No</th>
    <th style="width: 250px;">Judul Post</th>
    <th>Gambar </th>
    <th>Author</th>
    <?php if (in_array($role, ['admin', 'author'])) : ?>
    <th>Action</th>
    <?php endif; ?>
  </tr>
  <?php if(in_array($role, haystack: ['admin', 'user'])) :?>
    <?php foreach ($Posts_detail as $post): ?>
  <tr>
    <td><?= $num ?></td>
    <td ><?= $post['tittle'] ?></td>
    <td>
      <img src="../assets/img/posts/<?= $post['attachment_post'] ?>" alt="image post" width="80" class="my-3">
    </td>
    <td><?= $post['full_name'] ?></td>
    <?php if ($_SESSION['roles'] === 'admin') : ?>
                          <td>
                            <a href="edit-post.php?id_post=<?= $post['id_post'] ?>" class="btn btn-success mr-1"><i class="far fa-edit"></i> Edit</a>
                            <a href="../services/delete-post.php?id_post=<?= $post['id_post'] ?>" class="btn btn-danger mr-1"><i class="fas fa-trash"></i> Delete</a>
                        </td>
                        <?php endif; ?>
  </tr>
  <?php $num++; ?>
  <?php endforeach; ?>
  <?php endif; ?>
  <?php if($_SESSION['roles'] === 'author' ) :?>
  <?php foreach ($postAsAuthor as $post): ?>
  <tr>
    <td><?= $num ?></td>
    <td class="w-20"><?= $post['tittle'] ?></td>
    <td>
      <img src="../assets/img/posts/<?= $post['attachment_post'] ?>" alt="image post" width="80" class="my-3">
    </td>
    <td><?= $post['full_name'] ?></td>
                          <td>
                            <a href="edit-post.php?id_post=<?= $post['id_post'] ?>" class="btn btn-success mr-1"><i class="far fa-edit"></i> Edit</a>
                            <a href="../services/delete-post.php?id_post=<?= $post['id_post'] ?>" class="btn btn-danger mr-1"><i class="fas fa-trash"></i> Delete</a>
                        </td>
  </tr>
  <?php $num++; ?>
  <?php endforeach; ?>
  <?php endif; ?>
</table>

</div>

<div class="d-flex justify-content-center mt-4"> 
  <nav aria-label="Page navigation">
    <ul class="pagination">
      <li class="page-item">
        <?php if ($pageActive > 1): ?>
        <a class="page-link" href="?page=<?= $prev ?>" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
        <?php endif; ?>
      </li>
      <?php for ($i = 1; $i <= $countPage; $i++): ?>
        <li class="page-item<?= ($i == $pageActive) ? ' active' : '' ?>">
          <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
        </li>
      <?php endfor; ?>
      <li class="page-item">
        <?php if ($pageActive < $countPage): ?>
        <a class="page-link" href="?page=<?= $next ?>" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
        <?php endif; ?>
      </li>
    </ul>
  </nav>
</div>

          </div>
        </section>
      </div>
       <!-- Footer -->
       <?php include "../components/layout/footer.php"  ?>
    </div>
    <!-- Modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="detailModal">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Detail Post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body ">
                <!-- <p>Modal body text goes here.</p> -->
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
  </div>
  <!-- General JS Scripts -->
  <script src="../js/jquery.js"></script>
  <script >
    $(document).ready(function () {
  $("#keyCat").on("keyup", function () {
    $("#container").load(
      "./../search/search-post.php?keyCat=" + $("#keyCat").val()
    );
  });
});

  function modalDetails(desc){
      let content = '<ul >';
      content += `<li><strong>Isi konten: </strong><br>${desc}</li>`;
      content += '</ul>'; 
      $('#detailModal .modal-body').html(content);
      $('#detailModal .modal-tittle').text('Detail Kategori');
      $('#detailModal').modal('show');
      
    }
 

  </script>
  <script src="../js/jquery.js"></script>
  <script src="../dist/assets/modules/jquery.min.js"></script>
  <script src="../dist/assets/modules/popper.js"></script>
  <script src="../dist/assets/modules/tooltip.js"></script>
  <script src="../dist/assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="../dist/assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="../dist/assets/modules/moment.min.js"></script>
  <script src="../dist/assets/js/stisla.js"></script>
  
  <!-- JS Libraies -->
  <script src="../dist/assets/modules/prism/prism.js"></script>

  <!-- Page Specific JS File -->
  <script src="../dist/assets/js/page/bootstrap-modal.js"></script>
  
  <!-- Template JS File -->
  <script src="../dist/assets/js/scripts.js"></script>
  <script src="../dist/assets/js/custom.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 
</body>
</html>