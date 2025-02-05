<nav class="bg-[#fafafa] drop-shadow-lg">
      <div
        class="container mx-auto flex justify-between py-[18px] lg:py-5 px-4"
      >
        <div class="nav-logo flex items-center gap-[6px]">
          <div class="image_logo">
            <img src="./../img/logo.png" alt="logo" class="w-4 md:w-5 lg:w-6" />
          </div>
          <div class="name_logo">
            <h1 class="font-extrabold md:text-lg lg:text-xl">
              D.<span class="text-blue-600">NEWS</span>
            </h1>
          </div>
        </div>
        <div
          class="toggle lg:hidden text-3xl cursor-pointer"
          id="open"
          onclick="openNavbar()"
        >
          <i class="ph ph-list"></i>
        </div>
        <div class="list-menu hidden lg:flex items-center">
          <ul class="flex gap-6 font-semibold">
            <li
              class="relative px-3 pb-2 before:absolute before:inset-x-0 before:bottom-0 before:h-[2px] before:origin-right before:scale-x-0 before:bg-black before:transition before:duration-300 hover:before:origin-left hover:before:scale-x-100"
            >
              <a href="index.php">Home</a>
            </li>
            
            <li
              class="relative px-3 pb-2 before:absolute before:inset-x-0 before:bottom-0 before:h-[2px] before:origin-right before:scale-x-0 before:bg-black before:transition before:duration-300 hover:before:origin-left hover:before:scale-x-100"
            >
              <a href="contact.php">Contact</a>
            </li>
           
            <li
              class="relative px-3 pb-2 before:absolute before:inset-x-0 before:bottom-0 before:h-[2px] before:origin-right before:scale-x-0 before:bg-black before:transition before:duration-300 hover:before:origin-left hover:before:scale-x-100"
            >
              <a href="about.php">About</a>
            </li>
          </ul>
        </div>

        <div class="login hidden lg:flex items-center gap-1">
        <a
          href="./../../backend/pages/index.php"
          class="hidden lg:inline-block bg-blue-600 text-white py-2 px-4 rounded-lg shadow hover:bg-blue-700 transition"
          >Create Blog</a
        >
        </div>
      </div>
    </nav>
    <aside
      class="w-full mr-auto h-screen backdrop-blur bg-[#0000009f] bg-opacity-80 fixed transition-all ease-in-out duration-200 flex justify-end lg:hidden translate-x-full z-50"
      id="aside"
    >
      <div
        class="w-[260px] h-full bg-[#fafafa] content flex flex-row-reverse px-10"
      >
        <ul class="flex flex-col text-end gap-5 pt-20 px-4">
          <li
            class="relative px-3 pb-2 before:absolute before:inset-x-0 before:bottom-0 before:h-[2px] before:origin-right before:scale-x-0 before:bg-black before:transition before:duration-300 hover:before:origin-left hover:before:scale-x-100"
          >
            <a class="text-lg" href="index.php">Home</a>
          </li>
          
          <li
            class="relative px-3 pb-2 before:absolute before:inset-x-0 before:bottom-0 before:h-[2px] before:origin-right before:scale-x-0 before:bg-black before:transition before:duration-300 hover:before:origin-left hover:before:scale-x-100"
          >
            <a class="text-lg" href="contact.php">Contact</a>
          </li>
         
          <li
            class="relative px-3 pb-2 before:absolute before:inset-x-0 before:bottom-0 before:h-[2px] before:origin-right before:scale-x-0 before:bg-black before:transition before:duration-300 hover:before:origin-left hover:before:scale-x-100"
          >
            <a class="text-lg" href="about.php">About</a>
          </li>
          <li
            class="relative px-3 pb-2 before:absolute before:inset-x-0 before:bottom-0 before:h-[2px] before:origin-right before:scale-x-0 before:bg-blue-500 text-blue-500 before:transition before:duration-300 hover:before:origin-left hover:before:scale-x-100"
          >
            <a class="text-lg" href="./../../backend/pages/index.php">Create Blog</a>
          </li>
        </ul>
      </div>
    </aside>
    <script>
      const sidebar = document.getElementById("aside");
      const openNavbar = document.getElementById("open");
      openNavbar.addEventListener("click", function () {
      sidebar.classList.toggle("translate-x-full");
      });


  // Tambahkan event listener ke elemen dengan ID 'create-blog-link'
  document.addEventListener("DOMContentLoaded", function () {
    const createBlogLink = document.querySelectorAll("a[href='./../../backend/pages/index.php']");

    createBlogLink.forEach(link => {
      link.addEventListener("click", function (event) {
        // Munculkan dialog konfirmasi
        const userConfirmed = confirm("Apakah Anda ingin membuat Blog?");
        // Jika pengguna menekan 'Cancel', cegah navigasi
        if (!userConfirmed) {
          event.preventDefault();
        }
      });
    });
  });
</script>