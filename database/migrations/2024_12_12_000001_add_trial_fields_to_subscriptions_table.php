<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->boolean('is_trial')->default(false);
            $table->boolean('trial_converted')->default(false);
            $table->boolean('trial_expiring_sent')->default(false);
            $table->boolean('trial_expired_sent')->default(false);
        });
    }

    public function down()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn([
                'is_trial',
                'trial_converted',
                'trial_expiring_sent',
                'trial_expired_sent'
            ]);
        });
    }
}; 