<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NetworkTrx extends Model
{
    use HasFactory, SoftDeletes;

    public function network()
    {
        return $this->belongsTo(Network::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function today()
    {
        return $this->whereYear('updated_at', date('Y'))->whereMonth('updated_at', date('m'))->whereDay('updated_at', date('d'))->get();
    }
}
