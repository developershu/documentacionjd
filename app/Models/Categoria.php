<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Documento;

class Categoria extends Model
{
    
    protected $fillable = ['nombre', 'parent_id'];

    public function documentos()
    {
        return $this->hasMany(Documento::class);
    }

    public function parent()
    {
        return $this->belongsTo(Categoria::class, 'parent_id');
    }

    public function subcategorias()
    {
        return $this->hasMany(Categoria::class, 'parent_id');
    }

    
}