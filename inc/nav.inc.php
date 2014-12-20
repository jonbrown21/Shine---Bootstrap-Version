<?PHP
    // if(rand(1,30) == 1)
    //     include 'tweet-cron.php';

    $db = Database::getDatabase();
    $feedback_count = $db->getValue("SELECT COUNT(*) FROM shine_feedback WHERE new = 1");
    $tweet_count = $db->getValue("SELECT COUNT(*) FROM shine_tweets WHERE new = 1");
?>



 <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Shine</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="users.php"><i class="fa fa-user fa-fw"></i> Users</a>
                        </li>
                        <li><a href="settings.php"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
			<li class="sidebar-search"><form action="orders.php?id=<?PHP echo @$app_id; ?>" method="get">
                            <div class="input-group custom-search-form">
							
                                <input type="text" name="q" value="<?PHP echo @$q; ?>" id="q" class="form-control" placeholder="Search Orders...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="submit" name="btnSearch" id="btnSearch">
                                    <i class="fa fa-search"></i>
                                </button>


                            </span>
							
                            </div></form>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="index.php"><i class="fa fa-home fa-fw"></i> Home</a>
                        </li>
                        <li>
                            <a href="orders.php"><i class="fa fa-paypal fa-fw"></i> Orders</a>
                            
                            <!-- /.nav-second-level -->
                        </li>
						<li>
                            <a href="order-new.php"><i class="fa fa-money fa-fw"></i> Create Order</a>
                            
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="activations.php"><i class="fa fa-check-circle fa-fw"></i> Activations</a>
                        </li>
                        <li>
                            <a href="feedback.php"><i class="fa fa-comments fa-fw"></i> Feedback (<?PHP echo $feedback_count; ?>)</a>
                        </li>
                        <li>
                            <a href="tweets.php"><i class="fa fa-twitter fa-fw"></i> Tweets (<?PHP echo $tweet_count; ?>)</a>
                           
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="stats.php"><i class="fa fa-line-chart fa-fw"></i> Sparkle Stats</a>
                            
                            <!-- /.nav-second-level -->
                        </li>
                    

<form action="index.php" method="post">
<li class="sidebar-search" style="line-height: 2.5em;">
Create App
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="App Name" name="name" id="appname">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="submit" name="btnNewApp" id="btnNewApp">
                                    <i class="fa fa-arrow-circle-right"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
</form>	


                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>