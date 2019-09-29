<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new Venue();
    }

    public function index(Request $request)
    {
        $venues = $this->model->getVenues();
        if (isset($request->name) || isset($request->discount_percentage)) {
            $venues = array_values(array_filter($venues, function ($venue) use ($request) {
                if (isset($request->name) && isset($request->discount_percentage)) {
                    return stripos($venue['name'], $request->name) !== FALSE && $venue['discount_percentage'] >= $request->discount_percentage;
                } else if (isset($request->name)) {
                    return stripos($venue['name'], $request->name) !== FALSE;
                } else if (isset($request->discount_percentage)) {
                    return $venue['discount_percentage'] >= $request->discount_percentage;
                }
                return TRUE;
            }));
        }
        return response()->json($venues, 200);
    }
}
