<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bienes', function (Blueprint $table) {
            $table->string('hash_unico', 64)->unique()->nullable()->after('eliminado_el');
        });
    }

    public function down(): void
    {
        Schema::table('bienes', function (Blueprint $table) {
            $table->dropColumn('hash_unico');
        });
    }
};
