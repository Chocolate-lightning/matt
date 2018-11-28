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
$url = new moodle_url('/admin/tool/matt/index.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_url($url);
$PAGE->set_pagelayout('report');
$PAGE->set_title('Hello to the matt list');
$PAGE->set_heading(get_string('pluginname', 'tool_matt'));

if ($deleteid = optional_param('delete', null, PARAM_INT)) {
    $record = $DB->get_record('tool_matt', ['id' => $deleteid], '*', MUST_EXIST);
    require_login(get_course($record->courseid));
    require_capability('tool/matt:edit', context_course::instance($record->courseid));
    if (confirm_sesskey() == true) {
        $DB->delete_records('tool_matt', ['id' => $deleteid]);
    }
    redirect(new moodle_url('/admin/tool/matt/index.php', ['courseid' => $record->courseid]));
}

$courseid = required_param('courseid', PARAM_INT);

require_login($courseid);

$context = context_course::instance($courseid);

require_capability('tool/matt:view', $context);

echo $OUTPUT->header();

echo html_writer::tag('p', get_string('hello', 'tool_matt'));

echo html_writer::tag('p', get_string('course', 'tool_matt', $courseid));

$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);

echo html_writer::div($course->summary);

$table = new \tool_matt\output\tool_matt_table($courseid);
$table->out(20, true);

if (has_capability('tool/matt:edit', $context, $USER)) {
    $editurl = new moodle_url('/admin/tool/matt/edit.php', ['courseid' => $courseid]);
    echo html_writer::link($editurl, get_string('editentry', 'tool_matt'), ['id' => 'tool_matt_edit']);
}

echo $OUTPUT->footer();