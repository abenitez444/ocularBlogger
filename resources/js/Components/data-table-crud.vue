<template>
  <v-data-table
    :headers="headers"
    :items="items"
    :options.sync="options"
    :server-items-length="total"
    :loading="loading"
    class="elevation-8"
    :footer-props="{
      showFirstLastPage: true,
      firstIcon: 'mdi-arrow-collapse-left',
      lastIcon: 'mdi-arrow-collapse-right',
      prevIcon: 'mdi-minus',
      nextIcon: 'mdi-plus',
        'items-per-page-text':'Filas por página'
    }"
  >
    <template v-slot:top>
      <v-toolbar
        flat
      >
        <v-toolbar-title class="mt-4 font-weight-bolder">{{title? title : ''}}</v-toolbar-title>
        <v-divider
          class="mx-2"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>
        <v-dialog
          v-model="dialog"
          persistent
          max-width="500px"
        >
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              color="primary"
              dark
              class="mt-4"
              v-bind="attrs"
              v-on="on"
              small
              rounded
            >
            <v-icon left>
                mdi-label
            </v-icon>
            Nueva
            </v-btn>
          </template>
          <v-card>
            <v-card-title class="text-left">
              <span class="text-h5">{{ formTitle }}</span>
            </v-card-title>
            <v-card-text>
              <v-container>
                <slot name="formContainer"></slot>
              </v-container>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn
                color="blue darken-1"
                text
                @click="close"
              >
                Cancelar
              </v-btn>
              <v-btn
                color="blue darken-1"
                text
                @click="save"
              >
                Guardar
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <v-dialog v-model="dialogDelete" max-width="500px">
          <v-card>
            <v-card-title class="text-h5 ml-5">¿Estas seguro que deseas eliminar?</v-card-title>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closeDelete">Cancelar</v-btn>
              <v-btn color="blue darken-1" text @click="deleteItemConfirm">Aceptar</v-btn>
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    <template v-slot:[`item.actions`]="{ item }">
    <v-row> 
      <v-col cols="12" class="flex"> 
        <v-btn
        class="mx-2"
        fab
        dark
        small
        color="cyan"
        >
          <v-icon  
          small
          @click="editItem(item)" dark>
          mdi-pencil
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
    </v-row>
    </template>
    <template v-slot:no-data>
      <h6 class="h6">Sin datos</h6>
    </template>
  </v-data-table>
</template>
<script>
  export default {
    props:['title', 'items', 'total', 'headers', 'form'],
    data: () => ({
      dialog: false,
      dialogDelete: false,
      desserts: [],
      options:{},
      editedIndex: -1,
      editedItem:{},
      loading:false
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Registrar' : 'Editar'
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
      dialogDelete (val) {
        val || this.closeDelete()
      },
      options: {
        handler () {
          this.getData();
        },
        deep: true,
      }, 
    },
    methods: {
      getData()
      {
        this.$emit('getData', this.options);
      },
      editItem (item) {
        this.editedIndex = this.items.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.$emit('edit', this.editedItem);
        this.dialog = true
      },

      deleteItem (item) {
        this.editedIndex = this.items.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

      deleteItemConfirm () {
        //this.items.splice(this.editedIndex, 1)
        this.$emit('delete', this.editedItem)
        this.closeDelete()
      },

      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.$emit('edit', {});
          this.editedIndex = -1
        })
      },

      closeDelete () {
        this.dialogDelete = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      save () {
        this.$emit('save')
      },
    },
  }
</script>