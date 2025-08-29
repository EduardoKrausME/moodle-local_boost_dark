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
 * lib.php
 *
 * @package   local_boost_dark
 * @copyright 2024 Eduardo Kraus {@link https://eduardokraus.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use core\output\notification;
use local_boost_dark\core_hook_output;

/**
 * Function local_boost_dark_add_htmlattributes
 *
 * @return array
 *
 * @throws coding_exception
 */
function local_boost_dark_add_htmlattributes() {
    $atributes = core_hook_output::html_attributes();

    $return = [];
    foreach ($atributes as $id => $value) {
        $return[$id] = $value;
    }
    return $return;
}

/**
 * Renders the popup.
 *
 * @param renderer_base $renderer
 *
 * @return string The HTML
 * @throws dml_exception
 */
function local_boost_dark_render_navbar_output(renderer_base $renderer) {
    global $CFG;

    $theme = isset($_SESSION["SESSION"]->theme) ? $_SESSION["SESSION"]->theme : $CFG->theme;

    // Native support.
    if ($theme == "boost_magnific" || $theme == "degrade" || $theme == "eadflix") {
        return "";
    }

    // Upon request, I have removed support.
    if ($theme == "moove") {
        $message = "The Moove theme is not compatible with the Local Boost Dark plugin. " .
            "To resolve this incompatibility, please remove the <b>local_boost_dark</b> " .
            "plugin or choose a different theme that works properly with the plugin.";
        \core\notification::add($message, notification::NOTIFY_ERROR);
        return "";
    }

    return $renderer->render_from_template(
        "local_boost_dark/dark-icon",
        ["enable" => get_config("local_boost_dark", "enable")]
    );
}

/**
 * Function before_footer_html_generation
 *
 * @throws dml_exception
 */
function before_footer_html_generation() {
    core_hook_output::before_footer_html_generation();
}
