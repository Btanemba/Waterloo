<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meters', function (Blueprint $table) {
            $table->id();
            $table->string('meter_number');
            $table->string('address');
            $table->string('postCode');
            $table->unsignedBigInteger('customers_id'); // Define the foreign key column
            $table->timestamps();

            // Add the foreign key constraint
            $table->foreign('customers_id')
                  ->references('id') // Reference the 'id' column of the 'customers' table
                  ->on('customers')
                  ->onDelete('cascade'); // Optional: deletes related meters when a customer is deleted
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meters');
    }
};
