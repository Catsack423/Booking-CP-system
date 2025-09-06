<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('request', function (Blueprint $table) {
            
            $table->id();
            $table ->date('day');
            $table->boolean('wait_status')->default(false);
            $table->boolean("approve_status")->default(false);
            $table->boolean("reject_status")->default(false);
            $table->string("room_id");
            $table->string("user_id");
            $table->string("frist_name",200);
            $table->string("last_name",200);
            $table->string("detail",1000);
            $table->string("phone",20);
            $table->boolean("8_9_slot")->default(false);
            $table->boolean("9_10_slot")->default(false);
            $table->boolean("10_11_slot")->default(false);
            $table->boolean("11_12_slot")->default(false);
            $table->boolean("12_13_slot")->default(false);
            $table->boolean("13_14_slot")->default(false);
            $table->boolean("14_15_slot")->default(false);
            $table->boolean("15_16_slot")->default(false);
            $table->boolean("16_17_slot")->default(false);
            $table->boolean("17_18_slot")->default(false);
            $table->boolean("18_19_slot")->default(false);
            $table->timestamps();
            $table->softDeletes();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('request', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::dropIfExists('request');
    }
};
