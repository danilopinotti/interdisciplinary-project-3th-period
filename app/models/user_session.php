<?php
class UserSession extends Base {
		private $email;
		private $password;

		public function getEmail(){
			return $this->email;
		}

		public function setEmail($email){
			$this->email = $email;
		}

		public function setPassword($password){
			$this->password = $password;
		}

		public function isAuthenticate(){
			$sql = "SELECT id, name FROM employees WHERE (email = ? AND password = ?)";
			$params = array($this->email, sha1($this->password));

			$db = Database::getConnection();
			$statement = $db->prepare($sql);
			$resp = $statement->execute($params);

			$user = $statement->fetch(PDO::FETCH_ASSOC);
			if (isset($user['name'])) {
				$_SESSION['user']['id'] = $user['id'];
			    $_SESSION['user']['name'] = $user['name'];
			    return true;
			}

			$_SESSION['invalidemail'] = $this->email;
			return false;
		}

		public static function logout(){
			unset($_SESSION['user']);
		}
}
?>