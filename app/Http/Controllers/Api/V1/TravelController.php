<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TravelResource;
use App\Models\Travel;

class TravelController extends Controller
{
    /**
     * Retrieve a collection of public travel records.
     * laravel by default convert to json if it is  elquent collection
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        $travels = Travel::where('is_public', true)->paginate();
        if ($travels->isEmpty()) {
            return response()->json([
                'message' => 'No public travel records found.',
            ], 404);
        }

        return TravelResource::collection($travels);
    }
}
