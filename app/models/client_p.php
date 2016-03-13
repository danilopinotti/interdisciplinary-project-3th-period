<?php
class ClientP extends Client {
	protected $genre;
	protected $cpf;

	public function getGenre(){ return $this->genre; }
	public function setGenre($genre){ $this->genre = $genre; }
	public function getCpf(){ return $this->cpf; }
	public function setCpf($cpf){ $this->cpf = preg_replace( '/[^0-9]/', '', $cpf); }


	public function validates(){
		parent::validates();
		Validations::isCpf($this->cpf, 'cpf', $this->errors);
		//Validations::notEmpty($this->genre, 'genre', $this->errors);
		Validations::notEmpty($this->cpf, 'cpf', $this->errors);
	}

	public function save(){
		if (!$this->isvalid() || !Validations::uniqueField($this->cpf, 'cpf', 'physical_clients', $this->errors)
		) return false;

		parent::save();
		$this->clients_id = Client::lastInsertId();

        $params = array($this->cpf, $this->genre, $this->clients_id);
        $sql = "INSERT INTO physical_clients (cpf, genre, clients_id) 
                          VALUES (?,?,?)";
 
        $db = Database::getConnection();
        $statement = $db->prepare($sql);
        $resp = $statement->execute($params);

        if (!$resp) {
           Logger::getInstance()->log("Falha para salvar: " . print_r($this, TRUE), Logger::ERROR);
           Logger::getInstance()->log("Error: " . print_r(error_get_last(), true), Logger::ERROR  );
           return false;
        }
        return true;
	}

	public function update($data){
		$this->setData($data);
		if (!$this->isvalid()) return false;

		parent::update();

		$params = array($this->cpf, $this->genre, $this->id);
		$sql = "UPDATE physical_clients SET cpf = ?, genre = ? WHERE clients_id = ?";

		$db = Database::getConnection();
		$statement = $db->prepare($sql);
		$resp = $statement->execute($params);

		if (!$resp) {
			Logger::getInstance()->log("Falha para atualizar: " . print_r($this, TRUE), Logger::ERROR);
			Logger::getInstance()->log("Error: " . print_r(error_get_last(), true), Logger::ERROR);
			return false;
		}
		return true;
	}

	public static function findByClientId($id){
		$sql = "SELECT clients.id AS id, phone, email, cpf, genre, name, cities_id, address, client_type FROM clients, physical_clients WHERE (clients.id = physical_clients.clients_id) AND (clients.id = ?)";
		$params = array($id);

		$db = Database::getConnection();
		$statement = $db->prepare($sql);
		$resp = $statement->execute($params);

		if ($resp && $row = $statement->fetch(PDO::FETCH_ASSOC)) {
			return new ClientP($row);
		}

		return null;
	}

	 public static function count() {
      $sql = "SELECT COUNT(*) FROM physical_clients";

      $db = Database::getConnection();
      $statement = $db->prepare($sql);
      $statement->execute();

      return $statement->fetch()[0];
    }






}
?>