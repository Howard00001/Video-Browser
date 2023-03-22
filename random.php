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
    <a href="index.php"  class="w3-bar-item w3-button w3-padding barbutton"><i class="fa fa-home fa-fw w3-margin-right"></i>Home</a> 
    <a href="vidmain1.php?shuffle=TRUE" class="w3-bar-item w3-button w3-padding barbutton"><i class="fa fa-th-large fa-fw w3-margin-right"></i>Video List</a> 
    <a href="random.php" class="w3-bar-item w3-button w3-padding w3-text-teal barbutton"><i class="fa fa-user-secret fa-fw w3-margin-right"></i>Random Selector</a>
  </div>
</nav>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<?php include 'mygenerate.php';?>
<?php
  session_start();
  $infolist = $_SESSION['infolist'];
  $infolist2 = $_SESSION['infolist2'];
  $alltags = $_SESSION['alltags'];
  $allauthers = $_SESSION['allauthers'];
?>
<?php include 'myvar.php'?>
<?php
  $randnum = rand(1,count($infolist2));
?>

<div class="w3-main" style="margin-left:300px">
  <div style="position:fixed; right:5px; top:5px; width:60px;">
    <a href="vidmain1.php?shuffle=TRUE"><img src="pic/figure.jpg" style="float:right; width:60px"></a>
  </div>

  <!-- Header -->
  <header id="portfolio">
    <span class="w3-button w3-hide-large w3-xxlarge w3-hover-text-grey" onclick="w3_open()"><i class="fa fa-bars"></i></span>
    <div class="w3-container">
    <h1><b>Video List</b></h1>
    <div class="w3-section w3-bottombar w3-padding-16">
      <button class="collapsible"><h5>Filter Tags</h5></button>
      <div class="collapsecontent">
        <div>
          <button class="w3-button w3-black tagbutton" id="ALL">ALL</button>
          <?php foreach($alltags as $tag){ ?>
            <button class="w3-button w3-white tagbutton" id="<?php echo $tag; ?>"><?php echo $tag; ?></button>
          <?php } ?>
        </div>
        <div>
          <button class="w3-button w3-black autherbutton" id="ALL">ALL</button>
          <?php foreach($allauthers as $auther){ ?>
            <button class="w3-button w3-white autherbutton" id="<?php echo $auther; ?>"><?php echo $auther; ?></button>
          <?php } ?>
        </div>
      </div>       
    </div>
    </div>
  </header>
  
  <div>
    <a href="<?php echo 'playvid.php?vidnum='.$randnum; ?>"><img src="move/move1.jpg" class="playgif center"></a>
  </div>
</div>

<script> 
  $(document).ready(function() {
    $(".tagbutton").each(function(){
      var tag = "<?php echo $newtag; ?>";
      if($(this).text() == tag){
          $(this).removeClass('w3-white');
          $(this).addClass('w3-black');
      } else {
          $(this).removeClass('w3-black');
          $(this).addClass('w3-white');
      }
    });
    $(".autherbutton").each(function(){
      var auther = "<?php echo $newauther; ?>";
      if($(this).text() == auther){
          $(this).removeClass('w3-white');
          $(this).addClass('w3-black');
      } else {
          $(this).removeClass('w3-black');
          $(this).addClass('w3-white');
      }
    });
    $(".pagebutton").each(function(){
      var page = "<?php echo $currentpage; ?>"
      if($(this).text() == page){
        $(this).removeClass('w3-hover-black');
        $(this).addClass('w3-black');
      } else {
        $(this).removeClass('w3-black');
        $(this).addClass('w3-hover-black');
      }
    });
    $(".jumphead").click(function(){
        var site = window.location.href.split("?")[0];
        location.href = site + "?currentpage=1";
    })

    $(".jumptail").click(function(){
        var site = window.location.href.split("?")[0];
        location.href = site + "?currentpage=<?php echo $totalpages; ?>";
    })
  });
</script>

</body>
</html>