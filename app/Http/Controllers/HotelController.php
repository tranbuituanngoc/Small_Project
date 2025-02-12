<?php

namespace App\Http\Controllers;

use App\Http\Requests\HotelRequest;
use App\Http\Requests\UserRequest;
use App\Repositories\CityRepository;
use App\Services\Hotel\HotelService;
use App\Models\Hotel;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    protected $cityRepository;
    protected $hotelService;

    public function __construct(CityRepository $cityRepository, HotelService $hotelService)
    {
        $this->cityRepository = $cityRepository;
        $this->hotelService = $hotelService;
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user->role && $user->role->name === 'Admin') {
            $hotels = Hotel::all();
        } else {
            $hotels = $user->hotels;
        }

        $hotels = Hotel::all();
        $cities = $this->cityRepository->all();

        return view('hotel.index', compact('hotels', 'cities'));
    }

    public function create()
    {
        $cities = $this->cityRepository->all();

        return view('hotel.create', compact('cities'));
    }

    public function store(HotelRequest $request)
    {
        try {
            $data = $request->validated();
            $this->hotelService->create($data);

            return redirect()->route('hotels.index')->with('success', 'Hotel created successfully.');
        } catch (Exception $e) {
            return redirect()->route('hotels.create')->with('error', 'An error occurred while creating the hotel.');
        }
    }
}
