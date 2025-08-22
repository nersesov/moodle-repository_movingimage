<?php

/**
 * VideoManagerPro class
 *
 * @package    repository_movingimagepicker
 * @copyright  2019 Rainer Möller
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class VideoManagerPro
{

  const publicApiPath = 'https://api.video-cdn.net/v1/vms/';
  const privateApiPath = 'https://vmpro.movingimage.com/vam/rest/vms/';

  protected $VideoManagerID = 0;
  protected $AccessToken = '';
  protected $RefreshToken = '';

	public function getAccessToken()	{
	  return $this->AccessToken;
	}

	public function setAccessToken($vmproid, $token)	{
	  $this->VideoManagerID = $vmproid;
	  $this->AccessToken = $token;
	}

  /**
   * Test connection to movingimage API
   * @return boolean True if connection is successful, false otherwise
   */
  public function testConnection() {
    $result = $this->callPublicAPI('');
    if ($result === false) {
        error_log("movingimage testConnection: Connection failed");
        return false;
    }
    
    // Simple check if we got a valid response
    if (strpos($result, '<title>Error</title>') !== false) {
        error_log("movingimage testConnection: Received error page");
        return false;
    }
    
    error_log("movingimage testConnection: Connection successful");
    return true;
  }

	public function tryAccessToken($vmproid, $token)	{
    // Validate input parameters
    if (empty($vmproid) || empty($token)) {
        error_log("movingimage tryAccessToken: Missing required parameters - vmproid: " . (empty($vmproid) ? 'empty' : $vmproid) . ", token: " . (empty($token) ? 'empty' : 'provided'));
        return false;
    }

    $this->setAccessToken($vmproid, $token);
	  $result = $this->callPublicAPI('');
    
    if ($result === false) {
        error_log("movingimage tryAccessToken: API call failed");
        $this->setAccessToken($vmproid, '');
        return false;
    }
    
	  if (strpos($result, '<title>Error</title>') === false) {
      error_log("movingimage tryAccessToken: Token validation successful");
      return true;
    } else {
      error_log("movingimage tryAccessToken: Token validation failed - received error page");
      $this->setAccessToken($vmproid,'');
      return false;
    }
	}

	public function getVideoToken($videoID, $expTime)	{
	  $data = sprintf('{"video-id":"%s", "exp-time": %s}' , $videoID, $expTime);
	  $hash = hash_hmac ( 'sha256', $data , hex2bin($this->SharedSecret) );
	  $token = sprintf ('%s~%s', $expTime , $hash);
	  return $token;
	}

  protected function callAPI($apiPath, $data, $mode, $header)
  {
    $request = curl_init();

    if (!$request) {
        error_log("movingimage API Error: Failed to initialize cURL");
        return false;
    }

		if ($mode == CURLOPT_HTTPGET)
			$url = $apiPath.'?'.http_build_query($data,'', '&');
		else  {
			$url = $apiPath;
			curl_setopt($request, CURLOPT_POSTFIELDS, json_encode($data));
		}

    // Improved SSL and connection settings
    curl_setopt($request, CURLOPT_SSL_VERIFYPEER, TRUE);
    curl_setopt($request, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($request, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($request, CURLOPT_TIMEOUT, 60);  // Increased timeout
    curl_setopt($request, CURLOPT_CONNECTTIMEOUT, 30);  // Increased connection timeout
    curl_setopt($request, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($request, CURLOPT_MAXREDIRS, 5);
    curl_setopt($request, CURLOPT_USERAGENT, 'Moodle movingimage Connector v3.0');
    
    switch ($mode) {
      case 'CURLOPT_PUT':
        curl_setopt($request, CURLOPT_CUSTOMREQUEST, 'PUT');
        break;
      case 'CURLOPT_PATCH':
        curl_setopt($request, CURLOPT_CUSTOMREQUEST, 'PATCH');
        break;
      default:
        curl_setopt($request, $mode, TRUE);
    }
    
    curl_setopt($request, CURLOPT_URL, $url);
    if ($header)
		  curl_setopt($request, CURLOPT_HEADER, TRUE);

    if ($this->AccessToken !== null && !empty($this->AccessToken)) {
		  curl_setopt($request, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: Bearer '.$this->AccessToken));
    } else {
      curl_setopt($request, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    }

    $result = curl_exec($request);
    $httpcode = curl_getinfo($request, CURLINFO_HTTP_CODE);
    $error = curl_error($request);
    $errno = curl_errno($request);
    curl_close($request);
    
    // Enhanced error logging and handling
    if ($result === false || !empty($error) || $errno !== 0) {
        error_log("movingimage API cURL Error - URL: $url, Error: $error, Errno: $errno, HTTP: $httpcode");
        return false;
    }
    
    if ($httpcode >= 400) {
        error_log("movingimage API HTTP Error - URL: $url, HTTP: $httpcode, Response: " . substr($result, 0, 500));
        
        // Try to parse error response
        $errorResponse = json_decode($result, true);
        if (is_array($errorResponse) && isset($errorResponse['message'])) {
            error_log("movingimage API Error Message: " . $errorResponse['message']);
        }
        
        return false;
    }
    
    // Success logging for important operations
    if (strpos($url, 'auth/login') !== false || strpos($url, 'videos') !== false) {
        error_log("movingimage API Success - URL: $url, HTTP: $httpcode");
    }
    
    return $result;
  }

  protected function callPublicAPI($apiPath, $data = [], $mode = CURLOPT_HTTPGET, $header = false)
  {
    return $this->callAPI(self::publicApiPath.$apiPath, $data, $mode, $header);
  }

  protected function callPrivateAPI($apiPath, $data = [], $mode = CURLOPT_HTTPGET, $header = false)
  {
    return $this->callAPI(self::privateApiPath.$apiPath, $data, $mode, $header);
  }

  public function login($username, $password, $vmproID = 0)
  {
    // Validate input parameters
    if (empty($username) || empty($password) || empty($vmproID)) {
        error_log("movingimage login: Missing required parameters - username: " . (empty($username) ? 'empty' : 'provided') . ", password: " . (empty($password) ? 'empty' : 'provided') . ", vmproID: " . (empty($vmproID) ? 'empty' : $vmproID));
        return false;
    }

    $data = ['username' => $username, 'password' => $password];
    error_log("movingimage login: Attempting login for user '$username' with VMPro ID '$vmproID'");
    
    $result = $this->callPublicAPI('auth/login', $data, CURLOPT_POST);
    
    // Check if API call failed
    if ($result === false) {
        error_log("movingimage login: API call failed for user '$username'");
        return false;
    }
    
    $result = json_decode($result, true);

    if (is_array($result) && !isset($result['message']) && isset($result['accessToken'])) {
      $this->AccessToken = $result['accessToken'];
      if (isset($result['refreshToken'])) {
          $this->RefreshToken = $result['refreshToken'];
      }
      $this->VideoManagerID = $vmproID;
      error_log("movingimage login: Success for user '$username'");
			return true;
    } else {
      $error_msg = isset($result['message']) ? $result['message'] : 'Unknown error - check credentials and VMPro ID';
      error_log("movingimage login: Failed for user '$username' - $error_msg");
    }
    return false;
  }

  private function findChannel ($tree, $channel, $level = 0) {
    if (intval($channel) > 0) {
      if ($tree['id'] == $channel)
        return $tree;
    } else {
      if ($tree['name'] == $channel || $channel == '0')
        return $tree;
    }
    if (count($tree['children']) > 0) {
      foreach ($tree['children'] as $child) {
        $success = $this->findChannel($child, $channel, $level + 1);
        if ($success != [])
          return $success;
      }
    }
    return [];
  }

  public function getChannels($baseChannel = '0')
  {
    $result = $this->callPublicAPI($this->VideoManagerID.'/channels');
    $fullTree = json_decode($result, true);
    if (!(is_array($fullTree) && isset($fullTree["id"])))
      return [];

		if ($baseChannel != '0' && $baseChannel != null)
      $list = $this->findChannel($fullTree, $baseChannel);
    else
      $list = $fullTree;

		return $list;
  }

  public function getRootChannelID()
  {
    $result = $this->callPublicAPI($this->VideoManagerID.'/channels');
    $fullTree = json_decode($result, true);
    if (is_array($fullTree) && isset($fullTree["id"]))
		  return $fullTree['id'];
    else
      return 0;
  }

  public function getChannelIDByName($name)
  {
    $channels = $this->getChannels($name);
    if (!is_array($channels) || $channels == [] || !isset($channels['id']))
      return 0;
    else
      return $channels['id'];
  }

  public function createChannel($name,$parentID,$ownerGroupID = 0)
  {
    $data = array();
    $data['name'] =  $name;
    $data['parentId'] =  $parentID;
    if ($ownerGroupID != 0)
      $data['ownerGroupId'] =  $ownerGroupID;
    $result = $this->callPublicAPI($this->VideoManagerID.'/channels',$data, CURLOPT_POST, true);
		preg_match('|Location: *'.self::publicApiPath.'[0-9]*/channels/([0-9]*)|i',$result,$match);

    if (is_array($match) && isset($match[1]))
			$list = $match[1];
		else
			$list = 0;
		return $list;
  }

  public function addVideoToChannel($channelID, $videoID)
  {
    $result = $this->callPublicAPI($this->VideoManagerID.'/channels/'.$channelID.'/videos/'.$videoID, [], CURLOPT_POST);
    return json_decode($result, true);
  }

  public function getVideos($channel = 0, $limit = 50, $offset = 0, $search = '', $sort = '', $sub_channels = false, $public = '', $sortasc = false, $channel_assignments = false)
  {
    // Validate access token
    if (empty($this->AccessToken)) {
        error_log("movingimage getVideos: No access token available");
        return false;
    }

		$data = array();
  	if ($channel !== 0)
  		$data['channel_id'] = $channel;
  	$data['offset'] = $offset;
    $data['limit'] = $limit;
    $data['include_sub_channels'] = $sub_channels;
    $data['include_custom_metadata'] = 'true';
    $data['include_keywords'] = 'true';
  	if ($sortasc)
  		$data['order'] = 'asc';
    if ($channel_assignments)
  		$data['include_channel_assignments'] = 'true';
  	if ($search != '')
  		$data['search_term'] = $search;
  	if ($public != '')
  		$data['publication_state'] = $public;
  	if ($sort != '')
  		$data['order_property'] = $sort;

    // Debug logging
    $api_url = $this->VideoManagerID.'/videos';
    error_log("movingimage getVideos: URL=$api_url, Channel=$channel, Data=" . json_encode($data));
    
    $result = $this->callPublicAPI($api_url, $data);
    
    if ($result === false) {
        error_log("movingimage getVideos: API call failed");
        return false;
    }
    
    $list = json_decode($result, true);
    
    // Enhanced error logging
    if ($list === null) {
        error_log("movingimage getVideos: JSON decode failed, raw response: " . substr($result, 0, 500));
        return false;
    } else if (!is_array($list)) {
        error_log("movingimage getVideos: Invalid response format");
        return false;
    } else {
        $video_count = isset($list['videos']) ? count($list['videos']) : 0;
        error_log("movingimage getVideos: Success, found $video_count videos");
    }

  	return $list;
  }

  public function getVideo($videoID,$data)
  {
    $result = $this->callPublicAPI($this->VideoManagerID.'/videos/'.$videoID, $data);
    return json_decode($result, true);
  }

  public function getCustomMetadata($videoID)
  {
    $result = $this->callPublicAPI($this->VideoManagerID.'/videos/'.$videoID.'/metadata');
    return json_decode($result, true);
  }

  public function setCustomMetadata($videoID, $data)
  {
    $result = $this->callPublicAPI($this->VideoManagerID.'/videos/'.$videoID.'/metadata',$data, 'CURLOPT_PATCH');
    return json_decode($result, true);
  }

  public function createVideoEntity($filename, $title ='', $description = '', $keywords = array(), $channelID = 0, $groupID = 0, $autopublish = true)
  {
    // Validate access token
    if (empty($this->AccessToken)) {
        error_log("movingimage createVideoEntity: No access token available");
        return false;
    }

    // Validate required parameters
    if (empty($filename)) {
        error_log("movingimage createVideoEntity: filename is required");
        return false;
    }

		$data = array();
		$data['fileName'] = $filename;
		$data['autoPublish'] = $autopublish;
		if ($title != '')
			$data['title'] = $title;
		if ($description != '')
			$data['description'] = $description;
		if (is_array($keywords) && count($keywords) > 0)
			$data['keywords'] = $keywords;
		else if (is_string($keywords) && $keywords != '')
			$data['keywords'] = explode(',',$keywords);
		if ($channelID != 0)
			$data['channel'] = $channelID;
		if ($groupID != 0)
			$data['group'] = $groupID;
    
    error_log("movingimage createVideoEntity: Creating video with filename='$filename', title='$title', channelID=$channelID");
    $result = $this->callPublicAPI($this->VideoManagerID.'/videos', $data, CURLOPT_POST, true);
    
    if ($result === false) {
        error_log("movingimage createVideoEntity: API call failed");
        return false;
    }
    
		preg_match('|Location: *'.self::publicApiPath.'[0-9]*/videos/([^[:space:]]*)|i',$result,$match);
		if (is_array($match) && isset($match[1])) {
			$list = ['id' => $match[1] ];
      error_log("movingimage createVideoEntity: Success - Video ID: " . $match[1]);
    } else {
			$list = $result;
      error_log("movingimage createVideoEntity: Failed to parse video ID from response: " . substr($result, 0, 200));
    }

		return $list;
  }

  public function getUploadURL($videoID)
  {
    // Validate access token
    if (empty($this->AccessToken)) {
        error_log("movingimage getUploadURL: No access token available");
        return false;
    }

    // Validate required parameters
    if (empty($videoID)) {
        error_log("movingimage getUploadURL: videoID is required");
        return false;
    }

    error_log("movingimage getUploadURL: Getting upload URL for video ID: $videoID");
    $result = $this->callPublicAPI($this->VideoManagerID.'/videos/'.$videoID.'/url',[], CURLOPT_HTTPGET, true);
    
    if ($result === false) {
        error_log("movingimage getUploadURL: API call failed for video ID: $videoID");
        return false;
    }
    
    preg_match('|Location: *(http[^[:space:]]*)|i',$result,$match);
		if (is_array($match) && isset($match[1])) {
			$list = ['upload_url' => $match[1] ];
      error_log("movingimage getUploadURL: Success - Upload URL retrieved for video ID: $videoID");
    } else {
			$list = [];
      error_log("movingimage getUploadURL: Failed to parse upload URL from response for video ID: $videoID");
    }

    return $list;
  }

  public function getUsers()
  {
      $result = $this->callPrivateAPI($this->VideoManagerID.'/users');
      $list = json_decode($result, true);
      $keyList = array();
      foreach ($list as $e)
        if (isset($e["id"]))
          $keyList[$e["id"]] = $e;
      return $keyList;
  }

  public function getUserIDByEmail($email)
  {
      $users = $this->getUsers();
      if (is_array($users))
        foreach ($users as $user) {
          if (isset($user['email']) && $user['email'] == $email)
            return $user['id'];
        }
	    return 0;
  }
  public function createUser($email, $companyRoleID, $sendActivationLink = true, $emailVerified = false, $enabled = false,
                             $locale = ['id' => 1, 'language' => 'de', 'country' => 'DE', 'languageTag' => 'de_DE'])
  {
      $data = [
        'companyName' => '',
        'email' => $email,
        'emailVerified' => $emailVerified,
        'enabled' => $enabled,
        'firstName' => '',
        'lastName' => '',
        'locale' => $locale,
        'loginName' => '',
        'sendActivationLink' => $sendActivationLink,
        'telephone' => ''
      ];
      $result = $this->callPrivateAPI($this->VideoManagerID.'/users', $data, CURLOPT_POST, true);
      preg_match('|Location: *'.self::privateApiPath.'[0-9]*/users/([0-9]*)|i',$result,$match);
  		if (is_array($match) && isset($match[1])) {
        $this->addUserToGroup($match[1],$this->getDefaultGroup(),$companyRoleID);
  			$list = $match[1];
  		} else
  			$list = false;
	    return $list;
  }

  public function addUserToGroup($userID, $groupID, $userroleID)
  {
    $data = [
      'groupId' => $groupID,
      'roleId' => $userroleID,
      'userId' => $userID
    ];
    $result = $this->callPrivateAPI($this->VideoManagerID.'/group-associations', $data, CURLOPT_POST);
    $list = json_decode($result, true);
    return $list;
  }

  public function createGroup($name, $description = '')
  {
      $data = array();
      $data['name'] = $name;
      $data['description'] = $description;
      $result = $this->callPrivateAPI($this->VideoManagerID.'/groups',$data,CURLOPT_POST, true);

  		preg_match('|Location: *'.self::privateApiPath.'[0-9]*/groups/([0-9]*)|i',$result,$match);
  		if (is_array($match) && isset($match[1]))
  			$list = $match[1];
  		else
  			$list = false;
	    return $list;
  }

    public function getGroups()
    {
        $result = $this->callPrivateAPI($this->VideoManagerID.'/groups');
        $list = json_decode($result, true);
        $keyList = array();
        if (is_array($list))
          foreach ($list as $e)
            if (isset($e["id"]))
      			   $keyList[$e["id"]] = $e;
    		return $keyList;
    }

    public function getRoles()
    {
        $result = $this->callPrivateAPI($this->VideoManagerID.'/roles');
        $list = json_decode($result, true);
        $keyList = array();
        if (is_array($list))
          foreach ($list as $e)
            if (isset($e["id"]))
        			$keyList[$e["id"]] = $e;
    		return $keyList;
    }

    public function getGroupIDByName($name)
    {
        $groups = $this->getGroups();
        if (is_array($groups))
          foreach ($groups as $group) {
            if (isset($group['name']) && $group['name'] == $name)
              return $group['id'];
          }
  	    return 0;
    }

    public function getDefaultGroup()
    {
      $groups = $this->getGroups();
      if (is_array($groups))
        foreach ($groups as $group) {
          if (isset($group['defaultGroup']) && $group['defaultGroup'] === true)
            return $group['id'];
        }
      return 0;
    }

    public function getGroupsAndUsers()
    {
        $result = $this->callPrivateAPI($this->VideoManagerID.'/group-associations');
        $list = json_decode($result, true);
		    return $list;
    }

    public function getAllSAMLGroupsAndRoles()
    {
      $result = $this->callPrivateAPI($this->VideoManagerID.'/saml-ownership-mapping');
      $list = json_decode($result, true);
      $keyList = array();
      if (is_array($list))
        foreach ($list as $e)
          if (isset($e["id"]))
            $keyList[$e["id"]] = $e;
      return $keyList;
    }

    public function getSAMLRolesForGroup($groupName)
    {
      $assignments = $this->getAllSAMLGroupsAndRoles();
      $list = [];

      if (is_array($assignment))
        foreach ($assignment as $a)
          if (isset($a["groupName"]) && $a["groupName"] == $groupName)
            $list[$a["samlAttribute"]] = $a["roleName"];
      return $list;
    }

    public function createSAMLGroupAndRole($samlAttribute,$groupID,$roleID)
    {
        $data = array();
        $data['samlAttribute'] = $samlAttribute;
        $data['groupId'] = $groupID;
        $data['roleId'] = $roleID;
        $result = $this->callPrivateAPI($this->VideoManagerID.'/saml-ownership-mapping',$data,CURLOPT_POST, true);

    		preg_match('|Location: *'.self::privateApiPath.'[0-9]*/saml-ownership-mapping/([0-9]*)|i',$result,$match);
    		if (is_array($match) && isset($match[1]))
    			$list = $match[1];
    		else
    			$list = false;
  	    return $list;
    }

    public function setVideoData($videoID, $data)
    {
      $result = $this->callPublicAPI($this->VideoManagerID.'/videos/'.$videoID, $data, 'CURLOPT_PATCH');
      return json_decode($result, true);
    }

    public function setVideoDeletionTimer($videoID, $timeStamp)
    {
      $data = ['scheduledTrashDate' => $timeStamp];
      $result = $this->callPrivateAPI($this->VideoManagerID.'/videos/'.$videoID, $data, 'CURLOPT_PATCH');
      return json_decode($result, true);
    }

    public function getPlayers()
    {
      $result = $this->callPublicAPI($this->VideoManagerID.'/players');
      $list = json_decode($result, true);
      $keyList = array();
  		foreach ($list as $e)
        if (isset($e["id"]))
    			$keyList[$e["id"]] = $e;
  		return $keyList;
    }

    public function getSecurityPolicies()
    {
      $result = $this->callPrivateAPI($this->VideoManagerID.'/security-policies');
      $list = json_decode($result, true);
      $keyList = array();
      foreach ($list as $e)
        if (isset($e["id"]))
          $keyList[$e["id"]] = $e;
      return $keyList;
    }

    public function getCustomMetadataFields()
    {
      $data = ['entityType' => 'VIDEO'];
      $result = $this->callPrivateAPI($this->VideoManagerID.'/custom-metadata-fields',$data);
      $list = json_decode($result, true);
      $keyList = array();
      foreach ($list as $e)
        if (isset($e["id"]))
          $keyList[$e["id"]] = $e;
      return $keyList;
    }

}
