<?php
require_once __DIR__ . "/../../backend/model/model.php";
require_once __DIR__ . "/../../backend/model/categories.php";
require_once __DIR__ . "/../../backend/model/posts.php";



$PostsModel = new Posts();
$CategoriesModel = new Categories();
if (!isset($_GET['id_category']) || empty($_GET['id_category'])) {
  // Jika tidak ada parameter atau kosong, arahkan ke index.php
  header("Location: index.php");
  exit();
}

$id = base64_decode($_GET['id_category']);

$Posts = $PostsModel->SelectPostAsCategory($id);
$Categories = $CategoriesModel->find($id);


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Website blog</title>
    <!-- CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- ICON -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="icon" href="./../img/logo.png" />
  </head>
  <body class="bg-gray-100">
    <!-- NAVBAR -->
    <?php include_once ('./../layout/navbar.php') ?>

    <!-- MAIN CONTENT -->
     <section class="category pt-20">
    <div class="container mx-auto px-4 py-8">
    <!-- Category: Technology -->
    <div class="mb-12">
      <h2 class="text-2xl font-bold mb-6 border-b-2 border-blue-600 pb-2"><?= $Categories[0]['name_category'] ?></h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- News Card -->
         <?php if(!empty($Posts)) :?>
         <?php foreach($Posts as $Post) :?>
          <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
          <a href="blog.php?id_post=<?= base64_encode($Post['id_post'])  ?>">
              <img src="./../../backend/assets/img/posts/<?= $Post['attachment_post'] ?>" alt="Blog" class="w-full h-48 object-cover">
              <div class="p-4">
                <h3 class="font-semibold text-lg text-gray-800 mb-2"><?= $Post['tittle'] ?></h3>
                <p class="text-sm text-gray-600 line-clamp-4"><?= $Post['content'] ?></p>
                <a href="#" class="text-blue-600 text-sm font-semibold mt-2 inline-block hover:underline">Read More</a>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
        <?php else :?>
            <p class="text-center text-gray-600">No post found in this category.</p>
        <?php endif;?>
      </div>
    </div>
    </div>  
    
    </section>

    <!-- FOOTER -->
    <?php include_once ('./../layout/footer.php') ?>
    <script src="script.js"></script>
  </body>
</html>
