<template>
  <v-card>
    <v-card-title>
        <i class="mdi mdi-newspaper mr-1"></i> <h2>Panel general</h2>
      <v-spacer></v-spacer>
      <v-text-field
        v-model="search"
        append-icon="mdi-magnify"
        label="Search"
        single-line
        hide-details
      ></v-text-field>
    </v-card-title>
    <v-data-table
      :headers="headers"
      :items="categorias"
      :search="search"
    ></v-data-table>
  </v-card>
</template>
<script>
  export default {
    data () {
      return {
        search: '',
        headers: [
          {
            text: 'Usuarios',
            align: 'left',
            sortable: false,
            value: 'user',
          },
          { text: 'Roles', value: 'rol' },
          { text: 'Categorias', value: 'categories' },
          { text: 'Publicaciones', value: 'post' },
        ],
        categorias: [
          { 
            user:'Alejandro Benitez',
            categories: 'Tecnología',
            rol: 'Administrador',
            date_post: 22/12/2021,
            post: 24,
          },
          { 
            user:'Alejandro Benitez',
            categories: 'Tecnología',
            rol: 'Básico',
            date_post: 22/12/2021,
            post: 24,
          },
        ],
      }
    },
  }
</script>