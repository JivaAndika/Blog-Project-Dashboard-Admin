<?php
require_once __DIR__ . "/../model/model.php";
require_once __DIR__ . "/../model/categories.php";

$key = $_GET['keyCat'];
$kategori = new Categories();

$limit = 3;
$pageActive = (isset($_GET['page'] ))  ? ( $_GET['page']) : 1;
$startData = $limit * $pageActive - $limit;
$length = isset($key) && $key ? count($kategori->search($key)) : count($kategori->all());
$countPage = ceil($length / $limit);
$num = ($pageActive - 1) * $limit + 1;
if(!$key){
  $Categories = $kategori->pagginate($startData,$limit);
} else{
  $Categories = $kategori->search($key);
}

?>   
<div class="card-body p-0">
                    <div class="table-responsive" id="container">
                      <table class="table table-striped">
                        <tr>
                          <th>No</th>
                          <th>Nama kategori</th>
                          <th>Gambar kategori</th>
                          <th>Action</th>
                        </tr>
                        <?php $num = 1 ?>
                        <?php foreach($Categories as $Categorie ):?>
                        <tr>
                          <td><?= $num ?> </td>
                          <td><?= $Categorie['name_category'] ?></td>
                          <td><img src="../assets/img/categories/<?= $Categorie['attachment_category'] ?>" alt="image category" width="80"  class="my-3" ></td>
                          
                          <td>
                            <button href="#" onclick="modalDetails(<?= $Categorie['id_category'] ?>, '<?= $Categorie['name_category'] ?>') " class="btn btn-primary mr-1"><i class="fas fa-info-circle"></i> Detail</button>
                            <a href="edit-kategori.php?id_category=<?= $Categorie['id_category'] ?>" class="btn btn-success mr-1"><i class="far fa-edit"></i> Edit</a>
                            <a href="../services/delete-kategori.php?id_category=<?= $Categorie['id_category'] ?>" class="btn btn-danger mr-1"><i class="fas fa-trash"></i> Delete</a>
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