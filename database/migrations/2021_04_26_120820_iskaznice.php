<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Iskaznice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dodao_korisnik');
            $table->foreign('dodao_korisnik')->references('id')->on('users');
            $table->string('ime_prezime');
            $table->string('medij');
            $table->string('duznost');
            $table->date('vazi_do');
            $table->string('slika');
            $table->string('qr_kod');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
