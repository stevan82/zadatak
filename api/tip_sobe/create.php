<?php
// headeri
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 86400");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: PUT, GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Headers: Authorization");
//header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");

    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }

// preuzmi konekciju na bazu
include_once '../config/database.php';
  
// instanciraj objekat product
include_once '../objects/tip_sobe.php';
  
$database = new Database();
$db = $database->getConnection();
  
$TipSobe = new TipSobe($db);
  
// preuzmi poslate podatke
$data = json_decode(file_get_contents("php://input"));
  
// proveri da li su podaci prazni
if(
    !empty($data->naziv) &&
    !empty($data->skraceni_naziv) &&
    !empty($data->opis) &&
    !empty($data->cena)
){
  
    // podesi property proizvoda
    $TipSobe->naziv = $data->naziv;
    $TipSobe->skraceni_naziv = $data->skraceni_naziv;
    $TipSobe->opis = $data->opis;
    $TipSobe->cena = $data->cena;
	$TipSobe->broj_soba = $data->broj_soba;
	//$TipSobe->sobe =  $data[4]['soba[0]'];
	$TipSobe->sobe = $data->soba;
	var_dump($data->soba);
    // kreiraj proizvod
    if($TipSobe->create()){
  
        // podesi response code - 201 created
        http_response_code(201);
  
        // posalji poruku korisniku
        echo json_encode(array("message" => "Tip sobe je kreiran."));   
	}  
    // ako ne moze da se kreira proizvod posalji poruku korisniku
    else{  
        // podesi response code - 503 service unavailable
        http_response_code(503);
  
        // posalji poruku korisniku
        echo json_encode(array("message" => "Ne mogu da kreiram tip sobe."));
    }
}
  
// reci korisniku da podaci nisu kompletni
else{
  
    // podesi response code - 400 bad request
    http_response_code(400);
  
    // posalji poruku korisniku
    echo json_encode(array("message" => "Unable to create product. Data is incomplete."));
}
?>