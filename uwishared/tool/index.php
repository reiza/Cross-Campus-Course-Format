<?php
/**
* @package   format_uwishared
* @copyright OC Dev Team
*/
$service = $_REQUEST['service'];
$userid = $_REQUEST['id'];

require_once('./../tool/'.$service.'.php');
