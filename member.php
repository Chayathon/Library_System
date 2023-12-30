<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        SESSION_START();
        include("conn.php");
        include("head.php");

        if(!isset($_SESSION['user']))
        {
            echo "<script type='text/javascript'>";
            echo "window.history.back();";
            echo "</script>";
        }
    ?>
</head>
<body>
    <?php include("navbar.php") ?>
    <?php
        $book = (isset($_GET['book'])? $_GET['book'] : '');
        $search = (isset($_GET['search'])? $_GET['search'] : '');
        if($book == 'category')
        {
            include('book_category.php');
        }
        elseif($search!='')
        {
            include('book_search.php');
        }
        else
        {
            include('book.php');
        }
    ?>
</body>
</html>