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

require_once("$CFG->libdir/externallib.php");

class tool_matt_external extends external_api {
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
    public static function delete_records($inrecords) {
        global $DB;

        $params = self::validate_parameters(self::delete_records_parameters(), array('records' => $inrecords));

        // If an exception is thrown in the below code, all DB queries in this code will be rollback.
        $transaction = $DB->start_delegated_transaction();

        $records = array();

        foreach ($params['records'] as $record) {
            $record = (object)$record;

            if (!$DB->record_exists('tool_matt', array('id' => $record->recordid))) {
                throw new invalid_parameter_exception('Record not found. Did you pass the correct item id?');
            }

            $item = $DB->get_record('tool_matt', array('id' => $record->recordid));

            // Now security checks.
            $context = context_course::instance($item->courseid);
            self::validate_context($context);
            require_capability('tool/matt:edit', $context);

            $event = \tool_matt\event\item_deleted::create(array('context' => $context, 'objectid' => $record->recordid));
            $event->trigger();

            $records[] = (array)$record;
        }

        $transaction->allow_commit();

        return $records;
    }

    public static function delete_records_is_allowed_from_ajax() {
        return true;
    }
}