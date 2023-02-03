<div class="modal fade text-left w-100" id="modal_detalle_formulario" style="overflow:hidden;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #004A98; color:#fff;">
                <h4 class="modal-title white" id="myModalLabel16">
                    <div id="titulo">Detalles de el Reconocimiento</div>
                </h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 mx-auto" id="imagen">
                        <img src="<?= url_base(); ?>/archivos/imagenes/qr.png" alt="" width="250px">
                    </div>
                    <div class="col-md-4 ">
                        <b>Nombre Completo:</b>
                        <p style="margin-right: 10px;" id="nombre1" name="nombre1">Pedro Pedoro Zanchez Maruchines</p>
                        <b>Tipo Participación:</b>
                        <p style="margin-right: 10px;" id="costo" name="costo">PONENTE</p>
                    </div>
                    <div class="col-md-4 ">
                        <b>Fecha del Evento:</b>
                        <p style="margin-right: 10px;" id="anios" value="anios">01/01/2022</p>
                        <b>Lugar del Evento:</b>
                        <p style="margin-right: 10px;" id="fecha" name="fecha">Japon</p>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Cancelar</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>