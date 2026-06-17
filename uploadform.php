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
 * @package    repository_movingimage
 * @copyright  2019 Rainer Möller
 * @copyright  2025 lern.link GmbH, Vadym Nersesov
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// include all required Moodle and movingimage libs
require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once($CFG->libdir.'/adminlib.php');

use repository_movingimage\local\config;
use repository_movingimage\local\vmpro_client;

require_login();
require_sesskey();

// Set up the page for proper theme handling
$PAGE->set_context(context_system::instance());
$PAGE->set_url('/repository/movingimage/uploadform.php');
$PAGE->set_pagelayout('embedded');


// Helper function to read a repository option, preferring the current
// config area and falling back to the legacy name.
function get_movingimage_option($config = '') {
    return \repository_movingimage\local\config::get($config);
}

// Create movingimage API access instance and try to log in.
$vmpro = new vmpro_client();
if (!$vmpro->tryAccessToken(get_movingimage_option('vmproid'), optional_param('mitoken', '', PARAM_RAW))) {
    throw new moodle_exception('apierror-login', 'repository_movingimage',
        get_string('admin_login_error', 'repository_movingimage'), '');
}

// Get the list of video channels and flatten it for the dropdown.
$api_channels = $vmpro->getChannels(get_movingimage_option('rootchannel'));
$channels = array();

/**
 * Recursively flatten the channel tree into a one dimensional list for the
 * dropdown, prefixing nested channels with non-breaking spaces to illustrate
 * their depth.
 *
 * @param array  $channel Channel node from the movingimage API.
 * @param string $prefix  Indentation prefix for the current depth.
 * @return void
 */
function movingimage_flatten_channel_tree(array $channel, string $prefix = '') {
    global $channels;

    $rootlabel = get_string('upload_all_videos', 'repository_movingimage');
    $isroot = ($channel['name'] === 'root_channel');
    if (!$isroot || $prefix !== '' || get_movingimage_option('uploadrootchannel') == 1) {
        $channels[] = array(
            'id'    => $channel['id'],
            'label' => $prefix . ($isroot ? $rootlabel : $channel['name']),
        );
    }
    if (isset($channel['children']) && is_array($channel['children'])) {
        uasort($channel['children'], function ($a, $b) {
            return strcmp($a['name'], $b['name']);
        });
        foreach ($channel['children'] as $child) {
            // Indent each level by four non-breaking spaces.
            movingimage_flatten_channel_tree($child, $prefix . "\u{00A0}\u{00A0}\u{00A0}\u{00A0}");
        }
    }
}

if (is_array($api_channels) && isset($api_channels['id'])) {
    movingimage_flatten_channel_tree($api_channels);
}

// Mark the first channel as preselected in the dropdown.
foreach ($channels as $index => $channel) {
    $channels[$index]['selected'] = ($index === 0);
}

// Hand over the runtime configuration to the AMD uploader module. The access
// token is intentionally not passed here: it is held in the session and read
// server-side by the create_asset web service. Passing it would also exceed the
// js_call_amd argument length limit.
$PAGE->requires->js_call_amd('repository_movingimage/uploader', 'init', array(array(
    'coursename' => $COURSE->fullname,
)));

echo $OUTPUT->header();
echo $OUTPUT->render_from_template('repository_movingimage/upload_form', array('channels' => array_values($channels)));
echo $OUTPUT->footer();

