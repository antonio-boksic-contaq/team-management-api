<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['email','email_verified_at','remember_token','password']);
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->enum('gender', ['M','F','N']);
            $table->foreignId('team_id')->references('id')->on('teams');
            $table->softDeletes();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
