<div class="container mt-5">
    <h2 class="mb-4">Añadir / Editar Empresa</h2>
    <form action="/oficina/index.php" method="POST">
        <input type="hidden" name="rowid" value="<?php echo isset($empresa) ? $empresa['rowid'] : ''; ?>">

        <div class="mb-3">
            <label for="razon" class="form-label">Razón Social</label>
            <input type="text" class="form-control" id="razon" name="razon" required value="<?php echo isset($empresa) ? $empresa['razon'] : ''; ?>">
        </div>

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required value="<?php echo isset($empresa) ? $empresa['nombre'] : ''; ?>">
        </div>

        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion" required value="<?php echo isset($empresa) ? $empresa['direccion'] : ''; ?>">
        </div>
        <div class="mb-3">
            <label for="direccion" class="form-label">Código Postal</label>
            <input type="text" class="form-control" id="cp" name="cp" required value="<?php echo isset($empresa) ? $empresa['cp'] : ''; ?>">
        </div>
        <div class="mb-3">
            <label for="direccion" class="form-label">Población</label>
            <input type="text" class="form-control" id="pobla" name="pobla" required value="<?php echo isset($empresa) ? $empresa['pobla'] : ''; ?>">
        </div>
        <div class="mb-3">
            <label for="direccion" class="form-label">Província</label>
            <input type="text" class="form-control" id="provi" name="provi" required value="<?php echo isset($empresa) ? $empresa['provi'] : ''; ?>">
        </div>

        <div class="mb-3">
            <label for="tel" class="form-label">Teléfono</label>
            <input type="tel" class="form-control" id="tel" name="tel" required value="<?php echo isset($empresa) ? $empresa['tel'] : ''; ?>">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required value="<?php echo isset($empresa) ? $empresa['email'] : ''; ?>">
        </div>

        <div class="mb-3">
            <label for="web" class="form-label">Página Web</label>
            <input type="url" class="form-control" id="web" name="web" required value="<?php echo isset($empresa) ? $empresa['web'] : ''; ?>">
        </div>

        <div class="mb-3">
            <label for="iva" class="form-label">IVA (%)</label>
            <select class="form-select" id="iva" name="iva" required>
                <option></option>
                <option value="1" <?php if (isset($empresa) && $empresa['iva'] == 1) {
                                        echo 'selected';
                                    } else {
                                        echo '';
                                    } ?>>si</option>
                <option value="2" <?php if (isset($empresa) && $empresa['iva'] == 2) {
                                        echo 'selected';
                                    } else {
                                        echo '';
                                    } ?>>no</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="irpf" class="form-label">IRPF (%)</label>
            <select class="form-select" id="irpf" name="irpf" required>
                <option></option>
                <option value="1" 
                    <?php 
                        if (isset($empresa) && $empresa['irpf'] == 1) {
                            echo 'selected';
                        } else {
                            echo '';
                        } 
                    ?>
                >
                    si
                </option>
                <option value="2" 
                    <?php 
                        if (isset($empresa) && $empresa['irpf'] == 2) {
                            echo 'selected';
                        } else {
                            echo '';
                        }
                    ?>
                >
                    no
                </option>
            </select>
        </div>

        <div class="mb-3">
            <label for="cif" class="form-label">CIF</label>
            <input type="text" class="form-control" id="cif" name="cif" required value="<?php echo isset($empresa) ? $empresa['cif'] : ''; ?>">
        </div>
        <?php
        if (isset($empresa)) {
            echo '<input type="hidden" class="form-control" name="action" value="EDIT_EMPRESA" />';
        } else {
            echo '<input type="hidden" class="form-control" name="action" value="ADD_EMPRESA" />';
        }
        ?>

        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>