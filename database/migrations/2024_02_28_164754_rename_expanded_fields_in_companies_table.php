<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->renameColumn('expandedTitle', 'expanded_title');
            $table->renameColumn('expandedDescription', 'expanded_description');
        });
    }

    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->renameColumn('expanded_title', 'expandedTitle');
            $table->renameColumn('expanded_description', 'expandedDescription');
        });
    }
};
