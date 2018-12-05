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

$services = array(
    'mypluginservice' => array(                                                //the name of the web service
        'functions' => array ('tool_matt_create_groups', 'tool_matt_delete_records'), //web service functions of this service
        'requiredcapability' => '',                //if set, the web service user need this capability to access
        //any function of this service. For example: 'some/capability:specified'
        'restrictedusers' =>0,                                             //if enabled, the Moodle administrator must link some user to this service
        //into the administration
        'enabled'=>1,                                                       //if enabled, the service can be reachable on a default installation
    )
);

$functions = array(
    'tool_matt_create_groups' => array(         //web service function name
        'classname'   => 'tool_matt_external',  //class containing the external function
        'methodname'  => 'create_groups',          //external function name
        'classpath'   => 'admin/tool/matt/externallib.php',  //file containing the class/external function
        'description' => 'Creates new groups.',    //human readable description of the web service function
        'type'        => 'write',                  //database rights of the web service function (read, write)
    ),
    'tool_matt_delete_records' => array(         //web service function name
        'classname'   => 'tool_matt_external',  //class containing the external function
        'methodname'  => 'delete_records',          //external function name
        'classpath'   => 'admin/tool/matt/externallib.php',  //file containing the class/external function
        'description' => 'Delete requested records.',    //human readable description of the web service function
        'type'        => 'write',                  //database rights of the web service function (read, write)
    ),
);