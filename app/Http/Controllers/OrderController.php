<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'rooms' => 'required|array',
            'rooms.*.id' => 'required|numeric',
            'remark' => 'nullable|string|max:255',
            'from' => 'required|date',
            'to' => 'required|date',
        ];

        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()->first(),
                'errors' => $validation->errors()
            ], 422);
        }


        foreach($request->rooms as $rooms){
            $ck_room =  Room::find($rooms['id']);
            if(!$ck_room){
                return response()->json([
                    'status'=>false,
                    'message'=>'Room not found.'
                ],404);
            }

        }
        dd($request->all(),auth()->user()->job_type);
        $order = new Order();
        $order->user_id= auth()->id();
        $order->from= $request->from;
        $order->to= $request->to;
        $order->remark= $request->remark;







    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
