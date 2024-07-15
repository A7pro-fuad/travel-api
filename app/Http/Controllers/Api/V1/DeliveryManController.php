<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\admin\DeliveryLocationUpdate;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryRequest;
use App\Http\Requests\UpdateDeliveryRequest;
use App\Http\Resources\DeliveryManResource;
use App\Models\Deliveryman;
use Symfony\Component\HttpFoundation\StreamedResponse;



class DeliveryManController extends Controller
{

    public function update(UpdateDeliveryRequest $request, Deliveryman $deliveryman)
    {
        $deliveryman->update($request->validated());

        event(new DeliveryLocationUpdate($deliveryman->latitude, $deliveryman->longitude,$deliveryman->name));
        return (new DeliveryManResource($deliveryman))
            ->response()
            ->setStatusCode(200);
    }
    public function store(DeliveryRequest $request)
    {
        $delivery = Deliveryman::create($request->validated());
        return (new DeliveryManResource($delivery))
            ->response()
            ->setStatusCode(201);
    }

    public function liveUpdates(Deliveryman $deliveryman)
    {
        return new StreamedResponse(function () use ($deliveryman) {
            // Logic to generate and yield event data (e.g., using a loop)
            while (true) {
                $event = new DeliveryLocationUpdate($deliveryman->name, $deliveryman->latitude, $deliveryman->longitude);
                yield json_encode($event) . PHP_EOL;
                sleep(2); // Simulate waiting for new data (replace with your logic)
            }
        });

        $response = new StreamedResponse(function () {
            while (true) {
                // Your server-side logic to get data
                $data = json_encode(['message' => 'This is a message']);

                echo "data: $data\n\n";

                // Flush the output buffer
                ob_flush();
                flush();
                // Delay for 1 second
                sleep(1);
            }
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');

        return $response;
    }


    public function updateLocation(DeliveryRequest $request, $deliveryPersonId)
    {
        $latitude = $request->get('latitude');
        $longitude = $request->get('longitude');

        // Validate and process location data...

        event(new DeliveryLocationUpdate($deliveryPersonId, $latitude, $longitude));

        return response()->json(['message' => 'Location updated successfully']);
    }
}
