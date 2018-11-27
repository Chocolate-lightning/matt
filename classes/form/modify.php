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

namespace tool_matt\form;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/formslib.php');

class modify extends \moodleform {
    public function definition() {
        global $COURSE;
        $form = $this->_form;

        $form->addElement('text', 'name', get_string('name', 'tool_matt'));
        $form->setType('name', PARAM_ALPHANUM);

        $form->addElement('advcheckbox', 'completed', get_string('completed', 'tool_matt'), null, array(0, 1));

        $form->addElement('hidden', 'courseid');
        $form->setType('courseid', PARAM_INT);
        $form->setDefault('courseid', $COURSE->id);

        $this->add_action_buttons();
    }

    public function validation($data, $files) {
        return array();
    }
}