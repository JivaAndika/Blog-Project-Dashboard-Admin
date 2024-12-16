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




$limit = 3;
$pageActive = (isset($_GET['page'] ))  ? ( $_GET['page']) : 1;
$startData = $limit * $pageActive - $limit;
$length = count($Posts->all());
$countPage = ceil($length / $limit);
$num = ($pageActive - 1) * $limit + 1;
$Posts_detail = $Posts->all2($startData, $limit);

$prev = ($pageActive > 1) ? $pageActive - 1 : 1;
$next = ($pageActive < $countPage) ? $pageActive + 1 :$countPage ;

// var_dump($Posts_detail);

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Blank Page &mdash; Stisla</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="../dist/assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../dist/assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="../dist/assets/modules/prism/prism.js"></link>
  <!-- Template CSS -->
  <link rel="stylesheet" href="../dist/assets/css/style.css">
  <link rel="stylesheet" href="../dist/assets/css/components.css">
  <style>
  

  </style>
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

        <?= include "../components/layout/navbar.php" ?>

        <!-- Sidebar  -->
        
        <?= include "../components/layout/sidebar.php" ?>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Halaman kategori</h1>
          </div>
          <div class="section-body">  
          <div class="row">
  <?php foreach ($Posts_detail as $post): ?>
    <div class="col-md-4 col-sm-6 mb-4">
      <div class="card h-100">
        <img src="../assets/img/posts/<?= $post['attachment_post'] ?>" class="card-img-top " style="max-height: 200px; background-position: center; object-fit: ,  ;" alt="<?= $post['tittle'] ?>">
        <div class="card-body">
          <h5 class="card-title text-truncate" style="max-width: 200px; object-fit: contain;"> <?= $post['tittle'] ?> </h5>
          <p class="card-text">Author: <?= $post['full_name'] ?></p>
          <p class="card-text">Created at: <?= $post['created_at'] ?></p>
        </div>
        <div class="card-footer d-flex  justify-content-between">
          <button onclick='modalDetails("<?= $post["content"] ?>")'  class="btn btn-primary btn-sm">
            <i class="fas fa-info-circle"></i> Detail
          </button>
          <a href="edit-post.php?id_post=<?= $post['id_post'] ?>" class="btn btn-success btn-sm">
            <i class="far fa-edit"></i> Edit
          </a>
          <a href="../services/delete-post.php?id_post=<?= $post['id_post'] ?>" class="btn btn-danger btn-sm">
            <i class="fas fa-trash"></i> Delete
          </a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
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
       <?= include "../components/layout/footer.php"  ?>
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