<?php
require_once __DIR__ . "/../model/model.php";
require_once __DIR__ . "/../model/users.php";

if (!isset($_SESSION['full_name'])){
    echo "<script>
    window.location.href = 'login.php';
    </script>";
    exit;
  }
$Users = new Users();
$id = $_SESSION["id"];


if(isset($_POST['submit'])){
    $oldPass = $_POST['password'];
    $newPass = $_POST['new_password'];
    $confirmPass = $_POST['confirm_password'];
    if($newPass  !== $confirmPass){
        echo "<script>
        alert('Konfirmasi password salah');
        </script>";
    }
    $result = $Users->updatePassword($id, $oldPass, $newPass);
    
    if(gettype($result) == 'string'){
        echo "<script>
        alert('{$result}');
        </script>";
    }
    else{
        echo "<script>
        alert('Password berhasil diubah');
        window.location.href = 'account-information.php';
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
        <div class="main-wrapper main-wrapper-1 ">
            <div class="navbar-bg"></div>
            <!-- NAV -->
            <?php include '../components/layout/navbar.php' ?>
            <!--SIDEBAR -->
            <?php include '../components/layout/sidebar.php' ?>
            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Ganti Password</h1>
                    </div>
                    <div class="section-body">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6 d-flex align-items-center">
                                <div>
                                    <img src="./../assets/img/password.gif" alt="" class="img-fluid w-100 w-md-75 w-lg-50">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 d-flex align-items-center w-full">
                                <div class="card w-full col-12">
                                    <form class="card-body" action="" method="post">
                                        <h4>Ganti Password</h4>
                                        <div class="form-group">
                                            <label for="password">Password Lama</label>
                                            <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password lama" required >
                                        </div>
                                        <div class="form-group">
                                            <label for="new_password">Password Baru</label>
                                            <input type="password" id="new_password" name="new_password" class="form-control" placeholder="Masukkan password baru" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="confirm_password">Konfirmasi Password Baru</label>
                                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Masukkan ulang password baru" required>
                                        </div>
                                        
                                        <div class="d-flex flex-column flex-sm-row justify-content-end gap-2">    
                                        <button name="cancel" id="cancel" class="btn btn-secondary mb-2 mb-sm-0 mr-0 mr-sm-2 ">Cancel</button>
                                        <button  name="submit" id="submit" class="btn btn-primary mb-2 mb-sm-0 mr-0 mr-sm-2">Change Password</button>
                                        </div>
                                    </form>
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