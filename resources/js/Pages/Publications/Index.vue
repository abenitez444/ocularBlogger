<template>
<app-layout>
  <v-container
    id="dashboard"
    fluid
    tag="section">
    <v-row class="justify-center">
      <v-col cols="12" md="3" lg="3">
        <template>
        <v-card
          elevation="20"
          max-width="244"
          class="mx-auto"
        >
          <v-system-bar lights-out></v-system-bar>
          <v-carousel
            cycle
            :show-arrows="false"
            hide-delimiter-background
            delimiter-icon="mdi-minus"
            height="300"
          >
           <v-card-actions  style="margin-top:-19px;">
              <v-chip class="ma-2 ml-5" color="primary" label text-color="white">
                  <v-icon left>
                      mdi-label
                  </v-icon>
                  Publicaciones Recientes
              </v-chip>
            </v-card-actions>
            <v-carousel-item
              v-for="item in publications"
            >
              <v-img :src="item.image"></v-img>
              <v-sheet
                height="100%"
                tile
              >
                <v-row
                  class="fill-height"
                  align="center"
                  justify="center"
                >
                  <div class="text-h2">
                   
                  </div>
                </v-row>
              </v-sheet>
            </v-carousel-item>
          </v-carousel>
          <v-list two-line>
            <v-list-item>
              <v-list-item-avatar>
                <img class="h-10 w-10 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
              </v-list-item-avatar>
              <v-list-item-content>
                <v-list-item-title>Administrador</v-list-item-title>
                <v-list-item-subtitle>Autor</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
          </v-list>
        </v-card>
      </template>
      </v-col>
        <v-col cols="12" md="9" lg="9">
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
              @getData="tablePublications"
              @save="savePublications"
              @edit="editPublication"
              @delete="deletePublications"
              ref="dataTable">
              <template v-slot:formContainer>
               <form enctype="multipart/form-data" id="formImg">
                  <v-row>
                    <v-img
                    height="50%"
                    :src="previewImage"
                    class="mx-auto"
                    max-width="200">
                    <v-row
                      align="end"
                      class="fill-height">
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
                          </v-list-item>
                        </v-col>
                      </v-row>
                     </v-img>
                    </v-row>
                    <v-row>
                        <v-col cols="12" md="8" lg="8" class="offset-2 mb-4">
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
                          :rules="validate.titleRules"
                          label="Título"
                          required
                          solo
                          >
                        </v-text-field>
                    </v-col>
                  <v-col cols="12" md="10" class="mb-2">
                    <v-autocomplete
                        v-model="form.category_id"
                        placeholder="Categorías"
                        :items="categories"
                        :rules="validate.selectCategory"
                        item-value="id"
                        item-text="name"
                        solo
                        required
                        >
                    </v-autocomplete>
                  </v-col>
                  <v-col cols="12" md="10">
                    <v-text-field
                        v-model="form.summary"
                        :rules="validate.summaryRules"
                        name="input-7-4"
                        label="Resumen de publicación"
                        solo
                        >
                    </v-text-field>
                  </v-col>
                   <v-col cols="12" md="10">
                    <v-textarea
                        v-model="form.description"
                        name="input-7-4"
                        label="Descripción general"
                        :counter="max"
                        solo
                        >
                    </v-textarea>
                  </v-col>
                </v-row>
              </template>
            </data-table-crud>
          </v-form>
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
            slides: [
              'First',
              'Second',
              'Third',
              'Fourth',
              'Fifth',
            ],
            previewImage:'',
            image:'',
            loading: true,
            total: 0,
            max: 0,
            categories:[],
            publications:[],
              form:{
                title:'',
                category_id:'',
                summary:'',
                description:'',
                valid: true
            },
            headers: [
                {
                  text: 'Titulo',
                  value: 'title',
                  sortable: true
                },
                {
                    text: 'Autor',
                    value: 'author.name',
                    sortable: true
                },
                {
                    text: 'Categoría',
                    value: 'category.name',
                    sortable: true
                },
                {
                    text: 'Fecha y hora',
                    value: 'created_at',
                    sortable: true
                },
                {
                    text: 'Opciones',
                    value: 'actions',
                    sortable: true
                }
            ],
            filter: {
                search: '',
            },
            validate: {
                titleRules: [
                    v => !!v || '* El título de la publicación es requerida.',
                    v => (v && v.length <= 50) || '* El título debe contener máximo 50 caracteres.',
                    v => (v && v.length >= 3) || '* El título debe contener mínimo 3 caracteres.'
                ],
                selectCategory: [
                    v => !!v || '* La categoría de la publicación es requerida.',
                ],
                summaryRules: [
                    v => !!v || '* El resumen de la publicación es requerido.',
                    v => (v && v.length <= 50) || '* El título debe contener máximo 50 caracteres.',
                    v => (v && v.length >= 3) || '* El título debe contener mínimo 3 caracteres.'
                ],
            }
        }
    },
    mounted(){
    // Image of publication for default //
     
    if(!this.previewImage) this.previewImage = '/img/settings.png';
    console.log(this.data)
    this.selectCategories();
  
    },
   
    methods: {
        tablePublications(options)
        {
          this.$refs.dataTable.loading = true;
          this.filter.perPage = options.itemsPerPage;
          axios.post(route('table.publication', {
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
        selectCategories(){
            axios.get(route('select.category'))
            .then((res) => {
            this.categories = res.data
            })
            .catch((error) => {
            console.log(error)
            })
        },
        setImage(e){
            this.image = e;
            this.previewImage = URL.createObjectURL(e);
        },
        saveImage(publication_id)
        {
          let formElement = document.getElementById("formImg");
          let formImg = new FormData(formElement);
          formImg.append('file', this.image);
          formImg.append('publication_id', publication_id);
          const config = {
            headers: {
                'content-type': 'multipart/form-data'
            }
          }
          this.$inertia.post(route('upload.image'), formImg, config);
        },
        editPublication(publication)
        {
          this.$refs.form.resetValidation()
          this.form = publication;
        },
        savePublications() {
          
          let data = this.form;

          if(this.$refs.form.validate()){
            axios.post(route('save.publication'), {data})
            .then((res) => {
              this.saveImage(res.data)
              this.$swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: 'Solicitud realizada exitosamente.',
                  showConfirmButton: false,
                  timer: 1500
                })
                this.selectCategories(this.$refs.dataTable.options);
                this.$refs.dataTable.dialog = false;
                location.reload()
            })
            .catch((err) => {
               this.$toast.open({
                message: 'Complete los campos requeridos.!',
                type: 'error',
                position: 'top-right'
              });
              this.$refs.dataTable.dialog = false;
            });
          }else{
            this.$toast.open({
              message: '¡Debe completar los campos requeridos!',
              type: 'error',
              position: 'top'
            });
          }
        },
        deletePublications(item) {
          axios.delete(route('delete.publication', {
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
                location.reload()
                this.selectCategories(this.$refs.dataTable.options);
            })
        }
    }
}
</script>
