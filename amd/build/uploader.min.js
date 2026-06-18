/**
 * movingimage video upload handler.
 *
 * Controls the upload form display states, creates the video asset via the
 * repository_movingimage_create_asset web service and uploads the selected
 * file to the movingimage EVP.
 *
 * @module     repository_movingimage/uploader
 * @copyright  2019 Rainer Möller
 * @copyright  2025 lern.link GmbH, Vadym Nersesov
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define(['core/str', 'core/ajax'], function(Str, Ajax) {
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
     * Helper to show or hide elements using Bootstrap class list or fallback display style.
     *
     * @param {String}  id      The element ID.
     * @param {Boolean} visible Whether the element should be visible.
     */
    var setVisible = function(id, visible) {
        var element = el(id);
        if (!element) {
            return;
        }
        if (visible) {
            element.style.display = '';
            element.classList.remove('d-none');
        } else {
            element.style.display = 'none';
            element.classList.add('d-none');
        }
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
        label.className = 'label label-info text-white p-2 d-inline-block rounded';
        label.style.background = background;
        label.textContent = text;

        var heading = document.createElement('h5');
        heading.className = 'mt-3';
        heading.appendChild(label);

        var outtext = el('outtext');
        if (outtext) {
            if (append) {
                outtext.appendChild(heading);
            } else {
                outtext.innerHTML = '';
                outtext.appendChild(heading);
            }
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

        setVisible('fileInfo', true);
        setVisible('uploadbutton', true);
        setVisible('metadata', true);

        el('progress').value = 0;
        el('percent').innerHTML = '0%';
        var modernProg = el('modern-progress');
        if (modernProg) {
            modernProg.style.width = '0%';
            modernProg.textContent = '0%';
            modernProg.setAttribute('aria-valuenow', 0);
        }
    };

    /**
     * Reset all form values so another video can be uploaded.
     */
    var resetForm = function() {
        el('fileA').value = '';
        el('fileInfo').innerHTML = '';
        setVisible('fileInfo', false);
        setVisible('uploadbutton', false);
        setVisible('metadata', false);
        el('progress').value = 0;
        el('percent').innerHTML = '0%';
        var modernProg = el('modern-progress');
        if (modernProg) {
            modernProg.style.width = '0%';
            modernProg.textContent = '0%';
            modernProg.setAttribute('aria-valuenow', 0);
        }
        setVisible('cancelbutton', false);
        setVisible('redobutton', false);
        el('title').disabled = false;
        el('description').disabled = false;
        el('keywords').disabled = false;
        el('channel').disabled = false;
        el('title').value = '';
        el('description').value = '';
        el('keywords').value = '';
        setVisible('choosebutton', true);
        setVisible('progressbar', false);
        var outtext = el('outtext');
        if (outtext) {
            outtext.innerHTML = '';
        }
    };

    /**
     * Abort an in-progress upload.
     */
    var abortUpload = function() {
        if (client instanceof XMLHttpRequest) {
            client.abort();
        }
        showStatus(strings.cancelled, '#d9534f', true);
        setVisible('cancelbutton', false);
        setVisible('redobutton', true);
    };

    /**
     * Upload the selected file to the given movingimage upload URL.
     *
     * @param {String} url  Upload URL returned by the create_asset service.
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
            setVisible('cancelbutton', false);
            setVisible('redobutton', true);
            prog.value = prog.max;
            var modernProg = el('modern-progress');
            if (modernProg) {
                modernProg.style.width = '100%';
                modernProg.textContent = '100%';
                modernProg.setAttribute('aria-valuenow', 100);
            }
        };

        client.upload.onprogress = function(e) {
            var p = Math.round(100 / e.total * e.loaded);
            el('progress').value = p;
            el('percent').innerHTML = p + '%';
            var modernProg = el('modern-progress');
            if (modernProg) {
                modernProg.style.width = p + '%';
                modernProg.textContent = p + '%';
                modernProg.setAttribute('aria-valuenow', p);
            }
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
        setVisible('choosebutton', false);
        setVisible('progressbar', true);
        setVisible('uploadbutton', false);
        setVisible('cancelbutton', true);
        el('title').disabled = true;
        el('description').disabled = true;
        el('keywords').disabled = true;
        el('channel').disabled = true;

        var file = el('fileA').files[0];
        var prog = el('progress');
        if (!file) {
            return;
        }
        prog.value = 0;
        prog.max = 100;

        var request = {
            methodname: 'repository_movingimage_create_asset',
            args: {
                filename: file.name,
                title: el('title').value,
                description: el('description').value,
                channel: parseInt(el('channel').value, 10) || 0,
                keywords: el('keywords').value,
                coursename: settings.coursename,
                protected: el('protection').checked
            }
        };

        Ajax.call([request])[0].then(function(response) {
            if (response.uploadurl && response.uploadurl.indexOf('http') >= 0) {
                uploadFile(response.uploadurl, file, prog);
            } else {
                showStatus(strings.error, '#d9534f', true);
                setVisible('cancelbutton', false);
                setVisible('redobutton', true);
            }
            return response;
        }).catch(function() {
            showStatus(strings.requestError, '#d9534f', true);
            setVisible('cancelbutton', false);
            setVisible('redobutton', true);
        });
    };

    /**
     * Wire up the form event handlers.
     */
    var registerListeners = function() {
        el('fileA').addEventListener('change', fileChange);

        var dropzone = el('dropzone');
        if (dropzone) {
            dropzone.addEventListener('click', function() {
                el('fileA').click();
            });

            var preventDefaults = function(e) {
                e.preventDefault();
                e.stopPropagation();
            };

            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(function(eventName) {
                dropzone.addEventListener(eventName, preventDefaults);
            });

            ['dragenter', 'dragover'].forEach(function(eventName) {
                dropzone.addEventListener(eventName, function() {
                    dropzone.classList.remove('bg-light');
                    dropzone.classList.add('bg-white');
                    dropzone.classList.add('shadow-sm');
                    dropzone.style.borderColor = '#0d6efd';
                });
            });

            ['dragleave', 'drop'].forEach(function(eventName) {
                dropzone.addEventListener(eventName, function() {
                    dropzone.classList.remove('bg-white');
                    dropzone.classList.remove('shadow-sm');
                    dropzone.classList.add('bg-light');
                    dropzone.style.borderColor = '#ced4da';
                });
            });

            dropzone.addEventListener('drop', function(e) {
                var dt = e.dataTransfer;
                var files = dt.files;
                if (files && files.length > 0) {
                    el('fileA').files = files;
                    fileChange();
                }
            });
        }

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
         * @param {String} config.coursename Course full name.
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
