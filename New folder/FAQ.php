<?php
require_once ("dbconnect.php");

error_reporting(0);
session_start();
//session_destroy();
?>


<!DOCTYPE html>
<?php if (isset($_SESSION["arabic"]) AND $_SESSION["arabic"] == 1){?>
<html dir="rtl" lang="en">
<?php }else if (!isset($_SESSION["arabic"]) OR $_SESSION["arabic"] == 0){?>
<html lang="en">
<?php }?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="Bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <style>
        body{
            background-color: #e1e1e1;
        }
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
        @media(max-width: 500px) {
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
    <script type="text/javascript">
        $(window).load(function() {
            $(".carousel .item").each(function() {
                var i=$(this).next();
                i.length || (i=$(this).siblings(":first")),
                    i.children(":first-child").clone().appendTo($(this));

                for (var n=0; n < 4; n++)(i=i.next()).length ||
                (i=$(this).siblings(":first")),
                    i.children(":first-child").clone().appendTo($(this))
            })
        });
    </script>
    <title>FAQ</title>
    <link rel="icon" href="logo.png" type="image/x-icon">
</head>
<body>

<!--Mid Card-->
<section class="wrapper-box" style="max-width: 1220px; margin: 0px auto; background: #fff; box-shadow: 0px 0px 10px rgb(0 0 0 / 20%);">

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

    <!--Location-->
    <div class="text-black opacity-75 mt-2 mx-3">
        <h6>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/><path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/></svg>
            <span class="text-dark opacity-75">
                    &nbsp; / &nbsp;<a href="index.php" class="text-decoration-none text-dark opacity-75"> Home </a> &nbsp; / &nbsp;FAQ
            </span>
        </h6>
    </div>

    <!--Content FAQ Page-->
    <div class="row mt-5 container-fluid">
        <!--FAQ-->
        <div class="col-md-9">
            <h2>
                FAQ
            </h2>
            <h5 class="text-danger mt-4">How will I receive the product from the site?</h5>
            <h6 class="mb-5">The site will only sell you a code example 7F8XL-YKCF4-5MZHQ, you activate it in your account (<span class="warning">not DVD's</span>)</h6>
            <h5 class="text-danger">How do you know that I transferred the amount to your bank account?</h5>
            <h6 class="mb-5">We know through the name of the transferor (<span class="warning">the owner of the bank account or the name written in the bank card</span>), we enter our bank account and see the name and the amount transferred</h6>
            <h5 class="text-danger">What are the gaming platforms displayed on the site?</h5>
            <h6 class="mb-5">All games work on <span class="success">PC only</span> and do <span class="warning">not work</span> on xBox or PS.</h6>
            <h5 class="text-danger">How do I make the game code and how do I download it?</h5>
            <h6 class="mb-5">You enter it in your account with the game program or website, such as: Steam, Origin, UPLAY, Battle, and others<br> <br> And then you download the game using the program itself</h6>
            <h5 class="text-danger">What is the DLC?</h5>
            <h6 class="mb-5">An "addition" that you can add to the game may be weapons, maps ... etc. provided that you own the game, <span class="warning">the DLC will not work unless you own the game!</span></h6>
            <h5 class="text-danger">What is meant by GOTY?</h5>
            <h6 class="mb-5">GOTY is an abbreviation for Game of the Year Edition, which means "Game of the Year Modified" and contains the game and some or all add-ons depending on the game.</h6>
            <h5 class="text-danger">What is meant by "Complete Pack" and "Franchise Pack" ..?</h5>
            <h6 class="mb-5">The full collection of your favorite game! Contains all the parts in addition to the DLC</h6>
            <h5 class="text-danger">What is a Season Pass?</h5>
            <h6 class="mb-5">It is a set of add-ons approved by the company, and you can save the price of several add-ons through it <br> * Provided you own the game, <span class="warning">the Season Pass will not work unless you own the game!</span></h6>
            <h5 class="text-danger">Why are the prices of the site cheap?</h5>
            <h6 class="mb-5">Because the products are codes and codes, they do not contain additional expenses or shipping goods</h6>
            <h5 class="text-danger">Payment completed! And so far I haven't received the request!!</h5>
            <h6 class="mb-5">In case you made a purchase using “Bank Transfer”, go to: (<a href="order_history.php" class="text-decoration-none">Order History</a>) and complete the form, and if you pay using CashU or OneCard, the order will be sent directly to the email as soon as you see your order <br> * Please make sure if the message arrives in the junk mail or the "junk"</h6>
            <h5 class="text-danger">How do I know the order number?</h5>
            <h6 class="mb-5">Go to Home » Account » Order Details <br> And you can get the order number, for example: the order number: #0077</h6>
            <h5 class="text-danger">How long does it take for the order to arrive after payment?</h5>
            <h6 class="mb-5">80% of orders are delivered within 30 minutes, and the maximum delivery time is 8 hours <br> Therefore, please do not email us that the request has not arrived until after a maximum of 8 hours has passed</h6>
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
</section>>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<script src="search.js"></script>
</body>
</html>