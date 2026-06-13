<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->foreignId('groupe_id')
                ->nullable()
                ->after('enseignant_id')
                ->constrained('groupes')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->dropConstrainedForeignId('groupe_id');
        });
    }
};
