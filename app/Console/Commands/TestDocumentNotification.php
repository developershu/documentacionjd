<?php

namespace App\Console\Commands;

use App\Models\Documento;
use App\Models\User;
use App\Notifications\NewDocumentNotification;
use Illuminate\Console\Command;

class TestDocumentNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:test-document';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía una notificación de documento de prueba a un usuario.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Encuentra un usuario para enviar la notificación
        // Nota: Asegúrate de que exista al menos un usuario en tu base de datos
        $user = User::first();

        // Si no se encuentra un usuario, muestra un mensaje de error
        if (!$user) {
            $this->error('No se encontró ningún usuario para enviar la notificación de prueba.');
            return Command::FAILURE;
        }

        // Crea un documento de prueba para la notificación
        $documento = new Documento([
            'titulo' => 'Documento de Prueba para Notificación',
            'descripcion' => 'Este es un documento de prueba creado para verificar el envío de notificaciones por correo.',
            'created_at' => now(),
        ]);

        // Envía la notificación al usuario
        $user->notify(new NewDocumentNotification($documento));

        $this->info('Notificación de documento de prueba enviada exitosamente a ' . $user->email);

        // Indica al usuario que revise su bandeja de entrada de Mailtrap
        $this->warn('Por favor, revisa tu bandeja de entrada de Mailtrap para ver el correo.');

        return Command::SUCCESS;
    }
}
