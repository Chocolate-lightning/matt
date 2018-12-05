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

require_once("$CFG->libdir/externallib.php");

class tool_matt_external extends external_api {
    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function create_groups_parameters() {
        return new external_function_parameters(
            array(
                'groups' => new external_multiple_structure(
                    new external_single_structure(
                        array(
                            'courseid' => new external_value(PARAM_INT, 'id of course'),
                            'name' => new external_value(PARAM_TEXT, 'multilang compatible name, course unique'),
                            'description' => new external_value(PARAM_RAW, 'group description text'),
                            'enrolmentkey' => new external_value(PARAM_RAW, 'group enrol secret phrase'),
                        )
                    )
                )
            )
        );
    }

    public static function create_groups_returns() {
        return new external_multiple_structure(
            new external_single_structure(
                array(
                    'id' => new external_value(PARAM_INT, 'group record id'),
                    'courseid' => new external_value(PARAM_INT, 'id of course'),
                    'name' => new external_value(PARAM_TEXT, 'multilang compatible name, course unique'),
                    'description' => new external_value(PARAM_RAW, 'group description text'),
                    'enrolmentkey' => new external_value(PARAM_RAW, 'group enrol secret phrase'),
                )
            )
        );
    }

    /**
     * Create groups
     * @param array $groups array of group description arrays (with keys groupname and courseid)
     * @return array of newly created groups
     */
    public static function create_groups($groups) {
        global $CFG, $DB;
        require_once("$CFG->dirroot/group/lib.php");

        $params = self::validate_parameters(self::create_groups_parameters(), array('groups' => $groups));

        // If an exception is thrown in the below code, all DB queries in this code will be rollback.
        $transaction = $DB->start_delegated_transaction();

        $groups = array();

        foreach ($params['groups'] as $group) {
            $group = (object)$group;

            if (trim($group->name) == '') {
                throw new invalid_parameter_exception('Invalid group name');
            }
            if ($DB->get_record('groups', array('courseid' => $group->courseid, 'name' => $group->name))) {
                throw new invalid_parameter_exception('Group with the same name already exists in the course');
            }

            // Now security checks.
            $context = get_context_instance(CONTEXT_COURSE, $group->courseid);
            self::validate_context($context);
            require_capability('moodle/course:managegroups', $context);

            // Finally create the group.
            $group->id = groups_create_group($group, false);
            $groups[] = (array)$group;
        }

        $transaction->allow_commit();

        return $groups;
    }

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function delete_records_parameters() {
        return new external_function_parameters(
            array(
                'records' => new external_multiple_structure(
                    new external_single_structure(
                        array(
                            'recordid' => new external_value(PARAM_INT, 'id of record to delete'),
                        )
                    )
                )
            )
        );
    }

    public static function delete_records_returns() {
        return new external_multiple_structure(
            new external_single_structure(
                array(
                    'recordid' => new external_value(PARAM_INT, 'id of record to delete'),
                )
            )
        );
    }

    /**
     * Delete records
     * @param array $groups array of group description arrays (with keys groupname and courseid)
     * @return array of newly created groups
     */
    public static function delete_records($foo) {
        global $CFG, $DB;

        $params = self::validate_parameters(self::delete_records_parameters(), array('records' => $foo));

        // If an exception is thrown in the below code, all DB queries in this code will be rollback.
        $transaction = $DB->start_delegated_transaction();

        $records = array();

        foreach ($params['records'] as $record) {
            $record = (object)$record;

            $records[] = (array)$record;
        }

        $transaction->allow_commit();

        return $records;
    }
}