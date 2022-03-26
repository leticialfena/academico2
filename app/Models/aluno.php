<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class aluno extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getFaltas($mes){
        if ($this->exists) {
            $faltas = \App\Models\falta::where('id_aluno',$this->attributes['id'])->where('mes',$mes)->first();  
            //dd($faltas);
            if($faltas) {
                return $faltas->faltas;
            } else return 0;
        } else return 0;
    }
}
