<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users')) {

            Schema::table('users', function (Blueprint $table) {
                $table->text('social_id')->nullable();
                $table->boolean('is_student')->default(true);
                $table->boolean('is_instructor')->nullable();
                $table->boolean('is_admin')->nullable();
                $table->boolean('is_blogger')->nullable();
                $table->boolean('is_super_admin')->nullable();
                $table->text('profile_photo_path')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('two_factor_secret', 'two_factor_recovery_codes');
        });
    }
};