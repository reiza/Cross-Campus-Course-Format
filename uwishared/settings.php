<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Plugin administration pages are defined here.
 *
 * @package     format_uwishared
 * @category    admin
 * @copyright   2023 UWI OC
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings = new admin_settingpage('format_uwishared_settings', new lang_string('pluginname', 'format_uwishared'));

    // phpcs:ignore Generic.CodeAnalysis.EmptyStatement.DetectedIf
    if ($ADMIN->fulltree) {
        // TODO: Define actual plugin settings page and add it to the tree - {@link https://docs.moodle.org/dev/Admin_settings}.
        $settings->add(
			new admin_setting_configcheckbox('format_uwishared/ivlegacy',
				new lang_string('ivlegacy', 'format_uwishared'),
				'',
				0
			)
		);
	
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
                'CAV',
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
}
