<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Card extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $fillable = [
        'created_by',
        'updated_by',
        'deleted_by',
        'ime_prezime',
        'medij',
        'duznost',
        'vazi_do',
        'slika',
        'qr_kod',
        'ID_iskaznice',
    ];



}
