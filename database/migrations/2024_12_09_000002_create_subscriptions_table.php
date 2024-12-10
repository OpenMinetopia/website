<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instance_id')->constrained()->onDelete('cascade');
            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->decimal('amount', 10, 2);
            $table->enum('duration', ['1_month', '3_months', '6_months', '12_months']);
            $table->enum('status', ['pending', 'paid', 'failed'])->default('pending');
            $table->enum('payment_method', ['bank_transfer', 'paypal']);
            $table->boolean('renewal_7_days_sent')->default(false);
            $table->boolean('renewal_2_days_sent')->default(false);
            $table->boolean('renewal_today_sent')->default(false);
            $table->timestamp('renewed_at')->nullable();
            $table->string('renewal_status')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
};
