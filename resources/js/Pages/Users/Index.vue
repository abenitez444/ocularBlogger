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
              title="Usuarios"
              item-key="name"
              :items="users"
              :headers="headers"
              :total="total"
              :form="form"
              @save="submit"
              @delete="deleteStudy"
              ref="dataTable">
              <template v-slot:formContainer>
                <v-row justify="center">
                  <form @submit.prevent="submit">
                      <div>
                          <jet-label for="name" value="Name" />
                          <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
                      </div>

                      <div class="mt-4">
                          <jet-label for="email" value="Email" />
                          <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required />
                      </div>

                      <div class="mt-4">
                          <jet-label for="password" value="Password" />
                          <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
                      </div>

                      <div class="mt-4">
                          <jet-label for="password_confirmation" value="Confirm Password" />
                          <jet-input id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
                      </div>
                  </form>
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
import AppLayout from '@/Layouts/AppLayout';
import DataTableCrud from '@/Components/data-table-crud';
/*Components of jetstream*/

import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo';
import JetButton from '@/Jetstream/Button';
import JetInput from '@/Jetstream/Input';
import JetCheckbox from "@/Jetstream/Checkbox";
import JetLabel from '@/Jetstream/Label';

export default {
    components: {
        AppLayout,
        DataTableCrud,
        JetAuthenticationCardLogo,
        JetButton,
        JetInput,
        JetCheckbox,
        JetLabel
    },
    data() {
        return {
            loading: true,
            data: {},
            total: 0,
            max: 0,
            form: this.$inertia.form({
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    terms: false,
            }),
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
            users: [],
            validateusers: {
                usersRules: [
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

        submit() {
          this.form.post(this.route('register'), {
                onFinish: () => this.form.reset('password', 'password_confirmation'),
          })
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
