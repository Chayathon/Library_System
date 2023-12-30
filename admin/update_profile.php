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

        $ID = $_SESSION["ID"];

        $sql = "SELECT * FROM lib_user WHERE u_id = '$ID'";
        $result = mysqli_query($con, $sql) or die ("Error in query: $sql" . mysqli_error());
        $row = mysqli_fetch_array($result);
        extract($row);
    ?>

    <?php include("nav_admin.php"); ?>
    <p></p>
    <div class="container-fluid">
        <div class="row">
            <div class="center">
                <center>
                    <div class="col-md-4">
                        <div class="shadow-lg p-3 mb-5 bg-body rounded">
                            <form class="form-horizontal was-validated" action="update_profile.php" name="member_update" id="member_update" method="POST">
                                <h3>แก้ไขโปรไฟล์</h3>
                                <p></p>
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
                                <p></p>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control is-valid" name="u_name" id="u_name" placeholder="ชื่อผู้ใช้" value="<?php echo $u_name;?>" required>
                                    <label for="u_name">ชื่อผู้ใช้</label>
                                    <input class="form-control" type="hidden" name="u_id" id="u_id" value="<?php echo $u_id;?>">
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="password" class="form-control is-invalid" name="u_pass1" id="u_pass1" placeholder="รหัสผ่าน" required>
                                    <label for="u_pass1">รหัสผ่าน</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="password" class="form-control is-invalid" name="u_pass2" id="u_pass2" placeholder="ยืนยันรหัสผ่าน" required>
                                    <label for="u_pass2">ยืนยันรหัสผ่าน</label>
                                </div>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-warning" type="submit" name="submit">แก้ไข</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </center>
            </div>
        </div>
    </div>
</body>
</html>

<?php
    if(isset($_POST['submit']))
    {
        $errors = array();

        $u_id = $_POST["u_id"];
        $u_name = $_POST["u_name"];
        $u_pass1 = $_POST["u_pass1"];
        $u_pass2 = $_POST["u_pass2"];

        if($u_pass1 != $u_pass2)
        {
            array_push($errors, "รหัสผ่านไม่ตรงกัน");
            $_SESSION['error'] = "รหัสผ่านไม่ตรงกัน";
            echo "<script type='text/javascript'>";
            echo "window.history.back();";
            echo "</script>";
        }
    
        if(count($errors) == 0)
        {
            $u_pass = md5($u_pass1);

            $sql = "UPDATE lib_user
            SET u_id = '$u_id',
                u_name = '$u_name',
                u_pass = '$u_pass'
            WHERE u_id = '$u_id'";
            $result = mysqli_query($con, $sql) or die ("Error in query: $sql" . mysqli_error());

            mysqli_close($con);
        
            if($result)
            {
                $_SESSION['success'] = "แก้ไขโปรไฟล์เรียบร้อยแล้ว";
                echo "<script type='text/javascript'>";
                echo "window.history.back();";
                echo "</script>";
            }
        }
    }
?>

<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
    </symbol>
    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
    </symbol>
</svg>