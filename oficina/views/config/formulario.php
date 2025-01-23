<section class="container">
    <!-- Zona 1: Menu dublicado con botones de coregir, lista y formulario de los items del menú principal -->
    <div class="row mb-5">
      <!-- Lista de los items del menú principal -->
      <div class="col-lg-2">
        <?php
          $objMenu = new Menu();
          echo $objMenu->menuOf;
        ?>
      </div>
      <div id="idListaMenu" class="col-lg-6">
        <div class="p-3 border rounded">
          <h2>La lista de los items del menú principal</h2>
          <?php
            echo $objMenu->lista_items;
          ?>
        </div>
      </div>
      <!-- Formulario de añadir/editar el item del menú principal -->
      <div class="col-lg-4">
        <div id="idItemsAdd" class="p-3 border rounded mb-3">
          <h3>
            <?php
              echo $objMenu->titulo_form_item;
            ?>
          </h3>
          <?php
            echo $objMenu->form_item;
          ?>
        </div>
      </div>
    </div>

    <!-- Zona 2: Lista y formulario de los items del submenú -->
    <div class="row">
      <!-- Lista de los items del submenú -->
      <div id="idListaSubmenu" class="col-lg-8">
        <div class="p-3 border rounded">
          <h2>La lista de los items del submenú</h2>
          <?php
            echo $objMenu->lista_sub_items;
          ?>
        </div>
      </div>
      <!-- Formulario de añadir/editar el subItem del menú principal -->
      <div class="col-lg-4">
        <div id="idSubItemsAdd" class="p-3 border rounded mb-3">
          <h3>
            <?php
              echo $objMenu->titulo_form_sub_item;
            ?>
          </h3>
          <?php
            echo $objMenu->form_subitem;
          ?>
        </div>
      </div>
    </div>
  </section>

<script>

</script>