<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ploi_settings', function (Blueprint $table) {
            $table->id();
            $table->longText('api_token')->nullable();
            $table->unsignedBigInteger('default_server_id')->nullable();
            $table->string('repository_url')->default('https://github.com/OpenMinetopia/portal.git');
            $table->string('repository_branch')->default('main');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ploi_settings');
    }
};
