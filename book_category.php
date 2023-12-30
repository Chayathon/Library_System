<?php
    include('conn.php');
    $ID = $_SESSION['ID'];
    
    $c_id = $_GET['c_id'];

    $sql = "SELECT * FROM lib_book AS b INNER JOIN lib_category AS c ON b.c_id = c.c_id WHERE b.c_id = $c_id ORDER BY b_id ASC";
    $result = mysqli_query($con, $sql) or die ("Error in query: $sql" . mysqli_error());

    $sql_user_join = "SELECT * FROM lib_user AS u INNER JOIN lib_borrow AS br
    ON br.u_id = u.u_id";
    $result_user_join = mysqli_query($con, $sql_user_join) or die ("Error in query: $sql_user_join" . mysqli_error());

    $sql_user = "SELECT * FROM lib_user WHERE u_id = '$ID'";
    $result_user = mysqli_query($con, $sql_user) or die ("Error in query: $sql_user" . mysqli_error());
?>

<div class="container-fluid">
    <div class="row g-2">
        <center>
            <p></p>
            <div class="col-6">
                <?php if(isset($_SESSION['success'])) { ?>
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                        <div>
                            <?php
                                echo $_SESSION['success'];
                                unset($_SESSION['success']);
                            ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if(isset($_SESSION['error'])) { ?>
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                        <div>
                            <?php
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                            ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </center>
        <table class="table table-hover">
            <thead>
                <tr class="table table-active" align="center">
                    <th>ชื่อหนังสือ</th>
                    <th>หมวดหมู่</th>
                    <th>คงเหลือ(เล่ม)</th>
                    <th>ยืม</th>
                </tr>
            </thead>
            <?php foreach($result as $row) { ?>
                <tr align="center">
                    <td><?php echo $row['b_name']; ?></td>
                    <td><?php echo $row['c_name']; ?></td>
                    <td>
                        <?php if($row['b_remaining'] > 0){ echo $row['b_remaining']; } ?>
                        <font color="red"><?php if($row['b_remaining'] <= 0) { echo $row['b_remaining']; } ?></font>
                    </td>
                    <td><a href="borrow_db.php?b_id=<?php echo $row['b_id'];?>" data-bs-toggle="modal" data-bs-target="#borrow<?php echo $row['b_id'];?>"><img src="img/logo/borrow.png" height="16" id="hover"></a></td>
                </tr>

                <div class="modal fade" id="borrow<?php echo $row['b_id'];?>" tabindex="-1" aria-labelledby="borrow<?php echo $row['b_id'];?>" aria-hidden="true">
                    <div class="modal modal-alert-lg d-block" tabindex="-1" role="dialog" id="modalChoice">
                        <div class="modal-dialog modal-dialog-lg" role="document">
                            <div class="modal-content shadow">
                                <div class="modal-body p-4 text-center">
                                    <form class="form-horizontal" name="borrow" id="borrow" method="post" action="borrow_db.php">
                                        <h5 class="mb-0">ยืมหนังสือ</h5><br>
                                        <div class="row">
                                            <div class="col-md-4" align="center">
                                                <?php foreach($result_user as $roww) { ?>
                                                    <b>ผู้ยืม</b><br><br>
                                                    <?php echo $roww['u_name']; ?>
                                                    <input class="form-control" type="hidden" name="u_id" id="u_id" value="<?php echo $roww['u_id'];?>">
                                                <?php } ?>
                                            </div>
                                            <div class="col-md-4" align="center">
                                                <b>หนังสือ</b><br><br>
                                                <?php echo $row['b_name']; ?>
                                                <input class="form-control" type="hidden" name="b_id" id="b_id" value="<?php echo $row['b_id'];?>">
                                            </div>
                                            <div class="col-md-4" align="center">
                                                <b>หมวดหมู่</b><br><br>
                                                <?php echo $row['c_name']; ?>
                                                <input class="form-control" type="hidden" name="c_id" id="c_id" value="<?php echo $row['c_id'];?>">
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-4" align="center">
                                                <b>จำนวน(เล่ม)</b><br><br>
                                                <div class="form mb-2">
                                                    <input class="form-control" type="number" name="borrow_amount" id="borrow_amount" placeholder="จำนวน" min="1" max="<?php echo $row['b_remaining']; ?>" value="1" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4" align="center">
                                                <b>วันที่ยืม</b><br><br>
                                                <input class="form-control" type="datetime-local" name="borrow_date" id="borrow_date" placeholder="วันที่ยืม" value="<?php echo date('D-m-y H:i:s'); ?>" required>
                                                <label for="borrow_date"></label>
                                            </div>
                                            <div class="col-md-4" align="center">
                                                <b>วันที่คืน</b><br><br>
                                                <input class="form-control" type="datetime-local" name="return_date" id="return_date" value="<?php echo date('D-m-y H:i:s'); ?>" required>
                                                <label for="return_date"></label>
                                            </div>
                                        </div>
                                </div>
                                        <div class="modal-footer flex-nowrap p-0">
                                            <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 border-right" data-bs-dismiss="modal">ยกเลิก</button>
                                            <button type="submit" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-1" name="borrow" <?php if($row['b_remaining'] <= 0){ ?> disabled <?php } ?>><font color="green"><strong>ยืม</strong></font></button>
                                        </div>
                                    </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </table>
    </div>
</div>

<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
    </symbol>
    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
    </symbol>
</svg>