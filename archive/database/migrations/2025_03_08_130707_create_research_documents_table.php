<?php
// app/Database/migrations/*_create_research_documents_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResearchDocumentsTable extends Migration
{
    public function up()
    {
        Schema::create('research_documents', function (Blueprint $table) {
            $table->id();
            $table->string('project_name');
            $table->string('members');
            $table->text('abstract');
            $table->string('file_path')->nullable();
            $table->string('department')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('research_documents');
    }
}
