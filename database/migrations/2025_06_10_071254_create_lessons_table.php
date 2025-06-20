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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained()->cascadeOnDelete();
            $table->integer('order');  
            $table->string('title');      
            $table->string('slug');
            $table->text('summary')->nullable();
            $table->boolean('is_premium')->default(false);

            // Listening Section
            $table->string('listening_audio_path');  
            $table->text('listening_transcript')->nullable();   

            // Reading Section
            $table->text('reading_content');       
            $table->json('reading_vocabulary')->nullable();    

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
