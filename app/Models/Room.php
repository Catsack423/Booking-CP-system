<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $table = 'room';
    protected $primaryKey = "id";
    public $incrementing = false;
    public $timestamp = true;
    protected $fillable = [
        'day',
        'status',
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


    public function requests()
    {
        return $this->hasOne(Request::class, 'room_id', 'id');
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

    public function checkstatus(): void
    {
        $this->status = true;
        foreach (Room::slots() as $key) {
            if ($this->$key == false) {
                $this->status = false;
                $this->save();
                return;
            }
        }
        return;
    }


    public function checkslot($requests): void
    {
            foreach ($requests as $request) {
                foreach (Room::slots() as $key) {
                    if ($request->$key == 1) {
                        $this->$key = $request->$key;
                    }
                }
            }
        $this->save();
        return;
    }


    public function resetslot():void{
        foreach(Room::slots() as $key){
            $this->$key = false;
        }
        $this->status = false;
        $this->save();
        return;
    }


}
