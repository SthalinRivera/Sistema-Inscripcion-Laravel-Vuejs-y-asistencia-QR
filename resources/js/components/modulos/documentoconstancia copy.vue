<template>
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">Constancia de ingreso</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Realiza los siguientes procedimientos</span>
            </h3>
        </div>
        <div class="card-body py-3">
            <div>
                <ul class="nav nav-pills mb-8 mt-8 nav-fill" id="pills-tab" role="tablist">
                    
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-profile-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                            aria-selected="true" disabled>Subir requisitos (1)</button>
                    </li>
                    <!-- <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-carne-tab" data-bs-toggle="pill" data-bs-target="#pills-carne"
                            type="button" role="tab" aria-controls="pills-carne" aria-selected="false">Constancia de Ingreso (2)</button>
                    </li> -->
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">                        
                        <div v-if="ficha != 0 && ficha[0].dj_todos == 1" class="table-responsive">
                            <div class="row">
                                <!-- MODALIDAD -->
                                <td class="col-md-6">
                                    <div class="alert alert-primary" role="alert">
                                        MODALIDAD:
                                        <span v-if="ficha[0].mcp_id_modalidad == 1">
                                            ORDINARIO
                                        </span>
                                        <span v-else-if="ficha[0].mcp_id_modalidad == 2">
                                            PRIMEROS PUESTOS
                                        </span>
                                        <span v-else-if="ficha[0].mcp_id_modalidad == 3">
                                            GRADUADOS Y TITULADOS
                                        </span>
                                        <span v-else-if="ficha[0].mcp_id_modalidad == 4">
                                            TRASLADO EXTERNO
                                        </span>
                                        <span v-else-if="ficha[0].mcp_id_modalidad == 5">
                                            DISCAPACIDAD
                                        </span>
                                        <span v-else-if="ficha[0].mcp_id_modalidad == 6">
                                            DEPORTISTAS CALIFICADOS
                                        </span>
                                        <span v-else-if="ficha[0].mcp_id_modalidad == 7">
                                            VICTIMAS DE TERRORISMO
                                        </span>
                                        <span v-else-if="ficha[0].mcp_id_modalidad == 8">
                                            CEPRE (ingresante)
                                        </span>
                                        <span v-else-if="ficha[0].mcp_id_modalidad == 10">
                                            TRASLADO INTERNO
                                        </span>
                                        <span v-else-if="ficha[0].mcp_id_modalidad == 11">
                                            QUINTO DE SECUNDARIA
                                        </span>
                                    </div>
                                </td>
                                <!-- CARRERA -->
                                <td class="col-md-6">
                                    <div class="alert alert-primary" role="alert">
                                        CARRERA:
                                        <span v-if="ficha[0].mcp_id_carrera == 1">
                                            ADMINISTRACIÓN
                                        </span>
                                        <span v-else-if="ficha[0].mcp_id_carrera == 2">
                                            CONTABILIDAD
                                        </span>
                                        <span v-else-if="ficha[0].mcp_id_carrera == 3">
                                            ADMINISTRACIÓN DE TURISMO Y HOTELERÍA
                                        </span>
                                        <span v-else-if="ficha[0].mcp_id_carrera == 4">
                                            INGENIERÍA DE SISTEMAS
                                        </span>
                                        <span v-else-if="ficha[0].mcp_id_carrera == 5">
                                            AGRONOMÍA
                                        </span>
                                    </div>
                                </td>
                            </div>
                            <table class="table align-middle gs-0 gy-4">
                                <thead>
                                    <tr class="fw-bold text-muted bg-light">
                                        <th class="ps-4 rounded-start">Documento</th>
                                        <th class="min-w-125px">Subir archivo</th>
                                        <th class="min-w-125px text-center">Archivo enviado</th>
                                        <th class="min-w-125px">Estado</th>
                                        <th class="text-center rounded-end">Observación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- <tr v-for="requisitoconstancia in documentos" :key="requisitoconstancia.id"> -->
                                    <tr v-if="ficha!=0 && ficha[0].condicion=='INGRESO'">
                                        <td class="ps-4">
                                            <span>Requisitos para Constancia de Ingreso</span>
                                        </td>

                                        <td>
                                            <div class="input-group">
                                                <button type="button" class="btn btn-primary" @click="editarDocumento(requisitoconstancia)"
                                                    data-bs-toggle="modal" data-bs-target="#kt_modal_1">Subir</button>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a v-if="requisitoconstancia.enlace" :href="'storage/documentos/' + requisitoconstancia.enlace" target="_blank">
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
                                        </td>
                                        <td>
                                            <span v-if="requisitoconstancia == 0" class="badge badge-danger badge-lg">
                                                No disponible
                                            </span>
                                            <span v-if="requisitoconstancia.id_estado_revision == 0" class="badge badge-danger badge-lg">
                                                Sin enviar
                                            </span>
                                            <span v-if="requisitoconstancia.id_estado_revision == 1" class="badge badge-warning badge-lg">
                                                Pendiente de validación
                                            </span>
                                            <span v-if="requisitoconstancia.id_estado_revision == 2" class="badge badge-danger badge-lg">
                                                Rechazado
                                            </span>
                                            <span v-if="requisitoconstancia.id_estado_revision == 3" class="badge badge-success badge-lg">
                                                Validado
                                            </span>
                                        </td>
                                        <td class="text-init">
                                            <span>{{ requisitoconstancia.observacion }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="modal fade" tabindex="-1" id="kt_modal_1" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title">Requisito para Constancia de Ingreso</h3>
                                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                                data-bs-dismiss="modal" aria-label="Close">
                                                <span class="svg-icon svg-icon-1">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                                            transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                                        <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                                            transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                        <form id="requisitos-modalidad" @submit.prevent="guardarArchivo(subirDocumento.id, subirDocumento.tipo_documento_id)">
                                            <div class="modal-body">
                                                <div v-if="subirDocumento.tipo_documento_id == 5">
                                                    <div class="form-group m-form__group m--margin-top-10">
                                                        <div class="alert alert-warning" role="alert">
                                                            El archivo debe contener los siguientes documentos. <br>

                                                            <div v-if="id_modalidad_usu == 1">
                                                                - Declaración jurada requisito del ingresante. <br>
                                                            </div>
                                                            <div v-else-if="id_modalidad_usu == 2">
                                                                - Constancia otorgada del director del Centro Educativo de
                                                                cual procede, que acredite el orden de mérito en el que se
                                                                encuentra, refrendado por la UGEL correspondiente. <br>
                                                                - Certificado de estudios, con las calificaciones
                                                                aprobatorias de Secundaria.<br>
                                                            </div>
                                                            <div v-else-if="id_modalidad_usu == 3">
                                                                - Fotocopia autenticada por la universidad de origen del
                                                                título o grado académico otorgado por una universidad o
                                                                institución educativa con rango universitario. <br>
                                                                - Certificados oficiales en original de los estudios
                                                                universitarios, con calificación aprobatoria y sin
                                                                enmendaduras.<br>
                                                            </div>
                                                            <div v-else-if="id_modalidad_usu == 4">
                                                                - Certificados originales de estudios universitarios que
                                                                acrediten tener por lo menos aprobados cuatro periodos
                                                                lectivos o dos anuales o 72 créditos. <br>
                                                                - Constancia original de ingreso de la Universidad de
                                                                procedencia.<br>
                                                                - Constancia de no haber sido separado de su Institución de
                                                                procedencia por medida disciplinaria o falta grave.<br>
                                                            </div>
                                                            <div v-else-if="id_modalidad_usu == 10">
                                                                - Certificados originales de estudios universitarios que
                                                                acrediten tener por lo menos aprobados cuatro periodos
                                                                lectivos y 72 créditos, con un promedio ponderado mínimo de
                                                                14. <br>
                                                                - Constancia de no haber sido separado de la UNDC por medida
                                                                disciplinaria o falta grave.<br>
                                                            </div>
                                                            <div v-else-if="id_modalidad_usu == 5">
                                                                - Resolución del CONADIS que acredite la condición de
                                                                discapacidad del postulante. <br>
                                                                - Certificados de estudios con las calificaciones
                                                                aprobatorias de Secundaria.<br>
                                                            </div>
                                                            <div v-else-if="id_modalidad_usu == 7">
                                                                - Certificado de Acreditación del postulante en el Libro
                                                                Primero del Registro Único de Víctima (RUV) adscrito a la
                                                                Presidencia del Consejo de Ministros. <br>
                                                                - Certificados de estudios con las calificaciones
                                                                aprobatorias de Secundaria.<br>
                                                            </div>
                                                            <div v-else-if="id_modalidad_usu == 8">
                                                                - Constancia de ingreso emitida por el CENTRO PRE. <br>
                                                            </div>
                                                            <div v-else>
                                                                - Requisito por modalidad segun el reglamento. <br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group">
                                                        <label for="exampleInputEmail1">
                                                            File Browser
                                                        </label>
                                                        <div class="input-group mb-3">
                                                            <input 
                                                                type="file" 
                                                                @change="select_file_constancia_ingreso" :disabled="subirDocumento.id_estado_revision==3 " 
                                                                class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required>                                                           
                                                        </div>
                                                        <label for="exampleFormControlFile1">Formato admitido: PDF, RAR.</label>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="m-form__actions">
                                                    <button type="submit" class="btn btn-primary">
                                                        Subir archivo
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-start">
                                                <button type="button" id="btnCerrarModal" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>

                                                <button type="submit" class="btn btn-primary" :disabled='subirDocumento.id_estado_revision == 3 || subirDocumento == 0'>Enviar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div v-else class="alert alert-dismissible bg-danger d-flex flex-column flex-sm-row p-5 mb-10">
                            <span class="svg-icon svg-icon-2hx svg-icon-light me-4 mb-5 mb-sm-0">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3"
                                        d="M2 4V16C2 16.6 2.4 17 3 17H13L16.6 20.6C17.1 21.1 18 20.8 18 20V17H21C21.6 17 22 16.6 22 16V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4Z"
                                        fill="currentColor"></path>
                                    <path
                                        d="M18 9H6C5.4 9 5 8.6 5 8C5 7.4 5.4 7 6 7H18C18.6 7 19 7.4 19 8C19 8.6 18.6 9 18 9ZM16 12C16 11.4 15.6 11 15 11H6C5.4 11 5 11.4 5 12C5 12.6 5.4 13 6 13H15C15.6 13 16 12.6 16 12Z"
                                        fill="currentColor"></path>
                                </svg>
                            </span>
                            <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                                <h4 class="mb-2 light">Completar la Ficha de inscripción</h4>
                            </div>
                        </div><br>

                        <div v-if="ficha != 0 && ficha[0].id_estado_revision == 1 && ficha[0].dj_todos == 1"
                            class="alert alert-warning" role="alert">
                            <strong>
                                Pendiente!
                            </strong>
                            Su Constancia de Ingreso se mostrará despues de validado sus documentos.
                        </div>
                        <div v-if="ficha != 0 && ficha[0].id_estado_revision == 2 && ficha[0].dj_todos == 1"
                            class="alert alert-danger" role="alert">
                            <strong>
                                Rechazado!
                            </strong>
                            Revise sus documentos y vuelvalos a enviar.
                        </div>
                        <div v-if="ficha != 0 && ficha[0].id_estado_revision == 3 && ficha[0].dj_todos == 1"
                            class="alert alert-success" role="alert">
                            <strong>
                                Validado!
                            </strong>
                            Sus documentos han sido verificado exitosamente.
                        </div>

                        <div v-if="ficha != 0 && ficha[0].dj_todos == 1" align="center">
                            <button type="button" class="btn btn-success" @click.prevent="solicitarRevicion"
                                :disabled="btnRevision">
                                Solicitar revisión
                            </button>
                        </div>
                    </div>
                    <!-- Constancia de ingreso para descargar -->
                    <!-- <div class="tab-pane fade" id="pills-carne" role="tabpanel" aria-labelledby="pills-carne-tab">
                        <div class="text-center">
                            <div class="row" style="justify-content: center">
                                <div class="text-center col-md-10" v-if="ficha != 0 && ficha[0].id_estado_revision == 3">
                                    <div
                                        class="alert alert-dismissible bg-success d-flex flex-column flex-sm-row p-5 mb-10">
                                        <span class="svg-icon svg-icon-2hx svg-icon-light me-4 mb-5 mb-sm-0"><svg width="24"
                                                height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.3"
                                                    d="M2 4V16C2 16.6 2.4 17 3 17H13L16.6 20.6C17.1 21.1 18 20.8 18 20V17H21C21.6 17 22 16.6 22 16V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4Z"
                                                    fill="currentColor"></path>
                                                <path
                                                    d="M18 9H6C5.4 9 5 8.6 5 8C5 7.4 5.4 7 6 7H18C18.6 7 19 7.4 19 8C19 8.6 18.6 9 18 9ZM16 12C16 11.4 15.6 11 15 11H6C5.4 11 5 11.4 5 12C5 12.6 5.4 13 6 13H15C15.6 13 16 12.6 16 12Z"
                                                    fill="currentColor"></path>
                                            </svg></span>
                                        <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                                            <h4 class="mb-2 light">¡Felicitaciones por tu ingreso!</h4>
                                            <span>La descarga de tu constancia se habilitará cuando se verifique tus documentos</span>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="text-center col-md-10" v-else>
                                    <div class="alert alert-dismissible bg-danger d-flex flex-column flex-sm-row p-5 mb-10">
                                        <span class="svg-icon svg-icon-2hx svg-icon-light me-4 mb-5 mb-sm-0"><svg width="24"
                                                height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.3"
                                                    d="M2 4V16C2 16.6 2.4 17 3 17H13L16.6 20.6C17.1 21.1 18 20.8 18 20V17H21C21.6 17 22 16.6 22 16V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4Z"
                                                    fill="currentColor"></path>
                                                <path
                                                    d="M18 9H6C5.4 9 5 8.6 5 8C5 7.4 5.4 7 6 7H18C18.6 7 19 7.4 19 8C19 8.6 18.6 9 18 9ZM16 12C16 11.4 15.6 11 15 11H6C5.4 11 5 11.4 5 12C5 12.6 5.4 13 6 13H15C15.6 13 16 12.6 16 12Z"
                                                    fill="currentColor"></path>
                                            </svg></span>
                                        <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                                            <h4 class="mb-2 light">Complete el paso anterior!</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-if="1" class="row" style="justify-content: center;">
                                <div v-if="ficha != 0 && ficha[0].mcp_id_modalidad != 8 && ficha[0].id_estado_revision == 3"
                                    class="col-md-10">
                                    <div class="m-portlet__body mb-10">
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                                                <span >
                                                    <a v-bind:href="'#'" target="_blank"><img
                                                            :src="$parent.NombreRuta + '/assets/media/images/carne_postulante_modelo_2023.jpg'"
                                                            alt="" style="width: 100%;height: 500px;"></a>
                                                </span>
                                            </div>
                                                <div class="col-lg-12 m--align-right">
                                                    <a v-bind:href="'proceso/fichaspdf/carnepdf.php?d=' + encodeid(ficha[0].id_ficha)"
                                                        target="_blank"><i class="flaticon-profile"></i>
                                                    </a>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                                        <div class="m-form__actions m-form__actions--solid">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="mb-2">
                                                        <a v-if="ficha[0].id_estado_revision == 3 && ficha[0].id_aula"
                                                            v-bind:href="$parent.NombreRuta + '/inscripcion/constanciaingreso?token=' + encodeid(ficha[0].id)"
                                                            class="btn btn-success btn-block w-100"
                                                            target="_blank">Constancia
                                                        </a>
                                                        <a v-else href="" class="btn btn-primary btn-block disabled w-100"
                                                            target="_blank" disabled>Proximamente
                                                        </a>
                                                    </div>
                                                    <br>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <br>
                            <br>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            datos: [],
            ficha: [],
            botonRevision: true,
            botonEnviar: false,
            btnEnviando: false,
            botonGuardarFicha: false,
            loadingData: true,

            msgRevision: '',            

            requisitoconstancia: {
                tipo_documento_id: 5,
                created:0,
                archivo:null
            },
            subirDocumento: {
                ficha_id: '',
                tipo_documento_id: '5',
                id_estado_revision: '',
                id_tipo_enlace: '',
                id_estado: '',
                nombre: '',
            },
            

            txtenconde: '',

            //SUBIR DOCUMENTOS
            archivos: [],
            pagos: [],
            documentos: [],
            requisitos: [],
            dni: [],
            foto: [],
            voucher_examen: [],
            codigo_pago: '',
            objetoDoc: {
                documentos: '',
                requisitos: '',
                dni: '',
                foto: '',
                voucher_examen: '',
            },
            urlfoto: 'https://via.placeholder.com/240x288',
            id_modalidad_usu: '',
            id_ficha_usu: '',
            id_estado_usu: '',
            // horas_carne: ''
        }
    },
    mounted() {
        // this.obtenerDepartamentos()
        this.obtenerFicha()
        this.obtenerPagos()
        // setTimeout(this.asignarDatos, 2000);
    },
    methods: {
        async obtenerFicha() {
            this.botonGuardarFicha = true,
                this.loadingData = true
            await axios
                .get(this.$parent.NombreRuta + "/api/fichas")
                .then((response) => {
                    this.loadingData = false
                    this.botonGuardarFicha = false
                    this.ficha = response.data
                    if (this.ficha != 0) {
                        this.id_modalidad_usu = this.ficha[0].mcp_id_modalidad
                        this.id_ficha_usu = this.ficha[0].id
                        this.id_estado_usu = this.ficha[0].id_estado
                        this.obtenerDocumentos()
                    }
                })
                .catch(function (error) {
                    this.loadingData = false
                    this.ficha = [];
                });
        },
        async obtenerDocumentos() {
            let id_ficha = this.id_ficha_usu
            await axios
                .get(this.$parent.NombreRuta + "/api/documentos?id_ficha=" + id_ficha)
                .then((response) => {
                    this.documentos = response.data;
                })
                .catch(function (error) {
                    this.documentos = [];
                });
        },
        async obtenerPagos() {
            await axios
                .get(this.$parent.NombreRuta + "/api/pagos")
                .then((response) => {
                    this.pagos = response.data;
                })
                .catch(function (error) {
                    this.pagos = [];
                });
        },
        //FICHA
        select_file_constancia_ingreso(event){
            this.archivo = event.target.files[0];      
        },

        handleFileUpload(tipo) {
            // if (tipo == 1) {
            //     this.objetoDoc.documentos = this.$refs.file1.files[0];
            // }
            // if (tipo == 2) {
            //     this.objetoDoc.requisitos = this.$refs.file2.files[0];
            // }
            // if (tipo == 3) {
            //     this.objetoDoc.dni = this.$refs.file3.files[0];
            // }
            // if (tipo == 4) {
            //     this.objetoDoc.foto = this.$refs.file4.files[0];
            //     this.urlfoto = URL.createObjectURL(this.objetoDoc.foto);
            // }
            if (tipo == 5) {
                this.objetoDoc.requisitoconstancia = this.$refs.file4.files[0];
            }
        },
        encodeid(id) {

            let codigo = btoa(id);
            return codigo;
        },
        //Crear Documentos
        async crear(id_documento, archivo, tipo){
            this.btnEnviando=true
            var formData = new FormData();
            formData.append("opcion", 5);
            formData.append("id_documento", id_documento);
            formData.append("tipo", tipo);
            formData.append("archivo", archivo);
            
			this.axios.post(this.$parent.NombreRuta + `/api/documentos`, formData)
            .then((response) => {
                this.mostrarDatos()
                this.btnEnviando=false
                document.getElementById("inputGroupFile04").value = "";
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
            })
            .catch((error) => {
                this.btnEnviando=false
                this.errors=error.response.data.errors;
                toastr.options = {
                    "positionClass": "toastr-bottom-right",
                    "timeOut": "5000"
                };
                toastr.error('Archivo no enviado');
            });
        },
        editarDocumento(id_documento, archivo, tipo){
            this.subirDocumento = Object.assign ({},id_documento, archivo, tipo)
            document.getElementById("inputGroupFile04").value = "";
        },

        //SUBIR DOCUMENTOS
        async subirArchivo(id_documento, archivo, tipo) {

            this.botonEnviar = true;
            if(datos.id_documento==5){
                this.btnEnviando = true
            }

            var formData = new FormData();
            formData.append("opcion", 2);
            formData.append("id_documento", id_documento);
            formData.append("tipo", tipo);
            formData.append("archivo", archivo);

            this.axios.post(this.$parent.NombreRuta + `/api/documentos/` + id_documento + `?_method=PUT`, formData)
                .then((response) => {
                    this.obtenerDocumentos()
                    if (response.data.success == 1) {
                        toastr.options = {
                            "positionClass": "toastr-bottom-right",
                            "timeOut": "5000"
                        };
                        toastr.success('archivo enviado');
                        this.cerrarModal()
                    } else {
                        toastr.options = {
                            "positionClass": "toastr-bottom-right",
                            "timeOut": "5000"
                        };
                        toastr.error('archivo no enviado');
                    }
                    //location.href ="/login";
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                    console.log(error);
                });
        },
        subirArchivo12123: function (id_documento, archivo, tipo, codigo_pago) {
            this.botonEnviar = true;
            var formData = new FormData();
            // formData.append("opcion", 2);
            formData.append("id_documento", id_documento);
            formData.append("tipo", tipo);
            formData.append("archivo", archivo);
            formData.append("codigo_pago", codigo_pago);
            axios.post(url3, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
            }).then(response => {
                this.obtenerDatos()
                if (response.data == 1) {
                    this.$toast.open({
                        message: "Archivo enviado",
                        position: "top-right",
                        type: "success",
                        duration: 4000,
                        dismissible: true
                    })
                }
                if (response.data == 2) {
                    this.$toast.open({
                        message: "Archivo no enviado",
                        position: "top-right",
                        type: "error",
                        duration: 4000,
                        dismissible: true
                    })
                }
                if (response.data == 3) {
                    this.$toast.open({
                        message: "Extensión incorrecta",
                        position: "top-right",
                        type: "error",
                        duration: 4000,
                        dismissible: true
                    })
                }
            })
                .finally(() => this.botonEnviar = false)
        },


        enlacefoto(enlace) {
            if (enlace != null) {
                this.urlfoto = 'storage/documentos/' + enlace
            }
            return this.urlfoto
        },

        guardarArchivo(datos) {
            if(datos.created==0){
                this.crear(datos)
            }else{
                this.subirArchivo(datos)
            }
        },

        solicitarRevicion() {

            this.id_ficha = this.ficha[0].id

            this.registrarRevicion(this.id_ficha)
        },

        conforCarne(id_ficha) {
            //console.log(id_ficha)
            this.guardarConforCarne(id_ficha)
        },
        cerrarModal() {
            document.getElementById('btnCerrarModal').click();
        },
    },
    computed: {
        opcionCarne() {
            let estado
            let fecha_car = this.ficha[0].fecha_carne

            var fecha = new Date();
            var fecha_carne = new Date(fecha_car);
            console.log(fecha_carne > fecha);

            let resta = fecha_carne.getTime() - fecha.getTime()
            console.log(resta)
            this.horas_carne = parseInt(resta / (1000 * 60 * 60))

            if (fecha_carne >= fecha) {
                estado = true
            } else {
                estado = false
            }
            return estado
        },
        listaModalidad() {
            if (this.nuevoRegistro.modalidad == 1 || this.nuevoRegistro.modalidad == 11) {
                this.listaExtraordinario = true
                this.nuevoRegistro.modalidad2 = ''
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

            let prospectoPendiente = false
            let examenPendiente = false
            let ambosPendiente = false

            let pagosSinEnviar = true
            if (this.ficha == 0) {
                estado = true
                mensaje += "<li>Completar la ficha de inscripción.</li> "
            }
            for (var i = 0; i < this.documentos.length; i++) {
                if (this.documentos[i].id_estado_revision == 0 || this.documentos[i].id_estado_revision == 2) {
                    estado = true;
                    if (this.documentos[i].tipo_documento_id == 1) {
                        mensaje += "<li>Subir las fichas de inscripción.</li> "
                    }
                    if (this.documentos[i].tipo_documento_id == 2) {
                        mensaje += "<li>Subir los requisitos.</li> "
                    }
                    if (this.documentos[i].tipo_documento_id == 3) {
                        mensaje += "<li>Subir DNI escaneado.</li> "
                    }
                    if (this.documentos[i].tipo_documento_id == 4) {
                        mensaje += "<li>Subir Foto del postulante.</li> "
                    }
                    if (this.documentos[i].tipo_documento_id == 5) {
                        mensaje += "<li>Subir Requisitos para Constancia de Ingreso.</li> "
                    }
                }
            };
            for (var i = 0; i < this.pagos.length; i++) {
                if (this.pagos[i].id_estado_revision == 0 || this.pagos[i].id_estado_revision == 2 || this.pagos[i].id_estado_revision == 1) {
                }
                if ((this.pagos[i].id_estado_revision == 1 || this.pagos[i].id_estado_revision == 3) && this.pagos[i].id_tipo_pago == 1) {
                    prospectoPendiente = true
                }
                if ((this.pagos[i].id_estado_revision == 1 || this.pagos[i].id_estado_revision == 3) && this.pagos[i].id_tipo_pago == 2) {
                    examenPendiente = true
                }
                if ((this.pagos[i].id_estado_revision == 1 || this.pagos[i].id_estado_revision == 3) && this.pagos[i].id_tipo_pago == 3) {
                    ambosPendiente = true
                }
                if (this.pagos[i].id_estado_revision == 3) {
                    monto_pagado = this.pagos[i].monto_pago + monto_pagado
                }
            };
            if (this.id_modalidad_usu == 1 || this.id_modalidad_usu == 2 || this.id_modalidad_usu == 3 || this.id_modalidad_usu == 4 || this.id_modalidad_usu == 5 || this.id_modalidad_usu == 6 || this.id_modalidad_usu == 10) {
                if ((examenPendiente && prospectoPendiente) || ambosPendiente) {
                    pagosSinEnviar = false
                }
            } else if (this.id_modalidad_usu == 7) {
                pagosSinEnviar = false
            } else if (this.id_modalidad_usu == 8) {
                if (prospectoPendiente) {
                    pagosSinEnviar = false
                }
            }
            //verificar monto a pagar
            if (this.id_modalidad_usu == 1 || this.id_modalidad_usu == 2 || this.id_modalidad_usu == 5 || this.id_modalidad_usu == 6 || this.id_modalidad_usu == 11) {
                if (this.ficha[0].gestion_colegio == 1 || this.ficha[0].gestion_colegio == 2) {
                    monto_pagar = 250
                } else {
                    monto_pagar = 300
                }
            } else if (this.id_modalidad_usu == 3) {
                monto_pagar = 550
            } else if (this.id_modalidad_usu == 4) {
                monto_pagar = 350
            } else if (this.id_modalidad_usu == 7) {
                monto_pagar = 0
            } else if (this.id_modalidad_usu == 8) {
                monto_pagar = 50
            } else if (this.id_modalidad_usu == 10) {
                monto_pagar = 150
            }
            /*if(this.ficha[0].extemporaneo==1){
                monto_pagar = monto_pagar + 50
            }*/
            if ((pagosSinEnviar && monto_pagado < monto_pagar)) {
                estado = true
                mensaje += "<li>Completar pagos.</li> "
            }
            /* else if(monto_pagado<monto_pagar){
                mensaje += "<li>Pago no completado.</li> "
            } */

            /* if((monto_pagado<monto_pagar) || pagosSinEnviar){
                estado=true
                mensaje += "<li>Completar pagos.</li> "
            } */


            if (this.ficha == 0 || this.ficha[0].id_estado_revision == 1 || this.ficha[0].id_estado_revision == 3) {
                estado = true
            }
            this.msgRevision = mensaje
            this.botonRevision = estado
            return estado
        }
    }
}
</script>
<style>.vs-select-custom {
    --vs-controls-color: var(--kt-form-select-color);
    --vs-border-color: var(--kt-form-select-border-color);

    --vs-dropdown-bg: var(--kt-form-select-bg);
    --vs-dropdown-color: var(--kt-form-select-color);
    --vs-dropdown-option-color: var(--kt-form-select-color);

    --vs-selected-bg: #664cc3;
    --vs-selected-color: var(--kt-form-select-color);

    --vs-search-input-color: var(--kt-input-color);
    --vs-search-input-bg: var(--kt-form-select-bg);

    --vs-dropdown-option--active-bg: #664cc3;
    --vs-dropdown-option--active-color: #eeeeee;

    --vs-font-size: 1.1rem;
    --vs-line-height: 1.5;

    --vs-dropdown-option-padding: .775rem 3rem .775rem 1rem;
}</style>