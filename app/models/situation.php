<?php
class Situation extends Base {
	private $name;

	public function getName(){
		return $this->name;
	}

	public function setName($name){
		$this->name = $name;
	}


	public function all(){
		$sql = "SELECT * FROM situations ORDER BY id";
		$db = Database::getConnection();
		$statement = $db->prepare($sql);
		$resp = $statement->execute();

		$situations = [];
		while($resp && $situation = $statement->fetch(PDO::FETCH_ASSOC)){
			$situations[] = new Situation($situation);
		}
		return $situations;
	}

	public static function findById($id){
		$sql = "SELECT * FROM situations WHERE id = ?";
		$params = array($id);

		$db = Database::getConnection();
		$statement = $db->prepare($sql);
		$resp = $statement->execute($params);

		if ($resp && $row = $statement->fetch(PDO::FETCH_ASSOC)) {
			return new Situation($row);
		}

		return null;
	}
}
?>