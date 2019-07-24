<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;


class CreateAnnouncementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->bigIncrements('id');
            //clave foránea *********
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            //*************
            //clave foránea *********
            $table->unsignedBigInteger('subcategory_id');
            $table->foreign('subcategory_id')->references('id')->on('subcategories');
            //*************
            $table->string("name")->nullable();
            $table->string("description")->nullable();
            $table->string("price")->nullable();
            $table->string("location")->nullable();
            $table->string("email")->nullable();
            $table->string("phone")->nullable();
            $table->string("contact_preferences")->nullable();
            $table->timestamps();
        });
        // Full Text Index
        DB::statement('ALTER TABLE announcements ADD FULLTEXT fulltext_index (description, name)');
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('announcements');
    }
}
