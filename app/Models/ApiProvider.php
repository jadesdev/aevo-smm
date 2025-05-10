<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiProvider extends Model
{
    use HasFactory;

    public function services()
    {
        return $this->hasMany(Service::class, 'api_provider_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'api_provider_id');
    }
}
