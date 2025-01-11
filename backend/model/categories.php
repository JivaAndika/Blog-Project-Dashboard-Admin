<?php
require_once __DIR__ . "/model.php";

// define("TABLE","cars");
class Categories extends Model {
    protected $table = 'categories';
    protected $primary_key = "id_category";
    public function create($datas){
        $nama_file = $datas["files"]["attachment_category"]["name"];
        $tmp_name = $datas["files"]["attachment_category"]["tmp_name"];
        $ekstensi_file = pathinfo($nama_file, PATHINFO_EXTENSION);
        $ekstensi_allowed = ['jpg', 'jpeg', 'png', 'gif'];
    
        if (!in_array($ekstensi_file, $ekstensi_allowed)) {
            return "Error: " . $ekstensi_file;
        }
    
        if ($datas["files"]["attachment_category"]["size"] > 6000000) {
            return "Ukuran file yang anda masukkan terlalu besar";
        }
    
        $nama_file_baru = random_int(1000, 9999) . "." . $ekstensi_file;
        $upload_path = "./../assets/img/categories/" . $nama_file_baru;
    
        // Remove background and resize image
        list($width, $height) = getimagesize($tmp_name);
        $new_width = 99;
        $new_height = 99;
    
        $image_p = imagecreatetruecolor($new_width, $new_height);
    
        switch (strtolower($ekstensi_file)) {
            case 'jpg':
            case 'jpeg':
                $image = imagecreatefromjpeg($tmp_name);
                break;
            case 'png':
                $image = imagecreatefrompng($tmp_name);
                break;
            case 'gif':
                $image = imagecreatefromgif($tmp_name);
                break;
            default:
                return "Error: unsupported file type";
        }
    
        // Remove background (simulate by making it transparent for PNG/GIF)
        imagesavealpha($image_p, true);
        $transparent = imagecolorallocatealpha($image_p, 0, 0, 0, 127);
        imagefill($image_p, 0, 0, $transparent);
    
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    
        // Save the resized image
        switch (strtolower($ekstensi_file)) {
            case 'jpg':
            case 'jpeg':
                imagejpeg($image_p, $upload_path);
                break;
            case 'png':
                imagepng($image_p, $upload_path);
                break;
            case 'gif':
                imagegif($image_p, $upload_path);
                break;
        }
    
        imagedestroy($image);
        imagedestroy($image_p);
    
        $datas = [
            "name_category" => $datas["post"]["name_category"],
            "attachment_category" => $nama_file_baru
        ];
    
        return parent::create_data($datas, $this->table);
    }
    public function all(){
        return parent::all_data($this->table);
    }
    public function find($id){
        return parent::find_data($id,$this->primary_key,$this->table);
    }
    public function update($id, $datas) {
        $attachment = "";
        
        // Cek jika ada file yang diupload
        if ($datas["files"]["attachment_category"]["name"] !== "") {
            // Mendapatkan nama file lama dari database
            $query = "SELECT attachment_category FROM {$this->table} WHERE {$this->primary_key} = '$id'";
            $result = mysqli_query($this->db, $query);
            $data = mysqli_fetch_assoc($result);
    
            // Proses upload file baru
            $nama_file = $datas["files"]["attachment_category"]["name"];
            $tmp_name = $datas["files"]["attachment_category"]["tmp_name"];
            $ekstensi_file = pathinfo($nama_file, PATHINFO_EXTENSION);
            $ekstensi_allowed = ['jpg', 'jpeg', 'png', 'gif'];
    
            if (!in_array($ekstensi_file, $ekstensi_allowed)) {
                return "Error: " . $ekstensi_file;
            }
    
            if ($datas["files"]["attachment_category"]["size"] > 6000000) {
                return "Ukuran file yang anda masukkan terlalu besar";
            }
    
            $nama_file_baru = random_int(1000, 9999) . "." . $ekstensi_file;
            $upload_path = "./../assets/img/categories/" . $nama_file_baru;
    
            // Remove background and resize image
            list($width, $height) = getimagesize($tmp_name);
            $new_width = 99;
            $new_height = 99;
    
            $image_p = imagecreatetruecolor($new_width, $new_height);
    
            switch (strtolower($ekstensi_file)) {
                case 'jpg':
                case 'jpeg':
                    $image = imagecreatefromjpeg($tmp_name);
                    break;
                case 'png':
                    $image = imagecreatefrompng($tmp_name);
                    break;
                case 'gif':
                    $image = imagecreatefromgif($tmp_name);
                    break;
                default:
                    return "Error: unsupported file type";
            }
    
            // Remove background (simulate by making it transparent for PNG/GIF)
            imagesavealpha($image_p, true);
            $transparent = imagecolorallocatealpha($image_p, 0, 0, 0, 127);
            imagefill($image_p, 0, 0, $transparent);
    
            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    
            // Save the resized image
            switch (strtolower($ekstensi_file)) {
                case 'jpg':
                case 'jpeg':
                    imagejpeg($image_p, $upload_path);
                    break;
                case 'png':
                    imagepng($image_p, $upload_path);
                    break;
                case 'gif':
                    imagegif($image_p, $upload_path);
                    break;
            }
    
            imagedestroy($image);
            imagedestroy($image_p);
    
            $attachment = $nama_file_baru;
    
            // Hapus file lama jika ada
            if ($data && !empty($data['attachment_category'])) {
                $file_path = "./../assets/img/categories/" . $data['attachment_category'];
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
        }
    
        // Update data di database
        $update_data = [
            "name_category" => $datas["post"]["name_category"]
        ];
    
        if ($attachment !== "") {
            $update_data["attachment_category"] = $attachment;
        }
    
        return parent::update_data($id, $this->primary_key, $update_data, $this->table);
    }
    
    
    public function delete($id){
        return parent::delete_data($id,$this->primary_key,$this->table);
    }
    public function search($keyword, $startData = null, $limit = null){
        $queryLimit = "";
        if(isset($limit) && isset($startData)){
            $queryLimit = "LIMIT $startData, $limit";
          }
        $keyword = "WHERE name_category LIKE '%{$keyword}%' $queryLimit";
        return parent::search_data($keyword, $this->table);
    }
    public function pagginate($starData,$limit){
       
        $keyword = "LIMIT $starData , $limit";
        return parent::paggination_data($starData,$limit, $this->table);
    }
}