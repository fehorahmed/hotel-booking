<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomCategoryCreateRequest;
use App\Http\Resources\RoomCategoryResource;
use App\Models\RoomCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


        return response([
            'status' => true,
            'datas' => RoomCategoryResource::collection(RoomCategory::all())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(RoomCategoryCreateRequest $request)
    {
        // dd($request->all());

        try {
            $data = new RoomCategory();
            $data->name = $request->name;
            $data->hotel_id = $request->hotel_id;
            $data->status = $request->status;
            if ($data->save()) {
                return response([
                    'status' => true,
                    'message' => 'Category added successfully.'
                ]);
            } else {
                return response([
                    'status' => false,
                    'message' => 'Something went wrong.!'
                ]);
            }
        } catch (\Throwable $th) {
            return response([
                'status' => false,
                'message' => $th->getMessage()
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
    public function show(RoomCategory $roomCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($roomCategory)
    {
        $data = RoomCategory::find($roomCategory);
        if ($data) {
            return response()->json([
                'status' => true,
                'data' => new RoomCategoryResource($data)
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Category not found.'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $roomCategory)
    {

        $rules = [
            "name" => [
                'required',
                'string',
                'max:255',
                // Rule::unique('room_categories')->where(function ($query) {
                //     return $query->where('hotel_id', $this->hotel_id);
                // })
            ],
            "hotel_id" => 'required|numeric',
            "status" => 'required|boolean'
        ];

        $validation= Validator::make($request->all(),$rules);
        if($validation->fails()){
                return response()->json([
                    'status' => false,
                    'message' => $validation->errors()->first(),
                    'errors' => $validation->errors()
                ], 422);
        }

        try {
            $data = RoomCategory::find($roomCategory);
            $data->name = $request->name;
            $data->hotel_id = $request->hotel_id;
            $data->status = $request->status;
            if ($data->save()) {
                return response([
                    'status' => true,
                    'message' => 'Category updated successfully.'
                ]);
            } else {
                return response([
                    'status' => false,
                    'message' => 'Something went wrong.!'
                ]);
            }
        } catch (\Throwable $th) {
            return response([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoomCategory $roomCategory)
    {
        //
    }
}
