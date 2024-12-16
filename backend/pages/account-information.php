<?php
require_once __DIR__ . "/../model/model.php";
require_once __DIR__ . "/../model/users.php";

if (!isset($_SESSION['full_name'])){
    echo "<script>
    window.location.href = 'login.php';
    </script>";
    exit;
  }
$id = $_SESSION["id"];
$Users = new Users();
$user_details = $Users->find($id);

// Pilihan gender yang tersedia
$gender_options = ['l' => 'Laki-laki', 'p' => 'Perempuan'];

// Gender yang tersimpan di database
$selected_gender = $user_details[0]['gender'];
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

    <!-- JQUERY -->
    <link rel="stylesheet" href="../dist/assets/modules/jquery-selectric/selectric.css">

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
                        <h1>Tambah Akun</h1>
                    </div>
                    <div class="section-body">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6 d-flex align-items-center">
                                <div>
                                    <img src="./../assets/img/information.jpg" alt="" class="img-fluid w-100 w-md-75 w-lg-50">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 d-flex align-items-center w-full">
                                <div class="card w-full col-12">
                                    <div class="card-body">
                                        <h4>Informasi Akun</h4>
                                    </div>
                                 
                                    <div class="card-body">
                                        <div class="form-group">
                                           <img src="./../assets/img/users/<?= $user_details[0]['avatar'] ?>" class="w-25 h-25">
                                        </div>
                                 
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input readonly type="text" class="form-control " value="<?= $user_details[0]['full_name'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Bio</label>
                                            <textarea readonly name="bio" id="bio" class="form-control"><?= $user_details[0]['bio'] ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Gender</label>
                                            <select disabled class="form-control selectric" >
                                                <?php  foreach ($gender_options as $key => $label) : ?>
                                                    <option value="<?= $key ?>" <?= $key === $selected_gender ? 'selected' : '' ?>>
                                                     <?= $label ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input readonly type="email" class="form-control " value="<?= $user_details[0]['email'] ?>" >
                                        </div>
                                        <div class="form-group">
                                            <label>Phone</label>
                                            <input readonly type="number" class="form-control " value="<?= $user_details[0]['phone'] ?>" >
                                        </div>
                                      
                                        <div class="d-flex flex-column flex-sm-row justify-content-end gap-2">
                                            <a href="./edit-user.php" class="btn btn-primary">
                                                <i class="far fa-edit"></i> Edit Profile
                                            </a>
                                        </div>
                                    </div>
                                </div>
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
    <script src="../dist/assets/modules/jquery-selectric/jquery.selectric.min.js"></script>
</body>

</html>