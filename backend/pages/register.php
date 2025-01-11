<?php
require_once __DIR__ . '/../model/users.php';

if (isset($_SESSION['full_name'])){
    echo "<script>
    alert('Anda sudah login');
    window.location.href = 'index.php';
    </script>";
}

$Users = new Users();
if(isset($_POST['submit'])){
    $datas = [
        "post" => $_POST,
        "files" => $_FILES

    ];

    $result = $Users->register($datas);
    if (gettype($result)  == 'string') {
        echo "<script>alert('{$result}');
        window.location.href = 'register.php';
        </script>";
    } else{
        echo "<script>
        alert('Register akun berhasil');
        window.location.href = 'login.php';
        </script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Register &mdash; Blog</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="../dist/assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../dist/assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="../dist/assets/modules/jquery-selectric/selectric.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="../dist/assets/css/style.css">
  <link rel="stylesheet" href="../dist/assets/css/components.css">
<!-- Start GA -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-94034622-3');
</script>
<!-- /END GA --></head>

<body>
<div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="../dist/assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>
            
            
            <div class="card card-primary">
                        <div class="card-header"><h4>Register</h4></div>
                        
                        <div class="card-body">
                            <form method="post" action="" class="needs-validation" enctype="multipart/form-data" novalidate="">
                              <div class="form-group">
                                <label for="full_name">Nama Lengkap</label>
                                <input id="full_name" type="text" class="form-control" name="full_name" tabindex="1" required autofocus>
                                <div class="invalid-feedback">
                                  Please fill in name
                                </div>
                              </div>
                            <div class="form-group">
                              <label for="email">Email</label>
                              <input id="email" type="email" class="form-control"  name="email" tabindex="1" required autofocus>
                              <div class="invalid-feedback">
                                Please fill in your email
                              </div>
                            </div>
                            <div class="form-group">
                              <input id="created_at_user" type="text" class="form-control" hidden  name="created_at_user" >
                            </div>
                            <div class="form-group">
                              <label for="job">Job</label>
                              <input id="job" type="text" class="form-control"  name="job" tabindex="1" required autofocus>
                              <div class="invalid-feedback">
                                Please fill in your job
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="phone">Phone number</label>
                              <input id="phone" type="tel" class="form-control"  name="phone" tabindex="1" required autofocus>
                              <div class="invalid-feedback">
                                Please fill in your number
                              </div>
                            </div>
                            <div class="form-group">
                                            <label for="gender">Pilih Gender</label>
                                            <select name="gender" id="gender" class="form-control selectric">
                                                <option value="l">Laki-laki</option>
                                                <option value="p">Perempuan</option>
                                            </select>
                                        </div>
                            <div class="form-group">
                                            <label for="roles">Pilih Role</label>
                                            <select name="roles" id="roles" class="form-control selectric">
                                                <option value="author">Author</option>
                                                <option value="user">User</option>
                                            </select>
                                        </div>
                           <div class="form-group">
                                <label  class="form-control-label">Gambar</label>
                                    <div>
                                         <div class="custom-file">
                                           <input type="file" name="avatar" class="custom-file-input" id="avatar">
                                           <label for="avatar" class="custom-file-label">Choose File</label>
                                         </div>
                                  <div class="form-text text-muted">The image must have a maximum size of 5MB</div>
                              </div>
                              </div>
                              <div class="form-group">
                                <label for="bio">
                                     Biografi</label>
                                    <textarea id="bio" name="bio" class="form-control" rows="4" tabindex="5" required></textarea>
                                    <div class="invalid-feedback">
                                     Please fill in your biography
                                    </div>
                              </div>
                            <div class="form-group">
                              <div class="d-block">
                                  <label for="password" class="control-label">Password</label>
                              </div>
                              <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                              <div class="invalid-feedback">
                                please fill in your password
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="d-block">
                                  <label for="confirm_password" class="control-label">Konfirmasi password</label>
                              </div>
                              <input id="confirm_password" type="confirm_password" class="form-control" name="confirm_password" tabindex="2" required>
                              <div class="invalid-feedback">
                                please fill in your password
                              </div>
                            </div>
                            <div class="form-group">
                              <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                Register
                              </button>
                            </div>
                          </form>
                        
          
                        </div>
                      </div>
                      <div class="mt-5 text-muted text-center">
                        Have an account? <a href="login.php">Login</a>
                      </div>
                      <div class="simple-footer">
                        Copyright &copy; Stisla 2018
                      </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <script>
    // Function to get the current date in YYYY-MM-DD format
    function getCurrentDate() {
      const now = new Date();
      const year = now.getFullYear();
      const month = String(now.getMonth() + 1).padStart(2, '0');
      const day = String(now.getDate()).padStart(2, '0');
      return `${year}-${month}-${day}`;
    }

    // Automatically fill the input when the page loads
    document.addEventListener('DOMContentLoaded', () => {
      const dateInput = document.getElementById('created_at_user');
      if (dateInput) {
        dateInput.value = getCurrentDate();
      }
    });

    // Optionally update the value when the input is clicked
    document.getElementById('created_at_user').addEventListener('focus', function() {
      this.value = getCurrentDate();
    });
  </script>
  <!-- General JS Scripts -->
  <script src="../dist/assets/modules/jquery.min.js"></script>
  <script src="../dist/assets/modules/popper.js"></script>
  <script src="../dist/assets/modules/tooltip.js"></script>
  <script src="../dist/assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="../dist/assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="../dist/assets/modules/moment.min.js"></script>
  <script src="../dist/assets/js/stisla.js"></script>
  
  <!-- JS Libraies -->
  <script src="../dist/assets/modules/jquery-pwstrength/jquery.pwstrength.min.js"></script>
  <script src="../dist/assets/modules/jquery-selectric/jquery.selectric.min.js"></script>

  <!-- Page Specific JS File -->
  <script src="../dist/assets/js/page/auth-register.js"></script>
  
  <!-- Template JS File -->
  <script src="../dist/assets/js/scripts.js"></script>
  <script src="../dist/assets/js/custom.js"></script>
</body>
</html>