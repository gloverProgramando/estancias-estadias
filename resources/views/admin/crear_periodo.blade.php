<!DOCTYPE html>
<html lang="en">

<head>
    @include('plantilla/admin/head')
    <!--  css botones datatable  -->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/2.3.3/css/buttons.dataTables.min.css" />

    <!---- script ---->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

    <!-- script buttons datatable-->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.3/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.3/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.3/js/buttons.print.min.js"></script>
</head>

<body>
    <header>
        @include('plantilla/admin/navBar')
    </header>
    <section class="full-box dashboard-contentPage">
        @include('notificaciones/notificaciones')
        @include('sweetalert::alert')
        <div class="container p-3">
            <div class="page-header">
                <h2 class="text-center">Creacion De Periodos</h2>
            </div>
        </div>
        <div class="d-flex justify-content-center align-items-center">
            @csrf
            <form action="{{ route('adminPeriodoCrear.index') }}">
                <div class="py-5">
                    <button class="btn btn-warning " type="submit">Crear Periodo Actual</button>
                </div>
            </form>
        </div>
    </section>
    <footer>

    </footer>
</body>

</html>
