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

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->dirroot . '/' . $CFG->admin . '/tool/matt/locallib.php');

global $DB;

$url = new moodle_url('/admin/tool/matt/edit.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_url($url);
$PAGE->set_pagelayout('report');
$PAGE->set_title('Hello to the matt list');
$PAGE->set_heading(get_string('pluginname', 'tool_matt'));

$id = optional_param('id', 0, PARAM_INT);

if ($id == 0) {
    $courseid = required_param('courseid', PARAM_INT);
} else {
    $record = $DB->get_record('tool_matt', ['id' => $id]);
    $courseid = $record->courseid;

    $obj = new stdClass();
    $obj->name = $record->name;
    $obj->courseid = $courseid;
    $obj->completed = $record->completed;

}

require_login($courseid);

$context = context_course::instance($courseid);

require_capability('tool/matt:edit', $context);


$mform = new \tool_matt\form\modify();

if ($id != 0) {
    $mform->set_data($obj);
}

// Form processing and displaying is done here.

if ($mform->is_cancelled()) {
    // Handle form cancel operation, if cancel button is present on form.
    return;
} else if ($fromform = $mform->get_data()) {
    // In this case you process validated data. $mform->get_data() returns data posted in form.

    $dataobj = $mform->get_data();

    tool_matt::upsert($dataobj);

    redirect(new moodle_url('/admin/tool/matt/index.php', ['courseid' => $dataobj->courseid]));

} else {
    // This branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
    // or on the first display of the form.

    // Set default data (if any).
    $mform->set_data($mform);
    // Displays the form.
    echo $OUTPUT->header();

    $mform->display();

    echo $OUTPUT->footer();
}

