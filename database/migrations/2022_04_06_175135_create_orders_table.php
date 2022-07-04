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
        Schema::create('orders', function (Blueprint $table) {

            $table->id();
            $table->foreignId('customer_id')->constrained();
            $table->foreignId('address_id')->nullable()->constrained();

            $table->datetime('date')->default(date('Y-m-d H:i:s'));
            
            $table->double('subtotal');

            $table->double('cost')->nullable();
            $table->double('total');
            $table->double('difference')->nullable();

            $table->tinyInteger('status')->default(0); //, [0=>'Agendado', 1=>'En proceso', 2=>'Entregado', 3=>'Pagado',4=>'Completado', 5=> 'Pausado', 6=> 'Reagendado', 7 => 'Anulado', 8 => 'Otro']);
            $table->tinyInteger('sale_type')->default(0); //,[0 =>'seller', 1 => 'online', 2 => 'special'])->default('seller');// 1 por ejecutivo, 2 online, 3  cliente especial


            // PAGO
            $table->tinyInteger('payment_status')->default(0); // [ 0 => 'pendiente', 1 => 'abonado', 2=> 'pagado', 3=> 'other'])->nullable(); 
            $table->tinyInteger('payment_account')->nullable(); //[0 => 'Efectivo', 1=> 'Transferencia ', 2=>'Efectivo y transferencia', 3=> 'Otro'])->nullable(); //Cuenta de pago
            $table->text('payment_account_comment')->nullable();
            $table->integer('payment_amount')->default(0);
            $table->integer('pending_amount')->nullable();
            $table->dateTime('payment_date')->nullable();
            $table->foreignId('user_id_paid')->nullable()->constrained('users');

            // DELIVERY
            $table->boolean('delivery')->default(false);
            $table->boolean('delivery_stage')->default(false);// etapa de entrega  0= por entregar\n1= entregado
            $table->integer('delivery_value')->nullable();
            $table->date('delivery_date')->nullable();
            $table->dateTime('date_delivered')->nullable();
            $table->foreignId('user_id_delivered')->nullable()->constrained('users');
            
            
            // FACTURA
            $table->boolean('is_invoice_delivered')->default(false); //boleta entregada
            $table->dateTime('invoice_delivered_date')->nullable();// fecha de boleta entregada
            $table->foreignId('user_id_invoice_delivered')->nullable()->constrained('users');//boleta entregada por
            
            
            $table->text('comment')->nullable();
            
            $table->foreignId('user_id_created')->constrained('users');
            $table->foreignId('user_id_modified')->nullable()->constrained('users');

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
};
