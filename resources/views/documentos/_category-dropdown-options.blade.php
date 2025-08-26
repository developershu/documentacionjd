@foreach ($categorias as $categoria)
    @if ($categoria->subcategorias->isEmpty())
        <!-- Carpeta sin subcarpetas -->
        <li>
            <a class="dropdown-item categoria-option"  
               href="#" 
               data-id="{{ $categoria->id }}">
               <i class="fas fa-folder text-warning me-2"></i>
               {{ $categoria->nombre }}
            </a>
        </li>
    @else
        <!-- Carpeta con subcarpetas -->
        <li class="dropdown-submenu" >
            <a class="dropdown-item dropdown-toggle" href="#">
                <i class="fas fa-folder-open text-warning me-2"></i>
                {{ $categoria->nombre }}
            </a>
            <ul class="dropdown-menu">
                @include('documentos._category-dropdown-options', [
                    'categorias' => $categoria->subcategorias
                ])
            </ul>
        </li>
    @endif
@endforeach
