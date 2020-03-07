<?php include "includes/header.php"; ?>       
               
                <div id="wrapper">

        <!-- Navigation -->

<?php include "includes/navigation.php"; ?>
       
        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to Admin page
                            <small>Author</small>
                        </h1>
                           

                                                  
                        <table class ="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Author</th>
                                    <th>Comment</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>In Response to</th>
                                    <th>Date</th>
                                    <th>Approve</th>
                                    <th>Unapprove</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                        <tbody>
                           
<?php
if(isset($_GET['id']))
{
$the_post_id = $_GET['id'];
$query = "SELECT * FROM comments WHERE comment_post_id = $the_post_id";
$select_comments = mysqli_query($connection, $query);

while($row = mysqli_fetch_assoc($select_comments))
{
$comment_id = $row['comment_id'];
$comment_post_id = $row['comment_post_id'];
$comment_author = $row['comment_author'];
$comment_email = $row['comment_email'];
$comment_content = $row['comment_content'];
$comment_status = $row['comment_status'];
$comment_date = $row['comment_date'];

    
echo "<tr>";
echo "<td>{$comment_id}</td>";
echo "<td>{$comment_author}</td>";
echo "<td>{$comment_content}</td>";
//    
//$query = "SELECT * FROM categories WHERE cat_id={$post_cat}";
//$select_categories_id = mysqli_query($connection, $query);
//
//while($row = mysqli_fetch_assoc($select_categories_id))
//{
//$cat_id = $row['cat_id'];
//$cat_title = $row['cat_title'];    
//}
//echo "<td>{$cat_title}</td>";
    
    
echo "<td>{$comment_email}</td>";
echo "<td>{$comment_status}</td>";
    
$query = "SELECT * FROM posts WHERE post_id = $comment_post_id";
$select_post_id_query = mysqli_query($connection, $query);

if(!$select_post_id_query)
{
    die ("QUERY FAILED ." . mysqli_error($connection));
}
    
while($row = mysqli_fetch_assoc($select_post_id_query))
{
$post_id = $row['post_id'];
$post_title = $row['post_title'];
}

    
echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
    
    
echo "<td>{$comment_date}</td>";

if(isset($_GET['approve']))
{

    $the_coment_id = $_GET['approve'];
    $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = $the_coment_id";
    $approve_comment_query = mysqli_query($connection, $query);
    header ("Location: post_comments.php?id=$the_post_id");
    confirmQuery($approve_comment_query); 
}    
    
echo "<td><a href='post_comments.php?approve=$comment_id&id=$the_post_id'>Approve</a></td>";
    
if(isset($_GET['unapprove']))
{

    $the_coment_id = $_GET['unapprove'];
    $query = "UPDATE comments SET comment_status = 'unapprove' WHERE comment_id = $the_coment_id";
    $unapprove_comment_query = mysqli_query($connection, $query);
    header ("Location: post_comments.php?id=$the_post_id");
    confirmQuery($unapprove_comment_query); 
}
    
echo "<td><a href='post_comments.php?unapprove=$comment_id&id=$the_post_id'>Unapprove</a></td>";

if(isset($_GET['delete']))
{

    $the_coment_id = $_GET['delete'];
    $query = "DELETE FROM comments WHERE comment_id={$the_coment_id}";
    $delete_query = mysqli_query($connection, $query);
    header ("Location: post_comments.php?id=$the_post_id");
    confirmQuery($delete_query); 
}

echo "<td><a href='post_comments.php?delete=$comment_id&id=$the_post_id'>Delete</a></td>";
echo "</tr>";
}
}
                            
?>

                            </tbody>
                        </table>
                     </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    
    
<?php include "includes/footer.php"; ?>