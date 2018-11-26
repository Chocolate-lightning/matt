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
 * @package tool_matt
 * @copyright 2018 Mathew May mathew@moodle.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/*function tool_matt_extend_navigation_course(navigation_node $parentnode, stdClass $course, context_course $context){
    global $CFG;

    $id = $context->instanceid;
    $urltext = 'MATT';
    $url = new moodle_url($CFG->wwwroot . '/grade/report/grader/index.php', array('id'=>1));
    //print_object($parentnode);
    $coursesettingsnode = $parentnode->find('courseadmin', null);   // 'courseadmin' is the menu key
    print_object($coursesettingsnode);
    $node = $coursesettingsnode->create($urltext, $url, navigation_node::NODETYPE_LEAF, null, 'gradebook',  new pix_icon('i/report', 'grades'));
    $coursesettingsnode->add_node($node,  'gradebooksetup'); //'gradebooksetup' is an where you put the link before
    }*/


function tool_matt_extend_navigation_course($navigation, $course, $context) {
    require_capability('tool/matt:view', $context);

    $feedback = $navigation->add(get_string('pluginname', 'tool_matt'));
    $url = new moodle_url('/admin/tool/matt/index.php', array('id' => $course->id));
    $feedback->add(get_string('view', 'core'), $url,
        navigation_node::TYPE_SETTING, null, null, new pix_icon('i/report', ''));

}