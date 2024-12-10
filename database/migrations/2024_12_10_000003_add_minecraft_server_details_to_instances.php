<?php

namespace Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('instances', function (Blueprint $table) {
            $table->string('minecraft_server_host')->nullable()->after('hostname');
            $table->string('minecraft_plugin_ip')->nullable()->after('minecraft_server_host');
        });
    }

    public function down()
    {
        Schema::table('instances', function (Blueprint $table) {
            $table->dropColumn(['minecraft_server_host', 'minecraft_plugin_ip']);
        });
    }
}; 