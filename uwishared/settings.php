<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package format_uwishared
 * @copyright OC Dev Team
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;
require_once($CFG->dirroot . '/course/format/singleactivity/settingslib.php');

if ($ADMIN->fulltree) {

    $settings->add(
        new admin_setting_configtext('format_uwishared/smiurl',
            new lang_string('smiurl', 'format_uwishared'),
            new lang_string('smiurldesc', 'format_uwishared'),
            '',
            PARAM_TEXT
        )
    );
    $settings->add(
        new admin_setting_configtext('format_uwishared/smikey',
            new lang_string('smikey', 'format_uwishared'),
            new lang_string('smikeydesc', 'format_uwishared'),
            '',
            PARAM_TEXT
        )
    );
    $settings->add(
        new admin_setting_configselect('format_uwishared/smimappingcampusid',
            new lang_string('smimappingcampusid', 'format_uwishared'),
            new lang_string('smimappingcampusiddesc', 'format_uwishared'),
            '',
            array(
                'CAV' => 'Cave Hill',
                'MON' => 'Mona',
                'OC' => 'Open Campus',
                'STA' => 'St. Augustine',
                'XCM' => 'Cross Campus Moodle'
            )
        )
    );
}