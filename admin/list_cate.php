<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        SESSION_START();
        include("head_admin.php");
    ?>
</head>
<body>
    <?php include("nav_admin.php"); ?>
    <p></p>
    <div class="container-fluid">

    <!-------------------------------------------------------------------- ค้นหา -------------------------------------------------------------------->

        <div class="row">
            <div class="col-3">
                <form class="d-flex" method="GET" action="list_cate.php">
                    <input class="form-control me-2" type="search" name="search_cate" placeholder="ค้นหา" aria-label="Search">
                </form>
            </div>
            <div class="col-6">
                <?php if(isset($_SESSION['success'])) { ?>
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                        <div>
                            <?php
                                echo $_SESSION['success'];
                                unset($_SESSION['success']);
                            ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if(isset($_SESSION['error'])) { ?>
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                        <div>
                            <?php
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                            ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-2"></div>

    <!-------------------------------------------------------------------- เพิ่ม -------------------------------------------------------------------->

            <div class="col-1" align="right">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add">
                    เพิ่ม
                </button>
            </div>
        </div>
        <div class="modal fade" id="add" tabindex="-1" aria-labelledby="add" aria-hidden="true">
            <div class="modal modal-alert-md d-block" tabindex="-1" role="dialog" id="modalChoice">
                <div class="modal-dialog modal-dialog-md" role="document">
                    <div class="modal-content shadow">
                        <div class="modal-body p-4 text-center">
                            <form class="form-horizontal was-validated" name="add" id="add" method="post" action="cate_db.php">
                                <h5 class="mb-0">เพิ่มหมวดหมู่</h5><br>
                                <div class="form-floating">
                                    <input class="form-control is-invalid" type="text" name="c_name" id="c_name" placeholder="ชื่อหมวดหมู่" required>
                                    <label for="c_name">ชื่อหมวดหมู่</label>
                                </div>
                        </div>
                                <div class="modal-footer flex-nowrap p-0">
                                    <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 border-right" data-bs-dismiss="modal">ยกเลิก</button>
                                    <button type="submit" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-1" name="add"><font color="green"><b>เพิ่ม</b></font></button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
        <p></p>

    <!------------------------------------------------------------------ รายการ ------------------------------------------------------------------>

        <?php
            $search_cate = (isset($_GET['search_cate'])? $_GET['search_cate'] : '');
            if($search_cate!='')
            {
                include('search_cate.php');
            }
            else
            {
                include('list_cate_db.php');
            }
        ?>
    </div>
</body>
</html>

<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
    </symbol>
    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
    </symbol>
</svg>