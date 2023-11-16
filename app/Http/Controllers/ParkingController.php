<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Parking;

class ParkingController extends Controller
{
    public function parking(Request $request) {
        $data = Parking::where([
            ['car_number', '=', $request->car_number],
            ['status', '=', 'parking']
        ])->get();

        $price = 3000;

        if (count($data) === 0) {
            $requestData = $request;
            $id = Str::uuid();
            $time_in = date('Y-m-d H:i:s');

            try {
                Parking::create([
                    'car_number' => $requestData->car_number,
                    'id' => $id,
                    'time_in' => $time_in,
                    'status' => 'parking',
                    'price' => $price
                ]);

                return response([
                    'message' => 'Success'
                ], 201);
            } catch (\Throwable $th) {
                abort(response([
                    'message' => 'Something went wrong',
                    'code' => 502
                ], 502));
            }

        } else {
            $diff = (time()-strtotime($data[0]->time_in))/3600;
            $data[0]->time_out = date('Y-m-d H:i:s');
            $data[0]->status = 'out';
            
            if ($diff > 1) {
                $data[0]->price = $price * $diff;
            }

            $data[0]->save();

            return Parking::find($data[0]->id);
        }
    }

    public function parkings() {
        return Parking::all();
    }
}
