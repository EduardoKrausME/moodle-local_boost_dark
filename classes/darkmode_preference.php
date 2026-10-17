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
 * Resolve the current light or dark colour preference.
 *
 * @package   local_boost_dark
 * @copyright 2024 Eduardo Kraus {@link https://eduardokraus.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_boost_dark;

/**
 * Keeps visitors' cookie preferences separate from authenticated user preferences.
 */
class darkmode_preference {
    /**
     * Whether the current user has no persistent Moodle account.
     *
     * @return bool
     */
    public static function is_visitor(): bool {
        return !isloggedin() || isguestuser();
    }

    /**
     * Migrate legacy "auto" preferences and discard unrecognised values.
     *
     * @param mixed $mode
     * @return string
     */
    public static function normalize($mode): string {
        return in_array($mode, ["light", "dark"], true) ? $mode : "light";
    }

    /**
     * Read the current user's saved colour mode.
     *
     * @return string
     */
    public static function current(): string {
        if (self::is_visitor()) {
            return self::normalize($_COOKIE["darkmode"] ?? "light");
        }

        return self::normalize(get_user_preferences("darkmode", "light"));
    }
}
