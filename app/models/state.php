<?php
class State extends Base{
	private $acronym;

	public function getAcronym(){return $this->acronym;	}
	public function setAcronym($acronym){$this->acronym = $acronym;}

	public static function all(){
		$sql = "SELECT * FROM states ORDER BY acronym";
		$db = Database::getConnection();
		$statement = $db->prepare($sql);
		$resp = $statement->execute();

		$states = [];

		while($resp && $state = $statement->fetch(PDO::FETCH_ASSOC)){
			$states[] = new State($state);
		}
		return $states;
	}

	public static function findById($id){
		$sql = "SELECT * FROM states WHERE id = ?";
		$params = array($id);

		$db = Database::getConnection();
		$statement = $db->prepare($sql);
		$resp = $statement->execute($params);

		if ($resp && $row = $statement->fetch(PDO::FETCH_ASSOC)) {
			return new State($row);
		}

		return null;
	}

}

?>