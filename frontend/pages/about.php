<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About Us</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="icon" href="./../img/logo.png" />
  </head>
  <body class="bg-gray-100">
    <!-- NAVBAR -->
    <?php include_once ('./../layout/navbar_index.php') ?>

    <!-- MAIN CONTENT -->
    <section class="about pt-36 pb-16">
      <div class="container mx-auto px-6 lg:px-10">
        <div class="text-center">
          <h2 class="text-4xl font-bold text-gray-800 mb-4">About Us</h2>
          <p class="text-lg text-gray-600">
            D.NEWS is your reliable source for insightful news and engaging
            blogs. Explore the stories that shape the world.
          </p>
        </div>
        <div class="mt-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <!-- Card 1 -->
          <div
            class="bg-white shadow-lg rounded-lg p-6 transition transform hover:-translate-y-2 hover:shadow-xl"
          >
            <div class="mb-4">
              <i class="ph ph-globe text-blue-600 text-5xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">
              Global Reach
            </h3>
            <p class="text-gray-600">
              Stay informed with news from all over the world, brought to you in
              one place.
            </p>
          </div>
          <!-- Card 2 -->
          <div
            class="bg-white shadow-lg rounded-lg p-6 transition transform hover:-translate-y-2 hover:shadow-xl"
          >
            <div class="mb-4">
              <i class="ph ph-lightbulb text-blue-600 text-5xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">
              Innovative Ideas
            </h3>
            <p class="text-gray-600">
              Discover unique perspectives and ideas to inspire your day.
            </p>
          </div>
          <!-- Card 3 -->
          <div
            class="bg-white shadow-lg rounded-lg p-6 transition transform hover:-translate-y-2 hover:shadow-xl"
          >
            <div class="mb-4">
              <i class="ph ph-users-three text-blue-600 text-5xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">
              Community Focused
            </h3>
            <p class="text-gray-600">
              Connect with people who share your passions and interests.
            </p>
          </div>
        </div>
   
      </div>
    </section>

    <!-- FOOTER -->
   
    <?php include_once ('./../layout/footer.php') ?>
    <script src="script.js"></script>
  </body>
</html>
