<template>
<v-data-table
  :headers="headers"
  :items="items"
  :options.sync="options"
  :server-items-length="total"
  :loading="loading"
  data-app
  class="elevation-8"
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
        max-width="800px"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-btn
            color="secondary"
            dark
            class="mt-4"
            v-bind="attrs"
            v-on="on"
            small
            rounded
          >
          <v-icon color="primary" left>
            mdi-plus
          </v-icon>
            Registrar
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
          <v-card-title class="text-h5">¿Estas seguro que deseas eliminar?</v-card-title>
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
    <v-icon
      small
      class="mr-2"
      @click="editItem(item)"
    >
      mdi-pencil
    </v-icon>
    <v-icon
      small
      @click="deleteItem(item)"
    >
      mdi-delete
    </v-icon>
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