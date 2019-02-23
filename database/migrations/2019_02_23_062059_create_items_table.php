<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("checklist_id")->unsigned();
            $table->string("name")->nullable();
            $table->string("description");
            $table->boolean("is_completed")->default(0);
            $table->timestamp("due")->nullable();
            $table->integer("urgency")->nullable();
            $table->timestamp("completed_at")->nullable();
            $table->timestamp("last_update_by")->nullable();
            $table->timestamps();

            if( Schema::hasTable('checklists') ) {
                $table->foreign("checklist_id")->references('object_id')->on('checklists')
                ->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
