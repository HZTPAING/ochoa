<div class="container-fluid p-2" style="margin-left:2rem;">
    <div class="row">
        <div class="col-lg-12 p-2 align-item-center">
            <h2>Gestor de tareas</h2>
        </div>
        <div class="col-lg-4 p-2">
            <h5>El formulario de los presupuestos</h5>
        </div>
        <div class="col-lg-8 p-2">
            <h5>La lista de los presupuestos</h5>
        </div>
        <div class="col-lg-4 p-2">
            <div class="form-control">
                <label>Número</label>
                <input class="form-control" type="text" id="idNumeroPresup" name="numeroPresup" />
                <label>Nombre</label>
                <input class="form-control" type="text" id="idNombrePresup" name="nombrePresup" />
                <label>fecha</label>
                <input class="form-control" type="date" id="idFechaPresup" name="fechaPresup" />
                <label>fecha entrega:</label>
                <input class="form-control" type="date" id="idFecha_entregaPresup" name="fecha_entregaPresup" />
                <label>Empleado</label>
                <input class="form-control" type="text" id="idEmpleadoPresup" name="empleadoPresup" />
                <legend>Contacto/Cliente</legend>
                <select class="form-select" id="idUserPresup" name="userPresup">
                    <option></option>
                    <option value="47">Toni Domenech</option>
                </select>
                <input type="hidden" id="idActionPresup" name="action" value="INS_PRESUP" />
                <button class="btn btn-primary" id="idAddPresup" data-btn-edit-presup="INS">GUARDAR</button>
                <button class="btn btn-danger" id="idResetPresup">RESET</button>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="form-control" id="idPresupDivTable" style="max-height: 450px; overflow-y: auto;">
                <table class="table table-dark" id="idPresupTable">
                    <thead>
                        <tr>
                            <th>Numero</th>
                            <th>Nombre</th>
                            <th>Fecha</th>
                            <th>Fecha Entrega</th>
                            <th>Empleado</th>
                            <th>Contacto/Cliente</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="idPresupTbody">
                        <?php
                        // Rellenamos la tabla
                        if (isset($datosPresupuestos)) {
                            foreach ($datosPresupuestos as $datoPresup) {
                                $htmlPresupTabla =
                                    '<tr
                                            class="table-row-presup"
                                            onclick="selectRowPresup(this)"
                                            onmouseover="this.classList.add(\'hovered\')" 
                                            onmouseout="this.classList.remove(\'hovered\')"
                                            data-row-id="' . $datoPresup['rowid'] . '"
                                            data-presup-numero="' . $datoPresup['numero'] . '"
                                            data-presup-nombre="' . $datoPresup['nombre'] . '"
                                            data-presup-fecha="' . $datoPresup['fecha'] . '"
                                            data-presup-fecha_entrega="' . $datoPresup['fecha_entrega'] . '"
                                            data-presup-empleado="' . $datoPresup['empleado'] . '"
                                            data-presup-user="' . $datoPresup['idUser'] . '"
                                            data-edit-presup=""
                                        >
                                            <td class="td-selected">' . $datoPresup['numero'] . '</td>
                                            <td class="td-selected">' . $datoPresup['nombre'] . '</td>
                                            <td class="td-selected">' . $utils->convertirFecha($datoPresup['fecha']) . '</td>
                                            <td class="td-selected">' . $utils->convertirFecha($datoPresup['fecha_entrega']) . '</td>
                                            <td class="td-selected">' . $datoPresup['empleado'] . '</td>
                                            <td class="td-selected">' . $datoPresup['user'] . '</td>
                                            <td class="td-selected">
                                                <a 
                                                    class="btn btn-sm btn-secondary" 
                                                    href="#" 
                                                    onclick="createPdfPresup(this.closest(\'tr\'))"
                                                >
                                                    <i class="fa-solid fa-file-pdf"></i>
                                                </a>
                                            </td>
                                            <td class="td-selected">
                                                <a 
                                                    class="btn btn-sm btn-primary" 
                                                    href="#" 
                                                    onclick="enviarMailPdfPresup(this.closest(\'tr\'))"
                                                >
                                                    <i class="fa-solid fa-envelope"></i>
                                                </a>
                                            </td>
                                            <td class="td-selected">
                                                <a 
                                                    class="btn btn-sm btn-success" 
                                                    href="#" 
                                                    onclick="setEditPresup(this.closest(\'tr\'))"
                                                >
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>
                                            </td>
                                            <td class="td-selected">
                                                <a 
                                                    class="btn btn-sm btn-danger" 
                                                    href="#" 
                                                    onclick="deletePresup(this.closest(\'tr\'))"
                                                >
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    ';
                                echo $htmlPresupTabla;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <form class="container-fluid">
                <div class="row">
                    <div class="col-lg-1">
                        <label>Unidades:</label>
                    </div>
                    <div class="col-lg-2">
                        <label>Producto/Servicio</label>
                    </div>
                    <div class="col-lg-3">
                        <label>Detalle</label>
                    </div>
                    <div class="col-lg-1">
                        <label>Pre/Uni</lable>
                    </div>
                    <div class="col-lg-2">
                        <label>IVA</lable>
                    </div>
                    <div class="col-lg-1">
                        <lable>Total</label>
                    </div>
                    <div class="col-lg-1">
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-1">
                        <input class="form-control" type="number" name="uni" />
                    </div>
                    <div class="col-lg-2">
                        <select class="form-select" name="tipo">
                            <option></option>
                            <option value="1">Producto</option>
                            <option value="2">Servicio</option>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" name="dte" />
                    </div>
                    <div class="col-lg-1">
                        <input type="number" name="preu" class="form-control">
                    </div>
                    <div class="col-lg-2">
                        <select class="form-select" name="iva">
                            <option></option>
                            <option value="21">21%</option>
                        </select>
                    </div>
                    <div class="col-lg-1">
                        <input class="form-control" type="number" value="" />
                    </div>
                    <div class="col-lg-1">
                        <!-- <input class="btn btn-primary" type="submit" value="AGREGAR" /> -->
                        <input type="hidden" id="idActionPresupDetails" name="action_details" value="INS_PRESUP_DETAILS" />
                        <button class="btn btn-primary" id="idAddPresupDetails" data-btn-edit-presup-details="INS" disabled>AGREGAR</button>
                    </div>
                </div>
            </form>
            <table class="table table-striped table-hover table-dark" id="idPresupDetallesTable">
                <thead>
                    <tr>
                        <th>Unidades</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Precio Uni.</th>
                        <th>Impuesto</th>
                        <th>Total</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="idPresupDetallesTbody">

                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <fom class="form-control" entype="multipart/form-data">
                <h5>Adjuntar fichros al presupuesto</h5>
                <input type="file" name="fichero" />
                <input class="btn btn-primary" type="sumbit" value="SUBIRE" />
            </fom>
        </div>
        <div class="col-lg-6">
            <h5>Listado de archivos</h5>
            <table>
                <thead>
                    <tr>
                        <th>nombre</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>




<script>
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');
    let drawing = false;
    let startX, startY;
    let isLine = false;
    let isEraser = false;
    let textInput = '';

    // Iniciar el dibujo
    canvas.addEventListener('mousedown', (e) => {
        drawing = true;
        [startX, startY] = [e.offsetX, e.offsetY];
        if (isLine) {
            drawLine(startX, startY, e.offsetX, e.offsetY);
        }
    });

    // Finalizar el dibujo
    canvas.addEventListener('mouseup', () => {
        drawing = false;
        ctx.beginPath();
    });

    // Dibujar en el canvas
    canvas.addEventListener('mousemove', (e) => {
        if (!drawing) return;

        if (isEraser) {
            ctx.clearRect(e.offsetX, e.offsetY, 10, 10);
        } else {
            ctx.lineWidth = document.getElementById('grosor').value;
            ctx.strokeStyle = document.getElementById('color').value;
            ctx.lineCap = 'round';
            ctx.lineTo(e.offsetX, e.offsetY);
            ctx.stroke();
            ctx.beginPath();
            ctx.moveTo(e.offsetX, e.offsetY);
        }
    });

    // Borrar todo el canvas
    document.getElementById('clear').addEventListener('click', () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    });

    // Usar goma
    document.getElementById('eraser').addEventListener('click', () => {
        isEraser = !isEraser;
        document.getElementById('eraser').classList.toggle('active');
    });

    // Dibujar líneas rectas
    document.getElementById('line').addEventListener('click', () => {
        isLine = true;
        canvas.addEventListener('mouseup', (e) => {
            if (isLine) {
                drawLine(startX, startY, e.offsetX, e.offsetY);
                isLine = false;
            }
        });
    });

    // Añadir texto
    document.getElementById('text').addEventListener('click', () => {
        textInput = prompt('Introduce el texto:');
        if (textInput) {
            ctx.font = '20px Arial';
            ctx.fillStyle = document.getElementById('color').value;
            ctx.fillText(textInput, startX, startY);
        }
    });

    function drawLine(x1, y1, x2, y2) {
        ctx.beginPath();
        ctx.moveTo(x1, y1);
        ctx.lineTo(x2, y2);
        ctx.strokeStyle = document.getElementById('color').value;
        ctx.lineWidth = document.getElementById('grosor').value;
        ctx.stroke();
        ctx.closePath();
    }
</script>