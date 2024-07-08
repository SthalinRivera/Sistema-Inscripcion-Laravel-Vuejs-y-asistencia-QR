<template>
    <div>
        <div class="card mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Asignar postulantes a aulas</span>
                </h3>
            </div>
            <div class="card-body py-3">
                <div class="input-group mb-5" style="display: block">
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>
                                Modalidades examen
                            </label>
                            <select class="form-select" @change="buscar(1)" aria-label="Select example" v-model.number="asignar.examen" >
                                <!-- <option value="">TODOS</option> -->
                                <option value="2">
                                    Ordinario
                                </option>
                                <option value="1">
                                    Extraordinario
                                </option>
                                <option value="3">
                                    Quinto Secundaria
                                </option>
                            </select> 
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>
                                Local examen
                            </label>
                            <select class="form-select" @change="buscar(1), obtenerAulas()" aria-label="Select example" v-model.number="asignar.local">
                                <!-- <option value="">TODOS</option> -->
                                <option value="1">
                                    CASA DE LA CULTURA
                                </option>
                                <option value="2">
                                    COLEGIO 20188
                                </option>
                                <option value="3">
                                    SEDE SAN LUIS ADMINISTRACIÓN TIPO A
                                </option>
                                <option value="4">
                                    SEDE SAN LUIS USOS MULTIPLES TIPO A
                                </option>
                                <option value="5">
                                    SEDE SAN LUIS USOS MULTIPLES TIPO B
                                </option>
                            </select> 
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label class="">
                                Aula
                            </label>
                            <select class="form-select" v-model="asignar.id_aula" required="">
                                <option value="" hidden>Seleccione aula</option>
                                <option v-for="item in aulas" :key="item.id" :value="item.id">{{item.aula + ' ('+item.cantidad+')'}}</option>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label class="">
                                CANTIDAD
                            </label>
                            <input type="text" class="form-control m-input" v-model="asignar.cantidad" required="" size="2" maxlength="2" pattern="[0-9]+" title="Solo números. Tamaño max: 2 dígitos." placeholder="Ingrese cantidad" autocomplete="off">
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <div class="col-md-3 mt-6">
                                <button type="submit" @click.prevent="asignarPostulantes()" class="btn btn-primary">asignar</button>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <div class="mt-6">
                               <label >TOTAL</label><br>
                                <div v-for="(item, index) in sin_asignar" :key="index" >
                                    <span v-if="item.mcp_tipo==1">{{'TIPO A : '+item.cantidad}}</span>
                                    <span v-if="item.mcp_tipo==2">{{'TIPO B : '+item.cantidad}}</span>
                                    <br>
                                </div> 
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <div class="mt-6">
                               <label >ASIGNADO</label><br>
                                <div v-for="(item, index) in sin_asignar" :key="index" >
                                    <span v-if="item.mcp_tipo==1">{{'TIPO A : '+item.cantidad_asignado}}</span>
                                    <span v-if="item.mcp_tipo==2">{{'TIPO B : '+item.cantidad_asignado}}</span>
                                    <br>
                                </div> 
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <div class="mt-6">
                               <label >SIN ASIGNAR</label><br>
                                <div v-for="(item, index) in sin_asignar" :key="index" >
                                    <span v-if="item.mcp_tipo==1">{{'TIPO A : '+item.no_asignado}}</span>
                                    <span v-if="item.mcp_tipo==2">{{'TIPO B : '+item.no_asignado}}</span>
                                    <br>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-5 mb-xl-8">
            <!--begin::Header-->
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Lista de aulas</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Listado de postulantes por local y aula</span>
                </h3>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body py-3">
                <div class="input-group mb-5" style="display: block">
                    <div class="row">
                        
                        
                        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>
                                Modalidades examen
                            </label>
                            <select class="form-select" @change="buscar(1)" aria-label="Select example" v-model.number="filtros.examen">
                                <!-- <option value="">TODOS</option> -->
                                <option value="2">
                                    Ordinario
                                </option>
                                <option value="1">
                                    Extraordinario
                                </option>
                                <option value="3">
                                    Quinto Secundaria
                                </option>
                                <!-- <option value="1">Ordinario</option>
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
                                </option> -->
                            </select> 
                        </div>
                        
                        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>
                                Tipo de examen
                            </label>
                            <select class="form-select" @change="buscar(1)" aria-label="Select example" v-model.number="filtros.tipo_examen">
                                <option value="">TODOS</option>
                                <option value="1">
                                    A
                                </option>
                                <option value="2">
                                    B
                                </option>
                            </select> 
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>
                                Local examen
                            </label>
                            <select class="form-select" @change="buscar(1)" aria-label="Select example" v-model.number="filtros.local">
                                <option value="">TODOS</option>
                                <option value="1">
                                    CASA DE LA CULTURA
                                </option>
                                <option value="2">
                                    COLEGIO 20188
                                </option>
                                <option value="3">
                                    SEDE SAN LUIS ADMINISTRACIÓN TIPO A
                                </option>
                                <option value="4">
                                    SEDE SAN LUIS USOS MULTIPLES TIPO A
                                </option>
                                <option value="5">
                                    SEDE SAN LUIS USOS MULTIPLES TIPO B
                                </option>

                            </select> 
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <div class="col-md-3 mt-6 w-100">
                                <a v-if="filtros.local!=''" v-bind:href="$parent.NombreRuta + '/examen/lista_general?formato=1&id_examen='+filtros.examen+'&local_id='+filtros.local" type="submit" class="btn btn-primary" target="_blank">Lista general</a>
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
                                    <th>Examen</th>
                                    <th>Tipo examen</th>
                                    <th>Local</th>
                                    <th>Aula</th>
                                    <th>Cantidad</th>
                                    <th class="max-w-125px text-center rounded-end" style="width: 200px;">Acción</th>
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
                                    <td class="ps-4">{{index+1}}
                                    </td>
                                    <td>
                                        <span v-if="dato.id_examen==2">
                                            ORDINARIO
                                        </span>
                                        <span v-if="dato.id_examen==1">
                                            EXTRAORDINARIO
                                        </span>
                                        <span v-if="dato.id_examen==3">
                                            Quinto Secundaria
                                        </span>
                                    </td>
                                    <td>
                                        <span v-if="dato.mcp_tipo==1">
                                            TIPO A
                                        </span>
                                        <span v-if="dato.mcp_tipo==2">
                                            TIPO B
                                        </span>
                                    </td>
                                    <td>{{dato.local}}
                                    </td>
                                    <td>{{dato.aula}}
                                    </td>
                                    <td>
                                        {{dato.cantidad_aula}}    
                                    </td>
                                    <td class="text-center">
                                        
                                        <a v-bind:href="$parent.NombreRuta + '/examen/lista_aula?formato=2&id_examen='+dato.id_examen+'&id_aula='+dato.id_aula+'&local_id='+dato.local_id+'&aula='+dato.aula+'&nom_local='+dato.local" target="_blank" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                            <span class="svg-icon svg-icon-3"><i class="bi bi-file-bar-graph fs-2"></i></span>
                                            <!--end::Svg Icon-->
                                        </a>
                                        <a v-bind:href="$parent.NombreRuta + '/examen/lista_aula?formato=1&id_examen='+dato.id_examen+'&id_aula='+dato.id_aula+'&local_id='+dato.local_id+'&aula='+dato.aula+'&nom_local='+dato.local" target="_blank" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                            <span class="svg-icon svg-icon-3"><i class="bi bi-file-text-fill fs-2"></i></span>
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
    </div>
    
</template>
<script>
export default {
    data() {
        return {
            datos:[],
            botonCargando: false,
            aulas:[],
            sin_asignar:[],
            filtros: {
                examen: '2',
                tipo_examen: '',
                local: ''
            },
            asignar:{
                examen: '2',
                tipo_examen: '',
                local: '',
                id_aula: '',
                cantidad: '',
            }

        }
    },
    mounted() {
        this.mostrarDatos()
        this.postulantesSinAsignar()
    },
    methods: {
        async mostrarDatos() {
			let examen = this.filtros.examen
            let tipo_examen = this.filtros.tipo_examen
            let local = this.filtros.local
			await axios
				.get(this.$parent.NombreRuta + "/api/aulas?examen="+examen+'&tipo_examen='+tipo_examen+'&local='+local)
				.then((response) => {
				this.datos = response.data.aulas;
				})
				.catch(function (error) {
				this.datos = [];
				});
			},
        async obtenerAulas() {
			let examen = this.asignar.examen
            let tipo_examen = this.asignar.tipo_examen
            let local = this.asignar.local
			await axios
				.get(this.$parent.NombreRuta + "/api/aulas/listar?examen="+examen+'&tipo_examen='+tipo_examen+'&local='+local)
				.then((response) => {
				this.aulas = response.data.aulas;
				})
				.catch(function (error) {
				this.datos = [];
				});
			},
        async postulantesSinAsignar() {
			let examen = this.asignar.examen
            let tipo_examen = this.asignar.tipo_examen
            let local = this.asignar.local
			await axios
				.get(this.$parent.NombreRuta + "/api/aulas/sinasignar?examen="+examen)
				.then((response) => {
				this.sin_asignar = response.data.postulantes;
				})
				.catch(function (error) {
				this.sin_asignar = [];
				});
			},
        async guardarAulaPostulante(local, id_aula, cantidad) {
			await axios
				.post(this.$parent.NombreRuta + "/api/aulas/asignar", {
                local: local,
                id_aula: id_aula,
                cantidad: cantidad
                })
				.then((response) => {
				    if(response.data.changes>0){
                        toastr.options = {
                        "positionClass": "toastr-bottom-right",
                        "timeOut": "5000"
                    };
                    toastr.success(response.data.changes+' postulantes asignados');
                    }else{
                        toastr.options = {
                        "positionClass": "toastr-bottom-right",
                        "timeOut": "5000"
                        };
                    toastr.error('Postulantes asignados');
                    }
                    this.mostrarDatos()
                    this.obtenerAulas()
                    this.postulantesSinAsignar()
				})
				.catch(function (error) {
                    toastr.options = {
                        "positionClass": "toastr-bottom-right",
                        "timeOut": "5000"
                    };
                toastr.error('Postulantes asignados');
				});
			},
            
        buscar(opcion) {
            switch (opcion) {
                case 0:
                    this.filtros.examen = '1',
                    this.filtros.tipo_examen = '',
                    this.filtros.local = '',
                    this.dato = ''
                    break;
                case 1:
                    this.filtros.dato = ''
                    break;
                case 2:
                    this.filtros.examen = '1',
                    this.filtros.tipo_examen = '',
                    this.filtros.local = ''
                    break;
            }
            this.mostrarDatos()
        },
        asignarPostulantes(){
            console.log('asignarPostulantes')
            if(this.asignar.local && this.asignar.id_aula && this.asignar.cantidad){
                this.guardarAulaPostulante(this.asignar.local, this.asignar.id_aula, this.asignar.cantidad)
                    
            }else{
                toastr.options = {
                        "positionClass": "toastr-bottom-right",
                        "timeOut": "5000"
                    };
                toastr.error('Postulantes asignados');
            }
        }
    },
}
</script>