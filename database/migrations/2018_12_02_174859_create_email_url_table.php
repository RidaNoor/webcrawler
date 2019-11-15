<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailUrlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_url', function (Blueprint $table) {
            $table->unsignedinteger('email_id');
            $table->unsignedinteger('url_id');
            $table->timestamps();
            $table->primary(['email_id','url_id']);
            $table->foreign('email_id')->references('id')->on('emails')->onDelete('cascade');
            $table->foreign('url_id')->references('id')->on('urls')->onDelete('cascade');
        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::dropIfExists('email_url');
    }
}
