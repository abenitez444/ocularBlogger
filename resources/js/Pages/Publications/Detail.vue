<template>
<app-layout>
  <v-row  class=" mt-2">
    <v-col cols="12" md="8" lg="8" class="flex justify-center offset-2">
         <v-card elevation="2">
            <v-row>
                <v-col cols="12" md="6" lg="6">
                    <v-btn class="mt-5 ml-5" color="info" @click="back">
                        <v-icon>mdi-arrow-left-bold-hexagon-outline</v-icon> Regresar  
                    </v-btn>
                </v-col>
            </v-row> 
            <v-row> 
                <v-col cols="12" md="5" lg="5">
                    <v-img :src="previewImage" class="mt-5 ml-5" max-width="500" style="border-radius:10px;"></v-img>
                </v-col>
                 <v-col cols="12" md="7">
                    <v-card-title>
                        <h1>{{data.title}}</h1>
                    </v-card-title>
                    <v-card-title>
                     <p class="font-weight-bold subtitle-2"><v-icon color="secondary">mdi-tooltip-text</v-icon> Descripción de publicación</p>
                     </v-card-title>
                      <v-card-text>
                      {{data.description}}  
                      </v-card-text>
                    <p class="font-weight-bold subtitle-2 m-4"><v-icon color="secondary">mdi-calendar-text</v-icon> Resumen </p>
                        <v-card-text>
                        {{data.summary}}
                         </v-card-text>
                 </v-col>
            </v-row>
        <v-card-text>
        <v-row>
            <v-col cols="12" sm="4" md="6" lg="6">
             <p class="font-weight-bold subtitle-2"><v-icon color="secondary">mdi-account-outline</v-icon> Autor</p>
                {{data.author.name}}
            </v-col>
            <v-col cols="12" sm="4" md="6" lg="6">
            <p class="font-weight-bold subtitle-2" style="margin-left:-50px;"><v-icon color="secondary">mdi-calendar-text</v-icon> Fecha y Hora </p>
                <span style="margin-left:-50px;"> {{data.created_at}}</span>
             </v-col>
        </v-row>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
  </app-layout>
</template>


<script>
import AppLayout from '@/Layouts/AppLayout'


export default {
     components: {
        AppLayout,
  },      
  props:['data', 'index'],
    data: () => ({
      previewImage:''
   }),
   created () {
     this.previewImage = this.data.image ? this.data.image : null;
   },
   methods: {
    back() {
      window.history.back();
    }
   },
 
}
</script>