<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function getUserBalance(int $id)
    {
        try {
            $client = new Client();
            $response = $client->post(env('BALANCE_URI'), [
                'json' => [
                    'jsonrpc' => '2.0',
                    'method' => 'balance.userBalance',
                    'params' => [
                        'user_id' => 10
                    ],
                    'id' => 1
                ]
            ]);
            if ($response->getStatusCode() === 200) {
                return $response->getBody()->getContents();
            }
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
        return $response->getStatusCode();
    }

    public function getBalanceHistory(int $limit)
    {
        try {
            $client = new Client();
            $response = $client->post(env('BALANCE_URI'), [
                'json' => [
                    'jsonrpc' => '2.0',
                    'method' => 'balance.history',
                    'params' => [
                        'limit' => 10
                    ],
                    'id' => 1
                ]
            ]);
            if ($response->getStatusCode() === 200) {
                return $response->getBody()->getContents();
            }
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
        return $response->getStatusCode();
    }
}
