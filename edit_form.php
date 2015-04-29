<?php

/**
 * Version details
 *
 * @package    block_display_certificate
 * @copyright  2015 - Martin Tazlari (http://cyberlearn.hes-so.ch)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/*
 * File for the block settings
 */

class block_display_certificate_edit_form extends block_edit_form {

    protected function specific_definition($mform) {

        // Section header title according to language file.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block_display_certificate')); // Add a field to set the number of certificate to display

        $numberofcertificate = array('0' => get_string('all'));
        for ($i = 1; $i <= 10; $i++) { // Create a list of 10 numbers (by default the 0 = all)
            $numberofcertificate[$i] = $i;
        }

        $mform->addElement('select', 'config_numberofcertificate', get_string('numcertificatetodisplay', 'block_display_certificate'), $numberofcertificate);
        $mform->setDefault('config_numberofcertificate', 3);



    }
}
