<?php

namespace App\Services;

use App\Models\City;
use GuzzleHttp\Client;
use App\Models\Province;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Exception\RequestException;

class RajaOngkirService{
    protected $client;
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('RAJAONGKIR_API_KEY');
        $this->baseUrl = env('RAJAONGKIR_BASE_URL');
    }

    public function searchDestination($search)
    {
        try {
            $client = new \GuzzleHttp\Client();

            $response = $client->request('GET', 'https://rajaongkir.komerce.id/api/v1/destination/domestic-destination', [
                'headers' => [
                    'accept' => 'application/json',
                    'key' => env('RAJAONGKIR_API_KEY'), 
                ],
                'query' => [
                    'search' => $search, 
                ],
            ]);

            $responseBody = json_decode($response->getBody()->getContents(), true);
            $data = $responseBody['data'] ?? [];

            $filtered = array_filter($data, function ($item) use ($search) {
                return trim(Str::lower($item['label'])) === trim(Str::lower($search));
            });

            if($filtered){
                $filtered = array_values($filtered);
                $selected = $filtered[0];
            }

            return $selected ?? $data[0];
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function calculateCost($origin, $weight)
    {
        try {
            $client = new \GuzzleHttp\Client();

                $response = $client->request('POST', 'https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost', [
                    'headers' => [
                        'accept' => 'application/json',
                        'content-type' => 'application/json',
                        'key' => env('RAJAONGKIR_API_KEY'), 
                    ],
                    'query' => [
                        'origin' => $origin, 
                        'destination' => '8459', 
                        'weight' => $weight,
                        'courier' => 'jnt', 
                        'price' => 'lowest',
                    ],
                ]);

                $responseBody = json_decode($response->getBody()->getContents(), true);
                return $responseBody['data'][0]['cost'];
            } catch (\Exception $e) {
                return response()->json([
                    'error' => $e->getMessage(),
                ], 500);
            }
        }

    }