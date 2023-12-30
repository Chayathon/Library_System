<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        SESSION_START();
        include("head_admin.php");
    ?>
</head>
<body>
    <?php
        include("../conn.php");

        $sql = "SELECT * FROM lib_borrow AS br
        INNER JOIN lib_user AS u ON br.u_id = u.u_id
        INNER JOIN lib_book AS b ON br.b_id = b.b_id
        INNER JOIN lib_category AS c ON br.c_id = c.c_id
        WHERE borrow_status LIKE 3 OR borrow_status LIKE 4";
        $result = mysqli_query($con, $sql) or die ("Error in query: $sql" . mysqli_error());
    ?>

    <?php include("nav_admin.php"); ?>
    <div class="container-fluid">
        <p></p>
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
            <h1 align="center"><b>ครบกำหนด</b></h1>
            <table class="table table-hover">
                <thead>
                    <tr class="table table-active" align="center">
                        <th>ชื่อผู้ยืม</th>
                        <th>หนังสือ</th>
                        <th>ประเภทหนังสือ</th>
                        <th>จำนวน(เล่ม)</th>
                        <th>วันที่ยืม</th>
                        <th>วันที่คืน</th>
                        <th>สถานะ</th>
                        <th>คืน</th>
                    </tr>
                </thead>
                <?php foreach($result as $row) { ?>
                    <tr align="center">
                        <td><?php echo $row['u_name']; ?></td>
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
                                if($row['borrow_status'] == 3)
                                {
                                    echo "<font color='00C3FF'>ครบกำหนดแล้ว</font>";
                                }
                                elseif($row['borrow_status'] == 4)
                                {
                                    echo "<font color='green'>คืนหนังสือแล้ว</font>";
                                }
                            ?>
                        </td>
                        <td><a href="borrow.php?borrow_id=<?php echo $row['borrow_id'];?>" data-bs-toggle="modal" data-bs-target="#borrow<?php echo $row['borrow_id'];?>"><button class="btn btn-sm btn-success">คืนหนังสือแล้ว</button></a></td>
                    </tr>

                    <div class="modal fade" id="borrow<?php echo $row['borrow_id'];?>" tabindex="-1" aria-labelledby="borrow<?php echo $row['borrow_id'];?>" aria-hidden="true">
                        <div class="modal modal-alert-md d-block" tabindex="-1" role="dialog" id="modalChoice">
                            <div class="modal-dialog modal-dialog-md" role="document">
                                <div class="modal-content shadow">
                                    <div class="modal-body p-4 text-center">
                                        <h5 class="mb-0">ตรวจสอบการคืนหนังสือ</h5><br>
                                        <form class="form-horizontal was-validated" name="borrow" id="borrow" method="post" action="borrow_db.php">
                                            <input class="form-control" type="hidden" name="borrow_id" id="borrow_id" value="<?php echo $row['borrow_id'];?>">
                                            <input class="form-control" type="hidden" name="b_id" id="b_id" value="<?php echo $row['b_id'];?>">
                                            <input class="form-control" type="hidden" name="borrow_amount" id="borrow_amount" value="<?php echo $row['borrow_amount'];?>">
                                            <b><?php echo $row['u_name']; ?></b> คืนหนังสือ <b><?php echo $row['b_name'];?></b> จำนวน <b><?php echo $row['borrow_amount']; ?></b> เล่มแล้ว ?
                                    </div>
                                            <div class="modal-footer flex-nowrap p-0">
                                                <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 border-right" data-bs-dismiss="modal">ยังไม่คืน</button>
                                                <button type="submit" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-1" name="return"><font color="green"><b>คืนหนังสือแล้ว</b></font></button>
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