<?php
/**
* @package   format_uwishared
* @copyright OC Dev Team
*/
defined('MOODLE_INTERNAL') || die;
require_once($CFG->dirroot. '/course/format/singleactivity/settingslib.php');

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configtext('format_uwishared/m5url',
            new lang_string('smiurl', 'format_uwishared'),
            new lang_string('smiurldesc', 'format_uwishared'),
            '', PARAM_TEXT));
}
