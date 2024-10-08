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
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('cedula');
            $table->string('nombre');
            $table->timestamps();
        });

        DB::table('customers')->insert([
            ['nombre' => 'Juan Perez'],
            ['nombre' => 'Maria Lopez'],
            ['nombre' => 'Carlos Diaz']
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
