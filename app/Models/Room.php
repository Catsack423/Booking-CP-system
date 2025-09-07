<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $table = "room";
    protected $primaryKey = "id";
    public $incrementing = false;
    public $timestamp = true;


    public function request()
    {
        return $this->hasOne(Request::class, 'room_id', 'id');
    }
}
