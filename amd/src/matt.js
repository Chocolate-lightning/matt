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
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define(['jquery', 'core/ajax', 'core/templates', 'core/notification'], function($, ajax, templates, notification) {

    return {
        init: function() {
            $( ".delete" ).click(function() {
                var result = confirm("Want to delete this record??");
                if (result) {
                    return true;
                } else {
                    var info = [];
                    info[0]['recordid'] = Number(this.getAttribute("data-id"));
                    var promises = ajax.call([{
                        methodname: 'tool_matt_delete_records',
                        args: {records:info}
                    }]);
                    promises[0].done(function (data) {
                        templates.render('tool_matt/page_index', data).done(function (html, js) {
                            $('region-main').replaceWith(html);
                            templates.runTemplateJS(js);
                        }).fail(notification.exception);
                    }).fail(notification.exception);
                    return false;
                }
            });
        }
    };
});