<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPQROO</title>

    <link rel="stylesheet" href="css/menu.css">
	<link rel="stylesheet" href="css/formato.css">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="https://www.google.com/recaptcha/api.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href='{{ asset("/css/main.css") }}'>

</head>
<body>
    <!-- SideBar -->
	@include('plantilla/alumno/sideBar')

	<!-- Content page-->
	<section class="full-box dashboard-contentPage">
		<!-- NavBar -->
		@include('plantilla/alumno/navBar')
		<!-- Content page -->
		<div class="container p-3">
			<div class="page-header">
			  <h2 class="text-titles">Formatos <small>(Estancias II)</small></h2>
			</div>
		</div>
		@include('notificaciones/notificaciones')
		<div class="container p-2">
				<ol class="list-group borde">
					<!--Carga horaria-->
					<li class="list-group-item d-flex justify-content-between align-items-start" style="border: 1px solid rgb(210, 210, 210);">
						<div class="row lista">
							<div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-2">
								<div class="ms-2 me-auto">
									1.- Carga Horaria
								</div>
							</div>
							<div class="col-6 col-sm-6 col-md-5 col-lg-3 col-xl-3 p-1 colLlenar  ">
												
							</div>
							<!--DOC carga horaria-->
							<div class="col-12 col-sm-12 col-md-12 col-lg-7 p-1 colArchivo">
								@forelse ($documentos['documentos'] as $datoD)
									@forelse ($carta['carga_horaria'] as $datoCH)
										<div class="row">
											<div class="col-12 col-sm-12 py-1">
												@switch($datoCH->estado_c_h)
													@case(0)
														<!--Observaciones-->
														<div class="row">
															<div class="col-12 col-sm-9">
																<form class="btn-cancelar-carga-horaria-system" action="{{ route('cancelar_carga_horaria_Estancia2.index',[$datoCH->id_documentos,$datoCH->name]) }}" method="POST" enctype="multipart/form-data">
																	@csrf
																	<div class="row">
																		<div class="col-12 col-sm-9 id_d" >
																			<input type="text" name="nombreCarga_horaria" id="" value="{{$datoCH->nombre_c_h}}" class="nombreDoc"style=''>
																		</div>
																		<div class="col-12 col-sm-9 py-1" >
																			<input type="text" value="{{$datoCH->nombre_c_h}}" class="nombreDoc" disabled>
																		</div>
																		<div class="col-12 col-sm-3 py-1">
																			<button type="submit" class="btn btn-outline-danger btnCancelar" >Cancelar</button>
																		</div>
																	</div>
																	
																</form>
															</div>
															<div class="col-12 col-sm-3">
																<a href="{{ route('observaciones_carga_horaria_estancia2.index') }}">
																	<button type="submit" class="btn btn-outline-danger divObservacionf02" ><i class="zmdi zmdi-folder-person">  Observaciones</i> </button>
																</a>	
															</div>
																			
														</div>																																					
													@break
												
													@case(1)
													<!--pendiente-->
													<div class="row">
														<div class="col-12 col-sm-9">
															<form class="btn-cancelar-carga-horaria-system" action="{{ route('cancelar_carga_horaria_Estancia2.index',[$datoCH->id_documentos,$datoCH->name]) }}" method="POST" enctype="multipart/form-data">
																@csrf
																<div class="row">
																	<div class="col-12 col-sm-9 px-3 py-1 id_d" >
																		<input type="text" name="nombreCarga_horaria" id="" value="{{$datoCH->nombre_c_h}}" class="nombreDoc"style=''>
																	</div>
																	<div class="col-12 col-sm-9 px-3 py-1" >
																		<input type="text" value="{{$datoCH->nombre_c_h}}" class="nombreDoc" disabled>
																	</div>
																	<div class="col-12 col-sm-3 px-3 py-1">
																		<button type="submit" class="btn btn-outline-danger btnCancelar" >Cancelar</button>
																	</div>
																</div>																			
															</form>
														</div>
														<div class="col-12 col-sm-3">
															<div class="divPendientef02"><i class="zmdi zmdi-folder-person">  Pendiente</i>  </div>
													@break
													@case(2)
													<!--aceptado-->
															<div class="row">
																<div class="col-12 col-sm-9 px-3 py-1" >
																	<input type="text" value="{{$datoCH->nombre_c_h }}" class="nombreDoc" disabled>
																</div>
																<div class="col-12 col-sm-3 px-3 py-1" >
																	<div class="divAceptadof02"><i class="zmdi zmdi-check-circle-u">  Aceptado</i> </div>
																</div>
															</div>																			
													@break
													@default
															<p>Error</p>
												@endswitch
											</div>
										</div>
									@empty
									<!-- enviar carga horaria con datos-->
										@forelse ($documentos['documentos'] as $dato)														
											<form action="{{ route('actualizar_carga_horaria_estancia2.index',[auth()->user()->name,$datoD->name]) }}" method="post" enctype="multipart/form-data" >
												@csrf
													<input type="text" class="id_d" value="{{$datoD->id_documentos}}" name="id_doc_carga_horaria">
													<span class="btn  fileinput-button">
														<i class="zmdi zmdi-file"></i>
														<input type="file" class="archivo" name="carga_horaria">
													</span>
													<button type="submit" class="btn btn-outline-info btnSubir">Enviar</button>
											</form>
											
										@empty
											Error
										@endforelse	
									@endforelse	
								@empty
									<!-- enviar carga horaria vacio-->
									<form action="{{ route('subir_carga_horaria_estancia2.index',[auth()->user()->name,auth()->user()->name]) }}" method="post" enctype="multipart/form-data" >
										@csrf
										<span class="btn  fileinput-button">
											<i class="zmdi zmdi-file"></i>
											<input type="file" class="archivo" name="carga_horaria">
										</span>
										<button type="submit" class="btn btn-outline-info btnSubir">Enviar</button>
									</form>
								@endforelse			
							</div>
							<!--error carga_horaria-->				
							@error('carga_horaria')
								<p class="border border-danger rounded-md bg-red-200 w-full text-red-600 p-2 my-2">{{ $message }}</p>
							@enderror
						</div>
					</li>
					<!--Constacias de vigencia de derechos-->
					<li class="list-group-item d-flex justify-content-between align-items-start" style="border: 1px solid rgb(210, 210, 210);">
						<div class="row lista">
							<div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-2">
								<div class="ms-2 me-auto">
									2.- Constancia de vigencia de derechos del IMSS
								</div>
							</div>								
							<div class="col-6 col-sm-6 col-md-5 col-lg-3 col-xl-3 p-1 colLlenar  ">
												
							</div>
							<!--DOC constancia derecho-->
							<div class="col-12 col-sm-12 col-md-12 col-lg-7 p-1 colArchivo">
								@forelse ($documentos['documentos'] as $datoD)
									@forelse ($carta1['constancia_derecho'] as $datoCD)
										<div class="row">
											<div class="col-12 col-sm-12 py-1">
												@switch($datoCD->estado_c_d)
													@case(0)
														<!--Observaciones-->
														<div class="row">
															<div class="col-12 col-sm-9">
																<form class="btn-cancelar-constancia-derecho-system" action="{{ route('cancelar_constancia_derecho_Estancia2.index',[$datoCD->id_documentos,$datoCD->name]) }}" method="POST" enctype="multipart/form-data">
																	@csrf
																	<div class="row">
																		<div class="col-12 col-sm-9 id_d" >
																			<input type="text" name="nombreConstancia_derecho" id="" value="{{$datoCD->nombre_c_d}}" class="nombreDoc"style=''>
																		</div>
																		<div class="col-12 col-sm-9 py-1" >
																			<input type="text" value="{{$datoCD->nombre_c_d}}" class="nombreDoc" disabled>
																		</div>
																		<div class="col-12 col-sm-3 py-1">
																			<button type="submit" class="btn btn-outline-danger btnCancelar" >Cancelar</button>
																		</div>
																	</div>
																	
																</form>
															</div>
															<div class="col-12 col-sm-3">
																<a href="{{ route('obsevaciones2_constancia_derecho.index') }}">
																	<button type="submit" class="btn btn-outline-danger divObservacionf02" ><i class="zmdi zmdi-folder-person">  Observaciones</i> </button>
																</a>	
															</div>
																			
														</div>																																					
													@break
												
													@case(1)
													<!--pendiente-->
													<div class="row">
														<div class="col-12 col-sm-9">
															<form class="btn-cancelar-constancia-derecho-system" action="{{ route('cancelar_constancia_derecho_Estancia2.index',[$datoCD->id_documentos,$datoCD->name]) }}" method="POST" enctype="multipart/form-data">
																@csrf
																<div class="row">
																	<div class="col-12 col-sm-9 px-3 py-1 id_d" >
																		<input type="text" name="nombreConstancia_derecho" id="" value="{{$datoCD->nombre_c_d}}" class="nombreDoc"style=''>
																	</div>
																	<div class="col-12 col-sm-9 px-3 py-1" >
																		<input type="text" value="{{$datoCD->nombre_c_d}}" class="nombreDoc" disabled>
																	</div>
																	<div class="col-12 col-sm-3 px-3 py-1">
																		<button type="submit" class="btn btn-outline-danger btnCancelar" >Cancelar</button>
																	</div>
																</div>																			
															</form>
														</div>
														<div class="col-12 col-sm-3">
															<div class="divPendientef02"><i class="zmdi zmdi-folder-person">  Pendiente</i>  </div>
														</div>
													@break
													@case(2)
													<!--aceptado-->
														<div class="row">
															<div class="col-12 col-sm-9 px-3 py-1" >
																<input type="text" value="{{$datoCD->nombre_c_d }}" class="nombreDoc" disabled>
															</div>
															<div class="col-12 col-sm-3 px-3 py-1" >
																<div class="divAceptadof02"><i class="zmdi zmdi-check-circle-u">  Aceptado</i> </div>
															</div>
														</div>																			
													@break
													@default
														<p>Error</p>
												@endswitch
											</div>
										</div>
									@empty
									<!-- enviar constancia derecho con datos-->
										@forelse ($documentos['documentos'] as $dato)														
											<form action="{{ route('actualizar_constancia_derecho_estancia2.index',[auth()->user()->name,$datoD->name]) }}" method="post" enctype="multipart/form-data" >
												@csrf
													<input type="text" class="id_d" value="{{$datoD->id_documentos}}" name="id_doc_constancia_derecho">
													<span class="btn  fileinput-button">
														<i class="zmdi zmdi-file"></i>
														<input type="file" class="archivo" name="constancia_derecho">
													</span>
													<button type="submit" class="btn btn-outline-info btnSubir">Enviar</button>
											</form>
											
										@empty
											Error
										@endforelse	
									@endforelse	
								@empty
									<!-- enviar constancia derecho vacio-->
									<form action="{{ route('subir_constancia_derecho_estancia2.index',[auth()->user()->name,auth()->user()->name]) }}" method="post" enctype="multipart/form-data" >
										@csrf
										<span class="btn  fileinput-button">
											<i class="zmdi zmdi-file"></i>
											<input type="file" class="archivo" name="constancia_derecho">
										</span>
										<button type="submit" class="btn btn-outline-info btnSubir">Enviar</button>
									</form>
								@endforelse			
							</div>
							<!--error constancia derecho-->				
							@error('constancia derecho')
								<p class="border border-danger rounded-md bg-red-200 w-full text-red-600 p-2 my-2">{{ $message }}</p>
							@enderror	
						</div>
					</li>
					<!--Formato de carta responsiva-->
					<li class="list-group-item d-flex justify-content-between align-items-start" style="border: 1px solid rgb(210, 210, 210);">
						<div class="row lista">
							<div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2">
								<div class="ms-2 me-auto">
								  3.- Carta de exclusion de responsabilidad
								</div>
							</div>
						
								
							<div class="col-6 col-sm-12 col-md-3 col-lg-2 col-xl-2 p-1 colDescargar text-left">
								<a href="{{ route('descarga_carta_responsiva.index') }}">
									<button type="button" class="btn btn-outline-info btnDescargar"><i class="zmdi zmdi-download"> Descargar</i></button>
								</a>
							</div>
							<div class="col-6 col-sm-6 col-md-5 col-lg-3 col-xl-1 p-1 colLlenar  ">
												
							</div>
							<!--DOC carta responsiva-->
							<div class="col-12 col-sm-12 col-md-12 col-lg-7 p-1 colArchivo">
								@forelse ($documentos['documentos'] as $datoD)
									@forelse ($carta1['carta_responsiva'] as $datoCR)
										<div class="row">
											<div class="col-12 col-sm-12 py-1">
												@switch($datoCR->estado_c_r)
													@case(0)
														<!--Observaciones-->
														<div class="row">
															<div class="col-12 col-sm-9">
																<form class="btn-cancelar-carta-responsiva-system" action="{{ route('cancelar_carta_responsiva_Estancia2.index',[$datoCR->id_documentos,$datoCR->name]) }}" method="POST" enctype="multipart/form-data">
																	@csrf
																	<div class="row">
																		<div class="col-12 col-sm-9 id_d" >
																			<input type="text" name="nombreCarta_responsiva" id="" value="{{$datoCR->nombre_c_r}}" class="nombreDoc"style=''>
																		</div>
																		<div class="col-12 col-sm-9 py-1" >
																			<input type="text" value="{{$datoCR->nombre_c_r}}" class="nombreDoc" disabled>
																		</div>
																		<div class="col-12 col-sm-3 py-1">
																			<button type="submit" class="btn btn-outline-danger btnCancelar" >Cancelar</button>
																		</div>
																	</div>
																	
																</form>
															</div>
															<div class="col-12 col-sm-3">
																<a href="{{ route('obsevaciones2_carta_responsiva.index') }}">
																	<button type="submit" class="btn btn-outline-danger divObservacionf02" ><i class="zmdi zmdi-folder-person">  Observaciones</i> </button>
																</a>	
															</div>
																			
														</div>																																					
													@break
												
													@case(1)
													<!--pendiente-->
													<div class="row">
														<div class="col-12 col-sm-9">
															<form class="btn-cancelar-carta-responsiva-system" action="{{ route('cancelar_carta_responsiva_Estancia2.index',[$datoCR->id_documentos,$datoCR->name]) }}" method="POST" enctype="multipart/form-data">
																@csrf
																<div class="row">
																	<div class="col-12 col-sm-9 px-3 py-1 id_d" >
																		<input type="text" name="nombreCarta_responsiva" id="" value="{{$datoCR->nombre_c_r}}" class="nombreDoc"style=''>
																	</div>
																	<div class="col-12 col-sm-9 px-3 py-1" >
																		<input type="text" value="{{$datoCR->nombre_c_r}}" class="nombreDoc" disabled>
																	</div>
																	<div class="col-12 col-sm-3 px-3 py-1">
																		<button type="submit" class="btn btn-outline-danger btnCancelar" >Cancelar</button>
																	</div>
																</div>																			
															</form>
														</div>
														<div class="col-12 col-sm-3">
															<div class="divPendientef02"><i class="zmdi zmdi-folder-person">  Pendiente</i>  </div>
														</div>
													@break
													@case(2)
													<!--aceptado-->
														<div class="row">
															<div class="col-12 col-sm-9 px-3 py-1" >
																<input type="text" value="{{$datoCR->nombre_c_r }}" class="nombreDoc" disabled>
															</div>
															<div class="col-12 col-sm-3 px-3 py-1" >
																<div class="divAceptadof02"><i class="zmdi zmdi-check-circle-u">  Aceptado</i> </div>
															</div>
														</div>																			
													@break
													@default
														<p>Error</p>
												@endswitch
											</div>
										</div>
									@empty
									<!-- enviar carta responsiva con datos-->
										@forelse ($documentos['documentos'] as $dato)														
											<form action="{{ route('actualizar_carta_responsiva_estancia2.index',[auth()->user()->name,$datoD->name]) }}" method="post" enctype="multipart/form-data" >
												@csrf
													<input type="text" class="id_d" value="{{$datoD->id_documentos}}" name="id_doc_carta_responsiva">
													<span class="btn  fileinput-button">
														<i class="zmdi zmdi-file"></i>
														<input type="file" class="archivo" name="carta_responsiva">
													</span>
													<button type="submit" class="btn btn-outline-info btnSubir">Enviar</button>
											</form>
											
										@empty
											Error
										@endforelse	
									@endforelse	
								@empty
									<!-- enviar carta responsiva vacio-->
									<form action="{{ route('subir_carta_responsiva_estancia2.index',[auth()->user()->name,auth()->user()->name]) }}" method="post" enctype="multipart/form-data" >
										@csrf
										<span class="btn  fileinput-button">
											<i class="zmdi zmdi-file"></i>
											<input type="file" class="archivo" name="carta_responsiva">
										</span>
										<button type="submit" class="btn btn-outline-info btnSubir">Enviar</button>
									</form>
								@endforelse			
							</div>
							<!--error carta responsiva-->				
							@error('carta_responsiva')
								<p class="border border-danger rounded-md bg-red-200 w-full text-red-600 p-2 my-2">{{ $message }}</p>
							@enderror	
						</div>
					</li>
					<!-- f01 -->
					<li class="list-group-item d-flex justify-content-between align-items-start" style="border: 1px solid rgb(210, 210, 210);">
						<div class="row lista">
							<div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2">
								<div class="ms-2 me-auto">
									<div class="fw-bold">F01</div>
									4.- Carta de Presentación
								</div>
							</div>
						
							<!--Descargar 01-->
							<div class="col-6 col-sm-12 col-md-3 col-lg-2 col-xl-2 p-1 colDescargar text-left">
								<a href="{{ route('descarga_cd_estancia_f01.index') }}">
									<button type="button" class="btn btn-outline-info btnDescargar"><i class="zmdi zmdi-download"> Descargar</i></button>
								</a>
							</div>
							<div class="col-6 col-sm-6 col-md-5 col-lg-3 col-xl-1 p-1 colLlenar  ">				
							</div>
							<!--DOC 01-->
							<div class="col-12 col-sm-12 col-md-12 col-lg-7 p-1 colArchivo">
								@forelse ($documentos['documentos'] as $datoD)
									@forelse ($carta['carta_presentacion'] as $datoCP)
										<div class="row">
											<div class="col-12 col-sm-12 py-1">
												@switch($datoCP->estado_c_p)
													@case(0)
														<!--Observaciones-->
														<div class="row">
															<div class="col-12 col-sm-9">
																<form class="btn-cancelarF1-system" action="{{ route('cancelar_f01_Estancia2.index',[$datoCP->id_documentos,$datoCP->name]) }}" method="POST" enctype="multipart/form-data">
																	@csrf
																	<div class="row">
																		<div class="col-12 col-sm-9 id_d" >
																			<input type="text" name="nombreAf01" id="" value="{{$datoCP->nombre_c_p}}" class="nombreDoc"style=''>
																		</div>
																		<div class="col-12 col-sm-9 py-1" >
																			<input type="text" value="{{$datoCP->nombre_c_p}}" class="nombreDoc" disabled>
																		</div>
																		<div class="col-12 col-sm-3 py-1">
																			<button type="submit" class="btn btn-outline-danger btnCancelar" >Cancelar</button>
																		</div>
																	</div>
																	
																</form>
															</div>
															<div class="col-12 col-sm-3">
																<a href="{{ route('obsevaciones2_f01_estancia.index') }}">
																	<button type="submit" class="btn btn-outline-danger divObservacionf02" ><i class="zmdi zmdi-folder-person">  Observaciones</i> </button>
																</a>	
															</div>
																			
														</div>																																					
													@break
												
													@case(1)
													<!--pendiente-->
													<div class="row">
														<div class="col-12 col-sm-9">
															<form class="btn-cancelarF1-system" action="{{ route('cancelar_f01_Estancia2.index',[$datoCP->id_documentos,$datoCP->name]) }}" method="POST" enctype="multipart/form-data">
																@csrf
																<div class="row">
																	<div class="col-12 col-sm-9 px-3 py-1 id_d" >
																		<input type="text" name="nombreAf01" id="" value="{{$datoCP->nombre_c_p}}" class="nombreDoc"style=''>
																	</div>
																	<div class="col-12 col-sm-9 px-3 py-1" >
																		<input type="text" value="{{$datoCP->nombre_c_p}}" class="nombreDoc" disabled>
																	</div>
																	<div class="col-12 col-sm-3 px-3 py-1">
																		<button type="submit" class="btn btn-outline-danger btnCancelar" >Cancelar</button>
																	</div>
																</div>																			
															</form>
														</div>
														<div class="col-12 col-sm-3">
															<div class="divPendientef02"><i class="zmdi zmdi-folder-person">  Pendiente</i>  </div>
													@break
													@case(2)
													<!--aceptado-->
															<div class="row">
																<div class="col-12 col-sm-9 px-3 py-1" >
																	<input type="text" value="{{$datoCP->nombre_c_p}}" class="nombreDoc" disabled>
																</div>
																<div class="col-12 col-sm-3 px-3 py-1" >
																	<div class="divAceptadof02"><i class="zmdi zmdi-check-circle-u">  Aceptado</i> </div>
																</div>
															</div>																			
													@break
													@default
															<p>Error</p>
												@endswitch
											</div>
										</div>
									@empty
									<!-- enviar cedula registro con datos-->
										@forelse ($documentos['documentos'] as $dato)														
											<form action="{{ route('actualizar_f01_estancia2.index',[auth()->user()->name,$datoD->name]) }}" method="post" enctype="multipart/form-data" >
												@csrf
													<input type="text" class="id_d" value="{{$datoD->id_documentos}}" name="id_docf01">
													<span class="btn  fileinput-button">
														<i class="zmdi zmdi-file"></i>
														<input type="file" class="archivo" name="f01">
													</span>
													<button type="submit" class="btn btn-outline-info btnSubir">Enviar</button>
											</form>
											
										@empty
											Error
										@endforelse	
									@endforelse	
								@empty
								<!-- enviar cedula registro vacio-->
									<form action="{{ route('subir_f01_estancia2.index',[auth()->user()->name,auth()->user()->name]) }}" method="post" enctype="multipart/form-data" >
										@csrf
										<span class="btn  fileinput-button">
											<i class="zmdi zmdi-file"></i>
											<input type="file" class="archivo" name="f01">
										</span>
										<button type="submit" class="btn btn-outline-info btnSubir">Enviar</button>
									</form>
								@endforelse			
							</div>
							<!--error f01-->				
							@error('f01')
								<p class="border border-danger rounded-md bg-red-200 w-full text-red-600 p-2 my-2">{{ $message }}</p>
							@enderror	
						</div>
					</li>
					<!-- f02 -->
					<li class="list-group-item d-flex justify-content-between align-items-start" style="border: 1px solid rgb(210, 210, 210);">
						<div class="row lista">
							<div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2">
								<div class="ms-2 me-auto">
									<div class="fw-bold">F02</div>
									5.- Carta de Aceptación
								</div>
							</div>
							<!--Descargar 02-->
							<div class="col-6 col-sm-12 col-md-3 col-lg-2 col-xl-2 p-1 colDescargar text-left">
								<a href="{{ route('descarga_cd_estancia_f02.index') }}">
									<button type="button" class="btn btn-outline-info btnDescargar"><i class="zmdi zmdi-download"> Descargar</i></button>
								</a>
							</div>
							<div class="col-6 col-sm-6 col-md-5 col-lg-3 col-xl-1 p-1 colLlenar  ">					
							</div>
							<div class="col-12 col-sm-12 col-md-12 col-lg-7 p-1 colArchivo">
												@forelse ($documentos['documentos'] as $datoD)
														@forelse ($carta_aceptacion['carta_aceptacion'] as $datoCA)
																		<div class="row">
																			<div class="col-12 col-sm-12 py-1">
																				@switch($datoCA->estado)
																					@case(0)
																						<!--Observaciones-->
																						<div class="row">
																							<div class="col-12 col-sm-9">
																								<form class="btn-cancelarF2-system" action="{{ route('cancelar_f02_Estancia2.index',[$datoCA->id_documentos,$datoCA->name]) }}" method="POST" enctype="multipart/form-data">
																									@csrf
																									<div class="row">
																										<div class="col-12 col-sm-9 id_d" >
																											<input type="text" name="nombreAf02" id="" value="{{$datoCA->nombre}}" class="nombreDoc"style=''>
																										</div>
																										<div class="col-12 col-sm-9 py-1" >
																											<input type="text" value="{{$datoCA->nombre}}" class="nombreDoc" disabled>
																										</div>
																										<div class="col-12 col-sm-3 py-1">
																											<button type="submit" class="btn btn-outline-danger btnCancelar" >Cancelar</button>
																										</div>
																									</div>
																									
																								</form>
																							</div>
																							<div class="col-12 col-sm-3">
																								<a href="{{ route('obsevaciones2_f02.index') }}">
																									<button type="submit" class="btn btn-outline-danger divObservacionf02" ><i class="zmdi zmdi-folder-person">  Observaciones</i> </button>
																								</a>	
																							</div>
																											
																						</div>																																					
																					@break
																				
																					@case(1)
																					<!--pendiente-->
																					<div class="row">
																						<div class="col-12 col-sm-9">
																							<form class="btn-cancelarF2-system" action="{{ route('cancelar_f02_Estancia2.index',[$datoCA->id_documentos,$datoCA->name]) }}" method="POST" enctype="multipart/form-data">
																								@csrf
																								<div class="row">
																									<div class="col-12 col-sm-9 px-3 py-1 id_d" >
																										<input type="text" name="nombreAf02" id="" value="{{$datoCA->nombre}}" class="nombreDoc"style=''>
																									</div>
																									<div class="col-12 col-sm-9 px-3 py-1" >
																										<input type="text" value="{{$datoCA->nombre}}" class="nombreDoc" disabled>
																									</div>
																									<div class="col-12 col-sm-3 px-3 py-1">
																										<button type="submit" class="btn btn-outline-danger btnCancelar" >Cancelar</button>
																									</div>
																								</div>																			
																							</form>
																						</div>
																						<div class="col-12 col-sm-3">
																							<div class="divPendientef02"><i class="zmdi zmdi-folder-person">  Pendiente</i>  </div>
																					@break
																					@case(2)
																					<!--aceptado-->
																							<div class="row">
																								<div class="col-12 col-sm-9 px-3 py-1" >
																									<input type="text" value="{{$datoCA->nombre}}" class="nombreDoc" disabled>
																								</div>
																								<div class="col-12 col-sm-3 px-3 py-1" >
																									<div class="divAceptadof02"><i class="zmdi zmdi-check-circle-u">  Aceptado</i> </div>
																								</div>
																							</div>																			
																					@break
																					@default
																							<p>Error</p>
																				@endswitch
																			</div>
																		</div>
														@empty
														<!-- enviar cedula registro con datos-->
															@forelse ($documentos['documentos'] as $dato)														
																<form action="{{ route('actualizar_f02_estancia2.index',[auth()->user()->name,$datoD->name]) }}" method="post" enctype="multipart/form-data" >
																	@csrf
																		<input type="text" class="id_d" value="{{$datoD->id_documentos}}" name="id_docf02">
																		<span class="btn  fileinput-button">
																			<i class="zmdi zmdi-file"></i>
																			<input type="file" class="archivo" name="f02">
																		</span>
																		<button type="submit" class="btn btn-outline-info btnSubir">Enviar</button>
																</form>
																
															@empty
																Error
															@endforelse	
														@endforelse	
												@empty
												<!-- enviar cedula registro vacio-->
													<form action="{{ route('subir_f02_estancia2.index',[auth()->user()->name,auth()->user()->name]) }}" method="post" enctype="multipart/form-data" >
														@csrf
														<span class="btn  fileinput-button">
															<i class="zmdi zmdi-file"></i>
															<input type="file" class="archivo" name="f02">
														</span>
														<button type="submit" class="btn btn-outline-info btnSubir">Enviar</button>
													</form>
												@endforelse			
							</div>
							<!--Error 01-->						
							@error('f02')
								<p class="border border-danger rounded-md bg-red-200 w-full text-red-600 p-2 my-2">{{ $message }}</p>
							@enderror													
										
						</div>
					</li>
					<!-- f03 -->
					<li class="list-group-item d-flex justify-content-between align-items-start" style="border: 1px solid rgb(210, 210, 210);">
						<div class="row lista">
							<div class="col-6 col-sm-6 col-md-6 col-lg-3 col-xl-2">
								<div class="ms-2 me-auto">
									<div class="fw-bold">F03</div>
									6.- Cédula de Registro
								</div>
							</div>
						
								
							@forelse ($datos['datosCedula'] as $dato)
								
								<div class="col-12 col-sm-12 col-md-12 col-lg-10 p-1 colArchivo">
									@forelse ($documentos['documentos'] as $datoD)
											@forelse ($documentos['cedula_registro'] as $datoC)
												<div class="row">
													<div class="col-12 col-sm-12 py-1">
														@switch($datoC->estado_c_r)
															@case(0)
																<!--Observaciones-->
																<div class="row">
																	<!--ELIMINAR F03-->
																	<div class="col-6 col-sm-6 col-md-2 py-1 colLlenar">
																		<form class="btn-eliminarCR-system" method="post" action="{{ route('eliminar_f032',[$dato->id_alumno,$dato->id_empresa,$dato->id_asesor_emp,$dato->id_asesor_aca,$dato->id_proyecto]) }}">
																			@csrf
																			<button type="submit" class="btn btn-outline-danger btnCancelar" >Eliminar</button>
																		</form>											
																	</div>
																	<!--Descargar F03-->
																	<div class="col-6 col-sm-6 col-md-1 py-1 colDescargar text-center">
																		<a href="{{ route('descarga_cd_estancia_f03.index'),[2] }}">
																			<button type="button" class="btn btn-outline-info btnDescargar"><i class="zmdi zmdi-download"> Descargar</i></button>
																		</a>
																	</div>
																	<div class="col-12 col-sm-7">
																		<form class="btn-cancelarF3-system" action="{{ route('cancelar_f03_Estancia2.index',[$datoC->id_documentos,$datoC->name]) }}" method="POST" enctype="multipart/form-data">
																			@csrf
																			<div class="row">
																				<div class="col-12 col-sm-9 id_d" >
																					<input type="text" name="nombreAf03" id="" value="{{$datoC->nombre_c_r}}" class="nombreDoc"style=''>
																				</div>
																				<div class="col-12 col-sm-9 py-1" >
																					<input type="text" value="{{$datoC->nombre_c_r}}" class="nombreDoc" disabled>
																				</div>
																				<div class="col-12 col-sm-3 py-1">
																					<button type="submit" class="btn btn-outline-danger btnCancelar" >Cancelar</button>
																				</div>
																			</div>
																			
																		</form>
																	</div>
																	<div class="col-12 col-sm-2">
																		<a href="{{ route('obsevaciones2_f03.index') }}">
																			<button type="submit" class="btn btn-outline-danger divObservacionf02" ><i class="zmdi zmdi-folder-person">  Observaciones</i> </button>
																		</a>	
																	</div>
																					
																</div>																																					
															@break
														
															@case(1)
															<!--pendiente-->
															<div class="row">
																<!--ELIMINAR F03-->
																<div class="col-6 col-sm-6 col-md-5 col-lg-3 col-xl-2 p-1 colLlenar">
																	<form class="btn-eliminarCR-system" method="post" action="{{ route('eliminar_f032',[$dato->id_alumno,$dato->id_empresa,$dato->id_asesor_emp,$dato->id_asesor_aca,$dato->id_proyecto]) }}">
																		@csrf
																		<button type="submit" class="btn btn-outline-danger btnCancelar" >Eliminar</button>
																	</form>											
																</div>
																<!--Descargar F03-->
																<div class="col-12 col-sm-12 col-md-3 col-lg-2 col-xl-1 p-1 colDescargar text-center">
																	<a href="{{ route('descarga_cd_estancia_f03.index',[2]) }}">
																		<button type="button" class="btn btn-outline-info btnDescargar"><i class="zmdi zmdi-download"> Descargar</i></button>
																	</a>
																</div>
																<div class="col-12 col-sm-7">
																	<form class="btn-cancelarF3-system" action="{{ route('cancelar_f03_Estancia2.index',[$datoC->id_documentos,$datoC->name]) }}" method="POST" enctype="multipart/form-data">
																		@csrf
																		<div class="row">
																			<div class="col-12 col-sm-9 px-3 py-1 id_d" >
																				<input type="text" name="nombreAf03" id="" value="{{$datoC->nombre_c_r}}" class="nombreDoc"style=''>
																			</div>
																			<div class="col-12 col-sm-9 px-3 py-1" >
																				<input type="text" value="{{$datoC->nombre_c_r}}" class="nombreDoc" disabled>
																			</div>
																			<div class="col-12 col-sm-3 px-3 py-1">
																				<button type="submit" class="btn btn-outline-danger btnCancelar" >Cancelar</button>
																			</div>
																		</div>																			
																	</form>
																</div>
																<div class="col-12 col-sm-2">
																	<div class="divPendientef02"><i class="zmdi zmdi-folder-person">  Pendiente</i>  </div>
															@break
															@case(2)
															<!--aceptado-->
																	<div class="row">
																		<!--Descargar F03-->
																		<div class="col-12 col-sm-12 col-md-1 py-1 colDescargar text-center">
																			<a href="{{ route('descarga_cd_estancia_f03.index',[2]) }}">
																				<button type="button" class="btn btn-outline-info btnDescargar"><i class="zmdi zmdi-download"> Descargar</i></button>
																			</a>
																		</div>
																		<div class="col-0 col-md-2 py-1 colDescargar text-center">
																			
																		</div>
																		<div class="col-12 col-sm-7 px-3 py-1" >
																			<input type="text" value="{{$datoC->nombre_c_r}}" class="nombreDoc" disabled>
																		</div>
																		<div class="col-12 col-sm-2 px-3 py-1" >
																			<div class="divAceptadof02"><i class="zmdi zmdi-check-circle-u">  Aceptado</i> </div>
																		</div>
																	</div>																			
															@break
															@default
																	<p>Error</p>
														@endswitch
													</div>
												</div>
											@empty
												<div class="row">
													<!--ELIMINAR F03-->
													<div class="col-6 col-sm-6 col-md-2 py-1 colLlenar">
														<form class="btn-eliminarCR-system" method="post" action="{{ route('eliminar_f032',[$dato->id_alumno,$dato->id_empresa,$dato->id_asesor_emp,$dato->id_asesor_aca,$dato->id_proyecto]) }}">
															@csrf
															<button type="submit" class="btn btn-outline-danger btnCancelar" >Eliminar</button>
														</form>											
													</div>
													<!--Descargar F03-->
													<div class="col-6 col-sm-6 col-md-1 py-1 colDescargar text-center">
														<a href="{{ route('descarga_cd_estancia_f03.index',[2]) }}">
															<button type="button" class="btn btn-outline-info btnDescargar"><i class="zmdi zmdi-download"> Descargar</i></button>
														</a>
													</div>
													<div class="col-12 col-md-9 py-1">
														<!-- enviar cedula registro con datos-->
														@forelse ($documentos['documentos'] as $dato)														
															<form action="{{ route('actualizar_f03_estancia2.index',[auth()->user()->name,$datoD->name]) }}" method="post" enctype="multipart/form-data" >
																@csrf
																	<input type="text" class="id_d" value="{{$datoD->id_documentos}}" name="id_docf03">
																	<span class="btn  fileinput-button">
																		<i class="zmdi zmdi-file"></i>
																		<input type="file" class="archivo" name="f03">
																	</span>
																	<button type="submit" class="btn btn-outline-info btnSubir">Enviar</button>
															</form>
														@empty
														Error
														@endforelse	
													</div>
												</div>
											
											@endforelse	
									@empty
										<div class="row">
											<!--ELIMINAR F03-->
											<div class="col-6 col-sm-6 col-md-2 py-1 colLlenar">
												<form class="btn-eliminarCR-system" method="post" action="{{ route('eliminar_f032',[$dato->id_alumno,$dato->id_empresa,$dato->id_asesor_emp,$dato->id_asesor_aca,$dato->id_proyecto]) }}">
													@csrf
													<button type="submit" class="btn btn-outline-danger btnCancelar" >Eliminar</button>
												</form>											
											</div>
											<!--Descargar F03-->
											<div class="col-6 col-sm-6 col-md-1 py-1 colDescargar text-center">
												<a href="{{ route('descarga_cd_estancia_f03.index',[2]) }}">
													<button type="button" class="btn btn-outline-info btnDescargar"><i class="zmdi zmdi-download"> Descargar</i></button>
												</a>
											</div>
											<div class="col-12 col-md-9 py-1">
												<!-- enviar cedula registro vacio-->
												<form action="{{ route('subir_f03_estancia2.index',[auth()->user()->name,auth()->user()->name]) }}" method="post" enctype="multipart/form-data" >
													@csrf
													<span class="btn  fileinput-button">
														<i class="zmdi zmdi-file"></i>
														<input type="file" class="archivo" name="f03">
													</span>
													<button type="submit" class="btn btn-outline-info btnSubir">Enviar</button>
												</form>
											</div>
										</div>					
									@endforelse			
								</div>			
							@empty
								<!-- llenar cedula registro vacio-->
								<div class="col-6 col-sm-6 col-md-6 col-lg-2 col-xl-2 p-1 colLlenar">
									<a href="{{ route('home.index',[2]) }}">
										<button type="button" class="btn btn-outline-dark btnLlenar" >Llenar Cedula de Registro</button>
									</a>
								</div>
											
								<div class="col-12 col-sm-12 col-md-12 col-lg-8 colArchivo">
													
								</div>
							@endforelse	
							<!--error 03-->				
							@error('f03')
								<p class="border border-danger rounded-md bg-red-200 w-full text-red-600 p-2 my-2">{{ $message }}</p>
							@enderror												
						</div>
					</li>
					<!--f04-->
					<li class="list-group-item d-flex justify-content-between align-items-start" style="border: 1px solid rgb(210, 210, 210);">
						<div class="row lista">	
						<div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2">
								<div class="ms-2 me-auto">
									<div class="fw-bold">F04</div>
									7.- Definición de Proyecto
								</div>
							</div>
							
							@forelse ($definicionP['datosDef'] as $dato)							
								<div class="col-12 col-sm-12 col-md-12 col-lg-10 p-1 colArchivo">
									@forelse ($documentos['documentos'] as $datoD)
											@forelse ($etapas['definicion_proyecto'] as $datoDP)
															<div class="row">
																<div class="col-12 col-sm-12 py-1">
																	@switch($datoDP->estado_d_p)
																		@case(0)
																			<!--Observaciones-->
																			<div class="row">
																				<!--eliminar F04-->
																				<div class="col-6 col-sm-6 col-md-2 py-1 colLlenar">
																					<form class="btn-eliminarDP-system" method="post" action="{{ route('eliminar_f042.index',[$dato->id_alumno,$dato->id_asesor_emp,$dato->id_proyecto,$dato->id_detalle]) }}">
																						@csrf
																						@foreach ($etapas['etapas'] as $datoE )
																							<input type="text" name="id_etapas_{{$datoE->numero}}" value="{{$datoE->id}}" class="id_d" >
																						@endforeach
																						<button type="submit" class="btn btn-outline-danger btnCancelar" >Eliminar</button>
																					</form>											
																				</div>
																				<!--Descargar F04-->
																				<div class="col-6 col-sm-6 col-md-1 py-1 colDescargar text-centerr">
																					<a href="{{ route('descarga_cd_estancia_f04.index',[2]) }}">
																						<button type="button" class="btn btn-outline-info btnDescargar"><i class="zmdi zmdi-download"> Descargar</i></button>
																					</a>
																				</div>
																				<div class="col-12 col-sm-7">
																					<form class="btn-cancelarF4-system" action="{{ route('cancelar_f04_Estancia2.index',[$datoDP->id_documentos,$datoDP->name]) }}" method="POST" enctype="multipart/form-data">
																						@csrf
																						<div class="row">
																							<div class="col-12 col-sm-9 id_d" >
																								<input type="text" name="nombreAf04" id="" value="{{$datoDP->nombre_d_p}}" class="nombreDoc"style=''>
																							</div>
																							<div class="col-12 col-sm-9 py-1" >
																								<input type="text" value="{{$datoDP->nombre_d_p}}" class="nombreDoc" disabled>
																							</div>
																							<div class="col-12 col-sm-3 py-1">
																								<button type="submit" class="btn btn-outline-danger btnCancelar" >Cancelar</button>
																							</div>
																						</div>
																						
																					</form>
																				</div>
																				<div class="col-12 col-sm-2">
																					<a href="{{ route('obsevaciones2_f04.index') }}">
																						<button type="submit" class="btn btn-outline-danger divObservacionf02" ><i class="zmdi zmdi-folder-person">  Observaciones</i> </button>
																					</a>	
																				</div>
																								
																			</div>																																					
																		@break
																	
																		@case(1)
																			<!--pendiente-->
																			<div class="row">
																				<!--eliminar F04-->
																				<div class="col-6 col-sm-6 col-md-2 p-1 colLlenar">
																					<form class="btn-eliminarDP-system" method="post" action="{{ route('eliminar_f042.index',[$dato->id_alumno,$dato->id_asesor_emp,$dato->id_proyecto,$dato->id_detalle]) }}">
																						@csrf
																						@foreach ($etapas['etapas'] as $datoE )
																							<input type="text" name="id_etapas_{{$datoE->numero}}" value="{{$datoE->id}}" class="id_d" >
																						@endforeach
																						<button type="submit" class="btn btn-outline-danger btnCancelar" >Eliminar</button>
																					</form>											
																				</div>
																				<!--Descargar F04-->
																				<div class="col-6 col-sm-6 col-md-1 p-1 colDescargar text-centerr">
																					<a href="{{ route('descarga_cd_estancia_f04.index',[2]) }}">
																						<button type="button" class="btn btn-outline-info btnDescargar"><i class="zmdi zmdi-download"> Descargar</i></button>
																					</a>
																				</div>
																				<div class="col-12 col-sm-7">
																					<form class="btn-cancelarF4-system" action="{{ route('cancelar_f04_Estancia2.index',[$datoDP->id_documentos,$datoDP->name]) }}" method="POST" enctype="multipart/form-data">
																						@csrf
																						<div class="row">
																							<div class="col-12 col-sm-9 px-3 py-1 id_d" >
																								<input type="text" name="nombreAf04" id="" value="{{$datoDP->nombre_d_p}}" class="nombreDoc"style=''>
																							</div>
																							<div class="col-12 col-sm-9 px-3 py-1" >
																								<input type="text" value="{{$datoDP->nombre_d_p}}" class="nombreDoc" disabled>
																							</div>
																							<div class="col-12 col-sm-3 px-3 py-1">
																								<button type="submit" class="btn btn-outline-danger btnCancelar" >Cancelar</button>
																							</div>
																						</div>																			
																					</form>
																				</div>
																				<div class="col-12 col-sm-2">
																					<div class="divPendientef02"><i class="zmdi zmdi-folder-person">  Pendiente</i>  </div>
																				</div>
																			</div>
																		@break
																		@case(2)
																		<!--aceptado-->
																				<div class="row">
																					<!--Descargar f04-->
																					<div class="col-12 col-sm-12 col-md-1 py-1 colDescargar text-centerr">
																						<a href="{{ route('descarga_cd_estancia_f04.index',[2]) }}">
																							<button type="button" class="btn btn-outline-info btnDescargar"><i class="zmdi zmdi-download"> Descargar</i></button>
																						</a>
																					</div>
																					<div class="col-0 col-md-2 py-1 colDescargar text-centerr">
																						
																					</div>
																					<div class="col-12 col-sm-7 px-3 py-1" >
																						<input type="text" value="{{$datoDP->nombre_d_p}}" class="nombreDoc" disabled>
																					</div>
																					<div class="col-12 col-sm-2 px-3 py-1" >
																						<div class="divAceptadof02"><i class="zmdi zmdi-check-circle-u">  Aceptado</i> </div>
																					</div>
																				</div>																			
																		@break
																		@default
																				<p>Error</p>
																	@endswitch
																</div>
															</div>
											@empty
												<div class="row">
													<!--eliminar F04-->
													<div class="col-6 col-sm-6 col-md-2 py-1 colLlenar">
														<form class="btn-eliminarDP-system" method="post" action="{{ route('eliminar_f042.index',[$dato->id_alumno,$dato->id_asesor_emp,$dato->id_proyecto,$dato->id_detalle]) }}">
															@csrf
															@foreach ($etapas['etapas'] as $datoE )
																<input type="text" name="id_etapas_{{$datoE->numero}}" value="{{$datoE->id}}" class="id_d" >
															@endforeach
															<button type="submit" class="btn btn-outline-danger btnCancelar" >Eliminar</button>
														</form>											
													</div>
													<!--Descargar F04-->
													<div class="col-6 col-sm-6 col-md-1 py-1 colDescargar text-centerr">
														<a href="{{ route('descarga_cd_estancia_f04.index',[2]) }}">
															<button type="button" class="btn btn-outline-info btnDescargar"><i class="zmdi zmdi-download"> Descargar</i></button>
														</a>
													</div>
													<div class="col-12 col-md-9 py-1">
														<!-- enviar cedula registro con datos-->
														@forelse ($documentos['documentos'] as $dato)														
															<form action="{{ route('actualizar_f04_estancia2.index',[auth()->user()->name,$datoD->name]) }}" method="post" enctype="multipart/form-data" >
																@csrf
																	<input type="text" class="id_d" value="{{$datoD->id_documentos}}" name="id_docf04">
																	<span class="btn  fileinput-button">
																		<i class="zmdi zmdi-file"></i>
																		<input type="file" class="archivo" name="f04">
																	</span>
																	<button type="submit" class="btn btn-outline-info btnSubir">Enviar</button>
															</form>
														@empty
														Error
														@endforelse	
													</div>
												</div>
											@endforelse	
									@empty
										<div class="row">
											<!--eliminar F04-->
											<div class="col-6 col-sm-6 col-md-2 py-1 colLlenar">
												<form class="btn-eliminarDP-system" method="post" action="{{ route('eliminar_f042.index',[$dato->id_alumno,$dato->id_asesor_emp,$dato->id_proyecto,$dato->id_detalle]) }}">
													@csrf
													@foreach ($etapas['etapas'] as $datoE )
														<input type="text" name="id_etapas_{{$datoE->numero}}" value="{{$datoE->id}}" class="id_d" >
													@endforeach
													<button type="submit" class="btn btn-outline-danger btnCancelar" >Eliminar</button>
												</form>											
											</div>
											<!--Descargar F04-->
											<div class="col-6 col-sm-6 col-md-1 py-1 colDescargar text-centerr">
												<a href="{{ route('descarga_cd_estancia_f04.index',[2]) }}">
													<button type="button" class="btn btn-outline-info btnDescargar"><i class="zmdi zmdi-download"> Descargar</i></button>
												</a>
											</div>
											<div class="col-12 col-md-9 py-1">
												<!-- enviar cedula registro vacio-->
												<form action="{{ route('subir_f04_estancia2.index',[auth()->user()->name,auth()->user()->name]) }}" method="post" enctype="multipart/form-data" >
													@csrf
													<span class="btn  fileinput-button">
														<i class="zmdi zmdi-file"></i>
														<input type="file" class="archivo" name="f04">
													</span>
													<button type="submit" class="btn btn-outline-info btnSubir">Enviar</button>
												</form>
											</div>
										</div>
									@endforelse			
								</div>			
							@empty
								<!--llenar formmulario  f04-->
								<div class="col-6 col-sm-6 col-md-2 col-lg-2 col-xl-2 p-0 colLlenar">
									<a href="{{ route('f04Formulario2.index') }}">
										<button type="button" class="btn btn-outline-dark btnLlenarDp" >Llenar Definición de Proyecto</button>
									</a>
								</div>
								<div class="col-12 col-sm-12 col-md-12 col-lg-8 colArchivo">
											
								</div>
							@endforelse
							<!--ERROR f04-->
							@error('f04')
								<p class="border border-danger rounded-md bg-red-200 w-full text-red-600 p-2 my-2">{{ $message }}</p>
							@enderror			
						</div>
					</li>
					<!--F05-->
					<li class="list-group-item d-flex justify-content-between align-items-start" style="border: 1px solid rgb(210, 210, 210);">
						<div class="row lista">
							<div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2">
								<div class="ms-2 me-auto">
									<div class="fw-bold">F05</div>
									8.- Carta de Liberación
								</div>
							</div>
							<!--Descargar f05-->
							<div class="col-6 col-sm-12 col-md-3 col-lg-2 col-xl-2 p-1 colDescargar text-left">
								<a href="{{ route('descarga_cd_estancia_f05.index') }}">
									<button type="button" class="btn btn-outline-info btnDescargar"><i class="zmdi zmdi-download"> Descargar</i></button>
								</a>
							</div>
							<div class="col-6 col-sm-6 col-md-5 col-lg-3 col-xl-1 p-1 colLlenar  ">
												
							</div>
							<!--enviar doc f05-->
							<div class="col-12 col-sm-12 col-md-12 col-lg-7 p-1 colArchivo">
								@forelse ($documentos['documentos'] as $datoD)
										@forelse ($carta_aceptacion['carta_liberacion'] as $datoCL)
														<div class="row">
															<div class="col-12 col-sm-12 py-1">
																@switch($datoCL->estado_c_l)
																	@case(0)
																		<!--Observaciones-->
																		<div class="row">
																			<div class="col-12 col-sm-9">
																				<form class="btn-cancelarF5-system" action="{{ route('cancelar_f05_Estancia2.index',[$datoCL->id_documentos,$datoCL->name]) }}" method="POST" enctype="multipart/form-data">
																					@csrf
																					<div class="row">
																						<div class="col-12 col-sm-9 id_d" >
																							<input type="text" name="nombreAf05" id="" value="{{$datoCL->nombre_c_l}}" class="nombreDoc"style=''>
																						</div>
																						<div class="col-12 col-sm-9 py-1" >
																							<input type="text" value="{{$datoCL->nombre_c_l}}" class="nombreDoc" disabled>
																						</div>
																						<div class="col-12 col-sm-3 py-1">
																							<button type="submit" class="btn btn-outline-danger btnCancelar" >Cancelar</button>
																						</div>
																					</div>
																					
																				</form>
																			</div>
																			<div class="col-12 col-sm-3">
																				<a href="{{ route('obsevaciones2_f05.index') }}">
																					<button type="submit" class="btn btn-outline-danger divObservacionf02" ><i class="zmdi zmdi-folder-person">  Observaciones</i> </button>
																				</a>	
																			</div>
																							
																		</div>																																					
																	@break
																
																	@case(1)
																	<!--pendiente-->
																	<div class="row">
																		<div class="col-12 col-sm-9">
																			<form class="btn-cancelarF5-system" action="{{ route('cancelar_f05_Estancia2.index',[$datoCL->id_documentos,$datoCL->name]) }}" method="POST" enctype="multipart/form-data">
																				@csrf
																				<div class="row">
																					<div class="col-12 col-sm-9 px-3 py-1 id_d" >
																						<input type="text" name="nombreAf05" id="" value="{{$datoCL->nombre_c_l}}" class="nombreDoc"style=''>
																					</div>
																					<div class="col-12 col-sm-9 px-3 py-1" >
																						<input type="text" value="{{$datoCL->nombre_c_l}}" class="nombreDoc" disabled>
																					</div>
																					<div class="col-12 col-sm-3 px-3 py-1">
																						<button type="submit" class="btn btn-outline-danger btnCancelar" >Cancelar</button>
																					</div>
																				</div>																			
																			</form>
																		</div>
																		<div class="col-12 col-sm-3">
																			<div class="divPendientef02"><i class="zmdi zmdi-folder-person">  Pendiente</i>  </div>
																	@break
																	@case(2)
																	<!--aceptado-->
																			<div class="row">
																				<div class="col-12 col-sm-9 px-3 py-1" >
																					<input type="text" value="{{$datoCL->nombre_c_l}}" class="nombreDoc" disabled>
																				</div>
																				<div class="col-12 col-sm-3 px-3 py-1" >
																					<div class="divAceptadof02"><i class="zmdi zmdi-check-circle-u">  Aceptado</i> </div>
																				</div>
																			</div>																			
																	@break
																	@default
																			<p>Error</p>
																@endswitch
															</div>
														</div>
										@empty
										<!-- enviar cedula registro con datos-->
											@forelse ($documentos['documentos'] as $dato)														
												<form action="{{ route('actualizar_f05_estancia2.index',[auth()->user()->name,$datoD->name]) }}" method="post" enctype="multipart/form-data" >
													@csrf
														<input type="text" class="id_d" value="{{$datoD->id_documentos}}" name="id_docf05">
														<span class="btn  fileinput-button">
															<i class="zmdi zmdi-file"></i>
															<input type="file" class="archivo" name="f05">
														</span>
														<button type="submit" class="btn btn-outline-info btnSubir">Enviar</button>
												</form>
												
											@empty
												Error
											@endforelse	
										@endforelse	
								@empty
								<!-- enviar cedula registro vacio-->
									<form action="{{ route('subir_f05_estancia2.index',[auth()->user()->name,auth()->user()->name]) }}" method="post" enctype="multipart/form-data" >
										@csrf
										<span class="btn  fileinput-button">
											<i class="zmdi zmdi-file"></i>
											<input type="file" class="archivo" name="f05">
										</span>
										<button type="submit" class="btn btn-outline-info btnSubir">Enviar</button>
									</form>
								@endforelse			
							</div>	
							<!--error f05-->			
							@error('f05')
								<p class="border border-danger rounded-md bg-red-200 w-full text-red-600 p-2 my-2">{{ $message }}</p>
							@enderror													
										
						</div>
					</li>
					<!--Formato reporte de evaluacion-->
					<li class="list-group-item d-flex justify-content-between align-items-start" style="border: 1px solid rgb(210, 210, 210);">
						<div class="row lista">
							<div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2">
								<div class="ms-2 me-auto">
									Reporte de evaluacion de estancia
								</div>
							</div>
						
								
							<div class="col-6 col-sm-12 col-md-3 col-lg-2 col-xl-2 p-1 colDescargar text-left">
								<a href="{{ route('descarga_reporte_evaluacion_estancia.index') }}">
									<button type="button" class="btn btn-outline-info btnDescargar"><i class="zmdi zmdi-download"> Descargar</i></button>
								</a>
							</div>
							<div class="col-6 col-sm-6 col-md-5 col-lg-3 col-xl-1 p-1 colLlenar  ">
												
							</div>
							<div class="col-12 col-sm-12 col-md-12 col-lg-7 p-1 colArchivo">
												
							</div>	
						</div>
					</li>
				</ol>
				
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
<style>
	.id_d{
		visibility: hidden;
		display: none;
		width:10px;
	}
	@media (max-width: 406px){
	
		.borde{
			border: 1px solid darkgrey;
		}
	}
</style>