
        <!--
        <script src="/assects/js/script_dynamicConfirmModal.js"></script>
        <script src="/assects/js/script.js"></script>
        <script src="/assects/js/script_presup.js"></script>
        <script src="/assects/js/rol.js"></script>
        -->
        
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

        <section id="idFooter">

        </section>

    <!-- Modal de confirmación -->
    <div 
        class="modal fade" 
        id="dynamicConfirmModal" 
        tabindex="-1" 
        aria-labelledby="dynamicConfirmModalLabel" 
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 
                        class="modal-title"
                        id="dynamicConfirmModalLabel"
                        style="color: white;"
                    >
                        Confirmar borrado
                    </h5>
                    <button 
                        type="button" 
                        class="btn-close" 
                        data-bs-dismiss="modal" 
                        aria-label="Close"
                    ></button>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    ¿Estás seguro de que deseas realizar esta acción?
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button 
                        type="button" 
                        class="btn btn-secondary" 
                        data-bs-dismiss="modal" 
                        id="cancelBtn"
                    >
                        Cancelar
                    </button>
                    <button 
                        type="button" 
                        class="btn btn-danger" 
                        id="confirmBtn"
                    >
                        Borrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    </body>

</html>