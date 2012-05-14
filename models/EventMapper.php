<?
class EventMapper
{
	private $_tblName = "events";
		
    public function save(Event $event)
	{

		if (null === ($id = $event->getId())) {
			//TODO:select before insert new
			$ret = DbConnection::getInstance()->query(
					DbConnection::getInstance()->real_escape_string(
					"INSERT INTO " . $this->_tblName . 
					" (name,
						time,
						location,
						extrainfo,
						created) VALUES (
						'" . $event->getName() . "',
						'" . $event->getTime() . "',
						'" . $event->getLocation() . "',
						'" . $event->getExtraInfo() . "',
						'" . date("Y-m-d H:i:s", time()) . "'
						)
					"));

			if($ret === true) {
				$id = DbConnection::getInstance()->insert_id;
				$event->setId($id);
			} else {
				die("ERROR: insert failed.... -- " . DbConnection::getInstance()->error);
			}
		} else {
			DbConnection::getInstance()->query(
					"UPDATE FROM " . $this->_tblName . 
						" SET 
							name = '" . $event->getName() . "',
							time = '" . $event->getTime() . "',
							extrainfo = '" . $event->getExtraInfo() . "',
							location = '" . $event->getLocation() . "'
						  WHERE
						  	id = " . $event->getId() . "
					");
		}
		
		return $event;
	}

   	public function find($id, Event $event)
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
		$event->setId($row->id);
		$event->setName($row->name);
		$event->setTime($row->time);
		$event->setExtraInfo($row->extrainfo);
		$event->setLocation($row->location);
		
		//find its confirmed players if there are any
		return $this->_getJoinedPlayers($event);
	}

    public function fetchAll()
	{
		$resultSet = DbConnection::getInstance()->query("SELECT * FROM " . $this->_tblName);

		$events   = array();
		while ($row = $resultSet->fetch_object()) {
			$event = new Event();
			$event->setId($row->id);
			$event->setName($row->name);
			$event->setExtraInfo($row->extrainfo);
			$event->setLocation($row->location);
			$event->setTime($row->time);
		//	$entry->setCreated($row->created);
			
			//find its confirmed players if there are any
			$event = $this->_getJoinedPlayers($event);
			
			$events[] = $event;
		}
		return $events;
	}
	
	//TODO: return more future coming events
	public function getComingEvent()
	{
		$result = DbConnection::getInstance()->query(
					"SELECT 
						id 
					 FROM " . $this->_tblName . "
					 WHERE 
						created > NOW() LIMIT 1
				");

		if (0 < $result->num_rows) {
			$row = $result->fetch_object();

			$event = new Event();
			$event = $this->find($row->id, $event);
				
			return $event;

		}
		
		return false;
	}
	
	private function _getJoinedPlayers(Event $event)
	{
		$result = DbConnection::getInstance()->query(
					"SELECT 
						player_id 
					 FROM event_player
					 WHERE 
						event_id = " . $event->getId() . "
				");

		if (0 < count($result)) {
			$players = array();
			foreach($result->fetch_object() as $row) {
				$players[] = $row->player_id;
			}
			
			$event->setJoinedPlayers($players);
		}
		return $event;
	}
}