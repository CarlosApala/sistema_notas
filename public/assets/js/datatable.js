$(document).ready( function () {
    $('#datatable').DataTable({
        language: {
            processing:     "Buscando resultados...",
            search:         "Buscar:",
            lengthMenu:     "Mostrar _MENU_ resultados",
            info:           "Mostrando elementos _START_ de  _END_ de _TOTAL_ resultados",
            infoEmpty:      "Mostrando elementos 0  de 0 resultados",
           
            loadingRecords: "Chargement en cours...",
            zeroRecords:    "No se encontraron resultados para tu busqueda",
            emptyTable:     "No hay resultados disponibles",
            paginate: {
                first:      "Primero",
                previous:   "Anterior",
                next:       "Siguiente",
                last:       "Ultimo"
            },
           
        }
    } )
});