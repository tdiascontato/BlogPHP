<?php 
include 'partials/header.php'; 
//fetch post from db if id is set
if(isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $post = mysqli_fetch_assoc($result);
}else{
    header('location:' . ROOT_URL . 'blog.php');
    die();
}
?>

<!--Post-->
    <section class="singlepost">
        <div class="container singlepost__container">
            <h2><?=$post['title']?></h2>
            <div class="post__author">
                <?php
                    $author_id = $post['author_id'];
                    $author_query = "SELECT * FROM users WHERE id=$author_id";
                    $author_result = mysqli_query($connection, $author_query);
                    $author = mysqli_fetch_assoc($author_result);
                ?>
                <div class="post__author-avatar">
                    <img src= "./images/<?=$author['avatar']?>" alt="Image">
                </div>
                <div class="post__author-info">
                    <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                        <small>
                            <?=date("d M, Y", strtotime($post['date_time']))?>
                        </small>
                </div>
            <div class="singlepost__thumbnail">
                <img src="./images/<?=$post['thumbnail']?>" alt="Image">
            </div>
            <p>
                <?=$post['body']?>
            </p>
        </div>
    </section>
<!--Post-->

<!--Categories-->
<section class="category__buttons">
    <div class="container category__buttons-container">
        <?php
            $all_categories_query = "SELECT * FROM categories";
            $all_categories = mysqli_query($connection, $all_categories_query);
        ?>
        <?php while($category = mysqli_fetch_assoc($all_categories)): ?>
        <a href="<?=ROOT_URL?>category-posts.php?id=<?=$category['id']?>" class="category__button"><?=$category['title']?></a>
        <?php endwhile ?>
    </div>
</section>
<!--Categories-->

<?php include 'partials/footer.php'; ?>