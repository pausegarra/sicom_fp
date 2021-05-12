<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('customer_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->string('work_reference')->nullable();
            $table->foreignId('payment_method_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('payment_term_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->string('carrier');
            $table->string('vat');
            $table->string('howRecieveInvoice');
            $table->string('notes')->nullable();
            $table->string('price_notes')->nullable();
            $table->string('erp_id')->nullable()->default(null);
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
        Schema::dropIfExists('orders');
    }
}
