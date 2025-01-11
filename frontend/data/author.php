<?php
require_once __DIR__ . "/../../backend/model/model.php";
require_once __DIR__ . "/../../backend/model/categories.php";
require_once __DIR__ . "/../../backend/model/tags.php";
require_once __DIR__ . "/../../backend/model/users.php";
require_once __DIR__ . "/../../backend/model/posts.php";

$TagsModel = new Tags();
$PostsModel = new Posts();
$UsersModel = new Users();
if (!isset($_GET['id_user']) || empty($_GET['id_user'])) {
  header("Location: index.php");
  exit();
}
$id = base64_decode($_GET['id_user']);

$Users = $UsersModel->find($id);
// var_dump($Users);
$ShowTag = $TagsModel->show_tag();
$Posts = $PostsModel->SelectPostAsAuthor($id);
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
    <title>Website Blog</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="icon" href="./../img/logo.png" />
    <style>
      .clear {
        clear: both;
      }
    </style>
  </head>
  <body class="bg-gray-100">
    <!-- Navbar -->
    <?php include_once ('./../layout/navbar.php') ?>
      <!-- Author Section -->
    <section class="author pt-20 px-4">
      <div class="container mx-auto flex flex-col md:flex-row px-6 gap-8">
        <div class="bg-white p-6 rounded-md shadow-md md:w-1/3 lg:w-80">
          <div class="flex flex-col items-center">
            <img
              src="./../../backend/assets/img/users/<?= $Users[0]['avatar'] ?>"
              alt="User"
              class="w-32 rounded-full border-4 border-blue-500"
            />
            <h1 class="font-bold text-lg mt-4">Hi, <?= $Users[0]['full_name'] ?></h1>
          </div>
        </div>
        <div class="bg-white p-6 rounded-md shadow-md flex-grow">
          <h2 class="font-bold text-2xl"><?= $Users[0]['full_name'] ?></h2>
          <p class="italic text-gray-500"><?= $Users[0]['job'] ?></p>
          <p class="mt-4 text-gray-700">
          <?= $Users[0]['bio'] ?>.
          </p>
          <div class="mt-6 flex gap-4">
            <a
              href="#"
              class="text-blue-500 text-3xl hover:text-blue-700 transition"
              ><i class="ph ph-facebook-logo"></i
            ></a>
            <a
              href="#"
              class="text-blue-500 text-3xl hover:text-blue-700 transition"
              ><i class="ph ph-x-logo"></i
            ></a>
            <a
              href="#"
              class="text-blue-500 text-3xl hover:text-blue-700 transition"
              ><i class="ph ph-instagram-logo"></i
            ></a>
          </div>
          <div class="mt-6">
            <div class="join">
              <h5 class="font-extralight text-sm mt-6 text-[#6d6d6dc4] italic">
                Bergabung Sejak <?= $formattedDate ?>
              </h5>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Blog Section -->
    <section class="author_blog pt-16 px-4 mb-28">
      <div
      class="container mx-auto grid md:grid-cols-2 px-6 lg:grid-cols-3 gap-6"
      >
        <div class="blog_header  col-span-1 md:col-span-2 lg:col-span-3">
          <h1 class="font-bold text-2xl text-blue-500">
          <?= $Users[0]['full_name'] ?>'s 
            <span class="text-black">Blog</span> 
          </h1>
        </div>
      <?php if(!empty($Posts)) :?>
    <?php foreach($Posts as $Post) :?>
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
            <a href="blog.php?id_post=<?= base64_encode($Post['id_post'])  ?>">
                <img src="./../../backend/assets/img/posts/<?= $Post['attachment_post'] ?>" alt="Blog Image" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="font-semibold text-lg text-gray-800 mb-2"><?= $Post['tittle'] ?></h3>
                    <p class="text-sm text-gray-600 mb-4 line-clamp-3">
                    <?= $Post['content'] ?>
                    </p>
                    <div class="flex items-center gap-2">
                        <?php if (isset($groupedTags[$Post['id_post']])) : ?>
                            <?php foreach ($groupedTags[$Post['id_post']] as $index => $tag) : ?>
                                <?php if ($index % 2 == 0) : ?>
                                    <span class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded"># <?= $tag ?></span>
                                <?php else : ?>
                                    <span class="text-xs bg-green-100 text-green-600 px-2 py-1 rounded"># <?= $tag ?></span>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <span class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded"># No tags</span>
                        <?php endif; ?>
                    </div>
                    <a href="blog.php?id_blog=<?= $Post['id_post'] ?>" class="text-blue-600 text-sm font-semibold mt-4 inline-block hover:underline">Read More</a>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
<?php else :?>
    <p class="text-center text-gray-600">No post found created by this author.</p>
<?php endif;?>
        <!-- Tambahkan blog lainnya di sini -->
      </div>
    </section>
    <!-- FOOTER -->
    <?php include_once ('./../layout/footer.php') ?>
    <script src="script.js"></script>
  </body>
</html>
