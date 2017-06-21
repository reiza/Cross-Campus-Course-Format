<?php
/**
* @package    format_uwishared
* @copyright OC Dev Team
*/
defined('MOODLE_INTERNAL') || die;

$courserenderer = $PAGE->get_renderer('format_uwishared');
echo $courserenderer->display($course);
