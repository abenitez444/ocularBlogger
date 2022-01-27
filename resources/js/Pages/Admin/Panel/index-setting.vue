<template>
<v-container>
    <v-row class="flex justify-center">
        <v-col cols="12" sm="3" md="4" lg="4">
            <v-card color="#303030" dark>
                <v-card-title class="text-h5">
                 <i class="mdi mdi-account font-weight-bold"></i> <span class="ml-2"><b>Usuarios</b></span>
                </v-card-title>
                <v-card-actions>
                    <v-chip class="ma-2 ml-4" color="gray" label text-color="white">
                        <v-icon left>
                            mdi-label
                        </v-icon>
                        Cantidad 6
                    </v-chip>
                </v-card-actions>
            </v-card>
            <v-card color="#3D729D" dark>
                <v-card-title class="text-h5">
                    <i class="mdi mdi-message-arrow-right"></i> <span class="ml-2"><b>Categorias</b></span> 
                </v-card-title>
                <v-card-actions>
                    <v-chip class="ma-2 ml-4" color="gray" label text-color="white">
                        <v-icon left>
                            mdi-label
                        </v-icon>
                        5 Deportes
                    </v-chip>
                </v-card-actions>
                <v-card-actions>
                    <v-chip class="ma-2 ml-4" color="gray" label text-color="white">
                        <v-icon left>
                            mdi-label
                        </v-icon>
                        10 Tecnología
                    </v-chip>
                </v-card-actions>
                <v-card-actions>
                    <v-chip class="ma-2 ml-4" color="gray" label text-color="white">
                        <v-icon left>
                            mdi-label
                        </v-icon>
                        3 Automóviles
                    </v-chip>
                </v-card-actions>
            </v-card>
            <v-card color="#008F91" dark>
                <v-card-title class="text-h5">
                   <i class="mdi mdi-post-outline"></i> <span class="ml-2"><b>Publicaciones</b></span> 
                </v-card-title>
                <v-card-actions>
                    <v-chip class="ma-2 ml-4" color="gray" label text-color="white">
                        <v-icon left>
                            mdi-label
                        </v-icon>
                        7 Diarias
                    </v-chip>
                </v-card-actions>
                <v-card-actions>
                    <v-chip class="ma-2 ml-4" color="gray" label text-color="white">
                        <v-icon left>
                            mdi-label
                        </v-icon>
                        3 Mensual
                    </v-chip>
                </v-card-actions>
                <v-card-actions>
                    <v-chip class="ma-2 ml-4" color="gray" label text-color="white">
                        <v-icon left>
                            mdi-label
                        </v-icon>
                        10 Total
                    </v-chip>
                </v-card-actions>
            </v-card>
        </v-col>
        <v-col cols="12" sm="4" md="8" lg="8">
            <table-admin />
        </v-col>
    </v-row>
</v-container>
</template>

<script>
import TableAdmin from '@/Pages/Admin/Panel/TableAdmin';

export default {
    components: {
        TableAdmin
    },
    data: () => ({
        items: [{
                color: '#1F7087',
                src: 'https://cdn.vuetifyjs.com/images/cards/foster.jpg',
                title: 'Supermodel',
                artist: 'Foster the People',
            },
            {
                color: '#952175',
                src: 'https://cdn.vuetifyjs.com/images/cards/halcyon.png',
                title: 'Halcyon Days',
                artist: 'Ellie Goulding',
            },
        ],
    }),
}
</script>
