<?php
require_once __DIR__ . "/model.php";

class Posts extends Model {
    protected $table = 'posts';
    protected $primary_key = "id_post";
    

    public function compress_image($source, $destination, $quality) {
      $image_info = getimagesize($source);
      $mime = $image_info['mime'];
  
      if ($mime == 'image/jpeg') {
          $image = imagecreatefromjpeg($source);
          imagejpeg($image, $destination, $quality); // Compress the image
      } elseif ($mime == 'image/png') {
          $image = imagecreatefrompng($source);
          imagepng($image, $destination, (int)($quality / 10)); // Compress the image (quality is between 0-10)
      } elseif ($mime == 'image/gif') {
          $image = imagecreatefromgif($source);
          imagegif($image, $destination); // GIF images are lossless, no compression
      } else {
          return false; // Unsupported image type
      }
  
      return true;
    }
    
  
    public function create($datas){
      $tags_id = $datas['post']['tag_id_pivot'];
  
      if ($datas['files']['attachment_post']['name'] == "") {
          return "Masukkan gambar terlebih dahulu";
      }
  
      $nama_file = $datas["files"]["attachment_post"]["name"];
      $tmp_name = $datas["files"]["attachment_post"]["tmp_name"];
      $ekstensi_file = pathinfo($nama_file, PATHINFO_EXTENSION);
      $ekstensi_allowed = ['jpg', 'jpeg', 'png', 'gif'];
  
      if(!in_array($ekstensi_file, $ekstensi_allowed)) {
          return "Error: ".$ekstensi_file;
      }
  
      if ($datas["files"]["attachment_post"]["size"] > 6000000) {
          return "Ukuran file yang anda masukkan terlalu besar";
      }
  
      // Tentukan path untuk file sementara
      $nama_file = random_int(1000, 9999) . "." . $ekstensi_file;
      $destination = "./../assets/img/posts/" . $nama_file;
  
      // Kompres gambar sebelum menyimpannya
      if (!$this->compress_image($tmp_name, $destination, 75)) {
          return "Gagal mengompres gambar.";
      }
  
      // Simpan data post
      $datas = [
          "tittle" => $datas["post"]["tittle"],
          "content" => $datas["post"]["content"],
          "user_id" => $datas["post"]["user_id"],
          "category_id" => $datas["post"]["category_id"],
          "attachment_post" => $nama_file
      ];
      parent::create_data($datas, $this->table);
  
      // Masukkan data pivot tags
      $query_id = mysqli_insert_id($this->db);
      foreach($tags_id as $tag){
          $query = "INSERT INTO pivot_posts_tags (post_id_pivot, tag_id_pivot) VALUES ('$query_id', '$tag')";
          $result = mysqli_query($this->db, $query);
      }
      return $datas;
  }
    

    public function all(){
        return parent::all_data($this->table);
    }
    public function find($id){
      $query = "SELECT * FROM posts JOIN categories ON posts.category_id = categories.id_category JOIN users on posts.user_id = users.id_user WHERE {$this->primary_key} = $id";
      $result = mysqli_query($this->db, $query);
      return $this->convert_data($result);
    }
    public function update($id, $datas){
      $tags_id = $datas['post']['tag_id_pivot'];
      $attachment = "";
  
      // Cek apakah user mengunggah file baru
      if ($datas["files"]["attachment_post"]["name"] !== "") {
          // Mendapatkan nama file lama dari database
          $query = "SELECT attachment_post FROM {$this->table} WHERE {$this->primary_key} = '$id'";
          $result = mysqli_query($this->db, $query);
          $data = mysqli_fetch_assoc($result);
  
          // Hapus file lama jika ada
          if ($data && !empty($data['attachment_post'])) {
              $file_path = "./../assets/img/posts/" . $data['attachment_post'];
              if (file_exists($file_path)) {
                  unlink($file_path);
              }
          }
  
          // Proses file baru
          $nama_file = $datas["files"]["attachment_post"]["name"];
          $tmp_name = $datas["files"]["attachment_post"]["tmp_name"];
          $ekstensi_file = pathinfo($nama_file, PATHINFO_EXTENSION);
          $ekstensi_allowed = ['jpg', 'jpeg', 'png', 'gif'];
  
          if (!in_array($ekstensi_file, $ekstensi_allowed)) {
              return "Error: " . $ekstensi_file;
          }
  
          if ($datas["files"]["attachment_post"]["size"] > 5000000) {
              return "Ukuran file yang anda masukkan terlalu besar";
          }
  
          $nama_file = random_int(1000, 9999) . "." . $ekstensi_file;
          $destination = "./../assets/img/posts/" . $nama_file;
  
          // Kompres gambar sebelum menyimpannya
          if (!$this->compress_image($tmp_name, $destination, 75)) {
              return "Gagal mengompres gambar.";
          }
          
          $attachment = $nama_file;
      }
      $rawContents = $datas["post"]["content"];
      $rawContent = mysqli_real_escape_string($this->db, $rawContents);
      // Update data post
      $datas = [
          "tittle" => $datas["post"]["tittle"],
          "user_id" => $datas["post"]["user_id"],
          "category_id" => $datas["post"]["category_id"],
          "content" => $rawContents
      ];
      if ($attachment !== '') {
          $datas['attachment_post'] = $attachment;
      }
  
      parent::update_data($id, $this->primary_key, $datas, $this->table);
  
      // Hapus data pivot lama
      $query_delete = "DELETE FROM pivot_posts_tags WHERE post_id_pivot = '$id'";
      $result_delete = mysqli_query($this->db, $query_delete);
  
      // Tambahkan data pivot baru
      foreach ($tags_id as $tag) {
          $query_insert = "INSERT INTO pivot_posts_tags (post_id_pivot, tag_id_pivot) VALUES ('$id', '$tag')";
          $result = mysqli_query($this->db, $query_insert);
      }
  }
  
  
    public function delete($id){
      $query = "SELECT attachment_post FROM {$this->table} WHERE {$this->primary_key} = '$id'";
      $result = mysqli_query($this->db, $query);
      $data = mysqli_fetch_assoc($result);
  
      // Menghapus file gambar jika ada
      if ($data && !empty($data['attachment_post'])) {
          $file_path = "./../assets/img/posts/" . $data['attachment_post'];
          if (file_exists($file_path)) {
              unlink($file_path);
          }
      }
      $query_delete = "DELETE FROM pivot_posts_tags WHERE post_id_pivot = '$id'";
      $result_delete = mysqli_query($this->db, $query_delete);
      parent::delete_data($id,$this->primary_key,$this->table);
      return true;
    }
    public function search($keyword, $startData = null, $limit = null){
        $queryLimit = "";
        if(isset($limit) && isset($startData)){
            $queryLimit = "LIMIT $startData, $limit";
        }
        $keyword = "WHERE tittle LIKE '%{$keyword}%' $queryLimit";
        $query = "SELECT * FROM posts JOIN categories ON posts.category_id = categories.id_category JOIN users on posts.user_id = users.id_user $keyword";
        $result = mysqli_query($this->db, $query);
        return $this->convert_data($result);
    }
    public function pagginate($startData,$limit,$order){
      $query = "SELECT * FROM {$this->table} $order LIMIT $startData, $limit";
      $order = " order by tittle";
      $result = mysqli_query($this->db, $query);
      return $this->convert_data($result);
    }

    public function all2($starData,$limit){
        $query = 
        "SELECT * FROM posts JOIN categories ON posts.category_id = categories.id_category JOIN users on posts.user_id = users.id_user LIMIT $starData , $limit ";
        $result = mysqli_query($this->db,$query);
        return $this->convert_data($result);
    }
    public function create_tags($tags_id)
    {
        $query_id = mysqli_insert_id($this->db);
        foreach ($tags_id as $tag) {
            $query = "INSERT INTO pivot_posts_tags (post_id_pivot, tag_id_pivot) VALUES ('$query_id', '$tag')";

            $result = mysqli_query($this->db, $query);
        }
    }
    public function ShowLatestPosts(){
      $query = "SELECT * FROM posts ORDER BY posts.id_post DESC LIMIT 4";
      $result = mysqli_query($this->db, $query);
      return $this->convert_data($result);
    }

    public function SelectPostAsCategory($id_category){
    
      $query = "SELECT 
      posts.*,
      users.full_name,
      users.avatar,
      categories.name_category
      FROM
      categories
      JOIN posts ON categories.id_category = posts.category_id
      JOIN users ON posts.user_id = users.id_user
      WHERE id_category = $id_category";

      $result = mysqli_query($this->db, $query);
      return $this->convert_data($result);
    }

    public function SelectPostAsTag($id_tag){
      $query = "SELECT posts.*, 
      users.full_name, 
      users.avatar, 
      categories.name_category 
      FROM posts 
      JOIN categories 
      ON posts.category_id = categories.id_category 
      JOIN users 
      ON posts.user_id = users.id_user 
      JOIN pivot_posts_tags 
      ON pivot_posts_tags.post_id_pivot = posts.id_post
      WHERE pivot_posts_tags.tag_id_pivot = $id_tag";
      $result = mysqli_query($this->db, $query);
      return $this->convert_data($result);
    }
    public function SelectPostAsAuthor($id_user){
      $query = "SELECT posts.*,
      users.*,
      categories.name_category
      FROM posts
      JOIN categories ON posts.category_id = categories.id_category
      JOIN users ON posts.user_id = users.id_user
      WHERE user_id = $id_user";
      $result = mysqli_query($this->db, $query);
      return $this->convert_data($result);
    }

    public function FindPostAsBlog($id_post){
      $query = "SELECT posts.*, categories.*, users.*, pivot_posts_tags.*,  tags.* FROM posts JOIN categories ON posts.category_id = categories.id_category JOIN users ON posts.user_id = users.id_user JOIN pivot_posts_tags ON pivot_posts_tags.post_id_pivot = posts.id_post JOIN tags ON pivot_posts_tags.tag_id_pivot = tags.id_tag WHERE posts.id_post = $id_post";
      $result = mysqli_query($this->db, $query);
      return $this->convert_data($result);

    }

    public function RecommendPost(){
      $query = "SELECT posts.*, users.full_name, users.avatar FROM posts JOIN users ON posts.user_id = users.id_user ORDER BY RAND() LIMIT 4";
      $result = mysqli_query($this->db, $query);
      return $this->convert_data($result);
    }

    public function SelectPostLikeCategory($id , $exclude_id){
      $query = "SELECT posts.*, users.full_name, users.avatar, categories.name_category 
                FROM posts 
                JOIN categories ON posts.category_id = categories.id_category 
                JOIN users ON posts.user_id = users.id_user 
                WHERE posts.category_id = {$id} AND posts.id_post != {$exclude_id}
                ORDER BY posts.id_post DESC 
                LIMIT 4 
               ";
      $result = mysqli_query($this->db, $query);
      return $this->convert_data($result);
    }
}

// "SELECT posts.id_post, posts.content, posts.attachment_post, posts.tittle, categories.name_category, posts.user_id, users.full_name, users.avatar, pivot_posts_tags.post_id_pivot, pivot_posts_tags.tag_id_pivot, tags.name_tag FROM posts JOIN categories ON posts.category_id = categories.id_category JOIN users ON posts.user_id = users.id_user JOIN pivot_posts_tags ON pivot_posts_tags.post_id_pivot = posts.id_post JOIN tags ON pivot_posts_tags.tag_id_pivot = tags.id_tag";