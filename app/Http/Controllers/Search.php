<?php

namespace App\Http\Controllers;

use App\Http\Requests\Search as Request;

class Search extends Controller
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

            foreach ($videos['items'] as $item) {
                $words[] = $item['snippet']['title'];
                $words[] = $item['snippet']['description'];

                $seconds = (new \DateTime)
                    ->setTimeStamp(0)
                    ->add(new \DateInterval($item['contentDetails']['duration']))
                    ->getTimeStamp();

                $data['results'][] = [
                    'title' => $item['snippet']['title'],
                    'image' => $item['snippet']['thumbnails']['default']['url'],
                    'minutes' => ceil($seconds / 60),
                ];
            }

            $data['words'] = $this->getMostUsedWords($words);
        } catch (\Google_Service_Exception $e) {
            $data['alert']['type'] = 'danger';
            $data['alert']['message'] = sprintf('<p>A service error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
        } catch (\Google_Exception $e) {
            $data['alert']['type'] = 'danger';
            $data['alert']['message'] = sprintf('<p>A client error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
        }

        return view('search', $data);
    }

    private function getMostUsedWords($texts)
    {
        $lines = [];

        foreach ($texts as $text) {
            $_lines = explode("\n", $text);

            foreach ($_lines as $line) {
                if ($line) {
                    $lines[] = $line;
                }
            }
        }

        $words = [];

        foreach ($lines as $line) {
            $_words = explode(" ", $line);

            foreach ($_words as $word) {
                if (preg_match('/\w/', $word)) {
                    if (isset($words[$word])) {
                        $words[$word]++;
                    } else {
                        $words[$word] = 1;
                    }
                }
            }
        }

        arsort($words);

        return array_slice($words, 0, 5);
    }
}
