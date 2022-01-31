<template>
<app-layout>
<v-card class="mx-auto" max-width="100%">
    <v-container>
      <v-row class="justify-center mt-10">
        <v-col cols="12" sm="6" md="9" lg="9">
        <v-row>
          <v-col cols="12" md="12" lg="12">
            <h1 class="mb-5"><v-icon size="50" class="mr-2" color="secondary">mdi-clipboard-text-multiple</v-icon>{{data.person_data.fullname}}</h1>
          </v-col>
        </v-row>
          <v-row>
              <v-col cols="12" md="12" lg="12" class="text-center">
                <v-avatar
                  size="130"
                  color="grey"
                >
                  <v-img :src="previewImage"></v-img>
                </v-avatar>
              </v-col>
            </v-row>
        <v-row>
          <v-col cols="12" sm="4" md="6" lg="6">
            <h3 class="font-weight-black">
              Contacto
            </h3>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" md="4" lg="4">
              <p class="font-weight-bold subtitle-2"><v-icon color="secondary">mdi-email</v-icon> Correo electrónico</p>
              
          </v-col>
          <v-col cols="12" md="4" lg="4" class="mb-5">
              <p class="font-weight-bold subtitle-2"><v-icon color="secondary">mdi-cellphone-iphone</v-icon> Teléfono de contacto</p>
             
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" sm="4" md="6" lg="6">
            <h3 class="font-weight-black">
              Datos personales
            </h3>
          </v-col>
        </v-row>
         <v-row>
          <v-col cols="12" sm="4" md="12" lg="12">
            <h3 class="font-weight-black mb-1">
              Expectativa salarial
            </h3>
          </v-col>
        </v-row>
        <v-row class="mb-5">
          <v-col cols="12" sm="8" md="12" lg="12">
               
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" sm="4" md="12" lg="12">
            <h3 class="font-weight-black mb-3">
              Educación
            </h3>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" sm="4" md="6" lg="6">
            <h3 class="font-weight-black mb-3">
              Experiencia laboral
            </h3>
          </v-col>
        </v-row>
      <v-row>
        <v-col
          cols="12"
          md="12"
          lg="12"
          class="text-center mb-6">
            <v-btn color="secondary" class="font-weight-bold" @click="back" rounded>
              Cerrar
            </v-btn>
          </v-col>
      </v-row>
  </v-container>
</v-card>
</app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'

export default {
    components: {
      AppLayout,
    },
    props:['data'],
    data: () => ({
      previewImage:''
   }),
   mounted(){
     if(!this.data.image){
       this.previewImage ='/img/setting.png';
     }
   },
   created () {
     this.data.publication = this.data.publication ? this.data.publication : [];
     this.previewImage = this.data.image ? this.data.image : null;
   },
   methods: {
    back() {
      window.history.back();
    }
   },
}
</script>