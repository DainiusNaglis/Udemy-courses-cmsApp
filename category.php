<?php include "includes/db.php"?>
<?php include "includes/header.php"?>
<?php include "admin/includes/functions.php"?>   
    <?php session_start(); ?>

    <!-- Navigation -->
<?php include "includes/navigation.php"?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

               <?php
    
    if(isset($_GET['category']))
    {
        $post_categ = $_GET['category'];
        
        if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin')
        {
            $stmt1 = mysqli_prepare($connection, "SELECT post_id, post_title, post_user, post_author, post_date, post_image, post_content FROM posts WHERE post_category_id = ?");
        }
        else
        {
            $stmt2 = mysqli_prepare($connection, "SELECT post_id, post_title, post_user, post_author, post_date, post_image, post_content FROM posts WHERE post_category_id = ? AND post_status = ?");
            
            $published = 'published';
        }
        
        if(isset($stmt1))
        {
            mysqli_stmt_bind_param($stmt1, "i", $post_categ);
            mysqli_stmt_execute($stmt1);
            mysqli_stmt_bind_result($stmt1, $post_id, $post_title, $post_user, $post_author, $post_date, $post_image, $post_content);
            
            $stmt = $stmt1;
        }
        
        if(isset($stmt2))
        {
            mysqli_stmt_bind_param($stmt2, "is", $post_categ, $published);
            mysqli_stmt_execute($stmt2);
            mysqli_stmt_bind_result($stmt2, $post_id, $post_title, $post_user, $post_author, $post_date, $post_image, $post_content);
            
            $stmt = $stmt2;
        }

        if(mysqli_stmt_num_rows($stmt) === 0)
        {
            echo "<h1>Sorry, there are no published posts</h1>";
        }
        
        
            while(mysqli_stmt_fetch($stmt)):
            
                
                ?>

                <h1 class="page-header">
            Page Heading
            <small>Secondary Text</small>
        </h1>

        <!-- First Blog Post -->
        <h2>
            <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title ?></a>
        </h2>
        <p class="lead">
            by <a href="author_posts.php?author=<?php echo $post_user; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_user ?></a>
        </p>
        <p><span class="glyphicon glyphicon-time"></span> Posted on: <?php echo $post_date ?></p>
        <hr>
        <a href="post.php?p_id=<?php echo $post_id; ?>">
        <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
        </a>
        <hr>
        <p><?php echo $post_content ?></p>
        <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a> 

          <?php  endwhile; mysqli_stmt_close($stmt);  }
                else
                {
                    header("Location: index.php");
                }?>


            </div>

            <!-- Blog Sidebar Widgets Column -->
<?php include "includes/sidebar.php"?>

        </div>
        <!-- /.row -->

        <hr>

<?php include "includes/footer.php"?>
