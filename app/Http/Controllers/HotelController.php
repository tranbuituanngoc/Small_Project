<?php

namespace App\Http\Controllers;

use App\Http\Requests\HotelRequest;
use App\Http\Requests\UserRequest;
use App\Repositories\CityRepository;
use App\Services\Hotel\HotelService;
use App\Models\Hotel;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        $perPage = config('app.per_page');

        $user = Auth::user();
        $hotels = [];

        if ($user->role && $user->role->name === 'Admin') {
            $hotels = $this->hotelService->search(
                $request->input('cityId'),
                $request->input('hotelCode'),
                $request->input('hotelName')
            )->paginate($perPage);
        } else {
            $hotels = $this->hotelService->searchForUser(
                $user->id,
                $request->input('cityId'),
                $request->input('hotelCode'),
                $request->input('hotelName')
            )->paginate($perPage);
        }

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
            $data['user_id'] = Auth::id();
            $this->hotelService->create($data);

            return redirect()->route('hotel.index');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('hotel.create');
        }
    }

    public function view($id)
    {
        $hotel = $this->hotelService->find($id);

        return view('hotel.view', compact('hotel'));
    }

    public function edit($id)
    {
        $hotel = $this->hotelService->find($id);
        $cities = $this->cityRepository->all();

        return view('hotel.edit', compact('hotel', 'cities'));
    }

    public function update(HotelRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $this->hotelService->update($data, $id);

            return redirect()->route('hotel.index');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('hotel.edit', $id);
        }
    }

    public function destroy($id)
    {
        try {
            $this->hotelService->delete($id);

            return redirect()->route('hotel.index');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('hotel.index');
        }
    }
}
