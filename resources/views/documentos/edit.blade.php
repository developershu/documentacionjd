@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card shadow">
            <div class="card-header" style="background-color: #003764; color: white;">
                <h3 class="mb-0">Editar Documento</h3>
            </div>

            <div class="card-body bg-light">
                <form action="{{ route('documentos.update', $documento) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título <span class="text-danger">*</span></label>
                        <input type="text" name="titulo" id="titulo"
                            class="form-control @error('titulo') is-invalid @enderror"
                            value="{{ old('titulo', $documento->titulo) }}" required>
                        @error('titulo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea name="descripcion" id="descripcion" rows="3"
                            class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $documento->descripcion) }}</textarea>
                        @error('descripcion')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="categoria_id" class="form-label">Carpeta <span class="text-danger">*</span></label>
                        <select name="categoria_id" id="categoria_id" class="form-control" required>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}"
                                    {{ old('categoria_id', $documento->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="archivo" class="form-label">Archivo (Opcional)</label>
                        <input type="file" class="form-control" id="archivo" name="archivo" accept=".pdf,.docx,.pptx">
                        @error('archivo')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="form-text text-muted">
                            Tamaño máximo: 10MB (PDF, DOCX, PPTX)
                        </small>
                    </div>

                    <div class="mb-3">
                        <label for="link" class="form-label">Link (Opcional)</label>
                        <input type="url" class="form-control" id="link" name="link" value="{{ old('link', $documento->link) }}">
                        @error('link')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="estado">Estado</label>
                        <select name="estado" id="estado" class="form-control" required>
                            <option value="borrador" {{ $documento->estado === 'borrador' ? 'selected' : '' }}>Borrador</option>
                            <option value="publicado" {{ $documento->estado === 'publicado' ? 'selected' : '' }}>Publicado</option>
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
