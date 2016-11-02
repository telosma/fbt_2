<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reviews', function ($table) {
            $table->tinyInteger('rated_food')->nullable()->default(null);
            $table->tinyInteger('rated_place')->nullable()->default(null);
            $table->tinyInteger('rated_service')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reviews', function ($table) {
            $table->dropColumn([
                'rated_food',
                'rated_place',
                'rated_service',
            ]);
        });
    }
}
