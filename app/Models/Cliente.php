<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = ['id','nome'];

    public function rules() {
        return [
            'nome' => 'required|unique:clientes,nome'
        ];
    }

    public function feedback() {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'nome.unique' => 'O nome já existe',
        ];
    }
    
    public function locacao(){
        return $this->belongsTo('App\Models\Locacao');
    }
}
