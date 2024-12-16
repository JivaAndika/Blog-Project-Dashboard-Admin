<?php
require_once __DIR__ . "/../../backend/model/model.php";
require_once __DIR__ . "/../../backend/model/tags.php";
require_once __DIR__ . "/../../backend/model/categories.php";
require_once __DIR__ . "/../../backend/model/posts.php";


$PostsModel = new Posts();
$CategoriesModel = new Categories();
$TagsModel = new Tags();
if (!isset($_GET['id_post']) || empty($_GET['id_post'])) {
  // Jika tidak ada parameter atau kosong, arahkan ke index.php
  header("Location: index.php");
  exit();
}
$id = base64_decode($_GET['id_post']);

$ShowTag = $TagsModel->show_tag();
$Posts = $PostsModel->FindPostAsBlog($id);
// var_dump($Posts);
$recommendPosts = $PostsModel->RecommendPost();
$id_category = $Posts[0]['category_id'];
// var_dump($id_category);
$latestPosts = $PostsModel->SelectPostLikeCategory($id_category , $id);
// var_dump($latestPosts);
$Tags = $TagsModel->find($id);
$groupedTags = [];
foreach ($ShowTag as $tag) {
    $groupedTags[$tag['post_id_pivot']][] = $tag['name_tag'];
}
$formattedDate = date("d F Y", strtotime($Posts[0]['created_at']));



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
    <style>
      .clear {
        clear: both;
      }
    </style>
  </head>
  <body class="bg-gray-100">
  <!-- NAVBAR -->
  <?php include_once ('./../layout/navbar.php') ?>
    <!-- BLOG SECTION -->
    <section class="blog pt-20">
    <div class="container mx-auto flex flex-col lg:flex-row gap-6 px-4">
      <div class="main-content lg:w-2/3 flex flex-col gap-6">
      <div
            class="h-72 md:h-96 lg:h-[500px] bg-cover bg-center relative" style="background-image: url('./../../backend/assets/img/posts/<?= $Posts[0]['attachment_post'] ?>')""
          >
            <span
              class="absolute bottom-0 flex flex-col gap-2 justify-end text-left bg-gradient-to-t from-[#000000a4] h-full w-full p-3 text-white"
            >
              <div class="desc_news">
                <span
                  class="desc_news font-bold bg-[#ec3232] md:text-lg lg:text-xl rounded-sm p-1 py-[2px]"
                  ><?= $Posts[0]['name_category'] ?></span
                >
              </div>
              <h1 class="text-2xl md:text-3xl lg:text-5xl font-bold mb-2">
              <?= $Posts[0]['tittle'] ?>
              </h1>
            </span>
          </div>
        <div class="author flex flex-col md:flex-row gap-5 items-center mt-4">
          <img src="./../../backend/assets/img/users/<?= $Posts[0]['avatar'] ?>" alt="" class="w-16 h-16 rounded-full" />
          <div class="flex flex-col">
            <p class="text-sm text-blue-500 font-semibold"> <?= $Posts[0]['job'] ?> </p>
            <div class="name flex items-center">
              <h1 class="text-md font-bold"> <?= $Posts[0]['full_name'] ?></h1>
              <img src="./../img/verified.png" alt="" width="25" class="ml-2" />
            </div>
          </div>
          <span class="text-sm text-gray-500"> <?= $formattedDate ?> </span>
        </div>
        <hr class="border-gray-300 mt-6" />
        <div class="article mt-6">
          <p class="text-justify" >
            <?= nl2br(htmlspecialchars($Posts[0]['content'])) ?>
          </p>
        </div>
        <div class="tags mt-6">
          <h2 class="text-lg font-semibold">Tags:</h2>
          <div class="flex flex-wrap gap-3 mt-2">
            <?php foreach ($groupedTags[$Posts[0]['id_post']] as $tag) : ?>
              <span class="bg-blue-500 text-white text-sm px-3 py-1 rounded cursor-pointer hover:bg-blue-600">
                <?= $tag ?>
              </span>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <aside class="related_news lg:w-1/3 flex flex-col gap-6">
        <div class="header_news flex items-center gap-3">
          <div class="flex-grow border border-gray-500"></div>
          <h1 class="font-bold text-2xl lg:text-3xl">Berita Terkait</h1>
          <div class="flex-grow border border-gray-500"></div>
        </div>
        <?php foreach($latestPosts as $post) : ?>
        <a class="news hover:text-blue-500" href="blog.php?id_post=<?= base64_encode($post['id_post'])  ?>">
          <div class="new flex gap-3 items-center border-b border-black pb-2">
            <img src="./../../backend/assets/img/posts/<?= $post['attachment_post'] ?>" alt="news" class="w-32 h-auto rounded-md" />
            <div class="desc_new flex flex-col">
              <h2 class="text-lg font-bold line-clamp-1"> <?= $post['tittle'] ?></h2>
              <p class="text-gray-500 text-sm line-clamp-2"> <?= $post['content'] ?></p>
            </div>
          </div>
          </a>
          <?php endforeach;?>
          
      </aside>
    </div>
  </section>
  
    <!-- LATEST NEWS -->
    <section class="latest pt-20 mb-28">
      <div class="container mx-auto px-4">
        <div class="header_news flex items-center justify-center mb-4 gap-3">
          <div class="flex-grow border border-gray-500"></div>
          <h1 class="font-bold text-2xl lg:text-3xl">Rekomendasi Berita</h1>
          <div class="flex-grow border border-gray-500"></div>
        </div>
        <div
          class="related_news lg:justify-center grid md:grid-cols-4 lg:flex  gap-4 lg:gap-8"
        >
        <?php foreach($recommendPosts as $post) : ?>
  <a class="news hover:text-blue-500" href="blog.php?id_post=<?= base64_encode($post['id_post'])  ?>">
    <div class="new flex flex-col gap-3 py-2 border-b border-blue-500 h-64">
    <div class="image_new overflow-hidden">
  <img
    src="./../../backend/assets/img/posts/<?= $post['attachment_post'] ?>"
    alt="news"
    class="w-full md:w-44 lg:w-64 object-cover h-32 transition-transform duration-300 hover:scale-105"
  />
</div>

      <div class="desc_new md:w-44 lg:w-64 flex-1 flex flex-col justify-between">
      <h2 class="md:text-lg font-bold truncate">
  <?= $post['tittle'] ?>
</h2>

        <p class="text-gray-500 text-sm md:text-base line-clamp-2">
          <?= $post['content'] ?>
        </p>
      </div>
    </div>
  </a>
<?php endforeach; ?>

        </div>
      </div>
    </section>
    <!-- FOOTER -->
    <?php include_once ('./../layout/footer.php') ?>
    <script src="script.js"></script>
  </body>
</html>
