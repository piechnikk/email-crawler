<?php
$emails = array();
$sites = array();


if(isset($_GET["target"])){
    searchLink($_GET["target"], $_GET["number"]);
    echo json_encode([$emails, $sites]);
}



function searchMail($target){
    global $emails;
    $content = @file_get_contents($target);
    preg_match_all("|\w+@\w+\.\w+|", $content, $matches);
    $emails[] = $matches[0];
}

function searchLink($target, $number){
    global $sites;
    $sites[] = $target;
    searchMail($target);
    $content = @file_get_contents($target);
    preg_match_all("|a\shref\=\"(https?:\/\/\S*?)\"|", $content, $matches);
    if($number>0){
        for($i = 0; $i < sizeof($matches[1]); $i++){
            if($i>8) $number = 1;
            searchLink($matches[1][$i], $number-1);
        }
    }
}
?>