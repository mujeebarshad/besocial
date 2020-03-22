<?php 
    session_start();

     if ( !$_SESSION['loggedInUser'] ) {
        //send them to log in page i.e index.php
        header("Location: index.php");
    }
    include('includes/header.php');
    include('includes/functions.php');
    include('includes/connection.php');

    $id = $_SESSION['loggedInId'];
   
    $query = "SELECT * FROM users WHERE id = '$id'";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        
        while( $rows = mysqli_fetch_assoc($result) ){
            
            $fname        = $rows['fname'];
            $lname        = $rows['lname'];
            $email        = $rows['email'];
            $dob          = $rows['dob'];
            $address      = $rows['address'];
            $city         = $rows['city'];
            $state        = $rows['state'];
            $pcode        = $rows['pcode'];
            $country      = $rows['country'];
            $path         = $rows['Dpic'];
            $path1         = $rows['cover'];
        }
    }else {
    
    $alertMessage = "<div class = 'alert alert-danger'> Nothing to see here!<a class='close' data-dismiss='alert'>&times;</a></div>";
}

if (isset($_POST['update'])) {
    
    $fname = $lname = $email = $password = $cpassword = $dob = $address = $city = 
        $state = $pcode = $country = "";  
        
        //DP
        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
        
        //Cover Pic
        
        $target_dir1 = "images/";
        $target_file1 = $target_dir . basename($_FILES["fileToUpload1"]["name"]);
        $uploadOk1 = 1;
        $imageFileType1 = pathinfo($target_file1,PATHINFO_EXTENSION);
    
        move_uploaded_file($_FILES["fileToUpload1"]["tmp_name"], $target_file1);
    
        //Get data
        if (!$_POST['userfname']) {
            $sError = "<div class='alert alert-danger'>Please enter your first name<a class='close' data-dismiss='alert'>&times;</a></div> <br>";
        }else {
            $fname = validateFormData($_POST['userfname']);
        }
        if (!$_POST['userlname']) {
            $sError = "<div class='alert alert-danger'>Please enter your last name<a class='close' data-dismiss='alert'>&times;</a></div> <br>";
        }else {
            $lname = validateFormData($_POST['userlname']);
        }
        if (!$_POST['useremail']) {
            $sError = "<div class='alert alert-danger'>Please enter your email<a class='close' data-dismiss='alert'>&times;</a></div> <br>";
        }else{
                $email = validateFormData($_POST['useremail']);
            }
        if (!$_POST['userpassword']) {
            $sError = "<div class='alert alert-danger'>Please enter password<a class='close' data-dismiss='alert'>&times;</a></div> <br>";
        }        
        if (!$_POST['usercpassword']) {
            $sError = "<div class='alert alert-danger'>Please confirm your password<a class='close' data-dismiss='alert'>&times;</a></div> <br>";
        }
        if ($_POST['userpassword'] != $_POST['usercpassword']) {
            $sError = "<div class='alert alert-danger'>Password does not match!<a class='close' data-dismiss='alert'>&times;</a></div> <br>";
        }else {
            $password = password_hash( $_POST['userpassword'], PASSWORD_DEFAULT);
        }
        
        $dob     = validateFormData($_POST['userdob']);
        $address = validateFormData($_POST['useraddress']);
        $city    = validateFormData($_POST['usercity']);
        $state   = validateFormData($_POST['userstate']);
        $pcode   = validateFormData($_POST['pcode']);
        $country = validateFormData($_POST['usercountry']);
        $img =  $target_file;
        $img1 = $target_file1;
        
    if ($fname && $lname && $email && $password ) {
         $query1 = "UPDATE users
                  SET fname = '$fname',
                  lname = '$lname',
                  email = '$email',
                  password = '$password',
                  dob = '$dob',
                  address = '$address',
                  city = '$city',
                  state = '$state',
                  pcode = '$pcode',
                  country = '$country',
                  Dpic = '$img',
                  cover= '$img1'
                  WHERE id = '$id'";
        $result1 = mysqli_query( $conn, $query1 );
         if (!$result1) {
                    $success = "<div class='alert alert-danger'>This Email is already in use!<a class='close' data-dismiss='alert'>&times;</a></div> <br>";
                }else if (!$sError) {
                     $success = "<div class='alert alert-success'>Account has been updated!<a class='close' data-dismiss='alert'>&times;</a></div> <br>";
                }
    }
}

    

?>


<br><br><br><br><br>
<div class='alert alert-warning'>Upload Pictures Twice<a class='close' data-dismiss='alert'>&times;</a></div> <br>
  <div class="notification-bar"><?php echo $sError; echo $success; ?></div>
<h1>Update Your Profile</h1>
<div class="container">
    <form class="row" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data">
            <?php echo $nameError; 
            ?>
            <div class="form-group col-sm-6" >
                <label for="user-fname">First Name * </label>
                <input type="text" class="form-control input-lg" id="user-fname" name="userfname" value="<?php echo $fname; ?>">
            </div>
            <div class="form-group col-sm-6" >
                <label for="user-lname">Last Name * </label>
                <input  type="text" class="form-control input-lg" id="user-lname" name="userlname" value="<?php echo $lname; ?>">
            </div>          
             <div class="form-group col-sm-6" >
                <label for="user-email">Email *</label>
                <input  type="text" class="form-control input-lg" id="user-email" name="useremail" value="<?php echo $email; ?>">
            </div>
             <div class="form-group col-sm-6" >
                <label for="user-password">Password *</label>
                <input  type="password" class="form-control input-lg" id="user-password" name="userpassword">
            </div>
             <div class="form-group col-sm-6" >
                <label for="user-cpassword">Confirm Password *</label>
                <input  type="password" class="form-control input-lg" id="user-cpassword" name="usercpassword">
            </div>       
             <div class="form-group col-sm-6" >
                <label for="user-dob">Date of Birth</label>
                <input  type="date" class="form-control input-lg" id="user-dob" name="userdob" value="<?php echo $dob; ?>">
            </div>          
             <div class="form-group col-sm-6" >
                <label for="user-address">Address</label>
                <input  type="text" class="form-control input-lg" id="user-address" name="useraddress" value="<?php echo $address; ?>">
            </div>          
             <div class="form-group col-sm-6" >
                <label for="user-city">City</label>
                 <input  type="text" class="form-control input-lg" id="user-city" name="usercity" value="<?php echo $city; ?>">
            </div>
             <div class="form-group col-sm-6" >
                <label for="user-state">State</label>
                 <input  type="text" class="form-control input-lg" id="user-state" name="userstate" value="<?php echo $state; ?>">
            </div>
             <div class="form-group col-sm-6" >
                <label for="p-code">Postal Code</label>
                 <input  type="text" class="form-control input-lg" id="p-code" name="pcode" value="<?php echo $pcode; ?>">
            </div>
              <div class="form-group col-sm-6" >
                 <label >Country</label>
                <select name="usercountry" class="form-control " selected="<?php echo $country; ?>" >
                    <option>US</option>
                    <option selected>PAKISTAN</option>
                    <option>INDIA</option>
                    <option>UK</option>
                    <option>ITALI</option>
                    <option>SPAIN</option>
                    <option>NETHERLAND</option>
                    <option>CHINA</option>
                 </select>
            </div>  
            <div class="form-group col-sm-6" >
                <label for="p-code">Display Picture (Path)</label>
                 <input type="file" name="fileToUpload" id="fileToUpload" selected="<?php echo $path; ?>">
            </div>
             <div class="form-group col-sm-6" >
                <label for="p-code">Cover Picture (Path)</label>
                  <input type="file" name="fileToUpload1" id="fileToUpload1" value="<?php echo $path1; ?>">
            </div> 
           
            <div class="form-group col-sm-6">
            <button style="transition:0.5s; font-family: 'Oleo Script';border-radius:0;" type="submit" class="btn btn-primary btn-lg btn-success " name="update">Update</button>
            </div>
        </form>
</div>
<?php 

    include('includes/footer.php');
?>