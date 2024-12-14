<?php

namespace App\Http\Controllers;

use App\Http\Requests\HotelCreateRequest;
use App\Http\Resources\HotelResource;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // if ($request->per_page) {
        //     $perPage = $request->per_page;
        // } else {
        //     $perPage = 10;
        // }

        return HotelResource::collection(Hotel::orderBy('id', 'DESC')
            ->orderBy('id', 'DESC')
            ->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(HotelCreateRequest $request)
    {
        $hotel = new Hotel();
        $hotel->name = $request->name;
        $findUrl = $hotel->where('url', '=', Str::slug($request->name, '-'))->count();
        if ($findUrl == 0) {
            $hotel->url = Str::slug($request->name, '-');
        } else {
            $hotel->url = Str::slug($request->name . ' ' . rand(00, 99), '-');
        }
        $hotel->division_id = $request->division_id;
        $hotel->district_id = $request->district_id;
        $hotel->sub_district_id = $request->sub_district_id;
        $hotel->address = $request->address;
        $hotel->status = $request->status;
        $hotel->created_by = Auth::id();
        if ($hotel->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Hotel created successfully.',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.!',
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Hotel $hotel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($hotel)
    {
        $hotel = Hotel::find($hotel);
        if ($hotel) {
            return response()->json([
                'status' => true,
                'data' => new HotelResource($hotel)
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Hotel not found.'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HotelCreateRequest $request, $hotel)
    {

        $data = Hotel::find($hotel);
        $data->name = $request->name;
        $data->division_id = $request->division_id;
        $data->district_id = $request->district_id;
        $data->sub_district_id = $request->sub_district_id;
        $data->address = $request->address;
        $data->status = $request->status;

        if ($data->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Hotel updated successfully.',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.!',
            ]);
        }
    }


    public function apiGetHotels(Hotel $hotel)
    {
        return HotelResource::collection(Hotel::where('status', 1)
            ->orderBy('id', 'DESC')
            ->get());
    }
}
