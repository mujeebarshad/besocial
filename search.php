<?php 
    session_start();
    
    include('includes/connection.php');
    include('includes/functions.php');
    include('includes/header.php');

    //Add Friend 
    if (isset($_POST['req'])) {
       
        $user1 = $_SESSION['loggedInId'];
        $user2 = $_POST['req'];
        
         //Check for existing table
        $ch_query = "SELECT * FROM friends WHERE (userid1 = $user1 OR userid2 = $user1) AND (userid1 = $user2 OR userid2 = $user2)";
        $ch_res = mysqli_query($conn, $ch_query);
        if ( mysqli_num_rows($ch_res) <= 0) {

            $req_query = "INSERT INTO friends (userid1, userid2, status, dateOfFs) VALUES ($user1, $user2, 1, CURRENT_TIMESTAMP)";

            $res = mysqli_query($conn , $req_query);
            if (!res) {
              echo  "<div class='alert alert-alert'>No result found<a class='close' data-dismiss='alert'>&times;</a></div> <br>";
            }
        }else {
            // Unfriend and Cancel request
             $bquery = "DELETE FROM friends
                  WHERE userid1 = '$user1'
                  AND userid2 = '$user2'";
        $bres = mysqli_query($conn, $bquery);
        }
    }

    //search  
    if (isset($_GET['search'])) {
        if ($_GET['search'] != "" ){
            $user1 = $_SESSION['loggedInId'];

            $extract = $_GET['search'];

            $query = "SELECT id, fname, lname, city ,country,Dpic FROM users WHERE fname = '$extract' OR lname = '$extract' OR CONCAT( fname,  ' ', lname ) LIKE  '%$extract%'";
            $result = mysqli_query( $conn, $query );
            if(!$result){
                $error =  "<div class='alert alert-alert'>No result found<a class='close' data-dismiss='alert'>&times;</a></div> <br>";
            } 
        }
       
?>
        
<br><br><br><br><br>
    <div class="container">
        <h1> Showing Results For <span style="font-family:Alex Brush;">'<?php echo $_GET['search'] ;?>'</span></h1>
        <div class="list-group"> 
            <?php
        
            
        if (mysqli_num_rows($result) > 0 ) { 
            while( $row = mysqli_fetch_assoc($result)) { 
                if ($row['id'] != $_SESSION['loggedInId']) {
                    
            ?>
               <div class="candidate">
                  <span class="candidate__badge "><form action="<?php $_SERVER['php_self']; ?>" method="post">
                      <button class="btn btn-warning" style="transition:1s;"  name="req" value="<?php echo $row['id']; ?>" data-toggle="tooltip" title="Add/Remove Connection">
                     <?php 
                     // Get Status
                      $user2 = $row['id'];
                      $st_query = "SELECT status FROM friends WHERE userid1 = $user1 AND userid2 = $user2";
                      $st_res = mysqli_query($conn, $st_query);
                      if (!$st_res){
                          echo "<div class='alert alert-alert'>No result found<a class='close' data-dismiss='alert'>&times;</a></div> <br>";
                      }
                        if (mysqli_num_rows($st_res) > 0 ){
                            
                            while($st_row = mysqli_fetch_assoc($st_res)){ 
                                   if ($st_row['status'] == 1){
                                        echo "Friend Request Sent";
                                    }else {
                                        echo "Friends <span class='glyphicon glyphicon-ok'></span>";
                                    }
                                       
                             }
                        } else {
                            
                            $p_query = "SELECT status FROM friends WHERE userid1 = $user2 AND userid2 = $user1";
                            $p_res = mysqli_query($conn, $p_query);
                            if (!$p_res){
                                 echo "<div class='alert alert-alert'>No result found<a class='close' data-dismiss='alert'>&times;</a></div> <br>";
                            }
                            if (mysqli_num_rows($p_res) > 0) {
                                
                                while ($p_row = mysqli_fetch_assoc($p_res)) {
                                    if ($p_row['status'] == 1){
                                        echo "Pending Request";
                                    }else {
                                        echo "Friends <span class='glyphicon glyphicon-ok'></span>";
                                    }
                                }
                            }else {
                                echo "<span class='glyphicon glyphicon-plus'>Add-Friend</span>";
                            }
                        }
                      ?>
                      </button></form></span>
                <div class="candidate__header clearfix ">
                  <img class="candidate__img" src="<?php echo $row['Dpic']; ?>">

                  <div class="candidate__details">
                    <h1 class="candidate__fullname"><b><?php echo $row['fname'] . ' '.$row['lname']; ?></b></h1>
                    <h2 class="candidate__location"><?php echo $row['city'].' ,'. $row['country'];?></h2>
                  </div>
                  </div>
            </div> 
    
           <?php }
        }
        }else {
            echo "<br><br>";
            echo "<h1 style='color:gray'>No Results Found!</h1>"; 
        }
        
    }
    mysqli_close();
            
                           
            ?>    
       </div>
        
             

        
    </div>

<?php 

    include('includes/footer.php');

?>