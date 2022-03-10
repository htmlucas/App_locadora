<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    protected $fillable = ['nome','imagem'];

    public function regras(){
        return [
            'nome' => 'required|unique:marcas,nome,'.$this->id.'',
            'imagem' => 'required'
    
        ];
    }

    /*
    Unique tem 3 parametros
    
    1)tabela
    2)noime da coluna que sera pesquisado na tabela
    3)id do registro que sera desconsiderado na pesquisa

    */
    
    public function feedback(){
        return  [
            'required' => 'O campo :attribute é obrigatório',
            'nome.unique' => 'O nome da marca já existe'
        ];
    }
}


