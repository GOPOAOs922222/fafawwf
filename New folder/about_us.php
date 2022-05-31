<?php
//require_once ("dbconnect.php");
//
//error_reporting(0);
session_start();
////session_destroy();
//
//
//if (isset($_SESSION["login"])) {
//    $e_mail_log = $_SESSION["email_login"];
//    $password_log = $_SESSION["password_login"];
//    $query_count_items_nav = "SELECT COUNT(*) AS counto FROM items WHERE email='$e_mail_log' AND password='$password_log'";
//    $stmt_count_items_nav = $pdo->query($query_count_items_nav);
//    $count_items_nav = $stmt_count_items_nav->fetch(PDO::FETCH_ASSOC);
//}
//
//$query_cards = "SELECT * FROM products ORDER BY created_at desc LIMIT 7";
//$stmt_cards = $pdo->query($query_cards);
//$cards = $stmt_cards->fetchall(PDO::FETCH_ASSOC);
//
//$query_cards_s = "SELECT * FROM products ORDER BY rate desc LIMIT 6";
//$stmt_cards_s = $pdo->query($query_cards_s);
//$cards_b_slider = $stmt_cards_s->fetchall(PDO::FETCH_ASSOC);
//
//if (isset($_GET["fav-name"]) AND isset($_GET["fav-cate"])){
//    if (isset($_SESSION["login"])) {
//        $e_mail_log = $_SESSION["email_login"];
//        $password_log = $_SESSION["password_login"];
//
//        $fav_name = $_GET["fav-name"];
//        $fav_cate = $_GET["fav-cate"];
//
//        $query_fav = "SELECT * FROM products WHERE name='$fav_name' AND categorie='$fav_cate'";
//        $stmt_fav = $pdo->query($query_fav);
//        $cards_fav = $stmt_fav->fetch(PDO::FETCH_ASSOC);
//
//        $status_fav = $cards_fav["available"];
//        $price_fav = $cards_fav["price"];
//
//        $query_qty = "INSERT INTO favorite_list(product_name, categorie, status, price, email, password) VALUES (:p, :q, :c, :v, :b, :n);";
//        $stmt_qty = $pdo->prepare($query_qty);
//        $stmt_qty->execute(array(':p' => $fav_name, ':q' => $fav_cate, ':c' => $status_fav, ':v' => $price_fav, ':b' => $e_mail_log, ':n' => $password_log,));
//        header("Location: index.php");
//        return;
//    }else{
//        header("Location: login.php");
//        return;
//    }
//}
//
//if ($_SERVER["REQUEST_METHOD"] == "POST" AND isset($_POST["card"])){
//    $card_info = explode("$$$", $_POST["card"]);
//    $product_name = $card_info[0];
//    $categorie = $card_info[1];
//
//    if (isset($_SESSION["login"])) {
//        $e_mail_log = $_SESSION["email_login"];
//        $password_log = $_SESSION["password_login"];
//
//        $query_product = "SELECT * FROM products WHERE name='$product_name' AND categorie='$categorie';";
//        $stmt_product = $pdo->query($query_product);
//        $cards_product = $stmt_product->fetch(PDO::FETCH_ASSOC);
//
//        $rate = $cards_product["rate"];
//        $price = $cards_product["price"];
//
//        $query_chk = "SELECT quantity FROM items WHERE product = '$product_name' AND categorie = '$categorie' AND email = '$e_mail_log' AND password = '$password_log'";
//        $stmt_chk = $pdo->query($query_chk);
//        $user_chk = $stmt_chk->fetch(PDO::FETCH_ASSOC);
//
//        if (count($user_chk["quantity"]) >= 1) {
//            $new_qty = 1 + $user_chk["quantity"];
//            $query = "UPDATE items SET product='$product_name', quantity='$new_qty', categorie='$categorie' WHERE email=:e AND password=:p AND product=:n;";
//            $stmt = $pdo->prepare($query);
//            $stmt->execute(array(':e' => $e_mail_log, ':p' => $password_log, ':n' => $product_name,));
//            header("Location: index.php");
//            return;
//        } else {
//            $query_qty = "INSERT INTO items(product, quantity, categorie, price, email, password, rates) VALUES (:p, :q, :c, :v, :b, :n, :m);";
//            $stmt_qty = $pdo->prepare($query_qty);
//            $stmt_qty->execute(array(':p' => $product_name, ':q' => 1, ':c' => $categorie, ':v' => $price, ':b' => $e_mail_log, ':n' => $password_log, ':m' => $rate,));
//            header("Location: index.php");
//            return;
//        }
//    }else{
//        header("Location: login.php");
//        return;
//    }
//}
//
//?>



<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="Bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <style>
        .back-warning{
            background: rgb(250, 151, 71);
        }
        #nav-bar{
            position: sticky;
            z-index: 99;
            top: 0;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    <script src="js/jquery-1.11.2.js"></script>
    <script src="Bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <title>About US</title>
    <link rel="icon" href="logo.png" type="image/x-icon">
</head>
<body>
<!--Mid Card-->
<section class="wrapper-box" style="max-width: 1400px; margin: 0px auto; background: #fff; box-shadow: 0px 0px 10px rgb(0 0 0 / 20%);">
    <div>
        <!--Navbar SteamArab-->
        <nav id="nav-bar" class="navbar navbar-expand-lg navbar-light back-warning">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav container-fluid">
                    <div class="row container-fluid">
                        <div class="col-md-2 text-md-start">
                            <a href="index.php">
                                <img src="logo.png" width="200" height="80">
                            </a>
                        </div>
                        <div class="col-md-8 mx-md-0">
                            <form method="get" action="search.php">
                                <div class="input-group mt-4">
                                    <form method="get" action="search.php">
                                        <input type="search" class="form-control rounded" placeholder="Search..." name="search" aria-label="Search" aria-describedby="search-addon" />
                                        <button type="submit" class="btn btn-outline-dark" name="categorie" value="all">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </form>
                        </div>
                        <?php if (isset($_SESSION["login"])){?>
                            <div class="col-md-2 my-md-auto my-2 text-md-end">
                                <div class="btn-group rounded-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-person-circle text-dark categorie-text" data-bs-toggle="dropdown" aria-expanded="false" viewBox="0 0 16 16"><path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/><path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/></svg>
                                    <ul class="dropdown-menu bg-dark">
                                        <li>
                                            <h6 class="text-white text-center">
                                                user2132
                                            </h6>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-white bold" href="profile.php">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16"><path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/></svg>
                                                My Profile
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-white" href="contact_us.php">
                                                Contact US
                                            </a>
                                        </li>
                                        <li class="text-white">________________________</li>
                                        <li>
                                            <a class="dropdown-item text-danger fw-bolder" href="logout.php">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z"/><path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/></svg>
                                                <?php if (isset($_SESSION["arabic"]) AND $_SESSION["arabic"] == 1){
                                                    echo "الخروج";
                                                }elseif (!isset($_SESSION["arabic"]) OR $_SESSION["arabic"] == 0){
                                                    echo "Logout";
                                                }?>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        <?php }else{?>
                            <div class="col-md-1 col-6 mt-4 my-3 text-md-end">
                                <h6>
                                    <a href="login.php" class="text-decoration-none text-white fw-bolder text-end">
                                        Login
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16"><path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/></svg>
                                    </a>
                                </h6>
                            </div>
                            <div class="col-md-1 mt-4 col-6 text-md-start text-end">
                                <h6>
                                    <a href="register.php" class="text-decoration-none text-white fw-bolder text-end">
                                        Register
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16"><path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/><path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/></svg>
                                    </a>
                                </h6>
                            </div>
                        <?php }?>
                    </div>
                </ul>
            </div>
        </nav>

        <div class="text-black opacity-75 mt-2 mx-3">
            <h6>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/><path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/></svg>
                <span class="text-dark opacity-75">
                    &nbsp; / &nbsp;<a href="index.php" class="text-decoration-none text-dark opacity-75"> Home </a> &nbsp; / &nbsp;About US
                </span>
            </h6>
        </div>

        <div class="container-fluid">
            <h2 class="mt-5">About US</h2>
            <br>
            <h6>اول دليل يجمع جميع المتاجر السعودية والعالمية والخدمات في مكان واحد</h6>
            <br>
            <br>
            <br>
            <br>
        </div>

        <!--Header Buttom-->
        <div class="card bg-dark rounded-0">
            <div class="card-body">
                <div class="row mx-md-2">
                    <!--Information-->
                    <div class="col-md-2 col-6 text-white">
                        <h6 class="mb-4">
                            <b>
                                More Information
                            </b>
                        </h6>
                        <p>
                            <a href="about_us.php" class="text-decoration-none text-white">
                                about us
                            </a>
                            <br>
                            <a href="privacy.php" class="text-decoration-none text-white">
                                privacy
                            </a>
                            <br>
                            <a href="terms.php" class="text-decoration-none text-white">
                                terms
                            </a>
                        </p>
                    </div>
                    <!--Customer Service-->
                    <div class="col-md-2 col-6 text-white">
                        <h6 class="mb-4">
                            <b>
                                Customer Service
                            </b>
                        </h6>
                        <p>
                            <a href="contact_us.php" class="text-decoration-none text-white categorie-text">
                                contact us
                            </a>
                            <br>
                            <a href="steps_payment.php" class="text-decoration-none text-white categorie-text">
                                profile
                            </a>
                            <br>
                            <a href="favorite.php" class="text-decoration-none text-white categorie-text">
                                categorie
                            </a>
                        </p>
                    </div>
                    <!--My Account-->
                    <div class="col-md-2 col-6 text-white">
                        <h6 class="mb-4">
                            <b>
                                My Account
                            </b>
                        </h6>
                        <p>
                            <a href="my_account.php" class="text-decoration-none text-white categorie-text">
                                profile
                            </a>
                            <br>
                            <a href="favorite.php" class="text-decoration-none text-white categorie-text">
                                personal information
                            </a>
                            <br>
                            <a href="FAQ.php" class="text-decoration-none text-white categorie-text">
                                FAQ
                            </a>
                        </p>
                    </div>
                    <!--Payment Methods-->
                    <div class="col-md-3 col-12 text-center text-white">
                        <h6 class="mb-4">
                            <b>
                                Organisation
                            </b>
                        </h6>
                        <img src="logo.png" width="50%" height="50%">
                    </div>
                    <!--Site Safety-->
                    <div class="col-md-3 text-center text-white">
                        <h6 class="mx-4 mb-3">
                            <b>
                                Site Safety
                            </b>
                        </h6>
                        <b>
                            <h4>
                                <img src="true.png" width="100" height="100">
                            </h4>
                        </b>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>