<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMigrationsForPlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('file_size_limit');
            $table->boolean('advertising_free')->nullable();
            $table->boolean('files_kept_forever')->nullable();
            $table->boolean('pairing')->nullable();
            $table->boolean('prioritized_speed');

            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('subscription_id')->nullable();
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->integer('plan_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('subscription_id');
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn('plan_id');
        });
    }
}
