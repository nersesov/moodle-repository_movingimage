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
 * repository_movingimage
 *
 * @package    repository_movingimage
 * @copyright  2019 Rainer Möller
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['configplugin'] = 'Konfiguration für movingimage Video-Picker Repository';
$string['movingimage:view'] = 'View movingimage Video-Picker Repository';
$string['pluginname_help'] = 'Pick movingimage Videos';
$string['pluginname'] = 'movingimage Video-Picker';
$string['search'] = 'Suche';

$string['vmproid'] = 'VMPro-ID Ihres movingimage-Accounts ';
$string['playerid'] = 'Player-ID für Videoeinbettung';
$string['rootchannel'] = 'Root-Channel-ID für Moodle-Videos im movingimage EVP-Account';
$string['login'] = 'Admin-Username in movingimage EVP';
$string['password'] = 'Admin-Password für autorisierten Zugriff';
$string['adminrole'] = 'Admin-Rollen-ID in movingimage EVP';
$string['autocreateuser'] = 'Auto-Erstellen nicht-existenter Benutzer in movingimage EVP';
$string['miuserfield'] = 'Benutzereigenschaft mit E-Mail für die EVP-Benutzererstellung von Movingimage';
$string['usercompanyrole'] = 'Benutzer-Rollen-ID in Unternehmens-Gruppe in movingimage EVP';
$string['autocreategroup'] = 'Auto-Erstellen von Content-Gruppen für neue movingimage-Benutzer';
$string['usergrouprole'] = 'Benutzer-Rollen-ID in Benutzer-Gruppe in movingimage EVP';
$string['autocreatechannel'] = 'Auto-Erstellen von Video-Channels für neue movingimage-Benutzer';
$string['vmprologin'] = 'Login-URL für movingimage VideoManager Pro';
$string['sso'] = 'Aktiviere SSO Authentifizierung für movingimage EVP';
$string['client'] = 'SSO Client-Nanem für movingimage Auth Service';
$string['idphint'] = 'SSO IDP-Hhint für movingimage Auth Service';
$string['sortby'] = 'Sortiere Videoliste nach "title", "createdDate", "modifiedDate", "views" or "plays"';
$string['sortasc'] = 'Sortiere Videoliste aufsteigend';

$string['admin_login_error'] = 'movingimage EVP-Login fehlgeschlagen - Überprüfen Sie Login/Password sowie VMPro-ID';
$string['config_player_error'] = 'Ungültiger Player ID für movingimage-Account';
$string['config_channel_error'] = 'Ungültige Root-Channel-ID für movingimage EVP';
$string['config_idphint_error'] = 'IDP-Hint muss definiert sein wenn SSO aktiviert ist';
$string['config_client_error'] = 'Client-Name muss definiert sein wenn SSO aktiviert ist';
$string['config_miuserfield_error'] = 'Benutzereigenschaft existiert nicht';
$string['config_role_error'] = 'Ungültige Rollen-ID für movingimage EVP';
$string['videolist_error'] = 'Videoliste der movingimage EVP nicht abrufbar';

// Video-Upload (zusammengeführt aus dem ehemaligen movingimageupload-Repository).
$string['upload_folder'] = 'Neues Video hochladen';
$string['uploadrootchannel'] = 'Erlaube Uploads im Root-Channel für Moodle-Videos';
$string['securitypolicyid'] = 'movingimage Sicherheitsrichtlinien-ID für geschützte Videos';
$string['deletiondays'] = 'Automatischen Löschen der Videos nach wieviel Tagen';
$string['coursefield'] = 'Metadatenfeld für Moodle-Kurs in movingimage EVP';
$string['namefield'] = 'Metadatenfeld für Name des Uploaders in movingimage EVP';
$string['emailfield'] = 'Metadatenfeld für Email des Uploaders in movingimage EVP';
$string['config_policy_error'] = 'Ungültige Sicherheitsrichtlinien-ID für geschützte Videos';
$string['config_metadata_error'] = 'Ungültiger Custom-Metadaten-Feldname';
$string['upload_request_error'] = 'Upload-Request-Fehler';
$string['upload_error'] = 'Upload-Fehler';
$string['upload_success'] = 'Upload erfolgreich';
$string['upload_cancelled'] = 'Upload abgebrochen';
$string['upload_filesize'] = 'Dateigröße';
$string['upload_start_button'] = 'Upload zu movingimage EVP starten';
$string['upload_cancel_button'] = 'Upload abbrechen';
$string['upload_more_button'] = 'Weitere Videos hochladen...';
$string['upload_title_input'] = 'Video-Titel';
$string['upload_protected_input'] = 'Geschützt';
$string['upload_description_input'] = 'Video-Beschreibung';
$string['upload_keywords_input'] = 'Video-Keywords (kommagetrennt)';
$string['upload_channel_input'] = 'Upload-Channel auswählen';
