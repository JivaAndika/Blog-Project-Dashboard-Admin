<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Us</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="icon" href="./../img/logo.png" />
  </head>
  <body class="bg-gray-100">
    <!-- NAVBAR -->
   <?php include_once ('./../layout/navbar_index.php') ?>
    <!-- MAIN CONTENT -->
    <section class="contact pt-36 mb-28">
      <div class="container mx-auto px-6 lg:px-10">
        <div
          class="flex flex-col lg:flex-row bg-white shadow-lg rounded-lg overflow-hidden"
        >
          <!-- FORM -->
          <div class="w-full lg:w-1/2 p-8 bg-blue-500 text-white">
            <h2 class="text-3xl font-semibold mb-6">Contact Us</h2>
            <form action="#" method="POST" class="space-y-4">
              <div>
                <label for="name" class="block mb-1">Name</label>
                <input
                  type="text"
                  id="name"
                  name="name"
                  required
                  class="w-full p-2 rounded-md bg-white text-black"
                />
              </div>
              <div>
                <label for="email" class="block mb-1">Email</label>
                <input
                  type="email"
                  id="email"
                  name="email"
                  required
                  class="w-full p-2 rounded-md bg-white text-black"
                />
              </div>
              <div>
                <label for="message" class="block mb-1">Message</label>
                <textarea
                  id="message"
                  name="message"
                  rows="5"
                  required
                  class="w-full p-2 rounded-md bg-white text-black"
                ></textarea>
              </div>
              <button
                type="submit"
                class="w-full bg-white hover:bg-[#f4f4f4] py-2 rounded-md text-blue-500 font-semibold transition"
              >
                Send Message
              </button>
            </form>
          </div>
          <!-- CONTACT INFORMATION -->
          <div class="w-full lg:w-1/2 p-8 bg-gray-50">
            <h2 class="text-2xl font-semibold mb-4">Connect With Us</h2>
            <p class="mb-4">
              We're open for any suggestion or just to have a chat.
            </p>
            <ul class="space-y-4">
              <li>
                <a class="flex items-center gap-2" href="">
                  <i class="ph ph-instagram-logo text-blue-600 text-2xl"></i>
                  <span>Instagram.com</span>
                </a>
              </li>
              <li>
                <a class="flex items-center gap-2" href="">
                  <i class="ph ph-github-logo text-blue-600 text-2xl"></i>
                  <span>Github.com</span>
                </a>
              </li>
              <li>
                <a class="flex items-center gap-2" href="">
                  <i class="ph ph-envelope text-blue-600 text-2xl"></i>
                  <span>Umardika678@gmail.com</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </section>
    <!-- FOOTER -->
    <?php include_once ('./../layout/footer.php') ?>
    <script src="script.js"></script>
  </body>
</html>
