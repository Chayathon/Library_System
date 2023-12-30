<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        include("conn.php");

        $ID = $_SESSION['ID'];

        $sql = "SELECT * FROM lib_user WHERE u_id = '$ID'";
        $result = mysqli_query($con, $sql) or die ("Error in query: $sql" . mysqli_error());

        $sql_cate = "SELECT * FROM lib_category ORDER BY c_id ASC";
        $result_cate = mysqli_query($con, $sql_cate) or die ("Error in query: $sql_cate" . mysqli_error());
    
        while($row = mysqli_fetch_array($result))
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
                    <a class="navbar-brand"><img src="img/logo/logo.png" width="30" height="30"></a>&emsp;
                    <li class="nav-item">
                        <a class="nav-link" href="member.php"><b>หน้าแรก</b></a>
                    </li>
                    &emsp;
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <b>ประเภทหนังสือ</b>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                            <?php foreach($result_cate as $row) { ?>
                                <li><a href="member.php?book=category&c_id=<?php echo $row['c_id'];?>" class="dropdown-item">
                                <b><?php echo $row['c_name'];?></b></a></li>
                            <?php } ?>
                        </ul>
                    </li>
                    &emsp;
                    <li class="nav-item">
                        <a class="nav-link" href="borrow.php"><b>หนังสือที่ยืม</b></a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <form class="d-flex" method="GET" action="member.php">
                        <input class="form-control me-2" type="search" name="search" placeholder="ค้นหา" aria-label="Search">
                    </form>
                    &emsp;
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                            <font color="cyan"><b><?php echo $name;?></b></font>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="update_profile.php">แก้ไขโปรไฟล์</a></li>
                            <li><a class="dropdown-item" href="logout.php">ออกจากระบบ</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</body>
</html>