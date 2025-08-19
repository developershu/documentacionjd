<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Documento;

class Categoria extends Model
{
    // ...
    protected $fillable = ['nombre'];

    public function documentos()
    {
        return $this->hasMany(Documento::class);
    }
}