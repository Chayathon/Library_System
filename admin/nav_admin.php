<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        include("../conn.php");

        $ID = $_SESSION['ID'];

        $sql_user = "SELECT * FROM lib_user WHERE u_id = '$ID'";
        $result_user = mysqli_query($con, $sql_user) or die ("Error in query: $sql_user" . mysqli_error());
    
        while($row = mysqli_fetch_array($result_user))
        {
            $name = $row['u_name'];
        }
    ?>
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <a class="navbar-brand"><img src="../img/logo/logo.png" width="30" height="30"></a>&emsp;
                    <li class="nav-item">
                        <a class="nav-link" href="index.php"><b>หน้าแรก</b></a>
                    </li>
                    &emsp;
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <b>ยืม & คืน</b>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                            <li><a href="borrow-pending.php" class="dropdown-item">รอตรวจสอบ</a></li>
                            <li><a href="borrow-approve.php" class="dropdown-item">อนุมัติแล้ว</a></li>
                            <li><a href="borrow-matured.php" class="dropdown-item">ครบกำหนด</a></li>
                        </ul>
                    </li>
                    &emsp;
                    <li class="nav-item">
                        <a class="nav-link" href="list_admin.php"><b>จัดการผู้ดูแลระบบ</b></a>
                    </li>
                    &emsp;
                    <li class="nav-item">
                        <a class="nav-link" href="list_member.php"><b>จัดการสมาชิก</b></a>
                    </li>
                    &emsp;
                    <li class="nav-item">
                        <a class="nav-link" href="list_cate.php"><b>จัดการหมวดหมู่</b></a>
                    </li>
                    &emsp;
                    <li class="nav-item">
                        <a class="nav-link" href="list_book.php"><b>จัดการหนังสือ</b></a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                            <font color="cyan"><b><?php echo $name;?></b></font>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="update_profile.php">แก้ไขโปรไฟล์</a></li>
                            <li><a class="dropdown-item" href="../logout.php">ออกจากระบบ</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</body>
</html>