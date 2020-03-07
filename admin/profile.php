<?php include "includes/header.php"; ?>  
              
<?php    

if(isset($_SESSION['username']))
{
    $username = $_SESSION['username'];
    
    $query = "SELECT * FROM users WHERE username = '$username'";
    $select_user_profile_query = mysqli_query($connection, $query);
    if(!$select_user_profile_query)
    {
        die("QUERY FAILED. " . mysqli_error($connection));
    }
    
    while($row = mysqli_fetch_array($select_user_profile_query))
    {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
    }
}

?>  
               
                       
<?php

if(isset($_POST['update_user']))
    {

        $username = $_POST['username'];
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_password = $_POST['user_password'];
        $user_email = $_POST['user_email'];

    
    if(!empty($user_password))
    {
        $query_password = "SELECT user_password FROM users WHERE user_id = $user_id";
        $get_user_query = mysqli_query($connection, $query_password);
        confirmQuery($get_user_query);
        
        $row = mysqli_fetch_array($get_user_query);
        $db_user_password = $row['user_password'];
    
    
    if($db_user_password != $user_password)
    {
        $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
        $query = "UPDATE users SET user_password = '$hashed_password' WHERE user_id = $user_id";
        $change_password_query = mysqli_query($connection, $query);
        confirmQuery($change_password_query);
    }
    
    }

        $query = "UPDATE users SET ";
        $query .= "user_firstname = '$user_firstname', ";
        $query .= "user_lastname = '$user_lastname', ";
        $query .= "username = '$username', ";
        $query .= "user_email = '$user_email' ";
        $query .= "WHERE username = '$username' ";

        $send_query = mysqli_query($connection, $query);
        confirmQuery($send_query);
    }

?>
                                                             
                                                                               
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
                            <small><?php echo $_SESSION['firstname']; ?></small>   
                        </h1>    
                        
 <form action="" method="post" enctype="multipart/form-data">
    
    
    <div class="form-group">
    <label for="title">Username</label>
    <input type="text" class="form-control" value="<?php echo $username; ?>" name="username">
    </div>
    
    <div class="form-group">
    <label for="post_status">First name</label>
    <input type="text" class="form-control" value="<?php echo $user_firstname; ?>" name="user_firstname">
    </div>
    
    
    <div class="form-group">
    <label for="post_status">Last name</label>
    <input type="text" class="form-control" value="<?php echo $user_lastname; ?>" name="user_lastname">
    </div>
    
    <div class="form-group">
    <label for="post_status">Password</label>
    <input autocomplete="off" type="password" class="form-control" name="user_password">
    </div>
    
    <div class="form-group">
    <label for="post_status">Email</label>
    <input type="email" class="form-control" value="<?php echo $user_email; ?>" name="user_email">
    </div>
 
    
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_user" value="Update profile">
    </div>
    
    
</form>
                   
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