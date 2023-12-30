<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "library";

    $con = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($con->connect_error)
    {
        die("Connection failed: " . $con->connect_error);
    }
    // echo "Connected successfully";
    
    date_default_timezone_set('Asia/Bangkok');

    $sql_borrow = "SELECT * FROM lib_borrow";
    $result_borrow = mysqli_query($con, $sql_borrow) or die ("Error in query: $sql_borrow" . mysqli_error());
    
    foreach($result_borrow as $rowwor)
    {
        $date = date('Y-m-d H:i:s');
        $return = $rowwor['return_date'];
        $borrow_id = $rowwor['borrow_id'];
        $status = $rowwor['borrow_status'];

        if($date >= $return and $status == 2)
        {
            $sql_update_borrow = "UPDATE lib_borrow
            SET borrow_status = 3
            WHERE return_date = '$return'";
            $result_update_borrow = mysqli_query($con, $sql_update_borrow) or die ("Error in query: $sql_update_borrow" . mysqli_error());
        }
        elseif($date >= $return and $status == 1)
        {
            $sql_update_borrow = "UPDATE lib_borrow
            SET borrow_status = 5
            WHERE return_date = '$return'";
            $result_update_borrow = mysqli_query($con, $sql_update_borrow) or die ("Error in query: $sql_update_borrow" . mysqli_error());
        }
    }
?>