<?php
class TipSobe{
  
    // database konekcije i ime tabele
    private $conn;
    private $table_name = "tip_sobe";
  
    // svojstva objekta
    public $id;
    public $naziv;
    public $skraceni_naziv;
    public $opis;
    public $cena;  
	public $sobe;
	public $broj_soba;
    // konstruktor sa $db kao database konekcija
    public function __construct($db){
        $this->conn = $db;
    }
	// ispisi tipove soba
function read(){
  
    // upit koji selektuje sve
    $query = "SELECT
                id,naziv, skraceni_naziv, opis, cena,broj_soba
            FROM
                " . $this->table_name;
  
    // pripremi upit
    $stmt = $this->conn->prepare($query);
  
    // izvrsi upit
    $stmt->execute();
  
    return $stmt;
}

// kreiraj podatak
function create(){
  
    // upit za insertovanje podatka
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                naziv=:naziv, skraceni_naziv=:skraceni_naziv, opis=:opis, cena=:cena, broj_soba=:broj_soba";
  
    // pripremi upit
    $stmt = $this->conn->prepare($query);
  
    // sanitizacija
    $this->naziv=htmlspecialchars(strip_tags($this->naziv));
    $this->skraceni_naziv=htmlspecialchars(strip_tags($this->skraceni_naziv));
    $this->opis=htmlspecialchars(strip_tags($this->opis));
    $this->cena=htmlspecialchars(strip_tags($this->cena));
	$this->broj_soba=htmlspecialchars(strip_tags($this->broj_soba));	
  
    // binduj vrednosti
    $stmt->bindParam(":naziv", $this->naziv);
    $stmt->bindParam(":skraceni_naziv", $this->skraceni_naziv);
    $stmt->bindParam(":opis", $this->opis);
    $stmt->bindParam(":cena", $this->cena);
    $stmt->bindParam(":broj_soba", $this->broj_soba);
  
    // izvrsi upit
    if($stmt->execute()){
		$poslednji_id_tipa_sobe=$this->conn->lastInsertId();
		echo $poslednji_tip_sobe."<br>";
		foreach ($this->sobe as $soba) {			
		$query="INSERT INTO sobe (tip_sobe_id,naziv) VALUES ('".$poslednji_id_tipa_sobe."','".$soba."')";
		$stmt = $this->conn->prepare($query);		
		$stmt->execute();
		}
        return true;
    }
  
    return false;
      
}


// obrisi tip sobe
function delete(){
  
    // upit za brisanje
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
  
    // pripremi upit
    $stmt = $this->conn->prepare($query);
  
    // sanitizuj
    $this->id=htmlspecialchars(strip_tags($this->id));
  
    // binduj id reda za brisanje
    $stmt->bindParam(1, $this->id);
  
    // izvrsi upit
    if($stmt->execute()){
        return true;
    }
  
    return false;
}

}
?>