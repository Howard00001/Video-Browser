<?php

// tag initialize or load
if(!isset($_COOKIE['currenttag']) || $_COOKIE['currenttag'] ==""){
    setcookie('currenttag', "ALL");
}
$newtag = "ALL";
if(isset($_GET['currenttag']) && is_string($_GET['currenttag'])) {
    $newtag = $_GET['currenttag'];
    setcookie('currentauther', "ALL");
    if($_COOKIE['currenttag'] != $newtag){
        setcookie('currenttag', $newtag);
        if($newtag == "ALL"){
            $infolist2 = $infolist;
            $_SESSION['infolist2'] = $infolist2;
        } else {
            $infolist2 = filtered($newtag,$infolist);
            $_SESSION['infolist2'] = $infolist2;
        }
    }
}

// auther initialize or load
if(!isset($_COOKIE['currentauther']) || $_COOKIE['currentauther'] ==""){
    setcookie('currentauther', "ALL");
}
$newauther = "ALL";
if(isset($_GET['currentauther']) && is_string($_GET['currentauther'])) {
    $newauther = $_GET['currentauther'];
    setcookie('currenttag', "ALL");
    if($_COOKIE['currentauther'] != $newauther){
        setcookie('currentauther', $newauther);
        if($newauther == "ALL"){
            $infolist2 = $infolist;
            $_SESSION['infolist2'] = $infolist2;
        } else {
            $infolist2 = filtered2($newauther,$infolist);
            $_SESSION['infolist2'] = $infolist2;
        }
    }
}

//page initialization or load
$perpage = 8;
$totalpages = ceil(count($infolist2) / $perpage);
if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
    $currentpage = (int) $_GET['currentpage'];
} else {
    $currentpage = 1;
}
if ($currentpage > $totalpages) { 
    $currentpage = $totalpages;
}
if ($currentpage < 1) {
    $currentpage = 1;
}
$offset = ($currentpage - 1) * $perpage;

//shuffle content
if(isset($_GET['shuffle']) && is_string($_GET['shuffle'])){
    $currentpage = 1;
    shuffle($infolist2);
    $_SESSION['infolist2'] = $infolist2;
}

?>