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
        Schema::create('researches', function (Blueprint $table) {
            $table->id();
            $table->string('project_name');
            $table->string('members');
            $table->text('abstract');
            $table->string('document');
            $table->string('department');
            $table->foreignId('user_id')->constrained();  // Assuming the research is associated with a user
            $table->boolean('approved')->default(false); // Add the 'approved' field
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('researches', function (Blueprint $table) {
            //
        });
    }
};
