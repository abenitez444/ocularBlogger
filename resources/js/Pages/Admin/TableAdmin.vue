<template>
  <v-card>
    <v-card-title>
       <h2>Panel de configuración</h2> <i class="mdi mdi-wrench-outline ml-2"></i>
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
            text: 'Autores',
            align: 'left',
            sortable: false,
            value: 'authors',
          },
          { text: 'Roles', value: 'rol' },
          { text: 'Categorias', value: 'categories' },
          { text: 'Publicaciones', value: 'post' },
          { text: 'Opciones', value: 'option' },
        ],
        categorias: [
          { 
            authors:'Alejandro Benitez',
            categories: 'Tecnología',
            rol: 'Administrador',
            date_post: 22/12/2021,
            post: 24,
          },
          { 
            authors:'Alejandro Benitez',
            categories: 'Tecnología',
            rol: 'Básico',
            date_post: 22/12/2021,
            post: 24,
          },
          {
            authors:'Alejandro Benitez',
            categories: 'Deportes',
            date_post: 15/12/2021,
            post: 37,
          },
          {
            authors:'Alejandro Benitez',
            categories: 'Tecnología',
            date_post: 22/12/2021,
            post: 24,
          },
        ],
      }
    },
  }
</script>