<?php

namespace App\Services\Hotel;

interface HotelService
{
    public function all();
    public function create(array $data);
    public function update(array $data, $id);
    public function delete($id);
    public function find($id);
    public function paginate($perPage);
}
