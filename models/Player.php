<?

class Player
{

  	protected $_id;
    protected $_name;
    protected $_email;
    protected $_phone;
    protected $_created;

    public function getId()
    {
    	return $this->_id;
    }
    
    public function getName()
    {
    	return $this->_name;
    }
    
    public function getEmail()
    {
    	return $this->_email;
    }
    
    public function getPhone()
    {
    	return $this->_phone;
    }
    
    public function setId($id)
    {
		$this->_id = (int)$id;
    }
    
    public function setName($name)
    {
		$this->_name = $name;
    }
    
    public function setPhone($phone)
    {
		$this->_phone = $phone;
    }
    
    public function setEmail($email)
    {
		$this->_email = $email;
    }
    
}