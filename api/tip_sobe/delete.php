<?php
// headeri
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Headers: Authorization");
header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");  
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }  
  
  
// ukljuci database i TipSobe klase
include_once '../config/database.php';
include_once '../objects/tip_sobe.php';
  
// prezmi konekciju na bazu
$database = new Database();
$db = $database->getConnection();
  
// pripremi TipSobe objekat
$TipSobe = new TipSobe($db);
  
// preuzmi id proizvoda iz jsona
$data = json_decode(file_get_contents("php://input"));
  
// podesi id proizvoda
$TipSobe->id = $data->id;
  
// obrisi proizvod
if($TipSobe->delete()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("message" => "Tip sobe je obrisan."));
}
  
// ako proizvod ne moze da se obrise
else{
  
    // podesi response code - 503 service unavailable
    http_response_code(503);
  
    // posalji poruku korisniku
    echo json_encode(array("message" => "Ne mogu da obrisem tip sobe."));
}
?>