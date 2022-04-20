<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCharsToWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('words', function (Blueprint $table) {
            $table->char('c01', 1)->nullable()->after('word');
            $table->char('c02', 1)->nullable()->after('c01');
            $table->char('c03', 1)->nullable()->after('c02');
            $table->char('c04', 1)->nullable()->after('c03');
            $table->char('c05', 1)->nullable()->after('c04');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('words', function (Blueprint $table) {
            $table->dropColumn('c01');
            $table->dropColumn('c02');
            $table->dropColumn('c03');
            $table->dropColumn('c04');
            $table->dropColumn('c05');
        });
    }
}
