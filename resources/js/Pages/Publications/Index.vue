<template>
<app-layout>
  <v-container
    id="dashboard"
    fluid
    tag="section">
    <v-row class="justify-center">
      <v-col cols="12" md="4" lg="4">
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
              v-for="(slide, i) in slides"
              :key="i"
            >
              <v-img :src="previewImage"></v-img>
              <v-sheet
                :color="colors[i]"
                height="100%"
                tile
              >
                <v-row
                  class="fill-height"
                  align="center"
                  justify="center"
                >
                  <div class="text-h2">
                    {{ slide }} 
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
        <v-col cols="12" md="8" lg="8">
            <v-data-table
            :headers="headers"
            :items="publications"
            :options.sync="options"
            :server-items-length="total"
            :loading="loading"
            class="elevation-10"
          >
          <template v-slot:[`item.actions`]="{ item }">
            <v-col cols="12" class="flex"> 
               <v-btn
                color="secondary"
                class="ma-1 white--text"
                small
                @click="saveRedirect(item)" 
                >
                  Nueva
                  <v-icon
                    right
                    dark
                  >
                    mdi-plus
                  </v-icon>
                </v-btn>
                <v-btn
                color="primary"
                class="ma-1 white--text"
                small
                @click="detailItem(item)" 
                >
                  Ver
                  <v-icon
                    right
                    dark
                  >
                    mdi-gesture-swipe-up
                  </v-icon>
                </v-btn>
                <v-btn
                  color="indigo"
                  class="ma-1 white--text"
                  small
                  @click="editItem(item)"  
                >
                Editar
                  <v-icon
                    right
                    dark
                  >
                    mdi-tooltip-edit
                  </v-icon>
                </v-btn>
                <v-btn
                fab
                dark
                small
                color="#EE220A"
                title="Eliminar categoría."
                v-if="$page.props.user.rol_id === 1"
                >
                <v-icon  
                  small
                  @click="deleteItem(item)" 
                  dark
                  >
                  mdi-delete
                  </v-icon>
                </v-btn>
              </v-col>
            </template>
          </v-data-table>
           <v-dialog v-model="dialogDelete" max-width="500px">
            <v-card>
              <v-card-title class="text-h5">¿Estas seguro que deseas eliminar?</v-card-title>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="dialogDelete = false">Cancelar</v-btn>
                <v-btn color="blue darken-1" text @click="deleteItemConfirm">Aceptar</v-btn>
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-col>
    </v-row>
  </v-container>
</app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import DetailPublic from '@/Pages/Publications/Detail'


export default {
    components: {
        AppLayout,
        DetailPublic,
    },
    data() {
        return {
           colors: [
            'indigo',
            'warning',
            'pink darken-2',
            'red lighten-1',
            'deep-purple accent-4',
            ],
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
            data: {},
            options: {},
            total: 0,
            max: 0,
            dialogDetail: false,
            dialogDelete:false,
            categories:[],
            publications:[],
              form:{
                title:'',
                category_id:'',
                summary:'',
                description:'',
                valid: true
            },
            headers: [{
                text: 'Titulo',
                value: 'title',
                sortable: false
                },
                {
                    text: 'Autor',
                    value: 'author.name',
                    sortable: false
                },
                {
                    text: 'Categoría',
                    value: 'category.name',
                    sortable: false
                },
                {
                    text: 'Fecha de publicación',
                    value: 'created_at',
                    sortable: false
                },
                {
                    text: 'Opciones',
                    value: 'actions',
                    sortable: false
                },
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
    
      this.selectCategories();
    },
    watch: {
      options: {
        handler () {
          this.tablePublications()
        },
        deep: true,
      }, 
    },
    methods: {
        saveRedirect(item)
        {
           this.$inertia.visit(route('create.publication'), 
          {
            method: 'get'
          })
        },

        tablePublications(options)
        {
          this.loading = true;
          this.publications =  [];
          this.filter.perPage = this.options.itemsPerPage;
          axios.post(route('table.publication', {
            page: this.options.page,
          }), this.filter)
          .then( (response) => {
            this.publications =  response.data.data;
            this.loading = false;
            this.total = response.data.total;
          })
        },
        detailItem(item)
        {
          this.$inertia.visit(route('show.detail', {id:item.user_id}), 
          {
            method: 'get'
          })
          
        },
        editItem(item)
        {
          this.$inertia.visit(route(
            'edit', {id:item.id}), 
            {
              method: 'get'
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
        deleteItemConfirm (deleted) {
          this.dialogDelete = false
          var deleted = this.editedItem; 
          axios.delete(route('delete.publication', {id : deleted.id} ))
          .then(() => {
            this.$swal.fire({
              position: 'center',
              icon: 'success',
              title: 'El registro se eliminó exitosamente.',
              showConfirmButton: false,
              timer: 3000
            })
            this.getClients()
          })
      }
    }
}
</script>
