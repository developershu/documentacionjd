@props (['documento'])

<div class="card mb-3 shadow-sm rounded">
    <div class="card-body">
        {{-- Encabezado con título y estado --}}
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="card-title mb-0 fs-6 text-truncate">
                {{ $documento->titulo }}
            </h5>
            @if (auth()->user()->hasRole('admin'))
                <span class="badge rounded-pill @if ($documento->estado === 'publicado') bg-success @else bg-secondary @endif">
                    {{ ucfirst($documento->estado) }}
                </span>
            @endif
        </div>

        {{-- Descripción del documento --}}
        <p class="card-text text-muted mb-3" style="font-size: 0.875rem;">
            {{ Str::limit($documento->descripcion, 100) }}
        </p>

        {{-- Grupo de botones de acción --}}
        <div class="d-grid gap-2">
            @if ($documento->link)
                <a href="{{ $documento->link }}" target="_blank"
                   class="btn btn-sm btn-light" style="background-color: #003764; color: white;">
                    <i class="fas fa-link me-2"></i>
                    Ver Enlace
                </a>
            @elseif ($documento->archivo)
                <a href="{{ asset('storage/' . $documento->archivo) }}" target="_blank"
                   class="btn btn-sm btn-light" style="background-color: #003764; color: white;">
                    <i class="fas fa-download me-2"></i>
                    Descargar
                </a>
            @endif
            <a href="{{ route('documentos.show', $documento) }}"
               class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-eye me-2"></i>
                Ver Detalles
            </a>
        </div>
    </div>
</div>
