
<?php
if(isset($_GET['edit_user']))
{
        $the_user_id = $_GET['edit_user'];
        $query = "SELECT * FROM users WHERE user_id = $the_user_id";
        $select_users_info_query = mysqli_query($connection, $query);
    
    while($row = mysqli_fetch_assoc($select_users_info_query))
    {
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_email = $row['user_email'];
        $user_role = $row['user_role'];
    }
}

if(isset($_POST['edit_user']))
{
    $userr_id = $_GET['edit_user'];
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $username = $_POST['username'];
    $user_password = $_POST['user_password'];
    $user_email = $_POST['user_email'];
    $user_role = $_POST['user_role'];
    //$post_comment_count = 0;
    
    //move_uploaded_file($post_image_temp, "../images/$post_image");
    

    if(!empty($user_password))
    {
        $query_password = "SELECT user_password FROM users WHERE user_id = $the_user_id";
        $get_user_query = mysqli_query($connection, $query_password);
        confirmQuery($get_user_query);
        
        $row = mysqli_fetch_array($get_user_query);
        $db_user_password = $row['user_password'];
    
    
    if($db_user_password != $user_password)
    {
        $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
            
        $query = "UPDATE users SET ";
        $query .= "user_password = '{$hashed_password}' ";
        $query .= "WHERE user_id = $the_user_id";
        $user_change_pass = mysqli_query($connection, $query);

        confirmQuery($user_change_pass);
    }

    }
    
        $query = "UPDATE users SET ";
        $query .= "user_firstname='{$user_firstname}', ";
        $query .= "user_lastname='{$user_lastname}', ";
        $query .= "username='{$username}', ";
        $query .= "user_email='{$user_email}', ";
        $query .= "user_role='{$user_role}' ";
        $query .= "WHERE user_id = $userr_id";

        $user_create_query = mysqli_query($connection, $query);

        confirmQuery($user_create_query);
}

   
?>
   <form action="" method="post" enctype="multipart/form-data">
    
    
    <div class="form-group">
    <label for="title">First name</label>
    <input type="text" class="form-control" value="<?php echo $user_firstname; ?>" name="user_firstname">
    </div>
    
    <div class="form-group">
    <label for="post_status">Last name</label>
    <input type="text" class="form-control" value="<?php echo $user_lastname; ?>" name="user_lastname">
    </div>
    
    
    <div class="form-group">
    <label for="post_status">Username</label>
    <input type="text" class="form-control" value="<?php echo $username; ?>" name="username">
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
    <label for="user_role">User Role</label>
    <br>
    <select name="user_role" id="">
    <option value="<?php echo $user_role; ?>" selected><?php echo $user_role; ?></option>
       
       <?php 
        if ($user_role=='subscriber')
        {
           echo "<option value='admin'>admin</option>";
        }
        else
        {
            echo "<option value='subscriber'>subscriber</option>";
        }
        ?>

        </select>
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="edit_user" value="Edit User">
    </div>
    
    
</form>