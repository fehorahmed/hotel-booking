<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoomResource;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->per_page) {
            $perPage = $request->per_page;
        } else {
            $perPage = 10;
        }
        $query = Room::query();
        if ($request->search) {
            $query->where('room_no', 'LIKE', "%{$request->search}%");
        }
        return RoomResource::collection($query->paginate($perPage));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $rules = [
            'hotel_id' => 'required|numeric',
            'room_no' => [
                'required',
                'string',
                'max:255',
                Rule::unique('rooms')->where(function ($query) use ($request) {
                    return $query->where('hotel_id', $request->hotel_id);
                }),
            ],
            'description' => 'required|string|max:255',
            'room_category_id' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use ($request) {
                    // Check if the room category exists for the hotel
                    $exists = DB::table('room_categories')
                        ->where('id', $value)
                        ->where('hotel_id', $request->hotel_id)
                        ->exists();

                    if (!$exists) {
                        $fail("The selected $attribute is invalid for the given hotel.");
                    }
                },
            ],
            'price_for_govt' => 'required|numeric',
            'price_for_non_govt' => 'required|numeric',
            'is_special' => 'required|boolean',
            'status' => 'required|boolean',
        ];

        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()->first(),
                'errors' => $validation->errors()
            ], 422);
        }

        $data = new Room();
        $data->room_no = $request->room_no;
        $data->description = $request->description;
        $data->hotel_id = $request->hotel_id;
        $data->room_category_id = $request->room_category_id;
        $data->price_for_govt = $request->price_for_govt;
        $data->price_for_non_govt = $request->price_for_non_govt;
        $data->is_special = $request->is_special;
        $data->status = $request->status;
        $data->created_by = auth()->id();
        if ($data->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Room Create Successfully.',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
            ], 404);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($room)
    {
        $data = Room::find($room);
        if($data){
            return response()->json([
                'status' => true,
                'data' => new RoomResource($data),
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Room not found.',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $room)
    {
        $rules = [
            'hotel_id' => 'required|numeric',
            'room_no' => [
                'required',
                'string',
                'max:255',
                Rule::unique('rooms')->where(function ($query) use ($request,$room) {
                    return $query->where('hotel_id', $request->hotel_id)->where('id','!=',$room);
                }),
            ],
            'description' => 'required|string|max:255',
            'room_category_id' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use ($request) {
                    // Check if the room category exists for the hotel
                    $exists = DB::table('room_categories')
                        ->where('id', $value)
                        ->where('hotel_id', $request->hotel_id)
                        ->exists();

                    if (!$exists) {
                        $fail("The selected $attribute is invalid for the given hotel.");
                    }
                },
            ],
            'price_for_govt' => 'required|numeric',
            'price_for_non_govt' => 'required|numeric',
            'is_special' => 'required|boolean',
            'status' => 'required|boolean',
        ];

        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()->first(),
                'errors' => $validation->errors()
            ], 422);
        }

        $data = Room::find($room);
        $data->room_no = $request->room_no;
        $data->description = $request->description;
        $data->hotel_id = $request->hotel_id;
        $data->room_category_id = $request->room_category_id;
        $data->price_for_govt = $request->price_for_govt;
        $data->price_for_non_govt = $request->price_for_non_govt;
        $data->is_special = $request->is_special;
        $data->status = $request->status;
        $data->updated_by = auth()->id();
        if ($data->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Room Update Successfully.',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        //
    }
    public function apiGetRooms($hotel)
    {
        $ck_hotel = Hotel::where('url',$hotel)->first();
        if($ck_hotel){

            $rooms = Room::where('hotel_id',$ck_hotel->id)->get();

            return response()->json([
                'status' => true,
                'datas' => RoomResource::collection($rooms),
            ],404);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Hotel not found.',
            ],404);
        }

    }
}
