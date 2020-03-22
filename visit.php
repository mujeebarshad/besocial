<?php
    session_start();
    if (!$_SESSION['loggedInEmail']){
        header("Location: index.php");
    }
    
    include('includes/connection.php');
    include('includes/functions.php');
    include('includes/header.php');

    $id = $_GET['id'];
    //User Info 
    $q1 = "SELECT * FROM users WHERE id='$id'";
    $r1 = mysqli_query( $conn, $q1 );
    
    if (mysqli_num_rows($r1) > 0){
        while ($q_row = mysqli_fetch_assoc($r1)) {
            $fid = $q_row['id'];
            $fname = $q_row['fname'];
            $lname = $q_row['lname'];
            $dob = $q_row['dob'];
            $city = $q_row['city'];
            $email = $q_row['email'];
            $img = $q_row['Dpic'];
            $img1 = $q_row['cover'];
        }
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
          <div class="profile-image"><img src="<?php echo $img; ?>"  /></div>
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
                  <li class='menu-sub-nav current-item'><a href='visit.php?id=<?php echo $id ;?>'><i class='fa fa-home'></i><span>Timeline</span></a></li>
                  <li class='menu-sub-nav'><a href='messages.php'><i class='fa fa-user'></i><span>Messages</span></a></li>
                  <li class='menu-sub-nav' data-toggle="tooltip" title="Nothing To Show"><a href='visit.php?id=<?php echo $id ;?>'><i class='fa fa-fw fa-users'></i><span>Friends</span></a></li>
                  <li class='menu-sub-nav'><a href='#'><i class='glyphicon glyphicon-picture'></i><span>Photos</span></a></li>
                </ul>
              </div>
              
            </div>    
            
                    <div class="col-sm-12">
            
             <?php 
            
            $show = "SELECT * FROM posts WHERE userid=$fid ORDER BY time DESC";
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
                   

                </div>
            
        <?php    
                }
            } 
        
            ?>
            
        </div>

            
        </div>
        
    </div>   
        
    <br><br><br>
</div>

<?php

    include('includes/footer.php');

?>
