<?php include "includes/db.php"?>
<?php include "includes/header.php"?>
<?php session_start(); ?>
    <!-- Navigation -->
<?php include "includes/navigation.php"?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

               <?php
    
                if(isset($_GET['p_id']))
                {
                    $the_post_id = $_GET['p_id'];
                    $the_post_user = $_GET['author'];
                }
    
                $query = "SELECT * FROM posts WHERE post_user = '$the_post_user' AND post_status = 'published'";
    
                $select_all_posts_author_query = mysqli_query($connection, $query);
                    
                    while($row = mysqli_fetch_assoc($select_all_posts_author_query))
                    {
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];
                        
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
                    by <a href="author_posts.php?author=<?php echo $the_post_user ?>&p_id=<?php echo $post_id ?>"><?php echo $the_post_user ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on: <?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
                <hr>
                <p><?php echo $post_content ?></p>
                 
                    
                  <?php  }   ?>
                       
    


           
           
            </div>

            <!-- Blog Sidebar Widgets Column -->
<?php include "includes/sidebar.php"?>

        </div>
        <!-- /.row -->

        <hr>

<?php include "includes/footer.php"?>
