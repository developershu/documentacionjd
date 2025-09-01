<?php



namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DocumentoPublicadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $titulo;
    public $enlace;

    public function __construct($titulo, $enlace)
    {
        $this->titulo = $titulo;
        $this->enlace = $enlace;
    }

    public function build()
    {
        return $this->subject('¡Nuevo Documento/Enlace Publicado!')
                    ->view('emails.documento_publicado');
    }
}
