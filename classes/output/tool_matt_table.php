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
 * @copyright  2018 Mathew May
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_matt\output;
defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/tablelib.php');

use html_writer;
use moodle_url;
use table_sql;

/**
 * @package    tool_matt
 * @copyright  2018 Mathew May
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tool_matt_table extends table_sql {

    /** @var context The context. */
    protected $context;


    /**
     * Sets up the table.
     *
     * @param string $uniqueid Unique id of table.
     */
    public function __construct($courseid) {
        parent::__construct($courseid);

        $columns = array();
        $headers = array();
        $columns[] = 'courseid';
        $headers[] = get_string('course');
        $columns[] = 'name';
        $headers[] = get_string('name');
        $columns[] = 'completed';
        $headers[] = get_string('completed', 'completion');
        $columns[] = 'priority';
        $headers[] = get_string('priority', 'search');
        $columns[] = 'timecreated';
        $headers[] = get_string('created', 'question');
        $columns[] = 'timemodified';
        $headers[] = get_string('modified');
        $this->define_columns($columns);
        $this->define_headers($headers);

        $this->courseidfield = 'courseid';
        $this->define_baseurl("/admin/tool/matt/index.php");
        $this->is_collapsible = false;
        $this->sort_default_column = 'timemodified';
        $this->sort_default_order  = SORT_DESC;
        $this->set_count_sql('SELECT COUNT(*) FROM {tool_matt}', array());
        $fields = '*';
        $from = "{tool_matt}";
        $this->set_sql($fields, $from, 'courseid = '. $courseid);
        $this->pageable(true);
    }

    public function col_timemodified($values) {
        return userdate($values->timemodified);
    }

    public function col_timecreated($values) {
        return userdate($values->timecreated);
    }

    public function col_completed($values) {
        if ($values->completed == true) {
            return get_string('yes');
        } else {
            return get_string('no');
        }
    }

    public function col_priority($values) {
        if ($values->priority == true) {
            return get_string('yes');
        } else {
            return get_string('no');
        }
    }
    /**
     * Define table configs.
     */
    protected function define_table_configs() {
        $this->collapsible(false);
        $this->sortable(true, 'name', SORT_ASC);
        $this->pageable(true);
        $this->no_sorting('actions');
    }


    /**
     * Override the default implementation to set a decent heading level.
     */
    public function print_nothing_to_display() {
        global $OUTPUT;
        echo $this->render_reset_button();
        $this->print_initials_bar();
        echo $OUTPUT->heading(get_string('nothingtodisplay'), 4);
    }
}
