<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>BeSocial</title>
      <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="generator" content="Codeply">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />   
    
    <link href="hover/css/hover.css" rel="stylesheet">
      
    <link href="https://netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
    
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
function hideURLbar(){ window.scrollTo(0,1); 
}
</script>
<!-- Meta tag Keywords -->

<!-- css files -->
<link rel="stylesheet" href="css/style1.css" type="text/css" media="all" /> <!-- Style-CSS --> 
<link rel="stylesheet" href="css/font-awesome.css"> <!-- Font-Awesome-Icons-CSS -->
<!-- //css files -->
<!-- js -->
<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="js/script1.js"></script>
<!-- //js -->

<!-- online-fonts -->

    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Oleo+Script:400,700&amp;subset=latin-ext" rel="stylesheet">
        
</head>

<body style="background:url('images/b1.jpg');">
     <?php if ($_SESSION['loggedInEmail']){ ?>
     <nav class="navbar navbar-default navbar-fixed-top" >
      
          <div class="container-fluid">
          
              <div class="navbar-header">
                  <button type="button"  class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                        <span class="sr-only">Toggle navigation</span> 
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand hvr-glow" href="profile.php" style="font-size:150%;color:white;"><b>Be<span class="glyphicon glyphicon-heart"></span>Social</b></a>
              </div>
                
              <div class="collapse navbar-collapse" id="navbar-collapse">
              
                   <form method="get" action="search.php" id="searchbox5" class="navbar-left">
                        <input id="search52" name="search" type="text" size="40" placeholder="Search..." />
                    </form>
                  <ul class="nav navbar-nav navbar-right">
                      <li class="active hvr-float-shadow" ><a href="profile.php" style="background-color:transparent; color:white;">Profile</a></li>
                      <li class="hvr-float-shadow"><a href="profile.php" style="background-color:transparent;color:white;">Home</a></li>
                      <li class="dropdown">
                            <a href="#" class="dropdown-toggle hvr-float-shadow" data-toggle="dropdown" role="button" style="background-color:transparent;color:white;">Account info<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                <li class="hvr-float-shadow"><a href="edit.php"> Edit Profile</a></li>
                                <li class="hvr-float-shadow"><a href="logout.php"> Log Out</a></li>    
                          </ul>
                          
                      </li>
                  
                  </ul>
              </div>
          </div>
      
      </nav>
    
    <?php }  ?>
    
        