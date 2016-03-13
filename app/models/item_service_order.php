<?php
class ItemServiceOrder extends Base {
	private $cost;
	private $service_orders_id;
	private $services_id;

	public function getCost(){
		return $this->cost;
	}

	public function setCost($cost){
		$this->cost = $cost;
	}

	public function getServiceOrdersId(){
		return $this->service_orders_id;
	}

	public function setServiceOrdersId($service_orders_id){
		$this->service_orders_id = $service_orders_id;
	}

	public function getServicesId(){
		return $this->services_id;
	}

	public function setServicesId($services_id){
		$this->services_id = $services_id;
	}

	public function getService(){
		return Service::findById($this->services_id);
	}

	public function validates(){
		Validations::isNumeric($this->services_id, 'services_id', $this->errors);

	} 

//	public static function all(){
//		$sql = "SELECT * FROM priorities ORDER BY id";
//		$db = Database::getConnection();
//		$statement = $db->prepare($sql);
//		$resp = $statement->execute();
//
//		$priorities = [];
//		while($resp && $priority = $statement->fetch(PDO::FETCH_ASSOC)){
//			$priorities[] = new Priority($priority);
//		}
//		return $priorities;
//	}

	public function save(){
		if(!$this->isValid()) return false;
		
		$this->cost = $this->getService()->getCost();
		$params = array($this->cost, $this->service_orders_id, $this->services_id);
		$sql = "INSERT INTO items_service_order (cost, service_orders_id, services_id) 
		VALUES (?,?,?)";

		$db = Database::getConnection();
		$statement = $db->prepare($sql);
		$resp = $statement->execute($params);

		if (!$resp) {
			Logger::getInstance()->log("Falha para salvar Serviço: " . print_r($this, TRUE), Logger::ERROR);
			Logger::getInstance()->log("Error: " . print_r(error_get_last(), true), Logger::ERROR);
			return false;
		}

		$service_order = ServiceOrder::findById($this->service_orders_id);
		$service_order->updateTotalCost();
		return true;
	}

	public function delete(){
		$db = Database::getConnection();
	    $sql = "DELETE FROM items_service_order WHERE id = ?";
	    $params = array($this->id);
	    $statement = $db->prepare($sql);
	    $resp = $statement->execute($params);
      	$this->service_order = ServiceOrder::findById($this->service_orders_id);
        $this->service_order->updateTotalCost();
        return $resp;

	}


	public static function findByServiceOrderId($id){
		$sql = "SELECT * FROM items_service_order WHERE service_orders_id = ? ORDER BY id";
		$params = array($id);
		$db = Database::getConnection();
		$statement = $db->prepare($sql);
		$resp = $statement->execute($params);

		$items = [];
		while($resp && $item = $statement->fetch(PDO::FETCH_ASSOC)){
			$items[] = new ItemServiceOrder($item);
		}
		return $items;
	}
	
	public static function findById($id){
		$sql = "SELECT * FROM items_service_order WHERE id = ?";
		$params = array($id);
		$db = Database::getConnection();
		$statement = $db->prepare($sql);
		$resp = $statement->execute($params);

		$items = [];
		if($resp && $item = $statement->fetch(PDO::FETCH_ASSOC)){
			return new ItemServiceOrder($item);
		}
	}

	public static function deleteAllFromServiceOrderId($id){
		$db = Database::getConnection();
	    $params = array($id);
	    $sql = "DELETE FROM items_service_order WHERE service_orders_id = ?";
	    $statement = $db->prepare($sql);
	    return $statement->execute($params);
	}

	public static function countFromServiceOrder($id) {
      $sql = "SELECT COUNT(*) FROM items_service_order WHERE service_orders_id = ?";
      $params = array($id);

      $db = Database::getConnection();
      $statement = $db->prepare($sql);
      $statement->execute($params);

      return $statement->fetch()[0];
    }

}
?>