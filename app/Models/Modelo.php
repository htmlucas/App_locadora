<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    use HasFactory;

    protected $fillable = ['marca_id', 'nome', 'imagem', 'numero_portas', 'lugares', 'air_bag', 'abs'];

    public function rules() {
        return [
            'marca_id' => 'exists:marcas,id',
            'nome' => 'required|unique:modelos,nome,'.$this->id.'|min:3',
            'imagem' => 'required|file|mimes:png',
            'numero_portas' => 'required|integer|digits_between:1,5', //(1,2,3,4,5)
            'lugares' => 'required|integer|digits_between:1,20',
            'air_bag' => 'required|boolean',
            'abs' => 'required|boolean' //true, false, 1, 0, "1", "0"
        ];
    }
    public function feedback() {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'imagem.mimes' => 'O arquivo deve ser uma imagem do tipo PNG',
            'nome.unique' => 'O nome da marca já existe',
            'nome.min' => 'O nome deve ter no mínimo 3 caracteres',
            'numero_portas.digits_between' => 'O número de portas deve ter no mínimo 1 e no máximo 5',
            'numero_portas.integer' => 'O número de portas deve ser um numero inteiro',
            'lugares.digits_between' => 'O número de lugares deve ter no mínimo 1 e no máximo 20',
            'lugares.integer' => 'O número de lugares deve ser um numero inteiro',
            'air_bag.boolean' => 'Erro no envio do valor de AIR BAGS',
            'abs.boolean' => 'Erro no envio do valor de AIR ABS',
        ];
    }

    public function marca() {
        //UM modelo PERTENCE a UMA marca
        return $this->belongsTo('App\Models\Marca');
    }
}
