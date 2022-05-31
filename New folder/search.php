<?php
require_once ("dbconnect.php");

//error_reporting(0);
session_start();
//session_destroy();

$query_categories = "SELECT * FROM categories";
$stmt_categories = $pdo->query($query_categories);
$categories = $stmt_categories->fetchAll(PDO::FETCH_ASSOC);

if (isset($_SESSION["login"])) {
    $e_mail_log = $_SESSION["email_login"];
    $password_log = $_SESSION["password_login"];
}

if (isset($_GET["categorie"]) AND isset($_GET["show"]) AND isset($_GET["search"])){
    $search = $_GET["search"];
    $show = $_GET["show"];
    $categorie = $_GET["categorie"];

    if ($show == "all"){
        $show = 9999999999;
    }
    if ($categorie == "all"){
        $categorie = "%%";
    }

    $query_cards_number = "SELECT COUNT(*) AS count_cards FROM websites WHERE categorie LIKE '$categorie' AND name_site LIKE '%$search%'";
    $stmt_cards_number = $pdo->query($query_cards_number);
    $total_cards = $stmt_cards_number->fetch(PDO::FETCH_ASSOC);

    $query_count_cards = "SELECT * FROM websites WHERE categorie LIKE '$categorie' AND name_site LIKE '%$search%' LIMIT $show";
    $stmt_count_cards = $pdo->query($query_count_cards);
    $show_cards = $stmt_count_cards->fetchAll(PDO::FETCH_ASSOC);
    $show_cards = count($show_cards);

    if ($show > $total_cards["count_cards"]) {
        $show = $total_cards["count_cards"];
    }
    $count_pages = ceil($show / 30);

    $_SESSION["show"] = $show;
    $_SESSION["categorie"] = $categorie;

    if ($show > 30){
        $show_limit = 30;
    }else{
        $show_limit = $show;
    }

    if (!isset($_GET["page"]) or strlen($_GET["page"]) == 0){
        $page = 1;
    }else{
        $page = $_GET["page"];
    }

    $start = ($page - 1) * $show_limit;
    $end = $page * $show_limit;
//    echo $start;
//    echo $end;

    $query_cards = "SELECT DISTINCT * FROM websites WHERE categorie LIKE '$categorie' AND name_site LIKE '%$search%' LIMIT $end offset $start";
    $stmt_cards = $pdo->query($query_cards);
    $cards = $stmt_cards->fetchall(PDO::FETCH_ASSOC);

}elseif (!isset($_GET["categorie"]) OR !isset($_GET["search"]) OR !isset($_GET["show"])){
    if (isset($_GET["search"]) AND isset($_GET["categorie"])){
        $search = $_GET["search"];
        $categorie = $_GET["categorie"];

        header("Location: search.php?search=$search&categorie=$categorie&show=30");
        return;
    }
    header("Location: index.php");
    return;
}
?>



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
        .categorie-text{
            color: #2f2f2f;
        }
        .categorie-text:hover{
            opacity: 90%;
            color: #2c2525;
        }
        #card-categorie{
            opacity: 95%;
            transition: width 500ms linear, height 500ms linear;
            transition: all 100ms linear;
        }
        #card-categorie:hover{
            transition-delay:20ms;
            box-shadow: inset 0px 0px 0px 3px #e1e1e1;
            box-sizing: border-box;
            border-radius: 10px;
            opacity: 100%;
        }
        .card-categorie{
            width: 150px;
            height: 80px;
        }
        @media(max-width: 500px) {
            .card-categorie{
                width: 100px;
                height: 50px;
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    <script src="js/jquery-1.11.2.js"></script>
    <script src="Bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <title>Searching: <?php echo $search?></title>
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

        <!--        Location URL-->
        <div class="text-black opacity-75 mt-2 mx-3">
            <h6>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/><path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/></svg>
                <span class="text-dark opacity-75">
                    &nbsp; / &nbsp;<a href="index.php" class="text-decoration-none text-dark opacity-75"> Home </a> &nbsp; / &nbsp;Search
                </span>
            </h6>
        </div>
        <br>

        <!--Stores-->
        <div class="container-fluid">
            <br>
            <h3>Searching For "<?php echo $search?>"</h3>
            <br>
            <div class="mt-3 mb-3">
                <!--filter show-->
                <div class="row">
                    <div class="col-md-9">
                        <div class="alert py-0" style="background: #f3f3f3">
                            <form method="get" class="mb-3">
                                <div class="row mt-4">
                                    <div class="col-md-1 col-auto">
                                        <h6 class="mt-2">Searching:</h6>
                                    </div>
                                    <div class="col-md-2 col-auto">
                                        <input type="text" name="search" class="form-control" placeholder="Searching...">
                                    </div>

                                    <div class="col-md-1 mt-md-0 mt-2 col-auto">
                                        <h6 class="mt-2">Categories:</h6>
                                    </div>
                                    <div class="col-md-3 mt-md-0 mt-2 col-auto">
                                        <select id="select" class="login-input form-control" name="categorie">
                                            <option name="categorie" value="all">الكل</option>
                                            <?php foreach ($categories as $cate){?>
                                                <option name="categorie" value="<?php echo $cate["categorie_name"]?>"><?php echo $cate["categorie_name"]?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="col-md-1 mt-md-0 mt-2 offset-md-1 col-auto">
                                        <h6 class="mt-2 text-black">Show: </h6>
                                    </div>
                                    <div class="col-md-1 mt-md-0 mt-2 col-auto">
                                        <select id="select" class="login-input form-control" name="show">
                                            <option name="show" value="30">30</option>
                                            <option name="show" value="60">60</option>
                                            <option name="show" value="120">120</option>
                                            <option name="show" value="200">200</option>
                                            <option name="show" value="all">ALL</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1 text-md-start text-center mt-md-0 mt-3">
                                        <button type="submit" class="btn btn-warning text-white fw-bolder" name="sub" value="1">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <hr>
                <!--                                    cards-->
                <div class="row mt-4 mb-3">
                    <?php if (count($cards) == 0){?>
                        <h5 class="text-center">There is no result for "<?php echo $search?>"</h5>
                    <?php }else{?>
                        <?php foreach ($cards as $card){?>
                            <a href="website.php?categorie=<?php echo $card["categorie"]?>&website=<?php echo $card["name_site"]?>" class="col-md-2 mb-3 py-3 text-center col-4" id="card-categorie">
                                <img src="data:image/<?php echo "png"; ?>;base64,<?php echo base64_encode($card["logo"]); ?>" width="150" height="80" class="border border-dark rounded-3 card-categorie">
                            </a>
                        <?php }?>
                    <?php }?>
                </div>

                <!--pages number and total cards-->
                <div>
                    <div class="col-md-6 offset-md-6 text-end mt-5">
                        <h6>Show <?php echo $show_cards?> of <?php echo $total_cards["count_cards"]?> &nbsp; Pages Number: <?php echo $count_pages?></h6>
                    </div>
                    <div class="row">
                        <div class="col-md-11 offset-md-1 text-center">
                            <?php for ($o=1 ; $o<=$count_pages ; $o++){?>
                                <?php if ($o == $page){?>
                                    <button class="btn btn-danger mb-2"><?php echo $o?></button>
                                <?php }else{?>
                                    <a href="<?php echo "search.php?search=$search&categorie=$categorie&show=$show&page=$o"?>" class="text-decoration-none"><button class="btn btn-outline-danger mb-2 page-btn"><?php echo $o?></button></a>
                                <?php }?>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
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