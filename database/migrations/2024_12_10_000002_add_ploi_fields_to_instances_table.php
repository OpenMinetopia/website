<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('instances', function (Blueprint $table) {
            $table->unsignedBigInteger('ploi_server_id')->nullable();
            $table->unsignedBigInteger('ploi_site_id')->nullable();
            $table->string('ploi_database_name')->nullable();
            $table->string('ploi_database_user')->nullable();
            $table->text('ploi_database_password')->nullable();
            $table->boolean('ploi_ssl_enabled')->default(false);
            $table->enum('ploi_deployment_status', [
                'pending',
                'creating_site',
                'creating_database',
                'configuring_env',
                'installing_repository',
                'requesting_ssl',
                'deploying',
                'completed',
                'failed'
            ])->default('pending');
            $table->text('ploi_deployment_error')->nullable();
        });
    }

    public function down()
    {
        Schema::table('instances', function (Blueprint $table) {
            $table->dropColumn([
                'ploi_server_id',
                'ploi_site_id',
                'ploi_database_name',
                'ploi_database_user',
                'ploi_database_password',
                'ploi_ssl_enabled',
                'ploi_deployment_status',
                'ploi_deployment_error'
            ]);
        });
    }
}; 