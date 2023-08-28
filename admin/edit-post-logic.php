<?php

require "./config/database.php";

// Start the session if not started already
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['edit-post'])) {
    $_SESSION['edit-post'] = "";
}

if(isset($_POST['submit'])){
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $previous_thumbnail_name = filter_var($_POST['previous_thumbnail_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];
    //set is_featured to 0 if unchecked
    $is_featured = $is_featured ? 1 : 0;
    //validate form data
    if(!$title){
        $_SESSION['edit-post'] = "Enter post title";
    }elseif(!$category_id){
        $_SESSION['edit-post'] = "Select post category";
    }elseif(!$body){
        $_SESSION['edit-post'] = "Enter post body";
    }else{
        //delete existing thumbnail if new thumbnail is available
        
        if($thumbnail['name']){
            $previous_thumbnail_path = '../images/' . $previous_thumbnail_name;
            if(file_exists($previous_thumbnail_path) && is_file($previous_thumbnail_path)){
                unlink($previous_thumbnail_path);
            }
            //WORK ON THUMBNAIL
            //rename the image
            $time = time(); // make each image name unique
            $thumbnail_name = $time . $thumbnail['name'];
            $thumbnail_tmp_name = $thumbnail['tmp_name'];
            $thumbnail_destination_path = '../images/' . $thumbnail_name;

            //make sure file is an Image
            $allowed_files = ['png', 'jpg', 'jpeg'];
            $extension = explode('.', $thumbnail_name);
            $extension = end($extension);
            if(in_array($extension, $allowed_files)){
            //make sure image is not too big (2mb+)
                if($thumbnail['size'] < 2000000){
                    //upload avatar
                    move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
                }else{
                    $_SESSION['edit-post'] = "File size too big. Must be - 2mb";
                }
            }else{
                $_SESSION['edit-post'] = "Must be PNG, JPG or JPEG";
            }
        }
    }
    $thumbnail_to_insert = isset($thumbnail_name) ? $thumbnail_name : $previous_thumbnail_name;
    //redirect back (with form data) to edit post page if there is any problem
    if($_SESSION['edit-post']){
        //redirect to manage form page if form was invalid
        header('location:' . ROOT_URL . 'admin/edit-post.php');//why falling here
        die();
    }else{
        //set is_featured of all posts to 0 if is_featured for this post is 1
        if($is_featured == 1){
            $zero_all_is_featured_query = "UPDATE posts SET is_featured=0";
            $zero_all_is_featured_result = mysqli_query($connection, $zero_all_is_featured_query);
        }
        //set thumbnail name if a new one was uploaded, else keep old thumbnail
        $query = "UPDATE posts SET title='$title', body='$body', thumbnail='$thumbnail_to_insert', category_id=$category_id, is_featured=$is_featured WHERE id=$id LIMIT 1";
        $result = mysqli_query($connection, $query);
    
        if(!mysqli_errno($connection)){
            $_SESSION['edit-post-success'] = "New post edited successfully";
        }
    }
    
}
header('location:' . ROOT_URL . 'admin/');
die();
?>