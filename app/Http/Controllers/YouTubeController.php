<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client;
use Google_Service_YouTube;

class YouTubeController extends Controller 
{

	/**
	 * Main index function to control controller actions
	 * @return type
	 */
	public function index() {
		if (isset($_GET['q']) && isset($_GET['maxResults'])) {
			// Developer Key 
			$DEVELOPER_KEY = 'AIzaSyAxLryCYS5ADMHwW5oAySaRHAR25LXpdq4';
			$client = new Google_Client();
			$client->setDeveloperKey($DEVELOPER_KEY);
			// Define an object that will be used to make all API requests.
			$youtube = new Google_Service_YouTube($client);
			$htmlBody = '';
			try {
				$searchResponse = $youtube->search->listSearch('id,snippet', array(
					'q' => $_GET['q'],
					'maxResults' => $_GET['maxResults'],
				));
				$videos = '';
				$channels = '';
				$playlists = '';
				// Iterating the result and preparing respective list
				foreach ($searchResponse['items'] as $searchResult) {
					switch ($searchResult['id']['kind']) {
						case 'youtube#video':
							error_log(print_r($searchResult, 1));
							$videos .= sprintf('<a href="https://www.youtube.com/watch?v=%s" class="list-group-item" target="_blank">%s </a>', $searchResult['id']['videoId'], $searchResult['snippet']['title']);
							break;
						case 'youtube#channel':
							$channels .= sprintf('<a href="https://www.youtube.com/channel/%s" class="list-group-item" target="_blank">%s </a>', $searchResult['id']['channelId'], $searchResult['snippet']['title']);
							break;
						case 'youtube#playlist':
							$playlists .= sprintf('<a href="https://www.youtube.com/playlist?list=%s" class="list-group-item" target="_blank">%s </a>', $searchResult['id']['playlistId'], $searchResult['snippet']['title']);
							break;
					}
				}
				$htmlBody .= $this->prepareHTML($videos, $channels, $playlists);
			} catch (Google_Service_Exception $e) {
				$htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
			} catch (Google_Exception $e) {
				$htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
			}
			return response()->json(array('success' => true, 'htmlBody'=>$htmlBody));
		}
		
		return view('youtube');
	}

	/**
	 * merging videos, channels and playlist in a single HTML div
	 * @param type $videos
	 * @param type $channels
	 * @param string $playlists
	 * @return type
	 */
	function prepareHTML ($videos, $channels, $playlists) {
		if (empty($playlists)) {
			$playlists = '<div class="list-group">No List Found</div>';
		}
		$htmlBody = <<<END
   <div class="panel panel-default"> 
   <div class="panel-heading">Videos</div>
   <div class="list-group">$videos</div></div>
   <div class="panel panel-default">
   <div class="panel-heading">Channels</div>
   <div class="list-group">$channels</div></div>
   <div class="panel panel-default"> 
   <div class="panel-heading">Playlists</div>
   <div class="list-group">$playlists</div></div>
END;
		return $htmlBody;
	}

}
