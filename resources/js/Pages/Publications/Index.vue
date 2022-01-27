<template>
<app-layout>
  <v-container
    id="dashboard"
    fluid
    tag="section">
    <v-row class="justify-center">
      <v-col cols="12" md="8">
        <v-col cols="12" md="12">
          <v-form
            ref="form"
            v-model="form.valid"
            lazy-validation>
            <data-table-crud
              title="Publicaciones"
              item-key="name"
              :items="publications"
              :headers="headers"
              :total="total"
              :form="form"
              @save="saveStudy"
              @delete="deleteStudy"
              ref="dataTable">
              <template v-slot:formContainer>
               <form enctype="multipart/form-data" id="formImg">
                    <v-row>
                    <v-img
                    height="100%"
                    :src="previewAvatar"
                      class="mx-auto"
                    max-width="300"
                    >
                    <v-row
                        align="end"
                        class="fill-height"
                    >
                        <v-col
                        align-self="start"
                        class="pa-0"
                        cols="12"
                        >
                        </v-col>
                        <v-col class="py-0">
                        <v-list-item
                            color="#FFEB42"
                            dark
                        >
                            <v-list-item-content>
                            <v-list-item-title class="text-h5 font-weight-bold">
                                Alejandro Benitez
                            </v-list-item-title>
                            <v-list-item-subtitle>Autor Básico</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                        </v-col>
                        </v-row>
                        </v-img>
                    </v-row>
                    <v-row>
                        <v-col cols="12" md="6" lg="6" class="offset-3">
                            <v-file-input
                                accept="image/png, image/jpeg, image/bmp"
                                placeholder="Cargar imagen"
                                prepend-icon="mdi-camera"
                                label="Cargar imagen"
                                type="file"
                                @change="setAvatar"
                            ></v-file-input>
                        </v-col>
                    </v-row>
                </form>
                <v-row justify="center">
                    <v-col cols="12" md="10">
                        <v-text-field
                          v-model="form.title"
                          :rules="validatepublications.publicationsRules"
                          label="Título"
                          required
                          >
                        </v-text-field>
                    </v-col>
                  <v-col cols="12" md="10" class="mb-5">
                    <v-autocomplete
                        v-model="form.categories_id"
                        label="Seleccione"
                        required
                        >
                    </v-autocomplete>
                  </v-col>
                  <v-col cols="12" md="10">
                    <v-textarea
                        v-model="form.description"
                        solo
                        name="input-7-4"
                        label="Descripción"
                        >
                    </v-textarea>
                  </v-col>
                </v-row>
              </template>
            </data-table-crud>
          </v-form>
        </v-col>
      </v-col>
    </v-row>
  </v-container>
</app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import DataTableCrud from '@/Components/data-table-crud'

export default {
    components: {
        AppLayout,
        DataTableCrud
    },
    data() {
        return {
            previewAvatar:'',
            loading: true,
            data: {},
            total: 0,
            max: 0,
            form: {},
            headers: [{
                    text: 'Titulo',
                    value: 'title',
                    sortable: false
                },
                {
                    text: 'Autor',
                    value: 'user',
                    sortable: false
                },
                {
                    text: 'Categoría',
                    value: 'categories_id',
                    sortable: false
                },
                {
                    text: 'Descripción',
                    value: 'description',
                    sortable: false
                },
                {
                    text: 'Fecha',
                    value: 'date_publication',
                    sortable: false
                },
            ],
            filter: {
                search: '',
            },
            publications: [],
            validatepublications: {
                publicationsRules: [
                    v => !!v || '* La publicación es requerida.',
                    v => (v && v.length <= 15) || '* La publicación debe contener máximo 15 caracteres.',
                    v => (v && v.length >= 3) || '* La publicación debe contener mínimo 3 caracteres.'
                ],
            }
        }
    },
    mounted(){
        // Image of publication for default //
        if(!this.previewAvatar) this.previewAvatar =  '/img/settings.png';
    },
    methods: {
        setAvatar(){
            console.log("Imagen");
        },
        //   getStudy(options)
        //   {
        //     this.$refs.dataTable.loading = true;
        //     this.filter.perPage = options.itemsPerPage;
        //     axios.post(route('config.getStudy', {
        //       page: options.page,
        //     }), this.filter)
        //     .then( (response) => {
        //       if(this.filter.perPage > 0)
        //       {
        //         this.studies =  response.data.data;
        //         this.total = response.data.total;

        //       }
        //       else
        //       {
        //         this.studies =  response.data;
        //         this.total = response.data.length;

        //       }
        //         this.$refs.dataTable.loading = false;
        //     })
        //   },
        //   editStudy(study)
        //   {
        //     this.$refs.form.resetValidation()
        //     this.form = study;
        //   },

        saveStudy() {
            if (this.$refs.form.validate()) {
                //   axios.post(route('config.storeStudy'), this.form)
                //   .then(() => {
                // this.$swal.fire({
                //   position: 'center',
                //   icon: 'success',
                //   title: 'Solicitud realizada exitosamente.',
                //   showConfirmButton: false,
                //   timer: 1500
                // })
                //     this.getStudy(this.$refs.dataTable.options);
                //     this.$refs.dataTable.dialog = false;
                //   })
                this.$swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Solicitud realizada exitosamente.',
                    showConfirmButton: false,
                    timer: 1500
                })
                console.log("sisa")
                this.$refs.dataTable.dialog = false;
            } else {
                this.$toast.open({
                    message: 'Complete los campos requeridos.!',
                    type: 'error',
                    position: 'top-right'
                });
            }
        },
        deleteStudy(item) {
            axios.delete(route('config.deleteStudy', {
                    id: item.id
                }))
                .then(() => {
                    this.$swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'El registro se eliminó exitosamente.',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    this.getStudy(this.$refs.dataTable.options);
                })
        }
    }
}
</script>
