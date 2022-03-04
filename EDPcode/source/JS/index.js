//open view with content depending on if add or view existing
function openView(theObject, thePosition) {
    x = document.getElementById("view");
    x.style.display = "block";
    imageCurrent = document.getElementById("currentImage");
    nameField = document.getElementById("thename");
    ageField = document.getElementById("theage");
    hobbyField = document.getElementById("thehobby");
    testNewOrOldField = document.getElementById("newOrOld");
    if(typeof(theObject) == "string"){
        imageCurrent.src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7";
        testNewOrOldField.value = "new";
        nameField.value = " ";
        ageField.value = " ";
        hobbyField.value = " ";
    } else {
        imageCurrent.src = theObject['image'];
        nameField.value = theObject['name'];
        ageField.value = theObject['age'];
        hobbyField.value = theObject['hobby'];
        testNewOrOldField.value = thePosition;
    }
}
