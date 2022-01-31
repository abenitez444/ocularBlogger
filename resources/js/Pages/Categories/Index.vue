<template>
  <app-layout>
    <v-container
    id="dashboard"
    fluid
    tag="section">
    <v-row class="justify-center">
      <v-col cols="12" md="10">
        <v-col cols="12" md="12">
          <v-form
            ref="form"
            v-model="form.valid"
            lazy-validation>
            <data-table-crud
              title="Categorías"
              :items="categories"
              :headers="headers"
              :total="total"
              :form="form"
              @getData="tableCategories"
              @save="saveCategory"
              @edit="editCategory"
              @delete="deleteCategory"
              ref="dataTable">
              <template v-slot:formContainer>
                <v-row justify="center">
                    <v-col cols="12" md="8">
                        <v-text-field
                          v-model="form.name"
                          :rules="validateCategories.categoriesRules"
                          label="Nombre de categoría"
                          max="20"
                          min="3">
                        </v-text-field>
                    </v-col>
                </v-row>
                <v-row justify="center">
                  <v-col cols="12" md="8">
                    <v-text-field
                      v-model="form.description"
                      :rules="validateCategories.descriptionRules"
                      :counter="max"
                      label="Descripción"
                      max="50"
                      min="3">
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
      form: {},
      categories: [],
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
      validateCategories: {
        categoriesRules: [
            v => !!v || '* La categoría es requerida.',
            v => (v && v.length <= 20) || '* La categoría debe contener máximo 20 caracteres.',
            v => (v && v.length >= 3) || '* La categoría debe contener mínimo 3 caracteres.'
        ],
        descriptionRules: [
          v => !!v || '* La descripción es requerida.',
            v => (v && v.length <= 50) || '* La descripción debe contener máximo 50 caracteres.',
            v => (v && v.length >= 3) || '* La descripción debe contener mínimo 3 caracteres.'
        ],
      }
    }
  },
  methods: {
    tableCategories(options)
    {
      this.$refs.dataTable.loading = true;
      this.filter.perPage = options.itemsPerPage;
      axios.post(route('table.category', {
        page: options.page,
      }), this.filter)
      .then((response) => {
        if(this.filter.perPage > 0)
        {
          this.categories =  response.data.data;
          this.total = response.data.total;
        }
        else
        {
          this.categories =  response.data;
          this.total = response.data.length;
        }
          this.$refs.dataTable.loading = false;
      })
    },
    saveCategory() {
      if(this.$refs.form.validate()) {
          axios.post(route('save.category'), this.form)
        .then(() => {
          this.$swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Solicitud realizada exitosamente.',
          showConfirmButton: false,
          timer: 1500
        })
          this.tableCategories(this.$refs.dataTable.options);
          this.$refs.dataTable.dialog = false;
        })
      }else {
          this.$toast.open({
          message: 'Complete los campos requeridos.!',
          type: 'error',
          position: 'top-right'
        });
      }
    },
    editCategory(category)
    {
      this.$refs.form.resetValidation()
      this.form = category;
    },
    deleteCategory(item) {
      axios.delete(route('delete.category', {
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
        this.tableCategories(this.$refs.dataTable.options);
      })
    }
  }
}
</script>
