<li class="dropdown-item @if (!$categoria->subcategorias->isEmpty()) dropdown-submenu @endif">
    <a class="dropdown-item @if (!$categoria->subcategorias->isEmpty()) dropdown-toggle @endif" href="#" data-id="{{ $categoria->id }}">
        <i class="fas fa-folder me-2 text-warning"></i>
        {{ $categoria->nombre }}
    </a>
    @if (!$categoria->subcategorias->isEmpty())
        <ul class="dropdown-menu">
            @foreach ($categoria->subcategorias as $subcategoria)
                @include('documentos._category-dropdown-item', ['categoria' => $subcategoria])
            @endforeach
        </ul>
    @endif
</li>