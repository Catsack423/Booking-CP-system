<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;
    protected $table = "request";
    protected $primaryKey = "id";

    protected $fillable = [
        'day',
        'wait_status',
        'approve_status',
        'reject_status',
        'room_id',
        'user_id',
        'first_name',
        'last_name',
        'detail',
        'phone',
        '8_9_slot',
        '9_10_slot',
        '10_11_slot',
        '11_12_slot',
        '12_13_slot',
        '13_14_slot',
        '14_15_slot',
        '15_16_slot',
        '16_17_slot',
        '17_18_slot',
        '18_19_slot',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function slots(): array
    {
        return [
            '8_9_slot',
            '9_10_slot',
            '10_11_slot',
            '11_12_slot',
            '12_13_slot',
            '13_14_slot',
            '14_15_slot',
            '15_16_slot',
            '16_17_slot',
            '17_18_slot',
            '18_19_slot',
        ];
    }


}
