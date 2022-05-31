<?php
require_once ("dbconnect.php");

//error_reporting(0);
session_start();
//session_destroy();


if (isset($_SESSION["login"])) {
    $e_mail_log = $_SESSION["email_login"];
    $password_log = $_SESSION["password_login"];
    $query_user = "SELECT * FROM user_v1 WHERE email='$e_mail_log' AND password='$password_log'";
    $stmt_user = $pdo->query($query_user);
    $user = $stmt_user->fetch(PDO::FETCH_ASSOC);
    $id_user = $user["id"];
}

if (isset($_GET["categorie"]) AND isset($_GET["website"])){
    $errors_reg = [];
    $web_name = $_GET["website"];
    $categorie = $_GET["categorie"];
    $query_website = "SELECT * FROM websites WHERE name_site='$web_name' AND categorie='$categorie'";
    $stmt_website = $pdo->query($query_website);
    $website = $stmt_website->fetch(PDO::FETCH_ASSOC);

    if (strlen($website["id"]) == 0){
        header("Location: index.php");
        return;
    }
    $id_website = $website["id"];

    $query_reviews_count = "SELECT COUNT(review) AS count_reviews, AVG(rate) AS rate FROM reviews WHERE id_websites='$id_website'";
    $stmt_reviews_count = $pdo->query($query_reviews_count);
    $reviews_count = $stmt_reviews_count->fetch(PDO::FETCH_ASSOC);

    $rate_c = round($reviews_count["rate"]);
    $reviews_c = $reviews_count["count_reviews"];

    $query_rev_1 = "UPDATE websites SET reviews='$reviews_c', rate='$rate_c' WHERE id=:e;";
    $stmt_rev_1 = $pdo->prepare($query_rev_1);
    $stmt_rev_1->execute(array(':e' => $id_website,));

    $query_website = "SELECT * FROM websites WHERE name_site='$web_name' AND categorie='$categorie'";
    $stmt_website = $pdo->query($query_website);
    $website = $stmt_website->fetch(PDO::FETCH_ASSOC);

    $query_reviews = "
            SELECT reviews.review AS review, reviews.rate AS rate, reviews.created_at AS created_at, user_v1.first_name AS username FROM reviews
            INNER JOIN user_v1 ON
            reviews.id_user_v1 = user_v1.id
            WHERE
            reviews.id_websites = '$id_website'
            ORDER BY rate desc LIMIT 5;
            ";
    $stmt_reviews = $pdo->query($query_reviews);
    $reviews = $stmt_reviews->fetchAll(PDO::FETCH_ASSOC);

    $query_rate_website = "SELECT * FROM websites WHERE categorie='$categorie' ORDER BY rate desc LIMIT 20";
    $stmt_rate_website = $pdo->query($query_rate_website);
    $rate_websites = $stmt_rate_website->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER["REQUEST_METHOD"] == "POST" AND isset($_POST["comment"]) AND isset($_POST["rate"])){
        if (isset($_SESSION["login"])) {
            $comment = $_POST["comment"];
            $rate = $_POST["rate"];

            if ($rate == $_SESSION["rate"] AND $comment == $_SESSION["comment"] AND $_SESSION["id_user"] == $id_user){
                $_SESSION["error"] = "Spam comments are not allowed";
                header("Location: website.php?categorie=$categorie&website=$web_name");
                return;
            }else{
                $_SESSION["comment"] = $comment;
                $_SESSION["rate"] = $rate;
                $_SESSION["id_user"] = $id_user;
                $query_rev = "INSERT INTO reviews(id_websites, id_user_v1, review, rate) VALUES (:p, :q, :c, :v);";
                $stmt_rev = $pdo->prepare($query_rev);
                $stmt_rev->execute(array(':p' => $id_website, ':q' => $_SESSION["id_user"], ':c' => $comment, ':v' => $rate,));
                header("Location: website.php?categorie=$categorie&website=$web_name");
                return;
            }
        }else{
            header("Location: login.php");
            return;
        }
    }
}else{
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
            z-index: 99;
            position: sticky;
            top: 0;
        }
        #card-favorite{
            opacity: 95%;
            transition: width 500ms linear, height 500ms linear;
            transition: all 100ms linear;
        }
        #card-favorite:hover{
            transition-delay:20ms;
            box-shadow: inset 0px 0px 0px 3px #e1e1e1;
            box-sizing: border-box;
            border-radius: 10px;
            opacity: 100%;
        }
        .d-block{
            width: 1920px;
            height: 200px;
        }
        #logo-cover{
            width: 100%;
            height: 250px;
        }
        .card-categorie{
            width: 150px;
            height: 80px;
        }
        @media(max-width: 500px) {
            #logo-cover{
                height: 200px;
            }
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
    <title><?php echo $website["name_site"]?></title>
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
                <span class="text-dark opacity-75" style="line-height: 2;">
                    &nbsp; / &nbsp;<a href="index.php" class="text-decoration-none text-dark opacity-75"> Home </a> &nbsp; / &nbsp;<a href="categories.php" class="text-decoration-none text-dark opacity-75"><?php echo $website["categorie"]?></a> &nbsp; / &nbsp;<?php echo $website["name_site"]?>
                </span>
            </h6>
        </div>

        <div class="container-fluid" style="margin: 0 auto">
            <h3></h3>
            <div class="row mt-5">
<!--                cover and rates and number of reviews-->
                <div class="col-md-4">
                    <img src="data:image/<?php echo "png"; ?>;base64,<?php echo base64_encode($website["logo"]); ?>" id="logo-cover" class="border border-dark rounded-3">
                    <br>
                    <br>
                    <div id="carouselExampleCaptions" class="carousel slide rounded-3" data-bs-ride="carousel">
                        <!--number of sliders-->
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        </div>
                        <!--content of slioders-->
                        <div class="carousel-inner rounded-3">
                            <div class="carousel-item active">
                                <img src="data:image/<?php echo "png"; ?>;base64,<?php echo base64_encode($website["image_1"]); ?>" class="d-block w-100 rounded-3" alt="img" width="1920" height="200">
                            </div>
                            <div class="carousel-item">
                                <img src="data:image/<?php echo "png"; ?>;base64,<?php echo base64_encode($website["image_2"]); ?>" class="d-block w-100 rounded-3" alt="img" width="1920" height="200">
                            </div>
                            <div class="carousel-item">
                                <img src="data:image/<?php echo "png"; ?>;base64,<?php echo base64_encode($website["image_3"]); ?>" class="d-block w-100 rounded-3" alt="img" width="1920" height="200">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>

                    <div class="row mt-3 mb-md-0 mb-5">
                        <div class="col-6">
                            <img src="stars/<?php echo $website["rate"]?>star.png" width="100" height="15">
                        </div>
                        <div class="col-6 text-end">
                            <h6 class="text-primary">Reviews(<?php echo $website["reviews"]?>)</h6>
                        </div>
                    </div>
                </div>
<!--                description and name website and link website-->
                <div class="col-md-8">
                    <div class="row mb-3">
                        <div class="col-md-2" style="margin: auto auto">
                            <h6>Name Website:</h6>
                        </div>
                        <div class="col-md-10">
                            <input type="text" value="<?php echo $website["name_site"]?>" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2" style="margin: auto auto">
                            <h6>Link Website:</h6>
                        </div>
                        <div class="col-md-10">
                            <input type="text" value="<?php echo $website["link_site"]?>" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2" style="margin: auto auto">
                            <h6>Categorie:</h6>
                        </div>
                        <div class="col-md-10">
                            <input type="text" value="<?php echo $website["categorie"]?>" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2" style="margin: auto auto">
                            <h6>Description:</h6>
                        </div>
                        <div class="col-md-8">
                            <textarea type="text" class="form-control" style="background: #f5f5f5; color: #030000" rows="3" disabled><?php echo $website["description"]?></textarea>
                        </div>
                        <div class="col-md-2 text-center mt-md-0 mt-3" style="margin: auto auto">
                            <a href="http://localhost/website.php" class="btn btn-danger fw-bolder">Explore</a>
                        </div>
                    </div>
                    <hr>
                    <h3>Add comment</h3>

                    <!--Alert Error and Success-->
                    <div class="row mt-4">
                        <div class="col-md-4 offset-md-4 col-10 offset-1 text-center px-0 py-0">
                            <?php if (isset($_SESSION["error"])){?>
                                <div class="alert alert-warning">
                                    <h6>Spam comments are not allowed</h6>
                                </div>
                                <?php unset($_SESSION["error"])?>
                            <?php }?>
                        </div>
                    </div>

                    <br>
                    <form method="post">
                        <div class="row">
                            <div class="col-md-2">
                                <h6><span class="text-danger"> * </span> Comment</h6>
                            </div>
                            <div class="col-md-8">
                                <textarea name="comment" class="form-control" placeholder="Comment..." maxlength="200" required></textarea>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-2 col-3">
                                <h6><span class="text-danger"> * </span> Rate</h6>
                            </div>
                            <div class="col-md-6 col-9">
                                <span class="text-black mx-1">Bad</span>
                                <input class="comment-input" type="radio" name="rate" value="1" required>
                                <input class="comment-input" type="radio" name="rate" value="2" required>
                                <input class="comment-input" type="radio" name="rate" value="3" required>
                                <input class="comment-input" type="radio" name="rate" value="4" required>
                                <input class="comment-input" type="radio" name="rate" value="5" required>
                                <span class="text-black mx-1">Good</span>
                                <br>
                                <img src="stars/stars.gif" width="170" width="150" height="22" class="text-center">
                            </div>
                            <div class="col-md-2 text-md-center mt-md-0 mt-4">
                                <button type="submit" class="btn btn-danger fw-bold">Comment</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row my-5">
                <div class="col-md-4">
                    <h3>Reviews</h3>
                    <hr>
                    <br>
                    <?php foreach ($reviews as $c_review){?>
                        <div class="card shadow-sm rounded-3 mb-3">
                            <div class="card-header" style="background: #efefef">
                                <div class="row">
                                    <div class="col-md-8 col-8">
                                        <h6 class="my-0"><?php echo $c_review["username"]?></h6>
                                        <img src="stars/<?php echo $c_review["rate"]?>star.png" width="100" height="15">
                                    </div>
                                    <div class="col-md-4 col-4 text-end">
                                        <h6>
                                            <?php $date = explode(" ", $c_review["created_at"]);
                                            echo str_replace("-", "/", $date[0])?>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6><?php echo $c_review["review"]?></h6>
                            </div>
                        </div>
                    <?php }?>
                </div>
                <div class="col-md-8 text-md-center">
                    <h4 class="mt-1">Websites you may like</h4>
                    <hr>
                    <br>
                    <div class="row" style="margin: 0 auto">
                        <?php foreach ($rate_websites as $cards){?>
                            <a href="http://localhost/website.php?categorie=<?php echo $cards["categorie"]?>&website=<?php echo $cards["name_site"]?>" class="col-md-3 col-4 mb-3 py-2 px-0" id="card-favorite">
                                <img src="data:image/<?php echo "png"; ?>;base64,<?php echo base64_encode($cards["logo"]); ?>" width="150" height="80" class="border border-dark rounded-3 card-categorie">
                            </a>
                        <?php }?>
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