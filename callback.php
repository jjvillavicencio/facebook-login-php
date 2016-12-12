<?php
/**
* Login con Facebook SDK 5.0.0
* Autor: John Jairo Villavicencio Sarango
**/

session_start();
require_once "php-graph-sdk-5.0.0/src/Facebook/autoload.php";
require_once "credentials.php";

//CARGAR LA CONFIGURACIÓN DE LA APLICACIÓN EN EL SERVICIO FACEBOOK\FACEBOOK
$fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.5'
  ]);

//INICIAR ASISTENTE PARA MANEJAR TOKEN DE ACCESO
$helper = $fb->getRedirectLoginHelper();

//USAMOS EL ASISTENTE DE TOKEN PARA OBTENER UN TOKEN
try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

//VERIFICAR SI EXISTE UN TOKEN GENERADO
if (! isset($accessToken)) {
  if ($helper->getError()) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
  } else {
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad request';
  }
  exit;
}

//INICIALIZAMOS EL MANEJADOR DE oAUTH DE FACEBOOK PARA UN TOKEN DE LARGA DURACION
$oAuth2Client = $fb->getOAuth2Client();
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
$tokenMetadata->validateAppId($app_id);
$tokenMetadata->validateExpiration();

//PREGUNTAMOS SI EL TOKEN DE ACCESO ES DE LARGA DURACION
if (! $accessToken->isLongLived()) {
  try {
    //CAMBIAMOS EL TOKEN DE CORTA DURACIÓN (2HORAS) POR UNO DE LARGA DURACIÓN (60 DIAS)
    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
  } catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
    exit;
  }
}

//ALMACENAMOS EL TOKEN EN UNA VARIABLE DE SESION
$_SESSION['fb_access_token'] = (string) $accessToken;
//NOS REDIRIGIMOS A LA PAGINA PARA PRESENTAR LOS DATOS DEL USURIO REGISTRADO
header("Location: me.php ");




?>