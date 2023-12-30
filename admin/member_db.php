<?php
    SESSION_START();
    include("../conn.php");
    $errors = array();

    // เพิ่ม

    if(isset($_POST['add']))
    {
        $u_name = $_POST["u_name"];
        $u_pass1 = $_POST["u_pass1"];
        $u_pass2 = $_POST["u_pass2"];

        $user_check = "SELECT * FROM lib_user WHERE u_name = '$u_name'";
        $query = mysqli_query($con, $user_check);
        $result_check = mysqli_fetch_assoc($query);

        if($result_check)
        {
            if($result_check['u_name'] === $u_name)
            {
                array_push($errors, "มีชื่อผู้ใช้นี้อยู่แล้ว");
                $_SESSION['error1'] = "มีชื่อผู้ใช้นี้อยู่แล้ว";
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
            $result = mysqli_query($con, $sql) or die ("Error in query: $sql ".mysqli_error());
            
            if($result)
            {
                $_SESSION['success'] = "เพิ่มข้อมูลเรียบร้อยแล้ว";
                echo "<script type='text/javascript'>";
                echo "window.history.back();";
                echo "</script>";
            }
            else
            {
                $_SESSION['error'] = "เพิ่มข้อมูลล้มเหลว";
                echo "<script type='text/javascript'>";
                echo "window.history.back();";
                echo "</script>";
            }
        }
    }

    // แก้ไข

    if(isset($_POST['update']))
    {
        $u_id = $_POST['u_id'];
        $u_name = $_POST['u_name'];
        $u_pass1 = $_POST['u_pass1'];
        $u_pass2 = $_POST['u_pass2'];

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

            $sql = "UPDATE lib_user
            SET u_id = '$u_id',
                u_name = '$u_name',
                u_pass = '$u_pass'
            WHERE u_id = '$u_id'";
            $result = mysqli_query($con, $sql) or die ("Error in query: $sql" . mysqli_error());

            mysqli_close($con);
        
            if($result)
            {
                $_SESSION['success'] = "แก้ไขข้อมูลเรียบร้อยแล้ว";
                echo "<script type='text/javascript'>";
                echo "window.history.back();";
                echo "</script>";
            }
            else
            {
                $_SESSION['error'] = "เแก้ไขข้อมูลล้มเหลว";
                echo "<script type='text/javascript'>";
                echo "window.history.back();";
                echo "</script>";
            }
        }
    }

    // ลบ

    if(isset($_POST['delete']))
    {
        $u_id = $_POST['u_id'];

        $sql = "DELETE FROM lib_user WHERE u_id = '$u_id'";
        $result = mysqli_query($con, $sql) or die ("Error in query: $sql" . mysqli_error());

        mysqli_close($con);

        if($result)
        {
            $_SESSION['success'] = "ลบข้อมูลเรียบร้อยแล้ว";
            echo "<script type='text/javascript'>";
            echo "window.history.back();";
            echo "</script>";
        }
        else
        {
            $_SESSION['error'] = "ลบข้อมูลล้มเหลว";
            echo "<script type='text/javascript'>";
            echo "window.history.back();";
            echo "</script>";
        }
    }
?>