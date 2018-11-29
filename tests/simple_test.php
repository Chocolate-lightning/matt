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
 * Tool Matt tests.
 *
 * @package    tool_matt
 * @category   phpunit
 * @copyright  2018 Mathew May {@link http://mathew.solutions}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/' . $CFG->admin .'/tool/matt/locallib.php');

/**
 * Tool Matt tests.
 *
 * @group      tool_matt
 * @package    tool_matt
 * @category   phpunit
 * @copyright  2018 Mathew May {@link http://mathew.solutions}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class tool_matt_simple_testcase extends advanced_testcase {
    public function test_upsert() {
        global $DB;
        $this->resetAfterTest(true);

        $course = $this->getDataGenerator()->create_course();

        $testobj = new stdClass();
        $testobj->name = 'test';
        $testobj->courseid = $course->id;
        $testobj->completed = true;
        tool_matt::upsert($testobj);

        // Check if the record exists.
        $this->assertNotEmpty($DB->get_record('tool_matt', ['courseid' => $course->id]));

        sleep(1);
        $testobj->completed = true;
        tool_matt::upsert($testobj);
        $record = $DB->get_record('tool_matt', ['courseid' => $course->id]);

        // Check if the record was updated by checking the time modified field.
        $this->assertNotSame($record->timecreated, $record->timemodified);
    }
}