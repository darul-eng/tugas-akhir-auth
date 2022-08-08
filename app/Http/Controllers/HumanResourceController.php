<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HumanResourceController extends Controller
{
    public function index(Request $request)
    {
        // $request->id_sdm;
        $body = $request->getContent();
        $body = json_decode($body, true);

        // $body = explode("{", $body['query']);
        $body = preg_replace('/[^a-zA-Z,{}_():0-9-"]/', "", $body);
        // $body = preg_replace('/[\n]/', "", $body);

        // $me = $body;
        $body = str_replace("\\", " ", $body['query']);

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('http://127.0.0.1:8000/graphql', [
            'query' => $body
        ]);

        // return $body;
        return $response->json();
    }
}
