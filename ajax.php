<?
	defined('APPLICATION_PATH')
    || define('APPLICATION_PATH',
              realpath(dirname(__FILE__) . '/models'));
  
 
	include_once(APPLICATION_PATH . '/Database.php');
	include_once(APPLICATION_PATH . '/Player.php');
	include_once(APPLICATION_PATH . '/PlayerMapper.php');
	include_once(APPLICATION_PATH . '/Event.php');
	include_once(APPLICATION_PATH . '/EventMapper.php');
	
if($_REQUEST['action']) {
	$eventMapper = new EventMapper();
	
	$action = $_REQUEST['action'];
	$dataArray = $_REQUEST['ids'];
	$event = $eventMapper->find($_REQUEST['event'][0], new Event());

	$subject = 'Goodminton!';
	$headers = 'From: noreply@goodminton.com';
	$body = "
	Hej!
	
	We have booked a Goodminton time tonight! Please join us! The details are listed below:
	
	Time: " . $event->getTime() . "\n\r
	Place: " . $event->getLocation() . "\n\r
	Info: " . $event->getExtraInfo() . "\n\r
			
	";
	
	
	$mapper = new PlayerMapper();
	foreach($dataArray as $index => $subArray) {
		$playerId = (int) $subArray['id'];
		$player = $mapper->find($playerId, new Player());
		
		if(mail($player->getEmail(), $subject, $body, $headers)) {
			//then we insert this invited user into DB
			
		}
		
	}
	//sucess!
	 echo 200;
}