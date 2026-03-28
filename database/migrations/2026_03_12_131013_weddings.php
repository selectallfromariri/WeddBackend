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
        Schema::create('weddings', function(Blueprint $table){
                $table->id();
                $table->string('wedding_code')->unique();
                $table->foreignId('wedder_id')->constrained('users')->onDelete('cascade');
                $table->string('bride_name')->nullable();
                $table->string('groom_name')->nullable();
                $table->date('date');
                $table->string('venue');
                $table->string('cover_photo')->nullable();
                $table->boolean('is_published')->default(false);
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weddings');
    }
};