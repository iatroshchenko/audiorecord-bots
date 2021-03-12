<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\{Record, Tag};

class CreateRecordTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('record_id')
                ->references('id')
                ->on(Record::getTableNameStatic())
                ->onDelete('cascade');

            $table->foreignId('tag_id')
                ->references('id')
                ->on(Tag::getTableNameStatic())
                ->onDelete('cascade');

            $table->unique([
                'record_id',
                'tag_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('record_tag');
    }
}
