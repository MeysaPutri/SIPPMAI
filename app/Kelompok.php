<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelompok extends Model
{
    protected $table= "kelompoks";
    protected $primaryKey = "id_kel";

    protected $fillable = [
        'nama_kel', 'id_periode'
    ];
}
