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
 * @package   tool_matt
 * @copyright 2018 Mathew May {@link http://mathew.solutions}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

function xmldb_tool_matt_upgrade($oldversion) {
    global $DB;
    $dbman = $DB->get_manager();

    if ($oldversion < 2018112604) {

        // Define table tool_matt to be created.
        $table = new xmldb_table('tool_matt');

        // Adding fields to table tool_matt.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('courseid', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('name', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('completed', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('priority', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '1');
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, null, null, null);

        // Adding keys to table tool_matt.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('foreign', XMLDB_KEY_FOREIGN, ['courseid'], 'course', ['id']);

        // Conditionally launch create table for tool_matt.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Matt savepoint reached.
        upgrade_plugin_savepoint(true, 2018112604, 'tool', 'matt');
    }

    return true;
}

