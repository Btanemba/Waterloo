<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('readings', function (Blueprint $table) {
            $table->id();

            // Foreign key to meter_number
            $table->string('meter_number'); 
            $table->foreign('meter_number')
                ->references('meter_number')
                ->on('meters')
                ->onDelete('cascade'); 

            $table->float('reading_value'); // Reading in m³
            $table->string('photo')->nullable(); 
            $table->integer('reading_year'); 
            $table->integer('reading_month'); 
            $table->integer('reading_day'); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('readings');
    }
};
