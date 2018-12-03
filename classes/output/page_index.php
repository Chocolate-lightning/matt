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
 * Provides {@link tool_matt\output\renderer} class.
 *
 * @package     tool_matt
 * @category    output
 * @copyright   2018 Mathew May {@link http://mathew.solutions}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_matt\output;

use core\session\manager;
use moodle_exception;

defined('MOODLE_INTERNAL') || die();

use context_system;
use core_user;
use html_writer;
use moodle_url;
use renderable;
use renderer_base;
use templatable;

require_once($CFG->dirroot . '/' . $CFG->admin . '/tool/matt/locallib.php');

/**
 * @copyright 2018 Mathew May {@link http://mathew.solutions}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class page_index implements renderable, templatable {

    /** @var int Course id. */
    protected $courseid = null;

    /** @var object User who wants to see this page. */
    protected $userid = null;

    /**
     * Prepare the page for rendering.
     */
    public function __construct($courseid) {
        global $USER;

        $this->courseid = $courseid;
        $this->userid = $USER->id;

        $this->prepare_global_page_access();

        \tool_matt::delete();
    }

    /**
     * Sets up the global $PAGE and performs the access checks.
     */
    protected function prepare_global_page_access() {
        global $PAGE, $SITE, $USER;

        $myurl = new moodle_url('/admin/tool/matt/index.php', [
            'courseid' => $this->courseid,
        ]);

        $PAGE->set_context(\context_course::instance($this->courseid));
        $PAGE->set_pagelayout('standard');
        $PAGE->set_url($myurl);
        $PAGE->set_title('Hello to the matt list');
        $PAGE->set_heading(\get_string('pluginname', 'tool_matt'));

        $context = \context_course::instance($this->courseid);

        \require_capability('tool/matt:view', $context);
    }

    /**
     * Export the page data for the mustache template.
     *
     * @param renderer_base $output renderer to be used to render the page elements.
     * @return \stdClass
     */
    public function export_for_template(renderer_base $output) {
        global $CFG, $DB;

        $context = \context_course::instance($this->courseid);

        $data = new \stdClass();

        $data->hello = html_writer::tag('p', get_string('hello', 'tool_matt'));

        $data->coursename = html_writer::tag('p', get_string('course', 'tool_matt', $this->courseid));

        $course = $DB->get_record('course', array('id' => $this->courseid), '*', MUST_EXIST);

        $data->summary = html_writer::div($course->summary);

        if (has_capability('tool/matt:edit', $context, $this->userid)) {
            $editurl = new moodle_url('/admin/tool/matt/edit.php', ['courseid' => $this->courseid]);
            $data->edit = html_writer::link($editurl, get_string('editentry', 'tool_matt'), ['id' => 'tool_matt_edit']);
        }

        $data-> pluginbaseurl= (new moodle_url('/admin/tool/matt', [
            'courseid' => $this->courseid,
        ]))->out(false);

        return $data;
    }
}
