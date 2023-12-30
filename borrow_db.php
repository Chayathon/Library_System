<?php
    SESSION_START();
    include("conn.php");

    // ยืม

    if(isset($_POST['borrow']))
    {
        $u_id = $_POST['u_id'];
        $b_id = $_POST['b_id'];
        $c_id = $_POST['c_id'];
        $borrow_amount = $_POST['borrow_amount'];
        $borrow_date = $_POST['borrow_date'];
        $return_date = $_POST['return_date'];

        $sql = "INSERT INTO lib_borrow(u_id,b_id,c_id,borrow_amount,borrow_date,return_date,borrow_status)
        VALUES('$u_id','$b_id','$c_id','$borrow_amount','$borrow_date','$return_date','1')";
        $result = mysqli_query($con, $sql) or die ("Error in query: $sql" . mysqli_error());

        if($result)
        {
            $_SESSION['success'] = "ยืมหนังสือแล้ว รอการอนุมัติ";
            echo "<script type='text/javascript'>";
            echo "window.location='borrow.php';";
            echo "</script>";
        }
        else
        {
            $_SESSION['error'] = "ยืมหนังสือล้มเหลว";
            echo "<script type='text/javascript'>";
            echo "window.history.back();";
            echo "</script>";
        }
    }

    // แก้ไข

    if(isset($_POST['update']))
    {
        $borrow_id = $_POST['borrow_id'];
        $borrow_amount = $_POST['borrow_amount'];
        $borrow_date = $_POST['borrow_date'];
        $return_date = $_POST['return_date'];

        $sql = "UPDATE lib_borrow
        SET borrow_amount = '$borrow_amount',
            borrow_date = '$borrow_date',
            return_date = '$return_date'
        WHERE borrow_id = $borrow_id";
        $result = mysqli_query($con, $sql) or die ("Error in query: $sql" . mysqli_error());

        if($result)
        {
            $_SESSION['success'] = "แก้ไขการยืมหนังสือแล้ว";
            echo "<script type='text/javascript'>";
            echo "window.location='borrow.php';";
            echo "</script>";
        }
        else
        {
            $_SESSION['error'] = "แก้ไขการยืมหนังสือล้มเหลว";
            echo "<script type='text/javascript'>";
            echo "window.history.back();";
            echo "</script>";
        }
    }

    // คืน

    if(isset($_POST['return']))
    {
        $borrow_id = $_POST['borrow_id'];

        $sql = "UPDATE lib_borrow
        SET borrow_status = 4
        WHERE borrow_id = $borrow_id";
        $result = mysqli_query($con, $sql) or die ("Error in query: $sql" . mysqli_error());

        if($result)
        {
            $_SESSION['success'] = "คืนหนังสือแล้ว";
            echo "<script type='text/javascript'>";
            echo "window.history.back();";
            echo "</script>";
        }
        else
        {
            $_SESSION['error'] = "คืนหนังสือล้มเหลว";
            echo "<script type='text/javascript'>";
            echo "window.history.back();";
            echo "</script>";
        }
    }

    // ยกเลิก

    if(isset($_POST['cancel']))
    {
        $borrow_id = $_POST['borrow_id'];

        $sql = "DELETE FROM lib_borrow WHERE borrow_id = '$borrow_id'";
        $result = mysqli_query($con, $sql) or die ("Error in query: $sql" . mysqli_error());

        mysqli_close($con);

        if($result)
        {
            $_SESSION['success'] = "ยกเลิกการยืมเรียบร้อยแล้ว";
            echo "<script type='text/javascript'>";
            echo "window.history.back();";
            echo "</script>";
        }
        else
        {
            $_SESSION['error'] = "ยกเลิกการยืมล้มเหลว";
            echo "<script type='text/javascript'>";
            echo "window.history.back();";
            echo "</script>";
        }
    }
?>