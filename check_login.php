<?php
    SESSION_START();
    include("conn.php");

    if(isset($_POST['login']))
    {
        $u_name = mysqli_real_escape_string($con, $_POST['u_name']);
        $u_pass = mysqli_real_escape_string($con, $_POST['u_pass']);

        $u_pass = md5($u_pass);

        $sql = "SELECT * FROM lib_user WHERE u_name LIKE '$u_name' AND u_pass LIKE '$u_pass'";
        $result = mysqli_query($con, $sql) or die ("Error in query: $sql" . mysqli_error());

        if(mysqli_num_rows($result))
        {
            $row = mysqli_fetch_array($result);
            $_SESSION["ID"] = $row["u_id"];
            $_SESSION["user"] = $row["u_name"];
        
            if($row["u_status"] == 'admin')
            {
                header("location: admin/index.php");
            }
        
            if($row["u_status"] == 'member')
            {
                header("location: member.php");
            }
        }
        else
        {
            $_SESSION['error'] = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง!";
            echo "<script type='text/javascript'>";
            echo "window.history.back();";
            echo "</script>";
        }
    }
?>