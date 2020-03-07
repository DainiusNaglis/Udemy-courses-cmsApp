<?php

function escape($string)
{
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
}


function confirmQuery($result)
{
    global $connection;
        if(!$result)
    {
        die ("QUERY FAILED ." . mysqli_error($connection));
    }
    
}


function insert_categories()
{
    global $connection;
    if(isset($_POST['submit']))
{
    $cat_title = $_POST['cat_title'];
    
    if($cat_title == "" || empty($cat_title))
    {
        echo "This field should not be empty";
    }
    else
    {
        $query = mysqli_prepare($connection, "INSERT INTO categories (cat_title) VALUE (?)");
        mysqli_stmt_bind_param($query, 's', $cat_title);
        mysqli_stmt_execute($query);
        
        if(!$query)
        {
            die("QUERY FAILED" . mysqli_error($connection));
        }
    }
}
}

function findAllCategories()
{
    global $connection;
$query = "SELECT * FROM categories";
$select_all_categories = mysqli_query($connection, $query);
                                
while($row = mysqli_fetch_assoc($select_all_categories))
{
$cat_id = $row['cat_id'];
$cat_title = $row['cat_title'];

echo "<tr>";
echo "<td>{$cat_id}</td>";
echo "<td>{$cat_title}</td>";
echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
echo "</tr>"; 
}
}

function deleteCategories()
{
    global $connection;
    if(isset($_GET['delete']))
{
    $the_cat_id = $_GET['delete'];
    $query = "DELETE FROM categories WHERE cat_id = {$the_cat_id}";
    $cat_delete_query = mysqli_query($connection, $query);
    header ("Location: categories.php");
}
}


function deleteComment()
{
    global $connection;
    if(isset($_GET['delete']))
{

    $the_coment_id = $_GET['delete'];
    $query = "DELETE FROM comments WHERE comment_id={$the_coment_id}";
    $delete_query = mysqli_query($connection, $query);
    header ("Location: comments.php");
    confirmQuery($delete_query); 
}
}

function unapproveComment()
{
    global $connection;
    if(isset($_GET['unapprove']))
{

    $the_coment_id = $_GET['unapprove'];
    $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = $the_coment_id";
    $unapprove_comment_query = mysqli_query($connection, $query);
    header ("Location: comments.php");
    confirmQuery($unapprove_comment_query); 
} 
}

function approveComment()
{
    global $connection;
    if(isset($_GET['approve']))
{

    $the_coment_id = $_GET['approve'];
    $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = $the_coment_id";
    $approve_comment_query = mysqli_query($connection, $query);
    header ("Location: comments.php");
    confirmQuery($approve_comment_query); 
} 
}

function deleteUser()
{
    global $connection;
    if(isset($_GET['delete']))
{

    if(isset($_SESSION['user_role']))
    {
        if($_SESSION['user_role'] == 'admin')
        {
    $the_user_id = mysqli_real_escape_string($connection, $_GET['delete']);
    $query = "DELETE FROM users WHERE user_id={$the_user_id}";
    $delete_user_query = mysqli_query($connection, $query);
    header ("Location: users.php");
    confirmQuery($delete_user_query);
    }
    }
}
}

function userToAdmin()
{
    global $connection;
    if(isset($_GET['change_to_admin']))
{

    $the_user_id = $_GET['change_to_admin'];
    $query = "UPDATE users SET user_role = 'admin' WHERE user_id = $the_user_id";
    $user_to_admin_query = mysqli_query($connection, $query);
    header ("Location: users.php");
    confirmQuery($user_to_admin_query); 
} 
}

function userToSubscriber()
{
    global $connection;
    if(isset($_GET['change_to_subscriber']))
{

    $the_user_id = $_GET['change_to_subscriber'];
    $query = "UPDATE users SET user_role = 'subscriber' WHERE user_id = $the_user_id";
    $user_to_subscriber_query = mysqli_query($connection, $query);
    header ("Location: users.php");
    confirmQuery($user_to_subscriber_query); 
} 
}

function users_online() {

    global $connection;

        $session = session_id();
        $time = time();
        $time_out_in_seconds = 05;
        $time_out = $time - $time_out_in_seconds;

        $query = "SELECT * FROM users_online WHERE session = '$session'";
        $send_query = mysqli_query($connection, $query);
        $count = mysqli_num_rows($send_query);

            if($count == NULL) {
            mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session','$time')");
            } else {
            mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
            }

        $users_online_query =  mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
        echo $count_user = mysqli_num_rows($users_online_query);

}

function is_admin($username)
{
    global $connection;
    
    $query = "SELECT user_role FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    
    $row = mysqli_fetch_array($result);
    if($row['user_role'] == 'admin')
    {
        return true;
    }
    else
    {
        return false;
    }
    
}

function username_exists($username)
{
    global $connection;
    
    $query = "SELECT username FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    
    if(mysqli_num_rows($result) > 0)
    {
        return true;
    }
    else
    {
        return false;
    }
}


function email_exists($email)
{
    global $connection;
    
    $query = "SELECT user_email FROM users WHERE user_email = '$email'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    
    if(mysqli_num_rows($result) > 0)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function register_user($username, $email, $password)
{
    global $connection;
    
            $username = mysqli_real_escape_string($connection, $username);
            $email = mysqli_real_escape_string($connection, $email);
            $password = mysqli_real_escape_string($connection, $password);
            
            $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
            
            $query = "INSERT INTO users (username, user_password, user_email, user_role) ";
            $query .= "VALUES ('{$username}', '{$password}', '{$email}', 'subscriber') ";
            $insert_reg_user_query = mysqli_query($connection, $query);
            confirmQuery($insert_reg_user_query);
            echo "<script>alert('Your registration is completed!')</script>";
        
}


function redirect($location){


    header("Location:" . $location);
    exit;

}

function login_user($username, $password)
{
    
global $connection;
$username = trim($username);
$password = trim($password);   
$username = mysqli_real_escape_string($connection, $username);
$password = mysqli_real_escape_string($connection, $password);

$query = "SELECT * FROM users WHERE username = '$username' ";
$check_user_query = mysqli_query($connection, $query);
confirmQuery($check_user_query);

while($row = mysqli_fetch_array($check_user_query))
{
    $db_user_id = $row['user_id'];
    $db_username = $row['username'];
    $db_user_password = $row['user_password'];
    $db_user_firstname = $row['user_firstname'];
    $db_user_lastname = $row['user_lastname'];
    $db_user_role = $row['user_role'];
}

//$password = crypt($password, $db_user_password);
if (password_verify($password,$db_user_password)) {

             $_SESSION['username'] = $db_username;
             $_SESSION['firstname'] = $db_user_firstname;
             $_SESSION['lastname'] = $db_user_lastname;
             $_SESSION['user_role'] = $db_user_role;
    
header ("Location: ../admin/index.php");
         }
}

//function redirect($location)
//{
//    header("Location:" . $location);
//    exit;
//}

function ifItIsMethod($method=null)
{
    if($_SERVER['REQUEST_METHOD'] == strtoupper($method))
    {
        return true;
    }
    return false;
}

function isLoggedIn()
{
    if(isset($_SESSION['user_role']))
    {
        return true;
    }
    
    return false;
}

function checkIfUserIsLoggedInAndRedirect($redirectLocation=null)
{
    if(isLoggedIn())
    {
        redirect($redirectLocation);
    }
}
     

?>