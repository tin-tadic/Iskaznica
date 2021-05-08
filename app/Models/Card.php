<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    protected $fillable = [
        'dodao_korisnik',
        'ime_prezime',
        'medij',
        'duznost',
        'vazi_do',
        'slika',
        'qr_kod'
    ];



}
