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
 * upgrade file.
 *
 * @package   local_boost_dark
 * @copyright 2025 Eduardo Kraus {@link http://eduardokraus.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Upgrade file.
 *
 * @param int $oldversion
 * @return bool
 * @throws Exception
 */
function xmldb_local_boost_dark_upgrade($oldversion) {
    if ($oldversion < 2025012700) {
        require_once(__DIR__ . "/db-install.php");

        upgrade_plugin_savepoint(true, 2025012700, 'local', 'boost_dark');
    }

    if ($oldversion < 2025071800) {
        $value = get_config("local_boost_dark", "bs-write");
        set_config("bs-white", $value, "local_boost_dark");

        upgrade_plugin_savepoint(true, 2025071800, 'local', 'boost_dark');
    }

    return true;
}
