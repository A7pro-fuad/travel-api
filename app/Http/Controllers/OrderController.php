<?php

namespace App\Http\Controllers;

use App\Models\Deliveryman;

class OrderController extends Controller
{
    public function show(Deliveryman $deliveryman)
    {
        $order = Deliveryman::find($deliveryman->id);

        return view('layout', [
            'order'=> $order
        ]);
    }
}
