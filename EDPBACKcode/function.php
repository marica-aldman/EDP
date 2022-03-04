<?php
/*
search will right now display all items that contain or match 
any of the search paramaters in database order
if data was placed in a database this could more easily be
ordered for match both, first, second last 
if not search or and empty search has been done all items will
be displayed currently this is not optimal if the number of items
grow much larger
*/
function getSearch($searchName, $searchAge, $searchHobby){
    $searchArray = [];
    // get the data
    $strJsonFileContents = file_get_contents("items.json");
    $itemsArray = json_decode($strJsonFileContents, true);
    // check if we just want everything
	if($searchName == "" && $searchAge== "" && $searchHobby == ""){
        foreach($itemsArray["items"] as $x => $item){
            $searchArray[] = $item;
        } 
		return $searchArray;
    } else {
        foreach($itemsArray["items"] as $x => $item){
            $check = FALSE;
            if($searchName != "" && ($item["name"] == $searchName || strpos($item["name"], $searchName))){
                $check = TRUE;
            }
            if($searchAge != "" && ($item["age"] == $searchAge)){
                $check = TRUE;
            }
            if($searchHobby != "" && ($item["hobby"] == $searchHobby || strpos($item["hobby"], $searchHobby))){
                $check = TRUE;
            }
            // if we found a match we add it to the search result otherwise add an
            // empty array to be able to figure out what position the data is in
            // for saving purposes
            if($check){
                $searchArray[] = $item;
            } else {
                $searchArray[] = array();
            }
        }
		return $searchArray;
    }
}

function savePost($name, $age, $hobby, $base64, $position) {
    // get the data this should probably be changed to a more dynamic format
    // like a db for easier handling
    $strJsonFileContents = file_get_contents("items.json");
    $itemsArray = json_decode($strJsonFileContents, true);
    // of $position is a string this is not an update
	$newItem = "";
	if(gettype($position) == "string"){
		$newItem = array(
			"name" => $name,
			"age" => $age,
			"hobby" => $hobby,
			"image" => $base64
		);

		// add data
		$itemsArray['items'][] = $newItem;

		// encode array to json and save to file
		$newJSON = str_replace("\\","",json_encode($itemsArray, true));
		
		file_put_contents('items.json', $newJSON);
		$newItemsPosition = count($itemsArray['items']) - 1;
		$returnValue = array(
			"item" => $newItem,
			"position" => $newItemsPosition
		);
		return $returnValue;
	} else {$i = 0;
		$newItem = "";
		$newArray = array("items" => array());
		foreach($itemsArray["items"] as $x => $item){
			if($i == $position){
				if($base64 == '""' || $base64 == "" ){
					$newItem = array(
						"name" => $name,
						"age" => $age,
						"hobby" => $hobby,
						"image" => $item['image']
					);
					 
				} else {
					$newItem = array(
						"name" => $name,
						"age" => $age,
						"hobby" => $hobby,
						"image" => $base64
					);
				}
				$newArray["items"][] = $newItem;
			} else {
				$newArray["items"][] = $item;
			}
			$i++;
		} 
		// encode array to json and save to file
		$newJSON = str_replace("\\","",json_encode($newArray, true));
		
		file_put_contents('items.json', $newJSON);
		$returnValue = array(
			"item" => $newItem,
			"position" => $position
		);
		return $returnValue; 
		
	}
 
}

?>