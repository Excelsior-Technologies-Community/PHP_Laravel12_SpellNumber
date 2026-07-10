<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('conversions');

        Schema::create('conversions', function (Blueprint $table) {
            $table->id();
            $table->decimal('number', 15, 2);
            $table->string('words', 500);
            $table->string('locale', 10)->default('en');
            $table->string('mode', 20)->default('plain');
            $table->string('currency', 10)->nullable();
            $table->boolean('is_favorite')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversions');
    }
};