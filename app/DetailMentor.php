<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailMentor extends Model
{
    protected $table= "detail_mentors";
    protected $primaryKey = "id_mentor";

    protected $fillable = [
        'id_kel', 'nim'
    ];
}
