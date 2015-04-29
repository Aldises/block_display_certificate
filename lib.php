<?php
/**
 * Version details
 *
 * @package    block_display_certificate
 * @copyright  2015 - Martin Tazlari (http://cyberlearn.hes-so.ch)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


function get_user_certificate($certificatenb){
    global $DB, $CFG, $USER ;

    $content = '' ;

    // Get All user certificate
    if($certificatenb==0){ // Get All Certificate
        $param = array($USER->id) ;
        $query = "SELECT * FROM {certificate} AS c INNER JOIN {certificate_issues} AS ci ON c.id = ci.certificateid WHERE ci.userid = ? ORDER BY ci.timecreated DESC ";
        $certif = $DB->get_records_sql($query,$param);
    }else { // Get limited certificate
        $param = array($USER->id) ;
        $query = "SELECT * FROM {certificate} AS c INNER JOIN {certificate_issues} AS ci ON c.id = ci.certificateid WHERE ci.userid = ? ORDER BY ci.timecreated DESC limit ".$certificatenb;
        $certif = $DB->get_records_sql($query,$param);
    }


    // Create object table form query request


    if($certif){

        // Headers
        $content.= HTML_WRITER::start_tag('table', array('cellpadding'=>'5')) ;


            $content.= HTML_WRITER::start_tag('tr') ;

        $content.= HTML_WRITER::empty_tag('td') ;


                $content.= HTML_WRITER::start_tag('td') ;
                    $content.= HTML_WRITER::start_tag('b') ;
                        $content .= get_string('certificatename', 'block_display_certificate');
                    $content.= HTML_WRITER::end_tag('b') ;
                $content.= HTML_WRITER::end_tag('td') ;

                $content.= HTML_WRITER::start_tag('td') ;
                    $content.= HTML_WRITER::start_tag('b') ;
                     $content .= get_string('coursename', 'block_display_certificate');
                    $content.= HTML_WRITER::end_tag('b') ;
                $content.= HTML_WRITER::end_tag('td') ;
        $content.= HTML_WRITER::end_tag('tr') ;


        // Get Certificate Module id (helpful for having the activity id to link the certificate)
        $param = array("certificate") ;
        $query = "SELECT id FROM {modules} WHERE name = ?";
        $moduleNb = $DB->get_fieldset_sql($query,$param);
        $moduleNb = $moduleNb[0];



        foreach($certif as $certificate){
            $i = 0 ;
            $value[$i] = $certif[$certificate->id];
            $value[$i]->certificateid = $certificate->certificateid ;
            $value[$i]->name = $certificate->name ;
            $value[$i]->course = $certificate->course ;

            $content.= HTML_WRITER::start_tag('tr') ;

            // Get the module it from the certificate
            $param = array($value[$i]->course,$moduleNb, $value[$i]->certificateid) ;
            $query = "SELECT id FROM {course_modules} WHERE course = ? AND module = ? AND instance = ?";
            $moduleid = $DB->get_fieldset_sql($query,$param);
            $moduleid = $moduleid[0];
            $content.= HTML_WRITER::start_tag('td') ;
            $content .= HTML_WRITER::start_tag('img', array('src' => new moodle_url('/blocks/display_certificate/pix/certificate.png')));
            $content .= HTML_WRITER::end_tag('img');
            $content.= HTML_WRITER::end_tag('td') ;

                $content.= HTML_WRITER::start_tag('td') ;
                    $content .= HTML_WRITER::link(new moodle_url('/mod/certificate/view.php?id='.$moduleid), substr($value[$i]->name,0,15));
                        if(strlen(substr($value[$i]->name,0,15))>=15){
                            $content.='...';
                        }
                $content.= HTML_WRITER::end_tag('td') ;

            // Course name
            $param = array($value[$i]->course) ;
            $query = "SELECT shortname FROM {course} WHERE id = ?";
            $coursename = $DB->get_fieldset_sql($query,$param);
            $coursename = $coursename[0];


                $content.= HTML_WRITER::start_tag('td') ;
                    $content.= HTML_WRITER::link(new moodle_url('/course/view.php?id='.$value[$i]->course), substr($coursename,0,15));
                    if(strlen(substr($coursename,0,15))>=15){
                        $content.='...';
                    }
                    $content.= HTML_WRITER::end_tag('td') ;

            $content.= HTML_WRITER::end_tag('tr') ;

        }

        $content.= HTML_WRITER::end_tag('table') ;



    }else {
        $content = "No certificate";
    }



    return $content ;

}