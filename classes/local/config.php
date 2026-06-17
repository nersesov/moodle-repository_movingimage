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

namespace repository_movingimage\local;

/**
 * Shared configuration accessor for the movingimage repository.
 *
 * @package    repository_movingimage
 * @copyright  2025 lern.link GmbH, Vadym Nersesov
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class config {

    /** @var string Current frankenstyle config area. */
    const COMPONENT = 'repository_movingimage';

    /** @var string Legacy config area kept for backward compatibility. */
    const LEGACY_COMPONENT = 'movingimage';

    /**
     * Read a plugin configuration value.
     *
     * Prefers the current "repository_movingimage" config area and falls back
     * to the legacy "movingimage" area for backward compatibility.
     *
     * @param string $key Configuration key.
     * @return string Configuration value, or an empty string if not set.
     */
    public static function get(string $key): string {
        $value = get_config(self::COMPONENT, $key);
        if ($value !== false && $value !== '') {
            return trim($value);
        }

        $value = get_config(self::LEGACY_COMPONENT, $key);
        return ($value !== false) ? trim($value) : '';
    }
}
