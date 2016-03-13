<?php
class Employee extends Base {
	private $name;
	private $email;
	private $phone;
	private $genre;
	private $date_contratation;
	private $date_exit;
	private $password;
	private $last_access;

	public function getName(){ return $this->name; }
	public function setName($name){ $this->name = $name; }
	public function getEmail(){ return $this->email; }
	public function setEmail($email){ $this->email = $email; }
	public function getPhone(){ return $this->phone; }
	public function setPhone($phone){ $this->phone = $phone; }
	public function getGenre(){ return $this->genre; }
	public function setGenre($genre){ $this->genre = $genre; }
	public function getDateContratation(){ return $this->date_contratation; }
	public function setDateContratation($date_contratation){ $this->date_contratation = $date_contratation; }
	public function getDateExit(){ return $this->date_exit; }
	public function setDateExit($date_exit){ $this->date_exit = $date_exit; }
	public function getPassword(){ return $this->password; }
	public function setPassword($password){ $this->password = $password; }
	public function getLastAccess(){ return $this->last_access; }
	public function setLastAccess($last_access){ $this->last_access = $last_access; }

	public static function findById($id){
		$sql = "SELECT * FROM employees WHERE id = ?";
		$params = array($id);

		$db = Database::getConnection();
		$statement = $db->prepare($sql);
		$resp = $statement->execute($params);

		if ($resp && $row = $statement->fetch(PDO::FETCH_ASSOC)) {
		  return new Employee($row);
		}

		return null;
	}
	public static function all(){
		$sql = "SELECT * FROM employees ORDER BY name";
		$db = Database::getConnection();
		$statement = $db->prepare($sql);
		$resp = $statement->execute();

		$employees = [];

		while($resp && $employee = $statement->fetch(PDO::FETCH_ASSOC)){
			$employees[] = new Employee($employee);
		}
		return $employees;
	}

	 public static function count() {
      $sql = "SELECT COUNT(*) FROM employees";

      $db = Database::getConnection();
      $statement = $db->prepare($sql);
      $statement->execute();

      return $statement->fetch()[0];
    }


}

?>