<template>
    <div>
        <div class="card-body py-3">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 mb-5">
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
            </div>
        </div>
        <div class="card mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Secciones</span>
                </h3>
            </div>
            <div class="card-body py-3">
                <div class="table-responsive">
                    <!-- TABLA INGRESANTES CEPRE -->
                    <table class="table table-row-bordered">
                        <thead>
                            <tr class="fw-bold fs-6 text-gray-800 text-muted bg-light">
                                <th class="ps-4 rounded-start">Modalidad</th>
                                <th class="text-center">Inscritos</th>
                                <th class="text-center">En Proceso</th>
                                <th class="text-center rounded-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="botonCargando">
                                <td colspan="4" class="text-center">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </td>
                            </tr>
                            <tr v-else v-for="(dato, index) in modCepre" :index="index" :key="index">
                                <td class="ps-4 rounded-start" style="width: 135px;">{{ dato.modalidad }}</td>
                                <td class="text-center">{{ dato.inscritos }}</td>
                                <td class="text-center">{{ dato.proceso }}</td>
                                <td class="text-center rounded-end">{{ dato.total }}</td>
                            </tr>
                        </tbody>
                    </table>                                     
                </div>
                <div class="table-responsive">
                    <!-- TABLA MODALIDAD QUINTO DE SECUNDARIA -->
                    <table class="table table-row-bordered">
                        <thead>
                            <tr class="fw-bold fs-6 text-gray-800 text-muted bg-light">
                                <th class="ps-4 rounded-start">Modalidad</th>
                                <th class="text-center">Inscritos</th>
                                <th class="text-center">En Proceso</th>
                                <th class="text-center rounded-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="botonCargando">
                                <td colspan="4" class="text-center">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </td>
                            </tr>
                            <tr v-else v-for="(dato, index) in modQuinto" :index="index" :key="index">
                                <td class="ps-4 rounded-start" style="width: 135px;">{{ dato.modalidad }}</td>
                                <td class="text-center">{{ dato.inscritos }}</td>
                                <td class="text-center">{{ dato.proceso }}</td>
                                <td class="text-center rounded-end">{{ dato.total }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive">
                    <!-- TABLA ORDINARIO -->
                    <table class="table table-row-bordered">
                        <thead>
                            <tr class="fw-bold fs-6 text-gray-800 text-muted bg-light">
                                <th class="ps-4 rounded-start">Modalidad</th>
                                <th class="text-center">Inscritos</th>
                                <th class="text-center">En Proceso</th>
                                <th class="text-center rounded-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="botonCargando">
                                <td colspan="4" class="text-center">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </td>
                            </tr>
                            <tr v-else v-for="(dato, index) in modOrdinario" :index="index" :key="index">
                                <td class="ps-4 rounded-start" style="width: 135px;">{{ dato.modalidad }}</td>
                                <td class="text-center">{{ dato.inscritos }}</td>
                                <td class="text-center">{{ dato.proceso }}</td>
                                <td class="text-center rounded-end">{{ dato.total }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive">
                    <!-- TABLA EXTRAORDINARIO -->
                    <table class="table table-row-bordered">
                        <thead>
                            <tr class="fw-bold fs-6 text-gray-800 text-muted bg-light">
                                <th class="ps-4">Modalidad</th>
                                <th class="text-center">Inscritos</th>
                                <th class="text-center">En Proceso</th>
                                <th class="text-center rounded-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="botonCargando">
                                <td colspan="4" class="text-center">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </td>
                            </tr>
                            <tr v-else v-for="(dato, index) in modExtraordinario" :index="index" :key="index">
                                <td class="ps-4 rounded-start" style="width: 135px;">{{ dato.modalidad }}</td>
                                <td class="text-center">{{ dato.inscritos }}</td>
                                <td class="text-center">{{ dato.proceso }}</td>
                                <td class="text-center rounded-end">{{ dato.total }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- TABLA SUB-MODALIDADES-->
                    <table class="table table-row-bordered">
                        <thead>
                            <tr class="fw-bold fs-6 text-gray-800 text-muted bg-light">
                                <th class="ps-4">Sub-Modalidad</th>
                                <th class="text-center">Inscritos</th>
                                <th class="text-center">En Proceso</th>
                                <th class="text-center rounded-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="botonCargando">
                                <td colspan="4" class="text-center">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </td>
                            </tr>
                            <tr v-else v-for="(dato, index) in subModalidades" :index="index" :key="index">
                                <td class="ps-4 rounded-start" style="width: 135px;">{{ dato.modalidad }}</td>
                                <td class="text-center">{{ dato.inscritos }}</td>
                                <td class="text-center">{{ dato.proceso }}</td>
                                <td class="text-center rounded-end">{{ dato.total }}</td>
                            </tr>
                        </tbody>
                    </table>   
                </div>

            </div>
        </div>
        <div class="card mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Reporte por modalidades</span>
                </h3>
            </div>
            <div class="card-body py-3">
                <div class="table-responsive">
                    <table class="table table-row-bordered">
                        <thead>
                            <tr class="fw-bold fs-6 text-gray-800 text-muted bg-light">
                                <th class="ps-4 rounded-start">N°</th>
                                <th class="ps-4">Modalidad</th>
                                <th class="text-center rounded-end">Cantidad</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="botonCargando">
                                <td colspan="4" class="text-center">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </td>
                            </tr>
                            <tr v-else v-for="(dato, index) in data" :index="index" :key="index">
                                <td class="ps-4">{{ index + 1 }}</td>
                                <td class="ps-4">{{ dato.x }}</td>
                                <td class="text-center">
                                    {{ dato.y }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card card-bordered mb-5">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark">Reporte por modalidad</span>
                </h3>
            </div>
            <div class="card-body">
                <div id="kt_apexcharts_1" style="height: 350px;"></div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            modCepre: [],
            modQuinto: [],
            modOrdinario: [],
            modExtraordinario: [],
            subModalidades: [],
            data: [],
            name: '',
            botonCargando: false,
            themeMode: '',
            chart: '',
            options: {
                series: [{
                    name: 'POSTULANTES',
                    data: []
                }],
                chart: {
                    type: 'bar',
                    height: 350
                },
                xaxis: {
                    labels: {
                        /**/
                        rotate: 0,
                        trim: true,
                        style: {
                            fontSize: '9spx',
                        }
                    }
                },
                yaxis: {
                    title: {
                        text: 'CANTIDAD'
                    }
                },
            },
            filtros: {
                carrera: '',
                modalidad: '',
                estado: 1,
                dato: ''
            },

        }
    },
    mounted() {
        if (localStorage.kt_metronic_theme_mode_value) {
            this.themeMode = localStorage.kt_metronic_theme_mode_value;
        }
        this.mostrarDatos();
        this.mostrarGrafico();

    },
    methods: {
        async mostrarDatos() {
            let modalidad = this.filtros.modalidad
            let carrera = this.filtros.carrera
            this.botonCargando = true,
                await axios
                    .get(this.$parent.NombreRuta + "/api/reporte/modalidad?carrera=" + carrera)
                    .then((response) => {
                        this.data = response.data.modalidad;
                        this.modCepre = response.data.modCepre;
                        this.modOrdinario = response.data.modOrdinario;
                        this.modQuinto = response.data.modQuinto;
                        this.modExtraordinario = response.data.modExtraordinario;
                        this.subModalidades = response.data.subModalidades;
                        this.chart.updateSeries([{
                            data: response.data.modalidad
                        }])
                        this.chart.updateOptions({
                            theme: {
                                mode: this.themeMode,
                                palette: 'palette1',
                                monochrome: {
                                    shadeTo: this.themeMode,
                                },
                            },
                        })
                        this.botonCargando = false
                    })
                    .catch(function (error) {
                        this.datos = [];
                        this.botonCargando= false
                    });
        },
        mostrarGrafico() {
            this.chart = new ApexCharts(document.getElementById('kt_apexcharts_1'), this.options);
            this.chart.render();
        },
        buscar(opcion) {
            switch (opcion) {
                case 0:
                    this.filtros.dato = '',
                        this.filtros.modalidad = ''
                    break;
                case 1:
                    this.filtros.dato = ''
                    break;
                case 2:
                    this.filtros.modalidad = ''
                    break;
            }
            this.mostrarDatos()
        },
    },
    beforeMount() {
        this.$root.$on('send', data => {
            this.themeMode = data;
            this.chart.updateOptions({
                theme: {
                    mode: data,
                    palette: 'palette1',
                    monochrome: {
                        shadeTo: data,
                    },
                },
            })
        });
    }
}
</script>