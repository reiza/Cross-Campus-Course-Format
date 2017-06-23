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

defined( 'MOODLE_INTERNAL' ) || die( );

class format_uwishared_renderer extends plugin_renderer_base
{

    public function display( $course ) {
        global $CFG;

        $courserenderer = $this->page->get_renderer( 'core', 'course' );
        $baseurl  = get_config( 'format_uwishared' )->smiurl;
        $key = get_config( 'format_uwishared' )->smikey;
        $param    = substr( uniqid(), -1 );
        $package = new crypto_for_uwi_shared($key);
        $meshdata   = $this->get_uwi_shared_exchange_data( $course );

        //$redirecturl = $baseurl . "/auth/ocauth/acs.php?$param=" . $package->wrap( $course );
        $redirecturl = $baseurl . "/login/index.php?$param=" . $package->wrap( $meshdata );

        if ( !is_siteadmin() && strlen( $redirecturl ) < 2084 ) {
            redirect( $redirecturl );
        } else if ( strlen( $redirecturl ) > 2083 ) {
            $output = '<form method="post" action="'
                . $baseurl
                . '/login/index.php"><input type="hidden" name="p'
                . $param
                . '" value = "'
                . $package->wrap( $course )
                . '"/>'
                . '<button name="submit" id="submit" type="submit" class="btn btn-primary">'
                . 'Go to the shared course'
                . '</button>'
                . '</form>';
        } else {
            $output = '<a class="btn btn-lg btn-primary" style="margin:20px;color:#fff" href="'
                . $redirecturl
                . '">Go to the shared course</a>';
        }
        return $output;
    }

    public function get_uwi_shared_exchange_data( $course ) {
        global $CFG;
        $data = new StdClass();
        $data->a = $this->get_uwi_shared_user();
        $data->b = get_config( 'format_uwishared' )->smimappingcampusid;
        $data->d = $CFG->wwwroot;
        $data->e = $this->get_uwi_shared_enrol();
        $data->t = time();
        $data->c = course_get_format($course)->get_course()->smicourseid;

        return $data;
    }

    private function get_uwi_shared_user( ) {
        global $USER, $DB;
        return $DB->get_record( 'user', array('id' => $USER->id),
            'username AS a, idnumber AS b, firstname AS c, lastname  AS d, email AS e,
            institution AS f, department AS g, city AS h, country AS i, timezone AS j' );
    }

    private function get_uwi_shared_enrol( ) {
        global $USER, $DB;
        $enrolment = false;
        $o->xrns   = array( );

        $sql = "SELECT u.username, c.shortname AS remotecourseshortname,
                r.id AS remoteroleid, r.name AS remoterolename, r.shortname AS remoteroleshortname, cfo.value AS smicourseid
                FROM {role_assignments} ra
                JOIN {user} u ON ra.userid = u.id
                JOIN {context} ctx ON ra.contextid = ctx.id
                JOIN {course} c ON ctx.instanceid=c.id
                JOIN {role} r ON ra.roleid=r.id
                JOIN {course_format_options} cfo ON cfo.courseid=c.id AND cfo.name='smicourseid'
                WHERE u.id = ?";

        $enrolment = $DB->get_records_sql( $sql, array($USER->id) );

        if ( $enrolment ) {
            foreach ($enrolment as $user => $enrols) {
                $xrns[$enrols->smicourseid] = $enrols->remoteroleid;
            }
        }
        return $xrns;
    }

}

class crypto_for_uwi_shared {
    private $encryptmethod = "AES-256-CBC";
    private $key;
    private $iv;

    public function __construct($key) {
        $this->key = hash( 'sha256', $key );
        $this->iv  = substr( hash( 'sha256', '' ), 0, 16 );
    }

    public function wrap( $z ) {
        $z = json_encode( $z );
        $z = openssl_encrypt( $z, $this->encryptmethod, $this->key, 0, $this->iv );
        $z = base64_encode( $z );
        return $z;
    }

    public function unwrap( $z ) {
        $z = base64_decode( $z );
        $z = openssl_decrypt( $z, $this->encrypt_method, $this->key, 0, $this->iv );
        $z = json_decode( $z );
        return $z;
    }
}