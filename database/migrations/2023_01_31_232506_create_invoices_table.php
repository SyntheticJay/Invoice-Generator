<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Enums\Invoice\InvoiceStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('customer_id')->constrained('customers');
            $table->boolean('is_public')->default(true);
            $table->enum('status', InvoiceStatus::getValues())->default(InvoiceStatus::AWAITING);
            $table->string('invoice_number');
            $table->string('reference')->unique();
            $table->date('invoice_date');
            $table->string('invoice_from');
            $table->integer('currency_id')->unsigned();
            $table->decimal('sub_value', 10, 2)->unsigned();
            $table->decimal('vat_value', 10, 2)->unsigned()->nullable();
            $table->decimal('total_value', 10, 2)->unsigned();
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('invoices');
    }
};
