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
 * @package    tool_matt
 * @copyright  2018 Mathew May {@link http://mathew.solutions}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$services = array(
    // The name of the web service.
    'mypluginservice' => array(
        // Web service functions of this service.
        'functions' => array ('tool_matt_create_groups', 'tool_matt_delete_records'),
        // If set, the web service user need this capability to access.
        'requiredcapability' => '',
        // Any function of this service. For example: 'some/capability:specified'.
        // If enabled, the Moodle administrator must link some user to this service.
        'restrictedusers' => 0,
        // Into the administration.
        // If enabled, the service can be reachable on a default installation.
        'enabled' => 1,
    )
);

$functions = array(
    'tool_matt_create_groups' => array(         // Web service function name.
        'classname'   => 'tool_matt_external',  // Class containing the external function.
        'methodname'  => 'create_groups',          // External function name.
        'classpath'   => 'admin/tool/matt/externallib.php',  // File containing the class/external function.
        'description' => 'Creates new groups.',    // Human readable description of the web service function.
        'type'        => 'write',                  // Database rights of the web service function (read, write).
    ),
    'tool_matt_delete_records' => array(         // Web service function name.
        'classname'   => 'tool_matt_external',  // Class containing the external function.
        'methodname'  => 'delete_records',          // External function name.
        'classpath'   => 'admin/tool/matt/externallib.php',  // File containing the class/external function.
        'description' => 'Delete requested records.',    // Human readable description of the web service function.
        'type'        => 'write',                  // Database rights of the web service function (read, write).
    ),
);