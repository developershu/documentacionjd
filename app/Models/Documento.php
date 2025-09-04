<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categoria;


class Documento extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'archivo',
        'estado',
        'link',
        'user_id',
        'categoria_id',
        'notificar_usuarios',
        'comentarios_habilitados'
    ];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i',
        'updated_at' => 'datetime:d/m/Y H:i',
        'comentarios_habilitados' => 'boolean',
        'notificar_usuarios' => 'boolean',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    // Relación con el usuario que creó el documento
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con los comentarios
    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    // Scope para documentos publicados
   public function scopePublicados($query)
{
    return $query->where('estado', 'publicado');
}

    // Método para obtener la extensión del archivo
    public function getExtensionAttribute()
    {
        return pathinfo($this->archivo, PATHINFO_EXTENSION);
    }

    // Método para obtener el tipo de documento
    public function getTipoDocumentoAttribute()
    {
        $extension = strtolower($this->extension);
        
        $tipos = [
            'pdf' => 'PDF',
            'docx' => 'Word',
            'pptx' => 'PowerPoint',
            'doc' => 'Word',
            'ppt' => 'PowerPoint',
            
        ];

        return $tipos[$extension] ?? strtoupper($extension);
    }
}