<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('research_documents', function (Blueprint $table) {
            $table->string('banner_image')->nullable()->after('file_path');
        });
    }

    public function down(): void
    {
        Schema::table('research_documents', function (Blueprint $table) {
            $table->dropColumn('banner_image');
        });
    }
};
