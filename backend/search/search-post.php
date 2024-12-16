<?php
require_once __DIR__ . "/../model/posts.php";
require_once __DIR__ . "/../model/model.php";


if (!isset($_SESSION['full_name'])){
    echo "<script>
    window.location.href = 'login.php';
    </script>";
    exit;
  }
$key = $_GET['keyCat'];
$post = new Posts();

$limit = 3;
$pageActive = (isset($_GET['page'] ))  ? ( $_GET['page']) : 1;
$startData = $limit * $pageActive - $limit;
$length = isset($key) && $key ? count($post->search($key)) : count($post->all());
$countPage = ceil($length / $limit);
$num = ($pageActive - 1) * $limit + 1;
if(!$key){
  $Posts = $post->all2($startData,$limit);
} else{
  $Posts = $post->search($key);
}
?>

<div class="card-body p-0">
                    <div class="table-responsive" id="container">
                      <table class="table table-striped">
                        <tr>
                          <th>No</th>
                          <th>Judul Post</th>
                          <th>Gambar Post</th>
                          <th>Author</th>
                          <th>Action</th>
                        </tr>
                        <?php $num = 1 ?>
                        <?php foreach($Posts as $post ):?>
                        <tr>
                          <td><?= $num ?> </td>
                          <td ><?= $post['tittle'] ?></td>
                          <td><img src="../assets/img/posts/<?= $post['attachment_post'] ?>" alt="image category" width="80"  class="my-3" ></td>
                          <td data-value="<?= $post['user_id'] ?>"><?= $post['full_name'] ?></td>
                          
                          
                          <td>
                            <button href="#" onclick="modalDetails('<?= $post['content'] ?>') " class="btn btn-primary mr-1"><i class="fas fa-info-circle"></i> Detail</button>
                            <a href="edit-post.php?id_post=<?= $post['id_post'] ?>" class="btn btn-success mr-1"><i class="far fa-edit"></i> Edit</a>
                            <a href="../services/delete-post.php?id_post=<?= $post['id_post'] ?>" class="btn btn-danger mr-1"><i class="fas fa-trash"></i> Delete</a>
                        </td>
                        </tr>
                        <?php $num++ ?>


                        <?php endforeach ?>
                      </table>
                      <div class="d-flex justify-content-center"> 
                        <nav aria-label="Page navigation">
                          <ul class="pagination">
                            <li class="page-item ">
                              <?php if ($pageActive > 1):?>
                              <a class="page-link" href="?page=<?= $prev ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                              </a>
                              <?php endif;?>
                            </li>
                            <?php for ($i = 1; $i <= $countPage; $i++): ?>
                              <li class="page-item">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                              </li>
                              <?php endfor; ?>
                            <li class="page-item">
                              <?php if ($pageActive < $countPage):?>
                              <a class="page-link" href="?page=<?= $next ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                              </a>
                              <?php endif;?>
                            </li>
                          </ul>
                        </nav>
                      </div>
                    </div>
                  </div>