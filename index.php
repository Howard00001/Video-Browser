<!DOCTYPE html>
<html>
<head>
<title>Video Browser</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">
<link rel="stylesheet" href="font.css">
<link rel="stylesheet" href="mycss.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="myjs.js"></script>
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Raleway", sans-serif}
</style>
</head>
<body class="w3-light-grey w3-content" style="max-width:1600px">

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
  <div class="w3-container">
    <a href="#" onclick="w3_close()" class="w3-hide-large w3-right w3-jumbo w3-padding w3-hover-grey" title="close menu">
      <i class="fa fa-remove"></i>
    </a>
    <img src="pic/figure2.jpg" style="width:100px;" class="w3-round"><br><br>
    <h4><b>FUNCTION</b></h4>
  </div>
  <div class="w3-bar-block">
    <a href="index.php" class="w3-bar-item w3-button w3-padding w3-text-teal barbutton"><i class="fa fa-home fa-fw w3-margin-right"></i>Home</a> 
    <a href="vidmain1.php?shuffle=TRUE" class="w3-bar-item w3-button w3-padding barbutton"><i class="fa fa-th-large fa-fw w3-margin-right"></i>Video List</a> 
    <!-- <a href="autherlist1.php" class="w3-bar-item w3-button w3-padding  barbutton"><i class="fa fa-vcard-o fa-fw w3-margin-right"></i>auther List</a>  -->
    <a href="random.php" class="w3-bar-item w3-button w3-padding barbutton"><i class="fa fa-user-secret fa-fw w3-margin-right"></i>Random Selector</a>
  </div>
</nav>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<?php include 'mygenerate.php';?>
<?php
  initialize_treasurebox();
  session_start();
  $files = getfiles("./vid", "mp4");
  $infolist = array();
  foreach($files as $filepath){
      $x = new treasure($filepath);
      // $x->showinfo();
      array_push($infolist, $x);
  }
  $alltags = gettags();
  $allauthers = getauthers();
  $_SESSION['infolist'] = $infolist;
  $_SESSION['infolist2'] = $infolist;
  $_SESSION['alltags'] = $alltags;
  $_SESSION['allauthers'] = $allauthers;
?>

<div class="w3-main" style="margin-left:300px">

  <!-- Header -->
  <header id="portfolio">
    <span class="w3-button w3-hide-large w3-xxlarge w3-hover-text-grey" onclick="w3_open()"><i class="fa fa-bars"></i></span>
    <div class="w3-container">
    <h1><b>Welcome</b></h1>
    </div>
  </header>

  <div>
    <a href="vidmain1.php?shuffle=TRUE">
    <img src="move/move.jpg" class="playgif" style="width:100%">
    </a>
  </div>
  
<!-- End page content -->
</div>
</body>
</html>