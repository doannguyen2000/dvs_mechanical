<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_types', function (Blueprint $table) {
            $table->id();
            $table->string('product_type_name');
            $table->string('product_type_code')->unique();
            $table->string('product_type_symbol');
            $table->string('product_type_description');
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('product_code')->unique();
            $table->decimal('product_price', 50, 2)->nullable();
            $table->decimal('product_sale', 3, 2)->nullable();
            $table->string('product_description')->nullable();
            $table->boolean('product_status')->default(true)->nullable();
            $table->string('product_type_code')->nullable();
            $table->foreign('product_type_code')->references('product_type_code')->on('product_types')->onUpdate('cascade')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('material_name');
            $table->string('material_code')->unique();
            $table->decimal('material_price', 8, 2)->nullable();
            $table->string('material_description')->nullable();
            $table->boolean('material_status')->default(true)->nullable();
            $table->timestamps();
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_name');
            $table->string('invoice_code')->unique();
            $table->string('invoice_description')->nullable();
            $table->boolean('invoice_status')->default(true)->nullable();
            $table->timestamps();
        });

        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('unit_name');
            $table->string('unit_code')->unique();
            $table->boolean('unit_status')->default(true)->nullable();
            $table->timestamps();
        });

        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            $table->string('product_code');
            $table->string('material_code');
            $table->string('unit_code');
            $table->integer('material_quantity')->nullable();
            $table->foreign('product_code')->references('product_code')->on('products')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('material_code')->references('material_code')->on('materials')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('unit_code')->references('unit_code')->on('units')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();
            $table->string('product_code');
            $table->string('invoice_code');
            $table->foreign('product_code')->references('product_code')->on('products')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('invoice_code')->references('invoice_code')->on('invoices')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('quantity_product')->default(0)->nullable();
            $table->decimal('total_price', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_details');
        Schema::dropIfExists('product_details');
        Schema::dropIfExists('units');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('materials');
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_types');
    }
};
