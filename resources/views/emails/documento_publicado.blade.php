<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $titulo }}</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f9f9f9; padding: 20px;">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: auto; background: #ffffff; border-radius: 8px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
        <tr>
            <td style="padding: 20px;">
                <h2 style="color: #333;">¡Nuevo Documento/Enlace Publicado!</h2>
                <p>Hola,</p>
                <p>Se ha publicado un nuevo documento o enlace de interés.</p>
                <p><strong>Título:</strong> {{ $titulo }}</p>
                <p style="text-align: center; margin: 30px 0;">
                    <a href="{{ $enlace }}" style="background: #28a745; color: white; padding: 12px 20px; text-decoration: none; border-radius: 5px;">Ver Publicación</a>
                </p>
                <p>Gracias por usar el servicio.</p>
            </td>
        </tr>
    </table>
</body>
</html>