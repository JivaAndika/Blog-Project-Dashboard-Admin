<?php
require_once __DIR__ . "/../Model/Categories.php";
require_once  __DIR__ ."/../Model/Model.php";

if (!isset($_SESSION['full_name'])){
    echo "<script>
    alert('Gagal login');
    window.location.href = 'login.php';
    </script>";
    die;
  }

if(isset($_POST['submit'])){
    $datas = [
        "post" => $_POST,
        "files" => $_FILES
    ];
   

    if(strlen($_POST['name_category']) > 225){
        echo "<script>
               alert('Karakter yang anda inputkan lebih dari 225');
                window.location.href = 'create-category.php';
              </script>";
              die;
    }
    
    $Categories = new Categories(); 
    $result = $Categories->create($datas);
   if($result !== false){
    $name_category = $_POST['name_category'];
    echo "<script>
    alert('Kategori baru ditambahkan dengan nama {$name_category}');
    window.location.href = 'index-category.php';
    </script>";
}

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta
        content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no"
        name="viewport" />
    <title>Ecommerce Dashboard &mdash; Stisla</title>
    

    <!-- General CSS Files -->
    <link
        rel="stylesheet"
        href="../dist/assets/modules/bootstrap/css/bootstrap.min.css" />
    <link
        rel="stylesheet"
        href="../dist/assets/modules/fontawesome/css/all.min.css" />

    <!-- CSS Libraries -->
    <link
        rel="stylesheet"
        href="../dist/assets/modules/jqvmap/dist/jqvmap.min.css" />
    <link
        rel="stylesheet"
        href="../dist/assets/modules/summernote/summernote-bs4.css" />
    <link
        rel="stylesheet"
        href="../dist/assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css" />
    <link
        rel="stylesheet"
        href="../dist/assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css" />

    <!-- Template CSS -->
    <link rel="stylesheet" href="../dist/assets/css/style.css" />
    <link rel="stylesheet" href="../dist/assets/css/components.css" />
    <!-- Start GA -->
    <script
        async
        src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
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
            <!-- NAV -->
            <?php include '../components/layout/navbar.php' ?>
            <!--SIDEBAR -->
            <?php include '../components/layout/sidebar.php' ?>
            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Tambah kategori</h1>
                    </div>

                    <div class="section-body">

                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6 d-flex align-items-center w-25">
                                <div class="img-fluid">
                                <img src="./../assets/img/list.gif" alt="" class="img-fluid w-100 w-md-75 w-lg-50">
                                </div>
                            </div>
                      
                            <div class="col-12 col-md-6 col-lg-6 d-flex align-items-center w-full">
                                <div class="card w-full col-12">
                                    <div class="card-body">
                                        <h4>Input Kategori</h4>
                                    </div>
                                    <form class="card-body" method="post" action="" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="name_category">Nama Kategori</label>
                                          <input type="text" name="name_category" class="form-control ">
                                        </div>
                                        <div class="form-group">
                                            <label  class="form-control-label">Gambar</label>
                                            <div>
                                                <div class="custom-file">
                                                    <input type="file" name="attachment_category" class="custom-file-input" id="attachment_category">
                                                    <label for="attachment_category" class="custom-file-label">Choose File</label>
                                                </div>
                                                <div class="form-text text-muted">The image must have a maximum size of 1MB</div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-primary " name="submit" id="submit">Tambahkan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                </section>
            </div>




            <!-- FOOTER -->
            <?php include '../components/layout/footer.php' ?>
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