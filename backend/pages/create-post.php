<?php
require_once __DIR__ . "/../model/posts.php";
require_once __DIR__ . "/../model/users.php";
require_once __DIR__ . "/../model/categories.php";
require_once __DIR__ . "/../model/tags.php";
require_once  __DIR__ ."/../model/model.php";

if (!isset($_SESSION['full_name'])){
    echo "<script>
    alert('Gagal login');
    window.location.href = 'login.php';
    </script>";
    die;
}

$UsersModel = new Users();
$users = $UsersModel->all();
$CategoriesModel = new Categories();
$categories = $CategoriesModel->all();
$TagsModel = new Tags();
$tags = $TagsModel->all();
$Posts = new Posts(); 
if(isset($_POST['submit'])){
    $datas = [
        "post" => $_POST,
        "files" => $_FILES
    ];
   

    if(strlen($_POST['tittle']) > 225){
        echo "<script>
               alert('Karakter yang anda inputkan lebih dari 225');
                window.location.href = 'create-post.php';
              </script>";
              die;
    }
    
    $result = $Posts->create($datas);
   if($result !== false){
    $tittle = $_POST['tittle'];
    echo "<script>
    alert('Post baru ditambahkan dengan judul {$tittle}');
    window.location.href = 'index-post.php';
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
        
  <link rel="stylesheet" href="../dist/assets/modules/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="../dist/assets/modules/jquery-selectric/selectric.css">
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
                        <h1>Tambah Post</h1>
                    </div>

                    <div class="section-body">

                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6 d-flex align-items-center w-25">
                                <div class="img-fluid">
                                <img src="./../assets/img/post.gif" alt="" class="img-fluid w-100 w-md-75 w-lg-50">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 d-flex align-items-center w-full">
                                <div class="card w-full col-12">
                                    <div class="card-body">
                                        <h4>Input Post</h4>
                                    </div>
                                    <form class="card-body" method="post" action="" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="tittle">Nama Post</label>
                                          <input type="text" name="tittle" class="form-control ">
                                        </div>
                                        <div class="form-group">
                                            <label for="content">Isi Post</label>
                                          <textarea name="content" id="content" class="form-control"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label  class="form-control-label">Gambar</label>
                                            <div>
                                                <div class="custom-file">
                                                    <input type="file" name="attachment_post" class="custom-file-input" id="attachment_post">
                                                    <label for="attachment_post" class="custom-file-label">Choose File</label>
                                                </div>
                                                <div class="form-text text-muted">The image must have a maximum size of 3MB</div>
                                            </div>
                                        </div>
                                        <input name="user_id" type="hidden" value="<?= $_SESSION["id"] ?>">
                                        <div class="form-group">
                                            <label for="category_id">Pilih kategori</label>
                                            <select  name="category_id" id="category_id" class="form-control selectric">
                                                <?php foreach ($categories as $category) : ?>
                                                <option value="<?= $category['id_category'] ?>"><?= $category['name_category'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="tags">Pilih Tag</label>
                                            <select  name="tag_id_pivot[]" id="tags " class="form-control select2" multiple="">
                                                <?php foreach ($tags as $tag) : ?>
                                                <option value="<?= $tag['id_tag'] ?>"><?= $tag['name_tag'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
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
     <script>function formatState (state) {
  if (!state.id) {
    return state.text;
  }

  var $state = $(
    '<span><img class="img-flag" /> <span></span></span>'
  );

  // Use .text() instead of HTML string concatenation to avoid script injection issues
  $state.find("span").text(state.text);

  return $state;
};

$(".js-example-basic-multiple-limit").select2({
  maximumSelectionLength: 4
});
</script>
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
  <script src="../dist/assets/modules/select2/dist/js/select2.full.min.js"></script>
  <script src="../dist/assets/modules/jquery-selectric/jquery.selectric.min.js"></script>
    <script src="../dist/assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script>

    <!-- Page Specific JS File -->
    <script src="../dist/assets/js/page/index.js"></script>

    <!-- Template JS File -->
    <script src="../dist/assets/js/scripts.js"></script>
    <script src="../dist/assets/js/custom.js"></script>
</body>

</html>