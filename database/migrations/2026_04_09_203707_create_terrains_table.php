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
        Schema::create('terrains', function (Blueprint $table) {
            $table->id();

            $table->string('name'); 
            $table->string('adress'); 

            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            
            $table->decimal('price', 8, 2);

            $table->time('opening_time'); 
            $table->time('closing_time'); 

            $table->string('image')->nullable();

            $table->boolean('is_active')->default(true);

            $table->foreignId('manager_id')->constrained('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terrains');
    }
};
