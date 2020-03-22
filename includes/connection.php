 <?php 

 $server    = "localhost";
 $username  = "root";
 $password  = "root";
 $db        = "social";
    
 //Create connection 

$conn = mysqli_connect( $server, $username, $password, $db);

//Check Connection

if (!$conn) {
    die("Connection failed : " . mysqli_connect_error() );
}






 ?>




