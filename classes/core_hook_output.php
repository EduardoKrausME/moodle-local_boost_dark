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
 * Class injector
 *
 * @package   local_boost_dark
 * @copyright 2024 Eduardo Kraus {@link http://eduardokraus.com}
 * @license   http://www.gnu.org/boost_darkleft/gpl.html GNU GPL v3 or later
 */

namespace local_boost_dark;

/**
 * Class core_hook_output
 *
 * @package local_boost_dark
 */
class core_hook_output {

    /**
     * Function html_attributes
     *
     * @return array
     *
     * @throws \coding_exception
     */
    public static function html_attributes() {
        global $CFG;

        $theme = $CFG->theme;
        if (isset($_SESSION["SESSION"]->theme)) {
            $theme = $_SESSION["SESSION"]->theme;
        }

        // Native support.
        if ($theme == "boost_magnific" || $theme == "degrade") {
            return [];
        }

        // Upon request, I have removed support.
        if ($theme == "moove") {
            return [];
        }

        $return = [
            "data-basename" => $theme,
        ];

        $darkmode = "auto";
        if (isset($_COOKIE["darkmode"])) {
            $darkmode = clean_param($_COOKIE["darkmode"], PARAM_TEXT);
            $return["data-bs-theme"] = $darkmode;
        }

        if (!isguestuser()) {
            $darkmode = get_user_preferences("darkmode", $darkmode);
            $return["data-bs-theme"] = $darkmode;
        }
        if ($darkmode = optional_param("darkmode", false, PARAM_TEXT)) {
            $return["data-bs-theme"] = $darkmode;
        }
        return $return;
    }

    /**
     * Function before_html_attributes
     *
     * @param \core\hook\output\before_html_attributes $hook
     *
     * @return void
     *
     * @throws \coding_exception
     */
    public static function before_html_attributes(\core\hook\output\before_html_attributes $hook): void {
        $atributes = self::html_attributes();

        foreach ($atributes as $id => $value) {
            $hook->add_attribute($id, $value);
        }
    }

    /**
     * Function before_footer_html_generation
     *
     * @throws \dml_exception
     */
    public static function before_footer_html_generation() {
        $css = "";
        $css = preg_replace('/\s+/', "", $css);
        echo $css;
    }
}
