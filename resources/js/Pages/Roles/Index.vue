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
                title="Roles"
                :items="roles"
                :headers="headers"
                :total="total"
                :form="form"
                @getData="tableRoles"
                @save="saveRol"
                @edit="editRol"
                @delete="deleteRol"
                ref="dataTable">
                <template v-slot:formContainer>
                  <v-row justify="center">
                      <v-col cols="12" md="8">
                          <v-text-field
                            v-model="form.name"
                            :rules="validateRoles.rolesRules"
                            label="Nombre del rol"
                            max="20"
                            min="3">
                          </v-text-field>
                      </v-col>
                  </v-row>
                  <v-row justify="center">
                    <v-col cols="12" md="8">
                      <v-text-field
                        v-model="form.description"
                        :rules="validateRoles.descriptionRules"
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
      roles: [],
      headers: [{
          text: 'Rol',
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
      validateRoles: {
        rolesRules: [
            v => !!v || '* El rol es requerida.',
            v => (v && v.length <= 15) || '* El rol debe contener máximo 15 caracteres.',
            v => (v && v.length >= 3) || '* El rol debe contener mínimo 3 caracteres.'
        ],
        descriptionRules: [
          v => !!v || '* La descripción del rol es requerida.',
            v => (v && v.length <= 50) || '* La descripción debe contener máximo 50 caracteres.',
            v => (v && v.length >= 3) || '* La descripción debe contener mínimo 3 caracteres.'
        ],
      }
    }
  },
  methods: {
    tableRoles(options)
    {
      this.$refs.dataTable.loading = true;
      this.filter.perPage = options.itemsPerPage;
      axios.post(route('table.rol', {
        page: options.page,
      }), this.filter)
      .then((response) => {
        if(this.filter.perPage > 0)
        {
          this.roles =  response.data.data;
          this.total = response.data.total;
        }
        else
        {
          this.roles =  response.data;
          this.total = response.data.length;
        }
          this.$refs.dataTable.loading = false;
      })
    },
    saveRol() {
      if(this.$refs.form.validate()) {
        axios.post(this.route('save.rol'), this.form)
        .then(() => {
          this.$swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Solicitud realizada exitosamente.',
          showConfirmButton: false,
          timer: 1500
        })
          this.tableRoles(this.$refs.dataTable.options);
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
    editRol(rol)
    {
      this.$refs.form.resetValidation()
      this.form = rol;
    },
    deleteRol(item) {
      axios.delete(route('delete.roles', {
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
        this.tableRoles(this.$refs.dataTable.options);
      })
    }
  }
}
</script>
