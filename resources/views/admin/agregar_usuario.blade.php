<!DOCTYPE html>
<html lang="es">

<head>
    @include('plantilla/admin/head')
</head>

<body>
    <!-- Content page-->
    <section class="full-box dashboard-contentPage">
        <!-- NavBar -->
        @include('plantilla/admin/navBar')

        <!-- Content page -->
        <div class="container p-3">
            <div class="page-header">
                <h2 class="text-titles">Agregar Usuario <small>(Nuevo)</small></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12 d-flex align-items-center">
                <div class="card-body p-4 p-lg-5 text-black">

                    <form method="POST" action="{{ route('registrar_usuario.index') }}">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-outline mb-4">
                                    <input type="text" id="name" class="form-control form-control-lg"
                                        name="name" />
                                    <label class="form-label" for="name">Alumno (Matrícula) / Admin (Nombre)</label>
                                </div>
                                @error('name')
                                    <p class="border border-danger rounded-md bg-red-200 w-full text-red-600 p-2 my-2">
                                        {{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-outline mb-4">
                                    <select class="form-control" name="IdTipoUsu" id="IdTipoUsu">
                                        @foreach ($tipousuario as $tipo)
                                            <option value="{{ $tipo->IdTipoUsu }}">{{ $tipo->NombreTipo }}</option>
                                        @endforeach
                                    </select>
                                    <label class="form-label" for="role">Rol de Usuario</label>
                                </div>
                                @error('role')
                                    <p class="border border-danger rounded-md bg-red-200 w-full text-red-600 p-2 my-2">
                                        {{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="form-outline mb-4">
                                    <input type="email" id="email" class="form-control form-control-lg"
                                        name="email" />
                                    <label class="form-label" for="email">Email(UPQROO)</label>
                                </div>
                                @error('email')
                                    <p class="border border-danger rounded-md bg-red-200 w-full text-red-600 p-2 my-2">
                                        {{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <div class="form-outline mb-4">
                                    <input type="password" id="password" class="form-control form-control-lg"
                                        name="password" />
                                    <label class="form-label" for="password">Contraseña</label>
                                </div>
                                @error('password')
                                    <p class="border border-danger rounded-md bg-red-200 w-full text-red-600 p-2 my-2">
                                        {{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-outline mb-4">
                                    <input type="password" id="password_confirmation"
                                        class="form-control form-control-lg" name="password_confirmation" />
                                    <label class="form-label" for="password_confirmation">Confirmar Contraseña</label>
                                </div>

                                @error('message')
                                    <p class="border border-danger rounded-md bg-red-200 w-full text-red-600 p-2 my-2">*
                                        Error</p>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-outline mb-4">
                                    <input type="text" id="Nombre" class="form-control form-control-lg"
                                        name="Nombre" />
                                    <label class="form-label" for="name">Nombre de la persona</label>
                                </div>
                                @error('name')
                                    <p class="border border-danger rounded-md bg-red-200 w-full text-red-600 p-2 my-2">
                                        {{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-outline mb-4">
                                    <input type="number" id="Matricula" class="form-control form-control-lg"
                                        name="Matricula" />
                                    <label class="form-label" for="name">Matricula</label>
                                </div>
                                @error('name')
                                    <p class="border border-danger rounded-md bg-red-200 w-full text-red-600 p-2 my-2">
                                        {{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="pt-1 mb-4">
                                    <button class="btn btn-dark btn-lg btn-block" type="submit">Registrar</button>
                                </div>
                            </div>
                        </div>


                    </form>

                </div>
            </div>
        </div>


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
