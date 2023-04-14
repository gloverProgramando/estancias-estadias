<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Observaciones</title>
    @include('plantilla/admin/head')
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <!--  css botones datatable  -->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/2.3.3/css/buttons.dataTables.min.css" />
    <!-- script buttons datatable-->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.3/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.3/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.3/js/buttons.print.min.js"></script>
</head>

<body>
    <!-- NavBar -->
    @include('plantilla/admin/navBar')
    @include('sweetalert::alert')
    @include('notificaciones/notificaciones')
    <!-- Content page-->
    <section class="full-box dashboard-contentPage">
        <div class="page-header">
            <h2 class="text-center" style="padding: 1%">Observaciones para el documento {{$documento->ruta}}</h2>
        </div>
        <form action="{{ route('observacion_documento.index', $documento->IdDoc) }}" method="post"
            enctype="multipart/form-data">
            @csrf
			<div class="text-center" style="padding: 2%">
				<textarea class="form-control" id="observaciones" rows="5" name="observaciones">{{$documento->comentario}}</textarea>
			</div>
            @if($documento->comentario)
                
            @else
            <div class="text-center">
				<button class="btn btn-dark btn-lg btn-block g" type="submit">Guardar</button>
			</div>
            @endif
        </form>
    </section>

    <!--====== Scripts -->
    <script src="./js/jquery-3.1.1.min.js"></script>
    <script src="./js/sweetalert2.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/material.min.js"></script>
    <script src="./js/ripples.min.js"></script>
    <script src="./js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="./js/main.js"></script>
    <script>
        $.material.init();
    </script>
</body>

</html>
<style>
    .id_d {
        visibility: hidden;
        display: none;
        width: 10px;
    }
</style>
