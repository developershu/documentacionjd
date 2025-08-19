@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>{{ $documento->titulo }}</h2>
                    @if (auth()->user()->hasRole('admin'))
                        <span class="badge badge-{{ $documento->estado === 'publicado' ? 'success' : 'secondary' }}">
                            {{ ucfirst($documento->estado) }}
                        </span>
                    @endif
                </div>





                <div class="mb-4">
                    <p class="lead">{{ $documento->descripcion }}</p>


                    @if ($documento->archivo && Storage::disk('public')->exists($documento->archivo))
                        <a href="{{ asset('storage/' . $documento->archivo) }}" target="_blank" class="btn btn-outline-success"
                            style="background-color: #003764 ; color: white;">
                            <i class="fas fa-download"></i> Descargar Documento
                        </a>
                    @endif



                    @if ($documento->link)
                        <a href="{{ $documento->link }}" target="_blank">{{ $documento->link }}</a>
                    @endif



                </div>

                <hr>

                <h3 class="mb-3">Comentarios</h3>

                @forelse($documento->comentarios as $comentario)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title">{{ $comentario->usuario->name }}</h5>
                                <small class="text-muted">
                                    {{ $comentario->created_at->diffForHumans() }}
                                </small>
                            </div>
                            <p class="card-text">{{ $comentario->contenido }}</p>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info">
                        No hay comentarios aún.
                    </div>
                @endforelse

                @auth
                    <div class="mt-4">
                        <h3>Agregar Comentario</h3>
                        <form id="comentario-form" action="{{ route('comentarios.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="documento_id" value="{{ $documento->id }}">

                            <div class="mb-3">
                                <textarea name="contenido" class="form-control" rows="3" required placeholder="Escribe tu comentario aquí..."></textarea>
                                @error('contenido')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-light" style="background-color: #003764 ; color: white;">
                                <i class="fas fa-paper-plane"></i> Enviar Comentario
                            </button>
                        </form>
                    </div>
                @else
                    <div class="alert alert-info">
                        <a href="{{ route('login') }}" class="alert-link">Inicia sesión</a> para poder comentar.
                    </div>
                @endauth
            </div>
        </div>
    </div>
@endsection
