<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("head.php"); ?>
</head>
<body>
    <?php
        SESSION_START();
        include("conn.php");
        include("navbar.php");

        if(!isset($_SESSION['user']))
        {
            echo "<script type='text/javascript'>";
            echo "window.history.back();";
            echo "</script>";
        }

        $ID = $_SESSION['ID'];

        $sql = "SELECT * FROM lib_borrow AS br
        INNER JOIN lib_user AS u ON br.u_id = u.u_id
        INNER JOIN lib_book AS b ON br.b_id = b.b_id
        INNER JOIN lib_category AS c ON br.c_id = c.c_id
        WHERE br.u_id = '$ID'";
        $result = mysqli_query($con, $sql) or die ("Error in query:" . mysqli_error());
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
                        <th>จำนวน(เล่ม)</th>
                        <th>วันที่ยืม</th>
                        <th>วันที่คืน</th>
                        <th>สถานะ</th>
                        <th>ยกเลิก</th>
                        <th>แก้ไข</th>
                        <th>คืน</th>
                    </tr>
                </thead>
                <?php foreach($result as $row) { ?>
                    <tr align="center">
                        <td><?php echo $row['b_name']; ?></td>
                        <td><?php echo $row['c_name']; ?></td>
                        <td><?php echo $row['borrow_amount']; ?></td>
                        <td><?php echo $row['borrow_date']; ?></td>
                        <td>
                            <?php if($date <= $row['return_date']) { echo $row['return_date']; } ?>
                            <font color="00B0FF"><?php if($date >= $row['return_date']) { echo $row['return_date']; } ?></font>
                        </td>
                        <td>
                            <?php
                                if($row['borrow_status'] == 1)
                                {
                                    echo "<font color='FFD000'>รออนุมัติ</font>";
                                }
                                elseif($row['borrow_status'] == 2)
                                {
                                    echo "<font color='green'>อนุมัติแล้ว</font>";
                                }
                                elseif($row['borrow_status'] == 3)
                                {
                                    echo "<font color='00C3FF'>ครบกำหนดแล้ว</font>";
                                }
                                elseif($row['borrow_status'] == 4)
                                {
                                    echo "<font color='0BE000'>คืนหนังสือแล้ว</font>";
                                }
                                else
                                {
                                    echo "<font color='red'>ไม่อนุมัติ</font>";
                                }
                            ?>
                        </td>
                        <td width="4%"><a href="borrow_db.php?borrow_id=<?php echo $row['borrow_id'];?>" data-bs-toggle="modal" data-bs-target="#cancel<?php echo $row['borrow_id'];?>"><img src="img/logo/cancel.png" height="16" id="hover"></a></td>
                        <td width="4%"><a href="borrow_db.php?borrow_id=<?php echo $row['borrow_id'];?>" data-bs-toggle="modal" data-bs-target="#update<?php echo $row['borrow_id'];?>"><img src="img/logo/edit.png" height="16" id="hover"></a></td>
                        <td width="4%"><a href="borrow_db.php?borrow_id=<?php echo $row['borrow_id'];?>" data-bs-toggle="modal" data-bs-target="#return<?php echo $row['borrow_id'];?>"><img src="img/logo/return.png" height="16" id="hover"></a></td>
                    </tr>

                <!-------------------------------------------------------------------- ยกเลิก -------------------------------------------------------------------->

                    <div class="modal fade" id="cancel<?php echo $row['borrow_id'];?>" tabindex="-1" aria-labelledby="cancel<?php echo $row['borrow_id'];?>" aria-hidden="true">
                        <div class="modal modal-alert-md d-block" tabindex="-1" role="dialog" id="modalChoice">
                            <div class="modal-dialog modal-dialog-md" role="document">
                                <div class="modal-content shadow">
                                    <div class="modal-body p-4 text-center">
                                        <form class="form-horizontal was-validated" name="cancel" id="cancel" method="post" action="borrow_db.php">
                                            <h5 class="mb-0">ยกเลิกการยืมหนังสือ</h5><br>
                                            <input class="form-control" type="hidden" name="borrow_id" id="borrow_id" value="<?php echo $row['borrow_id'];?>">
                                            ยืนยันที่จะยกเลิกยืมหนังสือ <b><?php echo $row['b_name'];?></b> จำนวน <b><?php echo $row['borrow_amount']; ?></b> เล่ม ?
                                    </div>
                                            <div class="modal-footer flex-nowrap p-0">
                                                <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 border-right" data-bs-dismiss="modal">ยกเลิก</button>
                                                <button type="submit" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-1" name="cancel" <?php if(($row['borrow_status'] > 1) and ($row['borrow_status'] < 5)) { ?> disabled <?php } ?>><font color="green"><b>ยืนยัน</b></font></button>
                                            </div>
                                        </form>
                                </div>
                            </div>
                        </div>
                    </div>

                <!-------------------------------------------------------------------- แก้ไข -------------------------------------------------------------------->

                    <div class="modal fade" id="update<?php echo $row['borrow_id'];?>" tabindex="-1" aria-labelledby="update<?php echo $row['borrow_id'];?>" aria-hidden="true">
                        <div class="modal modal-alert-lg d-block" tabindex="-1" role="dialog" id="modalChoice">
                            <div class="modal-dialog modal-dialog-lg" role="document">
                                <div class="modal-content shadow">
                                    <div class="modal-body p-4 text-center">
                                        <form class="form-horizontal was-validated" name="borrow" id="borrow" method="post" action="borrow_db.php">
                                            <h5 class="mb-0">แก้ไขการยืมหนังสือ</h5><br>
                                            <div class="row">
                                                <div class="col-md-4" align="center">
                                                    <b>ผู้ยืม</b><br><br>
                                                    <?php echo $row['u_name']; ?>
                                                    <input class="form-control" type="hidden" name="borrow_id" id="borrow_id" value="<?php echo $row['borrow_id'];?>">
                                                </div>
                                                <div class="col-md-4" align="center">
                                                    <b>หนังสือ</b><br><br>
                                                    <?php echo $row['b_name']; ?>
                                                </div>
                                                <div class="col-md-4" align="center">
                                                    <b>หมวดหมู่</b><br><br>
                                                    <?php echo $row['c_name']; ?>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-4" align="center">
                                                    <b>จำนวน(เล่ม)</b><br><br>
                                                    <div class="form mb-2">
                                                        <input class="form-control is-valid" type="number" name="borrow_amount" id="borrow_amount" placeholder="จำนวน" min="1" max="<?php echo $row['b_remaining']; ?>" value="1" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" align="center">
                                                    <b>วันที่ยืม</b><br><br>
                                                    <input class="form-control is-valid" type="datetime-local" name="borrow_date" id="borrow_date" value="<?php echo date('d-m-Y H:i:s'); ?>" required>
                                                    <label for="borrow_date"></label>
                                                </div>
                                                <div class="col-md-4" align="center">
                                                    <b>วันที่คืน</b><br><br>
                                                    <input class="form-control is-valid" type="datetime-local" name="return_date" id="return_date" value="<?php echo date('d-m-Y H:i:s'); ?>" required>
                                                    <label for="return_date"></label>
                                                </div>
                                            </div>
                                    </div>
                                            <div class="modal-footer flex-nowrap p-0">
                                                <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 border-right" data-bs-dismiss="modal">ยกเลิก</button>
                                                <button type="submit" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-1" name="update" <?php if($row['b_remaining'] <= 0) { ?> disabled <?php } ?> <?php if($row['borrow_status'] > 1) { ?> disabled <?php } ?>><font color="FFC100"><b>แก้ไข</b></font></button>
                                            </div>
                                        </form>
                                </div>
                            </div>
                        </div>
                    </div>

                <!-------------------------------------------------------------------- คืน -------------------------------------------------------------------->

                    <div class="modal fade" id="return<?php echo $row['borrow_id'];?>" tabindex="-1" aria-labelledby="return<?php echo $row['borrow_id'];?>" aria-hidden="true">
                        <div class="modal modal-alert-md d-block" tabindex="-1" role="dialog" id="modalChoice">
                            <div class="modal-dialog modal-dialog-md" role="document">
                                <div class="modal-content shadow">
                                    <div class="modal-body p-4 text-center">
                                        <form class="form-horizontal was-validated" name="return" id="return" method="post" action="borrow_db.php">
                                            <h5 class="mb-0">คืนหนังสือ</h5><br>
                                            ยืนยันที่จะคืนหนังสือ <b><?php echo $row['b_name'];?></b> จำนวน <b><?php echo $row['borrow_amount']; ?></b> เล่ม ?
                                            <input class="form-control" type="hidden" name="borrow_id" id="borrow_id" value="<?php echo $row['borrow_id'];?>">
                                    </div>
                                            <div class="modal-footer flex-nowrap p-0">
                                                <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 border-right" data-bs-dismiss="modal">ยกเลิก</button>
                                                <button type="submit" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-1" name="return" <?php if(($row['borrow_status'] < 2) || ($row['borrow_status'] > 3)) { ?> disabled <?php } ?>><font color="blue"><b>คืน</b></font></button>
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
</body>
</html>

<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
    </symbol>
    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
    </symbol>
</svg>