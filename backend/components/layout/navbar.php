<?php
require_once __DIR__ . "/../../model/users.php";

$Users = new Users();
$id = $_SESSION['id'];
$user_details = $Users->find($id);
if(isset($_GET['logout'])){
  $Users->logout();
}
$_SESSION['login_time'] = time(); 
$loginTime = isset($_SESSION['login_time']) ? $_SESSION['login_time'] : time();
$timeElapsed = time() - $loginTime;

$minutesElapsed = floor($timeElapsed / 60);

if ($minutesElapsed < 1) {
  $timeDisplay = "just now";
} elseif ($minutesElapsed < 60) {
  $timeDisplay = "$minutesElapsed min ago";
} else {
  $hoursElapsed = floor($minutesElapsed / 60);
  $timeDisplay = "$hoursElapsed hour" . ($hoursElapsed > 1 ? "s" : "") . " ago";
}

?>
<nav class="navbar navbar-expand-lg main-navbar">
          <form class="form-inline mr-auto">
            <ul class="navbar-nav mr-3">
              <li>
                <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"
                  ><i class="fas fa-bars"></i
                ></a>
              </li>
            </ul>
          </form>
          <ul class="navbar-nav navbar-right">
            <li class="dropdown">
              <a
                href="#"
                data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user"
              >
                <img
                  alt="image" 
                  src="./../assets/img/users/<?= $user_details[0]['avatar'] ?>"
                  class="rounded-circle mr-1"
                />
                <div class="d-sm-none d-lg-inline-block">
                  Hi, <?= $user_details[0]['full_name']  ?>
                  
                </div></a
              >
              <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">Logged in <?= $timeDisplay ?></div>
                <a href="./account-information.php" class="dropdown-item has-icon">
                  <i class="far fa-user"></i> Profile
                </a>
               
                <div class="dropdown-divider"></div>
                <a href="?logout" class="dropdown-item has-icon text-danger" >
                  <i class="fas fa-sign-out-alt"></i> Logout
                </a>
              </div>
            </li>
          </ul>
        </nav>