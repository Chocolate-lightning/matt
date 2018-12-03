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
 * @package     tool_matt
 * @copyright   2018 Mathew May {@link http://mathew.solutions}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_matt;

defined('MOODLE_INTERNAL') || die();

/**
 * Provides the API of the matt plugin.
 *
 * @package     tool_matt
 * @copyright   2018 Mathew May {@link http://mathew.solutions}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class api {
    /**
     * Create user policy acceptances when the user is created.
     *
     * @param \core\event\user_created $event
     */
    public static function item_deleted(\tool_matt\event\item_deleted $event) {
        print_object('Would you like to purchase WINRAR?');
        print_object($event);
        die();
    }

}