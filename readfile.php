<?php
if (isset($_GET["fname"])){
    $fname=$_GET["fname"];
    $myfile = fopen($fname, "r") or die("Unable to open file!");
    echo fread($myfile,filesize($fname));
    fclose($myfile);
}else{
    echo "<h1>No File Selected</h1>";
}
?>
