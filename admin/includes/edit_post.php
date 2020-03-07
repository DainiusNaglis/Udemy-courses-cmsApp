<?php

if(isset($_GET['p_id']))
{
    $the_post_id = $_GET['p_id'];
}

$query = "SELECT * FROM posts WHERE post_id={$the_post_id}";
$select_posts_by_id = mysqli_query($connection, $query);

while($row = mysqli_fetch_assoc($select_posts_by_id))
{
$post_id = $row['post_id'];
$post_user = $row['post_user'];
$post_title = $row['post_title'];
$post_cat = $row['post_category_id'];
$post_stat = $row['post_status'];
$post_img = $row['post_image'];
$post_tag = $row['post_tags'];
$post_comment = $row['post_comment_count'];
$post_date = $row['post_date'];
$post_content = $row['post_content'];

}

if(isset($_POST['edit_post']))
{
    $post_title = $_POST['post_title'];
    $post_cat = $_POST['post_category_id'];
    $post_user = $_POST['post_user'];
    $post_stat = $_POST['post_status'];
    $post_img = $_FILES['image']['name'];
    $post_img_temp = $_FILES['image']['tmp_name'];
    $post_tag = $_POST['post_tags'];
    $post_content = $_POST['post_content']; 
    
    move_uploaded_file($post_img_temp, "../images/$post_img");
    
    if(empty($post_img))
    {
        $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
        $select_image = mysqli_query($connection, $query);
        
        while($row = mysqli_fetch_array($select_image))
        {
            $post_img = $row['post_image'];
        }
    }
    
    $query = "UPDATE posts SET ";
    $query .= "post_category_id='{$post_cat}', ";
    $query .= "post_title='{$post_title}', ";
    $query .= "post_user='{$post_user}', ";
    $query .= "post_image='{$post_img}', ";
    $query .= "post_content='{$post_content}', ";
    $query .= "post_tags='{$post_tag}', ";
    $query .= "post_status='{$post_stat}', ";
    $query .= "post_date=now() ";
    $query .= "WHERE post_id={$the_post_id} ";
    
    $edit_post = mysqli_query($connection, $query);
    
    confirmQuery($edit_post);
    
    echo "<p class='bg-success'>Post Updated. <a href='../post.php?p_id=$the_post_id'>View Post</a> or <a href='posts.php'>Edit more posts</a></p>";
    //echo "<script type='text/javascript'>alert('Post edited successfully!')</script>";
    
    $query = "UPDATE posts SET post_views_count = 0 WHERE post_id={$the_post_id}";
    $reset_views_query = mysqli_query($connection, $query);
    
}

?>
   
   
   <form action="" method="post" enctype="multipart/form-data">
    
    
    <div class="form-group">
    <label for="title">Post Title</label>
    <input type="text" class="form-control" name="post_title" value="<?php echo $post_title; ?>">
    </div>
    
    <div class="form-group">
    <label for="title">Post Category</label>
    <?php echo "<br>"; ?>
    <select name="post_category_id" id="">
       
       <?php
        
        
        $query = "SELECT * FROM categories";
        $select_categories = mysqli_query($connection, $query);

        confirmQuery($select_categories);
        while($row = mysqli_fetch_assoc($select_categories))
        {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
            
            if($cat_id == $post_cat)
            {
                echo "<option selected value='$cat_id'>$cat_title</option>";
            }
            else
            {
            echo "<option value='$cat_id'>$cat_title</option>";
            }
        }


        ?>
        
        </select>
    </div>
    
<!--
    <div class="form-group">
    <label for="title">Post Author</label>
    <input value="<?php //echo $post_author; ?>" type="text" class="form-control" name="post_author">
    </div>
-->
    
    <div class="form-group">
    <label for="post_user">User</label>
    <?php echo "<br>"; ?>
    <select name="post_user" id="">
       
        <?php
        $query = "SELECT * FROM users";
        $select_users = mysqli_query($connection, $query);

        confirmQuery($select_users);
        while($row = mysqli_fetch_assoc($select_users))
        {
        $username = $row['username'];
            
            if($username == $post_user)
            {
                echo "<option selected value='$username'>$username</option>";
            }
            else
            {
                echo "<option value='$username'>$username</option>";
            }
        }


        ?>
        
        </select>
    </div>
    
    
    <?php
       
       $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
       $select_post_with_id = mysqli_query($connection, $query);
       
       while($row = mysqli_fetch_array($select_post_with_id))
       {
           $post_status = $row['post_status'];
       }
       
       ?>
    
    <div class="form-group">
    <label for="post_status">Post Status</label>
    <br>
    <select name="post_status" id="">
       
       <?php
        if($post_status == 'published')
        {
           ?> 
        <option value="published" selected>published</option>
        <option value="draft">draft</option>
        
        <?php } 
        
        else
        {
        ?>
        <option value="draft" selected>draft</option>
        <option value="published">published</option>
        <?php } ?>
        
        </select>
    </div>
    
    <div class="form-group">
    <img width="100" src="../images/<?php echo $post_img; ?>" alt="">
    <input type="file" name="image">
    </div>
    
    <div class="form-group">
    <label for="post_tags">Post Tags</label>
    <input value="<?php echo $post_tag; ?>" type="text" class="form-control" name="post_tags">
    </div>
    
    <div class="form-group">
    <label for="post_content">Post Content</label>
    <textarea class="form-control" name="post_content" id="body" cols="30" rows="10"><?php echo $post_content; ?>
    </textarea>
    </div>
    
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="edit_post" value="Edit Post">
    </div>
    
    
</form>