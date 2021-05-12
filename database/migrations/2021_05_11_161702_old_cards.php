<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OldCards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('old_cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dodao_korisnik');
            $table->foreign('dodao_korisnik')->references('id')->on('users');
            $table->string('ime_prezime');
            $table->string('medij');
            $table->string('duznost');
            $table->date('vazi_do');
            $table->string('slika');
            $table->date('izbrisano');
            $table->unsignedBigInteger('izbrisao_korisnik');
            $table->foreign('izbrisao_korisnik')->references('id')->on('users');
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
