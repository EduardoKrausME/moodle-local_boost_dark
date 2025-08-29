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
 * Class userpreference
 *
 * @package   local_boost_dark
 * @copyright 2024 Eduardo Kraus {@link https://eduardokraus.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_boost_dark\external;

defined('MOODLE_INTERNAL') || die;
require_once("{$CFG->libdir}/externallib.php");

/**
 * Class userpreference
 *
 * @package local_boost_dark\external
 */
class userpreference extends \external_api {

    /**
     * save_parameters function
     *
     * @return \external_function_parameters
     */
    public static function save_parameters() {
        return new \external_function_parameters([
            "darkmode" => new \external_value(PARAM_TEXT, "The dark mode value"),
        ]);
    }

    /**
     * save function
     *
     * @param string $darkmode
     *
     * @return array
     *
     * @throws \coding_exception
     */
    public static function save($darkmode) {
        global $CFG;

        // Check if the user is a guest (not logged in).
        if (isguestuser()) {
            // Calculate the expiration date (1 year from now).
            $expiry = time() + (365 * 24 * 60 * 60); // 1 year in seconds.

            // Set the cookie.
            setcookie("darkmode", $darkmode, $expiry, $CFG->sessioncookiepath);

            return ["status" => true];
        }

        set_user_preference("darkmode", $darkmode);

        return ["status" => true];
    }

    /**
     * save_returns function
     *
     * @return \external_single_structure
     */
    public static function save_returns() {
        return new \external_single_structure([
            "status" => new \external_value(PARAM_BOOL, "the status"),
        ]);
    }
}
