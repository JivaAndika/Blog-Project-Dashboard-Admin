<?php
require_once __DIR__ . "/../model/tags.php";
require_once __DIR__ . "/../model/model.php";


if (!isset($_SESSION['full_name'])){
  echo "<script>
  window.location.href = 'login.php';
  </script>";
  exit;
}
$tags = new Tags();

$limit = 4;
$pageActive = (isset($_GET['page'] ))  ? ( $_GET['page']) : 1;
$startData = $limit * $pageActive - $limit;
$length = count($tags->all());
$countPage = ceil($length / $limit);
$num = ($pageActive - 1) * $limit + 1;
$tags = $tags->pagginate($startData, $limit);

$prev = ($pageActive > 1) ? $pageActive - 1 : 1;
$next = ($pageActive < $countPage) ? $pageActive + 1 :$countPage ;

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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        <?= include "../components/layout/navbar.php" ?>

        <!-- Sidebar  -->
        
        <?= include "../components/layout/sidebar.php" ?>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Halaman tag</h1>
          </div>
          <div class="section-body">  
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Home tag</h4>
                    <div class="card-header-form">
                      <form method="post" >
                        <div class="input-group">
                          <input type="text" class="form-control"  name="keyCat" id="keyCat" placeholder="Search">
                          <div class="input-group-btn">
                            <button class="btn btn-primary" ><i class="fas fa-search"></i></button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive" id="container">
                      <table class="table table-striped">
                        <tr>
                          <th>No</th>
                          <th>Nama tag</th>
                          <th>Action</th>
                        </tr>
                        <?php foreach($tags as $tag ):?>
                        <tr>
                          <td><?= $num ?> </td>
                          <td><?= $tag['name_tag'] ?></td>
                        
                          
                          <td>
                            <button href="#" onclick="modalDetails(<?= $tag['id_tag'] ?>, '<?= $tag['name_tag'] ?>') " class="btn btn-primary mr-1"><i class="fas fa-info-circle"></i> Detail</button>
                            <a href="edit-tag.php?id_tag=<?= $tag['id_tag'] ?>" class="btn btn-success mr-1"><i class="far fa-edit"></i> Edit</a>
                            <a href="../services/delete-tag.php?id_tag=<?= $tag['id_tag'] ?>" class="btn btn-danger mr-1"><i class="fas fa-trash"></i> Delete</a>
                        </td>
                        </tr>
                        <?php $num++ ?>

                        <?php endforeach ?>
                      </table>
                      <div class="d-flex justify-content-center"> 
                        <nav aria-label="Page navigation">
                          <ul class="pagination">
                            <li class="page-item ">
                              <?php if ($pageActive > 1):?>
                              <a class="page-link" href="?page=<?= $prev ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                              </a>
                              <?php endif;?>
                            </li>
                            <?php for ($i = 1; $i <= $countPage; $i++): ?>
                              <li class="page-item">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                              </li>
                              <?php endfor; ?>
                            <li class="page-item">
                              <?php if ($pageActive < $countPage):?>
                              <a class="page-link" href="?page=<?= $next ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                              </a>
                              <?php endif;?>
                            </li>
                          </ul>
                        </nav>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
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
                <h5 class="modal-title">Detail tag</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
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
      "./../search/search-tag.php?keyCat=" + $("#keyCat").val()
    );
  });
});


  function modalDetails(id,name){
      let content = '<ul>';
      content += `<li><strong>Id Tag: </strong>${id}</li>`;
      content += `<li><strong>Nama Tag: </strong>${name}</li>`;
      content += '</ul>';
      $('#detailModal .modal-body').html(content);
      $('#detailModal .modal-tittle').text('Detail Tag');
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
  

 
</body>
</html>