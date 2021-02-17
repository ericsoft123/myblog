<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogpostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogposts', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->index('uid'); //unique id of post
            $table->string('userid')->index('userid'); //user who create this post
            $table->string('title')->index('title')->default("none");
            $table->longtext('content')->nullable();
          

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
        Schema::dropIfExists('blogposts');
    }
}
