<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('quiz_answers', function (Blueprint $table) {
            $table->foreignId('quiz_attempt_id')
                ->after('user_id')
                ->constrained('quiz_attempts')
                ->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::table('quiz_answers', function (Blueprint $table) {
            $table->dropForeign(['quiz_attempt_id']);
            $table->dropColumn('quiz_attempt_id');
        });
    }
};
