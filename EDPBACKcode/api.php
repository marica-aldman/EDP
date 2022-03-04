<?php
    header("Content-Type:application/json");  
include "function.php";

if(isset($_POST['request'])) {
    $incomingPost = json_decode($_POST['request'], true);
    $request = $incomingPost['request'];
    if($incomingPost['type'] == "search"){
        $searchName = $request['name'];
        $searchAge = $request['age'];
        $searchHobby = $request['hobby'];
        $result = getSearch($searchName, $searchAge, $searchHobby);
        echo json_encode($result, true);
    } else if ($incomingPost['type'] == "save"){
        $name = $request['name'];
        $age = $request['age'];
        $hobby = $request['hobby'];
        $base64 = $request['base64'];
        $new64 = str_replace("\\","",$request['base64']);
        $newBase64 = str_replace(" ","+",$new64);

        $position = $request['position'];

        $result = savePost($name, $age, $hobby, $newBase64, $position);
        echo json_encode($result, true);
    } else {
        echo "Error type not correct or missing";
    }
} else {
    echo "404";
}

?>
