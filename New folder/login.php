<?php
require_once ("dbconnect.php");

error_reporting(0);
session_start();
//session_destroy();

$query_rate_website = "SELECT * FROM websites ORDER BY rate desc LIMIT 5";
$stmt_rate_website = $pdo->query($query_rate_website);
$rate_websites = $stmt_rate_website->fetchAll(PDO::FETCH_ASSOC);

if (isset($_SESSION["login"])){
    header("Location: index.php");
    return;
}else if (!isset($_SESSION["login"])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $errors_reg = [];
        $e_mail = $_POST["email"];
        $password = $_POST["password"];

        if (filter_var($e_mail, FILTER_VALIDATE_EMAIL) AND strlen($password) > 6) {
            $done = true;
        }else {
            $errors_reg[] = 'Warning: No match for E-Mail Address and/or Password.';
        }
        if (count($errors_reg) > 0) {
            $_SESSION["error"] = $errors_reg;
//            print_r($_SESSION["error"]);
            header("Location: login.php");
            return;
        } else if (!isset($_SESSION["error"]) && isset($done)) {
            $query_c = "SELECT * FROM user_v1 WHERE email = '$e_mail' AND password = '$password'";
            $stmt_c = $pdo->query($query_c);
            $user = $stmt_c->fetch(PDO::FETCH_ASSOC);
            print_r($user);
            if (strlen($user["id"]) == 0){
                if (isset($_SESSION["arabic"]) AND $_SESSION["arabic"] == 1){
                    $errors_reg[] = 'تحذير: لا يوجد تطابق لعنوان البريد الإلكتروني و / أو كلمة المرور.';}
                elseif (!isset($_SESSION["arabic"]) OR $_SESSION["arabic"] == 0){
                    $errors_reg[] = 'Warning: No match for E-Mail Address and/or Password.';}
                $_SESSION["error"] = $errors_reg;
                header("Location: login.php");
                return;
            }else if (strlen($user["id"]) >= 1){
                $_SESSION["login"] = true;
                $_SESSION["email_login"] = $e_mail;
                $_SESSION["password_login"] = $password;
                header("Location: index.php");
                return;
            }
        }
    }
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
        #logo2{
            display: none;
        }
        #card-featered{
            opacity: 95%;
            transition: width 500ms linear, height 500ms linear;
            transition: all 100ms linear;
        }
        #card-featered:hover{
            transition-delay:20ms;
            box-shadow: inset 0px 0px 0px 3px #e1e1e1;
            box-sizing: border-box;
            border-radius: 10px;
            opacity: 100%;
        }
        #line-account-login{
            display: none;
        }
        @media(max-width: 500px) {
            #line-new-customer{
                display: none;
            }
            #logo{
                display: none;
            }
            #logo2{
                display: block;
            }
            .back-mid-warning{
                background: #ff925b;
                margin-top: 20px;
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    <script src="js/jquery-1.11.2.js"></script>
    <script src="Bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <title>login</title>
    <link rel="icon" href="logo.png" type="image/x-icon">
</head>
<body>
<!--Mid Card-->
<section class="wrapper-box" style="max-width: 1400px; margin: 0px auto; background: #fff; box-shadow: 0px 0px 10px rgb(0 0 0 / 20%);">
    <div>
        <!--Navbar SteamArab-->
        <nav id="nav-bar" class="navbar navbar-expand-lg navbar-light back-warning px-2">
            <div class="row">
                <div class="col-6">
                    <img src="logo.png" id="logo2" width="200" height="80">
                </div>
            </div>
            <button class="navbar-toggler px-1 py-1" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                </svg>
            </button>
            <div class="collapse navbar-collapse back-mid-warning rounded-3" id="navbarSupportedContent">
                <ul class="navbar-nav container-fluid">
                    <div class="row container-fluid">
                        <div class="col-md-2 text-md-start">
                            <a href="index.php">
                                <img src="logo.png" id="logo" width="200" height="80">
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
                            <div class="col-md-1 col-6 my-auto text-md-end">
                                <h6>
                                    <a href="login.php" class="text-decoration-none text-white fw-bolder text-end">
                                        Login
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16"><path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/></svg>
                                    </a>
                                </h6>
                            </div>
                            <div class="col-md-1 col-6 my-auto text-md-start text-end">
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
                    &nbsp; / &nbsp;<a href="index.php" class="text-decoration-none text-dark opacity-75"> Home </a> &nbsp; / &nbsp;Login
                </span>
            </h6>
        </div>

        <br>

<!--        Content Login Page-->
        <div class="row mt-3 container-fluid" style="margin: 0 auto">
<!--            Login And Register-->
            <h3 class="mb-1 mx-3">Account Login</h3>
            <div class="col-md-9">
                <hr id="line-account-login-hide">
                <hr id="line-account-login">
                <!--Alert Error and Success-->
                <div class="row mt-4">
                    <div class="col-md-6 offset-md-3 col-10 offset-1 text-center px-0 py-0">
                        <?php if (isset($_SESSION["error"]) && count($_SESSION["error"]) > 0){?>
                            <div class="alert alert-danger">
                                <ul class="my-0 list-unstyled">
                                    <?php foreach ($_SESSION["error"] as $error) { ?>
                                        <li>
                                            <h6><?php echo $error; ?></h6>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <?php unset($_SESSION["error"])?>
                        <?php }else if (isset($_SESSION["exist"])){ ?>
                            <div class="alert alert-warning">
                                <h6><?php echo $_SESSION["exist"] ?></h6>
                            </div>
                            <?php unset($_SESSION["exist"])?>
                        <?php }else if(isset($_SESSION["success"])){?>
                            <div class="alert alert-success">
                                <h6><?php echo $_SESSION["success"] ?></h6>
                            </div>
                            <?php unset($_SESSION["success"])?>
                        <?php }?>
                    </div>
                </div>

                <div class="row">
<!--                    register-->
                    <div class="col-md-5">
                        <h5 class="mx-3">New Customer</h5>
                        <hr id="line-new-customer">
                        <div class="mx-3">
                            <h6>
                                By creating an account you will be able to shop faster, be up to date on an order's status, and keep track of the orders you have previously made.
                            </h6>
                            <a href="register.php" class="btn btn-danger fw-bolder mt-3">
                                Register
                            </a>
                        </div>
                    </div>
<!--                    login-->
                    <div class="col-md-7 mt-md-0 mt-4">

                        <h5>Returning Customer</h5>
                        <hr>
                        <form method="post">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <h6 class="mt-2"><span class="text-danger"> * </span>Email Address</h6>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="email" placeholder="EX- examble4512@exm.com" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="mt-2"><span class="text-danger"> * </span>Password</h6>
                                </div>
                                <div class="col-md-8">
                                    <input type="password" name="password" placeholder="Password" class="form-control">

                                    <div class="text-end mt-3">
                                        <button type="submit" class="btn btn-danger fw-bolder">Login</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--featered-->
            <div class="col-md-3">
                <hr>
                <h5 class="text-center">Featered</h5>
                <?php foreach ($rate_websites as $card){?>
                    <div class="card border border-0">
                        <div class="mt-3">
                            <div class="row py-2 px-2" id="card-featered">
                                <a href="http://localhost/website.php?categorie=<?php echo $card["categorie"]?>&website=<?php echo $card["name_site"]?>" class="col-3">
                                    <img src="data:image/<?php echo "png"; ?>;base64,<?php echo base64_encode($card["logo"]); ?>" width="70" height="40" class="border border-dark rounded-3">
                                </a>
                                <a href="http://localhost/website.php?categorie=<?php echo $card["categorie"]?>&website=<?php echo $card["name_site"]?>" class="col-9 text-decoration-none text-dark">
                                    <span style="font-size: medium">
                                        <?php $x = explode("/", $card["link_site"]);
                                        $x = $x[0] . "/" . $x[1] . "/" . $x[2];
                                        echo $x;
                                        ?>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php }?>
            </div>

        </div>

        <br>
        <br>
        <br>

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