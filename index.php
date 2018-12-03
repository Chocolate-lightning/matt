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
 * @copyright 2018 Mathew May {@link http://mathew.solutions}
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../config.php');

use tool_matt\output\page_agreedocs;

$courseid = required_param('courseid', PARAM_INT);

$PAGE->set_context(\context_course::instance($courseid));
$output = $PAGE->get_renderer('tool_matt');
$outputpage = new \tool_matt\output\page_index($courseid);

echo $output->header();
echo $output->render($outputpage);

$table = new \tool_matt\output\tool_matt_table($courseid);
$table->out(20, true);

echo $output->footer();