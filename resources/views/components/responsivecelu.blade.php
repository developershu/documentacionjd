@props (['documento'])

<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">{{ $documento->titulo }}</h5>
        @can('viewAny', App\Models\Documento::class)
        <p><strong>Estado:</strong>
            <span class="badge bg-{{ $documento->estado === 'publicado' ? 'success' : 'warning' }}">
                {{ ucfirst($documento->estado) }}
            </span>
        </p>
        <p><strong>Autor:</strong> {{ $documento->user->name }}</p>
        @endcan
        <p><strong>Fecha:</strong> {{ $documento->created_at->format('d/m/Y') }}</p>
        <div class="d-flex gap-2 mt-2">
            <a href="{{ route('documentos.show', $documento) }}" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-eye"></i>
            </a>
            @can('update', $documento)
            <a href="{{ route('documentos.edit', $documento) }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-edit"></i>
            </a>
            @endcan
            @can('delete', $documento)
            <form action="{{ route('documentos.destroy', $documento) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger"
                    onclick="return confirm('¿Eliminar este documento?')">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
            @endcan
        </div>
    </div>
</div>