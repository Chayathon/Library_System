<?php
    include('../conn.php');

    $search_admin = $_GET['search_admin'];
    
    $sql = "SELECT * FROM lib_user
    WHERE u_name LIKE '%$search_admin%'
    AND `u_status` LIKE 'admin'
    ORDER BY u_id ASC";
    $result = mysqli_query($con, $sql) or die ("Error in query: $sql" . mysqli_error());
?>

<!------------------------------------------------------------------ รายการ ------------------------------------------------------------------>

<table class="table table-hover">
    <thead>
        <tr class="table table-active" align="center">
            <th>ไอดี</th>
            <th>ชื่อผู้ใช้</th>
            <th>รหัสผ่าน</th>
            <th>แก้ไข</th>
            <th>ลบ</th>
        </tr>
    </thead>
    <?php foreach($result as $row) { ?>
        <tr align="center">
            <td><?php echo $row['u_id']; ?></td>
            <td><?php echo $row['u_name']; ?></td>
            <td><?php echo $row['u_pass']; ?></td>
            <td><a href="admin_db.php?u_id=<?php echo $row['u_id'];?>" data-bs-toggle="modal" data-bs-target="#update<?php echo $row['u_id'];?>"><img src="../img/logo/edit.png" height="16" id="hover"></a></td>
            <td><a href="admin_db.php?u_id=<?php echo $row['u_id'];?>" data-bs-toggle="modal" data-bs-target="#delete<?php echo $row['u_id'];?>"><img src="../img/logo/delete.png" height="16" id="hover"></a></td>
        </tr>

    <!------------------------------------------------------------------ แก้ไข ------------------------------------------------------------------>

        <div class="modal fade" id="update<?php echo $row['u_id'];?>" tabindex="-1" aria-labelledby="update<?php echo $row['u_id'];?>" aria-hidden="true">
            <div class="modal modal-alert-md d-block" tabindex="-1" role="dialog" id="modalChoice">
                <div class="modal-dialog modal-dialog-md" role="document">
                    <div class="modal-content shadow">
                        <div class="modal-body p-4 text-center">
                            <form class="form-horizontal was-validated" name="update" id="update" method="post" action="admin_db.php">
                                <h5 class="mb-0">แก้ไขข้อมูลผู้ดูแลระบบ</h5><br>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control is-valid" name="u_name" id="u_name" placeholder="ชื่อผู้ใช้" value="<?php echo $row['u_name'];?>" required>
                                    <label for="u_name">ชื่อผู้ใช้</label>
                                    <input class="form-control" type="hidden" name="u_id" id="u_id" value="<?php echo $row['u_id'];?>">
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="password" class="form-control is-invalid" name="u_pass1" id="u_pass1" placeholder="รหัสผ่าน" required>
                                    <label for="u_pass1">รหัสผ่าน</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="password" class="form-control is-invalid" name="u_pass2" id="u_pass2" placeholder="ยืนยันรหัสผ่าน" required>
                                    <label for="u_pass2">ยืนยันรหัสผ่าน</label>
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

            <div class="modal fade" id="delete<?php echo $row['u_id'];?>" tabindex="-1" aria-labelledby="delete<?php echo $row['u_id'];?>" aria-hidden="true">
                <div class="modal modal-alert-sm d-block" tabindex="-1" role="dialog" id="modalChoice">
                    <div class="modal-dialog modal-dialog-sm" role="document">
                        <div class="modal-content shadow">
                            <div class="modal-body p-4 text-center">
                                <form class="form-horizontal was-validated" name="delete" id="delete" method="post" action="admin_db.php">
                                    <h5 class="mb-0">ลบข้อมูลผู้ดูแลระบบ</h5><br>
                                    <p class="mb-0">ยืนยันที่จะลบข้อมูล <b><?php echo $row['u_name'];?></b> ?</p>
                                    <input class="form-control" type="hidden" name="u_id" id="u_id" value="<?php echo $row['u_id'];?>">
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
        </div>
    <?php } ?>
</table>