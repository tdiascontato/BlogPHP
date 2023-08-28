<?php
require 'config/database.php';
//clicou
if(isset($_POST['submit'])){
    
        $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);
        $avatar = $_FILES['avatar'];
        
        //validations
        if(!$firstname){
            $_SESSION['add-user'] = 'Please enter your first name!';
        }elseif(!$lastname){
            $_SESSION['add-user'] = 'Please enter your last name!';
        }elseif(!$username){
            $_SESSION['add-user'] = 'Please enter your username!';
        }elseif(!$email){
            $_SESSION['add-user'] = 'Please enter your email!';
       }elseif(strlen($createpassword)<8 || strlen($confirmpassword)<8){
            $_SESSION['add-user'] = 'Please enter your Password must be 8+ characters!';
        }elseif(!$avatar['name']){
            $_SESSION['add-user'] = 'Please enter with your avatar';
        }else{//check passwords
            if($createpassword !== $confirmpassword){
                $_SESSION['signup'] = 'Passwords do not match';
            }else{
                $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);//Cheking existions
                $user_check_query = "SELECT * FROM users WHERE username ='$username' OR email = '$email'";
            $user_check_result = mysqli_query($connection, $user_check_query);
                if(mysqli_num_rows($user_check_result)>0){
                    $_SESSION['add-user'] = "Username or Email already exist";
                }else{
                    $time = time();//Make images name using current timestamp
                    $avatar_name = $time . $avatar['name'];
                    $avatar_tmp_name = $avatar['tmp_name'];
                    $avatar_destination_path = '../images/' . $avatar_name;
    
                    //File ia sn image?
                    $allowed_files = ['png', 'jpg', 'jpeg'];
                    $extention = explode('.', $avatar_name);
                    $extention = end($extention);
                    if(in_array($extention, $allowed_files)){
                        //image is large?
                        if($avatar['size'] < 1000000){
                            move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                        }else{
                            $_SESSION['add-user'] = 'Image must to be < 1mb :(';
                        }
                    }else{
                        $_SESSION['add-user'] = 'File Should be PNG, JPG ou JPEG';
                    }
                }
            }
        }
        //redirect back to add-user pag
        if(isset($_SESSION['add-user'])){
            $_SESSION['add-user-data'] = $_POST;
            header('location:' . ROOT_URL . 'admin/add-user.php');
            die();
        }else{
            $insert_user_query = "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin) VALUES ('$firstname', '$lastname', '$username', '$email', '$hashed_password', '$avatar_name', '$is_admin')";
            $insert_user_result = mysqli_query($connection, $insert_user_query);
            if(!mysqli_errno($connection)){
                $_SESSION['add-user-success'] = "Success! New user: $firstname $lastname";
                header('location:' . ROOT_URL . 'admin/manage-users.php');
                die();
            }
        }
    
} else {
    header('location:' . ROOT_URL . 'admin/add-user.php');
    die();
}