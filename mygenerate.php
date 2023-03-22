<?php
// include_once('./getid3/getid3.php');

#class define
class treasure {
    public $route;
    public $vidname;
    public $auther;
    public $tags;
    public $duration;
    public $durationmin;
    public $watched;
    public $rate;

    function __construct($filepath) {
        $this->route = $filepath;
        $split = explode("/", $filepath);
        $this->vidname = str_replace(".mp4", "", $split[count($split)-1]);
        //$this->vidname = mb_convert_encoding($this->vidname, 'UTF-8', 'auto');
        $searchresult = searchDB($this->vidname);
        if($searchresult==NULL){
            #retrieve from local
            $this->tags = array();
            for($i=2; $i<count($split)-2; $i++){
                array_push($this->tags, $split[$i]);
            }
            $authers = explode("-", $split[count($split)-2]);
            $this->auther = array();
            foreach($authers as $auther0){
                array_push($this->auther, $auther0);
            }
            // $getID3 = new getID3;
            // $info = $getID3->analyze($filepath);
            // $this->duration = $info['playtime_string'];
            // $this->durationmin = strtok($this->duration,":");
            #Insert to DB
            insert_treasure($this);
        } else {
            #retrieve from DB
            $autherstring = explode("-", $searchresult["auther"]);
            $this->auther = array();
            for($i=1; $i<count($autherstring); $i++){
                array_push($this->auther, unserialize($autherstring[$i]));
            }
            $tagstring = explode("-", $searchresult["tags"]);
            $this->tags = array();
            for($i=1; $i<count($tagstring); $i++){
                array_push($this->tags, unserialize($tagstring[$i]));
            }
            $this->duration = $searchresult["duration"];
            $this->durationmin = $searchresult["durationmin"];
            $this->watched = $searchresult["watched"];
            $this->rate = $searchresult["rate"];
        }
    }

    function showinfo(){
        echo "route:" . $this->route . "<br>";
        echo "vidname:" . $this->vidname . "<br>";
        echo "auther:";
        foreach($this->auther as $auther0){
            echo $auther0 . ", ";
        }
        echo "<br>";
        echo "tags:";
        // print_r($this->tags);
        foreach($this->tags as $tag){
            echo $tag . ", ";
        }
        echo "<br>";
        echo "duration:" . $this->duration . "<br>";
        echo "durationmin:" . $this->durationmin . "<br>";
        echo "watched:" . $this->watched . "<br>";
        echo "rate:" . $this->rate . "<br>";
    }
}
############ run ########################################################
# get all mp4 into "files" array
// $files = getfiles("./vid", "mp4");
// $infolist = array();
// foreach($files as $filepath){
//     $x = new treasure($filepath);
//     // $x->showinfo();
//     array_push($infolist, $x);
// }
// $alltags = gettags();
########### load files functions ###########################################
function getfiles($root, $subname){
    $allfiles = array();
    $lst = listdirs($root);
    foreach ($lst as $dir){
        // $files = glob($dir . "/*." . $subname);
        $files = glob($dir . "/*.mp4");
        $allfiles = array_merge($allfiles, $files);
    }
    return $allfiles;
}

function listdirs($dir) {
    static $alldirs = array();
    $dirs = glob($dir . '/*', GLOB_ONLYDIR);
    if (count($dirs) > 0) {
        foreach ($dirs as $d) $alldirs[] = $d;
    }
    foreach ($dirs as $dir) listdirs($dir);
    return $alldirs;
}
########### Application ##########################################################
function filtered($currenttag, $infolist){
    $infolist2 = array();
    if($currenttag == "ALL"){return $infolist;}
    foreach($infolist as $treasure){
      foreach($treasure->tags as $tag){
        if($tag == $currenttag){
          array_push($infolist2, $treasure);
          break;
        }
      }
    }
    return $infolist2;
}

function filtered2($currentauther, $infolist){
    $infolist2 = array();
    if($currentauther == "ALL"){return $infolist;}
    foreach($infolist as $treasure){
      foreach($treasure->auther as $auther){
        if($auther == $currentauther){
          array_push($infolist2, $treasure);
          break;
        }
      }
    }
    return $infolist2;
}

function reflesh($infolist2){
    return shuffle($infolist2);
}
############ DB functions #################################################
function connect_treasurebox(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

function check_exist(){
    $conn = connect_treasurebox();
    $val = mysqli_query($conn,'select 1 from `treasurebox` LIMIT 1');
    if($val!==FALSE){
        return TRUE;
    }
    else{
        return FALSE;
    }
}

function insert_treasure($newtreasure){
    $conn = connect_treasurebox();
    #convert array to string
    $tagstring = "";
    foreach($newtreasure->tags as $tag) {
        $tagstring = $tagstring . "-" . serialize($tag);
    }
    $autherstring = "";
    foreach($newtreasure->auther as $auther0) {
        $autherstring = $autherstring . "-" . serialize($auther0);
    }

    $sql = "INSERT INTO treasurelist (vidname, vidroute, auther, tags, duration, durationmin, watched, rate)
    VALUES ('$newtreasure->vidname', '$newtreasure->route', 
        '$autherstring', '$tagstring', '$newtreasure->duration',
        '$newtreasure->durationmin', '0', '0')";
    $conn->query($sql);
    $conn->close();
}

function searchDB($newvidname){
    $conn = connect_treasurebox();
    $sql = "SELECT * FROM treasurelist WHERE vidname='$newvidname'";
    $result = mysqli_query($conn, $sql);
    $got = mysqli_fetch_assoc($result);
    $conn->close();
    return $got;
}

function gettags(){
    $conn = connect_treasurebox();
    $sql = "SELECT DISTINCT tags FROM treasurelist";
    $result = $conn->query($sql);
    $alltags = array();
    foreach($result as $tags){
        $tagstring = explode("-", $tags["tags"]);
        for($i=1; $i<count($tagstring); $i++){
            $newtag = unserialize($tagstring[$i]);
            if(in_array($newtag, $alltags) == FALSE){
                array_push($alltags, $newtag);
            }
        }
    }
    return $alltags;
}

function getauthers(){
    $conn = connect_treasurebox();
    $sql = "SELECT DISTINCT auther FROM treasurelist";
    $result = $conn->query($sql);
    $allauthers = array();
    foreach($result as $authers){
        $autherstring = explode("-", $authers["auther"]);
        for($i=1; $i<count($autherstring); $i++){
            $newauther = unserialize($autherstring[$i]);
            if(in_array($newauther, $allauthers) == FALSE){
                array_push($allauthers, $newauther);
            }
        }
    }
    return $allauthers;
}

function upsync($treasure){
    $searchresult = searchDB($treasure->vidname);
    if($searchresult==NULL){
        $x = new treasure($treasure->filepath);
    } else {
        $conn = connect_treasurebox();
        $vidname = $treasure->vidname;
        $route = $treasure->route;
        $autherstring = serialize($treasure->auther);
        $tagstring = serialize($treasure->tags);
        $tagstring = "";
        foreach($treasure->tags as $tag) {
            $tagstring = $tagstring . "-" . serialize($tag);
        }
        $autherstring = "";
        foreach($treasure->auther as $auther0) {
            $autherstring = $autherstring . "-" . serialize($auther0);
        }
        $duration = $treasure->duration;
        $durationmin = $treasure->durationmin;
        $watched = $treasure->watched;
        $rate = $treasure->rate;
        $sql = "UPDATE treasurelist SET vidroute='$route', auther='$autherstring',".
            "tags='$tagstring', duration='$duration', durationmin=$durationmin , watched=$watched, rate=$rate ".
            "WHERE vidname = '$vidname'"; //, watched=$watched, rate=$rate
        mysqli_query($conn, $sql);
        mysqli_close($conn);
    }
}

function initialize_treasurebox(){
    $conn = connect_treasurebox();
    $sql = "CREATE TABLE IF NOT EXISTS treasurelist (
            vidname VARCHAR(100) NOT NULL PRIMARY KEY,
            vidroute VARCHAR(200) NOT NULL,
            auther VARCHAR(50),
            tags VARCHAR(50),
            duration VARCHAR(10),
            durationmin INT,
            watched INT,
            rate INT
            )CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    if (mysqli_query($conn, $sql)) {
        echo " ";
        //echo "Table MyGuests created successfully";
      } else {
        echo "Error creating table: " . mysqli_error($conn);
      }
      
    mysqli_close($conn);
}
############################################################################################
?>
