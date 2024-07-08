<template>
    <div class="card mb-5 mb-xl-8">
		<!--begin::Header-->
		<div class="card-header border-0 pt-5">
			<h3 class="card-title align-items-start flex-column">
				<span class="card-label fw-bold fs-3 mb-1">Descarga de carnet</span>
				<span class="text-muted mt-1 fw-semibold fs-7">Verifica si un postulante no ha descrgado el carnet</span>
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
                            <option value="11">Quinto de Secundaria</option>
                        </select> 
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <label>
                            Buscar
                        </label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" v-on:keyup.enter="buscar(2)" placeholder="Buscar por nombres o DNI o código" v-model="filtros.dato" aria-describedby="button-addon2">
                            <button class="btn btn-primary"  @click.prevent="buscar(2)" type="button" id="button-addon2">Buscar</button>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                        <label>
                            Estados
                        </label>
                        <select class="form-select" @change="buscar(1)" aria-label="Select example" v-model.number="filtros.estado">
                            <option value="">TODOS</option>
                            <option value="1">DESCARGADO</option> 
                            <option value="0">NO DESCARGADO</option> 
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
                                <th>AULA</th>
                                <th>FECHA</th>
                                <th>ESTADO</th>
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
                                    <a v-if="dato.fecha_confor_carne" :href="'https://api.whatsapp.com/send?phone=51' + dato.da_numero_celular+'&text=UNIVERSIDAD%20NACIONAL%20DE%20CA%C3%91ETE%0D%0ASaludos%20estimado%20%28a%29%20%F0%9F%99%8B%F0%9F%8F%BB%E2%80%8D%E2%99%82%0D%0A%0D%0ALe%20escribo%20de%20la%20oficina%20de%20Admisi%C3%B3n%20del%20PROCESO%20DE%20ADMISI%C3%93N%202024%2C%20para%20recordarles%20el%20d%C3%ADa%20del%20EXAMEN%20ORDINARIO%20es%20el%2025%20de%20FEBRERO%0D%0A%0D%0AHORARIO%20DE%20INGRESO%20de%20los%20postulantes%3A%207%3A00%20a.m.%20a%208%3A00%20a.m.%0D%0A%0D%0ALUGAR%3A%20Direcci%C3%B3n%3A%20Panamericana%20Sur%20Kil%C3%B3metro%20139%2C%20Mz.%20A%2C%20Lt.%201-%20Fundo%20Don%20Luis%2C%20distrito%20San%20Luis%20%E2%80%93%20Ca%C3%B1ete.%0D%0A-%20Ref%3A%20Campus%20Universitario%20Universidad%20Nacional%20de%20Ca%C3%B1ete%0D%0A%0D%0ALLEVAR%20%C3%9ANICAMENTE%3A%20%F0%9F%93%9D%0D%0A%0D%0A%E2%9C%85%20Carn%C3%A9%20de%20postulante%20%28Pueden%20descargarlo%29%20enlace.-%20https%3A%2F%2Fadmision.undc.edu.pe%2Finscripciones%2Fpublic%2Flogin%0D%0AConfirmar%20la%20descarga%20del%20carn%C3%A9%20por%20este%20medio%20%0D%0A%28Llevar%20impreso%20el%20d%C3%ADa%20del%20examen-la%20firma%20y%20colocaci%C3%B3n%20dactilar%20se%20realizar%C3%A1%20en%20el%20aula%20asignada%29%0D%0A%E2%9C%85%20DNI%20VIGENTE%0D%0A%20%20%20%20%20%20%20%20%2A%20%28Si%20esta%20Caducado%2C%20en%20tr%C3%A1mite%20adjuntar%20-%20Ficha%20RENIEC%29%0D%0A%20%20%20%20%20%20%20%20%2A%20Si%20se%20encuentra%20extraviado%20llevar%20C4%0D%0A%E2%9C%85%20L%C3%A1piz%202B%0D%0A%E2%9C%85%20Borrador%0D%0A%E2%9C%85%20Tajador%0D%0A%0D%0APROHIBIDO%20LLEVAR%3A%20%F0%9F%99%85%F0%9F%8F%BB%0D%0A%0D%0A%F0%9F%9A%AB%20Gorra%0D%0A%F0%9F%9A%AB%20Capucha%20%28vestimenta%20que%20dificulte%20la%20identificaci%C3%B3n%29%0D%0A%F0%9F%9A%AB%20Celular%0D%0A%F0%9F%9A%AB%20Calculadora%20y%20cualquier%20equipo%20electr%C3%B3nico'" target="_blank">
                                    <i class="bi bi-whatsapp text-success"></i>
                                    {{dato.da_numero_celular}}
                                    </a>                                    
                                    <a v-else :href="'https://api.whatsapp.com/send?phone=51'+dato.da_numero_celular+'&text=UNIVERSIDAD%20NACIONAL%20DE%20CA%C3%91ETE%0D%0ASaludos%20estimado%20%28a%29%20%F0%9F%99%8B%F0%9F%8F%BB%E2%80%8D%E2%99%82%0D%0A%0D%0ALe%20escribo%20de%20la%20oficina%20de%20Admisi%C3%B3n%20del%20PROCESO%20DE%20ADMISI%C3%93N%202024%2C%20para%20recordarles%20el%20d%C3%ADa%20del%20EXAMEN%20ORDINARIO%20es%20el%2025%20de%20FEBRERO%0D%0A%0D%0AHORARIO%20DE%20INGRESO%20de%20los%20postulantes%3A%207%3A00%20a.m.%20a%208%3A00%20a.m.%0D%0A%0D%0ALUGAR%3A%20Direcci%C3%B3n%3A%20Panamericana%20Sur%20Kil%C3%B3metro%20139%2C%20Mz.%20A%2C%20Lt.%201-%20Fundo%20Don%20Luis%2C%20distrito%20San%20Luis%20%E2%80%93%20Ca%C3%B1ete.%0D%0A-%20Ref%3A%20Campus%20Universitario%20Universidad%20Nacional%20de%20Ca%C3%B1ete%0D%0A%0D%0ALLEVAR%20%C3%9ANICAMENTE%3A%20%F0%9F%93%9D%0D%0A%0D%0A%E2%9C%85%20Carn%C3%A9%20de%20postulante%20%28Pueden%20descargarlo%29%20enlace.-%20https%3A%2F%2Fadmision.undc.edu.pe%2Finscripciones%2Fpublic%2Flogin%0D%0AConfirmar%20la%20descarga%20del%20carn%C3%A9%20por%20este%20medio%20%0D%0A%28Llevar%20impreso%20el%20d%C3%ADa%20del%20examen-la%20firma%20y%20colocaci%C3%B3n%20dactilar%20se%20realizar%C3%A1%20en%20el%20aula%20asignada%29%0D%0A%E2%9C%85%20DNI%20VIGENTE%0D%0A%20%20%20%20%20%20%20%20%2A%20%28Si%20esta%20Caducado%2C%20en%20tr%C3%A1mite%20adjuntar%20-%20Ficha%20RENIEC%29%0D%0A%20%20%20%20%20%20%20%20%2A%20Si%20se%20encuentra%20extraviado%20llevar%20C4%0D%0A%E2%9C%85%20L%C3%A1piz%202B%0D%0A%E2%9C%85%20Borrador%0D%0A%E2%9C%85%20Tajador%0D%0A%0D%0APROHIBIDO%20LLEVAR%3A%20%F0%9F%99%85%F0%9F%8F%BB%0D%0A%0D%0A%F0%9F%9A%AB%20Gorra%0D%0A%F0%9F%9A%AB%20Capucha%20%28vestimenta%20que%20dificulte%20la%20identificaci%C3%B3n%29%0D%0A%F0%9F%9A%AB%20Celular%0D%0A%F0%9F%9A%AB%20Calculadora%20y%20cualquier%20equipo%20electr%C3%B3nico'" target="_blank">
                                    <i class="bi bi-whatsapp text-success"></i>
                                    {{dato.df_celular_apoderado}}
                                    </a>
                                    
                                </td>
                                <td>
                                    {{dato.aula}}
                                </td>
                                <td>
                                    {{dato.fecha_confor_carne}}
                                </td>
                                <td>
                                    <!-- <span v-if="dato.id_estado_revision==0" class="badge badge-circle badge-secondary"></span>
                                    <span v-if="dato.id_estado_revision==1" class="badge badge-circle badge-warning"></span>
                                    <span v-if="dato.id_estado_revision==2" class="badge badge-circle badge-danger"></span>
                                    <span v-if="dato.id_estado_revision==3" class="badge badge-circle badge-success"></span> -->
                                    <span v-if="dato.fecha_confor_carne" class="badge badge-circle badge-success"></span>
                                    <span v-else class="badge badge-circle badge-warning"></span>
                                </td>
                                <!-- <td class="text-center">
                                    <div>
                                        <button @click.prevent="ver(dato.id)" type="submit" class='btn btn-primary' data-bs-toggle="modal" data-bs-target="#kt_modal_1">
                                            VER
                                        </button>
                                    </div>
                                </td> -->
                                <td class="text-center">
                                    <a v-bind:href="$parent.NombreRuta + '/inscripcion/carne3?token=' + encodeid(dato.id)" target="_blank" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
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
    </div>
</template>
<script>
export default {
    data() {
        return {
            datos:[],
            botonCargando: false,
            filtros: {
                carrera: '',
                modalidad: 1,
                estado: '',
                dato:''
            },
        }
    },
    mounted() {
        this.buscar(1)
    },
    methods: {
        async mostrarDatos() {

            this.botonCargando = true 

            let modalidad = this.filtros.modalidad
            let carrera = this.filtros.carrera
            let estado = this.filtros.estado
            let dato = this.filtros.dato
			await axios
				.get(this.$parent.NombreRuta + "/api/fichas/descarga_carnet?modalidad="+modalidad +'&carrera='+carrera+'&estado='+estado+'&dato='+dato)
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
        encodeid(id) {

            let codigo = btoa(id);
            return codigo;
        },


    },
}
</script>