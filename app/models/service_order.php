<?php 
class ServiceOrder extends Base {
  private $priorities_id;
  private $situations_id;
  private $opening_date;
  private $prevision;
  private $total_cost;
  private $reported_problem;
  private $observation;
  private $employees_id;
  private $clients_id;
  private $services = [];


  public function getPrioritiesId(){return $this->priorities_id;}
  public function setPrioritiesId($priorities_id){$this->priorities_id = $priorities_id; }
  public function getSituationsId(){return $this->situations_id;}
  public function setSituationsId($situations_id){$this->situations_id = $situations_id; }
  public function getOpeningDate(){return $this->opening_date;}
  public function setOpeningDate($opening_date){$this->opening_date = $opening_date; }
  public function getPrevision(){return $this->prevision;}
  public function setPrevision($prevision){ $this->prevision = $prevision; }
  public function getTotalCost(){return $this->total_cost;}
  public function setTotalCost($total_cost){$this->total_cost = $total_cost; }
  public function getReportedProblem(){return $this->reported_problem;}
  public function setReportedProblem($reported_problem){$this->reported_problem = $reported_problem; }
  public function getObservation(){return $this->observation;}
  public function setObservation($observation){$this->observation = $observation; }
  public function getEmployeesId(){return $this->employees_id;}
  public function setEmployeesId($employees_id){$this->employees_id = $employees_id; }
  public function getClientsId(){return $this->clients_id;}
  public function setClientsId($clients_id){$this->clients_id = $clients_id; }
  public function getSituation(){
    return Situation::findById($this->situations_id);
  }
  public function getPriority(){
    return Priority::findById($this->priorities_id);
  }
  public function getClient(){
    return Client::findById($this->clients_id);
  }
  public function getEmployee(){
    return Employee::findById($this->employees_id);
  }

  public function validates(){
      Validations::notEmpty($this->reported_problem, 'reported_problem', $this->errors);
      Validations::greaterThen($this->reported_problem, 5, 'reported_problem', $this->errors);

      Validations::isSelected($this->clients_id, 'clients_id', $this->errors);
  }

  public function calculateTotalCost(){
    $sql = "  SELECT SUM(cost) as cost FROM items_service_order WHERE service_orders_id = ?";
    $params = array($this->getId());
    $db = Database::getConnection();
    $statement = $db->prepare($sql);
    $resp = $statement->execute($params);

    if ($resp && $row = $statement->fetch(PDO::FETCH_ASSOC)) {
      $this->total_cost = $row['cost'];
    }

    return null;
  }

  public function save(){
    if(!$this->isValid()) return false;
    
    $this->total_cost = ($this->calculateTotalCost())?$this->calculateTotalCost():0;

    $params = array($this->priorities_id, $this->prevision, $this->reported_problem, $this->observation, $this->employees_id, $this->clients_id, $this->total_cost);
    $sql = "INSERT INTO service_orders (priorities_id, situations_id, opening_date, prevision, reported_problem, observation, employees_id, clients_id, total_cost) 
    VALUES (?,'1',NOW(),?,?,?,?,?,?)";

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

  public static function allOpen(){
    $sql = "SELECT * FROM service_orders WHERE situations_id IN (1,2,3) ORDER BY id DESC";
    $db = Database::getConnection();
    $statement = $db->prepare($sql);
    $resp = $statement->execute();

    $service_orders = [];

    while($resp && $service_order = $statement->fetch(PDO::FETCH_ASSOC)){
      $service_orders[] = new ServiceOrder($service_order);
    }
    return $service_orders;

  }

  public static function allSituation($situation_name){
    $sql = "SELECT * FROM service_orders WHERE situations_id = (SELECT id FROM situations WHERE name = ?) ORDER BY id DESC";
    $params = array($situation_name);
    $db = Database::getConnection();
    $statement = $db->prepare($sql);
    $resp = $statement->execute($params);

    $service_orders = [];

    while($resp && $service_order = $statement->fetch(PDO::FETCH_ASSOC)){
      $service_orders[] = new ServiceOrder($service_order);
    }
    return $service_orders;

  }

    public static function all(){
    $sql = "SELECT * FROM service_orders ORDER BY situations_id ASC";
    $db = Database::getConnection();
    $statement = $db->prepare($sql);
    $resp = $statement->execute();

    $service_orders = [];

    while($resp && $service_order = $statement->fetch(PDO::FETCH_ASSOC)){
      $service_orders[] = new ServiceOrder($service_order);
    }
    return $service_orders;

  }

  public static function lastInsert(){
    $sql = "  SELECT id FROM service_orders ORDER BY id DESC LIMIT 1";

    $db = Database::getConnection();
    $statement = $db->prepare($sql);
    $resp = $statement->execute();

    if ($resp && $row = $statement->fetch(PDO::FETCH_ASSOC)) {
      return new Service($row);
    }

    return null;
  }

  public static function findById($id){
    $sql = "SELECT * FROM service_orders WHERE id = ?";
    $params = array($id);

    $db = Database::getConnection();
    $statement = $db->prepare($sql);
    $resp = $statement->execute($params);

    if ($resp && $row = $statement->fetch(PDO::FETCH_ASSOC)) {
      return new ServiceOrder($row);
    }

    return null;
  }

  public function update($data){
    $this->setData($data);
    if (!$this->isvalid()) return false;

    $params = array($this->priorities_id, $this->situations_id, $this->prevision ,$this->total_cost, $this->observation, $this->employees_id, $this->id);
    $sql = "UPDATE service_orders SET priorities_id = ?, situations_id = ?, prevision = ?, total_cost = ?, observation = ?, employees_id = ?
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

  public function updateTotalCost(){
    if (!$this->isvalid()) return false;
    $this->calculateTotalCost();
    $params = array($this->total_cost, $this->id);
    $sql = "UPDATE service_orders SET total_cost = ?
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
    if (ItemServiceOrder::deleteAllFromServiceOrderId($this->id)){
      $sql = "DELETE FROM service_orders WHERE id = ?";
      $statement = $db->prepare($sql);
      return $statement->execute($params);
    }
    return null;
  }

  public function cancel() {
    $sql = "UPDATE service_orders SET situations_id = 6
    WHERE id = ?";
    $params = array($this->id);

    $db = Database::getConnection();
    $statement = $db->prepare($sql);
    $resp = $statement->execute($params);
    return true;
  }

  public function processedOrder(){
    if($this->getSituation()->getId() == 1){
        $params = array($this->id);
        $sql = "UPDATE service_orders SET situations_id = 2 WHERE id = ?";

        $db = Database::getConnection();
        $statement = $db->prepare($sql);
        $resp = $statement->execute($params);     
        }
  }
  public static function count() {
    $sql = "SELECT COUNT(*) FROM service_orders";

    $db = Database::getConnection();
    $statement = $db->prepare($sql);
    $statement->execute();

    return $statement->fetch()[0];
  }

} ?>