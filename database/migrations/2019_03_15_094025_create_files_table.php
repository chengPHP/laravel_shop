<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->comment('文件名');
            $table->string('old_name')->nullable()->comment('文件原始名称');
            $table->string('type')->nullable()->comment('文件类型');
            $table->integer('width')->nullable()->comment('宽');
            $table->integer('height')->nullable()->comment('高');
            $table->string('suffix')->nullable()->comment('文件后缀名');
            $table->string('file_path')->nullable()->comment('文件存储路径');
            $table->string('path')->nullable()->comment('文件所在路径');
            $table->string('size')->nullable()->comment('文件文件大小');
            $table->integer('user_id')->nullable()->comment('所属用户');
            $table->integer('upload_mode')->nullable()->comment('上传模式：file:文件上传image上传video视频上传');
            $table->string('url')->nullable()->comment('文件访问的url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
