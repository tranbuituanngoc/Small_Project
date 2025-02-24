<?php

namespace App\Http\Controllers;

use App\Http\Requests\HotelRequest;
use App\Services\Hotel\HotelService;
use App\Services\City\CityService;
use App\Constant\UserRole;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Exceptions\MessageException;

class HotelController extends Controller
{
    protected $cityService;
    protected $hotelService;
    protected $adminRole;


    public function __construct(CityService $cityService, HotelService $hotelService)
    {
        $this->cityService = $cityService;
        $this->hotelService = $hotelService;
        $this->adminRole = UserRole::ADMIN;
    }

    public function index(Request $request)
    {
        $perPage = config('app.per_page');

        $user = Auth::user();
        $hotels = [];

        if ($user->role && $user->role->name === $this->adminRole) {
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

        $cities = $this->cityService->all();

        return view('hotel.index', compact('hotels', 'cities'));
    }

    public function create()
    {
        $cities = $this->cityService->all();

        return view('hotel.create', compact('cities'));
    }

    public function store(HotelRequest $request)
    {
        try {
            $data = $request->validated();
            $data['user_id'] = Auth::id();
            $this->hotelService->create($data);
            return redirect()->route('hotel.index')
                ->with('success', __('messages.hotel_created_successfully'));
        } catch (MessageException $e) {
            return redirect()->route('hotel.create')
                ->with('error', $e->getMessage());
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('hotel.create')
                ->with('error', __('messages.hotel_create_error'));
        }
    }

    public function show($id)
    {
        $hotel = $this->hotelService->find($id);

        return view('hotel.view', compact('hotel'));
    }



    public function edit($id)
    {
        $hotel = $this->hotelService->find($id);
        $cities = $this->cityService->all();

        return view('hotel.edit', compact('hotel', 'cities'));
    }

    public function update(HotelRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $this->hotelService->update($data, $id);

            return redirect()->route('hotel.index')
                ->with('success', __('messages.hotel_updated_successfully'));
        } catch (MessageException $e) {
            return redirect()->route('hotel.edit', $id)
                ->with('error', $e->getMessage());
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('hotel.edit', $id)
                ->with('error', __('messages.hotel_update_error'));
        }
    }

    public function destroy($id)
    {
        try {
            $this->hotelService->delete($id);

            return redirect()->route('hotel.index')
                ->with('success', __('messages.hotel_deleted_successfully'));
        } catch (MessageException $e) {
            return redirect()->route('hotel.index')
                ->with('error', $e->getMessage());
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('hotel.index')
                ->with('error', __('messages.hotel_delete_error'));
        }
    }
}
