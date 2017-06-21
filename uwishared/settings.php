<?php
/**
* @package    format_uwishared
* @copyright OC Dev Team
*/
defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot. '/course/format/singleactivity/settingslib.php');

if ($ADMIN->fulltree) {

    $settings->add(new admin_setting_configtext(
        'format_uwishared/smiurl',
        new lang_string('smiurl', 'format_uwishared'),
        new lang_string('smiurldesc', 'format_uwishared'),
        '', PARAM_TEXT
    ));

    $settings->add(new admin_setting_configselect(
        'format_uwishared/smimappingcampusid',
        new lang_string('smimappingcampusid', 'format_uwishared'),
        new lang_string('smimappingcampusiddesc', 'format_uwishared'),
        '',
        array( 'CAV' => 'Cave Hill', 'MON' => 'Mona', 'OC' => 'Open Campus', 'STA' => 'St. Augustine', 'XCM' => 'Cross Campus Moodle' )
    ));
    
}
