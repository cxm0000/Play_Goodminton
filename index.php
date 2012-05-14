<?php
	ini_set("display_errors", 1);

	defined('APPLICATION_PATH')
    || define('APPLICATION_PATH',
              realpath(dirname(__FILE__) . '/models'));
  
 
	include_once(APPLICATION_PATH . '/Database.php');
	include_once(APPLICATION_PATH . '/Player.php');
	include_once(APPLICATION_PATH . '/PlayerMapper.php');
	include_once(APPLICATION_PATH . '/Event.php');
	include_once(APPLICATION_PATH . '/EventMapper.php');
	
	include_once('sitedown.html');
//	include_once('index.phtml');

	//header('Location:index.phtml');