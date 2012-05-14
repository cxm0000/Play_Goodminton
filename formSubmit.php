<?
	defined('APPLICATION_PATH')
    || define('APPLICATION_PATH',
              realpath(dirname(__FILE__) . '/models'));
  
 
	include_once(APPLICATION_PATH . '/Database.php');
	include_once(APPLICATION_PATH . '/Player.php');
	include_once(APPLICATION_PATH . '/PlayerMapper.php');
	include_once(APPLICATION_PATH . '/Event.php');
	include_once(APPLICATION_PATH . '/EventMapper.php');
	
	
	
if($_REQUEST['name']) {

	$name = $_REQUEST['name'];
	$email = $_REQUEST['email'];
	$phone = $_REQUEST['phone'];

	$player = new Player();
	$player->setName($name);
	$player->setEmail($email);
	$player->setPhone($phone);
			
	$mapper = new PlayerMapper();
	$player = $mapper->save($player);
	
	$data = array(
		'id' => $player->getId(),
		'name' => $player->getName(),
		'email' => $player->getEmail()
	);

	echo json_encode($data);
} elseif($_REQUEST['event_name']) {
	$name = $_REQUEST['event_name'];
	$time = $_REQUEST['time'];
	$place = $_REQUEST['place'];
	$extraInfo = $_REQUEST['info'];

	$event = new Event();
	$event->setName($name);
	$event->setTime($time);
	$event->setLocation($place);
	$event->setExtraInfo($extraInfo);
			
	$mapper = new EventMapper();
	$event = $mapper->save($event);
	
	$data = array(
		'id' => $event->getId(),
		'name' => $event->getName(),
		'email' => $player->getEmail()
	);

	echo json_encode($data);
} else {
	echo false;
}
