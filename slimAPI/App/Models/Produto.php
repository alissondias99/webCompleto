<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model{

    protected $fillable = [
        'fabricante',
        'preco',
        'descricao',
        'titulo',
        'updated_at',
        'created_at'
    ];
}