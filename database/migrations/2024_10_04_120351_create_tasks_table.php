<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id'); // Reference to the projects table
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('status', ['todo', 'in-progress', 'done']);
            $table->timestamps();
            
            // Set up the foreign key constraint
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
