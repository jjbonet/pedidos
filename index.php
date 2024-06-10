<!DOCTYPE html>
<html lang="es">
          <!-- Este aplicacion web, fue creada como resolucion del TP2 del Seminario de Actualizacion
           en Sistemas colaborativos Docente. Ing. Sergio Daniel Conde - UES21 | A.U.S. JAVIER BONET  -->
<head>
    <meta charset="UTF-8">
    <title>BAR CAFE SXXI</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .order-item .form-group {
            margin-bottom: 0;
        }
        .order-item {
            margin-bottom: 10px;
        }
        .modal-footer {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">BAR CAFE SXXI - Gestión de Pedidos</h1>
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Pedido Nro.</th>
                    <th>Fecha</th>
                    <th>Detalle</th>
                </tr>
            </thead>
            <tbody id="orderHistory">
                <!-- Aquí se cargarán los pedidos -->
            </tbody>
        </table>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#orderModal">Agregar Pedido</button>
    </div>

    <!-- Modal para agregar pedido -->
    <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderModalLabel">CARGAR PEDIDO NUEVO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="orderForm">
                        <div id="orderItems">
                            <div class="order-item row">
                                <div class="form-group col-md-6">
                                    <label for="id_articulo">Artículo:</label>
                                    <select class="form-control item-id" name="id_articulo[]">
                                        <option value="" selected disabled>Seleccione un artículo</option>
                                        <!-- Los artículos se cargarán aquí -->
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="cantidad">Cantidad:</label>
                                    <input type="number" class="form-control cantidad" name="cantidad[]" min="1" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="total">Total:</label>
                                    <input type="text" class="form-control total" name="total[]" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="addItem" class="btn btn-secondary">Agregar Otro Artículo</button>
                            <div class="button-group">
                                <button type="submit" class="btn btn-primary btn-block">Generar Pedido</button>
                                <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Cancelar</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        Seminario de Actualización en Sistemas Colaborativos - Docente: ING. Sergio Daniel Conde | Alumno AUS Javier Bonet - UES21
    </footer>


    <script>
        //esta funcion se encarga de cargar los items en el select
        $(document).ready(function() {
            function loadItems() {
                $.ajax({
                    url: 'obtener_item.php',
                    method: 'GET',
                    success: function(data) {
                        $('.item-id').append(data);
                    }
                });
            }

            loadItems();
//a continuacion se definen los eventos para los elementos del modal
            $(document).on('change', '.item-id', function() {
                let parent = $(this).closest('.order-item');
                let itemId = $(this).val();
                if (itemId) {
                    $.ajax({
                        url: 'obtener_precio.php',
                        method: 'GET',
                        data: { id: itemId },
                        success: function(data) {
                            let precio = data;
                            parent.data('precio', precio);
                            updateTotal(parent);
                        }
                    });
                }
            });

            $(document).on('input', '.cantidad', function() {
                let parent = $(this).closest('.order-item');
                updateTotal(parent);
            });

            $('#addItem').click(function() {
                let newItem = $('.order-item:first').clone();
                newItem.find('input').val('');
                newItem.find('.item-id').val('');
                newItem.find('.total').val('');
                $('#orderItems').append(newItem);
            });

            function updateTotal(parent) {
                let cantidad = parent.find('.cantidad').val();
                let precio = parent.data('precio') || 0;
                let total = cantidad * precio;
                parent.find('.total').val(total.toFixed(2));
            }

            function calculateOverallTotal() {
                let overallTotal = 0;
                $('.order-item').each(function() {
                    let total = $(this).find('.total').val();
                    overallTotal += parseFloat(total) || 0;
                });
                $('#overallTotal').text(overallTotal.toFixed(2));
            }

            function loadOrderHistory() {
                $.ajax({
                    url: 'obtener_orden.php',
                    method: 'GET',
                    success: function(data) {
                        $('#orderHistory').html(data);
                    }
                });
            }

            loadOrderHistory();

            $('#orderForm').submit(function(event) {
                event.preventDefault();
                calculateOverallTotal(); // asegura que el total general se calcule correctamente
                var formData = $(this).serialize();
                $.ajax({
                    url: 'agregar_orden.php',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#orderModal').modal('hide');
                        $('#orderForm')[0].reset();
                        $('#orderItems').html($('.order-item:first').clone());
                        loadOrderHistory();
                    }
                });
            });

            // Limpiar el formulario al cerrar el modal
            $('#orderModal').on('hidden.bs.modal', function () {
                $('#orderForm')[0].reset();
                $('#orderItems').html($('.order-item:first').clone());
                loadItems();
            });
        });
    </script>
</body>
</html>
