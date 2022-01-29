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
              @getData="allPublications"
              @save="savePublications"
              @delete="deletePublications"
              ref="dataTable">
              <template v-slot:formContainer>
               <form enctype="multipart/form-data" id="formImg">
                    <v-row>
                    <v-img
                    height="100%"
                    :src="previewImage"
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
                            <v-list-item-title class="text-h5 font-weight-bold" style="color:#F4FF03;">
                                Alejandro Benitez
                            </v-list-item-title>
                            <v-list-item-subtitle style="color:#F4FF03;"><b>Autor Administrador</b></v-list-item-subtitle>
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
                                @change="setImage"
                            ></v-file-input>
                        </v-col>
                    </v-row>
                </form>
                <v-row justify="center">
                    <v-col cols="12" md="10" lg="10">
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
                        v-model="form.category_id"
                        :items="categories"
                        item-value="id"
                        item-text="name"
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
          
            previewImage:'',
            image:'',
            loading: true,
            data: {},
            total: 0,
            max: 0,
            categories:[],
            publications:[],
            form: {
                title:'',
                user_id:null,
                category_id:'',
                description:'',
                create_at:''
            },
            headers: [{
                    text: 'Titulo',
                    value: 'title',
                    sortable: false
                },
                {
                    text: 'Autor',
                    value: 'user_id',
                    sortable: false
                },
                {
                    text: 'Categoría',
                    value: 'category_id',
                    sortable: false
                },
                {
                    text: 'Descripción',
                    value: 'description',
                    sortable: false
                },
            ],
            filter: {
                search: '',
            },
            validatepublications: {
                publicationsRules: [
                    v => !!v || '* El título de la publicación es requerida.',
                    v => (v && v.length <= 50) || '* El título debe contener máximo 50 caracteres.',
                    v => (v && v.length >= 3) || '* El título debe contener mínimo 3 caracteres.'
                ],
                categoriesRules: [
                    v => !!v || '* La categoría de la publicación es requerida.',
                ],
            }
        }
    },
    mounted(){
        // Image of publication for default //
        if(!this.previewImage) this.previewImage =  '/img/settings.png';
        this.getCategories();
    },
    methods: {
        allPublications(options)
        {
          this.$refs.dataTable.loading = true;
          this.filter.perPage = options.itemsPerPage;
          axios.post(route('allPublication', {
            page: options.page,
          }), this.filter)
          .then((response) => {
            if(this.filter.perPage > 0)
            {
              this.publications =  response.data.data;
              this.total = response.data.total;
            }
            else
            {
              this.publications =  response.data;
              this.total = response.data.length;
            }
              this.$refs.dataTable.loading = false;
          })
        },
        getCategories(){
            axios.get(route('getCategory'))
            .then((res) => {
            this.categories = res.data
            dd(res.data)
            console.log(res.data)
            })
            .catch((error) => {
            console.log(error)
            })
        },
        setImage(e){
            this.image = e;
            this.previewImage = URL.createObjectURL(e);
        },
        saveImage(user_id)
        {
          let formElement = document.getElementById("formImg");
          let formImg = new FormData(formElement);
          formImg.append('file', this.image);
          formImg.append('user_id', user_id);
          const config = {
            headers: {
                'content-type': 'multipart/form-data'
            }
        }
         this.$inertia.post(route('upload'), formImg, config);
        },
        savePublications() {
            if (this.$refs.form.validate()) {
                this.saveImage()
                this.previewImage = this.image
                  axios.post(route('savePublication'), this.form)
                  .then(() => {
                this.$swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: 'Solicitud realizada exitosamente.',
                  showConfirmButton: false,
                  timer: 1500
                })
                    this.getCategories(this.$refs.dataTable.options);
                    this.$refs.dataTable.dialog = false;
                  })
            
                this.$refs.dataTable.dialog = false;
            } else {
                this.$toast.open({
                    message: 'Complete los campos requeridos.!',
                    type: 'error',
                    position: 'top-right'
                });
            }
        },
        deletePublications(item) {
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
                this.getCategories(this.$refs.dataTable.options);
            })
        }
    }
}
</script>
