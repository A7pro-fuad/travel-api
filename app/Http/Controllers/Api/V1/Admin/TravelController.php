<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TravelRequest;
use App\Http\Resources\TravelResource;
use App\Models\Travel;

class TravelController extends Controller
{
    public function store(TravelRequest $request)
    {
        // try {
        //     $client = new \GuzzleHttp\Client();
        //     $response = $client->request('GET', 'https://api.github.com/repos/guzzle/guzzle123456');
        // } catch (RequestException $ex) {
        //     abort(404, 'Github Repository not found');
        // }

        // abort(404, 'Github Repository not found');
        $travel = Travel::create($request->validated());

        return (new TravelResource($travel))
            ->response()
            ->setStatusCode(201);
    }

    public function update(Travel $travel, TravelRequest $request)
    {
        $travel->update($request->validated());

        return new TravelResource($travel);
        // ->response()
        // ->setStatusCode(201);
    }
}
