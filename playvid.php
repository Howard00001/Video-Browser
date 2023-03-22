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
    <a href="random.php" class="w3-bar-item w3-button w3-padding barbutton"><i class="fa fa-user-secret fa-fw w3-margin-right"></i>Random Selector</a>
  </div>
</nav>

<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<?php include 'mygenerate.php';?>
<?php
  session_start();
  $vidnum = $_GET['vidnum'];
  $toplay = $_SESSION['infolist2'][$vidnum];
?>

<div class="w3-main" style="margin-left:300px">
  <div style="position:fixed; right:5px; top:5px; width:60px;">
    <a href="vidmain1.php?shuffle=TRUE"><img src="pic/figure.jpg" style="float:right; width:60px"></a>
  </div>

  <!-- Overlay effect when opening sidebar on small screens -->
  <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>
  <header id="portfolio">
    <span class="w3-button w3-hide-large w3-xxlarge w3-hover-text-grey" onclick="w3_open()"><i class="fa fa-bars"></i></span>
    <div class="w3-container">
    <h1><b>Video List</b></h1>
    <div class="w3-section w3-bottombar w3-padding-16">
      <button class="collapsible"><h5>Video Info</h5></button>
      <div class="collapsecontent">
        <?php $toplay->showinfo();?>
      </div>
    </div>
    </div>
  </header>

  <div class="w3-row-padding">
    <video controls style="width:70%; position:relative; left:10px">
      <source src="<?php echo $toplay->route; ?>">
    </video>
    <div class="w3-section w3-lime w3-padding-16">
      <div class="w3-margin inforow">
        <b>rate</b>
        <span class="fa fa-star ratestar" id="star1"></span>
        <span class="fa fa-star ratestar" id="star2"></span>
        <span class="fa fa-star ratestar" id="star3"></span>
        <span class="fa fa-star ratestar" id="star4"></span>
        <span class="fa fa-star ratestar" id="star5"></span>
        <span><button class="addbutton"><b>watched</b></button></span>
        <span>
          <form id="addinfo">
            <b>addtags</b>
            <input type="text" id="addtags" style="margin-right:10px">
            <b>addauthers</b>
            <input type="text" id="addauthers">
            <button type="button" class="submitbutton">Submit</button>
          </form>
        </span>
      </div>
    </div>
  </div> 
</div>

<script>
  function lighting(star){
    if(star >= 1){ $("#star1").addClass("checked"); }
    if(star >= 2){ $("#star2").addClass("checked"); }
    if(star >= 3){ $("#star3").addClass("checked"); }
    if(star >= 4){ $("#star4").addClass("checked"); }
    if(star >= 5){ $("#star5").addClass("checked"); }
  }

  $(document).ready(function(){
    var star = <?php echo $toplay->rate ?>;
    var watched = <?php echo $toplay->watched ?>;
    lighting(star);

    $(".ratestar").hover(
      function(){
        $(".ratestar").removeClass("checked");
        switch( $(this).attr("id") ){
          case "star1": lighting(1); break;
          case "star2": lighting(2); break;
          case "star3": lighting(3); break;
          case "star4": lighting(4); break;
          case "star5": lighting(5); break;
        }
      },
      function(){
        $(".ratestar").removeClass("checked");
        lighting(star);
      }
    );

    $(".ratestar").click(function(){
      switch( $(this).attr("id") ){
        case "star1": star=1; break;
        case "star2": star=2; break;
        case "star3": star=3; break;
        case "star4": star=4; break;
        case "star5": star=5; break;
      }
      lighting(star);
    });

    $(".addbutton").click(function(){
      watched = watched +1;
      $(this).removeClass("addbutton");
      $(this).addClass("buttonactive");
    })

    $(".submitbutton").click(function(){
      $.ajax({
        type: "POST",
        url: "service.php",
        dataType: "json",
        data: {
          route: "<?php echo $toplay->route; ?>",
          watched: watched,
          rate: star,
          addtags: $("#addtags").val(),
          addauthers: $("#addauthers").val()
        }
      })
    });

  });
</script>

</body>
</html>