<?php
include("delete_modal.php");

if(isset($_POST['checkBoxArray']))
{
    foreach($_POST['checkBoxArray'] as $checkBoxValue)
    {
       $bulk_options = $_POST['bulk_options'];
        
        switch($bulk_options)
        {
            case 'published':
            $query = "UPDATE posts SET post_status = 'published' WHERE post_id = $checkBoxValue"; 
            $set_published_query = mysqli_query($connection, $query);
            confirmQuery($set_published_query);
            break; 
                
                
            case 'draft':
            $query = "UPDATE posts SET post_status = 'draft' WHERE post_id = $checkBoxValue"; 
            $set_draft_query = mysqli_query($connection, $query);
            confirmQuery($set_draft_query);    
            break;
                
                
            case 'delete':
            $query = "DELETE FROM posts WHERE post_id = $checkBoxValue";
            $delete_selected_post_query = mysqli_query($connection, $query);
            confirmQuery($delete_selected_post_query);    
            break;
                
            case 'clone':
            $query = "SELECT * FROM posts WHERE post_id = $checkBoxValue";
            $select_post_info_query = mysqli_query($connection, $query);
            confirmQuery($select_post_info_query);
                
            while($row = mysqli_fetch_array($select_post_info_query))
            {
                $post_category_id = $row['post_category_id'];
                $post_title = $row['post_title'];
                $post_author = $row['post_author'];
                $post_user = $row['post_user'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = $row['post_content'];
                $post_tags = $row['post_tags'];
                $post_status = 'draft';
            }
            
            $query = "INSERT INTO posts (post_category_id, post_title, post_author, post_user, post_date, post_image, post_content, post_tags, post_status) ";
            $query .= "VALUES ($post_category_id, '$post_title', '$post_author', '$post_user', '$post_date', '$post_image', '$post_content', '$post_tags', '$post_status')";
                
            $clone_query = mysqli_query($connection, $query);
            confirmQuery($clone_query);  
            break;
                
        }
    }
}

?>
                          

                          
                          
<form action="" method="post">                        
                           
                           
<table class ="table table-bordered table-hover">

<div id="bulkOptionContainer" class="col-xs-4" style="padding:0px">
    
    <select class="form-control" name="bulk_options" id="">
        
        <option value="">Select Options</option>
        <option value="published">Publish</option>
        <option value="draft">Draft</option>
        <option value="delete">Delete</option>
        <option value="clone">Clone</option>
    </select>
    
</div>
<div class="col-xs-4">
<input type="submit" name="submit" class="btn btn-success" value="Apply">
   <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>    
    
    
</div>


<thead>
    <tr>
        <th><input id="selectAllBoxes" type="checkbox"></th>
        <th>Id</th>
        <th>User</th>
        <th>Title</th>
        <th>Category</th>
        <th>Status</th>
        <th>Image</th>
        <th>Tags</th>
        <th>Comments</th>
        <th>Date</th>
        <th>View</th>
        <th>Edit</th>
        <th>Delete</th>
        <th>Post Views</th>
    </tr>
</thead>

<tbody>
                           
<?php
$query = "SELECT * FROM posts ORDER BY post_id DESC";
$select_posts = mysqli_query($connection, $query);

while($row = mysqli_fetch_assoc($select_posts))
{
$post_id = $row['post_id'];
$post_author = $row['post_author'];
$post_user = $row['post_user'];
$post_title = $row['post_title'];
$post_cat = $row['post_category_id'];
$post_stat = $row['post_status'];
$post_img = $row['post_image'];
$post_tag = $row['post_tags'];
$post_comment = $row['post_comment_count'];
$post_date = $row['post_date'];
$post_views_count = $row['post_views_count'];
 
echo "<tr>";    
    
?>
   
<td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id; ?>'></td>
            
<?php   

echo "<td>{$post_id}</td>";
    
echo "<td>{$post_user}</td>";

echo "<td>{$post_title}</td>";
    
$query = "SELECT * FROM categories WHERE cat_id={$post_cat}";
$select_categories_id = mysqli_query($connection, $query);

while($row = mysqli_fetch_assoc($select_categories_id))
{
$cat_id = $row['cat_id'];
$cat_title = $row['cat_title'];    
}
echo "<td>{$cat_title}</td>";
    
    
echo "<td>{$post_stat}</td>";
echo "<td><img width='100' img src='../images/{$post_img}'</td>";
echo "<td>{$post_tag}</td>";
    
$query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
$post_comments_count = mysqli_query($connection, $query);
//$row = mysqli_fetch_array($post_comments_count);
//$comment_id = $row['comment_id'];
$comment_num = mysqli_num_rows($post_comments_count);
    
echo "<td><a href='./post_comments.php?id=$post_id'>{$comment_num}</a></td>";
    
    
    
echo "<td>{$post_date}</td>";
echo "<td><a class='btn btn-primary' href='../post.php?p_id={$post_id}'>View Post</a></td>";
echo "<td><a class='btn btn-info' href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
    
?>
   
      <form method="post">

            <input type="hidden" name="post_id" value="<?php echo $post_id ?>">

         <?php   

            echo '<td><input class="btn btn-danger" type="submit" name="delete" value="Delete"></td>';

          ?>


        </form>
       
<?php    
    
    
//echo "<td><a rel='$post_id' href='javascript:void(0)' class='delete_link'>Delete</a></td>";
    
    
    
    
    
//echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete?'); \" href='posts.php?delete={$post_id}'>Delete</a></td>";
echo "<td>{$post_views_count}</td>";
echo "</tr>";    
    
}
?>

                        </tbody>
                            
                        </table>
                        
                        </form> 


<?php

if(isset($_POST['delete'])){
    
    $the_post_id = escape($_POST['post_id']);
    
    $query = "DELETE FROM posts WHERE post_id = {$the_post_id} ";
    $delete_query = mysqli_query($connection, $query);
    header ("Location: posts.php");
    
    
}

?>


<script>
$(document).ready(function()
                  {
    $(".delete_link").on('click', function()
                        {
        var id = $(this).attr("rel");
        var delete_url = "posts.php?delete="+ id + " ";
        
        $(".modal_delete_link").attr("href", delete_url);
        $("#myModal").modal('show');

    });
});
</script>