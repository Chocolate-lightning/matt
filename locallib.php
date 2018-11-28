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
 * Tool Matt locallib.
 *
 * @package    tool_matt
 * @category   phpunit
 * @copyright  2018 Mathew May {@link http://mathew.solutions}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class tool_matt {
    /**
     * @param $dataobj
     */
    public static function upsert($dataobj) {
        global $DB;
        $courserecords = $DB->get_records('tool_matt', ['courseid' => $dataobj->courseid]);

        $found = false;
        foreach ($courserecords as $courserecord) {
            if (strtolower($courserecord->name) === strtolower($dataobj->name)) {
                $record = $courserecord;
                $found = true;
            }
        }

        if ($found) {
            $record->completed = $dataobj->completed;
            $record->timemodified = time();
            $DB->update_record('tool_matt', $record);
        } else {
            $insertobj = new stdClass();
            $insertobj->name = $dataobj->name;
            $insertobj->courseid = $dataobj->courseid;
            $insertobj->completed = $dataobj->completed;
            $insertobj->timecreated = time();
            $insertobj->timemodified = time();
            $DB->insert_record('tool_matt', $insertobj);
        }
    }

    /**
     * @throws coding_exception
     * @throws dml_exception
     * @throws moodle_exception
     * @throws require_login_exception
     * @throws required_capability_exception
     */
    public static function delete() {
        global $DB;
        if ($deleteid = optional_param('delete', null, PARAM_INT)) {
            $record = $DB->get_record('tool_matt', ['id' => $deleteid], '*', MUST_EXIST);
            require_login(get_course($record->courseid));
            require_capability('tool/matt:edit', context_course::instance($record->courseid));
            if (confirm_sesskey() == true) {
                $DB->delete_records('tool_matt', ['id' => $deleteid]);
            }
            redirect(new moodle_url('/admin/tool/matt/index.php', ['courseid' => $record->courseid]));
        }
    }
}