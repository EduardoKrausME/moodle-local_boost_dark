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

use coding_exception;
use core\hook\output\before_html_attributes;
use dml_exception;

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
     * @throws coding_exception
     * @throws dml_exception
     */
    public static function html_attributes() {
        global $CFG;

        if (!get_config("local_boost_dark", "enable")) {
            return [];
        }

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
     * @param before_html_attributes $hook
     * @return void
     * @throws coding_exception
     * @throws dml_exception
     */
    public static function before_html_attributes(before_html_attributes $hook): void {
        if (!get_config("local_boost_dark", "enable")) {
            return;
        }

        $atributes = self::html_attributes();

        foreach ($atributes as $id => $value) {
            $hook->add_attribute($id, $value);
        }
    }

    /**
     * Function before_footer_html_generation
     * @throws dml_exception
     */
    public static function before_footer_html_generation() {
        if (!get_config("local_boost_dark", "enable")) {
            return;
        }

        $css = "
            <style>
                [data-bs-theme=dark] {
                    --bs-primary:       " . self::get_config("bs-primary", "#0d6efd") . "            !important;
                    --color_primary:    " . self::get_config("bs-primary", "#0d6efd") . "            !important;
                    --bs-white:         " . self::get_config("bs-white", "#fff") . "                 !important;
                    --bs-white-rgb:     " . self::get_config("bs-white-rgb", "255, 255, 255") . "    !important;
                    --bs-gray-100:      " . self::get_config("bs-gray-100", "#f8f9fa") . "           !important;
                    --bs-gray-100-rgb:  " . self::get_config("bs-gray-100-rgb", "248, 249, 250") . " !important;
                    --bs-gray-200:      " . self::get_config("bs-gray-200", "#e9ecef") . "           !important;
                    --bs-gray-200-rgb:  " . self::get_config("bs-gray-200-rgb", "233, 236, 239") . " !important;
                    --bs-gray-300:      " . self::get_config("bs-gray-300", "#dee2e6") . "           !important;
                    --bs-gray-300-rgb:  " . self::get_config("bs-gray-300-rgb", "222, 226, 230") . " !important;
                    --bs-gray-400:      " . self::get_config("bs-gray-400", "#ced4da") . "           !important;
                    --bs-gray-400-rgb:  " . self::get_config("bs-gray-400-rgb", "206, 212, 218") . " !important;
                    --bs-gray-500:      " . self::get_config("bs-gray-500", "#adb5bd") . "           !important;
                    --bs-gray-500-rgb:  " . self::get_config("bs-gray-500-rgb", "173, 181, 189") . " !important;
                    --bs-gray-600:      " . self::get_config("bs-gray-600", "#6c757d") . "           !important;
                    --bs-gray-600-rgb:  " . self::get_config("bs-gray-600-rgb", "108, 117, 125") . " !important;
                    --bs-gray-700:      " . self::get_config("bs-gray-700", "#495057") . "           !important;
                    --bs-gray-700-rgb:  " . self::get_config("bs-gray-700-rgb", "73, 80, 87") . "    !important;
                    --bs-gray-800:      " . self::get_config("bs-gray-800", "#393e4f") . "           !important;
                    --bs-gray-800-rgb:  " . self::get_config("bs-gray-800-rgb", "57, 62, 79") . "    !important;
                    --bs-gray-900:      " . self::get_config("bs-gray-900", "#2e3134") . "           !important;
                    --bs-gray-900-rgb:  " . self::get_config("bs-gray-900-rgb", "46, 49, 52") . "    !important;
                    --bs-gray-1000:     " . self::get_config("bs-gray-1000", "#1e1e25") . "          !important;
                    --bs-gray-1000-rgb: " . self::get_config("bs-gray-1000-rgb", "30, 30, 37") . "   !important;
                    --bs-gray-1100:     " . self::get_config("bs-gray-1100", "#0e0e11") . "          !important;
                    --bs-gray-1100-rgb: " . self::get_config("bs-gray-1100-rgb", "14, 14, 17") . "   !important;
                    --bs-black:         " . self::get_config("bs-black", "#000") . "                 !important;
                    --bs-black-rgb:     " . self::get_config("bs-black-rgb", "0, 0, 0") . "          !important;

                    --bs-nav-drawer:           " . self::get_config("bs-nav-drawer", "#e8eaed") . "                 !important;
                    --bs-nav-drawer-rgb:       " . self::get_config("bs-nav-drawer-rgb", "232, 234, 237") . "       !important;
                    --bs-link-color:           " . self::get_config("bs-link-color", "#98b6d9") . "                 !important;
                    --bs-link-color-rgb:       " . self::get_config("bs-link-color-rgb", "152, 182, 217") . "       !important;
                    --bs-link-hover-color:     " . self::get_config("bs-link-hover-color", "#aacbf2") . "           !important;
                    --bs-link-hover-color-rgb: " . self::get_config("bs-link-hover-color-rgb", "170, 203, 242") . " !important;
                    --bs-link-focus-color:     " . self::get_config("bs-link-focus-color", "#b3c0e8") . "           !important;
                    --bs-link-focus-color-rgb: " . self::get_config("bs-link-focus-color-rgb", "179, 192, 232") . " !important;
                    --bs-text-color:           " . self::get_config("bs-text-color", "#cbd0d4") . "                 !important;
                    --bs-text-color-rgb:       " . self::get_config("bs-text-color-rgb", "203, 208, 212") . "       !important;
                }
            </style>";
        $css = preg_replace('/\s+/', "", $css);
        echo $css;
    }

    /**
     * Function get_config
     *
     * @param $name
     * @param $default
     * @return mixed|string
     * @throws dml_exception
     */
    private static function get_config($name, $default) {
        $configname = str_replace("-rgb", "", $name);
        $configname = str_replace("-", "_", $configname);
        $config = get_config("local_boost_dark", $configname);

        if (!is_string($config)) {
            return $default;
        }

        if (strpos($name, "rgb") !== false) {
            if (preg_match('/^#[0-9A-Fa-f]{6}$/', $config)) {
                $hex = ltrim($config, "#");
                $r = hexdec(substr($hex, 0, 2));
                $g = hexdec(substr($hex, 2, 2));
                $b = hexdec(substr($hex, 4, 2));
                return "{$r}, {$g}, {$b}";
            }

            return $default;
        }

        return $config;
    }
}
