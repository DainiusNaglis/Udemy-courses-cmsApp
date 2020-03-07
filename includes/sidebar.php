            <!-- Blog Sidebar Widgets Column -->
                <div class="col-md-4">

               <?php
                    
                   if(isset($_POST['submit']))
                   {
                     $search = $_POST['search'];  
                     $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%'";
                     $search_query = mysqli_query($connection, $query);
                       
                     if(!$search_query)
                     {
                         die("QUERY FAILED" . mysqli_error($connection));
                     }
                       
                     $count = mysqli_num_rows($search_query);

                   }
                    ?>
               
               
                <!--Login form-->
               <div class="well">
                   
                   <?php
                   if(isset($_SESSION['user_role']))
                   {
                       echo "<h4>Logged in as " . $_SESSION['username'] . "</h4>";
                       ?>
                       <a href="includes/logout.php" class="btn btn-primary">Logout</a>
                       
                       <?php
                   }
                   
                   else
                   { ?>
                      
                       <h4>Login</h4>
                    <form action="includes/login.php" method = "post">
                    <div class="form-group">
                        <input name="username" type="text" class="form-control" placeholder="Username">
                    </div>
                    <div class="input-group">
                        <input name="password" type="password" class="form-control" placeholder="Password">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" name="login" type="submit">
                                Submit
                            </button>
                        </span>
                    </div>
                    </form> 
                         
                   <?php } ?>
                   
                   
                     <!-- search form -->
                    <!-- /.input-group -->
                </div>
               
               
               
                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <form action="search.php" method = "post">
                    <div class="input-group">
                        <input name="search" type="text" class="form-control">
                        <span class="input-group-btn">
                            <button name = "submit" class="btn btn-default" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
                    </form>  <!-- search form -->
                    <!-- /.input-group -->
                </div>

               
               
               
                <!-- Blog Categories Well -->
                <div class="well">
                   
                   <?php 
                 $query = "SELECT * FROM categories";
                $select_all_categories_sidebar = mysqli_query($connection, $query);
                    ?>
                   
                   
                   
                   
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="list-unstyled">
                                <?php
                                
                while($row = mysqli_fetch_assoc($select_all_categories_sidebar))
                {
                    $cat_title = $row['cat_title'];
                    $cat_id = $row['cat_id'];
                    echo "<li><a href='category.php?category=$cat_id'>{$cat_title}</a></li>";
                }
    
                                ?>
                            </ul>
                        </div>
                        

                    </div>
                    <!-- /.row -->
                </div>

               
               
               
               
               
                <!-- Side Widget Well -->
<?php include "includes/widget.php"; ?>

            </div>