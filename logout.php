<?php
// /**
// * Login con Facebook SDK 5.0.0
// * Autor: John Jairo Villavicencio Sarango
// **/

session_start();
if(isset($_SESSION["fb_access_token"])){
	session_destroy();
}
header("Location: index.php");

?>