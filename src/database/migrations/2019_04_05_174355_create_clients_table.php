<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('cnpj')->nullable();
            $table->string('public_key')->unique();
            $table->string('secret_key')->unique();
            $table->timestamp('start_access')->useCurrent();
            $table->timestamp('end_access')->nullable();
            $table->integer('limit_access')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('client_access', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ip');
            $table->string('host');
            $table->unsignedInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_access');
        Schema::dropIfExists('clients');
    }
}
