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
 * Connection diagnostic script for movingimage Moodle connector
 *
 * @package    repository_movingimagepicker
 * @copyright  2024 movingimage
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->dirroot . '/repository/movingimagepicker/classes/vmpro.php');

// Must be run by an admin
require_login();
require_capability('moodle/site:config', context_system::instance());

// Set up the page
$PAGE->set_context(context_system::instance());
$PAGE->set_url('/repository/movingimagepicker/test_connection.php');
$PAGE->set_title('movingimage Connection Test');
$PAGE->set_heading('movingimage Connection Test');

echo $OUTPUT->header();

echo html_writer::tag('h2', 'movingimage Connection Diagnostic');

/**
 * Read a picker connection option, preferring the current "repository_*" config
 * name and falling back to the legacy name for backward compatibility.
 *
 * @param string $config Configuration key.
 * @return string Configuration value, empty string if not set.
 */
function movingimage_get_picker_option(string $config): string {
    $value = get_config('repository_movingimagepicker', $config);
    if ($value !== false && $value !== '') {
        return trim($value);
    }
    $value = get_config('movingimagepicker', $config);
    return ($value !== false) ? trim($value) : '';
}

// Get configuration
$login = movingimage_get_picker_option('login');
$password = movingimage_get_picker_option('password');
$vmproid = movingimage_get_picker_option('vmproid');

echo html_writer::tag('h3', 'Configuration Check');
echo html_writer::start_tag('ul');
echo html_writer::tag('li', 'Login: ' . ($login ? 'Configured' : 'NOT CONFIGURED'), 
    array('style' => $login ? 'color: green;' : 'color: red;'));
echo html_writer::tag('li', 'Password: ' . ($password ? 'Configured' : 'NOT CONFIGURED'), 
    array('style' => $password ? 'color: green;' : 'color: red;'));
echo html_writer::tag('li', 'VMPro ID: ' . ($vmproid ? $vmproid : 'NOT CONFIGURED'), 
    array('style' => $vmproid ? 'color: green;' : 'color: red;'));
echo html_writer::end_tag('ul');

if (!$login || !$password || !$vmproid) {
    echo html_writer::tag('p', 'Please configure the connection settings first.', 
        array('style' => 'color: red; font-weight: bold;'));
    echo $OUTPUT->footer();
    exit;
}

echo html_writer::tag('h3', 'Connection Tests');

// Test 1: Basic cURL availability
echo html_writer::tag('h4', '1. cURL Extension');
if (function_exists('curl_init')) {
    echo html_writer::tag('p', '✓ cURL is available', array('style' => 'color: green;'));
} else {
    echo html_writer::tag('p', '✗ cURL is NOT available', array('style' => 'color: red;'));
    echo $OUTPUT->footer();
    exit;
}

// Test 2: SSL Support
echo html_writer::tag('h4', '2. SSL Support');
$curl_version = curl_version();
if ($curl_version['features'] & CURL_VERSION_SSL) {
    echo html_writer::tag('p', '✓ SSL support is available', array('style' => 'color: green;'));
} else {
    echo html_writer::tag('p', '✗ SSL support is NOT available', array('style' => 'color: red;'));
}

// Test 3: DNS Resolution
echo html_writer::tag('h4', '3. DNS Resolution');
$api_host = 'api.video-cdn.net';
$ip = gethostbyname($api_host);
if ($ip !== $api_host) {
    echo html_writer::tag('p', "✓ DNS resolution successful: $api_host -> $ip", array('style' => 'color: green;'));
} else {
    echo html_writer::tag('p', "✗ DNS resolution failed for $api_host", array('style' => 'color: red;'));
}

// Test 4: Basic connectivity
echo html_writer::tag('h4', '4. Basic API Connectivity');
try {
    $vmpro = new VideoManagerPro();
    if ($vmpro->testConnection()) {
        echo html_writer::tag('p', '✓ Basic API connectivity successful', array('style' => 'color: green;'));
    } else {
        echo html_writer::tag('p', '✗ Basic API connectivity failed', array('style' => 'color: red;'));
    }
} catch (Exception $e) {
    echo html_writer::tag('p', '✗ Exception during connectivity test: ' . $e->getMessage(), array('style' => 'color: red;'));
}

// Test 5: Authentication
echo html_writer::tag('h4', '5. Authentication Test');
try {
    $vmpro = new VideoManagerPro();
    if ($vmpro->login($login, $password, $vmproid)) {
        echo html_writer::tag('p', '✓ Authentication successful', array('style' => 'color: green;'));
        
        // Test 6: Video listing
        echo html_writer::tag('h4', '6. Video Listing Test');
        $videos = $vmpro->getVideos(0, 5, 0);
        if ($videos !== false && is_array($videos)) {
            $count = isset($videos['videos']) ? count($videos['videos']) : 0;
            echo html_writer::tag('p', "✓ Video listing successful (found $count videos)", array('style' => 'color: green;'));
        } else {
            echo html_writer::tag('p', '✗ Video listing failed', array('style' => 'color: red;'));
        }
        
        // Test 7: Channel access
        echo html_writer::tag('h4', '7. Channel Access Test');
        $rootchannel = movingimage_get_picker_option('rootchannel');
        $channels = $vmpro->getChannels($rootchannel);
        if ($channels !== false && is_array($channels)) {
            echo html_writer::tag('p', '✓ Channel access successful', array('style' => 'color: green;'));
        } else {
            echo html_writer::tag('p', '✗ Channel access failed', array('style' => 'color: red;'));
        }
        
    } else {
        echo html_writer::tag('p', '✗ Authentication failed - check username, password, and VMPro ID', array('style' => 'color: red;'));
    }
} catch (Exception $e) {
    echo html_writer::tag('p', '✗ Exception during authentication: ' . $e->getMessage(), array('style' => 'color: red;'));
}

echo html_writer::tag('h3', 'Log Information');
echo html_writer::tag('p', 'Check your web server error logs for detailed connection information. Look for entries containing "movingimage".');

echo html_writer::tag('h3', 'Troubleshooting Tips');
echo html_writer::start_tag('ul');
echo html_writer::tag('li', 'Verify your movingimage EVP credentials are correct');
echo html_writer::tag('li', 'Check that your server can access external HTTPS URLs');
echo html_writer::tag('li', 'Ensure your firewall allows outbound connections to api.video-cdn.net and vmpro.movingimage.com');
echo html_writer::tag('li', 'Verify SSL certificates are up to date on your server');
echo html_writer::tag('li', 'Check PHP cURL configuration and SSL settings');
echo html_writer::end_tag('ul');

echo $OUTPUT->footer();
