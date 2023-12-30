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
        WHERE borrow_status LIKE 2";
        $result = mysqli_query($con, $sql) or die ("Error in query: $sql" . mysqli_error());
    ?>

    <?php include("nav_admin.php"); ?>
    <div class="container-fluid">
        <p></p>
            <h1 align="center"><b>อนุมัติแล้ว</b></h1>
            <table class="table table-hover">
                <thead>
                    <tr class="table table-active" align="center">
                        <th>ชื่อผู้ยืม</th>
                        <th>หนังสือ</th>
                        <th>ประเภทหนังสือ</th>
                        <th>จำนวน(เล่ม)</th>
                        <th>วันที่ยืม</th>
                        <th>วันที่คืน</th>
                    </tr>
                </thead>
                <?php foreach($result as $row) { ?>
                    <tr align="center">
                        <td><?php echo $row['u_name']; ?></td>
                        <td><?php echo $row['b_name']; ?></td>
                        <td><?php echo $row['c_name']; ?></td>
                        <td><?php echo $row['borrow_amount']; ?></td>
                        <td><?php echo $row['borrow_date']; ?></td>
                        <td><?php echo $row['return_date']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>