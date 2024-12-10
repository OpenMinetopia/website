<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('instances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('hostname')->unique();
            $table->enum('status', ['pending', 'active', 'suspended', 'removed'])->default('pending');
            $table->string('deployment_status')->default('uncompleted');
            $table->string('plugin_api_token', 128)->nullable();
            $table->string('instance_api_token', 128)->nullable();
            $table->string('version')->default('1.0.0');
            $table->string('suspension_reason')->nullable();
            $table->boolean('has_set_api_tokens')->default(false);
            $table->boolean('is_beta')->default(false);
            $table->boolean('is_paid')->default(false);
            $table->boolean('dns_verified')->default(false);
            $table->timestamp('last_deployment_at')->nullable();
            $table->timestamp('suspended_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('instances');
    }
};
