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
        Schema::create('room', function (Blueprint $table) {
            
            $table->string('id')->primary();
            $table ->date('day');
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('room');
    }
};
