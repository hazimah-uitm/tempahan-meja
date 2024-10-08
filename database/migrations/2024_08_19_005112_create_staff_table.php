<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('no_pekerja');
            $table->string('email')->nullable();
            $table->enum('attendance', ['Hadir', 'Tidak Hadir']);
            $table->enum('category', ['Staf Akademik', 'Staf Pentadbiran'])->nullable();
            $table->string('department')->nullable();
            $table->string('campus')->nullable();
            $table->enum('club', ['Ahli KEKiTA', 'Ahli PEWANI', 'Bukan Ahli  (Bayaran RM20 dikenakan)'])->nullable();
            $table->string('payment')->nullable();
            $table->enum('type', ['Staf', 'Bukan Staf']);
            $table->enum('status', ['Belum Tempah', 'Selesai Tempah'])->default('Belum Tempah');
            $table->softDeletes();
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
        Schema::dropIfExists('staff');
    }
}
