<!DOCTYPE html>
<html lang="es">
@include('plantilla/alumno/head')

<body>
    @include('plantilla/alumno/navBar')

    <div class="container-fluid colorbg">
    <button class="onboarding-btn">Guia rapida</button>
        <div class="titulo">
            <h2 class="estiloTitulo">Registros <small>(Estancias/Estadías)</small></h2>
           
        </div>
        <div class="contenedor">
        
            <div class="carta">
                <h4>Estancias</h4>
                <img src="{{ asset('/css/documentos.png') }}">

                <div class="row">
                    <a href="{{ route('estancia1.index', [1]) }}">Estancias I</a>
                </div>
                <div class="row">
                    <a href="{{ route('estancia1.index', [2]) }}">Estancias II</a>
                </div>
            </div>
            <div class="carta">
                <h4>Estadías</h4>
                <img src="{{ asset('/css/documentos.png') }}">

                <div class="row">
                    <a href="{{ route('estancia1.index', [3]) }}">Estadías</a>
                </div>
                <div class="row">
                    <a href="{{ route('estancia1.index', [4]) }}">Estadías Nacionales</a>
                </div>

            </div>
            <div class="carta">
                <h4>Servicio Social</h4>
                <img src="{{ asset('/css/documentos.png') }}">

                <div class="row">
                    <a href="{{ route('estancia1.index', [5]) }}">Servicio Social</a>
                </div>

            </div>
           <div>
           <div class="div" ></div>
           </div>
           
            <div class="estiloAviso">
				<embed src="css/calendario.pdf#toolbar=0" height="500" width="1000" type="" style="padding: 2%">
            </div>
            
        </div>

        <div>
        <div class="onboarding-overlay" ></div>
        <div class="onboarding-container">
            <div class="content">
                <a href="/views/inicio.blade.php" class="skip-btn">Skip</a>
                <div class="dots">
                    <div class="dot active"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                </div>
<!--Paso 1 -->
                <div class="steps">
                    <div class="step">
                        <div class="image">
                        <img src="{{ asset('/css/Estan1y2.png') }}">
                        </div> 
                    
                        <h3>Paso 1</h3>
                        <p>
                       <!--Si le quieres añadir algun mensaje debajo de 'paso#' ya esta configurado para que lo
                        puedas añadir aqui adentro -->   
                        </p>
                    </div>
                    <div class="step">
                        <div class="image">
                        <img src="{{ asset('/css/Step2.png') }}">
                        </div> 
                
                        <h3>Paso 2</h3>
                        <p>
                            <!--Si le quieres añadir algun mensaje debajo de 'paso#' ya esta configurado para que lo
                        puedas añadir aqui adentro -->
                        </p>
                    </div>
                    <div class="step">
                        <div class="image">
                        <img src="{{ asset('/css/guiaPDF.png') }}">
                        </div> 
                        <p>
                       <!--Si le quieres añadir algun mensaje debajo de 'paso#' ya esta configurado para que lo
                        puedas añadir aqui adentro --> 
                        <h3><a href="/css/GUIADEUSO.pdf">Descarga aqui</a></h3>  
                        </p>
                    </div>
                </div>
<!--Paso 2 -->
                <button class="next-btn" >Siguiente</button>
            </div>
            <script src="{{ asset('/js/main2.js') }}"></script>
        </div>
		</div>
    </div>
    @include('plantilla/alumno/footer')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
    window.onload = function() {
    var showAlert = true;
    function showSweetAlert() {
        if (showAlert) {
            showAlert = false;
            swal({
                title: "¡AVISO!",
                text: "¡RECUERDA SUBIR TUS DOCUMENTOS EN TIEMPO Y FORMA!",
                icon: "warning",
                button: "Ok",
            }).then(function() {
                swal.close();
            });
        }
    }
    showSweetAlert();
}
</script>
</body>
</html>
