/**
 * movingimage video upload handler.
 *
 * Controls the upload form display states, creates the video asset via
 * createasset.php and uploads the selected file to the movingimage EVP.
 *
 * @module     repository_movingimage/uploader
 * @copyright  2019 Rainer Möller
 * @copyright  2025 lern.link GmbH, Vadym Nersesov
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define(['core/str'], function(Str) {
    'use strict';

    /** @type {XMLHttpRequest|null} Active upload request, used for aborting. */
    var client = null;

    /** @type {Object} Runtime configuration handed over from PHP. */
    var settings = {};

    /** @type {Object} Localised strings keyed by identifier. */
    var strings = {};

    /**
     * Short-hand for document.getElementById.
     *
     * @param {String} id Element id.
     * @return {HTMLElement|null}
     */
    var el = function(id) {
        return document.getElementById(id);
    };

    /**
     * Render a coloured status label into the percent element.
     *
     * @param {String} text       Status message.
     * @param {String} background CSS background colour.
     * @param {Boolean} append    Append to the existing content when true.
     */
    var showStatus = function(text, background, append) {
        var label = document.createElement('span');
        label.className = 'label';
        label.style.background = background;
        label.style.padding = '10px 30px';
        label.textContent = text;

        var heading = document.createElement('h4');
        heading.appendChild(label);

        var percent = el('percent');
        if (append) {
            percent.appendChild(heading);
        } else {
            percent.innerHTML = '';
            percent.appendChild(heading);
        }
    };

    /**
     * Switch the form to the "choose metadata" state once a file is picked.
     */
    var fileChange = function() {
        var fileList = el('fileA').files;
        var file = fileList[0];
        if (!file) {
            return;
        }

        var sizeMb = Math.round(file.size / 1024 / 1024 * 10) / 10;
        var info = el('fileInfo');
        info.innerHTML = '';
        var name = document.createElement('b');
        name.textContent = file.name;
        info.appendChild(name);
        info.appendChild(document.createElement('br'));
        info.appendChild(document.createTextNode(strings.filesize + ': ' + sizeMb + ' MB'));

        info.style.display = 'block';
        el('uploadbutton').style.display = 'block';
        el('metadata').style.display = 'block';
        el('progress').value = 0;
        el('percent').innerHTML = '0%';
    };

    /**
     * Reset all form values so another video can be uploaded.
     */
    var resetForm = function() {
        el('fileA').value = '';
        el('fileInfo').innerHTML = '';
        el('fileInfo').style.display = 'none';
        el('uploadbutton').style.display = 'none';
        el('metadata').style.display = 'none';
        el('progress').value = 0;
        el('percent').innerHTML = '0%';
        el('cancelbutton').style.display = 'none';
        el('redobutton').style.display = 'block';
        el('title').disabled = false;
        el('description').disabled = false;
        el('keywords').disabled = false;
        el('channel').disabled = false;
        el('title').value = '';
        el('description').value = '';
        el('keywords').value = '';
        el('choosebutton').style.display = 'block';
        el('progressbar').style.display = 'none';
    };

    /**
     * Abort an in-progress upload.
     */
    var abortUpload = function() {
        if (client instanceof XMLHttpRequest) {
            client.abort();
        }
        showStatus(strings.cancelled, '#d9534f', true);
        el('cancelbutton').style.display = 'none';
        el('redobutton').style.display = 'block';
    };

    /**
     * Upload the selected file to the given movingimage upload URL.
     *
     * @param {String} url  Upload URL returned by createasset.php.
     * @param {File}   file Selected file.
     * @param {HTMLProgressElement} prog Progress bar element.
     */
    var uploadFile = function(url, file, prog) {
        client = new XMLHttpRequest();

        client.onerror = function() {
            showStatus(strings.error, '#d9534f', true);
        };

        client.onload = function() {
            showStatus(strings.success, '#5cb85c', false);
            el('cancelbutton').style.display = 'none';
            el('redobutton').style.display = 'block';
            prog.value = prog.max;
        };

        client.upload.onprogress = function(e) {
            var p = Math.round(100 / e.total * e.loaded);
            el('progress').value = p;
            el('percent').innerHTML = p + '%';
        };

        client.open('POST', url);
        client.setRequestHeader('Content-Type', 'application/octet-stream');
        client.setRequestHeader('Mi24-Upload-Total-Chunks', '1');
        client.setRequestHeader('Mi24-Upload-Current-Chunk', '1');
        client.send(file);
    };

    /**
     * Create the video asset and start the upload.
     */
    var startUpload = function() {
        el('choosebutton').style.display = 'none';
        el('progressbar').style.display = 'block';
        el('uploadbutton').style.display = 'none';
        el('cancelbutton').style.display = 'block';
        el('title').disabled = true;
        el('description').disabled = true;
        el('keywords').disabled = true;
        el('channel').disabled = true;

        var file = el('fileA').files[0];
        var req = new XMLHttpRequest();
        var prog = el('progress');
        if (!file) {
            return;
        }

        req.onload = function() {
            var result = this.responseText;
            prog.value = 0;
            prog.max = 100;

            if (result.indexOf('http') >= 0) {
                uploadFile(result, file, prog);
            } else {
                showStatus(strings.error, '#d9534f', true);
                var detail = document.createElement('small');
                detail.textContent = result;
                el('percent').appendChild(detail);
                el('cancelbutton').style.display = 'none';
                el('redobutton').style.display = 'block';
            }
        };

        req.onerror = function() {
            showStatus(strings.requestError, '#d9534f', true);
        };

        req.open('POST', settings.createasseturl);
        req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        var params = {
            sesskey: settings.sesskey,
            mitoken: settings.mitoken,
            filename: file.name,
            title: el('title').value,
            description: el('description').value,
            channel: el('channel').value,
            keywords: el('keywords').value.split(','),
            coursename: settings.coursename,
            protected: el('protection').checked ? 1 : 0
        };

        var body = Object.keys(params).map(function(key) {
            return key + '=' + encodeURIComponent(params[key]);
        }).join('&');

        req.send(body);
    };

    /**
     * Wire up the form event handlers.
     */
    var registerListeners = function() {
        el('fileA').addEventListener('change', fileChange);

        var uploadButton = el('uploadbutton').querySelector('button');
        if (uploadButton) {
            uploadButton.addEventListener('click', startUpload);
        }
        var cancelButton = el('cancelbutton').querySelector('button');
        if (cancelButton) {
            cancelButton.addEventListener('click', abortUpload);
        }
        var redoButton = el('redobutton').querySelector('button');
        if (redoButton) {
            redoButton.addEventListener('click', resetForm);
        }
    };

    return {
        /**
         * Initialise the uploader.
         *
         * @param {Object} config Runtime configuration.
         * @param {String} config.sesskey         Moodle session key.
         * @param {String} config.mitoken         movingimage access token.
         * @param {String} config.coursename      Course full name.
         * @param {String} config.createasseturl  URL of createasset.php.
         */
        init: function(config) {
            settings = config;

            Str.get_strings([
                {key: 'upload_filesize', component: 'repository_movingimage'},
                {key: 'upload_cancelled', component: 'repository_movingimage'},
                {key: 'upload_error', component: 'repository_movingimage'},
                {key: 'upload_success', component: 'repository_movingimage'},
                {key: 'upload_request_error', component: 'repository_movingimage'}
            ]).then(function(loaded) {
                strings = {
                    filesize: loaded[0],
                    cancelled: loaded[1],
                    error: loaded[2],
                    success: loaded[3],
                    requestError: loaded[4]
                };
                registerListeners();
                return strings;
            }).catch(function() {
                // Fall back to identifiers so the form still works.
                strings = {
                    filesize: 'File size',
                    cancelled: 'Upload cancelled',
                    error: 'Upload error',
                    success: 'Upload success',
                    requestError: 'Upload request error'
                };
                registerListeners();
            });
        }
    };
});
