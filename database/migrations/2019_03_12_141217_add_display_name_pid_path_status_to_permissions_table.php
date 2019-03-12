<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDisplayNamePidPathStatusToPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('display_name')->nullable()->comment('权限别名');
            $table->tinyInteger('pid')->default(0)->comment('父级id');
            $table->string('path')->default("0,")->comment('祖级路径');
            $table->tinyInteger('status')->default(1)->comment('-1 |软删除 0 |禁用 1 |启用');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permissions', function (Blueprint $table) {
            //
        });
    }
}
