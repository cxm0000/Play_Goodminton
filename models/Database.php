<?

class DbConnection
{
	private $_dbName = 'randomlu_goodminton';
	private $_dbUser = 'randomlu_ming';
	private $_dbPass = 'pling';
	private static $_instance = null;

	private function __construct(){
		
		self::$_instance = new mysqli('localhost', $this->_dbUser, $this->_dbPass, $this->_dbName);
	}
	
	 public static function getInstance(){
		
		if (!isset(self::$_instance))
			new DbConnection();
		
		return self::$_instance;
		
	}
	

}