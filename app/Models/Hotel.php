<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\City;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hotel extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'hotel_code',
        'city_id',
        'user_id',
        'address1',
        'address2',
        'tel',
        'email',
        'fax',
        'company_name',
        'tax_code',
    ];

    protected $casts = [];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
