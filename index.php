<?php

    session_start();    

    include('includes/functions.php');
    include('includes/connection.php');
    //Login BeSocial
    if (isset($_POST['login'])) {
        $formUser = validateFormData($_POST['email']);
        $formPass = validateFormData($_POST['password']);
        
       $query="SELECT id, fname, email, password FROM users WHERE email='$formUser'";
     
     //store the result
     
     $result = mysqli_query($conn,$query);
     
     //verify if result is returned
     
     if(mysqli_num_rows($result) > 0) {
         //store basic user data in variables
         
         while( $row = mysqli_fetch_assoc($result) ) {
             $id = $row['id'];
             $user = $row['fname'];
             $email = $row['email'];
             $hashedPass = $row['password'];
         }
         //verify hashed password with the typed password
         if( password_verify( $formPass, $hashedPass) ) {
             
             //correct login details!
             //start the session
            //store data in SESSION variables
             $_SESSION['loggedInId'] = $id;
             $_SESSION['loggedInUser'] = $user;
             $_SESSION['loggedInEmail'] = $email;
             
            header("Location: profile.php");
         } else {  //hashed password didn't verify
             $loginError = "<div class='alert alert-danger'>Wrong username / password combination. Try again.<a class='close' data-dismiss='alert'>&times;</a></div>";
         }
         
     } else {
         
         $loginError = "<div class='alert alert-danger'> No such user in database. Please try again.<a class='close' data-dismiss='alert'>&times;</a> </div>";
     }
    //close the mysql connection
     mysqli_close($conn);
    }
    //Sign Up into BeSocial
    
    if (isset($_POST['create'])) {
        $fname = $lname = $email = $password = $cpassword = $dob = $address = $city = 
        $state = $pcode = $country = "";  
        
               
        //Get Data
        
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
        }else {
            $check = "SELECT * FROM users WHERE email = '$email'";
            $res = mysqli_query($conn, $check);
            if (mysqli_num_rows($res) > 0){
                $sError = "<div class='alert alert-danger'>This Email is already in use!!<a class='close' data-dismiss='alert'>&times;</a></div> <br>";
            }else{
                $email = validateFormData($_POST['useremail']);
            }
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
        $image   = "images/cover.jpg";
        $cover   = "images/edit.jpg";
        
        if ( $fname && $lname && $email && $password ) {
            
            $query = "INSERT INTO users (id, fname, lname, email, password, dob, address, city, state, pcode, country, Dpic ,cover) VALUES (NULL,'$fname', '$lname', '$email', '$password','$dob', '$address', '$city', '$state', '$pcode', '$country', '$image','$cover')";

            //$q1 = "INSERT INTO `social`.`users` (`id`, `fname`, `lname`, `email`, `password`, `DOB`, `Address`, `City`, `State`, `Postal Code`, `Country`) VALUES (NULL, 'Brad', 'Hussey', 'brad@gmail.com', '123', '111', 'A block johar town', 'Lahore', 'Punjab', '5432', 'Pakistan');"


            $sql_query = mysqli_query($conn, $query);
            if (!$sql_query) {
                $success = "<div class='alert alert-danger'>Query Not Working!<a class='close' data-dismiss='alert'>&times;</a></div> <br>";
            }else {
                 $success = "<div class='alert alert-success'>New Account has been created!<a class='close' data-dismiss='alert'>&times;</a></div> <br>";
            }
        }
    mysqli_close($conn);
    }
include ('includes/header.php');
?>

<script src="js/jquery.vide.min.js"></script>
	<!-- main -->
	<div data-vide-bg="video/Ipad2">
		<div class="center-container">
			<!--header-->
            <div class="notification-bar"><?php echo $loginError; echo $sError; echo $success; ?></div>
               
			<div class="header-w3l">
				<h1 style="font-family:impact;">Be<span class="glyphicon glyphicon-heart"></span>Social</h1>
			</div>
			<!--//header-->
			<div class="main-content-agile">
				<div class="sub-main-w3">	
					<div class="wthree-pro">
						<h2 style="font-family:courier;">Login Here</h2>
					</div>
					<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
						<input placeholder="E-mail" name="email" class="email" type="email" required=""> 
						<span class="icon1" ><i class="fa fa-user" aria-hidden="true"></i></span><br><br>
						<input  placeholder="Password" name="password" class="pass" type="password" required="">
						<span class="icon2"><i class="fa fa-unlock" aria-hidden="true"></i></span><br>
						<div class="sub-w3l">
                            <h6><a href="" data-toggle="modal" data-target="#myModal">Create Account?</a></h6>
							<div class="right-w3l">
								<input name="login" type="submit" value="Login">
							</div>
						</div>
					</form>
				</div>
			</div>
			<!--//main-->
            <!--Modal Sign Up-->
            <div class="modal fade" id="myModal" role="dialog" >
            <div class="modal-dialog" > 
                
              <!-- Modal content-->
              <div class="modal-content" style="background:rgba(0,0,0,0.8);">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h2 style="font-family:impact; color:white;" class="modal-title">Be<span class="glyphicon glyphicon-heart"></span>Social</h2>
                </div>
                <div class="modal-body" style="color:white;">
                  <form class="row" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
            <?php echo $nameError; 
            ?>
            <div class="form-group col-sm-6" >
                <label for="user-fname">First Name * </label>
                <input style="background:transparent;color:wheat;" type="text" class="form-control input-lg" id="user-fname" name="userfname">
            </div>
            <div class="form-group col-sm-6" >
                <label for="user-lname">Last Name * </label>
                <input style="background:transparent;color:wheat;" type="text" class="form-control input-lg" id="user-lname" name="userlname">
            </div>          
             <div class="form-group col-sm-6" >
                <label for="user-email">Email *</label>
                <input style="background:transparent;color:wheat;" type="text" class="form-control input-lg" id="user-email" name="useremail">
            </div>
             <div class="form-group col-sm-6" >
                <label for="user-password">Password *</label>
                <input style="background:transparent;color:wheat;" type="password" class="form-control input-lg" id="user-password" name="userpassword">
            </div>
             <div class="form-group col-sm-6" >
                <label for="user-cpassword">Confirm Password *</label>
                <input style="background:transparent;color:wheat;" type="password" class="form-control input-lg" id="user-cpassword" name="usercpassword">
            </div>       
             <div class="form-group col-sm-6" >
                <label for="user-dob">Date of Birth</label>
                <input style="background:transparent;color:wheat;" type="date" class="form-control input-lg" id="user-dob" name="userdob">
            </div>          
             <div class="form-group col-sm-6" >
                <label for="user-address">Address</label>
                <input style="background:transparent;color:wheat;" type="text" class="form-control input-lg" id="user-address" name="useraddress">
            </div>          
             <div class="form-group col-sm-6" >
                <label for="user-city">City</label>
                 <input style="background:transparent;color:wheat;" type="text" class="form-control input-lg" id="user-city" name="usercity">
            </div>
             <div class="form-group col-sm-6" >
                <label for="user-state">State</label>
                 <input style="background:transparent;color:wheat;" type="text" class="form-control input-lg" id="user-state" name="userstate">
            </div>
             <div class="form-group col-sm-6" >
                <label for="p-code">Postal Code</label>
                 <input style="background:transparent;color:wheat;" type="text" class="form-control input-lg" id="p-code" name="pcode">
            </div>       
            <div class="form-group col-sm-6" >
                 <label >Country</label>
                <select style="background:transparent;" name="usercountry" class="form-control " >
                    <option>US</option>
                    <option>PAKISTAN</option>
                    <option>INDIA</option>
                    <option>UK</option>
                    <option>ITALI</option>
                    <option>SPAIN</option>
                    <option>NETHERLAND</option>
                    <option>CHINA</option>
                 </select>
            </div>                
            <div class="form-group col-sm-6">
            <button style="transition:0.5s; font-family: 'Oleo Script';border-radius:0;" type="submit" class="btn btn-primary btn-lg btn-success " name="create">Create Account</button>
            </div>
        </form>

                </div>
                <div class="modal-footer">
                 
                </div>
              </div>

            </div>
  </div>

            
            <!--//Modal Sign Up-->
			<!--footer-->
			<div class="footer">
                <img src="images/logo.png">
				<p>Code with <span class="glyphicon glyphicon-heart"></span> by <b>Mujeeb Arshad</b></p>
			</div>
			<!--//footer-->
		</div>
	</div>

<?php

include ('includes/footer.php');

?>