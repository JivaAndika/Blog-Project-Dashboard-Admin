<?php
require_once __DIR__ . "/../../backend/model/model.php";
require_once __DIR__ . "/../../backend/model/tags.php";
require_once __DIR__ . "/../../backend/model/posts.php";


$PostsModel = new Posts();
$TagsModel = new Tags();
if (!isset($_GET['id_tag']) || empty($_GET['id_tag'])) {
  // Jika tidak ada parameter atau kosong, arahkan ke index.php
  header("Location: index.php");
  exit();
}
$id = base64_decode($_GET['id_tag']);

$ShowTag = $TagsModel->show_tag();
$Posts = $PostsModel->SelectPostAsTag($id);
$Tags = $TagsModel->find($id);
$groupedTags = [];
foreach ($ShowTag as $tag) {
    $groupedTags[$tag['post_id_pivot']][] = $tag['name_tag'];
}




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
     <section class="pt-20">
    <div class="container mx-auto px-4 py-8">
    <div class="mb-12">
      <h2 class="text-2xl font-bold mb-6 border-b-2 border-blue-600 pb-2">Tag: <?= $Tags[0]['name_tag']?></h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Blog Card -->
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
