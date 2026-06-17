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

namespace repository_movingimage\external;

use core_external\external_api;
use core_external\external_function_parameters;
use core_external\external_single_structure;
use core_external\external_value;
use repository_movingimage\local\config;
use repository_movingimage\local\vmpro_client;
use context_system;
use moodle_exception;

/**
 * External service to create a movingimage video asset and return its upload URL.
 *
 * @package    repository_movingimage
 * @copyright  2019 Rainer Möller
 * @copyright  2025 lern.link GmbH, Vadym Nersesov
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class create_asset extends external_api {

    /**
     * Describe the parameters accepted by the service.
     *
     * @return external_function_parameters
     */
    public static function execute_parameters(): external_function_parameters {
        return new external_function_parameters([
            'filename'    => new external_value(PARAM_FILE, 'Name of the uploaded file'),
            'title'       => new external_value(PARAM_TEXT, 'Video title', VALUE_DEFAULT, ''),
            'description' => new external_value(PARAM_TEXT, 'Video description', VALUE_DEFAULT, ''),
            'keywords'    => new external_value(PARAM_TEXT, 'Comma separated keywords', VALUE_DEFAULT, ''),
            'channel'     => new external_value(PARAM_INT, 'Target channel id', VALUE_DEFAULT, 0),
            'coursename'  => new external_value(PARAM_TEXT, 'Course full name', VALUE_DEFAULT, ''),
            'protected'   => new external_value(PARAM_BOOL, 'Whether to apply the security policy', VALUE_DEFAULT, false),
            'mitoken'     => new external_value(PARAM_RAW, 'Fallback movingimage access token', VALUE_DEFAULT, ''),
        ]);
    }

    /**
     * Create the video asset, return its upload URL and persist metadata.
     *
     * @param string $filename    Name of the uploaded file.
     * @param string $title       Video title.
     * @param string $description Video description.
     * @param string $keywords    Comma separated keywords.
     * @param int    $channel     Target channel id.
     * @param string $coursename  Course full name.
     * @param bool   $protected   Whether to apply the security policy.
     * @param string $mitoken     Fallback movingimage access token.
     * @return array Result containing the upload URL.
     * @throws moodle_exception
     */
    public static function execute(string $filename, string $title = '', string $description = '',
            string $keywords = '', int $channel = 0, string $coursename = '', bool $protected = false,
            string $mitoken = ''): array {
        global $USER, $SESSION;

        $params = self::validate_parameters(self::execute_parameters(), [
            'filename'    => $filename,
            'title'       => $title,
            'description' => $description,
            'keywords'    => $keywords,
            'channel'     => $channel,
            'coursename'  => $coursename,
            'protected'   => $protected,
            'mitoken'     => $mitoken,
        ]);

        // Access control: a valid session in the system context is required.
        $context = context_system::instance();
        self::validate_context($context);

        // Security-relevant values are derived server-side, never trusted from the client.
        $vmproid = config::get('vmproid');
        $ssoenabled = (config::get('sso') === '1');

        // The access token is held in the session; fall back to the passed token if absent.
        $token = (!empty($SESSION->miAccessToken)) ? $SESSION->miAccessToken : $params['mitoken'];

        if (empty($vmproid) || empty($token)) {
            throw new moodle_exception('admin_login_error', 'repository_movingimage');
        }

        // Author identity is taken from the logged-in user, not from the request.
        $author = fullname($USER);
        $email = $USER->email;

        // Create a new client instance and validate the access token against the API.
        $vmpro = new vmpro_client();
        if (!$vmpro->tryAccessToken($vmproid, $token)) {
            throw new moodle_exception('admin_login_error', 'repository_movingimage');
        }

        // Determine the owner group for SSO uploads (based on the user's email).
        $group = 0;
        if ($ssoenabled) {
            $group = (int) $vmpro->getGroupIDByName($email);
        }

        // Create the video asset.
        $entity = $vmpro->createVideoEntity($params['filename'], $params['title'], $params['description'],
            $params['keywords'], $params['channel'], $group);
        if (!is_array($entity) || !isset($entity['id'])) {
            throw new moodle_exception('upload_error', 'repository_movingimage');
        }

        // Retrieve the upload URL for the freshly created asset.
        $url = $vmpro->getUploadURL($entity['id']);
        if (!is_array($url) || !isset($url['upload_url'])) {
            throw new moodle_exception('upload_error', 'repository_movingimage');
        }

        // Persist Moodle metadata into the custom metadata fields configured by the admin.
        $coursefield = config::get('coursefield');
        $namefield = config::get('namefield');
        $emailfield = config::get('emailfield');

        $metadata = [];
        if ($coursefield !== '') {
            $metadata[$coursefield] = $params['coursename'];
        }
        if ($namefield !== '') {
            $metadata[$namefield] = $author;
        }
        if ($emailfield !== '') {
            $metadata[$emailfield] = $email;
        }
        if (count($metadata) > 0) {
            $vmpro->setCustomMetadata($entity['id'], $metadata);
        }

        // Apply the configured auto-deletion retention period, if any.
        $deletiondays = (int) config::get('deletiondays');
        if ($deletiondays > 0) {
            $deletiontimestamp = (time() + $deletiondays * DAYSECS) * 1000;
            $vmpro->setVideoDeletionTimer($entity['id'], $deletiontimestamp);
        }

        // Apply the configured security policy when the uploader requested protection.
        $securitypolicyid = (int) config::get('securitypolicyid');
        if ($params['protected'] && $securitypolicyid > 0) {
            $vmpro->setVideoData($entity['id'], ['securityPolicyId' => $securitypolicyid]);
        }

        return [
            'uploadurl' => $url['upload_url'],
        ];
    }

    /**
     * Describe the value returned by the service.
     *
     * @return external_single_structure
     */
    public static function execute_returns(): external_single_structure {
        return new external_single_structure([
            'uploadurl' => new external_value(PARAM_URL, 'URL to upload the video file to'),
        ]);
    }
}
