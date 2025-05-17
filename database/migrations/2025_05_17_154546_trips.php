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
        //
        Schema::create('trips', function (Blueprint $table){
            $table->id();
            $table->string('destination');
            $table->string('passenger');
            $table->date('start_date');
            $table->date('end_date');
            // trip code, destination, start date, end date, passenger
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
