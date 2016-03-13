<?php
class City extends Base{
	private $name;
	private $states_id;

	public function getName(){return $this->name;	}
	public function setName($name){$this->name = $name;}
	public function getStatesId(){return $this->states_id;	}
	public function setStatesId($states_id){$this->states_id = $states_id;}
	public function getState(){
		return State::findById($states_id);
	}

	public static function all(){
		$sql = "SELECT * FROM cities ORDER BY name";
		$db = Database::getConnection();
		$statement = $db->prepare($sql);
		$resp = $statement->execute();

		$cities = [];

		while($resp && $city = $statement->fetch(PDO::FETCH_ASSOC)){
			$cities[] = new City($city);
		}
		return $cities;
	}

	public static function citiesLikeAsJson($uf) {
      $sql = "SELECT * FROM cities 
        WHERE states_id = ?
        ORDER BY name";

      $params = array($uf);

      $db = Database::getConnection();
      $statement = $db->prepare($sql);
      $resp = $statement->execute($params);

      $suggestions = array('suggestions' => '');

      while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $city = array('value' => $row['name'], 'data' => $row['id']);
        $suggestions['suggestions'][] = $city;
      }

      return json_encode($suggestions);
    }

    public static function findById($id){
		$sql = "SELECT * FROM cities WHERE id = ?";
		$params = array($id);

		$db = Database::getConnection();
		$statement = $db->prepare($sql);
		$resp = $statement->execute($params);

		if ($resp && $row = $statement->fetch(PDO::FETCH_ASSOC)) {
			return new City($row);
		}

		return null;
	}
}

?>