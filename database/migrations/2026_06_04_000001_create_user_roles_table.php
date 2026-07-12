<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    
        Schema::create('user_roles', function (Blueprint $table) {
            $table->integer('role_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')->on('users');
            $table->foreign('role_id')
                ->references('id')->on('roles');
        });


    }

    public function down(): void
    {
        Schema::dropIfExists('user_roles');
    }
};
