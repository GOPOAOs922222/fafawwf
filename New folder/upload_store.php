<?php
require_once ("dbconnect.php");
session_start();
//error_reporting(0);

$query_categories = "SELECT * FROM categories";
$stmt_categories = $pdo->query($query_categories);
$categories = $stmt_categories->fetchAll(PDO::FETCH_ASSOC);

if ($_SESSION["login"]){
    $e_mail_log = $_SESSION["email_login"];
    $password_log = $_SESSION["password_login"];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_FILES['avatar'])) {
            if (!empty(array_filter($_FILES['avatar']['name']))) {
                $errors_reg = [];

                $file_tmp = $_FILES['card_img']['tmp_name'];
                $avatar = $_FILES["card_img"];
                $nname = $avatar["name"];
                $info = pathinfo($nname);
                $file_tmp1 = $_FILES['avatar']['tmp_name'][0];
                $file_tmp2 = $_FILES['avatar']['tmp_name'][1];
                $file_tmp3 = $_FILES['avatar']['tmp_name'][2];

                $image = file_get_contents($file_tmp);
                $image1 = file_get_contents($file_tmp1);
                $image2 = file_get_contents($file_tmp2);
                $image3 = file_get_contents($file_tmp3);

                $wesite_name = $_POST["name-website"];
                $url = $_POST["link-website"];
                $categorie = $_POST["categorie"];
                $description = $_POST["description"];

                if (strlen($image1) > 1 AND strlen($image2) >= 1 AND strlen($image3) >= 1){
                    if (filter_var($url, FILTER_VALIDATE_URL)) {
                        if (strlen($description) > 19){
                            $done = true;
                        }else{
                            $errors_reg[] = "The description must be 20 at most";
                        }
                    }else{
                        $errors_reg[] = "PLease enter valid url";
                    }
                }else{
                    $errors_reg[] = "You must to upload 3 images";
                }
                if (count($errors_reg) > 0) {
                    $_SESSION["error"] = $errors_reg;
                    header("Location: upload_store.php");
                    return;
                }else if (!isset($_SESSION["error"]) && isset($done)) {

                    $query_1 = "SELECT * FROM websites WHERE name_site = '$wesite_name' AND categorie = '$categorie'";
                    $stmt_1 = $pdo->query($query_1);
                    $user = $stmt_1->fetch(PDO::FETCH_ASSOC);
                    if (strlen($user["id"]) >= 1){
                        $_SESSION["exist"] = 'This Website is already exist';
                        header("Location: upload_store.php");
                        return;
                    }elseif (strlen($user["id"]) == 0){
                        $query = "INSERT INTO websites(name_site, link_site, categorie, description, logo, image_1, image_2, image_3) VALUES (:n, :p, :c, :j, :k, :l, :o, :t);";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute(array(':n' => $wesite_name, ':p' => $url, ':c' => $categorie, ':j' => $description, ':k' => $image, ':l' => $image1, ':o' => $image2, ':t' => $image3,));

                        $query_2 = "SELECT * FROM websites WHERE name_site = '$wesite_name' AND categorie = '$categorie'";
                        $stmt_2 = $pdo->query($query_2);
                        $user_2 = $stmt_2->fetch(PDO::FETCH_ASSOC);
                        if (strlen($user_2["id"]) == 0){
                            $_SESSION["error"] = 'An error occurred, please try again';
                            header("Location: upload_store.php");
                            return;
                        }elseif (strlen($user_2["id"]) >= 1){
                            echo 321;
                            $_SESSION["success_upload"] = 'Your store has been uploaded successfully';
                            header("Location: upload_store.php");
                            return;
                        }
                    }
                }
            }
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
    </style>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    <script src="js/jquery-1.11.2.js"></script>
    <script src="Bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <title>Upload Store</title>
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

        <div class="row container-fluid" style="margin: 0 auto">
            <div class="col-md-8 offset-md-2">
                <div class="card shadow-lg rounded-3 px-md-5 px-2 mt-5">
<!--                    name, link website, categorie, description, upload images-->
                    <form method="post" enctype="multipart/form-data">
                        <h3 class="my-5 text-center">Upload Your Store</h3>

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

<!--                        name-->
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <h6 class="mt-2">Name Site</h6>
                            </div>
                            <div class="col-md-10">
                                <input type="text" name="name-website" class="form-control" placeholder="Site Name..." required>
                            </div>
                        </div>
<!--                        link website-->
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <h6 class="mt-2">Link Website</h6>
                            </div>
                            <div class="col-md-10">
                                <input type="text" name="link-website" class="form-control" placeholder="Link Website..." required>
                            </div>
                        </div>
<!--                        categorie-->
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <h6 class="mt-2">Categorie</h6>
                            </div>
                            <div class="col-md-10">
                                <select id="select" class="login-input form-control" name="categorie" required>
                                    <?php foreach ($categories as $cate){?>
                                        <option name="categorie" value="<?php echo $cate["categorie_name"]?>"><?php echo $cate["categorie_name"]?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
<!--                        description-->
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <h6 class="mt-2">Description</h6>
                            </div>
                            <div class="col-md-10">
                                <textarea type="text" name="description" class="form-control" placeholder="Description..." maxlength="400" rows="4" required></textarea>
                            </div>
                        </div>
<!--                        upload images-->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6 class="mt-2">Website Logo (<span class="text-danger">One Image</span>)</h6>
                                <input class="form-control" id="avatar" name="card_img" type="file" required>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mt-md-2 mt-4">Images About Site (<span class="text-danger">Three Image</span>)</h6>
                                <input class="form-control" id="avatar" name="avatar[]" type="file" multiple required>
                            </div>
                        </div>
                        <div class="text-center my-5">
                            <button type="submit" class="btn btn-danger fw-bolder">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <br>
        <br>
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