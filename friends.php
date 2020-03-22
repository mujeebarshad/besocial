<?php

    session_start();
    if (!$_SESSION['loggedInEmail']){
        header("Location: index.php");
    }
    
    include('includes/connection.php');
    include('includes/functions.php');
    include('includes/header.php');

    $id = $_SESSION['loggedInId'];
    //Unfriend
    if (isset($_POST['friends'])){
        $id1 = $_POST['friends'];
         $bquery = "DELETE FROM friends
                  WHERE userid1 = '$id1'
                  AND userid2 = '$id'";
        $bres = mysqli_query($conn, $bquery);
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
        }
    }
    
    //Friend Request Noti
    $query = "SELECT status,userid1 FROM friends WHERE userid2 = '$id'";

    $result = mysqli_query( $conn, $query );
   
    if (!$result) {
        echo "<div class='alert alert-alert'>Error has encountered<a class='close' data-dismiss='alert'>&times;</a></div> <br>" . mysqli_error();
    }
    
   ?>
    <br><br><br><br>
    <div class="container">
        <div class="notification-bar"><?php echo $success; ?></div>
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
            <div class="col-sm-8">
                <?php
                    
                    $results_per_page = 1;
                    if (!isset($_GET['page'])) {
                          $page = 1;
                        } else {
                          $page = $_GET['page'];
                        }
                    $this_page_first_result = ($page-1)*$results_per_page;

                    $fquery = "SELECT * FROM friends WHERE status = 2 AND (userid1=$id OR userid2=$id)";
                    $fres = mysqli_query($conn,$fquery);
                    $number_of_results = mysqli_num_rows($fres);
                    $number_of_pages = ceil($number_of_results/$results_per_page);
                    $fquery = "SELECT * FROM friends WHERE status = 2 AND (userid1=$id OR userid2=$id) LIMIT " . $this_page_first_result . "," .$results_per_page;
                    $fres = mysqli_query($conn,$fquery);
                    if (mysqli_num_rows($fres) > 0){
                        $fid = "";
                        $fn = "";
                        $fl = "";
                        $fct = "";
                        $fcn = "";
                        $fimg = "";
                        
                        while ($frow = mysqli_fetch_assoc($fres)) {
                            if ($frow['userid1'] == $id){
                                $id2 = $frow['userid2'];
                                $fq1 = "SELECT * FROM users WHERE id = $id2";
                                $fres1 = mysqli_query($conn,$fq1);
                                if (mysqli_num_rows($fres1) > 0 ){
                                    while($frow1 = mysqli_fetch_assoc($fres1)) {
                                        $fid = $frow1['id'];
                                        $fn = $frow1['fname'];
                                        $fl = $frow1['lname'];
                                        $fct = $frow1['city'];
                                        $fcn = $frow1['country'];
                                        $fimg = $frow1['Dpic'];
                                    }
                                }
                            }else {
                                $id2 = $frow['userid1'];
                                $fq1 = "SELECT * FROM users WHERE id = $id2";
                                $fres1 = mysqli_query($conn,$fq1);
                                if (mysqli_num_rows($fres1) > 0 ){
                                    while($frow1 = mysqli_fetch_assoc($fres1)) {
                                        $fid = $frow1['id'];
                                        $fn = $frow1['fname'];
                                        $fl = $frow1['lname'];
                                        $fct = $frow1['city'];
                                        $fcn = $frow1['country'];
                                        $fimg = $frow1['Dpic'];
                                    }
                                }
                          } ?>  
                 
                <div class="candidate">
                    <span class="candidate__badge "><form action="<?php $_SERVER['php_self']; ?>" method="post">
                    <button class="btn btn-success" data-toggle="tooltip" title="Click to unfriend" style="transition:1s;" name="friends" value="<?php echo $fid; ?>">Friends <span class='glyphicon glyphicon-ok'></span></button>    
                    </form></span>
                    
                    <div class="candidate__header clearfix ">
                  <img class="candidate__img" src="<?php echo $fimg; ?>">

                  <div class="candidate__details">
                    <h1 class="candidate__fullname"><b><a style="text-decoration:none; color:black;" class="hvr-glow" href="visit.php?id=<?php echo $fid; ?>"><?php echo $fn . ' '.$fl; ?></a></b></h1>
                    <h2 class="candidate__location"><?php echo $fct .' ,'. $fcn;?></h2>
                  </div>
                  </div>

                </div>
                
                <?php
                               }
                    }else {
                        echo "<h3 style='color:gray'>You have No friends</h3>";
                    }
                    
                
                ?>      
               
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
    </div>
    </div>
       
    <ul class="pagination pagination-lg">
<?php 
        for ($page=1;$page<=$number_of_pages;$page++) {
              echo '<li><a href="friends.php?page=' . $page . '">' . $page . '</a></li>';
            }
    include('includes/footer.php');

?>
        </ul>
 <br><br><br>