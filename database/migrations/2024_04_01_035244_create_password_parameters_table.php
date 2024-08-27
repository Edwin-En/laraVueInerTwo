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
        Schema::create('password_parameters', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('length');
            $table->boolean('uppercase')->default(true);
            $table->boolean('lowercase')->default(true);
            $table->boolean('digits')->default(true);
            $table->boolean('special_characters')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('password_parameters');
    }
};
