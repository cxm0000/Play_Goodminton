<?

class Event
{

  	protected $_id;
  	protected $_name;
    protected $_time;
    protected $_location;
    protected $_extraInfo;
    protected $_created;
    
    protected $_joinedPlayers = array();

    public function getId()
    {
    	return $this->_id;
    }
    
    public function getName()
    {
    	return $this->_name;
    }
    
    public function getTime()
    {
    	return $this->_time;
    }
    
    public function getExtraInfo()
    {
    	return $this->_extraInfo;
    }
    
    public function getLocation()
    {
    	return $this->_location;
    }
    
    public function setId($id)
    {
		$this->_id = (int)$id;
    }
    
    public function setName($name)
    {
    	$this->_name = $name;
    }
    
    public function setTime($time)
    {
		$this->_time = $time;
    }
    
    public function setExtraInfo($info)
    {
		$this->_extraInfo = $info;
    }
    
    public function setLocation($loc)
    {
		$this->_location = $loc;
    }
    
    public function getJoinedPlayers()
    {
    	return $this->_joinedPlayers;
    }
    
    public function setJoinedPlayers(array $joinedPlayers)
    {
    	$this->_joinedPlayers = $joinedPlayers;
    }
    
}