<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'dodao_korisnik',
        'ime_prezime',
        'medij',
        'duznost',
        'vazi_do',
        'slika',
        'qr_kod',
        'ID_iskaznice',
    ];



}
