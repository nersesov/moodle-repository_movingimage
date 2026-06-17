# Moodle Repository: movingimage video repository (repository_movingimage)

Browse, insert and upload videos from movingimage EVP (VideoManager Pro) in Moodle.

- Component: `repository_movingimage`
- Moodle: 4.5+
- License: GNU GPL v3 or later

## Features

- Browse movingimage video channels in any Moodle file picker
- Enlarged preview still shown on hover and in the selection dialog
- Insert videos as external links (embedded via the configured player)
- Optionally choose a different player per insert via the picker search form
  (falls back to the globally configured default player)
- Upload new videos to movingimage EVP directly from Moodle via the virtual
  "Upload new video" folder shown at the repository root
- Full-text and advanced search (tags, duration and date filters)
- Optional SSO (Keycloak) authentication, with auto-creation of users,
  content groups and channels
- Per-upload security policy, auto-deletion retention period and custom
  metadata mapping (course name, uploader name, uploader email)

## Installation

- Copy this folder to: `/path/to/moodle/repository/movingimage/`
- Visit Site administration → Notifications to complete installation

## Configuration

- Site administration → Plugins → Repositories → movingimage video repository
- Requires movingimage EVP credentials or SSO
- Connection, player, channels, SSO and upload settings (security policy,
  auto-deletion, metadata fields) are all configured here
- Player ID, security policy and metadata fields can be chosen via
  API-backed dropdowns once a connection is established
- The configured player is the default; users can override it per insert
  from the picker search form

## Usage

- In any file picker, select "movingimage video repository"
- Browse channels and pick a video to insert, or open the
  "Upload new video" folder to upload a file to movingimage EVP
- To embed with a non-default player, click "Search" in the picker and
  choose a player from the "Player" drop-down before inserting

## History

- This plugin previously shipped as two separate plugins,
  `repository_movingimagepicker` (browse/pick) and
  `repository_movingimageupload` (upload). They have been merged into this
  single `repository_movingimage` plugin.

## Releases

- Version: v3.0 (2026061709)
- Maturity: stable

## Support

- Part of the movingimage Moodle Connector suite.
- Issues: please include Moodle version, plugin version, and reproduction steps.

Copyright (C) 2019 Rainer Möller
Copyright (C) 2025 lern.link GmbH, Vadym Nersesov
