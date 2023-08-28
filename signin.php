<?php 
    require 'config/constants.php';
    
    $username_email = $_SESSION['signin-data']['username_email'] ?? null;
    $password = $_SESSION['signin-data']['password'] ?? null;
    unset($_SESSION['signin-data']);
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
                <?php if(isset($_SESSION['user-id'])): ?>
                        <li class="nav__profile">
                            <div class="avatar">
                                <img src="<?= ROOT_URL . 'images/' . $avatar['avatar'] ?>" alt="User" />
                            </div>
                            <ul>
                                <li><a href="<?=ROOT_URL?>admin/">Dashboard</a></li>
                                <li><a href="<?=ROOT_URL?>logout.php">Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                    <li><a href="<?=ROOT_URL?>signin.php">Signin</a></li>
                    <?php endif ?>
            </ul>
            <button id="open__nav-btn"><i class="uil uil-bars"></i></button>
            <button id="close__nav-btn"><i class="uil uil-multiply"></i></button>
            </div>
</nav>
<!--NAvBar-->
<section class="form__section">
    <div class="container form__section-container">
        <h2>Sign In</h2>
        <?php if(isset($_SESSION['signup-success'])): ?>
        <div class="alert__message success">
            <p>
            <?= $_SESSION['signup-success'];
            unset($_SESSION['signup-success']);
            ?>
            </p>
        </div>
        <?php  elseif(isset($_SESSION['signin'])): ?>
        <div class="alert__message error">
            <p>
            <?= $_SESSION['signin'];
            unset($_SESSION['signin']); ?>
            </p>
        </div>
        <?php endif ?>
        <form action="<?= ROOT_URL ?>signin-logic.php" method="POST">
            <input type="text" name="username_email" value="<?= $username_email ?>" placeholder="Username or Email:">
            <input type="password" name="password" value="<?= $password ?>" placeholder="Password">
            <button type="submit" name="submit" class="btn">Sign In</button>
            <small>Don't have an account?<br/><a href="<?= ROOT_URL ?>signup.php">Sign Up</a></small>
        </form>
    </div>
</section>

<?php include 'partials/footer.php'; ?>