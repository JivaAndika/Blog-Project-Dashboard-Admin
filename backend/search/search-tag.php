<?php
require_once __DIR__ . "/../model/model.php";
require_once __DIR__ . "/../model/tags.php";

$key = $_GET['keyCat'];
$tags = new Tags();

$limit = 4;
$pageActive = (isset($_GET['page'] ))  ? ( $_GET['page']) : 1;
$startData = $limit * $pageActive - $limit;
$length = isset($key) && $key ? count($tags->search($key)) : count($tags->all());
$countPage = ceil($length / $limit);
$num = ($pageActive - 1) * $limit + 1;
if(!$key){
  $tags = $tags->pagginate($startData,$limit);
} else{
  $tags = $tags->search($key);
}

?>   

<div class="card-body p-0">
                    <div class="table-responsive" id="container">
                      <table class="table table-striped">
                        <tr>
                          <th>No</th>
                          <th>Nama tag</th>
                          <th>Action</th>
                        </tr>
                        <?php $num = 1 ?>
                        <?php foreach($tags as $tag ):?>
                        <tr>
                          <td><?= $num ?> </td>
                          <td><?= $tag['name_tag'] ?></td>
                          <td>
                            <button href="#" onclick="modalDetails(<?= $tag['id_tag'] ?>, '<?= $tag['name_tag'] ?>') " class="btn btn-primary mr-1"><i class="fas fa-info-circle"></i> Detail</button>
                            <a href="edit-tag.php?id_tag=<?= $tag['id_tag'] ?>" class="btn btn-success mr-1"><i class="far fa-edit"></i> Edit</a>
                            <a href="../services/delete-tag.php?id_tag=<?= $tag['id_tag'] ?>" class="btn btn-danger mr-1"><i class="fas fa-trash"></i> Delete</a>
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