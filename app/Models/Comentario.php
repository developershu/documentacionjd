<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $fillable = [
        'contenido',
        'documento_id',
        'user_id'
    ];

    // Relación con el documento
    public function documento()
    {
        return $this->belongsTo(Documento::class);
    }

    // Relación con el usuario que hizo el comentario
    public function usuario()
{
    return $this->belongsTo(User::class, 'user_id')->withDefault([
        'name' => 'Usuario eliminado' // Valor por defecto si el usuario no existe
    ]);
}
}

