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
        Schema::create('logo_icons', function (Blueprint $table) {
            $table->id();
            $table->string('icon_title');
            $table->string('icon_type'); // 1=logo, 2=icon
            $table->string('icon_tag');
            $table->string('icon_location')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logo_icons');
    }
};
