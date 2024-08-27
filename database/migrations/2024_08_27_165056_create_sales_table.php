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
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('codigo');
            $table->unsignedInteger('cedula');
            $table->decimal('total', 8, 2);
            $table->timestamps();

            $table->foreign('codigo')->references('codigo')->on('products');
            $table->foreign('cedula')->references('cedula')->on('customers');
        });

        DB::table('sales')->insert([
            ['codigo' => 1, 'cedula' => 1, 'total' => 1500.00],
            ['codigo' => 2, 'cedula' => 2, 'total' => 20.00],
            ['codigo' => 3, 'cedula' => 1, 'total' => 45.00]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
