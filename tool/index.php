<?php

$service = $_REQUEST['service'];
$userid = $_REQUEST['id'];

require_once('./../tool/'.$service.'.php');
