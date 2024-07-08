<template>
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">Constancia de Ingreso</span>
                <span class="text-muted mt-1 fw-semibold fs-7">Constancia de ingresantes</span>
            </h3>
            <!-- Botón descarga masiva -->
            <button v-if="is('Administrador')" class="btn btn-primary" @click="descargarPDFs()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M0 0h24v24H0z" fill="none"/><path d="M13 5v6h3l-4 4-4-4h3V5h2z"/></svg>
            </button>
        </div>

        <div class="card-body py-3">
            <div class="input-group mb-6" style="display: block">
                <div class="row">
                    <!-- Filtro de busqueda de Modalidades  -->
                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                        <label>
                            Modalidades
                        </label>
                        <select class="form-select" @change="buscar(1)" aria-label="Select example"
                            v-model.number="filtros.modalidad">
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
                            <option value="11">Quinto de Secundaria</option>
                        </select>
                    </div>
                    <!-- Filtro de busqueda por Carreras  -->
                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                        <label>
                            Carreras
                        </label>
                        <select class="form-select" @change="buscar(1)" aria-label="Select example"
                            v-model.number="filtros.carrera">
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
                    <!-- Filtro de busqueda por DNI o código -->
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <label>
                            Buscar
                        </label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" v-on:keyup.enter="buscar(2)"
                                placeholder="Buscar por nombres o DNI o código" v-model="filtros.dato"
                                aria-describedby="button-addon2">
                            <button class="btn btn-primary" @click.prevent="buscar(2)" type="button"
                                id="button-addon2">Buscar</button>
                        </div>
                    </div>
                    <!-- Filtro por Condición  -->
                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                        <label>
                            Condición
                        </label>
                        <select class="form-select" @change="buscar(1)" aria-label="Select example"
                            v-model="filtros.condicion">
                            <option value="">TODOS</option>
                            <option value="INGRESO">INGRESÓ</option>
                            <option value="COBERTURA">COBERTURA</option>
                            <option value="NO INGRESO">NO INGRESÓ</option>
                            <option value="AUSENTE">AUSENTE</option>
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
                            <th>CELULAR</th>
                            <th>CONDICION</th>
                            <th class="text-center rounded-end" style="width: 200px;">ACCION</th>
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
                                {{ index + 1 }}
                            </td>
                            <td>
                                {{ dato.modalidad }}
                            </td>
                            <td>
                                {{ dato.carrera }}
                            </td>
                            <td>
                                {{ dato.codigo_p }}
                            </td>
                            <td>
                                {{ dato.numero_documento }}
                            </td>
                            <td>
                                {{ dato.apellidos }}
                            </td>
                            <td>
                                {{ dato.dp_nombre }}
                            </td>

                            <td>
                                <!-- mensaje ingresantes cepre -->
                                <a v-if="dato.condicion === 'INGRESO' || dato.condicion === 'COBERTURA' || dato.modalidad === 8"
                                    :href="'https://api.whatsapp.com/send?phone=51' + dato.da_numero_celular + '&text=RECEPCIÓN%20DE%20DOCUMENTOS%20PARA%20INGRESANTES%20POR%20CEPRE%20PARA%20OBTENER%20LA%20CONSTANCIA%20DE%20INGRESO%20%28EN%20FÍSICO%20Y%20ESCANEADOS%20EN%20PDF%29%3A%0D%0A%0D%0A●%20Certificado%20de%20estudios%20del%201er%20al%205º%20año%20de%20secundaria%20%28PROPORCIONADO%20POR%20CEPRE%29%0D%0A●%20Partida%20o%20acta%20de%20nacimiento%20original.%20%28PROPORCIONADO%20POR%20CEPRE%29%0D%0A●%20Comprobante%20de%20pago%20por%20Inscripción%20y%20prospecto.%0D%0A●%20Comprobante%20de%20pago%20por%20Constancia%20de%20Ingreso.%20%28Monto%20-%20S%2F50.70%29%0D%0A●%20Copia%20DNI%20con%20ampliación%20al%20200%25%20o%20Carné%20de%20extranjería%0D%0A●%20Ficha%20de%20Inscripción.%0D%0A●%20Una%20mica%20tamaño%20oficio.%0D%0A%0D%0ADEPÓSITO%20A%20LOS%20NÚMEROS%20DE%20CUENTAS%3A%0D%0A%0D%0ABANCO%20DE%20LA%20NACIÓN%20%0D%0A💸%20N.º%2000-571-028409%0D%0A💸%20CCI%3A%20018%20571%2000057102840901%0D%0ABANCO%20INTERBANK%20%0D%0A💸%20N.º%20401-3004-5278-40%0D%0A💸%20CCI%3A%200034%200100%C2%A03004%C2%A05278%C2%A04072%0D%0A%0D%0AFECHA%20DE%20RECEPCION%20DE%20DOCUMENTOS%20Y%20ENTREGA%20DE%20CONSTANCIAS%20DE%20INGRESO%20A%20LOS%20INGRESANTES%20DE%20TODAS%20LAS%20MODALIDADES%3A%0D%0A%0D%0A★%20Área%20Ciencias%20Empresariales%3A%20Martes%2027%20y%20miércoles%2028%20de%20febrero%20de%202024.%0D%0A★%20Área%20Ingeniería%3A%20Jueves%2029%20de%20febrero%20y%20viernes%2001%20de%20marzo%20de%202024.%0D%0A★%20Extemporáneo%20todas%20las%20carreras%3A%20Sábado%2002%20de%20marzo%20de%202024%0D%0A%0D%0ALUGAR%3A%20Casa%20de%20la%20Cultura%20–%20San%20Vicente%20de%20Cañete%20%5BAv.%20Mariscal%20Benavides%201370%5D%0D%0AHora%3A%209%3A00%20–%2015%3A00%20horas.'"
                                    target="_blank">
                                    <i class="bi bi-whatsapp text-success"></i>
                                    {{ dato.da_numero_celular }}
                                </a>
                                <!-- mensaje ingresantes ordinario -->
                                <a v-else-if="dato.condicion === 'INGRESO' || dato.condicion === 'COBERTURA' || dato.modalidad === 1"
                                    :href="'https://api.whatsapp.com/send?phone=51' + dato.da_numero_celular + '&text=UNIVERSIDAD%20NACIONAL%20DE%20CAÑETE%0D%0ASaludos%20estimado%20%28a%29%20🙋🏻%E2%80%8D♂%0D%0ASomos%20de%20la%20Oficina%20de%20Inscripción%20para%20el%20Examen%20de%20Admisión%20de%20la%20UNDC%202024.%0D%0AEste%20es%20un%20mensaje%20dirigido%20a%20los%20ingresantes%20sobre%20los%20requisitos%20que%20deben%20presentar%20en%20las%20fechas%20indicadas%20para%20la%20obtención%20de%20su%20constancia%20de%20ingreso.%0D%0A%0D%0ARECEPCIÓN%20DE%20DOCUMENTOS%20INGRESANTES%20DE%20TODAS%20LAS%20MODALIDADES%20PARA%20OBTENER%20LA%20CONSTANCIA%20DE%20INGRESO%20%28EN%20FÍSICO%20Y%20ESCANEADOS%20EN%20PDF%29.%0D%0A●Documentos%20en%20físicos%20que%20presentaron%20como%20Requisitos%20para%20la%20Modalidad%20que%20postularon%0D%0A●%20Certificado%20de%20estudios%20del%201er%20al%205º%20año%20de%20secundaria%20%28original%29.%0D%0A●%20Partida%20o%20acta%20de%20nacimiento%20original.%0D%0A●%20Comprobante%20de%20pago%20por%20Inscripción%20y%20prospecto.%0D%0A●%20Comprobante%20de%20pago%20por%20Constancia%20de%20Ingreso.%20%28Monto%20-%20S%2F50.70%29%0D%0A●%20Copia%20DNI%20con%20ampliación%20al%20200%25%20o%20Carné%20de%20extranjería%0D%0A●%20Ficha%20de%20Inscripción.%0D%0A●%20Una%20mica%20tamaño%20oficio.%0D%0AFechas%3A%0D%0A★%20Área%20Ciencias%20empresariales%3A%2027%20y%2028%20de%20febrero%20de%202024.%0D%0A★%20Área%20Ingeniería%3A%2029%20de%20febrero%20y%2001%20de%20marzo%20de%202024.%0D%0A%2ALugar%3A%20Casa%20de%20la%20Cultura%20–%20San%20Vicente%20de%20Cañete%20%5BAv.%20Mariscal%20Benavides%20%0D%0A1370%2A%0D%0AHora%3A%209%3A00%20–%2015%3A00%20horas%0D%0A%0D%0AENTREGA%20DE%20CONSTANCIAS%20DE%20INGRESO%20A%20LOS%20INGRESANTES%20DE%20TODAS%20LAS%20MODALIDADES%0D%0A★%20Área%20Ciencias%20Empresariales%3A%20Martes%2027%20y%20miércoles%2028%20de%20febrero%20de%202024.%0D%0A★%20Área%20Ingeniería%3A%20Jueves%2029%20de%20febrero%20y%20viernes%2001%20de%20marzo%20de%202024.%0D%0A★%20Extemporáneo%20todas%20las%20carreras%3A%20Sábado%2002%20de%20marzo%20de%202024%0D%0ALugar%3A%20Casa%20de%20la%20Cultura%20–%20San%20Vicente%20de%20Cañete%20%5BAv.%20Mariscal%20Benavides%201370%5D%0D%0AHora%3A%209%3A00%20–%2015%3A00%20horas.'"
                                    target="_blank">
                                    <i class="bi bi-whatsapp text-success"></i>
                                    {{ dato.da_numero_celular }}
                                </a>
                                <!-- mensaje para extraordinario -->
                                <a v-else-if="dato.condicion === 'INGRESO' || dato.condicion === 'COBERTURA' || dato.modalidad === 2 || dato.modalidad === 3 || dato.modalidad === 4 || dato.modalidad === 5 || dato.modalidad === 6 || dato.modalidad === 7 || dato.modalidad === 9 || dato.modalidad === 10"
                                    :href="'https://api.whatsapp.com/send?phone=51' + dato.da_numero_celular + '&text=UNIVERSIDAD%20NACIONAL%20DE%20CAÑETE%0D%0ASaludos%20estimado%20%28a%29%20🙋🏻%E2%80%8D♂%0D%0ASomos%20de%20la%20Oficina%20de%20Inscripción%20para%20el%20Examen%20de%20Admisión%20de%20la%20UNDC%202024.%0D%0AEste%20es%20un%20mensaje%20dirigido%20a%20los%20ingresantes%20sobre%20los%20requisitos%20que%20deben%20presentar%20en%20las%20fechas%20indicadas%20para%20la%20obtención%20de%20su%20constancia%20de%20ingreso.%0D%0A%0D%0ARECEPCIÓN%20DE%20DOCUMENTOS%20INGRESANTES%20DE%20TODAS%20LAS%20MODALIDADES%20PARA%20OBTENER%20LA%20CONSTANCIA%20DE%20INGRESO%20%28EN%20FÍSICO%20Y%20ESCANEADOS%20EN%20PDF%29%3A%0D%0A%0D%0A●%20Certificado%20de%20estudios%20del%201er%20al%205º%20año%20de%20secundaria%20%28ORIGINAL%29%0D%0A●%20Partida%20o%20acta%20de%20nacimiento%20original.%0D%0A●%20Otros%20requisitos%20segun%20modalidad.%0D%0A●%20Comprobante%20de%20pago%20por%20Inscripción%20y%20prospecto.%0D%0A●%20Comprobante%20de%20pago%20por%20Constancia%20de%20Ingreso.%20%28Monto%20-%20S%2F50.70%29%0D%0A●%20Copia%20DNI%20con%20ampliación%20al%20200%25%20o%20Carné%20de%20extranjería%0D%0A●%20Ficha%20de%20Inscripción.%0D%0A●%20Una%20mica%20tamaño%20oficio.%0D%0A%0D%0ADEPÓSITO%20A%20LOS%20NÚMEROS%20DE%20CUENTAS%3A%0D%0A%0D%0ABANCO%20DE%20LA%20NACIÓN%20%0D%0A💸%20N.º%2000-571-028409%0D%0A💸%20CCI%3A%20018%20571%2000057102840901%0D%0ABANCO%20INTERBANK%20%0D%0A💸%20N.º%20401-3004-5278-40%0D%0A💸%20CCI%3A%200034%200100%C2%A03004%C2%A05278%C2%A04072%0D%0A%0D%0AFECHAS%3A%0D%0A★%20Área%20Ciencias%20empresariales%3A%2027%20y%2028%20de%20febrero%20de%202024.%0D%0A★%20Área%20Ingeniería%3A%2029%20de%20febrero%20y%2001%20de%20marzo%20de%202024.%0D%0A%2ALugar%3A%20Casa%20de%20la%20Cultura%20–%20San%20Vicente%20de%20Cañete%20%5BAv.%20Mariscal%20Benavides%20%0D%0A1370%2A%0D%0AHora%3A%209%3A00%20–%2015%3A00%20horas%0D%0A%0D%0AENTREGA%20DE%20CONSTANCIAS%20DE%20INGRESO%20A%20LOS%20INGRESANTES%20DE%20TODAS%20LAS%20MODALIDADES%3A%0D%0A%0D%0A★%20Área%20Ciencias%20Empresariales%3A%20Martes%2027%20y%20miércoles%2028%20de%20febrero%20de%202024.%0D%0A★%20Área%20Ingeniería%3A%20Jueves%2029%20de%20febrero%20y%20viernes%2001%20de%20marzo%20de%202024.%0D%0A★%20Extemporáneo%20todas%20las%20carreras%3A%20Sábado%2002%20de%20marzo%20de%202024%0D%0ALugar%3A%20Casa%20de%20la%20Cultura%20–%20San%20Vicente%20de%20Cañete%20%5BAv.%20Mariscal%20Benavides%201370%5D%0D%0AHora%3A%209%3A00%20–%2015%3A00%20horas.'"
                                    target="_blank">
                                    <i class="bi bi-whatsapp text-success"></i>
                                    {{ dato.da_numero_celular }}
                                </a>
                                <a v-else
                                    :href="'https://api.whatsapp.com/send?phone=51' + dato.da_numero_celular + '&text=UNIVERSIDAD%20NACIONAL%20DE%20CAÑETE%0D%0ASaludos%20estimado%20%28a%29%20🙋🏻%E2%80%8D♂%0D%0ASomos%20de%20la%20Oficina%20de%20Inscripción%20para%20el%20Examen%20de%20Admisión%20de%20la%20UNDC%202024.%0D%0A🗓%EF%B8%8F%20Examen%20ORDINARIO%2025%20de%20FEBRERO%20%28presencial%29.%0D%0ALas%20inscripciones%20para%20los%20postulantes%20al%20EXAMEN%20DE%20ADMISIÓN%20ORDINARIO%20tienen%20plazo%20para%20inscribirse%20hasta%20el%2023%20de%20FEBRERO.%20%0D%0ALa%20inscripción%20es%20de%20manera%20VIRTUAL%20👩🏻%E2%80%8D💻🧑🏻%E2%80%8D💻%0D%0A💻Link%20de%20registro%3A%20https%3A%2F%2Fadmision.undc.edu.pe%2Finscripciones%0D%0A%0D%0ASomos%20una%20casa%20de%20estudios%20LICENCIADA%20POR%20SUNEDU%0D%0AOfrecemos%205%20carreras%20profesionales%3A%0D%0A📘%20Administración%0D%0A📘%20Contabilidad%20%0D%0A📘%20Administración%20de%20Turismo%20y%20Hotelería%20%0D%0A📘%20Ingeniería%20de%20Sistemas%0D%0A📘%20Agronomía%20%0D%0A%0D%0ACONSIDERACIONES%20IMPORTANTES%3A%0D%0A📝%20100%20Preguntas%20%28Tipo%20A%20y%20Tipo%20B%29.%0D%0A%0D%0ADIRIGIDO%20PARA%3A%0D%0A✔%EF%B8%8F%20Publico%20en%20general%0D%0A%0D%0ACOSTOS%0D%0A✔%EF%B8%8F%20Derecho%20de%20Examen%3A%0D%0A💸S%2F250.00%20%28Colegio%20estatal%29%0D%0A💸S%2F300.00%20%28Colegio%20Particular%29'"
                                    target="_blank">
                                    <i class="bi bi-whatsapp text-success"></i>
                                    {{ dato.da_numero_celular }}
                                </a>
                            </td>

                            <td>
                                {{ dato.condicion }}
                            </td>
                            <td class="text-center" v-if="dato.condicion == 'INGRESO' || dato.condicion == 'COBERTURA'">
                                <a  v-bind:href="$parent.NombreRuta + '/inscripcion/constanciaingreso?token=' + encodeid(dato.id)"
                                    target="_blank" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                    <span class="svg-icon svg-icon-3"><i class="bi bi-eye fs-2"></i></span>
                                </a>
                                <a v-if="is('Administrador')" v-bind:href="$parent.NombreRuta + '/inscripcion/constanciaingreso?token=' + encodeid(dato.id)"
                                    download target="_blank"
                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                    <span class="svg-icon svg-icon-3"><i class="bi bi-download fs-2"></i></span>
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
    </div>
</template>
<script>
import JSZip from 'jszip';
import axios from 'axios';

export default {
    data() {
        return {
            datos: [],
            botonCargando: false,
            filtros: {
                carrera: '',
                modalidad: 1,
                condicion: '',
                dato: ''
            },
        }
    },
    mounted() {
        this.buscar(1)
    },
    methods: {
        async descargarPDFs() {
            try {
                // Filtrar los datos de los postulantes cuya condición sea 'INGRESO'
                const postulantesIngreso = this.datos.filter(postulante => postulante.condicion === 'INGRESO');

                // Crear un nuevo objeto JSZip
                const zip = new JSZip();

                // Iterar sobre los postulantes y agregar los PDFs al archivo ZIP
                await Promise.all(postulantesIngreso.map(async postulante => {
                    const url = `${this.$parent.NombreRuta}/inscripcion/constanciaingreso?token=${this.encodeid(postulante.id)}`;
                    const pdfResponse = await axios.get(url, { responseType: 'arraybuffer' });

                    // Obtener el nombre del archivo sin comillas
                    const contentDisposition = pdfResponse.headers['content-disposition'];
                    const matches = contentDisposition.match(/filename="?([^"]+)"?/);
                    const nombreArchivo = matches ? decodeURIComponent(escape(matches[1])) : 'archivo.pdf';


                    // Crear un objeto Blob a partir de los datos del PDF
                    const blob = new Blob([pdfResponse.data], { type: 'application/pdf' });

                    // Agregar el archivo al ZIP
                    zip.file(nombreArchivo, blob);
                }));

                // Generar el archivo ZIP
                const zipBlob = await zip.generateAsync({ type: 'blob' });

                // Crear un enlace de descarga y simular un clic para descargar el archivo ZIP
                const link = document.createElement('a');
                link.href = URL.createObjectURL(zipBlob);
                link.download = 'Constancia Ingreso 2024.zip';
                link.click();
            } catch (error) {
                console.error('Error al descargar los PDFs', error);
            }
        },
        async mostrarDatos() {

            this.botonCargando = true

            let modalidad = this.filtros.modalidad
            let carrera = this.filtros.carrera
            let condicion = this.filtros.condicion
            let dato = this.filtros.dato
            await axios
                .get(this.$parent.NombreRuta + "/api/fichas/descarga_constancia_ingreso?modalidad=" + modalidad + '&carrera=' + carrera + '&condicion=' + condicion + '&dato=' + dato)
                .then((response) => {
                    this.datos = response.data;
                    this.botonCargando = false
                })
                .catch(function (error) {
                    this.datos = [];
                    this.botonCargando = false
                });
        },
        buscar(opcion) {
            switch (opcion) {
                case 0:
                    this.filtros.dato = '',
                        this.filtros.modalidad = '',
                        this.filtros.carrera = '',
                        this.filtros.condicion = ''
                    break;
                case 1:
                    this.filtros.dato = ''
                    break;
                case 2:
                    this.filtros.modalidad = '',
                        this.filtros.carrera = '',
                        this.filtros.condicion = ''
                    break;
            }
            this.mostrarDatos()
        },
        encodeid(id) {
            let codigo = btoa(id);
            return codigo;
        },


    },
}
</script>