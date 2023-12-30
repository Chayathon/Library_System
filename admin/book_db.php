<?php
    SESSION_START();
    include("../conn.php");
    $errors = array();

    // เพิ่ม

    if(isset($_POST['add']))
    {
        $b_name = $_POST["b_name"];
        $c_id = $_POST["c_id"];
        $b_amount = $_POST["b_amount"];

        $product_check = "SELECT * FROM lib_book WHERE b_name = '$b_name'";
        $query = mysqli_query($con, $product_check);
        $result_check = mysqli_fetch_assoc($query);

        if($result_check)
        {
            if($result_check['b_name'] === $b_name)
            {
                array_push($errors, "มีหนังสือนี้อยู่แล้ว");
                $_SESSION['error'] = "มีหนังสือนี้อยู่แล้ว";
                echo "<script type='text/javascript'>";
                echo "window.history.back();";
                echo "</script>";
            }
        }

        if(count($errors) == 0)
        {
            
            $sql = "INSERT INTO lib_book(b_name,c_id,b_remaining,b_amount)
            VALUES('$b_name','$c_id','$b_amount','$b_amount')"; 
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
        $b_id = $_POST['b_id'];
        $b_name = $_POST['b_name'];
        $c_id = $_POST['c_id'];
        $b_remaining = $_POST['b_remaining'];
        $b_amount = $_POST['b_amount'];

        $sql = "UPDATE lib_book
        SET b_id = '$b_id',
            b_name = '$b_name',
            c_id = '$c_id',
            b_remaining = '$b_remaining',
            b_amount = '$b_amount'
        WHERE b_id = '$b_id'";

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
        $b_id = $_POST['b_id'];
    
        $sql = "DELETE FROM lib_book WHERE b_id = '$b_id'"; 
        $result = mysqli_query($con, $sql) or die ("Error in query: $sql" . mysqli_error());

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