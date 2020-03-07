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
                            Welcome to admin 

                          
                            <small><?php echo $_SESSION['username']; ?></small>
                        </h1>

                    </div>
                </div>
                <!-- /.row -->
                
                
                       
                <!-- /.row -->
                
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-file-text fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                
                                <?php
                                    $query = "SELECT * FROM posts";
                                    $all_posts_query = mysqli_query($connection, $query);
                                    if(!$all_posts_query)
                                    {
                                        die("QUERY FAILED ." . mysqli_error($connection));
                                    }
                                    
                                    $num_posts = mysqli_num_rows($all_posts_query);
                                    ?>
                                
                              <div class='huge'><?php echo $num_posts; ?></div>
                                    <div>Posts</div>
                                </div>
                            </div>
                        </div>
                        <a href="posts.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                
                                <?php
                                    $query = "SELECT * FROM comments";
                                    $all_comments_query = mysqli_query($connection, $query);
                                    if(!$all_comments_query)
                                    {
                                        die("QUERY FAILED ." . mysqli_error($connection));
                                    }
                                    
                                    $num_comments = mysqli_num_rows($all_comments_query);
                                    ?>
                                
                                
                                
                                 <div class='huge'><?php echo $num_comments; ?></div>
                                  <div>Comments</div>
                                </div>
                            </div>
                        </div>
                        <a href="comments.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                
                                <?php
                                    $query = "SELECT * FROM users";
                                    $all_users_query = mysqli_query($connection, $query);
                                    if(!$all_users_query)
                                    {
                                        die("QUERY FAILED ." . mysqli_error($connection));
                                    }
                                    
                                    $num_users = mysqli_num_rows($all_users_query);
                                    ?>
                                
                                
                                <div class='huge'><?php echo $num_users; ?></div>
                                    <div> Users</div>
                                </div>
                            </div>
                        </div>
                        <a href="users.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-list fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                   
                                   <?php
                                    $query = "SELECT * FROM categories";
                                    $all_categories_query = mysqli_query($connection, $query);
                                    if(!$all_categories_query)
                                    {
                                        die("QUERY FAILED ." . mysqli_error($connection));
                                    }
                                    
                                    $num_categories = mysqli_num_rows($all_categories_query);
                                    ?>
                                   
                                   
                                    <div class='huge'><?php echo $num_categories; ?></div>
                                     <div>Categories</div>
                                </div>
                            </div>
                        </div>
                        <a href="categories.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
                <!-- /.row -->
                
                
                <?php
                $query = "SELECT * FROM posts WHERE post_status = 'published'";
                $select_all_published_posts = mysqli_query($connection, $query);
                $select_all_published_posts = mysqli_num_rows($select_all_published_posts);
                
                $query = "SELECT * FROM posts WHERE post_status = 'draft'";
                $select_all_draft_posts = mysqli_query($connection, $query);
                $num_draft_posts = mysqli_num_rows($select_all_draft_posts);
                
                $query = "SELECT * FROM comments WHERE comment_status = 'unapproved'";
                $select_unapproved_comments = mysqli_query($connection, $query);
                $num_unapproved_comments = mysqli_num_rows($select_unapproved_comments);
                
                $query = "SELECT * FROM users WHERE user_role = 'subscriber'";
                $select_subscribers = mysqli_query($connection, $query);
                $num_subscribers = mysqli_num_rows($select_subscribers);
                ?>
                
                
                
                
                <div class="row">
                    <script type="text/javascript">
                      google.charts.load('current', {'packages':['bar']});
                      google.charts.setOnLoadCallback(drawChart);

                      function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                          ['Data', 'Count'],
                            
                            <?php
                            
                            $element_text = ['All Posts', 'Published Posts', 'Draft Posts', 'Comments', 'Unapproved comments', 'Users', 'Subscribers', 'Categories'];
                            $element_count = [$num_posts, $select_all_published_posts, $num_draft_posts, $num_comments, $num_unapproved_comments, $num_users, $num_subscribers, $num_categories];
                            
                            for($i=0; $i < 8; $i++)
                            {
                                echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}],";
                            }
                            
                            ?>
                            
                          
                       
                        ]);

                        var options = {
                          chart: {
                            title: '',
                            subtitle: '',
                          }
                        };

                        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                        chart.draw(data, google.charts.Bar.convertOptions(options));
                      }
                    </script>
                    
                    <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
               </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    
    
<?php include "includes/footer.php"; ?>