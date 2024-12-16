<?php
require_once  __DIR__ ."/../model/posts.php";
require_once  __DIR__ ."/../model/categories.php";
require_once  __DIR__ ."/../model/tags.php";
require_once  __DIR__ ."/../model/users.php";
require_once  __DIR__ ."/../model/model.php";


if (!isset($_SESSION['full_name'])){
    echo "<script>
    alert('Gagal login');
    window.location.href = 'login.php';
    </script>";
    die;
  }
  $id = $_GET['id_post'];
  $Posts = new Posts();
  $Categories = new Categories();
  $users = new Users();

  $categories_details = $Categories->all();
  $user_all = $users->all();
  $post_find = $Posts->find($id);

  $tags = new Tags();
  $show_tag = $tags->show_tag();
  $groupedTags = [];
  foreach ($show_tag as $tag) {
      $groupedTags[$tag['post_id_pivot']][] = [
          'id_tag' => $tag['id_tag'],
          'name_tag' => $tag['name_tag']
      ];
  }
  $allTags = $tags->all(); // Mengambil semua tag
$selectedTags = $groupedTags[$post_find[0]['id_post']] ?? []; // Tag terpilih untuk post

  

  
  

  if(isset($_POST['cancel'])){
    echo "<script>
    window.location.href = 'index-post.php';
    </script>";
    die;
  }

if(isset($_POST['submit'])){
    $datas = [
        "post" => $_POST,
        "files" => $_FILES
    ];
   

    if(strlen($_POST['tittle']) > 225){
        echo "<script>
               alert('Karakter yang anda inputkan lebih dari 225');
                window.location.href = 'edit-post.php';
              </script>";
              die;
    }
    
    $result = $Posts->update($id,$datas);
   if($result !== false){
    $tittle = $_POST['tittle'];
    echo "<script>
    alert('Post baru diedit dengan nama {$tittle}');
    window.location.href = 'index-post.php';
    </script>";
} else{
    echo "<script>
    alert('Gagal edit Post');
    window.location.href = 'edit-post.php';
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
  <link rel="stylesheet" href="../dist/assets/modules/select2/dist/css/select2.min.css">
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
                        <h1>Edit Post</h1>
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
                                        <h4>Edit Post</h4>
                                    </div>
                                    <form class="card-body" method="post" action="" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="tittle">Edit Judul post</label>
                                          <input type="text" name="tittle" class="form-control " value="<?= $post_find[0]['tittle'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label  class="form-control-label">Gambar</label>
                                            <div>
                                                <div class="old_image">
                                                     <img src="./../assets/img/posts/<?= $post_find[0]['attachment_post']?>" alt="" class="img-fluid">
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" name="attachment_post" class="custom-file-input" id="attachment_post">
                                                    <label for="attachment_post" class="custom-file-label">Choose File</label>
                                                </div>
                                                <div class="form-text text-muted">The image must have a maximum size of 1MB</div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="content">Edit konten</label>
                                            <textarea class="form-control" name="content" id="content"><?= $post_find[0]['content'] ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="user_id">Edit Author</label>
                                            <select name="user_id" id="user_id" class="form-control selectric">
                                               <?php foreach ($user_all as $user) : ?>
                                                <option value="<?= $user['id_user'] ?>">
                                                    <?= $user['full_name'] ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="category_id">Edit kategori</label>
                                            <select  name="category_id" id="category_id" class="form-control selectric">
                                                <?php foreach ($categories_details as $categorie) : ?>
                                                <option value="<?= $categorie['id_category'] ?>" 
                                                <?php echo ($categorie['id_category'] == $post_find[0]['category_id']) ? 'selected="selected"' : '' ?>>
                                                <?= $categorie['name_category'] ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                       <div class="form-group">
    <label for="tags">Pilih Tag</label>
    <select name="tag_id_pivot[]" id="tags" class="form-control select2" multiple="">
        <?php foreach ($allTags as $tag): ?>
            <option value="<?= $tag['id_tag'] ?>" 
                <?= in_array($tag['id_tag'], array_column($selectedTags, 'id_tag')) ? 'selected' : '' ?>>
                <?= $tag['name_tag'] ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
                                        <div class="d-flex flex-column flex-sm-row justify-content-end gap-2">    
                                        <button name="cancel" id="cancel" class="btn btn-secondary mb-2 mb-sm-0 mr-0 mr-sm-2 ">Cancel</button>
                                        <button  name="submit" id="submit" class="btn btn-primary mb-2 mb-sm-0 mr-0 mr-sm-2">Edit Post</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                </section>
            </div>

<kbd></kbd>


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
  <script src="../dist/assets/modules/select2/dist/js/select2.full.min.js"></script>
  <script src="../dist/assets/modules/jquery-selectric/jquery.selectric.min.js"></script>

    <!-- Page Specific JS File -->
    <script src="../dist/assets/js/page/index.js"></script>

    <!-- Template JS File -->
    <script src="../dist/assets/js/scripts.js"></script>
    <script src="../dist/assets/js/custom.js"></script>
</body>

</html>