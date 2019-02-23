<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChecklistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checklists', function (Blueprint $table) {
            $table->increments('object_id');
            $table->string("object_domain");
            $table->string("description");
            $table->boolean("is_completed")->default(0);
            $table->timestamp("due")->nullable();
            $table->integer("urgency")->nullable();
            $table->timestamp("completed_at")->nullable();
            $table->timestamp("last_update_by")->nullable();
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
        Schema::dropIfExists('checklists');
    }
}
