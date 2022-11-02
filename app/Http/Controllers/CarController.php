<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Car;
use App\Models\User;

class CarController extends Controller
{
    /**
     * Get my car
     */
    public function my(Request $request) {
        if ($request->user()->car === null) {
            return ['info' => 'You don\'t have a car assigned to you'];
        }

        return $request->user()->car;
    }

    /**
     * Change user car, for admin only
     */
    public function change(Request $request) {
        if ($request->user()->name !== 'admin') {
            return response()->json(['error' => '403 not allowed'], 403);
        }

        if (empty($request->input('car_id'))) {
            return response()->json(['error' => 'car_id is missing'], 400);
        }

        if (empty($request->input('user_id'))) {
            return response()->json(['error' => 'user_id is missing'], 400);
        }

        $car = Car::find($request->input('car_id'));
        $user = User::find($request->input('user_id'));

        if ($car === null) {
            return response()->json(['error' => 'not found car with id ' . $request->input('car_id')], 404);
        }

        if ($user === null) {
            return response()->json(['error' => 'not found user with id ' . $request->input('user_id')], 404);
        }

        if ($user->car !== null) {
            $user->car->user_id = null;
            $user->car->save();
        }

        $car->user_id = $user->id;
        $car->save();

        return ['info' => 'successfull change'];
    }

    /**
     * Cancel using car by user
     */
    public function cancel(Request $request) {
        $user = $request->user();

        if ($user->car !== null) {
            $user->car->user_id = null;
            $user->car->save();
        }

        return ['info' => 'car is cancelled'];
    }

    /**
     * Booking car by user
     */
    public function book(Request $request) {
        if (empty($request->input('car_id'))) {
            return response()->json(['error' => 'car_id is missing'], 400);
        }

        $car = Car::find($request->input('car_id'));

        if ($car === null) {
            return response()->json(['error' => 'not found car with id ' . $request->input('car_id')], 404);
        }

        if ($car->user_id !== null) {
            return response()->json(['error' => 'car with id ' . $request->input('car_id') . ' already booked'], 403);
        }

        $user = $request->user();

        if ($user->car !== null) {
            $user->car->user_id = null;
            $user->car->save();
        }

        $car->user_id = $user->id;
        $car->save();

        return ['info' => 'car is booked'];
    }

    /**
     * Get free cars
     */
    public function free(Request $request) {
        return Car::where('user_id', null)->get();
    }

    /**
     * Get all cars
     */
    public function all(Request $request) {
        return Car::all();
    }
}

