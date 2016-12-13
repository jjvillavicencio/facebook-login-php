<?php
// /**
// * Login con Facebook SDK 5.0.0
// * Autor: John Jairo Villavicencio Sarango
// **/

//INICIAMOS LAS SESIONES DE PHP
session_start();

//PREGUNTAMOS SI HAY UN TOKEN ALMACENADO EN LA SESION ACTUAL
if(isset($_SESSION["fb_access_token"])){

//CARGAMOS EL SDK DE FACEBOOK
require_once "php-graph-sdk-5.0.0/src/Facebook/autoload.php";
//CARGAMOS LAS CREDENCIALES DE APLICACION DE FACEBOOK
require_once "credentials.php";

//CARGAR LA CONFIGURACIÓN DE LA APLICACIÓN EN EL SERVICIO FACEBOOK\FACEBOOK
$fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.5'
  ]);

//ALMACENAMOS EN UN AVARIABLE EL TOKEN DE LA SESION ACTUAL
$accessToken = $_SESSION['fb_access_token'] ;

if(isset($accessToken)){
  //ESTABLECE EL TOKEN DE ACCESO DE FALLBACK PREDETERMINADO 
  //PARA QUE NO TENGAMOS QUE PASARLO A CADA SOLICITUD
$fb->setDefaultAccessToken($accessToken);


//OBTENEMOS LOS DATOS DEL USUARIO LOGEADO
try {
  $response = $fb->get('/me');
  $userNode = $response->getGraphUser();
  $plainOldArray = $response->getDecodedBody();
  print_r($plainOldArray);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

echo 'Bienvenido ' . $userNode->getName();
echo " <a href='logout.php'>Salir</a>";
}

}else{
  header("Location: index.php");

}

?>