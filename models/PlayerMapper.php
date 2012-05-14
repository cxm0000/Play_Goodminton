<?
class PlayerMapper
{
	const ERROR_USER_EXIST = 1001;
	
	private $_tblName = "players";
		
    public function save(Player $player)
	{

		if (null === ($id = $player->getId())) {
			//select before insert to prevent duplicates
			if(!$this->findPlayerByEmail($player->getEmail(), $player)) {
				$ret = DbConnection::getInstance()->query(
						"INSERT INTO " . $this->_tblName . 
						" (email,
							phone,
							name,
							created) VALUES (
							'" . $player->getEmail() . "',
							'" . $player->getPhone() . "',
							'" . $player->getName() . "',
							'" . date("Y-m-d H:i:s", time()) . "'
							)
						");

				if($ret === true) {
					$id = DbConnection::getInstance()->insert_id;
					$player->setId($id);
				} else {
					die("ERROR: insert failed....");
				}
			} else {
				//error code 
				echo self::ERROR_USER_EXIST;
				exit();
			}
		} else {
			DbConnection::getInstance()->query(
					"UPDATE FROM " . $this->_tblName . 
						" SET 
							email = '" . $player->getEmail() . "',
							phone = '" . $player->getPhone() . "',
							name = '" . $player->getName() . "'
						  WHERE
						  	id = " . $player->getId() . "
					");
		}
		
		return $player;
	}

   	public function find($id, Player $player)
	{
		$result = DbConnection::getInstance()->query(
					"SELECT 
						* 
					 FROM " . $this->_tblName . "
					 WHERE 
						id = " . $id . "
				");

		if (0 == count($result)) {
			return false;
		}
		
		$row = $result->fetch_object();
		$player->setId($row->id);
		$player->setEmail($row->email);
		$player->setPhone($row->phone);
		$player->setName($row->name);
				
		return $player;
	}
	
	public function findPlayerByEmail($email, Player $player)
	{
		$result = DbConnection::getInstance()->query(
					"SELECT 
						* 
					 FROM " . $this->_tblName . "
					 WHERE 
						email = '" . $email . "'
				");

		if (0 == count($result)) {
			return false;
		}
		
		$row = $result->fetch_object();
		$player->setId($row->id);
		$player->setEmail($row->email);
		$player->setPhone($row->phone);
		$player->setName($row->name);
				
		return $player;
	}

    public function fetchAll()
	{
		$resultSet = DbConnection::getInstance()->query("SELECT * FROM " . $this->_tblName);

		$entries   = array();
		while ($row = $resultSet->fetch_object()) {
			$entry = new Player();
			$entry->setId($row->id);
			$entry->setName($row->name);
			$entry->setPhone($row->phone);
			$entry->setEmail($row->email);
		//	$entry->setCreated($row->created);

			$entries[] = $entry;
		}
		return $entries;
	}

}