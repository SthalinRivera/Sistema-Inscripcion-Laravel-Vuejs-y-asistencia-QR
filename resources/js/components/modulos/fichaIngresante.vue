<template>
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">Ficha Ingresante</span>
            </h3>
        </div>
        <div class="card-body py-3">
            <div class="text-center">
                <div class="row" style="justify-content: center">
                    <div class="row" style="justify-content: center;">
                        <div v-if="ficha != 0 && ficha[0].condicion=='INGRESO'" class="col-md-10">
                            <div class="m-portlet__body mb-10">
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                                        <span>
                                            <a v-bind:href="$parent.NombreRuta + '/inscripcion/ficha?i=' + encodeid(ficha[0].id)" target="_blank"><img
                                                    :src="$parent.NombreRuta + '/assets/media/images/ficha.jpg'" alt=""
                                                    style="width: 100%;height: 460px;"></a>
                                        </span>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                        <div class="card text-right">
                                            <div class="card-header bg-primary pt-7">
                                                <h3 class="card-title align-items-center w-100 text-center"><span
                                                        class="card-label fw-bold text-white">Indicaciones</span></h3>
                                            </div>
                                            <div class="card-body" style="text-align: left">
                                                <ul>
                                                    <b>Ingresar a la ficha</b><br>
                                                    <li>Descargar ficha de Ingreso.</li>
                                                    <li>Solo se mostrará la ficha de ingreso de la ultima modalidad que
                                                        postulaste.</li>
                                                    <li>IMPRIMIR en hoja completa (A4) a COLOR.</li>
                                                    <li>Llevar impreso la ficha correcta.</li>
                                                    <li>Presentarte en la sede la fecha asignada</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                                <div class="m-form__actions m-form__actions--solid">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-2">
                                                <a v-if="ficha[0].condicion == 'INGRESO'"
                                                    v-bind:href="$parent.NombreRuta + '/inscripcion/ficha?i=' + encodeid(ficha[0].id)"
                                                    class="btn btn-success btn-block w-100" target="_blank">Descargar Ficha Ingresante
                                                </a>
                                                <a v-else href="" class="btn btn-primary btn-block disabled w-100"
                                                    target="_blank" disabled>
                                                    No eres ingresante
                                                </a>
                                            </div>
                                            <br>
                                        </div>
                                        <br>
                                        <br>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center col-md-10" v-else>
                        <div class="alert alert-dismissible bg-danger d-flex flex-column flex-sm-row p-5 mb-10">
                            <span class="svg-icon svg-icon-2hx svg-icon-light me-4 mb-5 mb-sm-0"><svg width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3"
                                        d="M2 4V16C2 16.6 2.4 17 3 17H13L16.6 20.6C17.1 21.1 18 20.8 18 20V17H21C21.6 17 22 16.6 22 16V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4Z"
                                        fill="currentColor"></path>
                                    <path
                                        d="M18 9H6C5.4 9 5 8.6 5 8C5 7.4 5.4 7 6 7H18C18.6 7 19 7.4 19 8C19 8.6 18.6 9 18 9ZM16 12C16 11.4 15.6 11 15 11H6C5.4 11 5 11.4 5 12C5 12.6 5.4 13 6 13H15C15.6 13 16 12.6 16 12Z"
                                        fill="currentColor"></path>
                                </svg></span>
                            <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                                <h4 class="mb-2 light">Este apartado se habilitará cuando se cumpla con la condición de ser ingresante por alguna modalidad</h4>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            ficha: [],
            botonRevision: true,
            botonEnviar: false,
            botonGuardarFicha: false,

            id_modalidad_usu: '',
            id_ficha_usu: '',
            id_estado_usu: ''

        };
    },
    mounted() {
        this.obtenerFicha()
    },
    methods: {
        async obtenerFicha() {
            this.botonGuardarFicha = true,
                this.loadingData = true
            await axios
                .get(this.$parent.NombreRuta + "/api/fichas/fichaingresante")
                .then((response) => {
                    this.botonGuardarFicha = false
                    this.ficha = response.data
                    if (this.ficha != 0) {
                        this.id_modalidad_usu = this.ficha[0].mcp_id_modalidad
                        this.id_ficha_usu = this.ficha[0].id
                        this.id_estado_usu = this.ficha[0].id_estado
                    }
                })
                .catch(function (error) {
                    this.loadingData = false
                    this.ficha = [];
                });
        },
        encodeid(id) {
            let codigo = btoa(id);
            return codigo;
        },
    },

};
</script>