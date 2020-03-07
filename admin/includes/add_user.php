
<?php 

if(isset($_POST['add_user']))
{
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $username = $_POST['username'];
    $user_password = $_POST['user_password'];
    $user_email = $_POST['user_email'];
    $user_role = $_POST['user_role'];
    //$post_comment_count = 0;
    
    //move_uploaded_file($post_image_temp, "../images/$post_image");
    $crypted_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));
    $query = "INSERT INTO users(username, user_password, user_firstname, user_lastname, user_email, user_role) ";
    $query .="VALUES('{$username}','{$crypted_password}','{$user_firstname}','{$user_lastname}','{$user_email}','{$user_role}')";
    
    $user_create_query = mysqli_query($connection, $query);
    
    confirmQuery($user_create_query);
    echo "User added successfully!";
}
   
?>
   <form action="" method="post" enctype="multipart/form-data">
    
    
    <div class="form-group">
    <label for="title">First name</label>
    <input type="text" class="form-control" name="user_firstname">
    </div>
    
    <div class="form-group">
    <label for="post_status">Last name</label>
    <input type="text" class="form-control" name="user_lastname">
    </div>
    
    
    <div class="form-group">
    <label for="post_status">Username</label>
    <input type="text" class="form-control" name="username">
    </div>
    
    <div class="form-group">
    <label for="post_status">Password</label>
    <input type="password" class="form-control" name="user_password">
    </div>
    
    <div class="form-group">
    <label for="post_status">Email</label>
    <input type="email" class="form-control" name="user_email">
    </div>
    
        <div class="form-group">
    <select name="user_role" id="">
       <option value="subscriber">Select Options</option>
       <option value="admin">Admin</option>
       <option value="subscriber">Subscriber</option>
        <?php

        ?>
        
        </select>
    </div>
    
    
    

    
    
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="add_user" value="Add User">
    </div>
    
    
</form>