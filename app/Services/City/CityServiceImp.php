<?php

namespace App\Services\City;

use App\Repositories\CityRepository;

class CityServiceImp implements CityService
{
    protected $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function all()
    {
        return  $this->cityRepository->all();
    }
}
