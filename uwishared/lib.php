<?php
/**
* @package   format_uwishared
* @copyright OC Dev Team
*/
defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot. '/course/format/lib.php');

class format_uwishared extends format_base {

  public function get_view_url($section, $options = array()) {
    return null;
  }

  public function extend_course_navigation($navigation, navigation_node $node) { }

  public function get_default_blocks() {
    return array(
      BLOCK_POS_LEFT => array(),
      BLOCK_POS_RIGHT => array()
    );
  }


  public function course_format_options($foreditform = false) {
    static $courseformatoptions = false;
    if ($courseformatoptions === false) {
      $courseformatoptions = array(
        'm5mappingcourseid' => array(
          'default' => '',
          'type' => PARAM_TEXT,
        ),
        'm5mappingcampusid' => array(
          'default' => '',
          'type' => PARAM_TEXT,
        ),

      );
    }

    if ($foreditform && !isset($courseformatoptions['m5mappingcourseid']['label'])) {
      $courseformatoptionsedit = array(
        'm5mappingcourseid' => array(
          'label' => new lang_string('m5mappingcourseid', 'format_uwishared'),
          'help' => 'm5mappingcourseid',
          'help_component' => 'format_uwishared',
          'element_type' => 'select',
          'element_attributes' => array(
            //Mock values for now
            array(
              'XYZ123' => 'UWIS0001 Our First Shared Course',
              'U230' => 'FOUN1101 Caribbean Civilisation',
              'U235' => 'MATH2002 Proofs and Analytical Methods',
              'U238' => 'LAW3400 Advanced Law of Torts'
            )
          ),
        ),
        'm5mappingcampusid' => array(
          'label' => new lang_string('m5mappingcampusid', 'format_uwishared'),
          'help' => 'm5mappingcampusid',
          'help_component' => 'format_uwishared',
          'element_type' => 'select',
          'element_attributes' => array(
            array(
              'CAV' => 'Cave Hill',
              'MON' => 'Mona',
              'OC' => 'Open Campus',
              'STA' => 'St. Augustine'
            )
          ),
          )
        );
        $courseformatoptions = array_merge_recursive($courseformatoptions, $courseformatoptionsedit);
      }
      return $courseformatoptions;
    }

    public function page_set_course(moodle_page $page) {
      global $CFG, $COURSE;
      require_once($CFG->dirroot. '/course/format/uwishared/tool/crypto.php');
      $baseUrl = get_config('format_uwishared')->m5url;

      $course = course_get_format($COURSE)->get_course();
      $package = new CryptoForUWISharedCourse();
      $param = substr(uniqid(),-1);

      $redirectUrl = $baseUrl ."/auth/ocauth/acs.php?$param=" . $package->wrap($course);
      if (!is_siteadmin()) {
        redirect($redirectUrl);
      }
    }

  }
