<?php
    SESSION_START();
    include("../conn.php");

    // อนุมัติ

    if(isset($_POST['approve']))
    {
        $borrow_id = $_POST['borrow_id'];
        $b_id = $_POST['b_id'];
        $borrow_amount = $_POST['borrow_amount'];

        $sql_select = "SELECT * FROM lib_book WHERE b_id = '$b_id'";
        $result_select = mysqli_query($con, $sql_select) or die ("Error in query: $sql_select" . mysqli_error());
        $row = mysqli_fetch_array($result_select);

        $remaining = $row['b_remaining'] - $borrow_amount;

        $sql_approve = "UPDATE lib_borrow
        SET borrow_status = 2
        WHERE borrow_id = '$borrow_id'";
        $result_approve = mysqli_query($con, $sql_approve) or die ("Error in query: $sql_approve" . mysqli_error());

        $sql_update = "UPDATE lib_book
        SET b_remaining = $remaining
        WHERE b_id = '$b_id'";
        $result_update = mysqli_query($con, $sql_update) or die ("Error in query: $sql_update" . mysqli_error());

        if($result_approve and $result_update)
        {
            $_SESSION['success'] = "อนุมัติการยืมแล้ว";
            echo "<script type='text/javascript'>";
            echo "window.history.back();";
            echo "</script>";
        }
        else
        {
            $_SESSION['error'] = "อนุมัติการยืมล้มเหลว";
            echo "<script type='text/javascript'>";
            echo "window.history.back();";
            echo "</script>";
        }
    }

    // ไม่อนุมัติ

    if(isset($_POST['disapprove']))
    {
        $borrow_id = $_POST['borrow_id'];

        $sql = "UPDATE lib_borrow
        SET borrow_status = 5
        WHERE borrow_id = '$borrow_id'";
        $result = mysqli_query($con, $sql) or die ("Error in query: $sql" . mysqli_error());

        if($result)
        {
            $_SESSION['success'] = "ไม่อนุมัติการยืมแล้ว";
            echo "<script type='text/javascript'>";
            echo "window.history.back();";
            echo "</script>";
        }
        else
        {
            $_SESSION['error'] = "ไม่อนุมัติการยืมล้มเหลว";
            echo "<script type='text/javascript'>";
            echo "window.history.back();";
            echo "</script>";
        }
    }

    // คืนแล้ว

    if(isset($_POST['return']))
    {
        $borrow_id = $_POST['borrow_id'];
        $b_id = $_POST['b_id'];
        $borrow_amount = $_POST['borrow_amount'];

        $sql_select2 = "SELECT * FROM lib_book WHERE b_id = '$b_id'";
        $result_select2 = mysqli_query($con, $sql_select2) or die ("Error in query: $sql_select2" . mysqli_error());
        $row = mysqli_fetch_array($result_select2);

        $remaining = $row['b_remaining'] + $borrow_amount;

        $sql_update2 = "UPDATE lib_book
        SET b_remaining = $remaining
        WHERE b_id = '$b_id'";
        $result_update2 = mysqli_query($con, $sql_update2) or die ("Error in query: $sql_update2" . mysqli_error());

        $sql_delete = "DELETE FROM lib_borrow WHERE borrow_id = '$borrow_id'"; 
        $result_delete = mysqli_query($con, $sql_delete) or die ("Error in query: $sql_delete" . mysqli_error());

        if($result_update2 and $result_delete)
        {
            $_SESSION['success'] = "อนุมัติการคืนแล้ว";
            echo "<script type='text/javascript'>";
            echo "window.history.back();";
            echo "</script>";
        }
        else
        {
            $_SESSION['error'] = "อนุมัติการคืนล้มเหลว";
            echo "<script type='text/javascript'>";
            echo "window.history.back();";
            echo "</script>";
        }
    }
?>