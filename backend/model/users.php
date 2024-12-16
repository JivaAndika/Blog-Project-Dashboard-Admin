<?php
require_once __DIR__ . "/Model.php";


class Users extends Model {
    protected $table = 'users';
    protected $primary_key = "id_user";
    public function create($datas){
        return parent::create_data($datas,$this->table);
    }
    
   

    public function all(){
        return parent::all_data($this->table);
    }
    public function find($id){
        return parent::find_data($id,$this->primary_key,$this->table);
    }
    public function update($id, $datas) {
        $attachment = "";
        $old_avatar = null;
    
        // Ambil avatar lama
        $query = "SELECT avatar FROM {$this->table} WHERE {$this->primary_key} = '$id'";
        $result = mysqli_query($this->db, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            $old_avatar = $user['avatar'];
        }
    
        if ($datas["files"]["avatar"]["name"] !== "") {
            $nama_file = $datas["files"]["avatar"]["name"];
            $tmp_name = $datas["files"]["avatar"]["tmp_name"];
            $ekstensi_file = pathinfo($nama_file, PATHINFO_EXTENSION);
            $ekstensi_allowed = ['jpg', 'jpeg', 'png', 'gif', 'heic', 'raw'];
    
            if (!in_array($ekstensi_file, $ekstensi_allowed)) {
                return "Error: " . $ekstensi_file;
            }
    
            if ($datas["files"]["avatar"]["size"] > 5000000) {
                return "Ukuran file yang anda masukkan terlalu besar";
            }
    
            $nama_file = random_int(1000, 9999) . "." . $ekstensi_file;
            move_uploaded_file($tmp_name, "./../assets/img/users/" . $nama_file);
            $attachment = $nama_file;
    
            // Hapus avatar lama jika ada
            if ($old_avatar && file_exists("./../assets/img/users/" . $old_avatar)) {
                unlink("./../assets/img/users/" . $old_avatar);
            }
        }
    
        $datas = [
            "full_name" => $datas["post"]["full_name"],
            "bio" => $datas["post"]["bio"],
            "email" => $datas["post"]["email"],
            "gender" => $datas["post"]["gender"],
            "phone" => $datas["post"]["phone"]
        ];
        if ($attachment !== '') {
            $datas['avatar'] = $attachment;
        }
        return parent::update_data($id, $this->primary_key, $datas, $this->table);
    }
    
    public function delete($id){
        return parent::delete_data($id,$this->primary_key,$this->table);
    }
    public function register($datas): array|string{
        $name = $datas['post']['full_name'];
        $email = $datas['post']['email'];
        $password = $datas['post']['password'];
        $job = $datas['post']['job'];
        $confirm_password = $datas['post']['confirm_password'];
        $gender = $datas['post']['gender'];
        $bio = $datas['post']['bio'];
        $created_at_user = $datas['post']['created_at_user'];
        $phone = $datas['post']['phone'];
        $avatar = $datas['files']['avatar'];

        if($password !== $confirm_password){
            return "Password dan konfirmasi password harus sama";
        }

        $query = "SELECT * FROM {$this->table} where email= '$email'";
        $result = mysqli_query($this->db, $query);
        if(mysqli_num_rows($result) > 0){
            return "Email sudah terdaftar";
        }
        $nama_file = $datas["files"]["avatar"]["name"];
        $tmp_name = $datas["files"]["avatar"]["tmp_name"];
        $ekstensi_file = pathinfo($nama_file, PATHINFO_EXTENSION);
        $ekstensi_allowed = ['jpg', 'jpeg', 'png', 'gif', 'heic', 'raw'];
        if(!in_array($ekstensi_file,$ekstensi_allowed)){
          return "Error: ".$ekstensi_file;
        }
  
        if($datas["files"]["avatar"]["size"] > 5000000){
          return "Ukuran file yang anda masukkan terlalu besar";
        }

        $nama_file = random_int(1000, 9999) . "." . $ekstensi_file;
        move_uploaded_file($tmp_name, "./../assets/img/users/" . $nama_file);
        $password = base64_encode($password);
        $query_register = "INSERT INTO {$this->table} (full_name , avatar , email, job, password, gender, phone, bio, created_at_user ) VALUES ('$name','$nama_file','$email', '$job', '$password', '$gender', '$phone', '$bio', '$created_at_user')";
        $result = mysqli_query($this->db, $query_register);
        if(!$result){
            return "Registrasi gagal";
        }
        $_SESSION['email'] = $email;
        $_SESSION['avatar'] = $nama_file;
        $detail_user = [
            "name" => $name,
            "email" => $email,
            "avatar" => $nama_file
        ];
        return $detail_user;
    }
    public function login($email,$password){
        $query = "SELECT * FROM {$this->table} WHERE email = '$email'";
        $result = mysqli_query($this->db, $query);
        if(mysqli_num_rows($result) == 0) {
            return "User tidak ditemukan";
        }

        $user = mysqli_fetch_assoc($result);
        if(base64_decode($user['password'], false) !== $password){
            return "Password salah";
        } 
        


        $_SESSION['id'] = $user['id_user'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['job'] = $user['job'];
        $_SESSION['avatar'] = $user['avatar'];
        $_SESSION['phone'] = $user['phone'];
        $_SESSION['gender'] = $user['gender'];
        $_SESSION['bio'] = $user['bio'];
        $detail_user = [
            "full_name" => $user['full_name'],
            "phone" => $user['phone'],
            "job" => $user['job'],
            "gender" => $user['gender'],
            "email" => $user['email'],
            "bio" => $user['bio'],
            "avatar" => $user['avatar']
        ];
        return $detail_user;
     
    }
    public function updatePassword($id, $oldPass, $newPass){
        $query = "SELECT * FROM {$this->table} WHERE {$this->primary_key} = '$id'";
        $result = mysqli_query($this->db, $query);
        if (mysqli_num_rows($result) == 0) {
            return "user tidak ditemukan";
        }
        
        $user = mysqli_fetch_assoc($result);
        if (base64_decode($user['password'], false) !== $oldPass) {
            return "Password lama salah";
        }

        $new_pass = base64_encode($newPass);
        $queryUpdate = "UPDATE {$this->table} SET password = '$new_pass' WHERE {$this->primary_key} = '$id'";
        $resultUpdate = mysqli_query($this->db, $queryUpdate);

        return $resultUpdate;

    }
    public function logout(){
        session_destroy();
        echo "<script>
        alert('Log out berhasil');
        window.location.href = 'login.php';
        </script>";
        exit;
    }
    public function Count_User(){
        $query = "SELECT users.full_name, users.avatar, users.job, users.id_user, COUNT(posts.user_id) AS post_count 
          FROM users 
          JOIN posts
          ON users.id_user = posts.user_id
          GROUP BY users.full_name, users.avatar, users.job, users.id_user";
          $result = mysqli_query($this->db, $query);
          return $this->convert_data($result);
    }

    
}