<?php
class Client extends Base {
	protected $name;
	protected $address;
	protected $email;
	protected $phone;
	protected $client_type;
	protected $cities_id;
	protected $clients_id;

	public function getName(){ return $this->name; }
	public function setName($name){ $this->name = $name; }
	public function getAddress(){ return $this->address; }
	public function setAddress($address){ $this->address = $address; }
	public function getEmail(){ return $this->email; }
	public function setEmail($email){ $this->email = $email; }
	public function getPhone(){ return $this->phone; }
	public function setPhone($phone){ $this->phone = preg_replace( '/[^0-9]/', '', $phone); }
	public function getClientType(){ return $this->client_type; }
	public function setClientType($client_type){ $this->client_type = $client_type; }
	public function getCitiesId(){ return $this->cities_id; }
	public function setCitiesId($cities_id){ $this->cities_id = $cities_id; }
	public function getClientId(){ return $this->client_id; }
	public function setClientId($client_id){ $this->client_id = $client_id; }
	public function getDocument(){
		if ($this->client_type == 'J')
			return ClientJ::findByClientId($this->id)->getCnpj();
		else if ($this->client_type == 'F')
			return ClientP::findByClientId($this->id)->getCpf();
		else
			return '';
	}
	public function getCity(){
		return City::findById($this->cities_id);
	}

	public function validates(){
		Validations::validEmail($this->email, 'email', $this->errors);
		Validations::isSelected($this->cities_id, 'cities_id', $this->errors);
		Validations::isNumeric($this->phone, 'phone', $this->errors);

		Validations::greaterThen($this->name, 5, 'name', $this->errors);
		Validations::greaterThen($this->address, 5, 'address', $this->errors);
		
		Validations::notEmpty($this->name, 'name', $this->errors);
		Validations::notEmpty($this->address, 'address', $this->errors);
		Validations::notEmpty($this->email, 'email', $this->errors);
		Validations::notEmpty($this->phone, 'phone', $this->errors);
		//Validations::notEmpty($this->cities_id, 'cities_id', $this->errors);
	}

	public function save() {
      if (!$this->isvalid()) return false;
      $params = array($this->name, $this->address, $this->email, $this->phone, $this->client_type, $this->cities_id);
      $sql = "INSERT INTO clients (name, address, email, phone, client_type, cities_id) 
                            VALUES (?,?,?,?,?,?)";

      $db = Database::getConnection();
      $statement = $db->prepare($sql);
      $resp = $statement->execute($params);

      if (!$resp) {
         Logger::getInstance()->log("Falha para salvar: " . print_r($this, TRUE), Logger::ERROR);
         Logger::getInstance()->log("Error: " . print_r(error_get_last(), true), Logger::ERROR);
         return false;
      }

      return true;
    }

	public static function all(){
		$sql = "SELECT * FROM clients ORDER BY name";
		$db = Database::getConnection();
		$statement = $db->prepare($sql);
		$resp = $statement->execute();

		$clients = [];

		while($resp && $client = $statement->fetch(PDO::FETCH_ASSOC)){
			$clients[] = new Client($client);
		}
		return $clients;
	}

	public static function findById($id){
		$sql = "SELECT client_type FROM clients WHERE id = ?";
		$params = array($id);

		$db = Database::getConnection();
		$statement = $db->prepare($sql);
		$resp = $statement->execute($params);

		if ($resp && $row = $statement->fetch(PDO::FETCH_ASSOC))
			$client_type = $row['client_type'];
		else
			return null;

		if($client_type == 'J')
			return ClientJ::findByClientId($id);
		else if ($client_type == 'F')
			return ClientP::findByClientId($id);
		
		return null;
	}

    public static function lastInsertId() {
       $sql = "  SELECT id FROM clients ORDER BY id DESC LIMIT 1";

      $db = Database::getConnection();
      $statement = $db->prepare($sql);
      $statement->execute();

      return $statement->fetch()[0];
    }

    public function delete(){
    	if ($this->client_type == 'J')
    		$sql_child = "DELETE FROM juridical_clients WHERE clients_id = ?";
    	else
    		$sql_child = "DELETE FROM physical_clients WHERE clients_id = ?";
    	$sql_parent = "DELETE FROM clients WHERE id = ?";

    	if(!$this->canDelete(array('service_orders'), 'clients_id', $this->id)) return false;

    	$db = Database::getConnection();
		$params = array($this->id);


		$statement_child = $db->prepare($sql_child);
		$statement_child->execute($params);

		$statement_parent = $db->prepare($sql_parent);
		$statement_parent->execute($params);
		return true;
    }

    public function update($data){
		$this->setData($data);
		if (!$this->isvalid()) return false;
		
		$params = array($this->name, $this->address, $this->email, $this->phone, $this->cities_id, $this->id);
		$sql = "UPDATE clients SET name = ?, address = ?, email = ?, phone = ?, cities_id = ? WHERE id = ?";

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

	public static function findByName($name){
		$sql = "SELECT id, name, client_type FROM clients WHERE name LIKE :name ";
		$params = ['name' => '%'.$name.'%'];

		$db = Database::getConnection();
		$statement = $db->prepare($sql);
		$resp = $statement->execute($params);

		$clients = [];

		while($resp && $client = $statement->fetch(PDO::FETCH_ASSOC)){
			if ($client['client_type'] == 'J')
				$clients[] = ClientJ::findByClientId($client['id']);
			else
				$clients[] = ClientP::findByClientId($client['id']);
		}

		return $clients;
	}

	public static function count() {
      $sql = "SELECT COUNT(*) FROM clients";

      $db = Database::getConnection();
      $statement = $db->prepare($sql);
      $statement->execute();

      return $statement->fetch()[0];
    }

    public static function whereNameLikeAsJson($query) {
      $sql = "SELECT * FROM clients WHERE name LIKE :query ORDER BY name";
      $params = ['query' => '%' . $query. '%'];

      $db = Database::getConnection();
      $statement = $db->prepare($sql);
      $resp = $statement->execute($params);

      $suggestions = array('suggestions' => '');
      while ($resp && $row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $suggestions['suggestions'][] = array('value' => $row['name'], 'data' => $row['id']);
      }

      return json_encode($suggestions);
    }

}

?>