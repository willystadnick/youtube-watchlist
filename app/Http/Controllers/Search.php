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
                'days' => [
                    'day1' => $request->day1,
                    'day2' => $request->day2,
                    'day3' => $request->day3,
                    'day4' => $request->day4,
                    'day5' => $request->day5,
                    'day6' => $request->day6,
                    'day7' => $request->day7,
                ],
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
            $data['watchlist'] = $this->getWatchlist($data['input']['days'], $data['results']);
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

    private function getWatchlist($days, $results)
    {
        $watchlist = [];
        $week = 1;

        while (count($results) > 0) {

            foreach ($days as $day => $available) {
                $prefix = 'week' . $week . '-' . $day . '-available' . $available;

                while ($available > 0) {
                    $result = array_shift($results);

                    if ( ! $result) {
                        break 3;
                    }

                    if (empty($watchlist[$prefix]) && $result['minutes'] > $available) {
                        continue;
                    }

                    if ($result['minutes'] <= $available) {
                        $watchlist[$prefix][] = $result;
                        $available -= $result['minutes'];
                        continue;
                    }

                    array_unshift($results, $result);
                    break;
                }
            }

            $week++;
        }

        return $watchlist;
    }
}
