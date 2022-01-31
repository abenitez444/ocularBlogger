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
              :items="permissions"
              :headers="headers"
              :total="total"
              :form="form"
              @getData="tablePermissions"
              @save="savePermission"
              @edit="editPermission"
              @delete="deletePermision"
              ref="dataTable">
              <template v-slot:formContainer>
                <v-row justify="center">
                    <v-col cols="12" md="8">
                        <v-text-field
                          v-model="form.name"
                          :rules="validate.nameRules"
                          label="Nombre de categoría"
                          max="20"
                          min="3">
                        </v-text-field>
                    </v-col>
                </v-row>
                <v-row justify="center">
                  <v-col cols="12" md="8">
                    <v-text-field
                      v-model="form.guard_name"
                      :rules="validate.guardRules"
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
      permissions: [],
      headers: [{
          text: 'Permiso',
          value: 'name',
          sortable: false
        },
        {
          text: 'Descripción',
          value: 'guard_name',
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
      validate: {
        nameRules: [
            v => !!v || '* El permiso es requerido.',
            v => (v && v.length <= 20) || '* El permiso debe contener máximo 20 caracteres.',
            v => (v && v.length >= 3) || '* El permiso debe contener mínimo 3 caracteres.'
        ],
        guardRules: [
          v => !!v || '* La descripción del permiso.',
            v => (v && v.length <= 50) || '* La descripción del permiso debe contener máximo 50 caracteres.',
            v => (v && v.length >= 3) || '* La descripción del permiso debe contener mínimo 3 caracteres.'
        ],
      }
    }
  },
  methods: {
    tablePermissions(options)
    {
      this.$refs.dataTable.loading = true;
      this.filter.perPage = options.itemsPerPage;
      axios.post(route('table.permission', {
        page: options.page,
      }), this.filter)
      .then((response) => {
        if(this.filter.perPage > 0)
        {
          this.permissions =  response.data.data;
          this.total = response.data.total;
        }
        else
        {
          this.permissions =  response.data;
          this.total = response.data.length;
        }
          this.$refs.dataTable.loading = false;
      })
    },
    savePermission() {
      if(this.$refs.form.validate()) {
          axios.post(route('save.permission'), this.form)
        .then(() => {
          this.$swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Solicitud realizada exitosamente.',
          showConfirmButton: false,
          timer: 1500
        })
          this.tablePermissions(this.$refs.dataTable.options);
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
    editPermission(permission)
    {
      this.$refs.form.resetValidation()
      this.form = permission;
    },
    deletePermision(item) {
      axios.delete(route('delete.permission', {
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
        this.tablePermissions(this.$refs.dataTable.options);
      })
    }
  }
}
</script>
