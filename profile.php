<?php
    session_start();
    if (!$_SESSION['loggedInEmail']){
        header("Location: index.php");
    }
    
    include('includes/connection.php');
    include('includes/functions.php');
    include('includes/header.php');

    $id = $_SESSION['loggedInId'];

    //Delete Post
    
    if (isset($_POST['pdel'])) {
        $tme = $_POST['pdel'];
        $dpost = "DELETE FROM posts WHERE userid='$id' AND time='$tme'";
        $dpr = mysqli_query($conn, $dpost);
        
    }
    
    //User Info 
    $q1 = "SELECT * FROM users WHERE id='$id'";
    $r1 = mysqli_query( $conn, $q1 );
    
    if (mysqli_num_rows($r1) > 0){
        while ($q_row = mysqli_fetch_assoc($r1)) {
            $fname = $q_row['fname'];
            $lname = $q_row['lname'];
            $dob = $q_row['dob'];
            $city = $q_row['city'];
            $email = $q_row['email'];
            $img = $q_row['Dpic'];
            $img1 = $q_row['cover'];
        }
    }
        
    //Friend Request Noti
    $query = "SELECT status,userid1 FROM friends WHERE userid2 = '$id'";

    $result = mysqli_query( $conn, $query );
   
    if (!$result) {
        echo "<div class='alert alert-alert'>Error has encountered<a class='close' data-dismiss='alert'>&times;</a></div> <br>" . mysqli_error();
    }
    
   ?>
       

<div class="container-fluid">
    <br><br>
    <div class="cover" style=" background: url('<?php echo $img1;?>') no-repeat; background-size: 1000px 480px; background-position: bottom center;">
        
    </div>
</div>
    <div class="container">
    <div class="row">
    
        <!--Profile Image -->
        <div class="col-sm-4">
                    <figure class="snip1515">
          <div class="profile-image"><img class="hvr-bounce-in" src="<?php echo $img; ?>"  /></div>
          <figcaption>
            <h3><?php echo '<b>'.$fname.' '.$lname.'</b>'; ?></h3>
            <h4><?php echo $city; ?></h4>
            <p><?php echo $email; ?></p>
              <hr>
              <h4><b>About</b></h4><br>
              <div class="col-xs-6">
             <b>Date of Birth</b>
              </div>
               <div class="col-xs-6">
             <p><?php echo $dob; ?></p>
              </div>
          </figcaption>
        </figure>
        
        </div>
    <!--/Profile Image -->
        <div class="col-sm-8">
                <div id='menu-nav'>
              <div id='navigation-bar'>
                <ul>
                  <li class='menu-sub-nav current-item'><a href='profile.php'><i class='fa fa-home'></i><span>Timeline</span></a></li>
                  <li class='menu-sub-nav'><a href='messages.php'><i class='fa fa-user'></i><span>Messages</span></a></li>
                  <li class='menu-sub-nav'><a href='friends.php'><i class='fa fa-fw fa-users'></i><span>Friends</span></a></li>
                  <li class='menu-sub-nav'><a href='request.php'><i class='glyphicon glyphicon-plus'></i><span>Requests</span></a></li>
                </ul>
              </div>
              
            </div>
            
            <?php 
                // Posts
            
                if (isset($_POST['post'])) {
                    $text = $_POST['parea'];
                    
                    $pq = "INSERT INTO posts(userid,time,post) VALUES('$id',CURRENT_TIMESTAMP,'$text')";
                    $pres = mysqli_query($conn, $pq);
                }
            
            ?>
            <form class="form-group" action="<?php $_SERVER['php_self']; ?>" method="post">
            <textarea name="parea" style="border-radius:0px;border:6px solid #556677; font-size:120%; width:90%; background:rgba(0,0,0,0.2);" class="form-control" rows="4" placeholder="What's in your mind"></textarea>
            <div class="row" style="background:#F2F2F2;padding:2%;width:89%;margin-left:1%;">    
                <div class="col-md-6">
                <ul class="nav nav-pills">
                            <li><a href="#" style="transition:1s;"><i class="fa fa-map-marker"></i></a></li> 
                            <li><a href="#" style="transition:1s;"><i class="fa fa-camera"></i></a></li>
                            <li><a href="#" style="transition:1s;"><i class=" fa fa-film"></i></a></li>
                            <li><a href="#" style="transition:1s;"><i class="fa fa-microphone"></i></a></li>
                        </ul>
                    </div >
                <div class="col-md-6">
                <button name="post" class="btn btn-primary pull-right hvr-bounce-in" style="transition:1s;">Post</button>
                </div>
            </div>
                    
        </form>   
            <h3 style="color:gray;">User Posts</h3>
        </div>
        
    </div>   
        
    <div class="row">
        <div class="col-sm-4">
        <nav>
		<ul class="mcd-menu">
			
			<li>
				<a href="">
					<i class="fa fa-group"></i>
					<strong>Friend Requests</strong>
				</a>
				<ul>
                    <?php
            if ( mysqli_num_rows($result) > 0){ 
					 while( $row = mysqli_fetch_assoc($result) ) {
                            $freq = $row['status'];
                            $user1= $row['userid1'];
                            if ($freq == 1) { 
                                $query2 = "SELECT fname,lname FROM users WHERE id='$user1'";
                                $res2 = mysqli_query($conn,$query2);
                                if (mysqli_num_rows($res2) > 0){
                                    while($rows = mysqli_fetch_assoc($res2)){
                                        $name1 = $rows['fname'];
                                        $name2 = $rows['lname'];
                                    }
                              ?>
                                <li>
                                    <a href="#"><i class="fa fa-user"></i>
                                        <?php 
                                        echo '<b>'.$name1 .' '. $name2. ' ' .'</b>';
                                        ?></a>
                                    
                                </li>
              <?php 
                                
                                   }
                   
                               
                           }
                    }
                                }
            ?>
					           <li>
                                    <a href="request.php"><i class="fa fa-plus"></i>
                                       <b>View All</b>
                                    </a>
                                    
                                </li>
					
				</ul>
			</li>
            <li>
				<a href="profile.php">
					<i class="fa fa-home"></i>
					<strong>Home</strong>
				</a>
			</li>
             <li>
				<a href="messages.php">
					<i class="fa fa-user"></i>
					<strong>Messages</strong>
				</a>
			</li>
            </ul>
	</nav>
        </div>
       
        <div class="col-sm-8">
            
             <?php 
            
            $show = "SELECT * FROM posts WHERE userid=$id ORDER BY time DESC";
            $sres = mysqli_query($conn,$show);
            if (mysqli_num_rows($sres) > 0){
                while ($sr = mysqli_fetch_assoc($sres)) {
                    $post = $sr['post'];
                    $ptime = $sr['time'];
        ?>
               <div class="candidate" style="width:90%">
                      <div class="candidate__header clearfix ">
                  <img class="candidate__img" src="<?php echo $img; ?>">

                  <div class="candidate__details">
                    <h1 class="candidate__fullname"><b><a style="text-decoration:none; color:black;"><?php echo $fname . ' '.$lname; ?></a></b></h1>                      
                    <h2 class="candidate__location"><?php echo $ptime;?></h2>
                  </div>
                  </div>
                    <span>  
                        <p class="lead"><?php echo $post; ?></p>
                    </span>
                   <form action="<?php $_SERVER['php_self']; ?>" method="post">
                 <button name="pdel" class="btn btn-danger btn-sm pull-right" style="transition:1s;" value="<?php echo $ptime; ?>">Delete</button>
                    </form>
                   <br>

                </div>
            
        <?php    
                }
            } 
        
            ?>
            
        </div>
    </div>
        <br><br><br>
</div>

<?php

    include('includes/footer.php');

?>
