<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCodiceBarreToCopieTable extends Migration
{
    public function up()
    {
        Schema::table('copie', function (Blueprint $table) {
            $table->string('codice_barre')->unique()->after('id');
        });
    }

    public function down()
    {
        Schema::table('copie', function (Blueprint $table) {
            $table->dropColumn('codice_barre');
        });
    }
}
