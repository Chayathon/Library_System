<?php
    include('../conn.php');

    $search_book = $_GET['search_book'];
    
    $sql = "SELECT * FROM `lib_book` AS b INNER JOIN `lib_category` AS c ON b.c_id = c.c_id
    WHERE b.b_name LIKE '%$search_book%'
    OR c.c_name LIKE '%$search_book%'
    ORDER BY b_id ASC";
    $result = mysqli_query($con, $sql) or die ("Error in query: $sql" . mysqli_error());
?>

<!-------------------------------------------------------------------- รายการ -------------------------------------------------------------------->

<table class="table table-hover">
    <thead>
        <tr class="table table-active" align="center">
            <th>ไอดี</th>
            <th>ชื่อหนังสือ</th>
            <th>หมวดหมู่</th>
            <th>คงเหลือ</th>
            <th>จำนวนทั้งหมด</th>
            <th>แก้ไข</th>
            <th>ลบ</th>
        </tr>
    </thead>
    <?php foreach($result as $row) { ?>
        <tr align="center">
            <td><?php echo $row['b_id']; ?></td>
            <td><?php echo $row['b_name']; ?></td>
            <td><?php echo $row['c_name']; ?></td>
            <td>
                <?php if($row['b_remaining'] > 0){ echo $row['b_remaining']; } ?>
                <font color="red"><?php if($row['b_remaining'] <= 0) { echo $row['b_remaining']; } ?></font>
            </td>
            <td><?php echo $row['b_amount']; ?></td>
            <td><a href="book_db.php?b_id=<?php echo $row['b_id'];?>" data-bs-toggle="modal" data-bs-target="#update<?php echo $row['b_id'];?>"><img src="../img/logo/edit.png" height="16" id="hover"></a></td>
            <td><a href="book_db.php?b_id=<?php echo $row['b_id'];?>" data-bs-toggle="modal" data-bs-target="#delete<?php echo $row['b_id'];?>"><img src="../img/logo/delete.png" height="16" id="hover"></a></td>
        </tr>

    <!------------------------------------------------------------------ แก้ไข ------------------------------------------------------------------>
        
        <div class="modal fade" id="update<?php echo $row['b_id'];?>" tabindex="-1" aria-labelledby="update<?php echo $row['b_id'];?>" aria-hidden="true">
            <div class="modal modal-alert-md d-block" tabindex="-1" role="dialog" id="modalChoice">
                <div class="modal-dialog modal-dialog-md" role="document">
                    <div class="modal-content shadow">
                        <div class="modal-body p-4 text-center">
                            <form class="form-horizontal was-validated" name="update" id="update" method="post" action="book_db.php">
                                <h5 class="mb-0">แก้ไขหนังสือ</h5><br>
                                <div class="form-floating mb-2">
                                    <input class="form-control is-valid" type="text" name="b_name" id="b_name" placeholder="ชื่อหนังสือ" value="<?php echo $row['b_name'];?>" required>
                                    <label for="b_name">ชื่อหนังสือ</label>
                                    <input class="form-control" type="hidden" name="b_id" id="b_id" value="<?php echo $row['b_id'];?>">
                                </div>
                                <div class="form-floating mb-2">
                                    <select class="form-select is-valid" name="c_id" id="c_id" aria-label="Floating label select example" required>
                                        <option selected value="<?php echo $row['c_id'];?>"><?php echo $row['c_name'];?></option>
                                        <?php foreach ($result_cate as $results) { ?>
                                            <option value="<?php echo $results['c_id'];?>"><?php echo $results['c_name'];?></option>
                                        <?php } ?>
                                    </select>
                                    <label for="c_id">หมวดหมู่</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input class="form-control is-valid" type="number" name="b_remaining" id="b_remaining" placeholder="คงเหลือ" min="0" value="<?php echo $row['b_remaining'];?>" required>
                                    <label for="b_remaining">คงเหลือ</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input class="form-control is-valid" type="number" name="b_amount" id="b_amount" placeholder="จำนวนทั้งหมด" min="0" value="<?php echo $row['b_amount'];?>" required>
                                    <label for="b_amount">จำนวนทั้งหมด</label>
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
        
        <div class="modal fade" id="delete<?php echo $row['b_id'];?>" tabindex="-1" aria-labelledby="delete<?php echo $row['b_id'];?>" aria-hidden="true">
            <div class="modal modal-alert-sm d-block" tabindex="-1" role="dialog" id="modalChoice">
                <div class="modal-dialog modal-dialog-sm" role="document">
                    <div class="modal-content shadow">
                        <div class="modal-body p-4 text-center">
                            <form class="form-horizontal was-validated" name="delete" id="delete" method="post" action="book_db.php">
                                <h5 class="mb-0">ลบหนังสือ</h5><br>
                                ยืนยันที่จะลบหนังสือ <b><?php echo $row['b_name'];?></b> ?
                                <input class="form-control" type="hidden" name="b_id" id="b_id" value="<?php echo $row['b_id'];?>">
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