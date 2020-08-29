<?php
// required headers
$host= $_SERVER["HTTP_HOST"];
$url= $_SERVER["REQUEST_URI"];
$urlcompleta="http://" . $host . $url;
header("Access-Control-Allow-Origin: $urlcompleta");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// Los Archivos que necesitamos para conectar
include_once 'config/database.php';
include_once 'objects/api_users.php';
 
// Obtener conexión a la base de datos
$database = new Database();
$db = $database->getConnection();
 
// Instanciar objeto de producto
$api_users = new Api_Student($db);
 
// Obtener datos publicados
$data = json_decode(file_get_contents("php://input"));
 
// Establecer los Valores 
$api_users->username = $data->username;
//$api_users->remember = $data->remember;
$username_exists = $api_users->usernameExists();
// Generar Json web token
include_once 'config/core.php';
include_once 'libs/php-jwt-master/src/BeforeValidException.php';
include_once 'libs/php-jwt-master/src/ExpiredException.php';
include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once 'libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

// Checamos si el Username Existe y si la Contraseña es correcta
if($username_exists && password_verify($data->password, $api_users->password)){
	
    $token = array(
       "iss" => $iss,
       "aud" => $aud,
       "iat" => $iat,
       "nbf" => $nbf,
       "data" => array(
           "id" => $api_users->id,
           "students_id" => $api_users->students_id,
           "username" => $api_users->username
       )
    );
 
  	//Cuando el usuario si pudo ingresar
    http_response_code(200);
 
    //Generar jwt
    $jwt = JWT::encode($token, $key);
	//$api_users->UpdateToken($jwt, $api_users->id);
	
	
    echo json_encode(
            array(
                "message" => "Ingreso Realizado.",
                "jwt" => $jwt
            )
        );
 
// login failed	
}else{
	
   // Cuando el usuario no pudo ingresar
    http_response_code(401);
    echo json_encode(array("message" => "Error de Ingreso."));
}

