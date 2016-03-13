<?php
class Priority extends Base {
	private $name;

	public function getName(){
		return $this->name;
	}

	public function setName($name){
		$this->name = $name;
	}


	public function all(){
		$sql = "SELECT * FROM priorities ORDER BY id";
		$db = Database::getConnection();
		$statement = $db->prepare($sql);
		$resp = $statement->execute();

		$priorities = [];
		while($resp && $priority = $statement->fetch(PDO::FETCH_ASSOC)){
			$priorities[] = new Priority($priority);
		}
		return $priorities;
	}

	public static function findById($id){
		$sql = "SELECT * FROM priorities WHERE id = ?";
		$params = array($id);

		$db = Database::getConnection();
		$statement = $db->prepare($sql);
		$resp = $statement->execute($params);

		if ($resp && $row = $statement->fetch(PDO::FETCH_ASSOC)) {
			return new Priority($row);
		}

		return null;
	}
}
?>