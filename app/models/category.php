<?php 
class Category extends Base {
	private $description;


	public function setDescription($desc){
		$this->description = $desc;
	}

	public function getDescription(){
		return $this->description;
	}

	public static function findById($id){
		$sql = "SELECT * FROM categories WHERE id = ?";
		$params = array($id);

		$db = Database::getConnection();
		$statement = $db->prepare($sql);
		$resp = $statement->execute($params);

		if ($resp && $row = $statement->fetch(PDO::FETCH_ASSOC)) {
			return new Category($row);
		}

		return null;
	}

	public function all(){
		$sql = "SELECT * FROM categories ORDER BY description";
		$db = Database::getConnection();
		$statement = $db->prepare($sql);
		$resp = $statement->execute();

		$category = [];

		while($resp && $category = $statement->fetch(PDO::FETCH_ASSOC)){
			$categories[] = new Category($category);
		}
		return $categories;
	}

} ?>