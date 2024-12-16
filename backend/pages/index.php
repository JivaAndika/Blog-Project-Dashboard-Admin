<?php
require_once __DIR__ . "/../model/users.php";
require_once __DIR__ . "/../model/categories.php";
require_once __DIR__ . "/../model/tags.php";
require_once __DIR__ . "/../model/posts.php";
require_once __DIR__ . "/../model/model.php";

if (!isset($_SESSION['full_name'])){
  echo "<script>
  window.location.href = 'login.php';
  </script>";
  exit;
}

$Categories = new Categories();
$Tags = new Tags();
$Users = new Users();
$Posts = new Posts();
$CountCategory = count($Categories->all());
$CountTag = count($Tags->all());
$CountPosts = count($Posts->all());
$CountUsers = count($Users->all());
$show_tag = $Tags->show_tag();
$groupedTags = [];
foreach ($show_tag as $tag) {
    $groupedTags[$tag['post_id_pivot']][] = $tag['name_tag'];
}

$limit = 5;
$pageActive = (isset($_GET['page'] ))  ? ( $_GET['page']) : 1;
$startData = $limit * $pageActive - $limit;
$length = count($Posts->all());
$countPage = ceil($length / $limit);
$num = ($pageActive - 1) * $limit + 1;
$Posts_detail = $Posts->all2($startData, $limit);

$prev = ($pageActive > 1) ? $pageActive - 1 : 1;
$next = ($pageActive < $countPage) ? $pageActive + 1 :$countPage ;

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no"
      name="viewport"
    />
    <title>Ecommerce Dashboard &mdash; Stisla</title>
    <!-- General CSS Files -->
     
    <link
      rel="stylesheet"
      href="../dist/assets/modules/bootstrap/css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="../dist/assets/modules/fontawesome/css/all.min1.css"
    />
    <link
    rel="stylesheet"
    href="../dist/assets/modules/fontawesome/css/all.min.css"
    />
   

    <!-- CSS Libraries -->
    <link
      rel="stylesheet"
      href="../dist/assets/modules/jqvmap/dist/jqvmap.min.css"
    />
    <link
      rel="stylesheet"
      href="../dist/assets/modules/summernote/summernote-bs4.css"
    />
    <link
      rel="stylesheet"
      href="../dist/assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css"
    />
    <link
      rel="stylesheet"
      href="../dist/assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css"
    />

    <!-- Template CSS -->
    <link rel="stylesheet" href="../dist/assets/css/style.css" />
    <link rel="stylesheet" href="../dist/assets/css/components.css" />
    <!-- Start GA -->
    <script
      async
      src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"
    ></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag() {
        dataLayer.push(arguments);
      }
      gtag("js", new Date());

      gtag("config", "UA-94034622-3");
    </script>
    <!-- /END GA -->
  </head>

  <body>
    <div id="app">
      <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
        <!-- Navbar -->

        <?= include "./../components/layout/navbar.php" ?>

        <!-- Sidebar  -->
        
        <?= include "./../components/layout/sidebar.php" ?>

        <!-- Main Content -->
        <div class="main-content">
          <section class="section">
            <div class="row">
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                  <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-user"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4>Total Tag</h4>
                    </div>
                    <div class="card-body"><?= $CountTag ?></div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                  <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-user"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4>Total Kategori</h4>
                    </div>
                    <div class="card-body"><?= $CountCategory ?></div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                  <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-user"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4>Total Blog</h4>
                    </div>
                    <div class="card-body"><?= $CountPosts ?></div>
                  </div>
                </div>
              </div>

            
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Blog</h4>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive table-invoice">
                      <table class="table table-striped">
                        <tr>
                          <th>No</th>
                          <th>Judul Blog</th>
                          <th>Author</th>
                          <th>Tags</th>
                          <th>Category</th>
                        </tr>
                       <?php foreach($Posts_detail as $Posts) :?>
                        <tr>
                          <td><?= $num ?></td>
                          <td class="font-weight-600 text-truncate" style="max-width: 200px; "><?= $Posts['tittle'] ?></td>
                          <td><?= $Posts['full_name'] ?></td>
                          <td style="max-width: 200px; "><?= isset($groupedTags[$Posts['id_post']]) ? implode(', ', $groupedTags[$Posts['id_post']]) : 'No tags' ?></td>
                          <td>
                            <?= $Posts['category_id'] ?>
                          </td>
                        </tr>
                        <?php $num++ ?>
                        <?php endforeach; ?>
                      </table>
                    </div>
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
              </div>
          </section>
        </div>
       <!-- Footer -->
        <?= include "./../components/layout/footer.php"  ?>
      </div>
    </div>

    <!-- General JS Scripts -->
    <script src="../dist/assets/modules/jquery.min.js"></script>
    <script src="../dist/assets/modules/popper.js"></script>
    <script src="../dist/assets/modules/tooltip.js"></script>
    <script src="../dist/assets/modules/bootstrap/js/bootstrap.min.js"></script>
    <script src="../dist/assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="../dist/assets/modules/moment.min.js"></script>
    <script src="../dist/assets/js/stisla.js"></script>

    <!-- JS Libraies -->
    <script src="../dist/assets/modules/jquery.sparkline.min.js"></script>
    <script src="../dist/assets/modules/chart.min.js"></script>
    <script src="../dist/assets/modules/owlcarousel2/dist/owl.carousel.min.js"></script>
    <script src="../dist/assets/modules/summernote/summernote-bs4.js"></script>
    <script src="../dist/assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script>

    <!-- Page Specific JS File -->
    <script src="../dist/assets/js/page/index.js"></script>

    <!-- Template JS File -->
    <script src="../dist/assets/js/scripts.js"></script>
    <script src="../dist/assets/js/custom.js"></script>
  </body>
</html>
