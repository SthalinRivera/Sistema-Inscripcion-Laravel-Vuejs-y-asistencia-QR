<template>
    <div class="card mb-5 mb-xl-8">
		<!--begin::Header-->
		<div class="card-header border-0 pt-5">
			<h3 class="card-title align-items-start flex-column">
				<span class="card-label fw-bold fs-3 mb-1">Fichas de inscripción</span>
				<span class="text-muted mt-1 fw-semibold fs-7">Inscribe postulantes</span>
			</h3>
		</div>
		<!--end::Header-->
		<!--begin::Body-->
		<div class="card-body py-3">
            <div class="input-group mb-5" style="display: block">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                        <label>
                            Carreras
                        </label>
                        <select class="form-select" @change="buscar(1)" aria-label="Select example" v-model.number="filtros.carrera">
                            <option value="">TODOS</option>
                            <option value="1">
                                Administración
                            </option>
                            <option value="2">
                                Contabilidad
                            </option>
                            <option value="3">
                                Administración de Turismo y Hotelería
                            </option>
                            <option value="4">
                                Ingenierias de Sistemas
                            </option>
                            <option value="5">
                                Agronomia
                            </option>
                        </select> 
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                        <label>
                            Modalidades
                        </label>
                        <select class="form-select" @change="buscar(1)" aria-label="Select example" v-model.number="filtros.modalidad">
                            <option value="">TODOS</option>
                            <option value="1">Ordinario</option>
                            <option value="2">
                                Primeros Puestos
                            </option>
                            <option value="3">
                                Graduados y Titulados
                            </option>
                            <option value="10">
                                Traslado Interno
                            </option>
                            <option value="4">
                                Traslado Externo
                            </option>
                            <option value="5">
                                Ley 29973 Personas con Discapacidad
                            </option>
                            <option value="6">
                                Ley 28036 Deportitas Calificados
                            </option>
                            <option value="7">
                                Ley 27277 Victimas del Terrorismo
                            </option>
                            <option value="8">
                                Centro PRE (Ingresantes).
                            </option>
                            <option value="11">
                                Quinto Secundaria
                            </option>
                        </select> 
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <label>
                            Buscar
                        </label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" v-on:keyup.enter="buscar(2)" placeholder="Buscar por nombres o DNI" v-model="filtros.dato" aria-describedby="button-addon2">
                            <button class="btn btn-primary"  @click.prevent="buscar(2)" type="button" id="button-addon2">Buscar</button>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                        <label>
                            Estados
                        </label>
                        <select class="form-select" @change="buscar(1)" aria-label="Select example" v-model.number="filtros.estado">
                            <option value="">TODOS</option>
                            <option value="0">SIN ENVIAR</option> 
                            <option value="1">PENDIENTE</option> 
                            <option value="2">RECHAZADO</option> 
                            <option value="3">VALIDADO</option>
                        </select> 
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                        <label>
                            RESETEAR
                        </label> 
                        <div class="m-demo-icon__preview">
                            <i @click="buscar(0)" class="bi bi-arrow-repeat fs-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!--begin::Table container-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table align-middle gs-0 gy-4">
                        <!--begin::Table head-->
                        <thead>
                            <tr class="fw-bold text-muted bg-light">
                                <th class="ps-4 rounded-start">N°</th>
                                <th>MODALIDAD</th>
                                <th>CARRERA</th>
                                <th>CODIGO</th>
                                <th>DNI</th>
                                <th>APELLIDOS</th>
                                <th>NOMBRES</th>
                                <th>FECHA</th>
                                <th>NÚMERO</th>
                                <th>DOCUMENTOS</th>
                                <th>ESTADO</th>
                                <th class="max-w-125px text-center rounded-end" style="width: 200px;">ACCION</th>
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody>
                            <tr v-if="botonCargando">
                                <td colspan="12" class="text-center">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </td>
                            </tr>
                            <tr v-else v-for="(dato, index) in datos" :index="index" :key="dato.id"> 
                                <td class="ps-4">
                                   {{index+1}} 
                                </td>
                                <td>
                                    {{dato.modalidad}}
                                </td>
                                <td>
                                    {{dato.carrera}}
                                </td>
                                <td>
                                    {{dato.codigo_p}}
                                </td>
                                <td>
                                    {{dato.numero_documento}}
                                </td>
                                <td>
                                    {{dato.apellidos}}
                                </td>
                                <td>
                                    {{dato.dp_nombre}}
                                </td>
                                <td>
                                    {{dato.fecha_solicitado}}
                                </td>
                                <!-- <td>
                                    <a :href="'https://wa.me/51' + dato.da_numero_celular" target="_blank">
                                    <i class="bi bi-whatsapp text-success"></i>
                                    {{dato.da_numero_celular}}
                                    </a>
                                </td> -->
                                <td>
                                    <!-- Mensaje personalizado para postulantes examen ordinario sin codigo -->
                                    <template v-if="dato.modalidad == 'ORDINARIO' && dato.codigo_p == null">
                                        <a :href="'https://wa.me/51' + dato.da_numero_celular" target="_blank">
                                        <i class="bi bi-whatsapp text-success"></i>
                                        {{dato.da_numero_celular}}
                                        </a>
                                    </template>
                                    <!-- Mensaje personalizado para postulantes examen ordinario con codigo -->
                                    <template v-else-if="dato.modalidad == 'ORDINARIO' && dato.codigo_p != null">
                                        <a :href="'https://wa.me/51' + dato.da_numero_celular" target="_blank">
                                        <i class="bi bi-whatsapp text-success"></i>
                                        {{dato.da_numero_celular}}
                                        </a>
                                    </template>
                                    <!-- Mensaje personalizado para postulantes examen extraordinario sin codigo -->
                                    <template v-else-if="(dato.modalidad == 'PRIMEROS PUESTOS' || dato.modalidad == 'GRADUADOS Y TITULADOS'|| dato.modalidad == 'TRASLADO INTERNO'|| dato.modalidad == 'TRASLADO EXTERNO'|| dato.modalidad == 'DISCAPACIDAD'|| dato.modalidad == 'VICTIMAS DE TERRORISMO') && dato.codigo_p == null">
                                        <a :href="'https://wa.me/51' + dato.da_numero_celular" target="_blank">
                                        <i class="bi bi-whatsapp text-success"></i>
                                        {{dato.da_numero_celular}}
                                        </a>
                                    </template>
                                    <!-- Mensaje personalizado para postulantes examen extraordinario con codigo -->
                                    <template v-else-if="(dato.modalidad == 'PRIMEROS PUESTOS' || dato.modalidad == 'GRADUADOS Y TITULADOS'|| dato.modalidad == 'TRASLADO INTERNO'|| dato.modalidad == 'TRASLADO EXTERNO'|| dato.modalidad == 'DISCAPACIDAD'|| dato.modalidad == 'VICTIMAS DE TERRORISMO') && dato.codigo_p != null">
                                        <a :href="'https://api.whatsapp.com/send?phone=+51'+dato.da_numero_celular+'&text=UNIVERSIDAD%20NACIONAL%20DE%20CAÑETE%0D%0ASaludos%20estimado%20%28a%29%20🙋🏻%E2%80%8D♂%0D%0A%0D%0ALe%20escribo%20de%20la%20oficina%20de%20Admisión%20del%20PROCESO%20DE%20ADMISIÓN%202024%2C%20para%20recordarles%20el%20día%20del%20EXAMEN%20EXTRAORDINARIO%20es%20el%2028%20de%20ENERO%0D%0A%0D%0AHORARIO%20DE%20INGRESO%20de%20los%20postulantes%3A%207%3A00%20a.m.%20a%208%3A00%20a.m.%0D%0A%0D%0ALUGAR%3A%20San%20Vicente%20-%20Casa%20de%20la%20Cultura-%20%28Al%20costado%20del%20Coliseo%20Lolo%20Fernández%20frente%20a%20Inkamay%29%20%0D%0A%0D%0ALLEVAR%20ÚNICAMENTE%3A%20📝%0D%0A%0D%0A✅%20Carné%20de%20postulante%20%2826%20de%20Enero%20-%206%20pm%20se%20les%20habilitará%20para%20que%20puedan%20descargar%29%20enlace.-%20https%3A%2F%2Fadmision.undc.edu.pe%2Finscripciones%2Fpublic%2Flogin%0D%0AConfirmar%20la%20descarga%20del%20carné%20por%20este%20medio%20%0D%0A%28Llevar%20impreso%20el%20día%20del%20examen-la%20firma%20y%20colocación%20dactilar%20se%20realizará%20en%20el%20aula%20asignada%29%0D%0A✅%20DNI%20VIGENTE%0D%0A%20%20%20%20%20%20%20%20%2A%20%28Si%20esta%20Caducado%2C%20en%20trámite%20adjuntar%20-%20Ficha%20RENIEC%29%0D%0A%20%20%20%20%20%20%20%20%2A%20Si%20se%20encuentra%20extraviado%20llevar%20C4%0D%0A✅%20Lápiz%202B%0D%0A✅%20Borrador%0D%0A✅%20Tajador%0D%0A%0D%0APROHIBIDO%20LLEVAR%3A%20🙅🏻%0D%0A%0D%0A🚫%20Gorra%0D%0A🚫%20Capucha%20%28vestimenta%20que%20dificulte%20la%20identificación%29%0D%0A🚫%20Celular%0D%0A🚫%20Calculadora%20y%20cualquier%20equipo%20electrónico' " target="_blank">
                                        <i class="bi bi-whatsapp text-success"></i>
                                        {{dato.da_numero_celular}}
                                        </a>


                                    </template>
                                    <!-- Mensaje personalizado para ingresantes cepre validados -->
                                    <template v-else-if="dato.modalidad == 'CEPRE' && dato.codigo_p == null && dato.id_estado_revision == 3">
                                        <a :href="'https://wa.me/51' + dato.da_numero_celular" target="_blank">
                                        <i class="bi bi-whatsapp text-success"></i>
                                        {{dato.da_numero_celular}}
                                        </a>
                                    </template>
                                    <!-- Mensaje personalizado para ingresantes cepre sin validar -->
                                    <template v-else-if="dato.modalidad == 'CEPRE' && dato.codigo_p == null && (dato.id_estado_revision == 0||dato.id_estado_revision == 1||dato.id_estado_revision == 2)">
                                        <a :href="'https://wa.me/51' + dato.da_numero_celular" target="_blank">
                                        <i class="bi bi-whatsapp text-success"></i>
                                        {{dato.da_numero_celular}}
                                        </a>
                                    </template>
                                    <!-- Mensaje personalizado para postulantes examen quinto de secundaria con codigo-->
                                    <template v-else-if="dato.modalidad == 'CEPRE' && dato.codigo_p == null && (dato.id_estado_revision == 0||dato.id_estado_revision == 1||dato.id_estado_revision == 2)">
                                        <a :href="'https://wa.me/51' + dato.da_numero_celular" target="_blank">
                                        <i class="bi bi-whatsapp text-success"></i>
                                        {{dato.da_numero_celular}}
                                        </a>
                                    </template>
                                    <!-- Mensaje personalizado para postulantes examen quinto de secundaria sin codigo-->
                                    <template v-else-if="dato.modalidad == 'CEPRE' && dato.codigo_p == null && (dato.id_estado_revision == 0||dato.id_estado_revision == 1||dato.id_estado_revision == 2)">
                                        <a :href="'https://wa.me/51' + dato.da_numero_celular" target="_blank">
                                        <i class="bi bi-whatsapp text-success"></i>
                                        {{dato.da_numero_celular}}
                                        </a>
                                    </template>
                                </td>

                                <td>
                                    <span class="badge badge-circle badge-secondary">{{dato.estado_sin_enviar}}</span>
                                    <span class="badge badge-circle badge-warning">{{dato.estado_pendiente}}</span>
                                    <span class="badge badge-circle badge-danger">{{dato.estado_rechazado}}</span>
                                    <span class="badge badge-circle badge-success">{{dato.estado_validado}}</span>
                                </td>
                                <td>
                                    <span v-if="dato.id_estado_revision==0" class="badge badge-circle badge-secondary"></span>
                                    <span v-if="dato.id_estado_revision==1" class="badge badge-circle badge-warning"></span>
                                    <span v-if="dato.id_estado_revision==2" class="badge badge-circle badge-danger"></span>
                                    <span v-if="dato.id_estado_revision==3" class="badge badge-circle badge-success"></span>
                                </td>
                                <!-- <td class="text-center">
                                    <div>
                                        <button @click.prevent="ver(dato.id)" type="submit" class='btn btn-primary' data-bs-toggle="modal" data-bs-target="#kt_modal_1">
                                            VER
                                        </button>
                                    </div>
                                </td> -->
                                <td class="text-center">
                                    <a v-if="(is('Administrador') || is('Asesor') || is('Colaborador') && dato.id_estado_revision!=3)" href="#" @click.prevent="editar(dato.id)" data-bs-toggle="modal" data-bs-target="#kt_modal_2" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                        <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                        <span class="svg-icon svg-icon-3"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor"></path>
                                        <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor"></path>
                                        </svg>
                                        </span>
                                        <!--end::Svg Icon-->                                
                                    </a>
                                    <a href="#" @click.prevent="ver(dato.id)" data-bs-toggle="modal" data-bs-target="#kt_modal_1" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                        <span class="svg-icon svg-icon-3"><i class="bi bi-eye fs-2"></i></span>
                                        <!--end::Svg Icon-->
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                        <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
        <!--end::Table container-->
		<!--begin::Body-->
		</div>
        <div class="modal fade" tabindex="-1" id="kt_modal_1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">INSCRIBIR</h3>
                        <span v-if="verRegistro.id_estado_revision==3" class="badge badge-success badge-lg">Inscrito</span>
                        <span v-if="verRegistro.id_estado_revision==2" class="badge badge-danger badge-lg">Rechazado</span>
                        <span v-if="verRegistro.id_estado_revision==1" class="badge badge-warning badge-lg">Pendiente</span>
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <span class="svg-icon svg-icon-1"></span>
                        </div>
                    </div>

                    <div class="modal-body">
                        <h4>
                            Datos del usuario
                        </h4>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="recipient-name" class="form-control-label">
                                    NOMBRE
                                </label>
                                <input type="text" v-model="verRegistro.dp_nombre" class="form-control" disabled>
                            </div>
                            <div class="col-md-5">
                                <label for="recipient-name" class="form-control-label">
                                    APELLIDOS
                                </label>
                                <input type="text" v-model="verRegistro.apellidos" class="form-control" disabled>
                            </div>
                            <div class="col-md-3">
                                <label for="recipient-name" class="form-control-label">
                                    CÓDIGO
                                </label>
                                <input type="text" v-model="verRegistro.codigo_p" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="recipient-name" class="form-control-label">
                                    DNI
                                </label>
                                <input type="text" v-model="verRegistro.numero_documento" class="form-control" disabled>
                            </div>
                            <div class="col-md-5">
                                <label for="recipient-name" class="form-control-label">
                                    CORREO
                                </label>
                                <input type="text" v-model="verRegistro.da_email" class="form-control" disabled>
                            </div>
                            <div class="col-md-3">
                                <label for="recipient-name" class="form-control-label">
                                    NÚMERO
                                </label>
                                <!-- <input type="text" v-model="verRegistro.da_numero_celular" class="form-control" disabled> -->
                                <span class="form-control" disabled>
                                    <a v-if="verRegistro.id_estado_revision==3" :href="'https://api.whatsapp.com/send?phone=51'+verRegistro.da_numero_celular+'&text=UNIVERSIDAD%20NACIONAL%20DE%20CA%C3%91ETE%0D%0ASaludos%20estimado%20%28a%29%20%F0%9F%99%8B%F0%9F%8F%BB%E2%80%8D%E2%99%82%0D%0A%0D%0ALe%20escribo%20de%20la%20oficina%20de%20Admisi%C3%B3n%20del%20PROCESO%20DE%20ADMISI%C3%93N%202024%2C%20para%20recordarles%20el%20d%C3%ADa%20del%20EXAMEN%20DE%20ADMISI%C3%93N%20es%20el%2026%20DE%20NOVIEMBRE%20PARA%20LOS%20ESTUDIANTES%20DE%205TO%20DE%20SECUNDARIA%0D%0A%0D%0AHORARIO%20DE%20INGRESO%20de%20los%20postulantes%3A%207%3A00%20a.m.%20a%208%3A30%20a.m.%0D%0A%0D%0ALUGAR%3A%20San%20Vicente%20-%20Casa%20de%20la%20Cultura-%20%28Al%20costado%20del%20Coliseo%20Lolo%20Fern%C3%A1ndez%20frente%20a%20Inkamay%29%20%0D%0A%0D%0ALLEVAR%20%C3%9ANICAMENTE%3A%20%F0%9F%93%9D%0D%0A%0D%0A%E2%9C%85%20Carn%C3%A9%20de%20postulante%20%28Hoy%2024%20de%20Noviembre%20-%206%20pm%20se%20les%20habilitar%C3%A1%20para%20que%20puedan%20descargar%29%20enlace.-%20https%3A%2F%2Fadmision.undc.edu.pe%2Finscripciones%2Fpublic%2Flogin%0D%0AConfirmar%20la%20descarga%20del%20carn%C3%A9%20por%20este%20medio%20%0D%0A%28Llevar%20impreso%20el%20d%C3%ADa%20del%20examen-la%20firma%20y%20colocaci%C3%B3n%20dactilar%20se%20realizar%C3%A1%20en%20el%20aula%20asignada%29%0D%0A%E2%9C%85%20DNI%20VIGENTE%0D%0A%20%20%20%20%20%20%20%20%2A%20%28Si%20esta%20Caducado%2C%20en%20tr%C3%A1mite%20adjuntar%20-%20Ficha%20RENIEC%29%0D%0A%20%20%20%20%20%20%20%20%2A%20Si%20se%20encuentra%20extraviado%20llevar%20C4%0D%0A%E2%9C%85%20L%C3%A1piz%202B%0D%0A%E2%9C%85%20Borrador%0D%0A%E2%9C%85%20Tajador%0D%0A%0D%0APROHIBIDO%20LLEVAR%3A%20%F0%9F%99%85%F0%9F%8F%BB%0D%0A%0D%0A%F0%9F%9A%AB%20Gorra%0D%0A%F0%9F%9A%AB%20Capucha%20%28vestimenta%20que%20dificulte%20la%20identificaci%C3%B3n%29%0D%0A%F0%9F%9A%AB%20Celular%0D%0A%F0%9F%9A%AB%20Calculadora%20y%20cualquier%20equipo%20electr%C3%B3nico'" target="_blank">
                                        <i class="bi bi-whatsapp text-success"></i>
                                        {{verRegistro.da_numero_celular}}
                                    </a>
                                    <a v-else :href="'https://wa.me/51' + verRegistro.da_numero_celular" target="_blank">
                                        <i class="bi bi-whatsapp text-success"></i>
                                        {{verRegistro.da_numero_celular}}
                                    </a>
                                </span>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="recipient-name" class="form-control-label">
                                    APODERADO
                                </label>
                                <input type="text" v-model="verRegistro.df_nombres_apoderado" class="form-control" disabled>
                            </div>
                            <div class="col-md-3">
                                <label for="recipient-name" class="form-control-label">
                                    DNI APODERADO
                                </label>
                                <input type="text" v-model="verRegistro.df_dni_apoderado" class="form-control" disabled>
                            </div>
                            <div class="col-md-3">
                                <label for="recipient-name" class="form-control-label">
                                    CELULAR APODERADO
                                </label>
                                <!-- <input type="text" v-model="verRegistro.df_celular_apoderado" class="form-control" disabled> -->
                                <span class="form-control" disabled>
                                    <a v-if="verRegistro.id_estado_revision==3" :href="'https://api.whatsapp.com/send?phone=51'+verRegistro.df_celular_apoderado+'&text=UNIVERSIDAD%20NACIONAL%20DE%20CA%C3%91ETE%0D%0ASaludos%20estimado%20%28a%29%20%F0%9F%99%8B%F0%9F%8F%BB%E2%80%8D%E2%99%82%0D%0A%0D%0ALe%20escribo%20de%20la%20oficina%20de%20Admisi%C3%B3n%20del%20PROCESO%20DE%20ADMISI%C3%93N%202024%2C%20para%20recordarles%20el%20d%C3%ADa%20del%20EXAMEN%20DE%20ADMISI%C3%93N%20es%20el%2026%20DE%20NOVIEMBRE%20PARA%20LOS%20ESTUDIANTES%20DE%205TO%20DE%20SECUNDARIA%0D%0A%0D%0AHORARIO%20DE%20INGRESO%20de%20los%20postulantes%3A%207%3A00%20a.m.%20a%208%3A30%20a.m.%0D%0A%0D%0ALUGAR%3A%20San%20Vicente%20-%20Casa%20de%20la%20Cultura-%20%28Al%20costado%20del%20Coliseo%20Lolo%20Fern%C3%A1ndez%20frente%20a%20Inkamay%29%20%0D%0A%0D%0ALLEVAR%20%C3%9ANICAMENTE%3A%20%F0%9F%93%9D%0D%0A%0D%0A%E2%9C%85%20Carn%C3%A9%20de%20postulante%20%28Hoy%2024%20de%20Noviembre%20-%206%20pm%20se%20les%20habilitar%C3%A1%20para%20que%20puedan%20descargar%29%20enlace.-%20https%3A%2F%2Fadmision.undc.edu.pe%2Finscripciones%2Fpublic%2Flogin%0D%0AConfirmar%20la%20descarga%20del%20carn%C3%A9%20por%20este%20medio%20%0D%0A%28Llevar%20impreso%20el%20d%C3%ADa%20del%20examen-la%20firma%20y%20colocaci%C3%B3n%20dactilar%20se%20realizar%C3%A1%20en%20el%20aula%20asignada%29%0D%0A%E2%9C%85%20DNI%20VIGENTE%0D%0A%20%20%20%20%20%20%20%20%2A%20%28Si%20esta%20Caducado%2C%20en%20tr%C3%A1mite%20adjuntar%20-%20Ficha%20RENIEC%29%0D%0A%20%20%20%20%20%20%20%20%2A%20Si%20se%20encuentra%20extraviado%20llevar%20C4%0D%0A%E2%9C%85%20L%C3%A1piz%202B%0D%0A%E2%9C%85%20Borrador%0D%0A%E2%9C%85%20Tajador%0D%0A%0D%0APROHIBIDO%20LLEVAR%3A%20%F0%9F%99%85%F0%9F%8F%BB%0D%0A%0D%0A%F0%9F%9A%AB%20Gorra%0D%0A%F0%9F%9A%AB%20Capucha%20%28vestimenta%20que%20dificulte%20la%20identificaci%C3%B3n%29%0D%0A%F0%9F%9A%AB%20Celular%0D%0A%F0%9F%9A%AB%20Calculadora%20y%20cualquier%20equipo%20electr%C3%B3nico'" target="_blank">
                                    <i class="bi bi-whatsapp text-success"></i>
                                    {{verRegistro.df_celular_apoderado}}
                                    </a>
                                    <a v-else :href="'https://wa.me/51' + verRegistro.df_celular_apoderado" target="_blank">
                                    <i class="bi bi-whatsapp text-success"></i>
                                    {{verRegistro.df_celular_apoderado}}
                                    </a>
                                </span>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div v-if="verRegistro.mcp_id_modalidad==1 || verRegistro.mcp_id_modalidad==2 || verRegistro.mcp_id_modalidad==5 || verRegistro.mcp_id_modalidad==6" class="col-md-12">
                                <label for="recipient-name" class="form-control-label">
                                    COLEGIO
                                </label>
                                <input type="text" v-model="verRegistro.colegio_gestion" class="form-control" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="recipient-name" class="form-control-label">
                                    MODALIDAD
                                </label>
                                <input type="text" v-model="verRegistro.modalidad" class="form-control" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="recipient-name" class="form-control-label">
                                    CARRERA
                                </label>
                                <input type="text" v-model="verRegistro.carrera" class="form-control" disabled>
                            </div>
                            <div v-if="verRegistro.mcp_id_modalidad==3 || verRegistro.mcp_id_modalidad==4 || verRegistro.mcp_id_modalidad==9" class="col-md-6">
                                <label for="recipient-name" class="form-control-label">
                                    UNIVERSIDAD PROCEDENCIA
                                </label>
                                <input type="text" v-model="verRegistro.de_nom_uni" class="form-control" disabled>
                            </div>
                            <div v-if="verRegistro.mcp_id_modalidad==3 || verRegistro.mcp_id_modalidad==4 || verRegistro.mcp_id_modalidad==9" class="col-md-6">
                                <label for="recipient-name" class="form-control-label">
                                    CREDITOS APROBADOS
                                </label>
                                <input type="text" v-model="verRegistro.de_cred_uni" class="form-control" disabled>
                            </div>
                            <div v-if="verRegistro.mcp_id_modalidad==7" class="col-md-6">
                                <label for="recipient-name" class="form-control-label">
                                    CÓDIGO RUV
                                </label>
                                <input type="text" v-model="verRegistro.de_cod_ruv" class="form-control" disabled>
                            </div>
                        </div>
                        <br>
                        <h5>
                            Formatos
                        </h5>
                        <div class="row">
                            <div class="col-6 col-md-4" align="center">
                                <label for="recipient-name" class="form-control-label">
                                    FICHAS DE INSCRIPCIÓN
                                </label>
                                <br>
                                <a v-bind:href="$parent.NombreRuta + '/inscripcion/ficha?ver=si&i=' + encodeid(verRegistro.id)" target="_blank"><i class="bi bi-files fs-2hx"></i>
                                </a>
                                <!-- <input type="text" v-model="verRegistro.modalidad" class="form-control" id="recipient-name" disabled> -->
                            </div>
                            <!-- <div class="col-6 col-md-4" align="center">
                                <label for="recipient-name" class="form-control-label">
                                    DJ REQUISITO DE INGRESANTE
                                </label>
                                <br>
                                <a v-bind:href="'/inscripcion/dj_ingreso?&i=' + encodeid(verRegistro.id)" target="_blank"><i class="bi bi-file-text fs-2hx"></i>
                                </a>
                            </div> -->
                            <div class="col-6 col-md-4" align="center">
                                <label for="recipient-name" class="form-control-label">
                                    EJEMPLO CARNÉ DE POSTULANTE
                                </label>
                                <br>
                                <a v-bind:href="$parent.NombreRuta + '/inscripcion/carne?ver=si&d=' + encodeid(verRegistro.id)" target="_blank"><i class="bi bi-person-video2 fs-2hx"></i>
                                </a>
                            </div>
                        </div>
                        <br>
                        <h5>
                            Fechas
                        </h5>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="recipient-name" class="form-control-label">
                                    REGISTRO USUARIO
                                </label>
                                <input type="text" v-model="verRegistro.usuario_registro" class="form-control" disabled>
                            </div>
                            <div class="col-md-3">
                                <label for="recipient-name" class="form-control-label">
                                    REGISTRO DE FICHA
                                </label>
                                <input type="text" v-model="verRegistro.created_at" class="form-control" disabled>
                            </div>
                            <div class="col-md-3">
                                <label for="recipient-name" class="form-control-label">
                                    SOLICITUD REVISIÓN
                                </label>
                                <input type="text" v-model="verRegistro.fecha_solicitado" class="form-control" disabled>
                            </div>
                            <div class="col-md-3">
                                <label v-if="verRegistro.id_estado_revision==3" for="recipient-name" class="form-control-label">
                                    DE INSCRIPCIÓN
                                </label>
                                <label v-else for="recipient-name" class="form-control-label">
                                    DE REVISIÓN
                                </label>
                                <input type="text" v-model="verRegistro.fecha_revisado" class="form-control" disabled>
                            </div>
                            <div class="col-md-6 mt-5">
                                <label for="recipient-name" class="form-control">
                                    TIPO INSCRIPCIÓN: 
                                    <span v-if="verRegistro.extemporaneo==1" class="badge badge-danger badge">EXTEMPORÁNEA</span>
                                    <span v-else class="badge badge-success badge">REGULAR</span>
                                </label>
                            </div>
                            <div class="col-md-6 mt-5">
                                <label for="recipient-name" class="form-control">
                                    POSTULACIÓN: 
                                    <span v-if="verRegistro.postulacion==1" class="badge badge-success badge">PRIMERA</span>
                                    <span v-else class="badge badge-info badge">SEGUNDA</span>
                                </label>
                            </div>
                        </div>
                        <br>
                        <h5>
                            Documentos
                        </h5>
                        <div class="m-section">
                            <div class="m-section__content table-responsive">
                                <table class="table m-table table-responsive">
                                    <thead class="thead-default">
                                        <tr>
                                            <th>
                                                #
                                            </th>
                                            <th>
                                                NOMBRE
                                            </th>
                                            <th>
                                                FECHA
                                            </th>
                                            <th>
                                                VER
                                            </th>
                                            <th style="text-align: center;">
                                                VALIDAR
                                            </th>
                                            <th class="mw-25" style="text-align: center; width: 25%;">
                                                RECHAZAR
                                            </th>
                                            <th>
                                                MSG
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in documentos" :key="item.id">
                                            <th scope="row">
                                                {{index + 1}}
                                            </th>
                                            <td>
                                                {{item.nombre}}
                                            </td>
                                            <td>
                                                {{item.updated_at}}
                                            </td>
                                            <td>
                                                <div v-if="item.id_tipo_enlace==1">
                                                    <a v-if="item.enlace!='' && item.enlace!=null" :href="$parent.NombreRuta + '/storage/documentos/' + item.enlace" target="_blank">
                                                     <span class="menu-icon">
                                                        <span class="svg-icon svg-icon-2">
                                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M20 14H18V10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14ZM21 19V17C21 16.4 20.6 16 20 16H18V20H20C20.6 20 21 19.6 21 19ZM21 7V5C21 4.4 20.6 4 20 4H18V8H20C20.6 8 21 7.6 21 7Z" fill="currentColor"></path> 
                                                                <path opacity="0.3" d="M17 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H17C17.6 2 18 2.4 18 3V21C18 21.6 17.6 22 17 22ZM10 7C8.9 7 8 7.9 8 9C8 10.1 8.9 11 10 11C11.1 11 12 10.1 12 9C12 7.9 11.1 7 10 7ZM13.3 16C14 16 14.5 15.3 14.3 14.7C13.7 13.2 12 12 10.1 12C8.10001 12 6.49999 13.1 5.89999 14.7C5.59999 15.3 6.19999 16 7.39999 16H13.3Z" fill="currentColor">
                                                                </path>
                                                            </svg>
                                                        </span>
                                                     </span>
                                                    </a>
                                                </div>
                                                <div v-if="item.id_tipo_enlace==2">
                                                    <a v-bind:href="item.enlace_drive" target="_blank"><i class="flaticon-file-1"></i>
                                                    </a>
                                                </div>
                                            </td>
                                            <td style="text-align: center;">
                                                <div v-if="item.id_estado_revision==1">
                                                    <form action="" method="post"></form>
                                                    <form @submit.prevent="verificar(3, item.id, 'Validado')">
                                                        <div>
                                                            <button type="submit" class="btn btn-success" :disabled="botonEnviar">
                                                                <span>Validar</span>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div v-if="item.id_estado_revision==3">
                                                    <button type="button" class="btn btn-success" disabled>
                                                        Validado
                                                    </button>
                                                </div>
                                            </td>
                                            <td style="text-align: center;">
                                                <div v-if="item.id_estado_revision==1">
                                                    <form @submit.prevent="verificar(2, item.id, item.observacion)">
                                                        <div>
                                                            <div v-if="item.tipo_documento_id==2">
                                                                <input class="form-control" v-model="item.observacion" type="text" required list="opciones_requisitos" />
                                                                <datalist id="opciones_requisitos">
                                                                    <option>Los requistos estan incompletos</option> 
                                                                    <option>Los datos no se visualizan correctamente</option> 
                                                                    <option>Enviar todos los requistos de su modalidad en un solo archivo</option> 
                                                                </datalist>
                                                            </div>
                                                            <div v-else-if="item.tipo_documento_id==3">
                                                                <input class="form-control" v-model="item.observacion" type="text" required list="opciones_dni" />
                                                                <datalist id="opciones_dni">
                                                                    <option>Enviar ambas caras del DNI en un archivo</option> 
                                                                    <option>Los datos no se visualizan correctamente</option> 
                                                                    <option>Se deben mostrar todos los datos del DNI</option> 
                                                                    <option>DNI caducado, adjuntar ticket de renovación a la copia de ambas caras de su DNI</option> 
                                                                </datalist>
                                                            </div>
                                                            <div v-else-if="item.tipo_documento_id==4">
                                                                <input class="form-control" v-model="item.observacion" type="text" required list="opciones_foto" />
                                                                <datalist id="opciones_foto">
                                                                    <option>La foto no debe tener margenes, recortarlo</option> 
                                                                    <option>La postura del postulante no es la correcta, al centro y mirando defrente</option> 
                                                                    <option>La calidad de la imagen no es la correcta</option> 
                                                                    <option>Evitar las sombras en las fotos</option> 
                                                                </datalist>
                                                                <!-- <select required="required" class="form-control m-input m-input--square">
                                                                    <option value="null" selected="selected">Seccione una opción</option> 
                                                                    <option>La foto no debe tener margenes, recortarlo</option> 
                                                                    <option>La postulara de la foto no es la correcta, al centro y mirando defrente</option> 
                                                                    <option>La calidad de la imagen no es la correcta</option> 
                                                                    <option>Evitar las sombras en las fotos</option> 
                                                                </select> -->
                                                            </div>
                                                            <button type="submit" class="btn btn-danger">
                                                                Rechazar
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div v-else-if="item.id_estado_revision==2">
                                                    <!-- <span class="badge badge-primary badge">{{item.observacion}}</span> -->
                                                    <!-- <button type="button" class="btn btn-danger" disabled>
                                                        Rechazado
                                                    </button> -->
                                                    <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" :title="item.observacion">
                                                        <button class="btn btn-danger" type="button" disabled>Rechazado</button>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <span v-if="item.id_estado_revision==0" class="form-control" disabled>
                                                    <a :href="'https://api.whatsapp.com/send?phone=51' + verRegistro.da_numero_celular+'&text=Buenas%20*'+verRegistro.dp_nombre+'*%2C%20somos%20de%20la%20oficina%20de%20Inscripci%C3%B3n%20para%20el%20Examen%20de%20Admisi%C3%B3n%20de%20la%20UNDC%202024,%20espero%20que%20se%20encuentren%20muy%20bien%20%F0%9F%98%81.%20%0AEste%20mensaje%20es%20para%20recordarle%20que%20a%C3%BAn%20no%20ha%20subido%20todos%20sus%20documentos%20al%20sistema%20de%20Inscripci%C3%B3n%20%F0%9F%92%BB%20de%20la%20UNDC,%20esto%20es%20fundamental%20para%20mantener%20un%20registro%20preciso%20y%20actualizado%20de%20nuestro%20trabajo%20%F0%9F%99%8B%E2%80%8D%E2%99%82.%20Adem%C3%A1s,%20nos%20ayuda%20a%20evitar%20retrasos%20y%20posibles%20malentendidos%20en%20el%20futuro%20%F0%9F%A7%8F%E2%80%8D%E2%99%82.%20%0ASi%20tienen%20alguna%20duda%20o%20necesitan%20ayuda%20con%20el%20proceso%20de%20subida,%20por%20favor%20no%20duden%20en%C2%A0contactarme%C2%A0%F0%9F%93%9E.'" target="_blank">
                                                    <i class="bi bi-whatsapp text-primary"></i>
                                                    </a>
                                                </span>
                                                <span v-else-if="item.id_estado_revision==2" class="form-control" disabled>
                                                    <a :href="'https://api.whatsapp.com/send?phone=51' + verRegistro.da_numero_celular+'&text=Buenas%20*'+verRegistro.dp_nombre+'*%2C%20somos%20de%20la%20oficina%20de%20Inscripci%C3%B3n%20para%20el%20Examen%20de%20Admisi%C3%B3n%20de%20la%20UNDC%202024%2C%20espero%20que%20se%20encuentren%20muy%20bien%20%F0%9F%98%81.%20%0AEste%20mensaje%20es%20para%20informarle%20que%20su%20documento%20*'+item.nombre+'*%20enviado%20al%20sistema%20de%20Inscripci%C3%B3n%20%F0%9F%92%BB%20de%20la%20UNDC%20ha%20sido%20*rechazado*%2C%20por%20lo%20cual%20deber%C3%A1%20enviar%20nuevamente%20con%20las%20correcciones.%20%0ASi%20tienen%20alguna%20duda%20o%20necesitan%20ayuda%20con%20el%20proceso%20de%20subida%2C%20por%20favor%20no%20duden%20en%C2%A0contactarme%C2%A0%F0%9F%93%9E.'" target="_blank">
                                                    <i class="bi bi-whatsapp text-danger"></i>
                                                    </a>
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br> 
                        <h5>
                            Pagos - <span class="badge badge-warning badge-lg">{{monto_a_pagar}}</span>
                        </h5>
                        <div class="m-section">
                            <div class="m-section__content table-responsive">
                                <table class="table m-table table-responsive">
                                    <thead class="thead-default">
                                        <tr>
                                            <th>
                                                #
                                            </th>
                                            <th>
                                                CONCEPTO
                                            </th>
                                            <th>
                                                FECHA PAGO
                                            </th>
                                            <th>
                                                MONTO PAGO
                                            </th>
                                            <th>
                                                VER
                                            </th>
                                            <th style="text-align: center;">
                                                VALIDAR
                                            </th>
                                            <th class="mw-25" style="text-align: center;">
                                                RECHAZAR
                                            </th>
                                            <th>
                                                MSG
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in pagos" :key="item.id">
                                            <th scope="row">
                                                {{index + 1}}
                                            </th>
                                            <td>
                                                <div v-if="item.id_tipo_pago===1">
                                                   PROSPECTO 
                                                </div>
                                                <div v-else-if="item.id_tipo_pago===2">
                                                   D. EXAMEN 
                                                </div>
                                                <div v-else-if="item.id_tipo_pago===3">
                                                   PROSPECTO y D. EXAMEN 
                                                </div>
                                                <div v-else-if="item.id_tipo_pago===4">
                                                   RECARGO (S/ 30.00)
                                                </div>
                                                <div v-else-if="item.id_tipo_pago===5">
                                                   SEGUNDO D. EXAMEN
                                                </div>
                                                <div v-else-if="item.id_tipo_pago===6">
                                                   TERCER D. EXAMEN
                                                </div>
                                                <div v-else-if="item.id_tipo_pago===7">
                                                   CONSTANCIA DE INGRESO
                                                </div>
                                                <!-- <span>- {{item.codigo_pago}}</span> -->
                                                <input v-if="item.id_estado_revision==1" class="" v-model="item.codigo_pago" type="text" required style="width:100px"/>
                                                <span v-else>- {{item.codigo_pago}}</span>
                                            </td>
                                            <td>
                                                {{item.fecha_pago}}
                                            </td>
                                            <td>
                                                <span class="badge badge-primary badge-lg">{{item.monto_pago}}</span>
                                            </td>
                                            <td>
                                                <div v-if="item.tipo_enlace==1">
                                                    <a v-if="item.enlace!='' && item.enlace!=null" :href="$parent.NombreRuta + '/storage/pagos/' + item.enlace" target="_blank">
                                                     <span class="menu-icon">
                                                        <span class="svg-icon svg-icon-2">
                                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M20 14H18V10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14ZM21 19V17C21 16.4 20.6 16 20 16H18V20H20C20.6 20 21 19.6 21 19ZM21 7V5C21 4.4 20.6 4 20 4H18V8H20C20.6 8 21 7.6 21 7Z" fill="currentColor"></path> 
                                                                <path opacity="0.3" d="M17 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H17C17.6 2 18 2.4 18 3V21C18 21.6 17.6 22 17 22ZM10 7C8.9 7 8 7.9 8 9C8 10.1 8.9 11 10 11C11.1 11 12 10.1 12 9C12 7.9 11.1 7 10 7ZM13.3 16C14 16 14.5 15.3 14.3 14.7C13.7 13.2 12 12 10.1 12C8.10001 12 6.49999 13.1 5.89999 14.7C5.59999 15.3 6.19999 16 7.39999 16H13.3Z" fill="currentColor">
                                                                </path>
                                                            </svg>
                                                        </span>
                                                     </span>
                                                    </a>
                                                </div>
                                                <div v-else-if="item.tipo_enlace==2">
                                                    <a v-bind:href="item.enlace_drive" target="_blank"><i class="flaticon-file-1"></i>
                                                    </a>
                                                </div>
                                                <div v-else-if="item.tipo_enlace==3">
                                                    <span class="badge badge-danger">IZIPAY</span>
                                                </div>
                                            </td>
                                            <td style="text-align: center;">
                                                <div v-if="item.id_estado_revision==1">
                                                    <form action="" method="post"></form>
                                                    <form @submit.prevent="verificarPago(3, item.id, item.monto_pago, item.codigo_pago)">
                                                        <div>
                                                            <!-- <label for="exampleInputEmail1">Monto</label> -->
                                                            <input type="number" step="any" class="form-control" id="exampleInputEmail1" v-model="item.monto_pago" aria-describedby="emailHelp" placeholder="Ingrese monto">
                                                            <button type="submit" class="btn btn-success" :disabled="botonEnviar">
                                                                <span>Validar</span>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div v-if="item.id_estado_revision==3">
                                                    <button type="button" class="btn btn-success" disabled>
                                                        Validado
                                                    </button>
                                                </div>
                                            </td>
                                            <td style="text-align: center;">
                                                <div v-if="item.id_estado_revision==1">
                                                    <form @submit.prevent="verificarPago(2, item.id, item.observacion, item.codigo_pago)">
                                                        
                                                        <div>
                                                            <!-- <select class="form-control m-input m-input--square" v-model="item.observacion" required>
                                                                <option value=null selected>Seccione una opción</option>
                                                                <option>Error en código de pago</option>
                                                                <option>Pago junto(Escribir en el voucher "Prospecto y Derecho de examen")</option>
                                                                <option>No se visualiza todos los datos</option>
                                                                <option>Pago imcompleto</option>
                                                                 <option>Voucher incorrecto</option>
                                                            </select> -->
                                                            <input class="form-control" v-model="item.observacion" type="text" required list="opciones_pago" />
                                                            <datalist id="opciones_pago">
                                                                <option>Error en código de pago</option>
                                                                <option>Enviar voucher en el concepto correcto:</option>
                                                                <option>No se visualiza todos los datos</option>
                                                                <option>Pago incompleto</option>
                                                                <option>Voucher incorrecto</option>
                                                            </datalist>
                                                            <button type="submit" class="btn btn-danger">
                                                                Rechazar
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div v-if="item.id_estado_revision==2">
                                                    <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" :title="item.observacion">
                                                        <button class="btn btn-danger" type="button" disabled>Rechazado</button>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <span v-if="item.id_estado_revision==2" class="form-control" disabled>
                                                    <a :href="'https://api.whatsapp.com/send?phone=51' + verRegistro.da_numero_celular+'&text=Buenas%20*'+verRegistro.dp_nombre+'*%2C%20somos%20de%20la%20oficina%20de%20Inscripci%C3%B3n%20para%20el%20Examen%20de%20Admisi%C3%B3n%20de%20la%20UNDC%202024%2C%20espero%20que%20se%20encuentren%20muy%20bien%20%F0%9F%98%81.%20%0AEste%20mensaje%20es%20para%20informarle%20que%20su%20comprobante%20de%20pago%20-%20*'+nombrePago(item.id_tipo_pago)+'*%20enviado%20al%20sistema%20de%20Inscripci%C3%B3n%20%F0%9F%92%BB%20de%20la%20UNDC%20ha%20sido%20*rechazado*%2C%20por%20lo%20cual%20deber%C3%A1%20enviar%20nuevamente%20con%20las%20correcciones.%20%0ASi%20tienen%20alguna%20duda%20o%20necesitan%20ayuda%20con%20el%20proceso%20de%20subida%2C%20por%20favor%20no%20duden%20en%C2%A0contactarme%C2%A0%F0%9F%93%9E.'" target="_blank">
                                                    <i class="bi bi-whatsapp text-danger"></i>
                                                    </a>
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br>
                        <div v-if="btnRevision!=''" class="alert alert-warning" role="alert">
                            <strong>
                                Alerta!
                            </strong>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <button type="button" @click.prevent="inscribir(verRegistro.id, verRegistro.user_id, verRegistro.mcp_id_modalidad, 2, verRegistro.numero_documento, verRegistro.da_email, verRegistro.dp_nombre, verRegistro.apellidos, verRegistro.carrera, verRegistro.modalidad)" v-bind:class="[botonRechazar ? 'm-loader m-loader--light m-loader--right' : '', 'btn btn-danger w-100']" :disabled="botonRechazar || verRegistro.id_estado_revision==0 || verRegistro.id_estado_revision==2 || verRegistro.id_estado_revision==3">
                                    <span v-if="botonRechazar">Rechazando</span>
                                    <span v-else>Rechazar</span>
                                </button>
                            </div>
                            <div v-if="verRegistro.mcp_id_modalidad==8 || is('Administrador') || is('Asesor') || is ('Colaborador')" class="col-md-6">
                                <button type="button" @click.prevent="inscribir(verRegistro.id, verRegistro.user_id, verRegistro.mcp_id_modalidad, 3, verRegistro.numero_documento, verRegistro.da_email, verRegistro.dp_nombre, verRegistro.apellidos, verRegistro.carrera, verRegistro.modalidad)" v-bind:class="[botonInscribir ? 'm-loader m-loader--light m-loader--right' : '', 'btn btn-primary w-100']" :disabled="botonInscribir || verRegistro.id_estado_revision==3 || botonInscribirDisabled">
                                    <span v-if="botonInscribir">Inscribiendo</span>
                                    <span v-else>Inscribir</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                        <!-- <button type="button" class="btn btn-primary" @click.prevent="inscribir(verRegistro.id, verRegistro.user_id, verRegistro.mcp_id_modalidad, 3, verRegistro.numero_documento, verRegistro.da_email)" >Inscribir</button> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" id="kt_modal_2">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">EDITAR FICHA</h3>
                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <span class="svg-icon svg-icon-1"></span>
                        </div>
                        <!--end::Close-->
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="guardarFicha()">

                        
                        <!-- DATOS PERSONALES -->
                        <div class="form-group m-form__group">
                            <div class="alert alert-warning" role="alert">
                                <strong>
                                    Importante!
                                </strong>
                                Revisar que sus datos sean los correctos al momento de completar el formulario.
                            </div>
                            <div class="m-form__heading">
                                <h6 class="m-form__heading-title row">
                                    <div class="col-lg-6">
                                        1. DATOS PERSONALES
                                    </div>
                                    <div class="col-lg-6">
                                        <span class="badge badge-warning float-right">Rellenar datos correctos.</span>
                                    </div>
                                </h6>
                            </div>
                            <div class="row mb-5">
                                <div class="col-lg-3">
                                    <label>
                                        APELLIDO PATERNO:
                                    </label>
                                    <input type="text" class="form-control m-input" maxlength="50" v-model="nuevoRegistro.dp_apellido_p" placeholder="Ingrese sus apellidos" required autocomplete="off">
                                </div>
                                <div class="col-lg-3">
                                    <label>
                                        APELLIDO MATERNO:
                                    </label>
                                    <input type="text" class="form-control m-input" maxlength="50" v-model="nuevoRegistro.dp_apellido_m" placeholder="Ingrese sus apellidos" required autocomplete="off">
                                </div>
                                <div class="col-lg-6">
                                    <label class="">
                                        NOMBRES:
                                    </label>
                                    <input type="text" class="form-control m-input" maxlength="30" v-model="nuevoRegistro.dp_nombre" placeholder="ingrese su nombre" required autocomplete="off">
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-lg-2">
                                    <label for="selectSexo">
                                        TIPO DOC.
                                    </label>
                                    <select class="form-control m-input"  v-model="nuevoRegistro.id_tipo_documento" placeholder="Seleccione" required :disabled="true">
                                        <!-- <option value="" hidden>Selecione sexo</option> -->
                                        <option value="1">
                                            DNI
                                        </option>
                                        <option value="2">
                                            C.E.
                                        </option>
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <label class="">
                                        DOCUMENTO DE IDENTIDAD
                                    </label>
                                    <input type="text" class="form-control m-input"  v-model="nuevoRegistro.numero_documento" required="" :disabled="true" minlength="8" maxlength="9" pattern="[0-9]+" title="Solo Nº DNI." placeholder="Ingrese número de documento" autocomplete="off">
                                </div>
                                <div class="col-lg-2">
                                    <label class="">
                                        EDAD
                                    </label>
                                    <input type="text" class="form-control m-input" v-model="nuevoRegistro.dp_edad" required="" size="2" maxlength="2" pattern="[0-9]+" title="Solo números. Tamaño max: 2 dígitos." placeholder="Ingrese edad" autocomplete="off">
                                </div>
                                <div class="col-lg-4">
                                    <label>
                                        FECHA DE NACIMIENTO
                                    </label>
                                    <div class="input-group date">
                                        <input type="date" class="form-control m-input col-lg-10" v-model="nuevoRegistro.dp_fecha_n" placeholder="Seleccione fecha" required autocomplete="off">
                                        <!-- <span class="input-group-addon">
                                            <i class="la la-calendar-check-o"></i>
                                        </span> -->
                                    </div>
                                </div>
                            </div>
                            <label>
                                LUGAR DE NACIMIENTO
                            </label>
                            <div class="row mb-5">
                                <div class="col-lg-12">
                                    <label for="inputNombresIE" class="">
                                        Pais de nacimiento:
                                    </label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" v-model="nuevoRegistro.dp_ln_peru" name="inlineRadioOptions" id="inlineRadio1" value="1" required>
                                        <label class="form-check-label" for="inlineRadio1">Perú</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" v-model="nuevoRegistro.dp_ln_peru" name="inlineRadioOptions" id="inlineRadio2" value="0">
                                        <label class="form-check-label" for="inlineRadio2">Extranjero</label>
                                    </div>
                                </div>
                                <div v-if="nuevoRegistro.dp_ln_peru==0"  class="col-lg-3">
                                    <label for="nombresPadre" class="">
                                        Pais
                                    </label>
                                    <input type="text" class="form-control m-input" v-model="nuevoRegistro.dp_ln_pais" size="100" maxlength="100" placeholder="Pais" required autocomplete="off">
                                </div>
                                <div v-if="nuevoRegistro.dp_ln_peru==0" class="col-lg-3">
                                    <label for="nombresPadre" class="">
                                        Departamento
                                    </label>
                                    <input type="text" class="form-control m-input" v-model="nuevoRegistro.dp_ln_dep_ext" size="100" maxlength="100" placeholder="Departamento" required autocomplete="off">
                                </div>
                                <div v-if="nuevoRegistro.dp_ln_peru==0" class="col-lg-3">
                                    <label for="nombresPadre" class="">
                                        Provincia
                                    </label>
                                    <input type="text" class="form-control m-input" v-model="nuevoRegistro.dp_ln_prov_ext" size="100" maxlength="100" placeholder="Provincia" required autocomplete="off">
                                </div>
                                <div v-if="nuevoRegistro.dp_ln_peru==0" class="col-lg-3">
                                    <label for="nombresPadre" class="">
                                        Distrito
                                    </label>
                                    <input type="text" class="form-control m-input" v-model="nuevoRegistro.dp_ln_dis_ext" size="100" maxlength="100" placeholder="Distrito" required autocomplete="off">
                                </div>
                                <div v-if="nuevoRegistro.dp_ln_peru==1" class="col-lg-2">
                                    <label class="">
                                        Departamento
                                    </label>
                                    <select class="form-select" @change="obtenerProvincia(1)" v-model="nuevoRegistro.dp_ln_dep" required="">
                                        <option value="" hidden>Seleccione departamento</option>
                                        <option v-for="item in depNac" :key="item.id" :value="item.id">{{item.nombre}}</option>
                                    </select>
                                </div>
                                <div v-if="nuevoRegistro.dp_ln_peru==1" class="col-lg-2">
                                    <label class="">
                                        Provincia
                                    </label>
                                    <select class="form-select" @change="obtenerDistrito(1)" v-model="nuevoRegistro.dp_ln_prov" required="">
                                        <option value="" hidden>Seleccione Provincia</option>
                                        <option v-for="item in provNac" :key="item.id" :value="item.id">{{item.nombre}}</option>
                                    </select>
                                </div>
                                <div v-if="nuevoRegistro.dp_ln_peru==1" class="col-lg-2">
                                    <label class="">
                                        Distrito
                                    </label>
                                    <select class="form-select" v-model="nuevoRegistro.dp_ln_dis" required="">
                                        <option value="" hidden>Seleccione Provincia</option>
                                        <option v-for="item in disNac" :key="item.id" :value="item.id">{{item.nombre}}</option>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label for="selectSexo">
                                        Sexo
                                    </label>
                                    <select class="form-select" v-model="nuevoRegistro.dp_sexo" placeholder="Seleccione" required>
                                        <option value="" hidden>Selecione sexo</option>
                                        <option>
                                            MASCULINO
                                        </option>
                                        <option>
                                            FEMENINO
                                        </option>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label for="selectEstadoCivil">
                                        Estado Civil
                                    </label>
                                    <select class="form-select" v-model="nuevoRegistro.dp_estado_c" required>
                                        <option value="" hidden>Selecione estado</option>
                                        <option>
                                            SOLTERO
                                        </option>
                                        <option>
                                            CASADO
                                        </option>
                                        <option>
                                            DIVORCIADO
                                        </option>
                                        <option>
                                            CONVIVIENTE
                                        </option>
                                        <option>
                                            VIUDO
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- DATOS PERSONALES -->
                        <div class="form-group m-form__group">
                            <div class="m-form__heading">
                                <h6 class="m-form__heading-title">
                                    2. DOMICILIO ACTUAL
                                </h6>
                            </div>
                            <div class="row mb-5">
                                <div class="col-lg-12">
                                    <label>
                                        Direccion (Jr/Av/Pje/Calle/Mz/Urb)
                                    </label>
                                    <div class="m-input-icon m-input-icon--right">
                                        <input type="text" class="form-control m-input" v-model="nuevoRegistro.da_direccion" maxlength="200" placeholder="Ingrese su dirección" required autocomplete="off">
                                        <!-- <span class="m-input-icon__icon m-input-icon__icon--right">
                                            <span>
                                                <i class="la la-map-marker"></i>
                                            </span>
                                        </span> -->
                                    </div>
                                </div>
                                <!-- <div class="col-lg-2">
                                        <label class="" >
                                            LOTE
                                        </label>
                                        <input type="text" class="form-control m-input" name="lote" size="3" maxlength="3" placeholder="lote" autocomplete="off">
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="inputInterior" class="">
                                            Interior
                                        </label>
                                        <input type="text" class="form-control m-input" name="interior" id="inputInterior" placeholder="interior" autocomplete="off">
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="inputUrbanizacion" class="">
                                            Urbanización
                                        </label>
                                        <input type="text" class="form-control m-input" name="urbanizacion" id="inputUrbanizacion" placeholder="urbanizacion" autocomplete="off">
                                    </div>-->
                            </div>
                            <div class="row mb-5" style="justify-content: normal">
                                <div class="col-lg-2">
                                    <label class="">
                                        Departamento
                                    </label>
                                    <select class="form-select" @change="obtenerProvincia(2)" v-model="nuevoRegistro.da_dep" required="">
                                        <option value="" hidden>Seleccione departamento</option>
                                        <option v-for="item in depNac" :key="item.id" :value="item.id">{{item.nombre}}</option>
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <label class="">
                                        Provincia
                                    </label>
                                    <select class="form-select" @change="obtenerDistrito(2)" v-model="nuevoRegistro.da_prov" required="">
                                        <option value="" hidden>Seleccione Provincia</option>
                                        <option v-for="item in provActu" :key="item.id" :value="item.id">{{item.nombre}}</option>
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <label class="">
                                        Distrito
                                    </label>
                                    <select class="form-select" v-model="nuevoRegistro.da_dis" required="">
                                        <option value="" hidden>Seleccione Provincia</option>
                                        <option v-for="item in disActu" :key="item.id" :value="item.id">{{item.nombre}}</option>
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-lg-3">
                                    <label class="">
                                        Celular
                                    </label>
                                    <div class="m-input-icon m-input-icon--right">
                                        <input type="text" class="form-control m-input" v-model="nuevoRegistro.da_numero_celular" minlength="9" maxlength="9" pattern="[0-9]+" title="Solo números. Tamaño max: 9 dígitos." placeholder="Ingrese celular" required autocomplete="off">
                                        <!-- <span class="m-input-icon__icon m-input-icon__icon--right">
                                            <span>
                                                <i class="la la-mobile"></i>
                                            </span>
                                        </span> -->
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <label class="">
                                        Teléfono fijo
                                    </label>
                                    <div class="m-input-icon m-input-icon--right">
                                        <input type="text" class="form-control m-input" v-model="nuevoRegistro.da_numero_telefono" size="10" maxlength="10" title="Solo números. Tamaño max: 10 dígitos." placeholder="Ingrese telefono" autocomplete="off">
                                        <!-- <span class="m-input-icon__icon m-input-icon__icon--right">
                                            <span>
                                                <i class="la la-phone"></i>
                                            </span>
                                        </span> -->
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label class="">
                                        Email
                                    </label>
                                    <input type="Email" class="form-control m-input" v-model="nuevoRegistro.da_email" size="50" maxlength="50" placeholder="Ingrese su correo" required autocomplete="off" disabled>
                                </div>
                            </div>
                        </div>
                        <!-- DATOS FAMILIARES -->
                        <div class="form-group m-form__group">
                            <div class="m-form__heading">
                                <h6 class="m-form__heading-title">
                                    3. DATOS FAMILIARES
                                </h6>
                            </div>
                            <!-- <div class="row mb-5">
                                <div class="col-lg-6">
                                    <label for="nombresPadre" class="">
                                        Apellidos y Nombres del Padre
                                    </label>
                                    <input type="text" class="form-control m-input" v-model="nuevoRegistro.datosPadre" size="100" maxlength="100" placeholder="Nombres del padre" required autocomplete="off">
                                </div>
                                <div class="col-lg-6">
                                    <label for="nombresMadre" class="">
                                        Apellidos y Nombres de la Madre
                                    </label>
                                    <input type="text" class="form-control m-input" v-model="nuevoRegistro.datosMadre" size="100" maxlength="100" placeholder="Nombre de la madre" required autocomplete="off">
                                </div>
                            </div> -->
                            <div class="row mb-5">
                                <div class="col-lg-6">
                                    <label class="">
                                        Apellidos y Nombres(Padre o madre o apoderado)
                                    </label>
                                    <input type="text" class="form-control m-input" v-model="nuevoRegistro.df_nombres_apoderado" size="100" maxlength="100" placeholder="Nombres del apoderado" required autocomplete="off">
                                </div>
                                <div v-if="nuevoRegistro.dp_edad<18" class="col-lg-3">
                                    <label class="">
                                        DNI del Apoderado
                                    </label>
                                    <input type="text" class="form-control m-input" v-model="nuevoRegistro.df_dni_apoderado" required="" minlength="8" maxlength="9" pattern="[0-9]+" title="Solo Nº DNI." placeholder="Ingrese DNI" autocomplete="off">
                                </div>
                                <div class="col-lg-3">
                                    <label class="">
                                        Celular del Apoderado
                                    </label>
                                    <div class="m-input-icon m-input-icon--right">
                                        <input type="text" class="form-control m-input" v-model="nuevoRegistro.df_celular_apoderado" minlength="9" maxlength="9" pattern="[0-9]+" title="Solo números. Tamaño max: 9 dígitos." placeholder="Ingrese celular" required autocomplete="off">
                                        <!-- <span class="m-input-icon__icon m-input-icon__icon--right">
                                            <span>
                                                <i class="la la-mobile"></i>
                                            </span>
                                        </span> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- DATOS DE LA INSTITUCION EDUCATIVA DE PROCEDENCIA -->
                        <div class="form-group m-form__group">
                            <div class="m-form__heading">
                                <h6 class="m-form__heading-title">
                                    5. DATOS DE LA INSTITUCION EDUCATIVA DE PROCEDENCIA
                                </h6>
                            </div>
                            <div class="row mb-5">
                                <div class="col-lg-12">
                                    <label>
                                        Colegio - Gestión
                                    </label>
                                    <div class="m-input-icon m-input-icon--right">
                                        <input type="text" class="form-control m-input" v-model="nuevoRegistro.colegio_gestion" maxlength="200" placeholder="Ingrese su dirección" required autocomplete="off" disabled>
                                        <!-- <span class="m-input-icon__icon m-input-icon__icon--right">
                                            <span>
                                                <i class="la la-map-marker"></i>
                                            </span>
                                        </span> -->
                                    </div>
                                </div>
                                <!-- <div class="col-lg-12">
                                    <label for="inputNombresIE" class="">
                                        Has culminado en un colegio:
                                    </label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" required>
                                        <label class="form-check-label" for="inlineRadio1">Nacional</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                        <label class="form-check-label" for="inlineRadio2">Extranjero</label>
                                    </div>
                                </div> -->
                                
                            </div>
                            <form  @submit.prevent="guardarColegio()">
                            <div class="row mb-5 rounded border">
                                <div class="col-lg-6">
                                    <label for="inputNombresIE" class="">
                                        Departamento
                                    </label>
                                    <select class="form-select" @change="obtenerProvincia(3)" v-model="nuevoRegistro.depColegio" required="">
                                        <option value="" hidden>Seleccione departamento</option>
                                        <option v-for="item in depNac" :key="item.id" :value="item.id">{{item.nombre}}</option>
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label class="">
                                        Provincia
                                    </label>
                                    <select class="form-select" @change="obtenerColegio()" v-model="nuevoRegistro.provColegio" required="">
                                        <option value="" hidden>Seleccione Provincia</option>
                                        <option v-for="item in provCole" :key="item.id" :value="item.nombre">{{item.nombre}}</option>
                                    </select>
                                </div>
                                <div class="col-lg-9 mb-3">
                                    <label class="">
                                        Colegio
                                    </label>
                                    <!-- <select name="CboColegio" id="CboColegio" class="form-control" required="">
                                                <option value="" hidden>Selecione su colegio</option>
                                            </select> -->
                                    <!-- <v-select label="nombre" :options="colegios" :reduce="usuarios => usuarios.id" v-model="nuevoRegistro.colegio">
                                                <template #search="{attributes, events}">
                                                    <input class="vs__search" :required="true" v-bind="attributes" v-on="events" />
                                                </template>
                                            </v-select> -->
                                    <v-select :options="colegios" :reduce="colegios => colegios.id" label="nombre" class="vs-select-custom" v-model="nuevoRegistro.diep_id_colegio">
                                        <template #search="{attributes, events}">
                                            <input class="vs__search" :required="!nuevoRegistro.diep_id_colegio" v-bind="attributes" v-on="events" />
                                        </template>
                                    </v-select>
                                </div>
                                <div class="col-lg-3">
                                    <button type="submit" class="btn btn-primary mt-4">guardar</button>
                                </div>
                            </div>
                            </form>
                            <div class="row mb-5">
                                
                                <!-- <div class="col-lg-4">  
                                    <label>¿Has culminado tus estudios?</label>
                                    <div class="mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="1" id="flexCheckAce1" name="radioace" v-model="nuevoRegistro.concluyoIE" required>
                                            <label class="form-check-label" for="flexCheckAce1">SI</label>
                                        </div>
                                    </div>
                                    <div class="mb-0">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="0" id="flexCheckAce2" name="radioace" v-model="nuevoRegistro.concluyoIE">
                                            <label class="form-check-label" for="flexCheckAce2">NO</label>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="col-lg-4">
                                    <label for="inputFinEstudio" class="">
                                        Año que concluyó sus estudios
                                    </label>
                                    <input type="text" class="form-control m-input" v-model="nuevoRegistro.diep_ace" required="" max="2021" pattern="[0-9]+" placeholder="Ingrese año" autocomplete="off">
                                    <!-- <input type="text" class="form-control m-input" v-model="nuevaFicha.fechaConcluyoIE" min="1950" max="2021" size="4" maxlength="4" placeholder=""> -->
                                    <!-- <select class="form-select" v-model="nuevoRegistro.diep_ace" required="" :disabled="nuevoRegistro.concluyoIE!='1'">
                                        <option value="" hidden>Especifique un año</option>
                                        <option>
                                            2022
                                        </option>
                                        <option>
                                            2021
                                        </option>
                                        <option>
                                            2020
                                        </option>
                                        <option>
                                            2019
                                        </option>
                                        <option>
                                            2018
                                        </option>
                                        <option>
                                            2017
                                        </option>
                                        <option>
                                            2016
                                        </option>
                                        <option>
                                            2015
                                        </option>
                                        <option>
                                            2014
                                        </option>
                                        <option>
                                            2013
                                        </option>
                                        <option>
                                            2012
                                        </option>
                                        <option>
                                            2011
                                        </option>
                                        <option>
                                            2010
                                        </option>
                                        <option>
                                            2009
                                        </option>
                                        <option>
                                            2008
                                        </option>
                                        <option>
                                            2007
                                        </option>
                                        <option>
                                            2006
                                        </option>
                                        <option>
                                            2005
                                        </option>
                                        <option>
                                            2004
                                        </option>
                                        <option>
                                            2003
                                        </option>
                                        <option>
                                            2002
                                        </option>
                                        <option>
                                            2001
                                        </option>
                                        <option>
                                            2000
                                        </option>
                                        <option>
                                            1999
                                        </option>
                                        <option>
                                            1998
                                        </option>
                                        <option>
                                            1997
                                        </option>
                                        <option>
                                            1996
                                        </option>
                                        <option>
                                            1995
                                        </option>
                                        <option>
                                            1994
                                        </option>
                                        <option>
                                            1993
                                        </option>
                                        <option>
                                            1992
                                        </option>
                                        <option>
                                            1991
                                        </option>
                                        <option>
                                            1990
                                        </option>
                                        <option>
                                            1989
                                        </option>
                                        <option>
                                            1988
                                        </option>
                                        <option>
                                            1987
                                        </option>
                                        <option>
                                            1986
                                        </option>
                                        <option>
                                            1985
                                        </option>
                                        <option>
                                            1984
                                        </option>
                                        <option>
                                            1983
                                        </option>
                                        <option>
                                            1982
                                        </option>
                                        <option>
                                            1981
                                        </option>
                                        <option>
                                            1980
                                        </option>
                                        <option>
                                            1979
                                        </option>
                                        <option>
                                            1978
                                        </option>
                                        <option>
                                            1977
                                        </option>
                                        <option>
                                            1976
                                        </option>
                                        <option>
                                            1975
                                        </option>
                                        <option>
                                            1974
                                        </option>
                                        <option>
                                            1973
                                        </option>
                                        <option>
                                            1972
                                        </option>
                                        <option>
                                            1971
                                        </option>
                                        <option>
                                            1970
                                        </option>
                                    </select> -->
                                    <!-- <span v-if="nuevoRegistro.concluyoIE=='0'" class="badge badge-warning float-right">
                                        La universidad no reserva vacantes para postulantes que no han culminado secundaria
                                    </span> -->
                                </div>
                            </div>
                        </div>
                        <!-- MODALIDAD Y CARRERA PROFESIONAL -->
                        <div class="form-group m-form__group">
                            <div class="m-form__heading">
                                <h6 class="m-form__heading-title">
                                    5. MODALIDAD Y CARRERA PROFESIONAL
                                </h6>
                            </div>
                            <form @submit.prevent="guardarModalidad()">
                            <div class="row mb-5 rounded border">
                                <div class="col-lg-6">
                                    <label for="nombresPadre" class="">
                                        5.1 MODALIDAD
                                    </label>
                                    <div class="m-radio-list">
                                        
                                    </div>                                                    
                                    <div class="col-lg-12">
                                        <select class="form-select" v-model.number="nuevoRegistro.mcp_id_modalidad" required :disabled="true">
                                            <option value="" hidden>Seleccione la modalidad</option>
                                            <option value="11">
                                                Quinto de Secundaria
                                            </option>
                                            <option value="1">
                                                Ordinario
                                            </option>
                                            <option value="2">
                                                Primeros Puestos
                                            </option>
                                            <option value="3">
                                                Graduados y Titulados
                                            </option>
                                            <option value="4">
                                                Traslado Externo
                                            </option>
                                            <option value="10">
                                                Traslado Interno
                                            </option>
                                            <option value="5">
                                                Ley 29973 Personas con Discapacidad
                                            </option>
                                            <option value="6">
                                                Ley 28036 Deportitas Calificados
                                            </option>
                                            <option value="7">
                                                Ley 27277 Victimas del Terrorismo
                                            </option>
                                            <option value="8">
                                                Centro PRE (Ingresantes).
                                            </option>
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="nombresMadre" class="">
                                        5.1 CARRERA PROFESIONAL
                                    </label>
                                    <select class="form-select" v-model.number="nuevoRegistro.mcp_id_carrera" required>
                                        <option value="" hidden>Seleccione la carrera</option>
                                        <option value="1">
                                            Administración
                                        </option>
                                        <option value="2">
                                            Contabilidad
                                        </option>
                                        <option value="3">
                                            Administración de Turismo y Hotelería
                                        </option>
                                        <option value="4">
                                            Ingenierias de Sistemas
                                        </option>
                                        <option value="5">
                                            Agronomia
                                        </option>
                                    </select>
                                </div>
                                
                                <br>
                                <div class="col-lg-12">
                                    <br>
                                </div>
                                <div v-if="nuevoRegistro.mcp_id_modalidad==9 || nuevoRegistro.mcp_id_modalidad==3 || nuevoRegistro.mcp_id_modalidad==4" class="col-lg-6">
                                    <label for="nombresPadre" class="">
                                        Universidad de procedencia
                                    </label>
                                    <input type="text" class="form-control m-input" v-model="nuevoRegistro.de_nom_uni" size="100" maxlength="100" placeholder="Universidad de procedencia" autocomplete="off" required>
                                </div>
                                <div v-if="nuevoRegistro.mcp_id_modalidad==9 || nuevoRegistro.mcp_id_modalidad==3 || nuevoRegistro.mcp_id_modalidad==4 || nuevoRegistro.mcp_id_modalidad==10" class="col-lg-6">
                                    <label for="nombresMadre" class="">
                                        Creditos aprobados
                                    </label>
                                    <input type="text" class="form-control m-input" v-model="nuevoRegistro.de_cred_uni" size="3" maxlength="3" title="Solo números. Tamaño max: 3 dígitos." placeholder="Creditos aprobados" autocomplete="off" required>
                                </div>
                                <div v-if="nuevoRegistro.mcp_id_modalidad==7" class="col-lg-6">
                                    <label class="">
                                        Código RUV
                                    </label>
                                    <input type="text" class="form-control m-input" v-model="nuevoRegistro.codigo_ruv" required="" title="Solo código RUV" placeholder="Ingrese código RUV" autocomplete="off">
                                </div>
                                <div class="col-lg-3 mt-6 mb-2"><button type="submit" class="btn btn-primary">guardar</button></div>
                            </div>
                            </form>
                        </div>
                        <h5>
                            Documentos
                        </h5>
                        <div class="rounded border p-2">
                            
                            <div v-for="(item, index) in documentos" :key="item.id">
                                <form @submit.prevent="guardarFoto(item)" class="row">
                                <div v-if="item.tipo_documento_id==4 && item.id_estado_revision!=3" class="col-md-12">
                                    <span><b> - Foto del postulante</b></span>
                                </div>
                                <div v-if="item.tipo_documento_id==4 && item.id_estado_revision!=3" class="col-md-7">
                                    <input  type="file" class="form-control" id="file4" ref="file4" v-on:change="handleFileUpload(4)" required>
                                </div>
                                <div v-if="item.tipo_documento_id==4 && item.id_estado_revision!=3" class="col-md-2">
                                    <div v-if="item.id_tipo_enlace==1">
                                        <a v-if="item.enlace!='' && item.enlace!=null" :href="$parent.NombreRuta + '/storage/documentos/' + item.enlace" target="_blank">
                                         <span class="menu-icon">
                                            <span class="svg-icon svg-icon-3x">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M20 14H18V10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14ZM21 19V17C21 16.4 20.6 16 20 16H18V20H20C20.6 20 21 19.6 21 19ZM21 7V5C21 4.4 20.6 4 20 4H18V8H20C20.6 8 21 7.6 21 7Z" fill="currentColor"></path> 
                                                    <path opacity="0.3" d="M17 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H17C17.6 2 18 2.4 18 3V21C18 21.6 17.6 22 17 22ZM10 7C8.9 7 8 7.9 8 9C8 10.1 8.9 11 10 11C11.1 11 12 10.1 12 9C12 7.9 11.1 7 10 7ZM13.3 16C14 16 14.5 15.3 14.3 14.7C13.7 13.2 12 12 10.1 12C8.10001 12 6.49999 13.1 5.89999 14.7C5.59999 15.3 6.19999 16 7.39999 16H13.3Z" fill="currentColor">
                                                    </path>
                                                </svg>
                                            </span>
                                         </span>
                                        </a>
                                    </div>
                                    <div v-if="item.id_tipo_enlace==2">
                                        <a v-bind:href="item.enlace_drive" target="_blank"><i class="flaticon-file-1"></i>
                                        </a>
                                    </div>
                                </div>
                                <div v-if="item.tipo_documento_id==4 && item.id_estado_revision!=3" class="col-md-3">
                                    <button type="submit" class="btn btn-primary">guardar</button>
                                </div>
                                </form>
                            </div>
                            
                        </div>
                        <h5>
                            Otros
                        </h5>
                        <div>
                            <div class="col-lg-6">
                                <label for="nombresPadre" class="">
                                    5.1 MODALIDAD
                                </label>
                                <div class="m-radio-list">
                                    
                                </div>                                                    
                                <div class="col-lg-12">
                                    <select class="form-select" v-model.number="nuevoRegistro.extemporaneo" required>
                                        <option value="0">
                                            REGULAR
                                        </option>
                                        <option value="1">
                                            EXTEMPORANEO
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!--<div class="m-section">
                            <div class="m-section__content table-responsive">
                                <table class="table m-table table-responsive">
                                    <thead class="thead-default">
                                        <tr>
                                            <th>
                                                #
                                            </th>
                                            <th>
                                                TIPO DOC.
                                            </th>
                                            <th>
                                                FECHA
                                            </th>
                                            <th>
                                                VER
                                            </th>
                                            <th style="text-align: center;">
                                                ESTADO
                                            </th>
                                            <th class="mw-25" style="text-align: center; width: 25%;">
                                                ACCIÓN
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in documentos" :key="item.id">
                                            <th scope="row">
                                                {{index + 1}}
                                            </th>
                                            <td>
                                                <select class="form-select" aria-label="Select example" v-model.number="item.tipo_documento_id">
                                                    <option value="1">
                                                        FICHA DE INSCRIPCIÓN
                                                    </option>
                                                    <option value="2">
                                                        REQUISITOS SEGUN MODALIDAD
                                                    </option>
                                                    <option value="3">
                                                        DNI O C.E.
                                                    </option>
                                                    <option value="4">
                                                        FOTO DEL POSTULANTE
                                                    </option>
                                                </select> 
                                            </td>
                                            <td>
                                                {{item.updated_at}}
                                            </td>
                                            <td>
                                                <div v-if="item.id_tipo_enlace==1">
                                                    <a v-if="item.enlace!='' && item.enlace!=null" :href="$parent.NombreRuta + '/storage/documentos/' + item.enlace" target="_blank">
                                                     <span class="menu-icon">
                                                        <span class="svg-icon svg-icon-2">
                                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M20 14H18V10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14ZM21 19V17C21 16.4 20.6 16 20 16H18V20H20C20.6 20 21 19.6 21 19ZM21 7V5C21 4.4 20.6 4 20 4H18V8H20C20.6 8 21 7.6 21 7Z" fill="currentColor"></path> 
                                                                <path opacity="0.3" d="M17 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H17C17.6 2 18 2.4 18 3V21C18 21.6 17.6 22 17 22ZM10 7C8.9 7 8 7.9 8 9C8 10.1 8.9 11 10 11C11.1 11 12 10.1 12 9C12 7.9 11.1 7 10 7ZM13.3 16C14 16 14.5 15.3 14.3 14.7C13.7 13.2 12 12 10.1 12C8.10001 12 6.49999 13.1 5.89999 14.7C5.59999 15.3 6.19999 16 7.39999 16H13.3Z" fill="currentColor">
                                                                </path>
                                                            </svg>
                                                        </span>
                                                     </span>
                                                    </a>
                                                </div>
                                                <div v-if="item.id_tipo_enlace==2">
                                                    <a v-bind:href="item.enlace_drive" target="_blank"><i class="flaticon-file-1"></i>
                                                    </a>
                                                </div>
                                            </td>
                                            <td style="text-align: center;">
                                                <select class="form-select" aria-label="Select example" v-model.number="item.id_estado">
                                                    <option value="0">
                                                        DESACTIVO
                                                    </option>
                                                    <option value="1">
                                                        ACTIVO
                                                    </option>
                                                </select> 
                                            </td>
                                            <td style="text-align: center;">
                                                <div class="">
                                                    <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                        <span class="svg-icon svg-icon-3"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor"></path>
                                                        <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor"></path>
                                                        </svg>
                                                        </span>
                                                    </a>
                                                    <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                                        <span class="svg-icon svg-icon-3"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor"></path>
                                                        <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor"></path>
                                                        <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor"></path>
                                                        </svg>
                                                        </span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div> -->
                        <br> 
                        <div class="row">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-light w-100" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary w-100">
                                    <span>Guardar ficha</span>
                                </button>
                            </div>
                        </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name:'ventaProspecto',
	data() {
		return {
			datos:[],
            documentos:[],
            pagos:[],
			//MODAL REGISTER:1 MODAL EDIT:0
			tipoModal:1,
			csrfToken: null,
            botonCargando: false,
            botonEnviar: false,
            botonInscribir: false,
            botonRechazar: false,
            botonInscribirDisabled: false,
			datosRegistro:{
				name:"Criss A",
				email:"cristian.ap.123@gmail.com", 
				password:"password"
			},
            verRegistro: [],
            id_ficha: '',
            id_usu: '',
            filtros: {
                carrera: '',
                modalidad: '',
                estado: 1,
                dato:''
            },
            monto_a_pagar:0,

            //
            nuevoRegistro: {
                dp_apellido_p: '',
                dp_apellido_m: '',
                dp_nombre: '',
                id_tipo_documento: '',
                numero_documento: '',
                dp_edad: '',
                dp_fecha_n: '',
                dp_ln_peru: '',
                paisNacimiento: '',
                dp_ln_dep: '',
                dp_ln_prov: '',
                dp_ln_dis: '',

                paisNacimientoExt: '',
                depNacimientoExt: '',
                provNacimientoExt: '',
                disNacimientoExt: '',

                dp_sexo: '',
                dp_estado_c: '',
                da_direccion: '',
                da_dep: '',
                da_prov: '',
                da_dis: '',
                da_numero_celular: '',
                da_numero_telefono: '',
                da_email: '',
                df_nombres_padre: '',
                df_nombres_madre: '',
                df_nombres_apoderado: '',
                df_dni_apoderado: '',
                df_celular_apoderado: '',

                depColegio: '',
                provColegio: '',

                de_nom_uni: '',
                de_cred_uni:'',
                de_cod_ruv:'',

                diep_id_colegio: '',
                concluyoIE: '',
                diep_ace: '',
                mcp_id_modalidad: '',
                modalidad: 3,
                modalidad2: '',
                mcp_id_carrera: '',
                entero: '',
                extemporaneo: ''
            },
            objetoDoc: {
                documentos: '',
                requisitos: '',
                dni: '',
                foto: '',
                voucher_examen: '',
            },
            depNac: [],
            provNac: [],
            disNac: [],
            provActu: [],
            disActu: [],
            provCole: [],
            colegios: [],
		}
	},
    mounted() {
        this.buscar(1)
        this.obtenerDepartamentos()
    },
    methods: {
        async obtenerDepartamentos() {
			await axios
				.get(this.$parent.NombreRuta + "/api/departamentos")
				.then((response) => {
                    this.depNac = response.data;
                    //this.asignar(response.data)
				})
				.catch(function (error) {
				    this.depNac = [];
				});
		},
        //FICHA
        async obtenerProvincias(tipo, codigoDep) {
            await axios.put(this.$parent.NombreRuta + "/api/provincias", {
                opcion: 4,
                codigoDep: codigoDep,
            })
                .then(response => {
                    if (tipo == 1) {
                        this.provNac = response.data;
                    }
                    if (tipo == 2) {
                        this.provActu = response.data;
                    }
                    if (tipo == 3) {
                        this.provCole = response.data;
                    }

                })
        },
        async obtenerDistritos(tipo, codigoProv) {
            await axios.put(this.$parent.NombreRuta + "/api/distritos", {
                opcion: 5,
                codigoProv: codigoProv,
            })
                .then(response => {
                    if (tipo == 1) {
                        this.disNac = response.data;
                    }
                    if (tipo == 2) {
                        this.disActu = response.data;
                    }

                })
        },
        async obtenerColegios(provColegio) {
            await axios.put(this.$parent.NombreRuta + "/api/colegios", {
                provColegio: provColegio,
            })
                .then(response => {
                    this.colegios = response.data;
                })
        },

        async mostrarDatos() {
            //Boton de cargando 
            this.botonCargando=true

            let modalidad = this.filtros.modalidad
            let carrera = this.filtros.carrera
            let estado = this.filtros.estado
            let dato = this.filtros.dato
			await axios
				.get(this.$parent.NombreRuta + "/api/fichas/listar?modalidad="+modalidad +'&carrera='+carrera+'&estado='+estado+'&dato='+dato)
				.then((response) => {
                    //console.log('Mostrar datos')
				    this.datos = response.data;
                    this.botonCargando=false
				})
				.catch(function (error) {
				    this.datos = [];
                    this.botonCargando=false
				});
				},
        async registrarEstado(id_estado_revision, id, dato) {
			await axios
				.post(this.$parent.NombreRuta + "/api/pagos/prospecto", {
                    'id_estado_revision':id_estado_revision,  
			        'id':id,
                    'dato':dato,
                })
				.then((response) => {
				this.mostrarDatos()
                //this.asignar(response.data)
				})
				.catch(function (error) {
                    this.errors=error.response.data.errors;
                    console.log(error);
				});
				},
        async obtenerDocumentos(id_ficha, id_usu) {
            await axios.post(this.$parent.NombreRuta + '/api/documentos/listar', {
                id_ficha: id_ficha,
                id_usu: id_usu
            })
                .then((response) => {
                    this.documentos = response.data.documentos
                })
        },
        async obtenerPagos(id_ficha, id_usu) {
            await axios.post(this.$parent.NombreRuta + '/api/pagos/listar', {
                id_ficha: id_ficha,
                id_usu: id_usu
            })
                .then((response) => {
                    this.pagos = response.data.pagos
                })
        },
        async registrarEstado(id_estado_revision, id, dato) {
            this.botonEnviar = true;
            await axios.post(this.$parent.NombreRuta + '/api/documentos/verificar', {
                id_estado_revision: id_estado_revision,
                id: id,
                dato: dato
            }).then(response => {
                //this.obtenerDatos()
                this.obtenerDocumentos(this.id_ficha, this.id_usu)
                if (response.data == 1 && estado == 3) {
                    /* this.$toast.open({
                        message: "Archivo validado",
                        position: "bottom-right",
                        type: "success",
                        duration: 4000,
                        dismissible: true
                    }) */
                }
                if (response.data == 2 && estado == 3) {
                    /* this.$toast.open({
                        message: "Archivo no validado",
                        position: "bottom-right",
                        type: "error",
                        duration: 4000,
                        dismissible: true
                    }) */
                }
                if (response.data == 1 && estado == 2) {
                    /* this.$toast.open({
                        message: "Archivo eliminado",
                        position: "bottom-right",
                        type: "success",
                        duration: 4000,
                        dismissible: true
                    }) */
                }
                if (response.data == 2 && estado == 2) {
                    /* this.$toast.open({
                        message: "Archivo no eliminado",
                        position: "bottom-right",
                        type: "error",
                        duration: 4000,
                        dismissible: true
                    }) */
                }
                this.botonEnviar = false;
            })
        },
        async registrarEstadoPago(id_estado_revision, id, dato, codigo_pago) {
            this.botonEnviar = true;
            await axios.post(this.$parent.NombreRuta + '/api/pagos/verificar', {
                id_estado_revision: id_estado_revision,
                id: id,
                dato: dato,
                codigo_pago: codigo_pago
            }).then(response => {
                //this.obtenerDatos()
                this.obtenerPagos(this.id_ficha, this.id_usu)
                if (response.data == 1 && estado == 3) {
                    /* this.$toast.open({
                        message: "Archivo validado",
                        position: "bottom-right",
                        type: "success",
                        duration: 4000,
                        dismissible: true
                    }) */
                }
                if (response.data == 2 && estado == 3) {
                    /* this.$toast.open({
                        message: "Archivo no validado",
                        position: "bottom-right",
                        type: "error",
                        duration: 4000,
                        dismissible: true
                    }) */
                }
                if (response.data == 1 && estado == 2) {
                    /* this.$toast.open({
                        message: "Archivo eliminado",
                        position: "bottom-right",
                        type: "success",
                        duration: 4000,
                        dismissible: true
                    }) */
                }
                if (response.data == 2 && estado == 2) {
                    /* this.$toast.open({
                        message: "Archivo no eliminado",
                        position: "bottom-right",
                        type: "error",
                        duration: 4000,
                        dismissible: true
                    }) */
                }
                this.botonEnviar = false;
            })
        },
        async registrarInscripcion(id_ficha, id_usu, id_modalidad, estado, dni, email, nombres, apellidos, carrera, modalidad) {
            //this.botonInscribir=true;
            await axios.post(this.$parent.NombreRuta + '/api/fichas/inscribir', {
                id_ficha: id_ficha,
                id_usu: id_usu,
                id_modalidad: id_modalidad,
                estado : estado,
                dni : dni,
                email : email,
                nombres : nombres,
                apellidos : apellidos,
                carrera : carrera,
                modalidad : modalidad
            }).then(response => {
                //console.log('PRIMER THEN')
                //let mypromise = 
                this.mostrarDatos().then((res)=>{
                    this.ver(this.id_ficha)
                });


                /* if (response.data.inscripcion == 1 && estado==3) {
                    this.obtenerDatos()
                    this.ver(this.id_ficha)
                    this.verRegistro.id_estado=estado
                    this.$toast.open({
                        message: "Postulante inscrito",
                        position: "bottom-right",
                        type: "success",
                        duration: 4000,
                        dismissible: true
                    })
                }
                if (response.data.inscripcion == 2 && estado==3) {
                    this.$toast.open({
                        message: "Postulante no inscrito",
                        position: "bottom-right",
                        type: "error",
                        duration: 4000,
                        dismissible: true
                    })
                }
                if (response.data.inscripcion == 1 && estado==2) {
                    this.obtenerDatos()
                    this.ver(this.id_ficha)
                    this.verRegistro.id_estado=estado
                    this.$toast.open({
                        message: "Postulante rechazado",
                        position: "bottom-right",
                        type: "success",
                        duration: 4000,
                        dismissible: true
                    })
                }
                if (response.data.inscripcion == 2 && estado==2) {
                    this.$toast.open({
                        message: "Postulante no rechazado",
                        position: "bottom-right",
                        type: "error",
                        duration: 4000,
                        dismissible: true
                    })
                }*/
                this.botonInscribir=false;
                this.botonRechazar=false; 

            })
        },
        verificar(id_estado_revision, id, dato){
            //console.log('verificar')
            this.registrarEstado(id_estado_revision, id, dato)
            
        },
        verificarPago(id_estado_revision, id, dato, codigo_pago){
            //console.log('verificar')
            this.registrarEstadoPago(id_estado_revision, id, dato, codigo_pago)
            
        },
        inscribir(id_ficha, id_usu, id_modalidad, estado, dni, email, nombres, apellidos, carrera, modalidad) {
            if(estado==3){
                this.botonInscribir=true
            }else{
                this.botonRechazar=true
            }
            this.registrarInscripcion(id_ficha, id_usu, id_modalidad, estado, dni, email, nombres, apellidos, carrera, modalidad)
        },

        ///////////////////////////
        obtenerProvincia(tipo) {
            let codigoDep
            if (tipo == 1) {
                this.disNac = []
                codigoDep = this.nuevoRegistro.dp_ln_dep
            } if (tipo == 2) {
                this.disActu = []
                codigoDep = this.nuevoRegistro.da_dep
            } if (tipo == 3) {
                this.colegios = []
                codigoDep = this.nuevoRegistro.depColegio
            }
            //console.log(tipo)
            this.obtenerProvincias(tipo, codigoDep)
        },
        obtenerDistrito(tipo) {
            let codigoProv
            if (tipo == 1) {
                codigoProv = this.nuevoRegistro.dp_ln_prov
            } else {
                codigoProv = this.nuevoRegistro.da_prov
            }
            /* console.log(tipo)
            console.log(codigoProv) */
            this.obtenerDistritos(tipo, codigoProv)

        },
        obtenerColegio() {
            let provColegio = 0
            provColegio = this.nuevoRegistro.provColegio
            this.obtenerColegios(provColegio)
        },
        registrarFicha: function (
            id,
            dp_apellido_p,
            dp_apellido_m,
            dp_nombre,
            id_tipo_documento,
            numero_documento,
            dp_edad,
            dp_fecha_n,
            dp_ln_peru,
            dp_ln_pais,
            dp_ln_dep,
            dp_ln_prov,
            dp_ln_dis,
            dp_ln_dep_ext,
            dp_ln_prov_ext,
            dp_ln_dis_ext,
            dp_sexo,
            dp_estado_c,
            da_direccion,
            da_dep,
            da_prov,
            da_dis,
            da_numero_celular,
            da_numero_telefono,
            da_email,
            df_nombres_padre,
            df_nombres_madre,
            df_nombres_apoderado,
            df_dni_apoderado,
            df_celular_apoderado,
            diep_id_colegio,
            diep_ace,
            extemporaneo) {
            axios.post(this.$parent.NombreRuta + "/api/fichas/datos", {
                id: id,
                dp_apellido_p: dp_apellido_p,
                dp_apellido_m: dp_apellido_m,
                dp_nombre: dp_nombre,
                id_tipo_documento: id_tipo_documento,
                numero_documento: numero_documento,
                dp_edad: dp_edad,
                dp_fecha_n: dp_fecha_n,
                dp_ln_peru: dp_ln_peru,
                dp_ln_pais: dp_ln_pais,
                dp_ln_dep: dp_ln_dep,
                dp_ln_prov: dp_ln_prov,
                dp_ln_dis: dp_ln_dis,
                dp_ln_dep_ext: dp_ln_dep_ext,
                dp_ln_prov_ext: dp_ln_prov_ext,
                dp_ln_dis_ext: dp_ln_dis_ext,
                dp_sexo: dp_sexo,
                dp_estado_c: dp_estado_c,
                da_direccion: da_direccion,
                da_dep: da_dep,
                da_prov: da_prov,
                da_dis: da_dis,
                da_numero_celular: da_numero_celular,
                da_numero_telefono: da_numero_telefono,
                da_email: da_email,
                df_nombres_padre: df_nombres_padre,
                df_nombres_madre: df_nombres_madre,
                df_nombres_apoderado: df_nombres_apoderado,
                df_dni_apoderado: df_dni_apoderado,
                df_celular_apoderado: df_celular_apoderado,
                diep_id_colegio: diep_id_colegio,
                diep_ace: diep_ace,
                extemporaneo: extemporaneo
                //entero: entero
            }).then(response => {
                //this.ficha = response.data;
                //this.obtenerFicha()
                //this.obtenerDocumentos()
                //this.botonGuardarFicha=false
                this.mostrarDatos().then((res)=>{
                    this.editar(this.id_ficha)
                });

                if (response.data.success == 1) {
                    toastr.options = {
                        "positionClass": "toastr-bottom-right",
                        "timeOut": "5000"
                    };
                    toastr.success('Ficha actualizada');
                }else if (response.data.success == 0) {
                    toastr.options = {
                        "positionClass": "toastr-bottom-right",
                        "timeOut": "5000"
                    };
                    toastr.error('Ficha no actualizada');
                }
            });
            /* .catch((error) => {
                toastr.options = {
                    "positionClass": "toastr-bottom-right",
                    "timeOut": "5000"
                };
                toastr.error('Error al actualizar');
            }); */
            //this.botonGuardarFicha=false
        },

        registrarColegio: function (id, diep_id_colegio){
            axios.post(this.$parent.NombreRuta + "/api/fichas/colegio", {
                id: id,
                diep_id_colegio: diep_id_colegio
            }).then(response => {
                this.mostrarDatos().then((res)=>{
                    this.editar(this.id_ficha)
                });

                if (response.data.success == 1) {
                    toastr.options = {
                        "positionClass": "toastr-bottom-right",
                        "timeOut": "5000"
                    };
                    toastr.success('Colegio actualizado');
                }else if (response.data.success == 0) {
                    toastr.options = {
                        "positionClass": "toastr-bottom-right",
                        "timeOut": "5000"
                    };
                    toastr.error('Colegio no actualizado');
                }
            });
        },

        registrarModalidad: function (id, mcp_id_modalidad, mcp_id_carrera, de_nom_uni, de_cred_uni, de_cod_ruv){
            axios.post(this.$parent.NombreRuta + "/api/fichas/modalidad", {
                id: id,
                mcp_id_modalidad: mcp_id_modalidad,
                mcp_id_carrera: mcp_id_carrera,
                de_nom_uni: de_nom_uni,
                de_cred_uni: de_cred_uni,
                de_cod_ruv: de_cod_ruv,
            }).then(response => {
                this.mostrarDatos().then((res)=>{
                    this.editar(this.id_ficha)
                });

                if (response.data.success == 1) {
                    toastr.options = {
                        "positionClass": "toastr-bottom-right",
                        "timeOut": "5000"
                    };
                    toastr.success('Modalidad actualizado');
                }else if (response.data.success == 0) {
                    toastr.options = {
                        "positionClass": "toastr-bottom-right",
                        "timeOut": "5000"
                    };
                    toastr.error('Modalidad no actualizado');
                }
            });
        },

        guardarFicha() {
            /* if (this.nuevoRegistro.modalidad != 1) {
                this.modalidad = this.nuevoRegistro.modalidad2
            } else {
                this.modalidad = this.nuevoRegistro.modalidad
            } */
            /* if (this.nuevoRegistro.concluyoIE == 1) {
                this.fechaConcluyoIE = this.nuevoRegistro.fechaConcluyoIE
            } else {
                this.fechaConcluyoIE = '0000'
            } */

            //lugar de nacimiento
            this.dp_ln_peru = this.nuevoRegistro.dp_ln_peru
            if(this.nuevoRegistro.dp_ln_peru==1){
                this.dp_ln_pais='PERU',
                this.dp_ln_dep = this.nuevoRegistro.dp_ln_dep,
                this.dp_ln_prov = this.nuevoRegistro.dp_ln_prov,
                this.dp_ln_dis = this.nuevoRegistro.dp_ln_dis,

                this.dp_ln_pais_ext = '',
                this.dp_ln_dep_ext = '',
                this.dp_ln_prov_ext = '',
                this.dp_ln_dis_ext = ''
            }else{
                this.dp_ln_pais = this.nuevoRegistro.dp_ln_pais,
                this.dp_ln_dep_ext = this.nuevoRegistro.dp_ln_dep_ext,
                this.dp_ln_prov_ext = this.nuevoRegistro.dp_ln_prov_ext,
                this.dp_ln_dis_ext = this.nuevoRegistro.dp_ln_dis_ext

                this.dp_ln_pais_ext='',
                this.dp_ln_dep = 0,
                this.dp_ln_prov = 0,
                this.dp_ln_dis = 0

            }
            this.botonGuardarFicha=true,
            this.id = this.nuevoRegistro.id,
            this.dp_apellido_p = this.nuevoRegistro.dp_apellido_p,
            this.dp_apellido_m = this.nuevoRegistro.dp_apellido_m,
            this.dp_nombre = this.nuevoRegistro.dp_nombre,
            this.id_tipo_documento = this.nuevoRegistro.id_tipo_documento,
            this.numero_documento = this.nuevoRegistro.numero_documento,
            this.dp_edad = this.nuevoRegistro.dp_edad,
            this.dp_fecha_n = this.nuevoRegistro.dp_fecha_n,

            this.dp_sexo = this.nuevoRegistro.dp_sexo,
            this.dp_estado_c = this.nuevoRegistro.dp_estado_c,
            this.da_direccion = this.nuevoRegistro.da_direccion,
            this.da_dep = this.nuevoRegistro.da_dep,
            this.da_prov = this.nuevoRegistro.da_prov,
            this.da_dis = this.nuevoRegistro.da_dis,
            this.da_numero_celular = this.nuevoRegistro.da_numero_celular,
            this.da_numero_telefono = this.nuevoRegistro.da_numero_telefono,
            this.da_email = this.nuevoRegistro.da_email,
            this.df_nombres_padre = this.nuevoRegistro.df_nombres_padre,
            this.df_nombres_madre = this.nuevoRegistro.df_nombres_madre,
            this.df_nombres_apoderado = this.nuevoRegistro.df_nombres_apoderado,
            this.df_dni_apoderado = this.nuevoRegistro.df_dni_apoderado,
            this.df_celular_apoderado = this.nuevoRegistro.df_celular_apoderado,
            this.diep_id_colegio = this.nuevoRegistro.diep_id_colegio,
            this.diep_ace = this.nuevoRegistro.diep_ace,
            this.extemporaneo = this.nuevoRegistro.extemporaneo,

            this.registrarFicha(this.id,
                this.dp_apellido_p,
                this.dp_apellido_m,
                this.dp_nombre,
                this.id_tipo_documento,
                this.numero_documento,
                this.dp_edad,
                this.dp_fecha_n,
                this.dp_ln_peru,
                this.dp_ln_pais,
                this.dp_ln_dep,
                this.dp_ln_prov,
                this.dp_ln_dis,
                this.dp_ln_dep_ext,
                this.dp_ln_prov_ext,
                this.dp_ln_dis_ext,
                this.dp_sexo,
                this.dp_estado_c,
                this.da_direccion,
                this.da_dep,
                this.da_prov,
                this.da_dis,
                this.da_numero_celular,
                this.da_numero_telefono,
                this.da_email,
                this.df_nombres_padre,
                this.df_nombres_madre,
                this.df_nombres_apoderado,
                this.df_dni_apoderado,
                this.df_celular_apoderado,
                this.diep_id_colegio,
                this.diep_ace,
                this.extemporaneo
                )
        },
        ///////////////////////////

        ver(id_ficha) {
            //
            const found = this.datos.find(element => element.id == id_ficha);
            this.id_ficha = found.id
            this.id_usu = found.user_id
            this.verRegistro = Object.assign({}, found);
            this.obtenerDocumentos(found.id, found.user_id)
            this.obtenerPagos(found.id, found.user_id)
        },
        editar(id_ficha) {
            //
            //console.log('editar')
            const found = this.datos.find(element => element.id == id_ficha);
            this.id_ficha = found.id
            this.id_usu = found.id_usu
            this.nuevoRegistro = Object.assign({}, found);
            if(found.dp_ln_peru){
                this.obtenerProvincias(1, found.dp_ln_dep)
                this.obtenerDistritos(1, found.dp_ln_prov)
            }
            this.obtenerProvincias(2, found.da_dep)
            this.obtenerDistritos(2, found.da_prov)
            this.obtenerDocumentos(found.id, found.user_id)
            //console.log(found)
            //this.obtenerDocumentos(found.id, found.user_id)
            //this.obtenerPagos(found.id, found.user_id)
        },

        nombrePago(id_tipo_pago){
            let nombre = ''
            if(id_tipo_pago==1){
                nombre = 'PROSPECTO'
            }else if(id_tipo_pago==2){
                nombre = 'DERECHO DE INSCRIPCIÓN'
            }else if(id_tipo_pago==3){
                nombre = 'PROSPECTO Y DEPRECHO DE INSCRIPCIÓN'
            }else if(id_tipo_pago==4){
                nombre = 'RECARGO REZAGADO'
            }else if(id_tipo_pago==5){
                nombre = 'DERECHO DE SEGUNDO EXAMEN'
            }else if(id_tipo_pago==6){
                nombre = 'RDERECHO DE TERCER EXAMEN'
            }else if(id_tipo_pago==7){
                nombre = 'CONSTANCIA DE INGRESO'
            }
            return nombre
        },

        guardarColegio(){
            //this.nuevoRegistro.diep_id_colegio

            this.registrarColegio(this.nuevoRegistro.id,this.nuevoRegistro.diep_id_colegio)
        },
        guardarModalidad(){
            this.id = this.nuevoRegistro.id
            this.mcp_id_modalidad = this.nuevoRegistro.mcp_id_modalidad
            this.mcp_id_carrera = this.nuevoRegistro.mcp_id_carrera
            this.de_nom_uni = this.nuevoRegistro.de_nom_uni
            this.de_cred_uni = this.nuevoRegistro.de_cred_uni
            this.de_cod_ruv = this.nuevoRegistro.de_cod_ruv

            let suma_documentos= 0
            let actualizar_modalidad = false
            for (var i = 0; i < this.documentos.length; i++) {
                suma_documentos = this.documentos[i].tipo_documento_id + suma_documentos
                /* if (this.documentos[i].id_estado_revision == 0 || this.documentos[i].id_estado_revision == 2 || this.documentos[i].id_estado_revision == 1) {
                    estado = true;
                    if (this.documentos[i].tipo_documento_id == 1) {
                        mensaje += "<li>Fichas de inscripción no validado.</li> "
                    }
                    if (this.documentos[i].tipo_documento_id == 2) {
                        mensaje += "<li>Requisitos no validados.</li> "
                    }
                    if (this.documentos[i].tipo_documento_id == 3) {
                        mensaje += "<li>DNI no validado.</li> "
                    }
                     if (this.documentos[i].tipo_documento_id == 4) {
                        mensaje += "<li>Fotos validados.</li> "
                    }
                } */
            };

            if(this.mcp_id_modalidad==1 && suma_documentos==7){
                actualizar_modalidad = true
            }else if(this.mcp_id_modalidad!=1 && this.mcp_id_modalidad!=8 && suma_documentos==9){
                actualizar_modalidad = true
            }else if(this.mcp_id_modalidad==8 && suma_documentos==5){
                actualizar_modalidad = true
            }

            
            if(actualizar_modalidad){
                
                this.registrarModalidad(this.id, this.mcp_id_modalidad, this.mcp_id_carrera, this.de_nom_uni, this.de_cred_uni, this.de_cod_ruv)  
            }else{
                toastr.options = {
                    "positionClass": "toastr-bottom-right",
                    "timeOut": "5000"
                };
                toastr.error('Lista de documentos incompletos');
            }
            console.log(suma_documentos)
        },
/*         guardarEstado(estado, id_documento, dato) {
            this.registrarEstado(estado, id_documento, dato)
        }, */
        buscar(opcion) {
            switch (opcion) {
                case 0:
                    this.filtros.dato = '',
                    this.filtros.modalidad = '',
                    this.filtros.carrera = '',
                    this.filtros.estado = ''
                    break;
                case 1:
                    this.filtros.dato = ''
                    break;
                case 2:
                    this.filtros.modalidad = '',
                    this.filtros.carrera = '',
                    this.filtros.estado = ''
                    break;
            }
            this.mostrarDatos()
        },
        handleFileUpload(tipo) {
            /* if (tipo == 1) {
                this.objetoDoc.documentos = this.$refs.file1.files[0];
            }
            if (tipo == 2) {
                this.objetoDoc.requisitos = this.$refs.file2.files[0];
            }
            if (tipo == 3) {
                this.objetoDoc.dni = this.$refs.file3.files[0];
            } */
            if (tipo == 4) {
                this.objetoDoc.foto = this.$refs.file4[0].files[0];
                //this.urlfoto = URL.createObjectURL(this.objetoDoc.foto);
            }
            //console.log(this.objetoDoc.documentos)
            //console.log('Foto')
            console.log(this.objetoDoc.foto)
        },
        guardarFoto(item){
            //console.log(item)
            //console.log('guardarFoto')
            var formData = new FormData();
            formData.append("opcion", 2);
            formData.append("id", item.id);
            formData.append("tipo_documento_id", item.tipo_documento_id);
            formData.append("enlace",item.enlace);
            formData.append("id_estado_revision",item.id_estado_revision);
            formData.append("archivo", this.objetoDoc.foto);

			this.axios.post(this.$parent.NombreRuta + `/api/documentos/foto?_method=PUT`, formData)
            .then((response) => {
                this.obtenerDocumentos(this.id_ficha, this.id_usu)
                if(response.data.success==1){
                    toastr.options = {
                        "positionClass": "toastr-bottom-right",
                        "timeOut": "5000"
                    };
                    toastr.success('archivo enviado');
                    this.cerrarModal()
                }else{
                    toastr.options = {
                        "positionClass": "toastr-bottom-right",
                        "timeOut": "5000"
                    };
                    toastr.error('archivo no enviado');
                }
				//location.href ="/login";
            })
            .catch((error) => {
                this.errors=error.response.data.errors;
                console.log(error);
            });
        },

        encodeid(id) {
            let codigo = btoa(id);
            return codigo;
        },
    },
    computed: {
        listaModalidad() {
            if (this.nuevoRegistro.modalidad == 1) {
                this.listaExtraordinario = true
                this.nuevoRegistro.modalidad2 = ''
            } else if(this.nuevoRegistro.modalidad == 3) {
                this.listaExtraordinario = true
            } else {
                this.listaExtraordinario = false
            }
            return this.listaExtraordinario
        },
        btnRevision: function () {
            let estado = false
            let mensaje = ''
            let monto_pagar = 1000
            let monto_pagado = 0
            let documentosValidos = true
            /* if(this.ficha==0){
                estado=true
                mensaje += "<li>Completar la ficha de inscripción.</li> "
            } */
            for (var i = 0; i < this.documentos.length; i++) {
                if (this.documentos[i].id_estado_revision == 0 || this.documentos[i].id_estado_revision == 2 || this.documentos[i].id_estado_revision == 1) {
                    estado = true;
                    documentosValidos = false;
                    if (this.documentos[i].tipo_documento_id == 1) {
                        mensaje += "<li>Fichas de inscripción no validado.</li> "
                    }
                    if (this.documentos[i].tipo_documento_id == 2) {
                        mensaje += "<li>Requisitos no validados.</li> "
                    }
                    if (this.documentos[i].tipo_documento_id == 3) {
                        mensaje += "<li>DNI no validado.</li> "
                    }
                     if (this.documentos[i].tipo_documento_id == 4) {
                        mensaje += "<li>Fotos no validados.</li> "
                    }
                }
            };

            for (var i = 0; i < this.pagos.length; i++) {
                if (this.pagos[i].id_estado_revision == 0 || this.pagos[i].id_estado_revision == 2 || this.pagos[i].id_estado_revision == 1) {
                    
                    if(this.verRegistro.mcp_id_modalidad==7){
                        
                    }else{
                        estado = true;
                    }
                    
                    //console.log('documentos for dentro if')
                    if (this.pagos[i].id_tipo_pago == 1) {
                        mensaje += "<li>Prospecto no comprado.</li> "
                    }
                    if (this.pagos[i].id_tipo_pago == 2) {
                        mensaje += "<li>Voucher derecho de examen no validado.</li> "
                    }
                }
                if(this.pagos[i].id_estado_revision == 3){
                    monto_pagado = this.pagos[i].monto_pago + monto_pagado
                }
            };

            if(this.verRegistro.postulacion==1 && !(this.verRegistro.mcp_id_modalidad==7)){
                monto_pagar = 50
            }else{
                monto_pagar = 0
            }

            //verificar monto a pagar
            if(this.verRegistro.mcp_id_modalidad==1 || this.verRegistro.mcp_id_modalidad==2 || this.verRegistro.mcp_id_modalidad==5 || this.verRegistro.mcp_id_modalidad==6 ||this.verRegistro.mcp_id_modalidad==8 || this.verRegistro.mcp_id_modalidad==11){
                if(this.verRegistro.gestion_colegio==1 || this.verRegistro.gestion_colegio==2){
                    monto_pagar = monto_pagar + 250
                }else{
                    monto_pagar = monto_pagar + 300
                }
            }else if(this.verRegistro.mcp_id_modalidad==3){
                monto_pagar = monto_pagar + 500
            }else if(this.verRegistro.mcp_id_modalidad==4){
                monto_pagar = monto_pagar + 350
            }else if(this.verRegistro.mcp_id_modalidad==7){
                monto_pagar = monto_pagar + 0
            }
            /*else if(this.verRegistro.mcp_id_modalidad==8){
                monto_pagar = monto_pagar + 0
            }*/
            else if(this.verRegistro.mcp_id_modalidad==10){
                monto_pagar = monto_pagar + 200
            }

            if(this.verRegistro.extemporaneo==1){
                monto_pagar = monto_pagar + 30
            }
            this.monto_a_pagar=monto_pagar

            //console.log('monto_pagar: ' + monto_pagar)
            //console.log('monto_pagado: ' + monto_pagado)
            

            if (this.documentos == 0) {
                estado = true
                //console.log('documentos == 0')
                mensaje += "<li>El postulante no completo la ficha de inscripción.</li> "
            }

            if (this.pagos==0 && !(this.verRegistro.mcp_id_modalidad==7)) {
                estado = true
                mensaje += "<li>Comprobantes de pago no enviados.</li> "
            }
            //console.log(monto_pagado)
            if(monto_pagado<monto_pagar){
                estado=true
                mensaje += "<li>Monto de pago incompleto.</li> "
            }else if(documentosValidos){
                estado=false
            }

            this.msgInscribir = mensaje
            this.botonInscribirDisabled = estado
            return mensaje
        },
        /* estadoModal: function () {
            let estado
            var div = document.getElementById("m_modal_4");
            console.log(div.style.display)
            if(div.style.display=="block"){
                estado=true
            }else{
                estado=false
            }
            this.Modal=estado
            return estado
        }, */
    },
}
</script>