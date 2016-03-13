<?php 
class Service extends Base {
	private $name;
	private $description;
	private $cost;
	private $categories_id;


	public function getName(){return $this->name;}
	public function setName($name){$this->name = $name;	}
	public function setDescription($description){$this->description = $description;}
	public function getDescription(){return $this->description;}
	public function setCost($cost){$this->cost = $cost;}
	public function getCost(){return $this->cost;}
	public function getCategoriesId(){return $this->categories_id;}
	public function setCategoriesId($cat_id){$this->categories_id = $cat_id;}
	public function getCategory() {
		return Category::findById($this->categories_id);
    }

	public function validates(){
		Validations::greaterThen($this->name, 5, 'name', $this->errors);
		Validations::greaterThen($this->description, 5, 'description', $this->errors);

		Validations::isNumeric($this->cost, 'cost', $this->errors);
		Validations::isSelected($this->categories_id, 'categories_id', $this->errors);
		
		Validations::notEmpty($this->description, 'description', $this->errors);
		Validations::notEmpty($this->name, 'name', $this->errors);
		Validations::notEmpty($this->cost, 'cost', $this->errors);
	}

	public function save(){
		if(!$this->isValid()) return false;
		
		$params = array($this->name, $this->description, $this->cost, $this->getCategoriesId());
		$sql = "INSERT INTO services (name, description, cost, categories_id) 
		VALUES (?,?,?,?)";

		$db = Database::getConnection();
		$statement = $db->prepare($sql);
		$resp = $statement->execute($params);

		if (!$resp) {
			Logger::getInstance()->log("Falha para salvar Serviço: " . print_r($this, TRUE), Logger::ERROR);
			Logger::getInstance()->log("Error: " . print_r(error_get_last(), true), Logger::ERROR);
			return false;
		}
		return true;
	}

	public static function all(){
		$sql = "SELECT * FROM services ORDER BY name ASC";
		$db = Database::getConnection();
		$statement = $db->prepare($sql);
		$resp = $statement->execute();

		$services = [];

		while($resp && $service = $statement->fetch(PDO::FETCH_ASSOC)){
			$services[] = new Service($service);
		}
		return $services;

	}

	public static function findById($id){
		$sql = "SELECT * FROM services WHERE id = ?";
		$params = array($id);

		$db = Database::getConnection();
		$statement = $db->prepare($sql);
		$resp = $statement->execute($params);

		if ($resp && $row = $statement->fetch(PDO::FETCH_ASSOC)) {
			return new Service($row);
		}

		return null;
	}

	public function update($data){
		$this->setData($data);
		if (!$this->isvalid()) return false;

		$params = array($this->name, $this->description, $this->cost ,$this->id);
		$sql = "UPDATE services SET name = ?, description = ?, cost = ?
		WHERE id = ?";

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

	public function delete() {
		$db = Database::getConnection();
		$params = array($this->id);
		$sql = "DELETE FROM services WHERE id = ?";
		$statement = $db->prepare($sql);
		return $statement->execute($params);
	}

	public static function count() {
      $sql = "SELECT COUNT(*) FROM services";

      $db = Database::getConnection();
      $statement = $db->prepare($sql);
      $statement->execute();

      return $statement->fetch()[0];
    }


} ?>