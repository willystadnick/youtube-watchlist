<?php

namespace App\Http\Controllers;

use App\Http\Requests\Welcome as Request;

class Welcome extends Controller
{
    public function search(Request $request)
    {
        $client = new \Google_Client();
        $client->setDeveloperKey(env('GOOGLE_DEVELOPER_KEY'));
        $youtube = new \Google_Service_YouTube($client);
        $data = [
            'input' => [
                'search' => $request->search,
            ],
        ];

        try {
            $search = $youtube->search->listSearch('id,snippet', [
                'maxResults' => env('YOUTUBE_MAX_RESULTS'),
                'q' => $request->search,
                'type' => 'video',
            ]);

            $ids = [];

            foreach ($search['items'] as $item) {
                array_push($ids, $item['id']['videoId']);
            }

            $videos = $youtube->videos->listVideos('snippet,contentDetails', [
                'id' => join(',', $ids),
            ]);

            $data['results'] = $videos['items'];
        } catch (\Google_Service_Exception $e) {
            $data['alert']['type'] = 'danger';
            $data['alert']['message'] = sprintf('<p>A service error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
        } catch (\Google_Exception $e) {
            $data['alert']['type'] = 'danger';
            $data['alert']['message'] = sprintf('<p>A client error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
        }

        return view('welcome', $data);
    }
}
