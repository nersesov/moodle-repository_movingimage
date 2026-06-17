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
 * AJAX endpoint: create a movingimage video asset and return its upload URL.
 *
 * @package    repository_movingimage
 * @copyright  2019 Rainer Möller
 * @copyright  2025 lern.link GmbH, Vadym Nersesov
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('AJAX_SCRIPT', true);

require_once(__DIR__ . '/../../config.php');
if (!class_exists('VideoManagerPro')) {
    require_once($CFG->dirroot . '/repository/movingimage/classes/vmpro.php');
}

// Access control: an authenticated user with a valid session is required.
require_login();
require_sesskey();

/**
 * Read a repository option, preferring the current "repository_*" config name
 * and falling back to the legacy name for backward compatibility.
 *
 * @param string $config Configuration key.
 * @return string Configuration value, empty string if not set.
 */
function movingimage_get_option(string $config): string {
    $value = get_config('repository_movingimage', $config);
    if ($value !== false && $value !== '') {
        return trim($value);
    }
    $value = get_config('movingimage', $config);
    return ($value !== false) ? trim($value) : '';
}

/**
 * Send a plain-text error response and stop execution.
 *
 * @param int    $code    HTTP status code.
 * @param string $message Message to return to the uploader.
 * @return void
 */
function movingimage_fail(int $code, string $message): void {
    http_response_code($code);
    echo $message;
    exit;
}

// User-supplied content parameters (validated and type-cleaned).
$filename = required_param('filename', PARAM_FILE);
$title = optional_param('title', '', PARAM_TEXT);
$description = optional_param('description', '', PARAM_TEXT);
$keywords = optional_param('keywords', '', PARAM_TEXT);
$channel = optional_param('channel', 0, PARAM_INT);
$coursename = optional_param('coursename', '', PARAM_TEXT);

// Security-relevant values are derived server-side and never trusted from the client.
$vmproid = movingimage_get_option('vmproid');
$ssoenabled = (movingimage_get_option('sso') === '1');

// The access token is held in the session; fall back to the posted token if absent.
$mitoken = (!empty($SESSION->miAccessToken))
    ? $SESSION->miAccessToken
    : optional_param('mitoken', '', PARAM_RAW);

if (empty($vmproid) || empty($mitoken)) {
    movingimage_fail(401, get_string('admin_login_error', 'repository_movingimage'));
}

// Author identity is taken from the logged-in user, not from the request.
$author = fullname($USER);
$email = $USER->email;

// Create new instance and validate the access token against the API.
$vmpro = new VideoManagerPro();
if (!$vmpro->tryAccessToken($vmproid, $mitoken)) {
    movingimage_fail(401, get_string('admin_login_error', 'repository_movingimage'));
}

// Determine the owner group for SSO uploads (based on the user's email).
$group = 0;
if ($ssoenabled) {
    $group = (int) $vmpro->getGroupIDByName($email);
}

// Create the video asset.
$entity = $vmpro->createVideoEntity($filename, $title, $description, $keywords, $channel, $group);

if (!is_array($entity) || !isset($entity['id'])) {
    movingimage_fail(404, get_string('upload_error', 'repository_movingimage'));
}

// Retrieve the upload URL for the freshly created asset.
$url = $vmpro->getUploadURL($entity['id']);
if (!is_array($url) || !isset($url['upload_url'])) {
    movingimage_fail(404, get_string('upload_error', 'repository_movingimage'));
}

// Return the upload URL to the uploader.
http_response_code(200);
echo $url['upload_url'];

// Persist Moodle metadata into the custom metadata fields configured by the admin.
$coursefield = movingimage_get_option('coursefield');
$namefield = movingimage_get_option('namefield');
$emailfield = movingimage_get_option('emailfield');

$metadata = [];
if ($coursefield !== '') {
    $metadata[$coursefield] = $coursename;
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
$deletiondays = (int) movingimage_get_option('deletiondays');
if ($deletiondays > 0) {
    $deletiontimestamp = (time() + $deletiondays * DAYSECS) * 1000;
    $vmpro->setVideoDeletionTimer($entity['id'], $deletiontimestamp);
}

// Apply the configured security policy when the uploader requested protection.
$protected = optional_param('protected', 0, PARAM_BOOL);
$securitypolicyid = (int) movingimage_get_option('securitypolicyid');
if ($protected && $securitypolicyid > 0) {
    $vmpro->setVideoData($entity['id'], ['securityPolicyId' => $securitypolicyid]);
}
