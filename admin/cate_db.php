<?php
    SESSION_START();
    include("../conn.php");
    $errors = array();

    // เพิ่ม

    if(isset($_POST['add']))
    {
        $c_name = $_POST["c_name"];

        $type_check = "SELECT * FROM lib_category WHERE c_name = '$c_name'";
        $query = mysqli_query($con, $type_check);
        $result_check = mysqli_fetch_assoc($query);

        if($result_check['c_name'] === $c_name)
        {
            array_push($errors, "มีหมวดหมู่นี้อยู่แล้ว");
            $_SESSION['error'] = "มีหมวดหมู่นี้อยู่แล้ว";
            echo "<script type='text/javascript'>";
            echo "window.history.back();";
            echo "</script>";
        }
        
        if(count($errors) == 0)
        {
            $sql = "INSERT INTO lib_category(c_name)
            VALUES('$c_name')"; 
            $result = mysqli_query($con, $sql) or die ("Error in query: $sql" . mysqli_error());

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
        $c_id = $_POST['c_id'];
        $c_name = $_POST['c_name'];

        $sql = "UPDATE lib_category
        SET c_id = '$c_id',
            c_name = '$c_name'
        WHERE c_id = '$c_id'";

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
            $_SESSION['error'] = "แก้ไขข้อมูลล้มเหลว";
            echo "<script type='text/javascript'>";
            echo "window.history.back();";
            echo "</script>";
        }
    }

    // ลบ

    if(isset($_POST['delete']))
    {
        $c_id = $_POST['c_id'];

        $sql = "DELETE FROM lib_category WHERE c_id = '$c_id'";
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