# VAM OpenAPI Documentation — Reference

> Auto-generated from the OpenAPI spec. **Version:** 1.0.0  
> **Contact:** movingimage EVP GmbH — support@movingimage.com — http://www.movingimage.com  
> **Base URL:** `https://api.video-cdn.net/`

Source spec: `https://api.video-cdn.net/v1/openapi`

## Authentication

### `bearerAuth`

- **Type:** http
- **Scheme:** bearer
- **Bearer format:** JWT

### `oauth2`

- **Type:** oauth2
- **OAuth2 flow:** authorizationCode
  - Authorization URL: `https://login.movingimage.com/auth/realms/platform/protocol/openid-connect/auth`
  - Token URL: `https://login.movingimage.com/auth/realms/platform/protocol/openid-connect/token`
  - Refresh URL: `https://login.movingimage.com/auth/realms/platform/protocol/openid-connect/token`

## Endpoints by section

- [AI Indexing](#ai-indexing) — 5 endpoint(s)
- [Access Profile](#access-profile) — 3 endpoint(s)
- [Access to VideoManagers](#access-to-videomanagers) — 1 endpoint(s)
- [Authentication](#authentication) — 2 endpoint(s)
- [Channel Attachment](#channel-attachment) — 5 endpoint(s)
- [Channel metadata](#channel-metadata) — 5 endpoint(s)
- [Channels Collection](#channels-collection) — 6 endpoint(s)
- [Custom Metadata Fields](#custom-metadata-fields) — 1 endpoint(s)
- [Custom metadata for videos](#custom-metadata-for-videos) — 3 endpoint(s)
- [Download URL](#download-url) — 1 endpoint(s)
- [Duplicate Video](#duplicate-video) — 1 endpoint(s)
- [Editing](#editing) — 1 endpoint(s)
- [Embed codes](#embed-codes) — 1 endpoint(s)
- [Group UI Integration](#group-ui-integration) — 1 endpoint(s)
- [Keywords Collection](#keywords-collection) — 4 endpoint(s)
- [Metadata Sets](#metadata-sets) — 1 endpoint(s)
- [Overlays](#overlays) — 1 endpoint(s)
- [Ownership Groups](#ownership-groups) — 1 endpoint(s)
- [Player definitions](#player-definitions) — 1 endpoint(s)
- [Publication periods](#publication-periods) — 4 endpoint(s)
- [Searching filter](#searching-filter) — 1 endpoint(s)
- [Security Override - Video](#security-override-video) — 2 endpoint(s)
- [Security Override - VideoManager](#security-override-videomanager) — 3 endpoint(s)
- [Security Policy](#security-policy) — 4 endpoint(s)
- [Security override](#security-override) — 1 endpoint(s)
- [Source](#source) — 1 endpoint(s)
- [Subtitles](#subtitles) — 6 endpoint(s)
- [Thumbnail Collection](#thumbnail-collection) — 1 endpoint(s)
- [Transcoding Status](#transcoding-status) — 1 endpoint(s)
- [Trash bin video](#trash-bin-video) — 3 endpoint(s)
- [Usage Summary](#usage-summary) — 1 endpoint(s)
- [Video](#video) — 10 endpoint(s)
- [Video Analytics](#video-analytics) — 1 endpoint(s)
- [Video Attachment](#video-attachment) — 2 endpoint(s)
- [Video Replacement](#video-replacement) — 1 endpoint(s)
- [Video Stills](#video-stills) — 6 endpoint(s)
- [(untagged)](#untagged) — 7 endpoint(s)

---

## AI Indexing

_Creates metadata for your videos based on AI indexing of your videos._

### `GET` `/v1/vms/{videoManagerId}/ai-indexing/ai-index-languages`

Get available languages to index a video

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoManagerId` | path | yes | number | Numeric id of the desired VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | array&lt;[`SourceLanguageDTO`](#schema-sourcelanguagedto)&gt; |

---

### `GET` `/v1/vms/{videoManagerId}/ai-indexing/subtitle-languages`

Get available languages to generate subtitle for an indexed video

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoManagerId` | path | yes | number | Numeric id of the desired VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | object |

---

### `POST` `/v1/vms/{videoManagerId}/ai-indexing/{videoId}/generate-metadata`

Generate ai metadata for a specific video

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoId` | path | yes | string |  |
| `videoManagerId` | path | yes | number | Numeric id of the desired VideoManager. |
| `generate_keywords` | query | no | boolean |  |
| `generate_labels` | query | no | boolean |  |
| `generate_topics` | query | no | boolean |  |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 204 | No Content |  |

---

### `POST` `/v1/vms/{videoManagerId}/ai-indexing/{videoId}/generate-subtitle`

Generate subtitle for a specific video

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoId` | path | yes | string |  |
| `videoManagerId` | path | yes | number | Numeric id of the desired VideoManager. |

**Request body** (optional)

- `application/json`: [`CreateAISubtitleDto`](#schema-createaisubtitledto)

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 201 | Created |  |

---

### `POST` `/v1/vms/{videoManagerId}/ai-indexing/{videoId}/index`

Indexes a specific video

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoId` | path | yes | string |  |
| `videoManagerId` | path | yes | number | Numeric id of the desired VideoManager. |

**Request body** (optional)

- `application/json`: [`AiIndexingRequestDTO`](#schema-aiindexingrequestdto)

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 204 | No Content |  |

---

## Access Profile

### `GET` `/v1/vms/{videoManagerId}/security/access-profiles`

Gets all access profiles in the specified VideoManager

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoManagerId` | path | yes | number | Numeric id of the desired VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | object |

---

### `GET` `/v1/vms/{videoManagerId}/security/access-profiles/{accessProfileId}`

Returns the name and ID of a specific access profile.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `accessProfileId` | path | yes | integer (int64) |  |
| `videoManagerId` | path | yes | number | Numeric id of the desired VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | object |

---

### `GET` `/v1/vms/{videoManagerId}/videos/{videoId}/access-profile`

Returns the access profile assigned to a specific video.

When the video's access profile is set to the global setting, it will return an empty body with the status: 204. See the "Update a specific video" PATCH request above for information about how to set a video's access profile.
See also the Access Profiles Collection chapter below for more information.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | object |

---

## Access to VideoManagers

### `GET` `/v1/vms`

Returns a list of VideoManagers that you have access to.

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | object |

---

## Authentication

_Rest endpoint for authenticating users_

### `POST` `/v1/vms/auth/login`

Endpoint for logging into your VMPro account using JSON web access token

**Request body** (optional)

- `application/json`: [`LoginDTO`](#schema-logindto)

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | object |

---

### `POST` `/v1/vms/auth/refresh/{videoManagerId}`

Endpoint for refreshing your JSON authentication token

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoManagerId` | path | yes | integer (int64) |  |

**Request body** (optional)

- `application/json`: [`RefreshDTO`](#schema-refreshdto)

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | object |

---

## Channel Attachment

_Get information about or delete a specific channel attachment by its ID.
_

### `GET` `/v1/vms/{videoManagerId}/channels/{channelId}/attachments`

Get channel attachments

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `channelId` | path | yes | number | Numeric id of the desired channel. |
| `videoManagerId` | path | yes | number | Numeric id of the desired VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | array&lt;[`AttachmentItemDTO`](#schema-attachmentitemdto)&gt; |

---

### `POST` `/v1/vms/{videoManagerId}/channels/{channelId}/attachments`

Create channel attachment

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `channelId` | path | yes | number | Numeric ìd of the channel the attachment should be added to. |
| `videoManagerId` | path | yes | number | Numeric id of the desired VideoManager. |

**Request body** (optional)

- `application/json`: [`CreateAttachmentDTO1`](#schema-createattachmentdto1)

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 201 | Created | string |

---

### `GET` `/v1/vms/{videoManagerId}/channels/{channelId}/attachments/{attachmentId}`

Get specific channel attachment

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `attachmentId` | path | yes | string | String id of the desired channel attachment. |
| `channelId` | path | yes | number | Numeric id of the desired channel. |
| `videoManagerId` | path | yes | number | Numeric id of the desired VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | object |

---

### `DELETE` `/v1/vms/{videoManagerId}/channels/{channelId}/attachments/{attachmentId}`

Delete channel attachment

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `attachmentId` | path | yes | string | String id of the desired channel attachment. |
| `channelId` | path | yes | number | Numeric id of the desired channel. |
| `videoManagerId` | path | yes | number | Numeric id of the desired VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK |  |

---

### `GET` `/v1/vms/{videoManagerId}/channels/{channelId}/attachments/{attachmentId}/url`

Get channel attachment upload URL

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `attachmentId` | path | yes | string | String id of the desired channel attachment. |
| `channelId` | path | yes | number | Numeric id of the desired channel. |
| `videoManagerId` | path | yes | number | Numeric id of the desired VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK |  |

---

## Channel metadata

_Calls for getting or updating channel metadata_

### `GET` `/v1/vms/{videoManagerId}/channels/{channelId}/metadata`

Returns all saved channel metadata. If the VideoManager has a metadata localization set, it will also be included in the response.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `channelId` | path | yes | number | Numeric id of the desired channel. |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | array&lt;[`ChannelMetadataDTO`](#schema-channelmetadatadto)&gt; |

---

### `GET` `/v1/vms/{videoManagerId}/channels/{channelId}/metadata/{metadataSetId}`

Returns specific channel metadata.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `channelId` | path | yes | number | Numeric id of the desired channel. |
| `metadataSetId` | path | yes | number | Numeric id of the desired metadata set. |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | object |

---

### `PATCH` `/v1/vms/{videoManagerId}/channels/{channelId}/metadata/{metadataSetId}`

Updates name or description of specific channel metadata. If the VideoManager has a metadata localization set, it will also be included in the response.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `channelId` | path | yes | number | Numeric id of the desired channel. |
| `metadataSetId` | path | yes | number | Numeric id of the desired metadata set. |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |

**Request body** (optional)

- `application/json`: object

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK |  |

---

### `GET` `/v1/vms/{videoManagerId}/channels/{channelId}/metadata/{metadataSetId}/custom-metadata`

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `channelId` | path | yes | integer (int64) |  |
| `metadataSetId` | path | yes | integer (int64) |  |
| `videoManagerId` | path | yes | integer (int64) |  |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK |  |

---

### `PUT` `/v1/vms/{videoManagerId}/channels/{channelId}/metadata/{metadataSetId}/custom-metadata`

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `channelId` | path | yes | integer (int64) |  |
| `metadataSetId` | path | yes | integer (int64) |  |
| `videoManagerId` | path | yes | integer (int64) |  |

**Request body** (optional)

- `application/json`: object

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK |  |

---

## Channels Collection

_Get, create or update channels_

### `GET` `/v1/vms/{videoManagerId}/channels`

Returns all channels of the specified VideoManager. Optionally, a videoId can also be specified to return a list of the channels assigned to that video.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoManagerId` | path | yes | number | Numeric `id` of the appropriate VideoManager. |
| `locale` | query | no | string | Optional. Specifies the locale in which the metadata is fetched. If given locale is not present, the default metadata set is returned |
| `videoId` | query | no | string | Numeric `id` of the desired video. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | object |

---

### `POST` `/v1/vms/{videoManagerId}/channels`

Creates a channel in the specified VideoManager.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |

**Request body** (optional)

- `application/json`: [`CreateChannelDTO`](#schema-createchanneldto)

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 201 | OK | , string |

---

### `PATCH` `/v1/vms/{videoManagerId}/channels/{channelId}`

Updates a channel specified by ID.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `channelId` | path | yes | number | Numeric id of the desired channel. |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |
| `adminMode` | query | no | boolean |  |

**Request body** (optional)

- `application/json`: object

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK |  |

---

### `DELETE` `/v1/vms/{videoManagerId}/channels/{channelId}`

Deletes a channel specified by ID.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `channelId` | path | yes | number | Numeric id of the desired channel. |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK |  |

---

### `POST` `/v1/vms/{videoManagerId}/channels/{channelId}/videos/{videoId}`

Adds a video to a specified channel.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `channelId` | path | yes | number | Numeric id of the desired channel. |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK |  |

---

### `DELETE` `/v1/vms/{videoManagerId}/channels/{channelId}/videos/{videoId}`

Removes a video from a specified channel.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `channelId` | path | yes | number | Numeric id of the desired channel. |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK |  |

---

## Custom Metadata Fields

_Gets custom metadata for a VideoManager._

### `GET` `/v1/vms/{videoManagerId}/custom-metadata-fields`

Gets custom metadata from a specific VideoManager. As well, you can specify a video and channel.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |
| `entityType` | query | no | [`EntityType`](#schema-entitytype) & object |  |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | array&lt;[`CustomMetadataFieldDTO`](#schema-custommetadatafielddto)&gt; |

---

## Custom metadata for videos

_Gets or update metadata for specific videos_

### `GET` `/v1/vms/{videoManagerId}/videos/{videoId}/metadata`

Returns metadata of the desired video specified by ID.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | object |

---

### `PATCH` `/v1/vms/{videoManagerId}/videos/{videoId}/metadata`

Update or delete custom metadata value

To update a custom metadata value, use an existing field name as the key. The value should be a valid option that will replace the existing value. "SELECT" and "MULTI_SELECT" field type values should exist within the available options list. The "DATE_TIME" values should be formatted correctly (yyyy-mm-ddThh:mm:ssZ or yyyy-mm-ddThh:mm:ss.sssZ).
To delete a custom metadata value, set the target key equal to null. Note that setting a MULTI_SELECT field value to null here will delete all values (see the Multi-select delete function below).
Provide metadata_set_id query parameter in order to update metadata of the specific set (no value will update the default set metadata)

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |
| `metadata_set_id` | query | no | integer (int64) |  |

**Request body** (optional)

- `application/json`: object

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 204 | No Content |  |

---

### `DELETE` `/v1/vms/{videoManagerId}/videos/{videoId}/metadata/option/{optionId}`

Delete a select option from a multi-select custom metadata of specific video

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `optionId` | path | yes | integer (int64) | Numeric `id` of the option |
| `videoId` | path | yes | string | String id of the desired video |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager |
| `metadata_set_id` | query | no | integer (int64) | Numeric `id` of the metadata set |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 204 | No Content |  |

---

## Download URL

### `GET` `/v1/vms/{videoManagerId}/videos/{videoId}/download-urls`

Get download URLs of specific video

To create download URLs with meaningful file names for the download file, you can set the optional parameter 'download_file_name_template'.The template may include some special placeholders that replace actual values. The value of the parameter is then the name of the downloaded file.
Supported placeholders:
* %{QUALITY} : e.g. 720p
* %{PROFILE_KEY} : e.g. aaa2356
* %{FILE_EXTENSION} : e.g. mp4

If needed: '%', '{', '}'-signs URL-encoded: for example, '%' => '%25', '{' => '%7B', '}' -> '%7D'

Sample value: video_version123_uploaded-20151027110400_%25%7BPROFILE_KEY%7D_%25%7BQUALITY%7D_.%25%7BFILE_EXTENSION%7D

Note
 For the download URLs in the response listed here, the optional query parameter 'download_file_name_template' is set.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |
| `download_file_name_template` | query | no | string | If this parameter is set and not empty, the URLs are prepared to enable the CDN to serve this string as the filename after downloading the file. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | array&lt;[`DownloadUrlDTO`](#schema-downloadurldto)&gt; |

---

## Duplicate Video

### `POST` `/v1/vms/{videoManagerId}/videos/duplication/{videoId}`

Duplicate Video

By means of this endpoint you can duplicate your video to specified channel with specified title.It is an asynchronous process. This means that it might take some time after the response is received before duplicated video appears

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoId` | path | yes | string | String id of the desired video |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager |
| `channelId` | query | no | number | Numeric ìd of the target channel. When not specified, it will fall back to the root channel id of the specified video manager |

**Request body** (optional)

- `application/json`: [`VideoDuplicationDTO`](#schema-videoduplicationdto)

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 201 | Duplication has been initiated. Please, find the 'location' header with the new video id in the response' |  |
| 404 | If video with the specified id is not published |  |

---

## Editing

_Rest endpoints for editing videos_

### `POST` `/v1/vms/{videoManagerId}/videos/{videoId}/edit/trim`

Trims a specific video within a specific VideoManager

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the desired VideoManager. |

**Request body** (optional)

- `application/json`: [`VideoTrimDto`](#schema-videotrimdto)

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 202 | Accepted |  |

---

## Embed codes

_Get embed codes_

### `GET` `/v1/vms/{videoManagerId}/videos/{videoId}/embed-codes`

Get embed codes of specific video

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |
| `channelId` | query | no | number | Numeric ìd of the desired channel. |
| `embedType` | query | no | string | If not specified, HTML-code will be returned for old players, iframe will be returned for new players. Possible values: 'iframe', 'html_code', 'link_url' or 'share_url'. |
| `player_definition_id` | query | yes | string | String id of the player definition. |
| `token_lifetime_in_seconds` | query | no | number | Numeric token lifetime if the VideoManager is configured for video player token protection. Default = 180 sec. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | object |

---

## Group UI Integration

_Integrate the VideoManager UI into your application without logging into VideoManager._

### `POST` `/v1/vms/auth/uiintegration`

Returns a valid access token for a UI integration. If the VideoManager ID is not specified, the first accessible VideoManager is accessed.

**Request body** (optional)

- `application/json`: [`UIIntegrationTokenRequestDTO`](#schema-uiintegrationtokenrequestdto)

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK |  |

---

## Keywords Collection

_Adds, updates or deletes keywords for specific videos_

### `GET` `/v1/vms/{videoManagerId}/keyword/find`

Retrieve a list of keywords for a VideoManager.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoManagerId` | path | yes | number | Numeric id of the desired VideoManager. |
| `searchstring` | query | no | string |  |
| `type` | query | no | [`KeywordType`](#schema-keywordtype) & object |  |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | array&lt;[`KeywordDto`](#schema-keyworddto)&gt; |

---

### `GET` `/v1/vms/{videoManagerId}/videos/{videoId}/keywords`

Returns keywords of the video specified by ID.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | desc | array&lt;[`KeywordDto`](#schema-keyworddto)&gt; |

---

### `POST` `/v1/vms/{videoManagerId}/videos/{videoId}/keywords`

Adds the specified keyword to a video.

Provide metadata_set_id query parameter in order to update metadata of the specific set (no value will update the default set metadata)

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |
| `metadata_set_id` | query | no | integer (int64) |  |

**Request body** (optional)

- `application/json`: [`KeywordDto`](#schema-keyworddto)

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | object |

---

### `DELETE` `/v1/vms/{videoManagerId}/videos/{videoId}/keywords/{keywordId}`

Removes a specific keyword from the video specified by ID.

Provide metadata_set_id query parameter in order to update metadata of the specific set (no value will update the default set metadata)

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `keywordId` | path | yes | integer (int64) |  |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |
| `metadata_set_id` | query | no | integer (int64) |  |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 204 | No Content |  |

---

## Metadata Sets

_Retrieve custom metadata set definitions_

### `GET` `/v1/vms/{videoManagerId}/metadata-sets`

Retrieve a list of custom metadata set definitions for a VideoManager.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoManagerId` | path | yes | integer (int64) |  |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | array&lt;[`MetadataSetDTO1`](#schema-metadatasetdto1)&gt; |

---

## Overlays

### `GET` `/v1/vms/{videoManagerId}/videos/{videoId}/overlays`

Get overlays of specific video.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | array&lt;[`OverlayDTO`](#schema-overlaydto)&gt; |

---

## Ownership Groups

### `GET` `/v1/vms/{videoManagerId}/security/ownership-groups`

Get ownership groups in the specified VideoManager

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoManagerId` | path | yes | number | Numeric id of the desired VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | object |

---

## Player definitions

_Get all player definitions_

### `GET` `/v1/vms/{videoManagerId}/players`

Returns the player definitions of a specific VideoManager.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | object |

---

## Publication periods

_Resource for managing publication periods_

### `GET` `/v1/vms/{videoManagerId}/videos/{videoId}/publication-period`

Returns a list of publication periods for a video

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | object |

---

### `POST` `/v1/vms/{videoManagerId}/videos/{videoId}/publication-period`

Creates a new publication period in a defined time range for a video.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |

**Request body** (optional)

- `application/json`: [`PublicationPeriodDTO1`](#schema-publicationperioddto1)

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK |  |

---

### `PATCH` `/v1/vms/{videoManagerId}/videos/{videoId}/publication-period/{publicationPeriodId}`

Updates a publication period of a video.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `publicationPeriodId` | path | yes | string | Numeric id of the publication period. |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |

**Request body** (optional)

- `application/json`: object

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK |  |

---

### `DELETE` `/v1/vms/{videoManagerId}/videos/{videoId}/publication-period/{publicationPeriodId}`

Deletes a publication period of a video.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `publicationPeriodId` | path | yes | string | Numeric id of the publication period. |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK |  |

---

## Searching filter

### `POST` `/v1/vms/{videoManagerId}/videos/search-filter`

Perform search based on the filtering rules with pagination.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoManagerId` | path | yes | integer (int64) |  |

**Request body** (optional)

- `application/json`: [`FilterRequestDTO`](#schema-filterrequestdto)

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | object |

---

## Security Override - Video

_Make assets for a specific video public_

### `POST` `/v1/vms/{videoManagerId}/videos/{videoId}/security-override`

Makes all assets for a specific video public

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |

**Request body** (optional)

- `application/json`: [`SecurityOverrideDto`](#schema-securityoverridedto)

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK |  |

---

### `DELETE` `/v1/vms/{videoManagerId}/videos/{videoId}/security-override`

Removes the security override for a specific video and makes its assets private/protected again

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK |  |

---

## Security Override - VideoManager

_Makes assets of a specific VideoManager visible._

### `GET` `/v1/vms/{videoManagerId}/security-override`

Displays all assets for a specific VideoManager that are public.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | object |

---

### `POST` `/v1/vms/{videoManagerId}/security-override`

Make all assets within a specific VideoManager public.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | Created |  |

---

### `DELETE` `/v1/vms/{videoManagerId}/security-override`

Removes the security override for a specific VideoManager and makes its assets private/protected again.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | Removed |  |

---

## Security Policy

### `GET` `/v1/vms/{videoManagerId}/security/security-policies`

Get security policies for a specific VideoManager

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoManagerId` | path | yes | number | Numeric id of the desired VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK |  |

---

### `GET` `/v1/vms/{videoManagerId}/security/security-policies/global-policy`

Returns the name and ID of global security policy.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoManagerId` | path | yes | number | Numeric id of the desired VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | desc | object |

---

### `GET` `/v1/vms/{videoManagerId}/security/security-policies/{securityPolicyId}`

Get a specific security policy for a VideoManager

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `securityPolicyId` | path | yes | integer (int64) |  |
| `videoManagerId` | path | yes | number | Numeric id of the desired VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | object |

---

### `GET` `/v1/vms/{videoManagerId}/videos/{videoId}/security-policy`

Get security policy of a specific video

Returns the security policy assigned to a specific video. When the video's security policy is set to the global setting, it will return an empty body with the status: 204. See the "Update a specific video" PATCH request above for information about how to set a video's security policy.
See the Security Policies Collection chapter below for more information about security policies.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | object |

---

## Security override

### `POST` `/v1/vms/{videoManagerId}/asset-type/security-override`

Enables the security override for your VideoManager Pro account to make particular asset types public.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |

**Request body** (optional)

- `application/json`: [`SecurityOverrideDto`](#schema-securityoverridedto)

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK |  |

---

## Source

_Create new source for a video_

### `POST` `/v1/vms/{videoManagerId}/videos/{videoId}/source`

Creates a new video source for specified videoId

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |

**Request body** (optional)

- `application/json`: [`SourceDto`](#schema-sourcedto)

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK |  |

---

## Subtitles

_Get, update, or remove a specific subtitle from a video specified by ID_

### `GET` `/v1/vms/{videoManagerId}/videos/{videoId}/subtitles`

Get subtitles for video.

OK

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the desired VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | array&lt;[`SubtitleDTO`](#schema-subtitledto)&gt; |

---

### `POST` `/v1/vms/{videoManagerId}/videos/{videoId}/subtitles`

Create subtitle for specific video.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the desired VideoManager. |

**Request body** (optional)

- `application/json`: [`CreateSubtitleDTO`](#schema-createsubtitledto)

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 201 | Created |  |

---

### `GET` `/v1/vms/{videoManagerId}/videos/{videoId}/subtitles/{subtitleId}`

Get specific subtitle.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `subtitleId` | path | yes | number | Numeric id of the desired subtitle. |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the desired VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | object |

---

### `PATCH` `/v1/vms/{videoManagerId}/videos/{videoId}/subtitles/{subtitleId}`

Partial update?

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `subtitleId` | path | yes | number | Numeric id of the desired subtitle. |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the desired VideoManager. |

**Request body** (optional)

- `application/json`: object

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 204 | No Content |  |

---

### `DELETE` `/v1/vms/{videoManagerId}/videos/{videoId}/subtitles/{subtitleId}`

Delete specific subtitle from a specific video.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `subtitleId` | path | yes | number | Numeric id of the desired subtitle. |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the desired VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 204 | Specific subtitle |  |

---

### `GET` `/v1/vms/{videoManagerId}/videos/{videoId}/subtitles/{subtitleId}/url`

Get subtitle upload URL.

To create and upload subtitles, follow the steps below: 
1. Create a subtitle for a specific video (using the POST request in the resource above). The response header will contain a location URL with a number at the end; this is the new subtitle's id number.
2. Use the id number to get the subtitle upload URL by using the GET request below.
3. The response header will contain a location URL for uploading the subtitle file.
4. Use this location URL to make a POST request to upload the subtitle file:
* Content-Type: application/x-www-form-urlencoded
* Body: file=path-to-subtitle-file

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `subtitleId` | path | yes | number | Numeric id of the desired subtitle. |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the desired VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | desc |  |

---

## Thumbnail Collection

### `GET` `/v1/vms/{videoManagerId}/videos/thumbnails`

Get thumbnails for specific VideoManager

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | array&lt;[`ThumbnailListDTO`](#schema-thumbnaillistdto)&gt; |

---

## Transcoding Status

### `GET` `/v1/vms/{videoManagerId}/videos/{videoId}/transcoding-status`

Returns the transcoding status of the video specified by ID.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the desired VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | array&lt;[`TranscodingStatusDTO`](#schema-transcodingstatusdto)&gt; |

---

## Trash bin video

### `GET` `/v1/vms/{videoManagerId}/trash/videos`

Returns a list of deleted videos from a certain VideoManager with optional query parameters.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoManagerId` | path | yes | integer (int64) |  |
| `limit` | query | no | integer (int32) |  |
| `offset` | query | no | integer (int32) |  |
| `order` | query | no | [`Order`](#schema-order) & object |  |
| `order_property` | query | no | string |  |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | object |

---

### `PATCH` `/v1/vms/{videoManagerId}/trash/videos/{videoId}`

Restore video from trash bin

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoId` | path | yes | string |  |
| `videoManagerId` | path | yes | integer (int64) |  |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK |  |

---

### `DELETE` `/v1/vms/{videoManagerId}/trash/videos/{videoId}`

Permanently deletes video from trash bin.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoId` | path | yes | string |  |
| `videoManagerId` | path | yes | integer (int64) |  |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 204 | NO_CONTENT |  |

---

## Usage Summary

### `GET` `/v1/vms/{videoManagerId}/usage`

Gets usage summary of a specific VideoManager.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoManagerId` | path | yes | number | Numeric id of the desired VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | object |

---

## Video

_Get, create or update videos_

### `GET` `/v1/vms/{videoManagerId}/videos`

Returns a list of videos from a certain VideoManager with optional query parameters.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |
| `archivedState` | query | no | string | Optional. Specifies the archive state of videos to be fetched. If given state is not present, not archived videos are returned.Note: Since archived videos can not be published, fetching archived videos in the published state always returns empty list. |
| `audio_only` | query | no | boolean | Optional. Specifies whether the results should be audio-only files. |
| `channel_id` | query | no | array&lt;object&gt; | Optional. Numeric id of the desired channel. To include multiple channels, employ this option multiple times. |
| `custom_metadata_field` | query | no | string | Optional. This parameter can only be used if 'include_custom_metadata = true'. The field name of the custom metadata field value you want to retrieve. You can retrieve multiple custom_meta_data values by adding this parameter with another key. |
| `exact_string` | query | no | boolean |  |
| `include_channel_assignments` | query | no | boolean | Optional. If true, the response includes a list of channels the video is assigned to (containing each channel's name and ID). |
| `include_custom_metadata` | query | no | boolean | Optional. Specifies whether custom metadata should be returned. |
| `include_keywords` | query | no | boolean | Optional. If true, keywords are retrieved. |
| `include_owner` | query | no | boolean | Optional. Returns email address for the uploader and the current owner of the video. |
| `include_sub_channels` | query | no | boolean |  |
| `limit` | query | no | number | Optional. Number of videos that are retrieved. |
| `locale` | query | no | string | Optional. Specifies the locale in which the metadata is fetched. If given locale is not present, the default metadata set is returned. |
| `offset` | query | no | number | Optional. Item number of the video list to start from. |
| `order` | query | no | string | Optional. Sort order of the video list. asc = ascending, desc=descending (default). |
| `order_property` | query | no | string |  |
| `publication_state` | query | no | string | Optional. Filtering the videos based on their publication status. |
| `search_in_field` | query | no | string | Optional. The field name of the value you want to retrieve (title, description, keywords, and any of the custom metadata fields are all supported). This parameter can only be used if the parameter 'search_term' contains a non-empty value. |
| `search_term` | query | no | string | Optional. Search term for this request (note that it is possible to search by original filename even after renaming the video). To use multiple search terms, employ this option multiple times. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | object |

---

### `POST` `/v1/vms/{videoManagerId}/videos`

Create a video

Creates a video entity for uploading a new video to the desired VideoManager account.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoManagerId` | path | yes | number | ID number of the desired VideoManager. |

**Request body** (optional)

- `application/json`: [`VideoUploadRequestDTO`](#schema-videouploadrequestdto)

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 201 | Created |  |

---

### `GET` `/v1/vms/{videoManagerId}/videos/videoIds`

Returns a list of videos from a certain VideoManager with optional query parameters.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | array&lt;string&gt; |

---

### `GET` `/v1/vms/{videoManagerId}/videos/{videoId}`

Returns a single video, specified by its ID. Optional query parameters can be added to refine your request.

Note: Please keep in mind that when a video is deleted via this API, it is moved to the trash. There is currently no way to permanently delete a video via the API.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |
| `custom_metadata_field` | query | no | string | Optional. This parameter can only be used if 'include_custom_metadata = true'. The field name of the custom metadata field value you want to retrieve. It is possible to specify multiple values separated by a comma. |
| `ignore_publication_state` | query | no | boolean | Optional. If true, a video is returned even when its status is unpublished. |
| `include_channel_assignments` | query | no | boolean | Optional. If true, the response includes a list of channels the video is assigned to (containing each channel's name and ID). |
| `include_custom_metadata` | query | no | boolean | Optional. If true, custom metadata is included in the response. |
| `include_keywords` | query | no | boolean | Optional. If true, keywords are retrieved. |
| `include_owner` | query | no | boolean | Optional. Returns the uploader and the current owner of the video. |
| `metadata_set_id` | query | no | number | Numeric id of metadata set. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | object |

---

### `PATCH` `/v1/vms/{videoManagerId}/videos/{videoId}`

Updates video metadata

In addition to items in the video object, it is also possible to update the following data: relatedVideosChannelId, adConfigurationId, scheduledTrashDate, securityPolicyId, and accessProfileId. These all behave similarly, except for scheduledTrashDate: You can set them to their respective resource's ID or set the ID to 0 to unlink it. scheduledTrashDate should be set to null if no scheduled deletion date is desired; otherwise provide a timestamp in ISO 8601 format. The ad configuration, security policy, and access profile will use the global setting when set to 0. Provide metadata_set_id query parameter in order to update metadata of the specific set (no value will update the default set metadata)

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |
| `metadata_set_id` | query | no | number | Numeric id of metadata set. |

**Request body** (optional)

- `application/json`: object

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 204 | No Content |  |

---

### `DELETE` `/v1/vms/{videoManagerId}/videos/{videoId}`

Delete a specific video

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 204 | No Content |  |

---

### `GET` `/v1/vms/{videoManagerId}/videos/{videoId}/ad-configuration`

Get ad configurations of specific VideoManager

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | object |

---

### `GET` `/v1/vms/{videoManagerId}/videos/{videoId}/metadata/corporate-tube`

Get video CorporateTube metadata

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | object |

---

### `PATCH` `/v1/vms/{videoManagerId}/videos/{videoId}/metadata/corporate-tube`

Update the CorporateTube metadata

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |

**Request body** (optional)

- `application/json`: object

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK |  |
| 204 | No Content |  |

---

### `GET` `/v1/vms/{videoManagerId}/videos/{videoId}/url`

Get upload URL

After the video entity has been created successfully, you can get the upload URL. The upload URL is sent back in the HTTP response header under location. For instructions on how to use the upload URL to complete the upload process, see the movingimage Documentation Portal.
Please note that the token is valid for four hours. This means that if the video upload takes longer than four hours to complete, an error will occur. If this happens, perform this request again to generate a new upload URL.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK |  |

---

## Video Analytics

_Get videos with analytics data_

### `GET` `/v1/vms/{videoManagerId}/analytics/videos`

Returns a list of videos with analytics from a certain VideoManager.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoManagerId` | path | yes | number | Numeric id of the appropriate VideoManager. |
| `analyticsEndDateTime` | query | no | string | Optional. Sets the beginning timestamp for the analytics data. It is only supported if NPAW (Youbora) analytics is enabled |
| `analyticsStartDateTime` | query | no | string | Optional. Sets the beginning timestamp for the analytics data. It is only supported if NPAW (Youbora) analytics is enabled |
| `limit` | query | no | number | Optional. Number of videos with analytics that are retrieved. It will be ignored if 'videoIds' is present.The maximum allowed value per request is 100 |
| `offset` | query | no | number | Optional. Item number of the video list with analytics to start from. It will be ignored if 'videoIds' is present. |
| `videoIds` | query | no | array&lt;object&gt; | List of video IDs to retrieve. The maximum allowed size per request is 100 |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | object |

---

## Video Attachment

_Get attachments of a specific video._

### `GET` `/v1/vms/{videoManagerId}/videos/{videoId}/attachments`

Gets all attachments of a specific video.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the desired VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | array&lt;[`AttachmentItemDTO`](#schema-attachmentitemdto)&gt; |

---

### `GET` `/v1/vms/{videoManagerId}/videos/{videoId}/attachments/{attachmentId}`

Gets a specific attachment of the desired video by ID.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `attachmentId` | path | yes | string | String id of the desired channel attachment. |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the desired VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | object |

---

## Video Replacement

_Replace a specific video with another video._

### `POST` `/v1/vms/{videoManagerId}/videos/{videoId}/replacement/{otherVideoId}`

Replace the video files of the original video with those of another.

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `otherVideoId` | path | yes | string | String id of the replacement video. |
| `videoId` | path | yes | string | String id of the original video. |
| `videoManagerId` | path | yes | number | Numeric id of the desired VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK |  |

---

## Video Stills

_Retrives, updates, and deletes video stills_

### `GET` `/v1/vms/{videoManagerId}/videos/{videoId}/thumbnails`

Retrieves a still of a specific video

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the desired VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK | array&lt;[`StillViewDTO`](#schema-stillviewdto)&gt; |

---

### `POST` `/v1/vms/{videoManagerId}/videos/{videoId}/thumbnails`

Uploads the still of a specific video

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the desired VideoManager. |
| `timestamp` | query | no | integer (int64) |  |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK |  |

---

### `PATCH` `/v1/vms/{videoManagerId}/videos/{videoId}/thumbnails/{stillId}`

Replaces a specific still

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `stillId` | path | yes | number | Numeric id of the desired still. |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the desired VideoManager. |

**Request body** (optional)

- `application/json`: object

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK |  |

---

### `DELETE` `/v1/vms/{videoManagerId}/videos/{videoId}/thumbnails/{stillId}`

Deletes the specific still of a specific video

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `stillId` | path | yes | number | Numeric id of the desired still. |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the desired VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK |  |

---

### `GET` `/v1/vms/{videoManagerId}/videos/{videoId}/thumbnails/{stillId}/upload-url`

Retrieves the still of a specific video

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `stillId` | path | yes | number | Numeric id of the desired still. |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the desired VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK |  |

---

### `GET` `/v1/vms/{videoManagerId}/videos/{videoId}/thumbnails/{stillId}/url`

Retrieves a specific still

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `stillId` | path | yes | number | Numeric id of the desired still. |
| `videoId` | path | yes | string | String id of the desired video. |
| `videoManagerId` | path | yes | number | Numeric id of the desired VideoManager. |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK |  |

---

## (untagged)

### `GET` `/v1/vms/{videoManagerId}/ad_configurations`

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoManagerId` | path | yes | integer (int64) |  |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK |  |

---

### `POST` `/v1/vms/{videoManagerId}/ad_configurations`

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `videoManagerId` | path | yes | integer (int64) |  |

**Request body** (optional)

- `application/json`: [`AdConfigurationDTO`](#schema-adconfigurationdto)

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK |  |

---

### `GET` `/v1/vms/{videoManagerId}/ad_configurations/{adConfigurationId}`

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `adConfigurationId` | path | yes | integer (int64) |  |
| `videoManagerId` | path | yes | integer (int64) |  |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK |  |

---

### `PATCH` `/v1/vms/{videoManagerId}/ad_configurations/{adConfigurationId}`

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `adConfigurationId` | path | yes | integer (int64) |  |
| `videoManagerId` | path | yes | integer (int64) |  |

**Request body** (optional)

- `application/json`: object

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK |  |

---

### `DELETE` `/v1/vms/{videoManagerId}/ad_configurations/{adConfigurationId}`

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `adConfigurationId` | path | yes | integer (int64) |  |
| `videoManagerId` | path | yes | integer (int64) |  |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK |  |

---

### `POST` `/v1/vms/{videoManagerId}/channels/{channelId}/security-override`

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `channelId` | path | yes | integer (int64) |  |
| `videoManagerId` | path | yes | integer (int64) |  |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK |  |

---

### `DELETE` `/v1/vms/{videoManagerId}/channels/{channelId}/security-override`

**Parameters**

| Name | In | Required | Type | Description |
| --- | --- | --- | --- | --- |
| `channelId` | path | yes | integer (int64) |  |
| `videoManagerId` | path | yes | integer (int64) |  |

**Responses**

| Code | Description | Body |
| --- | --- | --- |
| 200 | OK |  |

---

## Schemas

### Schema: `AccessControlEntryDTO`

<a id="schema-accesscontrolentrydto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `aceId` | integer (int64) | no |  |
| `groupId` | integer (int64) | yes |  |
| `accessProfileId` | integer (int64) | yes |  |

### Schema: `AccessProfileDTO`

<a id="schema-accessprofiledto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `name` | string | no |  |
| `description` | string | no |  |
| `permissions` | array&lt;string&gt; | no |  |

### Schema: `AccountOverviewView`

<a id="schema-accountoverviewview"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `videoManagerInfo` | [`VideoManagerInfo`](#schema-videomanagerinfo) | no |  |
| `userInfo` | [`UserInfo`](#schema-userinfo) | no |  |
| `videoStorageInfo` | [`VideoStorageInfo`](#schema-videostorageinfo) | no |  |
| `archivedVideoStorageInfo` | [`ArchivedVideoStorageInfo`](#schema-archivedvideostorageinfo) | no |  |
| `trafficInfo` | [`TrafficInfo`](#schema-trafficinfo) | no |  |
| `indexingInfo` | [`IndexingInfo`](#schema-indexinginfo) | no |  |
| `videoCount` | integer (int64) | no |  |
| `groupTrafficStorage` | array&lt;[`GroupReportDto`](#schema-groupreportdto)&gt; | no |  |
| `groupInfo` | [`GroupInfo`](#schema-groupinfo) | no |  |

### Schema: `ActionType`

<a id="schema-actiontype"></a>

**Type:** enum

- `SEND_EMAIL`
- `GET_REQUEST`
- `POST_REQUEST`

### Schema: `AdConfigurationDTO`

<a id="schema-adconfigurationdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `videoManagerId` | integer (int64) | no |  |
| `title` | string | no |  |
| `description` | string | no |  |
| `preRollUrl` | string | no |  |
| `midRollUrl` | string | no |  |
| `postRollUrl` | string | no |  |

### Schema: `AiIndexingRequestDTO`

<a id="schema-aiindexingrequestdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `sourceLanguage` | string | yes |  |
| `generateKeywords` | boolean | no |  |
| `generateLabels` | boolean | no |  |
| `generateTopics` | boolean | no |  |
| `generateSubtitles` | boolean | no |  |

### Schema: `AiIndexingStatus`

<a id="schema-aiindexingstatus"></a>

**Type:** enum

- `NOT_TRIGGERED`
- `TRIGGERED`
- `FAILED`
- `COMPLETED`

### Schema: `AiSubtitleLocale`

<a id="schema-aisubtitlelocale"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `locale` | string | no |  |

### Schema: `AnalyticsReportDTO`

<a id="schema-analyticsreportdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `startDateTime` | string (date-time) | yes |  |
| `endDateTime` | string (date-time) | yes |  |
| `emails` | array&lt;string&gt; | no |  |

### Schema: `ApprovalRequest`

<a id="schema-approvalrequest"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `action` | object | yes |  |

### Schema: `ApproverSettingsDTO`

<a id="schema-approversettingsdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `approverEmails` | array&lt;string&gt; | no |  |
| `approverDomains` | array&lt;string&gt; | no |  |

### Schema: `ApproverTokenRequest`

<a id="schema-approvertokenrequest"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `email` | string | yes |  |

### Schema: `ApproverTokenVerifyRequest`

<a id="schema-approvertokenverifyrequest"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `email` | string | yes |  |
| `code` | string | yes |  |

### Schema: `ApproversDto`

<a id="schema-approversdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `userIds` | array&lt;integer (int64)&gt; | no |  |
| `emails` | array&lt;string&gt; | no |  |
| `domains` | array&lt;string&gt; | no |  |

### Schema: `ArchivedState`

<a id="schema-archivedstate"></a>

**Type:** enum

- `ARCHIVED`
- `NOT_ARCHIVED`
- `ALL`

### Schema: `ArchivedVideoStorageInfo`

<a id="schema-archivedvideostorageinfo"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `currentValue` | integer (int64) | no |  |
| `maxValue` | integer (int64) | no |  |
| `sizeValue` | number (double) | no |  |

### Schema: `ArrayFieldFilterDTO`

<a id="schema-arrayfieldfilterdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `type` | [`SearchFilterType`](#schema-searchfiltertype) | yes | Type of the filter field |
| `field` | [`FilterField`](#schema-filterfield) | no | Field to filter on |
| `any_of` | array&lt;string&gt; | no |  |
| `none_of` | array&lt;string&gt; | no |  |

### Schema: `AspectRatioDto`

<a id="schema-aspectratiodto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `width` | integer (int32) | no |  |
| `height` | integer (int32) | no |  |

### Schema: `AssetFailedReason`

<a id="schema-assetfailedreason"></a>

**Type:** enum

- `CORRUPTED_FILE`
- `NOT_SUPPORTED_FILE`
- `UNKNOWN`

### Schema: `AssetStatus`

<a id="schema-assetstatus"></a>

**Type:** enum

- `UPLOADING`
- `UPLOADED`
- `FAILED`

### Schema: `AssetType`

<a id="schema-assettype"></a>

**Type:** object

### Schema: `AttachmentDTO`

<a id="schema-attachmentdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | string | no |  |
| `fileName` | string | no |  |
| `downloadUrl` | string | no |  |
| `fileSize` | integer (int64) | no |  |

### Schema: `AttachmentItemDTO`

<a id="schema-attachmentitemdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `type` | [`AttachmentTypeDTO1`](#schema-attachmenttypedto1) | no |  |
| `data` | [`AttachmentDTO`](#schema-attachmentdto) | no |  |

### Schema: `AttachmentTypeDTO`

<a id="schema-attachmenttypedto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | string | no |  |
| `name` | string | yes |  |
| `disabled` | boolean | no |  |
| `entityType` | [`EntityType`](#schema-entitytype) | no |  |
| `allowedFileTypes` | array&lt;string&gt; | no |  |

### Schema: `AttachmentTypeDTO1`

<a id="schema-attachmenttypedto1"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | string | no |  |
| `name` | string | no |  |
| `allowedFileTypes` | array&lt;string&gt; | no |  |

### Schema: `AudioDTO`

<a id="schema-audiodto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `codec` | [`CodecDTO`](#schema-codecdto) | no |  |
| `bitRate` | integer (int32) | no |  |
| `sampleRate` | integer (int32) | no |  |
| `channels` | integer (int32) | no |  |

### Schema: `AudioStreamDTO`

<a id="schema-audiostreamdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `index` | integer (int32) | no |  |
| `language` | string | no |  |
| `title` | string | no |  |
| `defaultTrack` | boolean | no |  |
| `channelLayout` | string | no |  |
| `sampleRate` | integer (int64) | no |  |
| `codec` | string | no |  |
| `bitRate` | integer (int64) | no |  |
| `duration` | integer (int64) | no |  |

### Schema: `AudioStreamDto`

<a id="schema-audiostreamdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `index` | integer (int32) | no |  |
| `codec` | string | no |  |
| `bitRate` | integer (int64) | no |  |
| `duration` | integer (int64) | no |  |
| `codecTimeBase` | string | no |  |
| `channelLayout` | string | no |  |
| `sampleRate` | integer (int64) | no |  |
| `language` | string | no |  |
| `title` | string | no |  |
| `defaultTrack` | boolean | no |  |

### Schema: `AzureLocaleDto`

<a id="schema-azurelocaledto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `languageCode` | string | no |  |

### Schema: `BigPlayButtonDTO`

<a id="schema-bigplaybuttondto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `customButton` | string | yes |  |
| `dimension` | [`ButtonDimensionDTO`](#schema-buttondimensiondto) | yes |  |
| `position` | [`ButtonPositionDTO`](#schema-buttonpositiondto) | yes |  |

### Schema: `BooleanFilterFieldDTO`

<a id="schema-booleanfilterfielddto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `type` | [`SearchFilterType`](#schema-searchfiltertype) | yes | Type of the filter field |
| `field` | [`FilterField`](#schema-filterfield) | no | Field to filter on |
| `equals` | boolean | no |  |

### Schema: `BreakpointDTO`

<a id="schema-breakpointdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `min` | integer (int32) | no |  |
| `max` | integer (int32) | no |  |
| `playButton` | boolean | no |  |
| `stopButton` | boolean | no |  |
| `seekBar` | boolean | no |  |
| `mute` | boolean | no |  |
| `volume` | boolean | no |  |
| `loop` | boolean | no |  |
| `currentTime` | boolean | no |  |
| `duration` | boolean | no |  |
| `fullScreen` | boolean | no |  |
| `subtitleMenu` | boolean | no |  |
| `quality` | boolean | no |  |

### Schema: `BulkAction`

<a id="schema-bulkaction"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `actionType` | [`BulkActionType`](#schema-bulkactiontype) | no |  |

### Schema: `BulkActionRequest`

<a id="schema-bulkactionrequest"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `videoIds` | array&lt;string&gt; | yes |  |
| `action` | [`BulkAction`](#schema-bulkaction) | yes |  |

### Schema: `BulkActionType`

<a id="schema-bulkactiontype"></a>

**Type:** enum

- `ARCHIVE`
- `UNARCHIVE`
- `MOVE_TO_TRASH`
- `RESTORE_FROM_TRASH`
- `PERMANENTLY_DELETE`
- `TRIGGER_AI_STANDARD_INDEXING`
- `UPDATE_PUBLISH_SETTINGS`
- `UPDATE_OWNERSHIP_SETTINGS`
- `UPDATE_SECURITY_POLICY`
- `UPDATE_RETENTION_POLICY`
- `UPDATE_DELETION_DATE`
- `UPDATE_ARCHIVE_DATE`
- `ADD_KEYWORDS`

### Schema: `BulkEditDTO`

<a id="schema-bulkeditdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `videoIds` | array&lt;string&gt; | no |  |
| `metadataSetId` | integer (int64) | no |  |
| `changeSets` | array&lt;[`ChangeSetDTO`](#schema-changesetdto)&gt; | no |  |

### Schema: `ButtonDTO`

<a id="schema-buttondto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `dimension` | [`ButtonDimensionDTO`](#schema-buttondimensiondto) | yes |  |
| `position` | [`ButtonPositionDTO`](#schema-buttonpositiondto) | yes |  |

### Schema: `ButtonDimensionDTO`

<a id="schema-buttondimensiondto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `width` | integer (int32) | no |  |
| `height` | integer (int32) | no |  |

### Schema: `ButtonPositionDTO`

<a id="schema-buttonpositiondto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `x` | integer (int32) | no |  |
| `y` | integer (int32) | no |  |

### Schema: `ChangeSetDTO`

<a id="schema-changesetdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `type` | [`ChangeSetType`](#schema-changesettype) | yes |  |

### Schema: `ChangeSetType`

<a id="schema-changesettype"></a>

**Type:** enum

- `METADATA`
- `KEYWORDS`
- `CUSTOM_METADATA`

### Schema: `ChannelDto`

<a id="schema-channeldto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `name` | string | yes |  |
| `description` | string | no |  |
| `parentId` | integer (int64) | no |  |
| `children` | array&lt;[`ChannelDto`](#schema-channeldto)&gt; | no |  |
| `rootChannel` | boolean | no |  |
| `locked` | boolean | no |  |
| `disabled` | boolean | no |  |
| `createdDate` | integer (int64) | no |  |
| `modifiedDate` | integer (int64) | no |  |
| `owner` | [`ChannelOwnerDto`](#schema-channelownerdto) | no |  |
| `permissions` | array&lt;[`Permission`](#schema-permission)&gt; | no |  |
| `userGroupId` | integer (int64) | no |  |

### Schema: `ChannelLinkingDto`

<a id="schema-channellinkingdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `link` | [`LinkingDetails`](#schema-linkingdetails) | no |  |
| `unlink` | [`LinkingDetails`](#schema-linkingdetails) | no |  |

### Schema: `ChannelMetadataDTO`

<a id="schema-channelmetadatadto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `name` | string | no |  |
| `description` | string | no |  |
| `metadataSetId` | integer (int64) | no |  |
| `metadataSetKeyName` | string | no |  |

### Schema: `ChannelOwnerDto`

<a id="schema-channelownerdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `firstName` | string | no |  |
| `lastName` | string | no |  |
| `email` | string | no |  |

### Schema: `ChannelUpdateRequest`

<a id="schema-channelupdaterequest"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `parentChannelId` | integer (int64) | no |  |

### Schema: `ChapterDTO`

<a id="schema-chapterdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `title` | string | no |  |
| `description` | string | no |  |
| `startTime` | integer (int64) | no |  |
| `thumbnailUrl` | string | no |  |

### Schema: `CodecDTO`

<a id="schema-codecdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `name` | string | no |  |
| `properties` | object | no |  |

### Schema: `ColorBackgroundDTO`

<a id="schema-colorbackgrounddto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `default` | string | yes |  |

### Schema: `ColorButtonDTO`

<a id="schema-colorbuttondto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `active` | string | yes |  |
| `default` | string | yes |  |
| `hover` | string | yes |  |

### Schema: `ColorDTO`

<a id="schema-colordto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `slider` | [`ColorSliderDTO`](#schema-colorsliderdto) | no |  |
| `button` | [`ColorButtonDTO`](#schema-colorbuttondto) | no |  |
| `background` | [`ColorBackgroundDTO`](#schema-colorbackgrounddto) | no |  |
| `primaryColor` | string | no |  |
| `playerTheme` | string | no |  |
| `controlBarColor` | string | no |  |
| `controlBarOpacity` | number (float) | no |  |
| `iconColor` | string | no |  |
| `bigPlayButtonIconColor` | string | no |  |

### Schema: `ColorSliderDTO`

<a id="schema-colorsliderdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `text` | string | yes |  |
| `progress` | string | yes |  |
| `background` | string | yes |  |

### Schema: `ContainerDTO`

<a id="schema-containerdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `name` | string | no |  |
| `properties` | object | no |  |

### Schema: `CountryCodeDTO`

<a id="schema-countrycodedto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `countryCode` | string | no |  |

### Schema: `CreateAISubtitleDto`

<a id="schema-createaisubtitledto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `languageCode` | string | no |  |
| `type` | [`SubtitleType`](#schema-subtitletype) | no |  |

### Schema: `CreateAttachmentDTO`

<a id="schema-createattachmentdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `type` | string | no |  |
| `fileName` | string | no |  |

### Schema: `CreateAttachmentDTO1`

<a id="schema-createattachmentdto1"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `type` | string | yes |  |
| `fileName` | string | yes |  |

### Schema: `CreateChannelDTO`

<a id="schema-createchanneldto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `name` | string | no |  |
| `parentId` | integer (int64) | no |  |
| `ownerGroupId` | integer (int64) | no |  |
| `createdDate` | string (date-time) | no |  |
| `modifiedDate` | string (date-time) | no |  |

### Schema: `CreateChapterStillRequest`

<a id="schema-createchapterstillrequest"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `timestamp` | integer (int64) | no |  |

### Schema: `CreateSubtitleDTO`

<a id="schema-createsubtitledto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `title` | string | no |  |
| `description` | string | no |  |
| `type` | [`SubtitleTypeDTO`](#schema-subtitletypedto) | no |  |
| `locale` | string | no |  |
| `uploadFileName` | string | no |  |
| `autoPublish` | boolean | no |  |

### Schema: `CreateSubtitleDto`

<a id="schema-createsubtitledto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `title` | string | no |  |
| `localeCode` | string | no |  |
| `type` | [`SubtitleTypeDTO`](#schema-subtitletypedto) | no |  |
| `uploadFileName` | string | no |  |
| `creationType` | [`SubtitleCreationType`](#schema-subtitlecreationtype) | no |  |
| `files` | array&lt;[`SubtitleFileDto`](#schema-subtitlefiledto)&gt; | no |  |
| `autoPublish` | boolean | no |  |

### Schema: `CustomMetadataFieldDTO`

<a id="schema-custommetadatafielddto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `keyName` | string | no |  |
| `type` | string | no |  |
| `editable` | boolean | no |  |
| `options` | array&lt;[`SelectOptionDTO1`](#schema-selectoptiondto1)&gt; | no |  |
| `entityType` | [`EntityType`](#schema-entitytype) | no |  |
| `useDefault` | boolean | no |  |

### Schema: `DeleteVideosDto`

<a id="schema-deletevideosdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `videoIds` | array&lt;string&gt; | no |  |

### Schema: `DimensionDTO`

<a id="schema-dimensiondto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `width` | integer (int32) | no |  |
| `height` | integer (int32) | no |  |

### Schema: `DownloadUrlDTO`

<a id="schema-downloadurldto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `quality` | string | no |  |
| `profileKey` | string | no |  |
| `fileExtension` | string | no |  |
| `url` | string | no |  |
| `fileSize` | integer (int64) | no |  |
| `md5` | string | no |  |

### Schema: `EcdnConfiguration`

<a id="schema-ecdnconfiguration"></a>

ECDN Configuration

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | string | no | Unique identifier of the configuration |
| `integratorCustomerId` | string | no | Integrator customer ID |
| `publicKeyId` | string | no | Public key ID |
| `active` | boolean | no | Indicates if this configuration is active |

### Schema: `EmbedType`

<a id="schema-embedtype"></a>

**Type:** enum

- `HTML_CODE`
- `LINK_URL`
- `LINK_PREVIEW_URL`
- `SHARE_URL`
- `WATCH_URL`
- `IFRAME`

### Schema: `EntityType`

<a id="schema-entitytype"></a>

**Type:** object

### Schema: `ErrorCode`

<a id="schema-errorcode"></a>

**Type:** enum

- `VIDEO_ACCESS_ERROR_CODE`
- `GENERAL_ERROR`
- `ENTRY_ALREADY_EXISTS`
- `MUST_NOT_DELETE_ROOT_CHANNEL`
- `MUST_NOT_DELETE_PARENT_CHANNEL`
- `GOOGLE_ID_ALREADY_IN_USE`
- `FB_ID_ALREADY_IN_USE`
- `GOOGLE_REVOKE_FAILED_UNEXPECTED_ANSWER`
- `GOOGLE_REVOKE_FAILED_NO_DB_ENTRY`
- `MUST_NOT_DELETE_ROLE_WITH_USERS`
- `MUST_NOT_DELETE_VM_WITH_DATA`
- `VIDEO_UPLOAD_UNSUPPORTED_MIME_TYPE`
- `VIDEO_UPLOAD_INVALID_VIDEO_DATA`
- `VIDEO_IS_ALREADY_UPLOADED`
- `VIDEO_IS_NOT_INDEXED`
- `VIDEO_IS_ARCHIVED_CAN_NOT_BE_MODIFIED`
- `VIDEO_IS_NOT_ARCHIVED`
- `VIDEO_IS_ALREADY_ARCHIVED`
- `VIDEO_IS_NOT_SUITABLE_FOR_ARCHIVING`
- `FILE_UPLOAD_UNSUPPORTED_FILE_TYPE`
- `FILE_EXTENSION_NOT_IDENTIFIED`
- `ATTACHMENT_UNSUPPORTED_FILE_TYPE`
- `SUBTITLE_UNSUPPORTED_FILE_TYPE`
- `THUMBNAIL_UNSUPPORTED_FILE_TYPE`
- `VIDEO_SCHEDULED_TRASH_DATE_CANNOT_BE_MODIFIED`
- `RETENTION_POLICY_APPLIED_CANNOT_BE_DELETED`
- `VIDEO_IS_NOT_AI_INDEXED`
- `VIDEO_INDEXER_SOURCE_LANGUAGE_NOT_FOUND`
- `INVALID_EMAIL_ADDRESS`
- `INVALID_IP_RANGE`
- `INVALID_SKIN_URL`
- `INVALID_SELECT_OPTION`
- `INVALID_SCHEDULED_TRASH_DATE`
- `INVALID_SOURCE_LANGUAGE`
- `INVALID_INPUT`
- `INVALID_CUSTOM_METADATA_PROPERTY`
- `INVALID_CUSTOM_METADATA_SORTING_TYPE`
- `INVALID_FILE_NAME`
- `INVALID_IDP_NAME`
- `ASSET_REPLACEMENT_IN_PROGRESS`
- `PLAYOUT_GEO_PROTECTION_DENIED`
- `MI_ANALYTICS_SERVER_ERROR`
- `AI_INDEXER_SERVER_ERROR`
- `LAST_PLAYED_DATE_MIN_BOUND_ERROR`
- `EXCHANGE_VMPRO_TOKEN_TO_CORPORATE_TUBE_TOKEN`
- `RETENTION_POLICY_INVALID_DURATION`
- `RETENTION_POLICY_CANNOT_BE_MODIFIED`
- `VIDEO_ARCHIVED_DATE_IS_IN_PAST`
- `VIDEO_ARCHIVED_DATE_IS_AFTER_SCHEDULED_TRASH_DATE`
- `VIDEO_SCHEDULED_TRASH_DATE_IS_AFTER_SCHEDULED_ARCHIVE_DATE`
- `RETENTION_POLICY_CANNOT_BE_DELETED_WITH_ASSIGNED_VIDEOS`
- `RETENTION_POLICY_CANNOT_BE_DELETED_DEFAULT`
- `VIL_SOURCE_UNREACHABLE`
- `SUBTITLE_PARSER_CONTENT_NOT_PARSEABLE`
- `VIL_SUBTITLE_UPDATE_FAILED`
- `UPLOAD_FORM_NOT_ACTIVE`
- `UPLOAD_FORM_EMAIL_VALIDATION_FAILED`
- `MUST_NOT_DELETE_CHANNEL_WITH_UPLOAD_FORMS`
- `MUST_NOT_DELETE_ACCESS_PROFILE_WITH_UPLOAD_FORMS`
- `MUST_NOT_DELETE_SECURITY_POLICY_WITH_UPLOAD_FORMS`
- `MUST_NOT_DELETE_RETENTION_POLICY_WITH_UPLOAD_FORMS`

### Schema: `EventType`

<a id="schema-eventtype"></a>

**Type:** enum

- `PUBLISH_PERIOD_EXPIRES`
- `VIDEO_UPLOADED`
- `VIDEO_CHANGED`
- `CHANNEL_CHANGED`
- `MONTHLY_REPORT`
- `SOCIAL_MEDIA_PUBLISH`
- `VIDEO_ABOUT_TO_DELETE`
- `VIDEO_ABOUT_TO_ARCHIVE`

### Schema: `FeedbackDto`

<a id="schema-feedbackdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `title` | string | no |  |
| `content` | string | no |  |

### Schema: `FileDto`

<a id="schema-filedto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `fileName` | string | yes |  |
| `mimeType` | string | no |  |
| `size` | integer (int64) | no |  |

### Schema: `FilterDTO`

<a id="schema-filterdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `type` | [`SearchFilterType`](#schema-searchfiltertype) | yes | Type of the filter field |

### Schema: `FilterField`

<a id="schema-filterfield"></a>

**Type:** enum

- `TITLE`
- `DESCRIPTION`
- `CHANNEL_ID`
- `UPLOADED_BY`
- `OWNER`
- `CORPORATE_TUBE_UPLOADER_USER_ID`
- `CORPORATE_TUBE_UPLOADER_USER_KEYCLOAK_ID`
- `CORPORATE_TUBE_IN_CHARGE_USER_KEYCLOAK_ID`
- `AUDIO_ONLY`
- `PLAYS`
- `UPLOAD_DATE`
- `PUBLISHED`
- `LAST_PLAYED_DATE`
- `MODIFIED_DATE`
- `SCHEDULED_TRASH_DATE`
- `SCHEDULED_ARCHIVE_DATE`
- `VIDEO_ID`
- `ARCHIVED`
- `PUBLICATION_DATE`
- `PUBLICATION_PERIOD_START`
- `PUBLICATION_PERIOD_END`
- `DURATION`
- `KEYWORDS`
- `MOVED_TO_TRASH`

### Schema: `FilterRequestDTO`

<a id="schema-filterrequestdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `offset` | integer (int32) | no | Offset of the first result to return |
| `limit` | integer (int32) | no | Maximum number of results to return |
| `filters` | array&lt;[`FilterDTO`](#schema-filterdto)&gt; | no |  |
| `ordering` | [`Ordering`](#schema-ordering) | no | Fields to search in |
| `searchFields` | array&lt;[`SearchField`](#schema-searchfield)&gt; | no | Fields to search in, leave empty to search in all fields |
| `searchMetadataFields` | array&lt;string&gt; | no | Metadata fields to search in, leave empty to search in all metadata fields |

### Schema: `GroupAssociationDTO`

<a id="schema-groupassociationdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `groupId` | integer (int64) | yes |  |
| `userId` | integer (int64) | yes |  |
| `roleId` | integer (int64) | yes |  |

### Schema: `GroupDTO`

<a id="schema-groupdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `name` | string | yes |  |
| `description` | string | no |  |
| `defaultGroup` | boolean | no |  |

### Schema: `GroupDTO1`

<a id="schema-groupdto1"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `name` | string | no |  |

### Schema: `GroupInfo`

<a id="schema-groupinfo"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `currentValue` | integer (int64) | no |  |
| `maxValue` | integer (int64) | no |  |

### Schema: `GroupReportDto`

<a id="schema-groupreportdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `name` | string | no |  |
| `traffic` | number (double) | no |  |
| `storage` | number (double) | no |  |
| `storageSize` | number (double) | no |  |

### Schema: `IdentityProviderDTO`

<a id="schema-identityproviderdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `idpName` | string | no |  |

### Schema: `IndexingInfo`

<a id="schema-indexinginfo"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `currentValue` | number (double) | no |  |
| `maxValue` | integer (int64) | no |  |

### Schema: `KeywordDto`

<a id="schema-keyworddto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `text` | string | no |  |
| `type` | [`KeywordType`](#schema-keywordtype) | no |  |
| `createdAt` | string (date) | no |  |

### Schema: `KeywordType`

<a id="schema-keywordtype"></a>

**Type:** object

### Schema: `LinkingDetails`

<a id="schema-linkingdetails"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `videoIds` | array&lt;string&gt; | no |  |
| `channelIds` | array&lt;integer (int64)&gt; | no |  |

### Schema: `LocaleDto`

<a id="schema-localedto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `language` | string | no |  |
| `country` | string | no |  |
| `languageTag` | string | yes |  |

### Schema: `LoginDTO`

<a id="schema-logindto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `username` | string | yes |  |
| `password` | string | yes |  |

### Schema: `MetadataSetDTO`

<a id="schema-metadatasetdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `keyName` | string | no |  |
| `type` | [`MetadataSetType`](#schema-metadatasettype) | no |  |
| `isDefault` | boolean | no |  |

### Schema: `MetadataSetDTO1`

<a id="schema-metadatasetdto1"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `keyName` | string | no |  |
| `type` | string | no |  |
| `isDefault` | boolean | no |  |

### Schema: `MetadataSetType`

<a id="schema-metadatasettype"></a>

**Type:** enum

- `LOCALIZATION`
- `CUSTOM`

### Schema: `MinimalChannelDTO`

<a id="schema-minimalchanneldto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `name` | string | no |  |

### Schema: `MinimalCorporateTubeMetadataDTO`

<a id="schema-minimalcorporatetubemetadatadto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `uploadDate` | string (date) | no |  |
| `uploaderUserId` | string | no |  |
| `inChargeUserId` | string | no |  |
| `uploaderKeycloakUserId` | string | no |  |
| `inChargeKeycloakUserId` | string | no |  |

### Schema: `NewDefaultVideoManagerDTO`

<a id="schema-newdefaultvideomanagerdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `name` | string | yes |  |
| `owner` | string | yes |  |
| `company` | string | no |  |
| `accountId` | string (uuid) | yes |  |
| `department` | string | no |  |
| `languageTag` | string | no |  |
| `features` | object | no |  |

### Schema: `NewPlayerDefinitionDTO`

<a id="schema-newplayerdefinitiondto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `name` | string | yes |  |
| `playerSkinId` | string | yes |  |
| `newPlayer` | boolean | no |  |
| `options` | [`OptionsDTO`](#schema-optionsdto) | no |  |

### Schema: `NewPlayerSkinDTO`

<a id="schema-newplayerskindto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `name` | string | yes |  |
| `skinDownloadUrl` | string | yes |  |
| `playButton` | [`ButtonDTO`](#schema-buttondto) | yes |  |
| `stopButton` | [`ButtonDTO`](#schema-buttondto) | yes |  |
| `slider` | [`ButtonDTO`](#schema-buttondto) | yes |  |
| `sliderBackground` | [`ButtonDTO`](#schema-buttondto) | yes |  |
| `sliderBuffer` | [`ButtonDTO`](#schema-buttondto) | yes |  |
| `sliderProgress` | [`ButtonDTO`](#schema-buttondto) | yes |  |
| `mute` | [`ButtonDTO`](#schema-buttondto) | yes |  |
| `volume` | [`ButtonDTO`](#schema-buttondto) | yes |  |
| `volumeBackground` | [`ButtonDTO`](#schema-buttondto) | yes |  |
| `fullScreen` | [`ButtonDTO`](#schema-buttondto) | yes |  |
| `buttonSeparator` | [`ButtonDTO`](#schema-buttondto) | yes |  |
| `bigPlayButton` | [`BigPlayButtonDTO`](#schema-bigplaybuttondto) | yes |  |
| `colors` | [`ColorDTO`](#schema-colordto) | yes |  |
| `template` | string | no |  |

### Schema: `NewVideoManagerDTO`

<a id="schema-newvideomanagerdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `name` | string | yes |  |
| `owner` | string | yes |  |
| `company` | string | no |  |
| `accountId` | [`UUID`](#schema-uuid) | no |  |
| `department` | string | no |  |
| `plans` | [`PlansDTO`](#schema-plansdto) | no |  |
| `languageTag` | string | no |  |
| `transcodingProfiles` | array&lt;[`RestTranscodingProfileDTO`](#schema-resttranscodingprofiledto)&gt; | no |  |
| `playerSkins` | array&lt;[`NewPlayerSkinDTO`](#schema-newplayerskindto)&gt; | no |  |
| `configuration` | object | no |  |

### Schema: `NumberFieldFilterDTO`

<a id="schema-numberfieldfilterdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `type` | [`SearchFilterType`](#schema-searchfiltertype) | yes | Type of the filter field |
| `field` | [`FilterField`](#schema-filterfield) | no | Field to filter on |
| `equals` | integer (int64) | no |  |

### Schema: `OptionsDTO`

<a id="schema-optionsdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `defaultQuality` | string | no |  |
| `defaultQualityFlash` | string | no |  |
| `defaultQualityFullscreen` | string | no |  |
| `useHtmlFirst` | boolean | no |  |
| `responsive` | boolean | no |  |
| `autoplay` | boolean | no |  |
| `lazyLoad` | boolean | no |  |
| `downloadMenu` | boolean | no |  |
| `adsOnPlay` | boolean | no |  |
| `accessibilityEnabled` | boolean | no |  |
| `defaultDefinition` | boolean | no |  |
| `fixedWidth` | boolean | no |  |
| `width` | integer (int32) | no |  |
| `aspectRatio` | string | no |  |
| `playerType` | [`PlayerType`](#schema-playertype) | no |  |
| `useStoryboard` | boolean | no |  |
| `loopVideo` | boolean | no |  |
| `showBigPlayButton` | boolean | no |  |
| `controlBarHeight` | integer (int32) | no |  |
| `trackingDialogueEnabled` | boolean | no |  |
| `trackingDialoguePreferredLanguage` | string | no |  |
| `minimalAnalytics` | boolean | no |  |
| `autoSubtitleEnabled` | boolean | no |  |
| `autoSubtitlePreferredLanguage` | string | no |  |
| `autoSubtitleFallbackLanguage` | string | no |  |
| `hideBar` | boolean | no |  |
| `enableTranscripts` | boolean | no |  |
| `downloadTranscripts` | boolean | no |  |
| `hideControlsBeforePlay` | boolean | no |  |
| `muted` | boolean | no |  |
| `preloadSources` | [`PreloadSourceOptionsDto`](#schema-preloadsourceoptionsdto) | no |  |
| `mediaSessionEnabled` | boolean | no |  |
| `noUI` | boolean | no |  |

### Schema: `Order`

<a id="schema-order"></a>

**Type:** enum

- `ASC`
- `DESC`

### Schema: `Ordering`

<a id="schema-ordering"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `field` | string | no |  |
| `direction` | [`OrderingDirection`](#schema-orderingdirection) | no |  |

### Schema: `OrderingDirection`

<a id="schema-orderingdirection"></a>

**Type:** enum

- `ASC`
- `DESC`

### Schema: `OverlayDTO`

<a id="schema-overlaydto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `title` | string | no |  |
| `description` | string | no |  |
| `startTime` | integer (int64) | no |  |
| `duration` | integer (int64) | no |  |
| `markup` | string | no |  |
| `backgroundColor` | string | no |  |
| `mode` | [`OverlayMode`](#schema-overlaymode) | no |  |
| `endTime` | integer (int64) | no |  |
| `positionTop` | number | no |  |
| `positionLeft` | number | no |  |
| `width` | number | no |  |
| `height` | number | no |  |
| `type` | [`OverlayType`](#schema-overlaytype) | no |  |

### Schema: `OverlayDto`

<a id="schema-overlaydto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `title` | string | no |  |
| `description` | string | no |  |
| `startTime` | integer (int64) | no |  |
| `duration` | integer (int64) | no |  |
| `markup` | string | no |  |
| `backgroundColor` | string | no |  |
| `mode` | [`OverlayMode`](#schema-overlaymode) | no |  |
| `endTime` | integer (int64) | no |  |
| `positionTop` | number | no |  |
| `positionLeft` | number | no |  |
| `positionBottom` | number | no |  |
| `positionRight` | number | no |  |
| `width` | number | no |  |
| `height` | number | no |  |
| `type` | [`OverlayType`](#schema-overlaytype) | no |  |

### Schema: `OverlayMode`

<a id="schema-overlaymode"></a>

**Type:** enum

- `LIGHT_AD`
- `LAYER`

### Schema: `OverlayType`

<a id="schema-overlaytype"></a>

**Type:** enum

- `EDITOR`
- `TEMPLATE`
- `INSERT`
- `FLOATING_TITLES`

### Schema: `OwnershipDTO`

<a id="schema-ownershipdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `ownerGroupId` | integer (int64) | no |  |
| `visibility` | boolean | no |  |

### Schema: `Permission`

<a id="schema-permission"></a>

**Type:** enum

- `READ_VIDEOS`
- `UPDATE_VIDEOS`
- `DELETE_VIDEOS`
- `ARCHIVE_VIDEOS`
- `REPLACE_VIDEOS`
- `MODIFY_VIDEOS`
- `PUBLISH_VIDEOS`
- `UPDATE_OWNERSHIP_VIDEOS`
- `DUPLICATE_VIDEOS`
- `SPLIT_VIDEOS`
- `MERGE_VIDEOS`
- `EDIT_SECURITY_POLICIES`
- `EDIT_RETENTION_POLICIES`
- `EXTEND_RETENTION_POLICY`
- `MANAGE_SUBTITLES`
- `DOWNLOAD_SOURCE`
- `READ_ANALYTICS_VIDEOS`
- `AI_VIDEOS`
- `USE_VIDEO_AI_ASSISTANT`
- `UPDATE_VIDEO_METADATA`
- `UPDATE_VIDEO_STILLS`
- `UPDATE_VIDEO_ATTACHMENTS`
- `UPDATE_VIDEO_SUBTITLES`
- `CREATE_VIDEOS`
- `EDIT_VIDEO_ASSET_PROTECTION`
- `YOUTUBE`
- `CREATE_CHANNELS`
- `READ_CHANNELS`
- `READ_SUB_CHANNELS`
- `READ_CHANNEL_VIDEOS`
- `WRITE_CHANNEL_VIDEOS`
- `UPDATE_CHANNELS`
- `DELETE_CHANNELS`
- `EDIT_CHANNEL_ASSET_PROTECTION`
- `ADMINISTRATION`
- `PLAYER_GENERATOR`
- `ANALYTICS`
- `YOUBORA_ANALYTICS`
- `CT_ADMINISTRATION`
- `MANAGE_UPLOAD_FORMS`

### Schema: `PlansDTO`

<a id="schema-plansdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `trafficQuota` | integer (int32) | no |  |
| `userQuota` | integer (int32) | no |  |
| `storageQuota` | integer (int32) | no |  |
| `aiIndexingQuota` | integer (int32) | no |  |
| `archivedStorageQuota` | integer (int32) | no |  |

### Schema: `PlayerOptionsUpdateRequest`

<a id="schema-playeroptionsupdaterequest"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `autoSubtitleEnabled` | boolean | no |  |
| `autoSubtitlePreferredLanguage` | string | no |  |
| `autoSubtitleFallbackLanguage` | string | no |  |
| `trackingDialogueEnabled` | boolean | no |  |
| `trackingDialoguePreferredLanguage` | string | no |  |
| `minimalAnalytics` | boolean | no |  |
| `defaultQuality` | string | no |  |
| `defaultQualityFlash` | string | no |  |
| `defaultQualityFullscreen` | string | no |  |
| `useHtmlFirst` | boolean | no |  |
| `responsive` | boolean | no |  |
| `autoplay` | boolean | no |  |
| `lazyLoad` | boolean | no |  |
| `adsOnPlay` | boolean | no |  |
| `downloadMenu` | boolean | no |  |
| `accessibilityEnabled` | boolean | no |  |
| `fixedWidth` | boolean | no |  |
| `width` | integer (int32) | no |  |
| `aspectRatio` | string | no |  |
| `playerType` | [`PlayerType`](#schema-playertype) | no |  |
| `useStoryboard` | boolean | no |  |
| `loopVideo` | boolean | no |  |
| `showBigPlayButton` | boolean | no |  |
| `controlBarHeight` | integer (int32) | no |  |
| `hideBar` | boolean | no |  |
| `enableTranscripts` | boolean | no |  |
| `downloadTranscripts` | boolean | no |  |
| `hideControlsBeforePlay` | boolean | no |  |
| `muted` | boolean | no |  |
| `preloadSources` | object | no |  |
| `mediaSessionEnabled` | boolean | no |  |
| `noUI` | boolean | no |  |

### Schema: `PlayerType`

<a id="schema-playertype"></a>

**Type:** enum

- `BITDASH`
- `DEFAULT`

### Schema: `PreloadSourceOptionsDto`

<a id="schema-preloadsourceoptionsdto"></a>

**Type:** enum

- `NONE`
- `METADATA`
- `AUTO`

### Schema: `ProbeJobResultDto`

<a id="schema-probejobresultdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `videoId` | [`UUID`](#schema-uuid) | no |  |
| `fileSize` | integer (int64) | no |  |
| `transcodingJobId` | [`UUID`](#schema-uuid) | no |  |
| `container` | string | no |  |
| `audioStreamDtos` | array&lt;[`AudioStreamDto`](#schema-audiostreamdto)&gt; | no |  |
| `videoStreamDtos` | array&lt;[`VideoStreamDto`](#schema-videostreamdto)&gt; | no |  |

### Schema: `PublicationPeriodDTO`

<a id="schema-publicationperioddto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `periodStart` | integer (int64) | no |  |
| `periodEnd` | integer (int64) | no |  |
| `periodStartDate` | string | no |  |
| `periodEndDate` | string | no |  |

### Schema: `PublicationPeriodDTO1`

<a id="schema-publicationperioddto1"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `periodStart` | integer (int64) | no |  |
| `periodEnd` | integer (int64) | no |  |
| `periodStartDate` | string | no |  |
| `periodEndDate` | string | no |  |

### Schema: `PublicationPrivacyStatus`

<a id="schema-publicationprivacystatus"></a>

**Type:** enum

- `PUBLIC`
- `PRIVATE`
- `UNLISTED`

### Schema: `PublicationProfileDTO`

<a id="schema-publicationprofiledto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | yes |  |
| `videoManagerId` | integer (int64) | yes |  |
| `name` | string | yes |  |
| `status` | [`PublicationProfileStatus`](#schema-publicationprofilestatus) | yes |  |
| `type` | [`SocialMediaType`](#schema-socialmediatype) | no |  |
| `creationDate` | integer (int64) | no |  |
| `connectionDate` | integer (int64) | no |  |

### Schema: `PublicationProfileStatus`

<a id="schema-publicationprofilestatus"></a>

**Type:** enum

- `CONNECTED`
- `DISCONNECTED`

### Schema: `PublicationStatus`

<a id="schema-publicationstatus"></a>

**Type:** enum

- `PUBLISHED`
- `NOT_PUBLISHED`
- `SCHEDULED`
- `SCHEDULED_FOR_PUBLISHING`
- `SCHEDULED_FOR_UNPUBLISHING`

### Schema: `PublicationStatus1`

<a id="schema-publicationstatus1"></a>

**Type:** enum

- `PUBLISHED`
- `NOT_PUBLISHED`
- `TIME_PERIOD_PUBLISHED`
- `TIME_PERIOD_NOT_PUBLISHED`

### Schema: `PublicationStatusFilterDTO`

<a id="schema-publicationstatusfilterdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `type` | [`SearchFilterType`](#schema-searchfiltertype) | yes | Type of the filter field |
| `equals` | [`PublicationStatus`](#schema-publicationstatus) | no |  |

### Schema: `QueryFilterDTO`

<a id="schema-queryfilterdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `type` | [`SearchFilterType`](#schema-searchfiltertype) | yes | Type of the filter field |
| `contains_one` | string | no |  |

### Schema: `RangeFieldFilterDTO`

<a id="schema-rangefieldfilterdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `type` | [`SearchFilterType`](#schema-searchfiltertype) | yes | Type of the filter field |
| `field` | [`FilterField`](#schema-filterfield) | no | Field to filter on |
| `greaterThanOrEquals` | integer (int64) | no |  |
| `lessThanOrEquals` | integer (int64) | no |  |
| `lowerBoundPresent` | boolean | no |  |
| `upperBoundPresent` | boolean | no |  |

### Schema: `RefreshDTO`

<a id="schema-refreshdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `refreshToken` | string | yes |  |

### Schema: `RegistrationDTO`

<a id="schema-registrationdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `password` | string | yes |  |
| `passwordConfirm` | string | yes |  |
| `activationToken` | string | yes |  |

### Schema: `RelatedVideos`

<a id="schema-relatedvideos"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `channels` | array&lt;[`RelatedVideosChannelDto`](#schema-relatedvideoschanneldto)&gt; | no |  |
| `videoIds` | array&lt;string&gt; | no |  |

### Schema: `RelatedVideosChannelDto`

<a id="schema-relatedvideoschanneldto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `name` | string | no |  |

### Schema: `ResolutionDto`

<a id="schema-resolutiondto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `width` | integer (int32) | no |  |
| `height` | integer (int32) | no |  |

### Schema: `RestTranscodingProfileDTO`

<a id="schema-resttranscodingprofiledto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `key` | string | no |  |
| `quality` | string | no |  |
| `videoExtension` | string | no |  |
| `stillExtension` | string | no |  |
| `createStill` | boolean | no |  |
| `container` | [`ContainerDTO`](#schema-containerdto) | no |  |
| `video` | [`VideoDTO`](#schema-videodto) | no |  |
| `audio` | [`AudioDTO`](#schema-audiodto) | no |  |
| `active` | boolean | no |  |

### Schema: `RetentionPolicyDTO`

<a id="schema-retentionpolicydto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `name` | string | yes |  |
| `description` | string | no |  |
| `duration` | string (duration) | yes |  |
| `active` | boolean | no |  |
| `notificationEnabled` | boolean | no |  |
| `notificationRule` | [`RuleNotificationDataDTO`](#schema-rulenotificationdatadto) | no |  |
| `assignedVideosCount` | integer (int32) | no |  |

### Schema: `RoleDto`

<a id="schema-roledto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `removeAdminPermission` | boolean | no |  |
| `name` | string | no |  |
| `description` | string | no |  |
| `permissions` | array&lt;string&gt; | no |  |

### Schema: `RuleDTO`

<a id="schema-ruledto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `days` | integer (int32) | no |  |
| `locale` | [`LocaleDto`](#schema-localedto) | no |  |
| `emails` | array&lt;[`RuleEmailDTO`](#schema-ruleemaildto)&gt; | no |  |
| `emailPersonInCharge` | boolean | no |  |
| `emailSubstitutePeopleInCharge` | boolean | no |  |
| `id` | integer (int64) | no |  |
| `videoManagerId` | integer (int64) | no |  |
| `eventType` | [`EventType`](#schema-eventtype) | yes |  |
| `actionType` | [`ActionType`](#schema-actiontype) | yes |  |
| `name` | string | yes |  |
| `urls` | array&lt;[`RuleUrlDTO`](#schema-ruleurldto)&gt; | no |  |
| `active` | boolean | no |  |
| `userEmailAllowed` | boolean | no |  |

### Schema: `RuleEmailDTO`

<a id="schema-ruleemaildto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `ruleId` | integer (int64) | no |  |
| `email` | string | yes |  |

### Schema: `RuleNotificationDataDTO`

<a id="schema-rulenotificationdatadto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `days` | integer (int32) | no |  |
| `locale` | [`LocaleDto`](#schema-localedto) | no |  |
| `emails` | array&lt;[`RuleEmailDTO`](#schema-ruleemaildto)&gt; | no |  |
| `emailPersonInCharge` | boolean | no |  |
| `emailSubstitutePeopleInCharge` | boolean | no |  |

### Schema: `RuleUrlDTO`

<a id="schema-ruleurldto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `ruleId` | integer (int64) | no |  |
| `url` | string | yes |  |

### Schema: `SamlOwnershipMappingDto`

<a id="schema-samlownershipmappingdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `samlAttribute` | string | no |  |
| `videoManagerId` | integer (int64) | no |  |
| `videoManagerName` | string | no |  |
| `groupId` | integer (int64) | no |  |
| `groupName` | string | no |  |
| `roleId` | integer (int64) | no |  |
| `roleName` | string | no |  |

### Schema: `SearchField`

<a id="schema-searchfield"></a>

**Type:** enum

- `ID`
- `TITLE`
- `UPLOAD_FILE_NAME`
- `KEYWORDS`
- `DESCRIPTION`
- `SUBTITLES`

### Schema: `SearchFilterType`

<a id="schema-searchfiltertype"></a>

**Type:** enum

- `NUMBER`
- `TEXT`
- `BOOLEAN`
- `RANGE`
- `PUBLICATION_STATUS`
- `QUERY`
- `ARRAY`

### Schema: `SecurityOverrideDto`

<a id="schema-securityoverridedto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `assetTypes` | array&lt;[`AssetType`](#schema-assettype)&gt; | no |  |
| `scope` | string | no |  |

### Schema: `SecurityPolicyDTO`

<a id="schema-securitypolicydto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `name` | string | no |  |
| `description` | string | no |  |
| `tokenProtected` | boolean | no |  |
| `referrerProtected` | boolean | no |  |
| `referrers` | array&lt;[`SecurityPolicyReferrerDTO`](#schema-securitypolicyreferrerdto)&gt; | no |  |
| `sharedSecret` | string | no |  |
| `ipRangeProtected` | boolean | no |  |
| `ipRangeList` | array&lt;[`SecurityPolicyIpRangeDTO`](#schema-securitypolicyiprangedto)&gt; | no |  |
| `geoProtected` | boolean | no |  |
| `geoProtectedInclusive` | boolean | no |  |
| `geoLocations` | array&lt;[`SecurityPolicyGeoLocationDTO`](#schema-securitypolicygeolocationdto)&gt; | no |  |
| `idpProtected` | boolean | no |  |
| `idpHints` | array&lt;[`IdentityProviderDTO`](#schema-identityproviderdto)&gt; | no |  |
| `defaultForVideoManager` | boolean | no |  |

### Schema: `SecurityPolicyGeoLocationDTO`

<a id="schema-securitypolicygeolocationdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `countryCode` | string | no |  |

### Schema: `SecurityPolicyIpRangeDTO`

<a id="schema-securitypolicyiprangedto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `ipRange` | string | no |  |

### Schema: `SecurityPolicyReferrerDTO`

<a id="schema-securitypolicyreferrerdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `name` | string | no |  |

### Schema: `Segment`

<a id="schema-segment"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `title` | string | no |  |
| `startTime` | string | no |  |
| `endTime` | string | no |  |

### Schema: `SelectOptionDTO`

<a id="schema-selectoptiondto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `name` | string | yes |  |

### Schema: `SelectOptionDTO1`

<a id="schema-selectoptiondto1"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `name` | string | yes |  |

### Schema: `SocialMediaType`

<a id="schema-socialmediatype"></a>

**Type:** enum

- `YOUTUBE`

### Schema: `SourceDto`

<a id="schema-sourcedto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `createdDate` | integer (int64) | no |  |
| `modifiedDate` | integer (int64) | no |  |
| `uploadFinished` | boolean | no |  |
| `status` | [`AssetStatus`](#schema-assetstatus) | no |  |
| `failedReason` | [`AssetFailedReason`](#schema-assetfailedreason) | no |  |
| `file` | [`FileDto`](#schema-filedto) | yes |  |
| `duration` | integer (int64) | no |  |
| `container` | string | no |  |
| `videoStreams` | array&lt;[`VideoStreamDto`](#schema-videostreamdto)&gt; | no |  |
| `audioStreams` | array&lt;[`AudioStreamDto`](#schema-audiostreamdto)&gt; | no |  |
| `uploadFilename` | string | no |  |
| `bucketId` | string | no |  |

### Schema: `SourceLanguageDTO`

<a id="schema-sourcelanguagedto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `languageCode` | string | no |  |
| `language` | string | no |  |

### Schema: `Status`

<a id="schema-status"></a>

**Type:** enum

- `PROCESSED`
- `FAILED`

### Schema: `StillDTO`

<a id="schema-stilldto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `quality` | string | no |  |
| `url` | string | no |  |
| `dimension` | [`DimensionDTO`](#schema-dimensiondto) | no |  |

### Schema: `StillViewDTO`

<a id="schema-stillviewdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `active` | boolean | no |  |
| `items` | array&lt;[`StillDTO`](#schema-stilldto)&gt; | no |  |

### Schema: `SubtitleCreationType`

<a id="schema-subtitlecreationtype"></a>

**Type:** enum

- `UPLOADED`
- `GENERATED`
- `CREATED`

### Schema: `SubtitleDTO`

<a id="schema-subtitledto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `title` | string | no |  |
| `description` | string | no |  |
| `type` | [`SubtitleTypeDTO`](#schema-subtitletypedto) | no |  |
| `languageLabel` | string | no |  |
| `locale` | string | no |  |
| `fileUrl` | string | no |  |
| `uploadFileName` | string | no |  |
| `creationType` | [`SubtitleCreationType`](#schema-subtitlecreationtype) | no |  |

### Schema: `SubtitleFileDto`

<a id="schema-subtitlefiledto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `fileName` | string | no |  |
| `downloadUrl` | string | no |  |

### Schema: `SubtitleType`

<a id="schema-subtitletype"></a>

**Type:** enum

- `SUBTITLES`
- `CAPTIONS`

### Schema: `SubtitleTypeDTO`

<a id="schema-subtitletypedto"></a>

**Type:** enum

- `SUBTITLES`
- `UNKNOWN`
- `CAPTIONS`

### Schema: `TextFieldFilterDTO`

<a id="schema-textfieldfilterdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `type` | [`SearchFilterType`](#schema-searchfiltertype) | yes | Type of the filter field |
| `field` | [`FilterField`](#schema-filterfield) | no | Field to filter on |
| `contains_all` | string | no |  |
| `contains_one` | string | no |  |
| `contains_none` | string | no |  |
| `equals` | string | no |  |

### Schema: `ThumbnailListDTO`

<a id="schema-thumbnaillistdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `videoId` | string | no |  |
| `stills` | array&lt;[`StillDTO`](#schema-stilldto)&gt; | no |  |

### Schema: `TrafficExportDTO`

<a id="schema-trafficexportdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `startDate` | string | yes |  |
| `endDate` | string | yes |  |

### Schema: `TrafficInfo`

<a id="schema-trafficinfo"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `currentValue` | number (double) | no |  |
| `maxValue` | integer (int64) | no |  |

### Schema: `TranscodingStatusDTO`

<a id="schema-transcodingstatusdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `quality` | string | no |  |
| `profileKey` | string | no |  |
| `fileExtension` | string | no |  |
| `transcodingCompleted` | boolean | no |  |

### Schema: `UIIntegrationTokenRequestDTO`

<a id="schema-uiintegrationtokenrequestdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `username` | string | yes |  |
| `password` | string | yes |  |
| `videoManagerId` | integer (int64) | no |  |

### Schema: `UUID`

<a id="schema-uuid"></a>

**Type:** string

### Schema: `UpdateBrandingDTO`

<a id="schema-updatebrandingdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `primaryColor` | string | yes |  |

### Schema: `UploadFormActivationDTO`

<a id="schema-uploadformactivationdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `active` | boolean | yes |  |

### Schema: `UploadFormDTO`

<a id="schema-uploadformdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | string | no |  |
| `videoManagerId` | integer (int64) | no |  |
| `title` | string | yes |  |
| `description` | string | no |  |
| `language` | string | yes |  |
| `complianceMessages` | array&lt;string&gt; | no |  |
| `footerText` | string | no |  |
| `channelId` | integer (int64) | no |  |
| `accessProfileId` | integer (int64) | no |  |
| `securityPolicyId` | integer (int64) | no |  |
| `retentionPolicyId` | integer (int64) | no |  |
| `personInChargeId` | integer (int64) | no |  |
| `substitutePersonsInChargeIds` | array&lt;integer (int64)&gt; | no |  |
| `securitySettings` | [`UploadFormSecuritySettingsDTO`](#schema-uploadformsecuritysettingsdto) | no |  |
| `approverSettings` | [`ApproverSettingsDTO`](#schema-approversettingsdto) | no |  |
| `fields` | array&lt;[`UploadFormFieldDTO`](#schema-uploadformfielddto)&gt; | no |  |
| `createdAt` | string (date-time) | no |  |
| `modifiedAt` | string (date-time) | no |  |
| `createdByEmail` | string | no |  |
| `modifiedByEmail` | string | no |  |

### Schema: `UploadFormFieldDTO`

<a id="schema-uploadformfielddto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `label` | string | no |  |
| `description` | string | no |  |
| `fieldType` | object | no |  |
| `valueType` | object | no |  |
| `required` | boolean | no |  |
| `customMetadataFieldId` | integer (int64) | no |  |
| `attachmentFieldId` | [`UUID`](#schema-uuid) | no |  |
| `defaultValue` | string | no |  |
| `options` | array&lt;[`UploadFormFieldOptionDTO`](#schema-uploadformfieldoptiondto)&gt; | no |  |

### Schema: `UploadFormFieldOptionDTO`

<a id="schema-uploadformfieldoptiondto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `alias` | string | no |  |

### Schema: `UploadFormSecuritySettingsDTO`

<a id="schema-uploadformsecuritysettingsdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `visibility` | object | no |  |
| `restrictedEmails` | array&lt;string&gt; | no |  |
| `restrictedEmailPatterns` | array&lt;string&gt; | no |  |
| `activationStartTime` | string (date-time) | no |  |
| `activationEndTime` | string (date-time) | no |  |
| `active` | boolean | no |  |

### Schema: `UploadFormSummaryDTO`

<a id="schema-uploadformsummarydto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | string | no |  |
| `title` | string | no |  |
| `active` | boolean | no |  |
| `activationStartTime` | string (date-time) | no |  |
| `activationEndTime` | string (date-time) | no |  |
| `totalUploads` | integer (int64) | no |  |
| `lastUploadAt` | string (date-time) | no |  |

### Schema: `UploadFormsComplianceDTO`

<a id="schema-uploadformscompliancedto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `defaultComplianceLinkEnabled` | boolean | no |  |
| `texts` | array&lt;[`UploadFormsComplianceTextDTO`](#schema-uploadformscompliancetextdto)&gt; | no |  |

### Schema: `UploadFormsCompliancePatchDTO`

<a id="schema-uploadformscompliancepatchdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `defaultComplianceLinkEnabled` | boolean | no |  |
| `texts` | array&lt;[`UploadFormsComplianceTextPatchEntryDTO`](#schema-uploadformscompliancetextpatchentrydto)&gt; | no |  |

### Schema: `UploadFormsComplianceTextDTO`

<a id="schema-uploadformscompliancetextdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `language` | string | no |  |
| `complianceLinks` | string | no |  |
| `dataProtectionStatement` | string | no |  |

### Schema: `UploadFormsComplianceTextPatchEntryDTO`

<a id="schema-uploadformscompliancetextpatchentrydto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `language` | string | no |  |
| `complianceLinks` | string | no |  |
| `dataProtectionStatement` | string | no |  |
| `insert` | boolean | no |  |
| `update` | boolean | no |  |

### Schema: `UserDto`

<a id="schema-userdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `firstName` | string | no |  |
| `lastName` | string | no |  |
| `loginName` | string | no |  |
| `systemUserName` | string | no |  |
| `enabled` | boolean | no |  |
| `sendActivationLink` | boolean | no |  |
| `emailVerified` | boolean | no |  |
| `systemUser` | boolean | no |  |
| `email` | string | no |  |
| `companyName` | string | no |  |
| `telephone` | string | no |  |
| `isDeleted` | boolean | no |  |
| `isDeactivated` | boolean | no |  |
| `locale` | [`LocaleDto`](#schema-localedto) | no |  |
| `sourceLanguage` | [`AzureLocaleDto`](#schema-azurelocaledto) | no |  |
| `generateKeywords` | boolean | no |  |
| `generateLabels` | boolean | no |  |
| `generateTopics` | boolean | no |  |
| `generateSubtitles` | boolean | no |  |
| `deleted` | boolean | no |  |
| `deactivated` | boolean | no |  |

### Schema: `UserInfo`

<a id="schema-userinfo"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `currentValue` | integer (int64) | no |  |
| `maxValue` | integer (int64) | no |  |

### Schema: `VideoActionState`

<a id="schema-videoactionstate"></a>

**Type:** enum

- `NONE`
- `DUPLICATING`

### Schema: `VideoAnalyticsDTO`

<a id="schema-videoanalyticsdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | string | no |  |
| `title` | string | no |  |
| `description` | string | no |  |
| `createdDate` | string (date-time) | no |  |
| `modifiedDate` | string (date-time) | no |  |
| `duration` | integer (int64) | no |  |
| `uploadedFile` | string | no |  |
| `published` | boolean | no |  |
| `channels` | array&lt;[`MinimalChannelDTO`](#schema-minimalchanneldto)&gt; | no |  |
| `groups` | array&lt;[`GroupDTO1`](#schema-groupdto1)&gt; | no |  |
| `metadata` | object | no |  |
| `plays` | integer (int64) | no |  |
| `archived` | boolean | no |  |
| `archivedDate` | string (date-time) | no |  |
| `lastPlayDate` | string (date) | no |  |

### Schema: `VideoDTO`

<a id="schema-videodto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `codec` | [`CodecDTO`](#schema-codecdto) | no |  |
| `resolution` | [`ResolutionDto`](#schema-resolutiondto) | no |  |
| `sourceResolution` | [`ResolutionDto`](#schema-resolutiondto) | no |  |
| `keyFrame` | integer (int32) | no |  |
| `frameRate` | integer (int32) | no |  |
| `bitRate` | integer (int32) | no |  |
| `rotate` | integer (int32) | no |  |
| `aspectRatio` | [`AspectRatioDto`](#schema-aspectratiodto) | no |  |

### Schema: `VideoDTO1`

<a id="schema-videodto1"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | string | no |  |
| `title` | string | no |  |
| `thumbnail` | string | no |  |
| `description` | string | no |  |
| `createdDate` | integer (int64) | no |  |
| `modifiedDate` | integer (int64) | no |  |
| `uploadDate` | integer (int64) | no |  |
| `length` | integer (int64) | no |  |
| `generation` | integer (int32) | no |  |
| `plays` | integer (int64) | no |  |
| `views` | integer (int64) | no |  |
| `allFormatsAvailable` | boolean | no |  |
| `published` | boolean | no |  |
| `audioOnly` | boolean | no |  |
| `vrContentType` | string | no |  |
| `customMetadata` | object | no |  |
| `keywords` | array&lt;[`KeywordDto`](#schema-keyworddto)&gt; | no |  |
| `stills` | array&lt;[`StillDTO`](#schema-stilldto)&gt; | no |  |
| `channels` | array&lt;[`MinimalChannelDTO`](#schema-minimalchanneldto)&gt; | no |  |
| `downloadable` | boolean | no |  |
| `scheduledTrashDate` | string | no |  |
| `ownershipGroupId` | integer (int64) | no |  |
| `adConfigurationId` | integer (int64) | no |  |
| `owner` | string | no |  |
| `substituteOwners` | array&lt;string&gt; | no |  |
| `uploader` | string | no |  |
| `corporateTubeMetadata` | [`MinimalCorporateTubeMetadataDTO`](#schema-minimalcorporatetubemetadatadto) | no |  |
| `deleted` | boolean | no |  |
| `publicationDate` | integer (int64) | no |  |
| `lastPlayedDate` | integer (int64) | no |  |
| `sourceLanguage` | string | no |  |

### Schema: `VideoDto`

<a id="schema-videodto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | string | no |  |
| `deleted` | boolean | no |  |
| `downloadable` | boolean | no |  |
| `published` | boolean | no |  |
| `audioOnly` | boolean | no |  |
| `publicationStatus` | [`PublicationStatus1`](#schema-publicationstatus1) | no |  |
| `status` | string | no |  |
| `title` | string | no |  |
| `description` | string | no |  |
| `source` | [`SourceDto`](#schema-sourcedto) | yes |  |
| `keywords` | array&lt;[`KeywordDto`](#schema-keyworddto)&gt; | no |  |
| `modifiedDate` | integer (int64) | no |  |
| `createdDate` | integer (int64) | no |  |
| `uploader` | [`UserDto`](#schema-userdto) | no |  |
| `owner` | [`UserDto`](#schema-userdto) | no |  |
| `substituteOwners` | array&lt;[`UserDto`](#schema-userdto)&gt; | no |  |
| `scheduledTrashDate` | integer (int64) | no |  |
| `scheduledArchiveDate` | integer (int64) | no |  |
| `actionState` | [`VideoActionState`](#schema-videoactionstate) | no |  |
| `bulkTranscoding` | boolean | no |  |
| `relatedVideosChannel` | [`RelatedVideosChannelDto`](#schema-relatedvideoschanneldto) | no |  |
| `publicationPeriod` | [`PublicationPeriodDTO`](#schema-publicationperioddto) | no |  |
| `useGlobalAd` | boolean | no |  |
| `stillBucketId` | [`UUID`](#schema-uuid) | no |  |
| `sourceLanguage` | string | no |  |
| `groupId` | integer (int32) | no |  |
| `securityPolicyId` | integer (int32) | no |  |
| `generateKeywords` | boolean | no |  |
| `generateLabels` | boolean | no |  |
| `generateTopics` | boolean | no |  |
| `generateSubtitles` | boolean | no |  |
| `autoPublish` | boolean | no |  |
| `generateFormats` | boolean | no |  |
| `pauseChapters` | boolean | no |  |
| `lastPlayedDate` | integer (int64) | no |  |
| `archived` | boolean | no |  |
| `archivedDate` | integer (int64) | no |  |
| `deletionTimeAdjustable` | boolean | no |  |
| `transcodingRetryable` | boolean | no |  |
| `retentionPolicyId` | integer (int64) | no |  |
| `attachmentCount` | integer (int64) | no |  |
| `subtitleCount` | integer (int64) | no |  |
| `captionCount` | integer (int64) | no |  |
| `permissions` | array&lt;[`Permission`](#schema-permission)&gt; | no |  |
| `aiIndexingStatus` | [`AiIndexingStatus`](#schema-aiindexingstatus) | no |  |
| `relatedVideos` | [`RelatedVideos`](#schema-relatedvideos) | no |  |
| `approvers` | [`ApproversDto`](#schema-approversdto) | no |  |

### Schema: `VideoDuplicationDTO`

<a id="schema-videoduplicationdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `title` | string | yes |  |

### Schema: `VideoManagerInfo`

<a id="schema-videomanagerinfo"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `name` | string | no |  |
| `company` | string | no |  |
| `department` | string | no |  |
| `owner` | string | no |  |

### Schema: `VideoManagerInfoDTO`

<a id="schema-videomanagerinfodto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `name` | string | no |  |
| `uuid` | string | no |  |
| `configuration` | object | no |  |

### Schema: `VideoManagerPartialUpdateRequest`

<a id="schema-videomanagerpartialupdaterequest"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `name` | string | no |  |
| `companyName` | string | no |  |
| `useDefaultTitle` | boolean | no |  |
| `useDefaultDescription` | boolean | no |  |
| `useDefaultKeywords` | boolean | no |  |
| `stillTimepoint` | integer (int64) | no |  |
| `defaultLocaleId` | integer (int64) | no |  |
| `defaultSecurityPolicyId` | integer (int64) | no |  |
| `defaultAdConfigurationId` | integer (int64) | no |  |
| `defaultRetentionPolicyId` | integer (int64) | no |  |
| `videoListItemDisplayOption` | string | no |  |
| `defaultAccessProfileId` | integer (int64) | no |  |
| `supportContactInformation` | string | no |  |
| `linkToDocumentation` | string | no |  |
| `defaultSubtitlePublishingEnabled` | boolean | no |  |
| `defaultSubtitleTranslations` | array&lt;[`AiSubtitleLocale`](#schema-aisubtitlelocale)&gt; | no |  |

### Schema: `VideoMergeRequest`

<a id="schema-videomergerequest"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `newVideo` | boolean | no |  |
| `title` | string | no |  |
| `introVideoId` | string | no |  |
| `outroVideoId` | string | no |  |
| `channelId` | integer (int64) | no |  |

### Schema: `VideoPartialUpdateRequest`

<a id="schema-videopartialupdaterequest"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `vrContentType` | string | no |  |
| `scheduledTrashDate` | string | no |  |
| `scheduledArchiveDate` | string | no |  |
| `sourceLanguage` | string | no |  |
| `aiIndexingTriggered` | string | no |  |
| `adConfigurationId` | integer (int64) | no |  |
| `securityPolicyId` | integer (int64) | no |  |
| `owner` | integer (int64) | no |  |
| `relatedVideosChannelId` | integer (int64) | no |  |
| `relatedChannels` | array&lt;integer (int64)&gt; | no |  |
| `relatedVideos` | array&lt;string&gt; | no |  |
| `deleted` | boolean | no |  |
| `generateKeywords` | boolean | no |  |
| `generateLabels` | boolean | no |  |
| `generateTopics` | boolean | no |  |
| `generateSubtitles` | boolean | no |  |
| `transcode` | boolean | no |  |
| `published` | boolean | no |  |
| `downloadable` | boolean | no |  |
| `substituteOwners` | array&lt;number&gt; | no |  |
| `extendRetentionPolicyBy` | string (duration) | no |  |
| `retentionPolicyId` | integer (int64) | no |  |
| `chunksFullyUploaded` | boolean | no |  |

### Schema: `VideoSplitRequest`

<a id="schema-videosplitrequest"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `segments` | array&lt;[`Segment`](#schema-segment)&gt; | no |  |
| `channelId` | integer (int64) | no |  |

### Schema: `VideoStorageInfo`

<a id="schema-videostorageinfo"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `currentValue` | integer (int64) | no |  |
| `maxValue` | integer (int64) | no |  |
| `sizeValue` | number (double) | no |  |

### Schema: `VideoStreamDto`

<a id="schema-videostreamdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `index` | integer (int32) | no |  |
| `codec` | string | no |  |
| `bitRate` | integer (int64) | no |  |
| `duration` | integer (int64) | no |  |
| `codecTimeBase` | string | no |  |
| `frameRate` | string | no |  |
| `rotate` | integer (int32) | no |  |
| `resolution` | [`ResolutionDto`](#schema-resolutiondto) | no |  |
| `aspectRatio` | [`AspectRatioDto`](#schema-aspectratiodto) | no |  |

### Schema: `VideoTrimDto`

<a id="schema-videotrimdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `startTime` | string | yes |  |
| `endTime` | string | yes |  |

### Schema: `VideoUploadRequestDTO`

<a id="schema-videouploadrequestdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `title` | string | no |  |
| `description` | string | no |  |
| `keywords` | array&lt;string&gt; | no |  |
| `channel` | integer (int64) | no |  |
| `group` | integer (int64) | no |  |
| `fileName` | string | yes |  |
| `autoPublish` | boolean | no |  |

### Schema: `ViewPublicationStatus`

<a id="schema-viewpublicationstatus"></a>

**Type:** enum

- `PROGRESS`
- `SUCCESS`
- `ERROR`

### Schema: `ViewPublicationStatusErrorCause`

<a id="schema-viewpublicationstatuserrorcause"></a>

**Type:** enum

- `VIDEO_ALREADY_EXISTS`
- `AUTHENTICATION_FAILED`
- `QUOTA_EXCEEDED`
- `UNKNOWN_ERROR`
- `NO_ERROR`
- `UNSPECIFIED`
- `PROFILE_DISCONNECTED`

### Schema: `YoutubePublicationDTO`

<a id="schema-youtubepublicationdto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | no |  |
| `videoId` | string | yes |  |
| `videoManagerId` | integer (int64) | no |  |
| `type` | [`SocialMediaType`](#schema-socialmediatype) | yes |  |
| `title` | string | yes |  |
| `progress` | integer (int32) | no |  |
| `description` | string | yes |  |
| `creationDate` | integer (int64) | no |  |
| `state` | [`ViewPublicationStatus`](#schema-viewpublicationstatus) | no |  |
| `errorCause` | [`ViewPublicationStatusErrorCause`](#schema-viewpublicationstatuserrorcause) | no |  |
| `successDate` | integer (int64) | no |  |
| `isReuploadPossible` | boolean | no |  |
| `publicationProfile` | [`PublicationProfileDTO`](#schema-publicationprofiledto) | yes |  |
| `youtubeVideoId` | string | no |  |
| `privacyState` | [`PublicationPrivacyStatus`](#schema-publicationprivacystatus) | no |  |
| `tags` | array&lt;string&gt; | no |  |

### Schema: `YoutubePublicationProfileDTO`

<a id="schema-youtubepublicationprofiledto"></a>

| Property | Type | Required | Description |
| --- | --- | --- | --- |
| `id` | integer (int64) | yes |  |
| `videoManagerId` | integer (int64) | yes |  |
| `name` | string | yes |  |
| `status` | [`PublicationProfileStatus`](#schema-publicationprofilestatus) | yes |  |
| `type` | [`SocialMediaType`](#schema-socialmediatype) | no |  |
| `creationDate` | integer (int64) | no |  |
| `connectionDate` | integer (int64) | no |  |

