@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card shadow">
            <div class="card-body">
                <h1 class="mb-4">Editar Documento</h1>

                <form action="{{ route('documentos.update', $documento) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="titulo">Título del Documento</label>
                        <input type="text" name="titulo" id="titulo"
                            class="form-control @error('titulo') is-invalid @enderror"
                            value="{{ old('titulo', $documento->titulo) }}" required>
                        @error('titulo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea name="descripcion" id="descripcion" rows="3"
                            class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $documento->descripcion) }}</textarea>
                        @error('descripcion')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Archivo Actual</label>
                        <div class="mb-2">
                            <a href="{{ asset('storage/' . $documento->archivo) }}" target="_blank">
                                {{ basename($documento->archivo) }}
                            </a>
                        </div>
                        <label for="archivo">Reemplazar Archivo (opcional)</label>
                        <input type="file" name="archivo" id="archivo"
                            class="form-control-file @error('archivo') is-invalid @enderror">
                        @error('archivo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="form-text text-muted">
                            Tamaño máximo: 10MB (PDF, DOCX, PPTX)
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select name="estado" id="estado" class="form-control" required>
                            <option value="borrador" {{ $documento->estado === 'borrador' ? 'selected' : '' }}>Borrador
                            </option>
                            <option value="publicado" {{ $documento->estado === 'publicado' ? 'selected' : '' }}>Publicado
                            </option>
                        </select>
                    </div>


                    

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('documentos.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-light" style="background-color: #003764; color: white;">
                            <i class="fas fa-save"></i> Actualizar Documento
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
