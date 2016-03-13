<?php
class ClientJ extends Client {
	private $cnpj;

	public function getCnpj(){ return $this->cnpj; }
	public function setCnpj($cnpj){ $this->cnpj =  preg_replace( '/[^0-9]/', '', $cnpj); }

	public function validates(){
		parent::validates();
		Validations::isCnpj($this->cnpj, 'cnpj', $this->errors);
		Validations::notEmpty($this->cnpj, 'cnpj', $this->errors);
	}

	public function save(){
		if (!$this->isvalid() || !Validations::uniqueField($this->cnpj, 'cnpj', 'juridical_clients', $this->errors)
		) return false;

		parent::save();
		$this->clients_id = Client::lastInsertId();

        $params = array($this->cnpj, $this->clients_id);
        $sql = "INSERT INTO juridical_clients (cnpj, clients_id) 
                          VALUES (?,?)";
 
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

		$params = array($this->cnpj, $this->id);
		$sql = "UPDATE juridical_clients SET cnpj = ? WHERE clients_id = ?";

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
		$sql = "SELECT clients.id AS id, phone, email, cnpj, name, cities_id, address, client_type FROM clients, juridical_clients WHERE (clients.id = juridical_clients.clients_id) AND (clients.id = ?)";
		$params = array($id);

		$db = Database::getConnection();
		$statement = $db->prepare($sql);
		$resp = $statement->execute($params);

		if ($resp && $row = $statement->fetch(PDO::FETCH_ASSOC)) {
			return new ClientJ($row);
		}

		return null;
	}


	 public static function count() {
      $sql = "SELECT COUNT(*) FROM juridical_clients";

      $db = Database::getConnection();
      $statement = $db->prepare($sql);
      $statement->execute();

      return $statement->fetch()[0];
    }

}
?>