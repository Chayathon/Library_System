<?php
    include('../conn.php');

    $search_cate = $_GET['search_cate'];
    
    $sql = "SELECT * FROM `lib_category`
    WHERE c_name LIKE '%$search_cate%'
    ORDER BY c_id ASC";
    $result = mysqli_query($con, $sql) or die ("Error in query: $sql" . mysqli_error());
?>

<!-------------------------------------------------------------------- รายการ -------------------------------------------------------------------->

<table class="table table-hover">
    <thead>
        <tr class="table table-active" align="center">
            <th>ไอดี</th>
            <th>ชื่อหมวดหมู่</th>
            <th>แก้ไข</th>
            <th>ลบ</th>
        </tr>
    </thead>
    <?php foreach($result as $row) { ?>
        <tr align="center">
            <td><?php echo $row['c_id']; ?></td>
            <td><?php echo $row['c_name']; ?></td>
            <td><a href="cate_db.php?c_id=<?php echo $row['c_id'];?>" data-bs-toggle="modal" data-bs-target="#update<?php echo $row['c_id'];?>"><img src="../img/logo/edit.png" height="16" id="hover"></a></td>
            <td><a href="cate_db.php?c_id=<?php echo $row['c_id'];?>" data-bs-toggle="modal" data-bs-target="#delete<?php echo $row['c_id'];?>"><img src="../img/logo/delete.png" height="16" id="hover"></a></td>
        </tr>

    <!------------------------------------------------------------------ แก้ไข ------------------------------------------------------------------>
        
        <div class="modal fade" id="update<?php echo $row['c_id'];?>" tabindex="-1" aria-labelledby="update<?php echo $row['c_id'];?>" aria-hidden="true">
            <div class="modal modal-alert-md d-block" tabindex="-1" role="dialog" id="modalChoice">
                <div class="modal-dialog modal-dialog-md" role="document">
                    <div class="modal-content shadow">
                        <div class="modal-body p-4 text-center">
                            <form class="form-horizontal was-validated" name="update" id="update" method="post" action="cate_db.php">
                                <h5 class="mb-0">แก้ไขหมวดหมู่</h5><br>
                                <div class="form-floating">
                                    <input class="form-control is-valid" type="text" name="c_name" id="c_name" placeholder="ชื่อหมวดหมู่" value="<?php echo $row['c_name'];?>" required>
                                    <label for="c_name">ชื่อหมวดหมู่</label>
                                    <input class="form-control" type="hidden" name="c_id" id="c_id" value="<?php echo $row['c_id'];?>">
                                </div>
                        </div>
                                <div class="modal-footer flex-nowrap p-0">
                                    <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 border-right" data-bs-dismiss="modal">ยกเลิก</button>
                                    <button type="submit" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-1" name="update"><font color="FFC100"><b>แก้ไข</b></font></button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>

    <!------------------------------------------------------------------ ลบ ------------------------------------------------------------------>
        
        <div class="modal fade" id="delete<?php echo $row['c_id'];?>" tabindex="-1" aria-labelledby="delete<?php echo $row['c_id'];?>" aria-hidden="true">
            <div class="modal modal-alert-sm d-block" tabindex="-1" role="dialog" id="modalChoice">
                <div class="modal-dialog modal-dialog-sm" role="document">
                    <div class="modal-content shadow">
                        <div class="modal-body p-4 text-center">
                            <form class="form-horizontal was-validated" name="delete" id="delete" method="post" action="cate_db.php">
                                <h5 class="mb-0">ลบหมวดหมู่</h5><br>
                                ยืนยันที่จะลบหมวดหมู่ <b><?php echo $row['c_name'];?></b> ?
                                <input class="form-control" type="hidden" name="c_id" id="c_id" value="<?php echo $row['c_id'];?>">
                        </div>
                                <div class="modal-footer flex-nowrap p-0">
                                    <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 border-right" data-bs-dismiss="modal">ยกเลิก</button>
                                    <button type="submit" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-1" name="delete"><font color="red"><b>ลบ</b></font></button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</table>