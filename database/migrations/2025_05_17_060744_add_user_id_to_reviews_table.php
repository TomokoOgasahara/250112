<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToReviewsTable extends Migration
{
    public function up()
    {
        Schema::table('review', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
        });
    }

    public function down()
    {
        Schema::table('review', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
};
