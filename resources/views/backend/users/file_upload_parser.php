<?php
$fileName = $_FILES["videofile"]["name"]; // The file name
$fileTmpLoc = $_FILES["videofile"]["tmp_name"]; // File in the PHP tmp folder
$fileType = $_FILES["videofile"]["type"]; // The type of file it is
$fileSize = $_FILES["videofile"]["size"]; // File size in bytes
$fileErrorMsg = $_FILES["videofile"]["error"]; // 0 for false... and 1 for true
if (!$fileTmpLoc) { // if file not chosen
    echo "ERROR: Please browse for a file before clicking the upload button.";
    exit();
}

?>