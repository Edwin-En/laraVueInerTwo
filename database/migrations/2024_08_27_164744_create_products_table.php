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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('codigo');
            $table->string('descripcion');
            $table->integer('stock');
            $table->decimal('precio_unitario', 8, 2);
            $table->timestamps();
        });

        DB::table('products')->insert([
            ['descripcion' => 'Laptop', 'stock' => 50, 'precio_unitario' => 1500.00],
            ['descripcion' => 'Mouse', 'stock' => 200, 'precio_unitario' => 20.00],
            ['descripcion' => 'Teclado', 'stock' => 150, 'precio_unitario' => 45.00]
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
