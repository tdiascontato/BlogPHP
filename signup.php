<?php 

require 'config/constants.php'; 

//if get error
$firstname = $_SESSION['signup-data']['firstname'] ?? null;
$lastname = $_SESSION['signup-data']['lastname'] ?? null;
$username = $_SESSION['signup-data']['username'] ?? null;
$email = $_SESSION['signup-data']['email'] ?? null;
$createpassword = $_SESSION['signup-data']['createpassword'] ?? null;
$confirmpassword = $_SESSION['signup-data']['confirmpassword'] ?? null;
//delete signup data session
unset($_SESSION['signup-data']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TriunfoImóvieis</title>
    <link rel="stylesheet" href="<?=ROOT_URL?>css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
</head>
    <body>

    <!--NAvBAr-->
    <nav>
        <div class="container nav__container">
            <a href="<?=ROOT_URL?>" class="nav__logo">Fofoca</a>
            <ul class="nav__items">
                <li><a href="<?=ROOT_URL?>blog.php">Blog</a></li>
                <li><a href="<?=ROOT_URL?>about.php">About</a></li>
                <li><a href="<?=ROOT_URL?>services.php">Services</a></li>
                <li><a href="<?=ROOT_URL?>contact.php">Contact</a></li>
                <li><a href="<?=ROOT_URL?>signin.php">Signin</a></li>
                    <!--<li class="nav__profile">
                        <div class="avatar">
                            <img src="./images/user.png" alt="User" />
                        </div>
                        <ul>
                            <li><a href="<?=ROOT_URL?>admin/index.php">Dashboard</a></li>
                            <li><a href="<?=ROOT_URL?>logout.php">Logout</a></li>
                        </ul>
                    </li>-->
            </ul>
            <button id="open__nav-btn"><i class="uil uil-bars"></i></button>
            <button id="close__nav-btn"><i class="uil uil-multiply"></i></button>
            </div>
    </nav>
    <!--NAvBar-->

<section class="form__section">
    <div class="container form__section-container">
        <h2>Sign Up</h2>
        <?php if(isset($_SESSION['signup'])):?>
        <div class="alert__message error">
            <p>
                <?= $_SESSION['signup']; 
                unset($_SESSION['signup']) ?>
            </p>
        </div>
        <?php endif ?>
        <form action="<?= ROOT_URL?>signup-logic.php" enctype="multipart/form-data" method="post">
            <input type="text" name="firstname" value="<?=$firstname?>" placeholder="First Name:">
            <input type="text" name="lastname" value="<?=$lastname?>" placeholder="Last Name:">
            <input type="text" name="username" value="<?=$username?>" placeholder="Username:">
            <input type="text" name="email" value="<?=$email?>" placeholder="Email:">
            <input type="password" name="createpassword" value="<?=$createpassword?>" placeholder="Create password:">
            <input type="password" name="confirmpassword" value="<?=$confirmpassword?>" placeholder="Confirm password:">
            <div class="form__control">
                <label for="avatar">User avatar:</label>
                <input type="file" name="avatar" id="avatar">
            </div>
            <button type="submit" name="submit" class="btn">Sign In</button>
            <small>Already have an account? <a href="signin.php">Sign Up</a></small>
        </form>
    </div>
</section>     

<?php include 'partials/footer.php'; ?>