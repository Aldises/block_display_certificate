<?php
/**
 * Version details
 *
 * @package    block_display_certificate
 * @copyright  2015 - Martin Tazlari (http://cyberlearn.hes-so.ch)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$capabilities = array(

        'block/simplehtml:myaddinstance' => array( // Give access to add myinstance
            'captype' => 'write',
            'contextlevel' => CONTEXT_SYSTEM,
            'archetypes' => array(
                'user' => CAP_ALLOW // to All users
            ),

            'clonepermissionsfrom' => 'moodle/my:manageblocks'
        ),

        'block/simplehtml:addinstance' => array( // Give access to add an instance
            'riskbitmask' => RISK_SPAM | RISK_XSS,

            'captype' => 'write',
            'contextlevel' => CONTEXT_BLOCK,
            'archetypes' => array(
                'editingteacher' => CAP_ALLOW, // only teachers and manager
                'manager' => CAP_ALLOW
            ),

            'clonepermissionsfrom' => 'moodle/site:manageblocks'


    ),
);
