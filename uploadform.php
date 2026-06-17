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

echo $OUTPUT->header();
echo $OUTPUT->render_from_template('repository_movingimage/upload_form', array('channels' => array_values($channels)));
?>

    <script>

/*
   PART TWO: JavaScript form handling
     Controlling display options of HTML elements, upload file to movingimage EVP, monitor upload progress
*/

    var client = null;

    function fileChange()
    {

        // Store file path once file is defined
      var fileList = document.getElementById('fileA').files;
      var file = fileList[0];
      if (!file)
          return;

        // Switch to "enter metadata" state once upload file is defined
      document.getElementById('fileInfo').innerHTML = '<b>' + file.name + '</b><br><?php echo get_string('upload_filesize', 'repository_movingimage'); ?>: ' + (Math.round(file.size / 1024 / 1024 * 10)/10) + ' MB';
        document.getElementById('fileInfo').style.display = 'block';
        document.getElementById('uploadbutton').style.display = 'block';
        document.getElementById('metadata').style.display = 'block';
      document.getElementById('progress').value = 0;
      document.getElementById('percent').innerHTML = '0%';

    }

    function resetForm() {

        // Reset all form values for additional video upload
      document.getElementById('fileA').value = '';
      document.getElementById('fileInfo').innerHTML = '';
        document.getElementById('fileInfo').style.display = 'none';
        document.getElementById('uploadbutton').style.display = 'none';
        document.getElementById('metadata').style.display = 'none';
      document.getElementById('progress').value = 0;
      document.getElementById('percent').innerHTML = '0%';
        document.getElementById('cancelbutton').style.display = 'none';
        document.getElementById('redobutton').style.display = 'block';
        document.getElementById('title').disabled = false;
        document.getElementById('description').disabled = false;
        document.getElementById('description').disabled = false;
        document.getElementById('keywords').disabled = false;
        document.getElementById('channel').disabled = false;
        document.getElementById('title').value = '';
        document.getElementById('description').value = '';
        document.getElementById('keywords').value = '';
        document.getElementById('choosebutton').style.display = 'block';
        document.getElementById('progressbar').style.display = 'none';

    }

    function abortUpload() {

        // Handle cancel events both for helper function and upload requests
      if (client instanceof XMLHttpRequest)
          client.abort();

        // Set display state to cancelled and offer re-uopload
        document.getElementById('percent').innerHTML += '<h4><span class="label" style="background-color:#d9534f; padding:10px 30px;"<?php echo get_string('upload_cancelled', 'repository_movingimage'); ?></span></h4>';
        document.getElementById('cancelbutton').style.display = 'none';
        document.getElementById('redobutton').style.display = 'block';

    }

    function startUpload()
    {

        // set form display options to uploading state and disable form input fields
        document.getElementById('choosebutton').style.display = 'none';
        document.getElementById('progressbar').style.display = 'block';
        document.getElementById('uploadbutton').style.display = 'none';
        document.getElementById('cancelbutton').style.display = 'block';
        document.getElementById('title').disabled = true;
        document.getElementById('description').disabled = true;
        document.getElementById('keywords').disabled = true;
        document.getElementById('channel').disabled = true;

        // Initialize request and progress bar
      var file = document.getElementById('fileA').files[0];
      var req = new XMLHttpRequest();
      var prog = document.getElementById('progress');

        // Cancel if file if not defined
      if (!file)
          return;

        req.onload = function(e) {
            result = this.responseText;     // save result of helper function createasset.php
            prog.value = 0;
            prog.max = 100;
            client = new XMLHttpRequest();  // the final upload request

            client.onerror = function(e) {

                // If upload process fails, display error message and log to console
                document.getElementById('percent').innerHTML += '<h4><span class="label" style="background-color:#d9534f; padding:10px 30px;\"><?php echo get_string('upload_error', 'repository_movingimage'); ?></span></h4>';
                console.log('Error while uploading.');
            };

            client.onload = function(e) {

                // display upload success and allow another upload via re-do button
                document.getElementById('percent').innerHTML = '100%<h5><span class="label" style="background-color:#5cb85c; padding:5px 20px;\"><?php echo get_string('upload_success', 'repository_movingimage'); ?></span></h5>';
                document.getElementById('cancelbutton').style.display = 'none';
                document.getElementById('redobutton').style.display = 'block';
                prog.value = prog.max;

            };

            client.upload.onprogress = function(e) {

                // display upload progress in percent
                var p = Math.round(100 / e.total * e.loaded);
                document.getElementById('progress').value = p;
                document.getElementById('percent').innerHTML = p + '%';

            };

            client.onabort = function(e) {

                // upload has been cancelled, log to console
                console.log('Upload canceled.');

            };

            // proceed if helper function createasset.php has returned a success code
            if (result.indexOf('http') >= 0) {

                // If the result of helper function createasset.php returned a URL, proceed with uploading the file to this URL (set headers, send file)
                client.open('POST', result);
                client.setRequestHeader('Content-Type', 'application/octet-stream');
                client.setRequestHeader('Mi24-Upload-Total-Chunks','1');
                client.setRequestHeader('Mi24-Upload-Current-Chunk','1');
                client.send(file);

            } else {

                // If the result of helper function createasset.php did NOT return a URL, display error message and re-do button)
                document.getElementById('percent').innerHTML += '<h4><span class="label" style="background-color:#d9534f; padding:10px 30px;\"><?php echo get_string('upload_error', 'repository_movingimage'); ?></span></h4>'
                    + '<small>' + result + '</small>';
                document.getElementById('cancelbutton').style.display = 'none';
                document.getElementById('redobutton').style.display = 'block';

            }
        }

        req.onerror = function(e) {

            // helper function in createasset.php returned an error, display it in the status bar and log to console

            document.getElementById('percent').innerHTML += '<h4><span class=\"label\" style=\"background-color:#d9534f; padding:10px 30px;\"><?php echo get_string('upload_request_error', 'repository_movingimage'); ?></span></h4>';
            console.log('Error on upload request!');
        }

        // call createasset.php helper function to handle all movingimage API communication (create new video asset, get upload URL from API)
        // call will return upload URL for video file upload

        req.open('POST', 'createasset.php');
        req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        // Set POST parameters for createasset.

        var $params = [];
        $params['sesskey'] = '<?php echo sesskey(); ?>';
        $params['mitoken'] = <?php echo json_encode(optional_param('mitoken', '', PARAM_RAW)); ?>;
        $params['filename'] = file.name;
        $params['title'] = document.getElementById('title').value;
        $params['description'] = document.getElementById('description').value;
        $params['channel'] = document.getElementById('channel').value;
        $params['keywords'] = document.getElementById('keywords').value.split(',');
        $params['coursename'] = <?php echo json_encode($COURSE->fullname); ?>;
        $params['protected'] = document.getElementById('protection').checked ? 1 : 0;

        // Encode all parameters and start POST requests

        req.send(Object.keys($params).reduce(function(a,k){a.push(k+'='+encodeURIComponent($params[k]));return a},[]).join('&'));

    }

    </script>
<?php echo $OUTPUT->footer(); ?>
