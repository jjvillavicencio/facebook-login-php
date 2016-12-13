<?php
// /**
// * Login con Facebook SDK 5.0.0
// * Autor: John Jairo Villavicencio Sarango
// **/

  //INICIAMOS UNA SESION PARA ADMINISTRAR EL USUARIO
  session_start();
  //CARGAMOS EL SDK DE FACEBOOK
  require_once "php-graph-sdk-5.0.0/src/Facebook/autoload.php";
  //CARGAMOS LAS CREDENCIALES DE APLICACION DE FACEBOOK
  require_once "credentials.php";

 //CARGAR LA CONFIGURACIÓN DE LA APLICACIÓN EN EL SERVICIO FACEBOOK\FACEBOOK
 $fb = new Facebook\Facebook([
   'app_id' => $app_id,
   'app_secret' => $app_secret,
   'default_graph_version' => 'v2.3'
   ]);

 //INICIAR ASISTENTE PARA MANEHAR TOKEN DE ACCESO
 $helper = $fb->getRedirectLoginHelper();
 //DESCRIBIR LOS PERMISOS A LOS QUE QUIERES ACCEDER DEL USUARIO
 $permissions = ['email']; // permisos
 //GENERAR LA URL PARA SOLICITAR EL LOGIN
 $loginUrl = $helper->getLoginUrl($login_url, $permissions);

 echo '<a href="' . htmlspecialchars($loginUrl) . '">Entrar con Facebook!</a>';

?>
