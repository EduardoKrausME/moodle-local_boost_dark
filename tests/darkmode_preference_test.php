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
 * Tests for resolving dark mode preferences for visitors and authenticated users.
 *
 * @package   local_boost_dark
 * @copyright 2024 Eduardo Kraus {@link https://eduardokraus.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_boost_dark;

/**
 * Dark mode preference tests.
 *
 * @covers \local_boost_dark\darkmode_preference
 */
final class darkmode_preference_test extends \advanced_testcase {
    /**
     * Legacy auto and unsupported values must not produce half-dark pages.
     */
    public function test_normalize_values(): void {
        $this->assertSame("light", darkmode_preference::normalize("light"));
        $this->assertSame("dark", darkmode_preference::normalize("dark"));
        $this->assertSame("light", darkmode_preference::normalize("auto"));
        $this->assertSame("light", darkmode_preference::normalize("invalid"));
        $this->assertSame("light", darkmode_preference::normalize(["dark"]));
    }

    /**
     * Anonymous visitors use cookies, not Moodle user preferences.
     */
    public function test_anonymous_cookie_preference(): void {
        $this->resetAfterTest();
        $this->setUser(null);
        $previouscookies = $_COOKIE;

        try {
            unset($_COOKIE["darkmode"]);
            $this->assertTrue(darkmode_preference::is_visitor());
            $this->assertSame("light", darkmode_preference::current());

            $_COOKIE["darkmode"] = "dark";
            $this->assertSame("dark", darkmode_preference::current());

            $_COOKIE["darkmode"] = "auto";
            $this->assertSame("light", darkmode_preference::current());
        } finally {
            $_COOKIE = $previouscookies;
        }
    }

    /**
     * Guest logins share the same cookie semantics as anonymous visitors.
     */
    public function test_guest_cookie_preference(): void {
        $this->resetAfterTest();
        $this->setGuestUser();
        $previouscookies = $_COOKIE;

        try {
            $_COOKIE["darkmode"] = "dark";
            $this->assertTrue(darkmode_preference::is_visitor());
            $this->assertSame("dark", darkmode_preference::current());
        } finally {
            $_COOKIE = $previouscookies;
        }
    }

    /**
     * Account preferences take priority over any visitor cookie.
     */
    public function test_authenticated_user_preference(): void {
        $this->resetAfterTest();
        $user = $this->getDataGenerator()->create_user();
        $this->setUser($user);
        $previouscookies = $_COOKIE;

        try {
            $_COOKIE["darkmode"] = "light";
            set_user_preference("darkmode", "dark");
            $this->assertFalse(darkmode_preference::is_visitor());
            $this->assertSame("dark", darkmode_preference::current());

            set_user_preference("darkmode", "auto");
            $this->assertSame("light", darkmode_preference::current());
        } finally {
            $_COOKIE = $previouscookies;
        }
    }
}
