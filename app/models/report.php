<?php 
class Report extends Base {
	private $employees_id;
	private $total_orders;
	private $percent_finished;
	private $finished_orders;
	private $opened_orders;

	public function getTotalOrders(){return $this->total_orders;}
	public function setTotalOrders($total_orders){$this->total_orders = $total_orders;}
	public function getEmployeesId(){return $this->employees_id;}
	public function setEmployeesId($employees_id){$this->employees_id = $employees_id;}
	public function getPercentFinished(){
		$this->percent_finished = ($this->finished_orders/$this->total_orders)*100;
		return $this->percent_finished;
	}
	public function setPercentFinished($percent_finished){$this->percent_finished = $percent_finished;}
	public function getEmployee(){
		return Employee::findById($this->employees_id);
	}

	public function getAmountBySituationId($situation_id){
		$sql = "SELECT COUNT(*) as amount FROM service_orders	WHERE employees_id = ? AND situations_id = ?";
		$params = array($this->employees_id, $situation_id);

		$db = Database::getConnection();
		$statement = $db->prepare($sql);
		$resp = $statement->execute($params);

		if($resp && $amount = $statement->fetch(PDO::FETCH_ASSOC)){
			return $amount['amount'];
		}
	}


	public function setFinishedOrders($finished){
		$this->finished_orders = $finished;
	}

	public static function all(){
		$sql = "SELECT id, employees_id, COUNT(*) AS total_orders 
						FROM service_orders 
						GROUP BY employees_id
						ORDER BY total_orders DESC";
	
		$db = Database::getConnection();
		$statement = $db->prepare($sql);
		$resp = $statement->execute();

		$reports = [];

		while($resp && $report = $statement->fetch(PDO::FETCH_ASSOC)){
			$reports[] = new Report($report);
		}
		return $reports;

	}
}
?>