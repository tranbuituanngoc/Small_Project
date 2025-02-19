<?php

namespace App\Services\Hotel;

use App\Repositories\HotelRepository;
use App\Repositories\CityRepository;
use \Exception;

class HotelServiceImp implements HotelService
{
    protected $hotelRepository;
    protected $cityRepository;

    public function __construct(HotelRepository $hotelRepository, CityRepository $cityRepository)
    {
        $this->hotelRepository = $hotelRepository;
        $this->cityRepository = $cityRepository;
    }

    public function all()
    {
        $this->hotelRepository->all();
    }

    public function create($data)
    {
        if ($this->hotelRepository->findBy('name', $data['name'])) {
            throw new Exception('The hotel name already exists');
        }
        if ($this->hotelRepository->findBy('hotel_code', $data['hotel_code'])) {
            throw new Exception('The hotel code already exists');
        }
        $this->hotelRepository->create($data);
    }

    public function update($data, $id)
    {
        $hotel = $this->hotelRepository->find($id);

        if ($hotel) {
            if (
                $hotel->name !== $data['name']
                && $this->hotelRepository->findBy('name', $data['name'])
            ) {
                throw new Exception('The hotel name already exists');
            }
            if (
                $hotel->hotel_code !== $data['hotel_code']
                && $this->hotelRepository->findBy('hotel_code', $data['hotel_code'])
            ) {
                throw new Exception('The hotel code already exists');
            }
            $this->hotelRepository->update($data, $id);
        } else {
            throw new Exception('Hotel not found');
        }
    }

    public function delete($id)
    {
        $hotel = $this->hotelRepository->find($id);
        if ($hotel) {
            $this->hotelRepository->delete($id);
        } else {
            throw new Exception('Hotel not found');
        }
    }

    public function find($id)
    {
        $hotel = $this->hotelRepository->find($id);
        if ($hotel) {
            return $hotel;
        } else {
            throw new Exception('Hotel not found');
        }
    }

    public function paginate($perPage)
    {
        $this->hotelRepository->paginate($perPage);
    }

    public function search($cityId = null, $hotelCode = null, $hotelName = null)
    {
        $query = $this->hotelRepository->query();

        if ($cityId) {
            $city = $this->cityRepository->findBy('id', $cityId);
            if ($city) {
                $query->where('city_id', $city->id);
            } else {
                throw new Exception('City not found');
            }
        }

        if ($hotelCode) {
            $query->where('hotel_code', $hotelCode);
        }

        if ($hotelName) {
            $query->where('name', 'like', '%' . $hotelName . '%');
        }

        return $query->orderBy('city_id', 'asc');
    }

    public function searchForUser($userId, $cityId = null, $hotelCode = null, $hotelName = null)
    {
        $query = $this->hotelRepository->query()->where('user_id', $userId);

        if ($cityId) {
            $city = $this->cityRepository->findBy('id', $cityId);
            if ($city) {
                $query->where('city_id', $city->id);
            } else {
                throw new Exception('City not found');
            }
        }

        if ($hotelCode) {
            $query->where('hotel_code', $hotelCode);
        }

        if ($hotelName) {
            $query->where('name', 'like', '%' . $hotelName . '%');
        }

        return $query->orderBy('city_id', 'asc');
    }
}
