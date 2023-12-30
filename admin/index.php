<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        SESSION_START();
        include("head_admin.php");

        if(!isset($_SESSION['user']))
        {
            echo "<script type='text/javascript'>";
            echo "window.history.back();";
            echo "</script>";
        }
    ?>
</head>
<body>
    <?php
        include("nav_admin.php");
        include("../conn.php");

        $sql1 = "SELECT borrow_status FROM lib_borrow WHERE borrow_status LIKE 1";
        $result1 = mysqli_query($con, $sql1) or die ("Error in query: $sql1" . mysqli_error());

        $sql2 = "SELECT borrow_status FROM lib_borrow WHERE borrow_status LIKE 2";
        $result2 = mysqli_query($con, $sql2) or die ("Error in query: $sql2" . mysqli_error());

        $sql3 = "SELECT borrow_status FROM lib_borrow WHERE borrow_status LIKE 3 OR borrow_status LIKE 4";
        $result3 = mysqli_query($con, $sql3) or die ("Error in query: $sql3" . mysqli_error());
    ?>
    <p></p>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card text-white bg-warning shadow" onclick="window.location='borrow-pending.php'">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <h1 class="card-text"><img src="../img/logo/load.png" width="120"></h1>
                            </div>
                            <div class="col-8">
                                <h5 align="right">ยืม & คืน</h5>
                                <h1 align="right"><b><?php echo mysqli_num_rows($result1); ?></b></h1>
                                <h5 align="right">รอตรวจสอบ</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success shadow" onclick="window.location='borrow-approve.php'">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <h1 class="card-text"><img src="../img/logo/correct.png" height="120"></h1>
                            </div>
                            <div class="col-8">
                                <h5 align="right">ยืม & คืน</h5>
                                <h1 align="right"><b><?php echo mysqli_num_rows($result2); ?></b></h1>
                                <h5 align="right">อนุมัติแล้ว</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-info shadow" onclick="window.location='borrow-matured.php'">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <h1 class="card-text"><img src="../img/logo/warning.png" width="135"></h1>
                            </div>
                            <div class="col-8">
                                <h5 align="right">ยืม & คืน</h5>
                                <h1 align="right"><b><?php echo mysqli_num_rows($result3); ?></b></h1>
                                <h5 align="right">ครบกำหนด</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p></p>

        <?php
            include('../conn.php');

            $sql = "SELECT * FROM lib_book AS b INNER JOIN lib_category AS c ON b.c_id = c.c_id ORDER BY b_id ASC";
            $result = mysqli_query($con, $sql) or die ("Error in query: $sql" . mysqli_error());
        ?>

        <table class="table table-hover">
            <thead>
                <tr class="table table-active" align="center">
                    <th>ไอดี</th>
                    <th>ชื่อหนังสือ</th>
                    <th>หมวดหมู่</th>
                    <th>คงเหลือ</th>
                </tr>
            </thead>
            <?php foreach($result as $row) { ?>
                <tr align="center">
                    <td><?php echo $row['b_id']; ?></td>
                    <td><?php echo $row['b_name']; ?></td>
                    <td><?php echo $row['c_name']; ?></td>
                    <td>
                        <?php if($row['b_remaining'] > 0){ echo $row['b_remaining']; } ?>
                        <font color="red"><?php if($row['b_remaining'] <= 0) { echo $row['b_remaining']; } ?></font>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>