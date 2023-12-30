<?php
    SESSION_START();
    include("conn.php");
    $errors = array();

    if(isset($_POST['register']))
    {
        $u_name = mysqli_real_escape_string($con, $_POST['u_name']);
        $u_pass1 = mysqli_real_escape_string($con, $_POST['u_pass1']);
        $u_pass2 = mysqli_real_escape_string($con, $_POST['u_pass2']);

        $user_check = "SELECT * FROM lib_user WHERE u_name = '$u_name'";
        $query = mysqli_query($con, $user_check);
        $result_check = mysqli_fetch_assoc($query);

        if($result_check)
        {
            if($result_check['u_name'] === $u_name)
            {
                array_push($errors, "มีชื่อผู้นี้อยู่แล้ว");
                $_SESSION['error1'] = "มีชื่อผู้นี้อยู่แล้ว";
                echo "<script type='text/javascript'>";
                echo "window.history.back();";
                echo "</script>";
            }
        }

        if($u_pass1 != $u_pass2)
        {
            array_push($errors, "รหัสผ่านไม่ตรงกัน");
            $_SESSION['error2'] = "รหัสผ่านไม่ตรงกัน";
            echo "<script type='text/javascript'>";
            echo "window.history.back();";
            echo "</script>";
        }

        if(count($errors) == 0)
        {
            $u_pass = md5($u_pass1);

            $sql = "INSERT INTO lib_user(u_name,u_pass,u_status)
            VALUES('$u_name','$u_pass','member')";
            $result = mysqli_query($con,$sql) or die ("Error in query: $sql " . mysqli_error());
            
            if($result)
            {
                $_SESSION['success'] = "สมัครสมาชิกเรียบร้อยแล้ว";
                echo "<script type='text/javascript'>";
                echo "window.location='index.php';";
                echo "</script>";
            }
            else
            {
                $_SESSION['error'] = "สมัครสมาชิกล้มเหลว";
                echo "<script type='text/javascript'>";
                echo "window.history.back();";
                echo "</script>";
            }
        }
    }
?>