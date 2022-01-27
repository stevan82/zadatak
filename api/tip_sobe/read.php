<?php
// headeri
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// ukljuci database i TipSobe fajlove
include_once '../config/database.php';
include_once '../objects/tip_sobe.php';
  
// instanciranje database i TipSobe objekta
$database = new Database();
$db = $database->getConnection();
  
// inicijalizacija objekta
$TipSobe = new TipSobe($db);
  
// upit za citanje proizvoda
$stmt = $TipSobe->read();
$num = $stmt->rowCount();
  
// proveri da li ima vise od 0 redova
if($num>0){
  
    // TipSobes niz
    $sobe_arr=array();
    $sobe_arr["records"]=array();
  
    // retrieve our table contents   
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // ekstraktuj red
        // ovo ce pretvoriti $row['name'] u
        // samo $name
        extract($row);
  
        $tipovi_soba=array(
            "id" => $id,
            "naziv" => $naziv,
            "skraceni_naziv" => html_entity_decode($skraceni_naziv),
            "opis" => $opis,
            "cena" => $cena,
			"broj_soba" => $broj_soba 			
        );
  
        array_push($sobe_arr["records"], $tipovi_soba);
    }
  
    // podesi response code - 200 OK
    http_response_code(200);
  
    // prikazi podatke o proizvodima u json formatu
    echo json_encode($sobe_arr);
}
  
else{
  
    // podesi response code - 404 Not found
    http_response_code(404);
  
    // reci korisniku da proizvodi nisu pronadjeni
    echo json_encode(
        array("message" => "Nije pronadjen ni jedan tip sobe.")
    );
}