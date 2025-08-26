
<!-- Modal para crear una nueva categoría (carpeta) -->
<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #003764; color: white;">
                <h5 class="modal-title" id="createCategoryModalLabel">Crear Nueva Carpeta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createCategoryForm" action="{{ route('categorias.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    {{-- Campo de entrada oculto para el ID de la categoría padre --}}
                    <input type="hidden" name="parent_id" id="parentIdInput" value="">
                    
                    <div class="mb-3">
                        <label for="nombre_categoria" class="form-label">Nombre de la Carpeta</label>
                        <input type="text" class="form-control" id="nombre_categoria" name="nombre_categoria" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-light" style="background-color: #003764; color: white;">
                        <i class="fas fa-folder-plus"></i> Crear
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script para pasar el parent_id al modal --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const createCategoryModal = document.getElementById('createCategoryModal');

    // Escucha el evento 'show.bs.modal' de Bootstrap, que se dispara justo antes de que se muestre el modal.
    createCategoryModal.addEventListener('show.bs.modal', function(event) {
        // Obtiene el botón que activó el modal.
        const button = event.relatedTarget;
        
        // Extrae el valor del atributo data-parent-id del botón. Si no existe, será null.
        const parentId = button.getAttribute('data-parent-id');
        
        // Obtiene el campo de entrada oculto dentro del modal.
        const parentIdInput = createCategoryModal.querySelector('#parentIdInput');
        
        // Asigna el valor del parentId extraído al campo de entrada oculto.
        parentIdInput.value = parentId;
        
        console.log(`Modal de categoría abierto. Parent ID: ${parentId || 'ninguno'}`);
    });
});
</script>
@endpush
