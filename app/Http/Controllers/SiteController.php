<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    public $myLat;
    public $myLong;

    public function __construct()
    {
        $this->myLat  = "53.3340285";
        $this->myLong = "-6.2535495";
    }

    /**
     * @name getNearestLocation
     */
    public function getNearestLocation(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'location-list' => 'required|mimes:json|file',
        ]);

        if ($validator->fails()) {
            $result = [
                'status'  => 'validation',
                'message' => 'Please upload valid JSON-encoded file',
            ];

            return response()->json($result);
        }

        $file = $request->file('location-list');

        if (!empty($file)) {

            $affiliates = [];
            $contents   = file_get_contents($file->getRealPath());

            foreach (explode("\n", $contents) as $key => $line) {
                $address = json_decode($line);
                if (!empty($address)) {
                    $distance = $this->findGreatCircleDistance($this->myLat, $this->myLong, $address->latitude, $address->longitude);
                    if ($distance <= 100) {
                        $address->distance                  = round($distance, 2);
                        $affiliates[$address->affiliate_id] = $address;
                    }
                }
            }
            ksort($affiliates);

            $table = (string) view('component.location-table', compact('affiliates'));

            $result = [
                'status'  => "success",
                'data'    => $table,
                'message' => "Get affiliates successfully!",
            ];
        } else {
            $result = [
                'status'  => "error",
                'data'    => [],
                'message' => "Please upload valid file",
            ];
        }

        return response()->json($result);
    }

    public function findGreatCircleDistance($latFrom, $longFrom, $latTo, $longTo, $earthRadius = 6371)
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latFrom);
        $lonFrom = deg2rad($longFrom);
        $latTo   = deg2rad($latTo);
        $lonTo   = deg2rad($longTo);

        $lonDelta = $lonTo - $lonFrom;

        $a = pow(cos($latTo) * sin($lonDelta), 2) + pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
        $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

        $angle = atan2(sqrt($a), $b);
        return $angle * $earthRadius;
    }
}
