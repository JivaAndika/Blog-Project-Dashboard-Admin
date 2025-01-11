<?php
require_once __DIR__ . "/../../backend/model/model.php";
require_once __DIR__ . "/../../backend/model/categories.php";
require_once __DIR__ . "/../../backend/model/posts.php";
require_once __DIR__ . "/../../backend/model/tags.php";
require_once __DIR__ . "/../../backend/model/users.php";

$CategoriesModel = new Categories();
$PostsModel = new Posts();
$TagsModel = new Tags();
$UsersModel = new Users();

$Posts = $PostsModel->ShowLatestPosts();
$postAtHome = $PostsModel->ShowPostAtHome();
$Categories = $CategoriesModel->all();
$Categories = array_slice($Categories, 0, 6);
$Tags = $TagsModel->all();
$Tags = array_slice($Tags, 0, 6);
$Users = $UsersModel->Count_User();
$Users = array_slice($Users, 0, 5);
$TagsCount = $TagsModel->count_tag();
$TagsCount = array_slice($TagsCount, 0, 6);

$formattedDate = date("d F Y", strtotime($postAtHome[0]['created_at']));

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
    <?php include_once ('./../layout/navbar_index.php') ?>
    <!-- HERO SECTION  -->
    <section class="hero pt-20">
      <div class="container mx-auto grid md:grid-cols-3 px-4 gap-6">
        <a
          class="news bg-[url('./../../backend/assets/img/posts/<?= $postAtHome[0]['attachment_post'] ?>')] relative h-72 md:h-full bg-cover flex flex-col gap-2 col-span-2" 
          href="../data/blog.php?id_post=<?= base64_encode($postAtHome[0]['id_post']) ?>"
        >
          <span
            class="absolute bottom-0 flex flex-col gap-2 justify-end text-left bg-gradient-to-t from-[#000000a4] h-full w-full p-3 text-white"
          >
            <div class="desc_news">
              <span
                class="desc_news font-bold bg-[#e72222] md:text-lg lg:text-xl rounded-sm p-1 py-[2px]"
                ><?= $postAtHome[0]['name_category'] ?></span
              >
            </div>
            <h1 class="text-2xl md:text-3xl lg:text-5xl font-bold">
            <?= $postAtHome[0]['tittle'] ?>
            </h1>
            <div class="flex gap-3">
              <div class="author flex items-center gap-2 cursor-pointer">
                <img src="./../../backend/assets/img/users/<?= $postAtHome[0]['avatar'] ?>" alt="profile" width="25">
                <span class="text-sm lg:text-base"><?= $postAtHome[0]['full_name'] ?></span>
              </div>
              |
              <div class="date">
                <span class="text-sm lg:text-base"><?= $formattedDate ?></span>
              </div>
            </div>
          </span>
        </a>
        <div class="latest_news flex flex-col">
          <div class="header_news flex items-center justify-center mb-4 gap-3">
            <div class="flex-grow border border-gray-500"></div>
            <h1 class="font-bold text-2xl lg:text-3xl">Berita terkini</h1>
            <div class="flex-grow border border-gray-500"></div>
          </div>
          <?php foreach($Posts as $post) :?>
          <a class="news hover:text-blue-500" href="../data/blog.php?id_post=<?= base64_encode($post['id_post']) ?>">
            <div class="new flex gap-3 py-2 border-b border-black">
              <div class="image_new">
                <img src="./../../backend/assets/img/posts/<?= $post['attachment_post'] ?>" alt="news" class="w-48" />
              </div>
              <div class="desc_new w-fit lg:w-96">
                <h2 class="text-lg font-bold line-clamp-1">
                <?= $post['tittle'] ?>
                </h2>
                <p class="text-gray-500 line-clamp-2">
                <?= $post['content'] ?>
                </p>
              </div>
            </div>
          </a>
       <?php endforeach;?>
        </div>
      </div>
    </section>
    <!-- CATEGORIES & TAGS SECTION -->
    <section class="catags pt-10">
      <div class="container mx-auto px-4">
        <div class="content grid md:grid-cols-3 gap-6">
          <div
            class="category grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 col-span-2 md:mb-32"
          >
            <div
              class="header_category flex items-center gap-3 col-span-2 md:col-span-4 lg:col-span-5"
            >
              <h1 class="font-bold text-2xl lg:text-3xl">Kategori berita</h1>
              <div class="flex-grow border border-gray-500"></div>
            </div>
            <?php foreach($Categories as $Category) :?>
              <a href="../data/category.php?id_category=<?= base64_encode($Category['id_category']) ?>">
            <div
              class="category flex flex-col justify-center items-center p-6 bg-white rounded-md drop-shadow-lg "
            >
              <img src="./../../backend/assets/img/categories/<?= $Category['attachment_category'] ?>" class="" alt="" />
              <h3 class="font-semibold"><?= $Category['name_category'] ?></h3>
            </div>
            </a>
            <?php endforeach;?>
            
          </div>
          <div
            class="tags flex flex-col col-span-2 md:col-span-1 border border-black rounded-md p-4"
          >
            <div class="tags flex items-center justify-center mb-4 gap-3">
              <div class="flex-grow border border-gray-500"></div>
              <h1 class="font-bold text-2xl lg:text-3xl">Tag Teratas</h1>
              <div class="flex-grow border border-gray-500"></div>
            </div>
            <?php foreach($TagsCount as $Tag) :?>
              <a href="../data/tag.php?id_tag=<?= base64_encode($Tag['id_tag']) ?>">

                <div
              class="tag flex justify-between items-center gap-3 py-2 border-b border-black group cursor-pointer mb-2"
              >
              <div class="desc_tag flex flex-col">
                <h2 class="text-lg font-bold">#<?= $Tag['name_tag'] ?></h2>
                <p class="text-gray-500 font-semibold text-xs"><?= $Tag['tag_count'] ?> Post</p>
              </div>
              <div class="visit_tag">
                <span
                class="bg-[#d1cece] group-hover:bg-[#8f8f8f] px-[6px] py-[2px] rounded-full"
                >
                <i class="ph ph-arrow-up-right text-white text-sm"></i>
              </span>
            </div>
          </div>
        </a>
           <?php endforeach ;?>
          </div>
        </div>
      </div>
    </section>
    <!-- AUTHOR SECTION -->
    <section class="news pt-10 mb-28">
      <div class="container mx-auto px-4 lg:px-44">
        <div class="header_author flex items-center justify-center mb-4 gap-3">
          <div class="flex-grow border border-gray-500"></div>
          <h1 class="font-bold text-2xl lg:text-3xl">Author Teratas</h1>
          <div class="flex-grow border border-gray-500"></div>
        </div>

        <div
          class="content grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 justify-center gap-5 mt-12 lg:mt-20"
        >
        <?php foreach($Users as $User) :?>
          <a href="../data/author.php?id_user=<?= base64_encode($User['id_user']) ?>">
          <div
            class="card rounded-lg bg-white shadow-2xl px-6 pb-2 pt-4 lg:py-6 flex flex-col items-center cursor-pointer"
          >
            <div class="image flex justify-center items-center mb-4">
              <img src="./../../backend/assets/img/users/<?= $User['avatar'] ?>" alt="People profile" width="60" />
            </div>
            <div class="author_bio text-center mb-3">
              <h3 class="font-bold line-clamp-1"><?= $User['full_name'] ?></h3>
              <h5 class="font-semibold italic text-sm line-clamp-1"><?= $User['job'] ?></h5>
              <p class="text-[#616060] text-[12px] font-semibold mt-1"><?= $User['post_count'] ?> Post Created</p>
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
