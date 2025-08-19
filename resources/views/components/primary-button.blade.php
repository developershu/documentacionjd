<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => '
        
        /* Estilos base */
        inline-flex items-center px-4 py-2
        border border-transparent rounded-md
        font-semibold text-xs uppercase tracking-widest
        transition ease-in-out duration-150

        /* Colores de Texto Fondo */
        bg-fondo text-white
        dark:bg-fondo dark:text-white

         /* Colores al pasar el cursor */
        hover:bg-secundario
        dark:hover:bg-secundario

       /* Colores al enfocar */
        focus:bg-white focus:text-white focus:outline-none focus:ring-2 focus:ring-secundario focus:ring-offset-2
        dark:focus:bg-fondo
        dark:focus:ring-offset-secundario
        
       /* Colores al hacer clic */
        active:bg-fondo
        dark:active:bg-fondo
    '
]) }}>
    {{ $slot }}
</button>