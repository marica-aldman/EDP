<?php
// check if we have done a search
$search = FALSE;
$searchName = "";
$searchAge = "";
$searchHobby = "";
$searchValues = "";
$searchArray = "";

// when we are first starting the page we dont have any values in post
// do a full search for display purposes

if(!isset($_POST["cancel"]) && !isset($_POST["save"]) && !isset($_POST["search"])) {
    $search = TRUE;
    $searchName = "";
    $searchAge = "";
    $searchHobby = "";
    $tempItem = array(
        'name' => $searchName,
        'age' => $searchAge,
        'hobby' => $searchHobby
    );
    $searchValues = json_encode($tempItem);
    // get the search
    $url = "EDPBACKcode/api.php";

    $ch = curl_init();

    $fortest = array(
        "type" => "search",
        "request" => $tempItem
    );
    $test = json_encode($fortest, true);

    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS,
    "request=" . $test);


    // Receive server response
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec($ch);
    
    $result = json_decode($server_output, true);
    $searchArray = $result;
    curl_close ($ch);
}

if(isset($_POST["cancel"])) {
    $searchValues = $_POST["searchValue"];
    $searched = json_decode($_POST["searchValue"]);
    $searchName = $searched -> {'name'};
    $searchAge = $searched -> {'age'};
    $searchHobby = $searched->{'hobby'};
    $tempItem = array(
        'name' => $searchName,
        'age' => $searchAge,
        'hobby' => $searchHobby
    );
    $searchValues = json_encode($tempItem);
    // get the search
    
    $url = "EDPBACKcode/api.php";

    $ch = curl_init();

    $fortest = array(
        "type" => "search",
        "request" => $tempItem
    );
    $test = json_encode($fortest, true);

    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS,
    "request=" . $test);


    // Receive server response
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec($ch);
    
    $result = json_decode($server_output, true);
    $searchArray = $result;

    curl_close ($ch);
}
if(isset($_POST["search"])) {
    $search = TRUE;
    $searchName = $_POST["searchName"];
    $searchAge = $_POST["searchAge"];
    $searchHobby = $_POST["searchHobby"];
    $tempItem = array(
        'name' => $searchName,
        'age' => $searchAge,
        'hobby' => $searchHobby
    );
    $searchValues = json_encode($tempItem);
    // get the search
    //$searchArray = getSearch($searchName, $searchAge, $searchHobby);
    $url = "EDPBACKcode/api.php";

    $ch = curl_init();

    $fortest = array(
        "type" => "search",
        "request" => $tempItem
    );
    $test = json_encode($fortest, true);

    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS,
    "request=" . $test);


    // Receive server response
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec($ch);
    
    $result = json_decode($server_output, true);
    $searchArray = $result;

    curl_close ($ch);
}

// check if we have done a save
$save = FALSE;
$saveComplete = FALSE;
$name = "";
$age = "";
$hobby = "";
$base64 = "";
$oldOrNew = "";
$image = "";

if(isset($_POST["save"])) {
    $save = TRUE;
    if($_POST["newOrOld"] == "new"){
        $oldOrNew = $_POST["newOrOld"];
    } else {
        $oldOrNew = intval($_POST["newOrOld"]);
    }
    $name = trim($_POST["name"]);
    $age = intval($_POST["age"]);
    $hobby = trim($_POST["hobby"]);

    if(!$_FILES['theimage']['name'] == ""){
        
        $type = pathinfo($_FILES['theimage']['name'], PATHINFO_EXTENSION);
        $image = file_get_contents($_FILES['theimage']['tmp_name']);

        $img = base64_encode($image);

        $image = file_get_contents($_FILES['theimage']['tmp_name']);

        $img = base64_encode($image);
        $base64 = 'data:image/' . $type . ';base64,' . $img;
    }
    
}

// save values
if($save){
    $tempItem = array(
        'name' => $name,
        'age' => $age,
        'hobby' => $hobby,
        'base64' => $base64,
        'position' => $oldOrNew
    );

    $url = "EDPBACKcode/api.php";

    $ch = curl_init();

    $fortest = array(
        "type" => "save",
        "request" => $tempItem
    );

    $test = json_encode($fortest, true);
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS,
    "request=" . $test);

    // Receive server response
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec($ch);
    $result = json_decode($server_output, true);
    $oldOrNew = $result['position'];
    $image = $result['item']['image'];
    $saveComplete = TRUE;
    curl_close ($ch);

    // get the search for display purposes
    $searchValues = $_POST["searchValue"];
    $searched = json_decode($_POST["searchValue"]);
    $searchName = $searched -> {'name'};
    $searchAge = $searched -> {'age'};
    $searchHobby = $searched->{'hobby'};

    $ch2 = curl_init();
    
    $tempItem = array(
        'name' => $searchName,
        'age' => $searchAge,
        'hobby' => $searchHobby
    );

    $fortest2 = array(
        "type" => "search",
        "request" => $tempItem
    );
    $test2 = json_encode($fortest2, true);

    curl_setopt($ch2, CURLOPT_URL,$url);
    curl_setopt($ch2, CURLOPT_POST, true);
    curl_setopt($ch2, CURLOPT_POSTFIELDS,
    "request=" . $test2);


    // Receive server response
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);

    $server_output2 = curl_exec($ch2);
    
    $result2 = json_decode($server_output2, true);
    $searchArray = $result2;

    curl_close ($ch2);
}

?>

<main>
    <section id="add" class="id">
        <button onclick='openView(" ", "");'>Add new item</button>
    </section>
    <section id="search" class="search">
        <form action="index.php" method="POST">
            <table>
                <tbody>
                    <tr>
                        <td>
                            Name:
                        </td>
                        <td>
                            <input type="text" name="searchName" value=<?php echo $searchName; ?>>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Age:
                        </td>
                        <td>
                            <input type="text" name="searchAge" value=<?php echo $searchAge; ?>>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Hobby:
                        </td>
                        <td>
                            <input type="text" name="searchHobby" value=<?php echo $searchHobby; ?>>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            &nbsp;
                        </td>
                        <td>
                            <button name="search" type="submit">Search</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </section>
    <section id="result" class="resultsection">

<?php 

    // display all search results
    $j = 0;
    if(gettype($searchArray) == "array") {
        foreach($searchArray as $x => $object) {
            if(count($object) > 0){
?>


<div class="resultcard">
            <div class="resultimg">
                <img src="<?php echo $object['image']; ?>">
            </div>
            <div class="resulttext">
                <table>
                    <tbody>
                        <tr>
                            <td class="resultLabel">
                                Name:
                            </td>
                            <td>
                                <?php echo $object['name']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="resultLabel">
                                Age:
                            </td>
                            <td>
                                <?php echo $object['age']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="resultLabel">
                                Hobby:
                            </td>
                            <td>
                                <?php echo $object['hobby']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                &nbsp;
                            </td>
                            <td>
                                <button onclick='openView(<?php echo json_encode($object); ?>, <?php echo $j; ?>)'>View</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

<?php 
            }
            $j++;
        }
    }
?>


    </section>
    
    <section id="view" <?php if(!$saveComplete){ echo "style='display: none;'"; } ?> class="viewmodule">
        <div>
            <div class="closeButton">
                <form action="index.php" method="POST" enctype="multipart/form-data">    
                    <input type="hidden" name="searchValue" value=<?php echo $searchValues; ?>>    
                    <button name="cancel">Close</button>
                </form>
            </div>
            <div class="currentImage">
                <img src="<?php if($saveComplete){ echo $image; }?>" id="currentImage">
            </div>
            <div class="currentInfo">
                <form action="index.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="newOrOld" value="<?php if($saveComplete){ echo $oldOrNew; }?>" id="newOrOld">
                    <input type="hidden" name="searchValue" value=<?php echo $searchValues; ?>>
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    Name:
                                </td>
                                <td>
                                    <input type="text" name="name" id="thename" value="<?php if($saveComplete){ echo $name; }?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Age:
                                </td>
                                <td>
                                    <input type="text" name="age" id="theage" value="<?php if($saveComplete){ echo $age; }?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Hobby:
                                </td>
                                <td>
                                    <input type="text" name="hobby" id="thehobby" value="<?php if($saveComplete){ echo $hobby; }?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Image:
                                </td>
                                <td>
                                    <input type="file" id="theimage" value="" name="theimage" accept="image/*">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <button name="save" type="submit">Save</button>
                                </td>
                                <td>
                                    <button name="cancel">Cancel</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </section>
    <section class="top" id="top">
        <button onclick="goToTop()">To Top</button>
    </section>
    <script>
        // scroll to top

        //Get the button:
        myButtonDiv = document.getElementById("top");

        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function() { scrollFunction() };

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                myButtonDiv.style.display = "block";
            } else {
                myButtonDiv.style.display = "none";
            }
        }

        // When the user clicks on the button, scroll to the top of the document
        function goToTop() {
            document.body.scrollTop = 0; // For Safari
            document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
        }
    </script>
</main>