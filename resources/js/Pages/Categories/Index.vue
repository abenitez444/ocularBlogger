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
              title="Categorias"
              item-key="name"
              :items="categories"
              :headers="headers"
              :total="total"
              :form="form"
              @save="saveCategories"
              @delete="deleteStudy"
              ref="dataTable">
              <template v-slot:formContainer>
                <v-row justify="center">
                    <v-col cols="12" md="8">
                        <v-text-field
                          v-model="form.name"
                          :rules="validateCategories.categoriesRules"
                          label="Nombre de categoría">
                        </v-text-field>
                    </v-col>
                </v-row>
                <v-row justify="center">
                  <v-col cols="12" md="8">
                    <v-text-field
                      v-model="form.description"
                      :rules="validateCategories.categoriesRules"
                      label="Descripción"
                      :counter="max">
                    </v-text-field>
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
            loading: true,
            data: {},
            total: 0,
            max: 0,
            form: {
              name:'',
              description:''
            },
            headers: [{
                    text: 'Categoría',
                    value: 'name',
                    sortable: false
                },
                {
                    text: 'Descripción',
                    value: 'description',
                    sortable: false
                },
                {
                    text: 'Acciones',
                    value: 'actions',
                    sortable: false
                },
            ],
            filter: {
                search: '',
            },
            categories: [],
            validateCategories: {
                categoriesRules: [
                    v => !!v || '* La categoría es requerida.',
                    v => (v && v.length <= 15) || '* La categoría debe contener máximo 15 caracteres.',
                    v => (v && v.length >= 3) || '* La categoría debe contener mínimo 3 caracteres.'
                ],
            }
        }
    },
    methods: {
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

        saveCategories() {
            if (this.$refs.form.validate()) {
                console.log(this.form);
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
                // this.$swal.fire({
                //     position: 'center',
                //     icon: 'success',
                //     title: 'Solicitud realizada exitosamente.',
                //     showConfirmButton: false,
                //     timer: 1500
                // })
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
