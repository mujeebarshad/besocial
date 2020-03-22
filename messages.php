<?php 
    session_start();
     if (!$_SESSION['loggedInEmail']){
        header("Location: index.php");
    }
    include('includes/connection.php');
    include('includes/functions.php');
    include('includes/header.php');
    
     $id = $_SESSION['loggedInId'];

    //User info 
     $img4 = "";
     $qimg1 = "SELECT * FROM users WHERE id = $id";
     $imgres1 = mysqli_query($conn,$qimg1);
     if (mysqli_num_rows($imgres1) > 0){
         while ($imgrow1 = mysqli_fetch_assoc($imgres1)){
             $img4 = $imgrow1['Dpic'];
         }
     }
    //Sending Message
   
    
    if (isset($_POST['submit'])){
        $id1 = $_GET['fsubmit'];
        if ($_POST['msgbox'] == ""){
             $error = "<div class='alert alert-danger'>Message is empty!<a class='close' data-dismiss='alert'>&times;</a></div>";
        }else {
           $msg = $_POST['msgbox'];
            
            $query = "INSERT INTO messages(toid,fromid,time,msg) VALUES ('$id1','$id',CURRENT_TIMESTAMP,'$msg')";
            $result = mysqli_query($conn,$query);
            
        }
        
        
    }
    //Messsage List
    
    $lquery = "SELECT DISTINCT userid1,userid2 FROM friends f INNER JOIN messages m WHERE ( (userid1 = $id AND userid1 = toid) OR (userid2 = $id AND userid2 = toid) OR (userid1 = $id AND userid1 = fromid) OR (userid2 = $id AND userid2 = fromid)) AND status = 2";
    $lres = mysqli_query($conn,$lquery);
    if (!$lres) {
        $error = "<div class='alert alert-danger'>List Query Error!<a class='close' data-dismiss='alert'>&times;</a></div>".mysqli_error();
    }
    
?> 
<br><br><br><br>
   <script src="https://use.fontawesome.com/45e03a14ce.js"></script>
<div class="main_section">
   <div class="container" style="font-family:Audiowide ;background:white;">
       <h2 style="font-family:impact">MessageZone</h2>
    <br>
      <div class="chat_container">
         <div class="col-sm-3 chat_sidebar">
    	 <div class="row">
            <div id="custom-search-input">
               <div class="input-group col-md-12">
                  <input type="text" class="  search-query form-control" placeholder="Conversation" />
                  <button class="btn btn-danger" type="button">
                  <span class=" glyphicon glyphicon-search"></span>
                  </button>
               </div>
            </div>
            <div class="dropdown all_conversation">
               <button class="dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <i class="fa fa-weixin" aria-hidden="true"></i>
               All Conversations
               <span class="caret pull-right"></span>
               </button>
               <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                  <li><a href="#"> All Conversation </a>  <ul class="sub_menu_ list-unstyled">
                  <li><a href="#"> All Conversation </a> </li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li><a href="#">Separated link</a></li>
               </ul>
			   </li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li><a href="#">Separated link</a></li>
               </ul>
            </div>
            <div class="member_list">
               <ul class="list-unstyled">
                   <?php 

                    if (mysqli_num_rows($lres) > 0) {
                        while($lrow = mysqli_fetch_assoc($lres)){
                            if ($lrow['userid1'] == $id){
                                $id1 = $lrow['userid2'];
                            }else {
                                    $id1 = $lrow['userid1'];
                                }
                                $q1 = "SELECT * FROM users WHERE id = $id1";
                                $res1 = mysqli_query($conn,$q1);
                                if (mysqli_num_rows($res1) > 0){
                                    while($row1 = mysqli_fetch_assoc($res1)) {
                                        $fname=$row1['fname'];
                                        $lname=$row1['lname'];
                                        $img1 = $row1['Dpic'];
                                        
                                        ?>
                           <li class="left clearfix">
                               <form action="<?php $_SERVER['php_self']; ?>" method="get">
                               <a style="text-decoration:none;color:black;">
                             <span class="chat-img pull-left">
                             <img src="<?php echo $img1; ?>" class="img-circle">
                             </span>
                             <div class="chat-body clearfix">
                                <div class="header_sec">
                                   <strong class="primary-font"><?php echo $fname." ".$lname; ?></strong>
                                </div>
                                <div class="contact_sec">
                                <button type="submit" name="fsubmit" value="<?php echo $row1['id']; ?>" class="btn btn-default" style="transition:1s;"><span class="badge">Click to show messages</span></button>
                                </div>
                             </div>
                                   </a>
                                   </form>
                          </li>
                   
                   <?php                 
                                }
                            }
                        }
                    }
                   
                   ?>
                  
               </ul>
            </div></div>
         </div>
         <!--chat_sidebar-->
		 
		 
         <div class="col-sm-9 message_section">
		 <div class="row">
		 <div class="new_message_head">
		 <div class="pull-left"><button><i class="fa fa-plus-square-o" aria-hidden="true"></i> New Message</button></div><div class="pull-right"><div class="dropdown">
  <button class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fa fa-cogs" aria-hidden="true"></i>  Setting
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
    <li><a href="#">Action</a></li>
    <li><a href="#">Profile</a></li>
    <li><a href="#">Logout</a></li>
  </ul>
</div></div>
		 </div><!--new_message_head-->
		 
		 <div class="chat_area">
             
		 <ul class="list-unstyled">
             <?php
             
             //Display Message
             
             if (isset($_GET['fsubmit'])) {
                 
                 $id1 = $_GET['fsubmit'];
                 $dquery = "SELECT * FROM messages WHERE (toid=$id1 AND fromid=$id) OR (fromid=$id1 AND toid=$id)";
                 $dres = mysqli_query($conn,$dquery);
                 if (mysqli_num_rows($dres) > 0){
                     while($drow = mysqli_fetch_assoc($dres)) {
                         $msg = $drow['msg'];
                         $time = $drow['time'];
                         if ($drow['toid'] == $id) {
                             $id2 = $drow['fromid'];
                             $qimg = "SELECT * FROM users WHERE id = $id2";
                             $imgres = mysqli_query($conn,$qimg);
                             if (mysqli_num_rows($imgres) > 0){
                                 while ($imgrow = mysqli_fetch_assoc($imgres)){
                                     $img12 = $imgrow['Dpic'];
                                 }
                             }
                             
                             ?>
		 <li class="left clearfix">
                     <span class="chat-img1 pull-left">
                     <img src="<?php echo $img12; ?>" alt="User Avatar" class="img-circle">
                     </span>
                     <div class="chat-body1 clearfix">
                        <p><?php echo $msg; ?></p>
						<div class="chat_time pull-right"><b><?php echo $time; ?></b></div>
                     </div>
                  </li>
             <?php }else { ?>
        <li class="left clearfix admin_chat">
                     <span class="chat-img1 pull-right">
                     <img src="<?php echo $img4; ?>" alt="User Avatar" class="img-circle">
                     </span>
                     <div class="chat-body1 clearfix">
                        <p style="background:#86f442;"><?php echo $msg; ?></p>
    					<div class="chat_time pull-left"><b><?php echo $time; ?></b></div>
                     </div>
                  </li>
             <?php 
                             }
                         }
                     }
                 }
             
             
             ?>
             
		 </ul>
		 </div><!--chat_area-->
          <div class="message_write">
        <form action="<?php $_SERVER['php_self']; ?>" method="post">
             <textarea id="msgbox" name="msgbox" class="form-control" placeholder="type a message..."></textarea>
             <div class="clearfix"></div>
             <div class="chat_bottom"><a href="#" class="pull-left upload_btn"><i class="fa fa-cloud-upload" aria-hidden="true"></i>
             Add Files</a>
             <button style="transition:1s;" name="submit" type="submit" class="pull-right btn btn-success">
             Send</button></div>
         </form>
		 </div>
		 </div>
         </div> <!--message_section-->
      </div>
   </div>
</div>
<br>

<?php 
    
    include('includes/footer.php');

?>