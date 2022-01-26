<template>
<v-app id="inspire">
    <v-container class="fill-height" fluid>
        <v-row align="center" justify="center">
            <v-col cols="12" sm="6" md="4" lg="4" class="mt-10">
                <v-card class="mt-5">
                    <template>
                        <img :src="'/img/blog-login.png'" class="imgAdmin"></v-img>
                    </template>
                    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                        {{ status }}
                    </div>
                    <v-form @submit.prevent="submit">
                        <v-card-text>
                            <v-main class="font-weight-bold mt-1">
                                Inicio de Sesión
                            </v-main>
                        </v-card-text>
                            <v-row class="flex justify-center">
                                <v-col cols="12" md="10">
                                    <v-text-field
                                    v-model="form.email"
                                    :rules="validateAdmin.email"
                                    max="50" 
                                    min="15"
                                    name="email"
                                    label="Correo electrónico" 
                                    prepend-icon="mdi-account-tie-outline" 
                                    type="email" 
                                    title="Indique el usuario." 
                                    required>
                                    </v-text-field>
                                </v-col>
                            </v-row>
                            <v-row class="flex justify-center" style="margin-top:-20px;">
                                <v-col cols="12" md="10">
                                    <v-text-field 
                                        v-model="form.password"
                                        :rules="validateAdmin.password" 
                                        max="15" 
                                        min="20" 
                                        :counter="max" 
                                        name="password" 
                                        label="Contraseña" 
                                        prepend-icon="mdi-key-arrow-right" 
                                        title="Indique la contraseña." 
                                        autocomplete="current-password" 
                                        type="password" 
                                        required>
                                    </v-text-field>
                                </v-col>
                            </v-row>
                        <v-row class="flex justify-center mb-4">
                            <v-col cols="12" sm="4" md="6" lg="6" class="offset-3">
                                <inertia-link v-if="canResetPassword" color="dark" :href="route('password.request')" class="underline text-sm text-gray-600 hover:text-gray-900">
                                        ¿Olvidaste tu contraseña?
                                </inertia-link>
                            </v-col>
                        </v-row>
                        <v-row class="flex justify-center mb-4">
                            <v-col cols="12" sm="6" md="1" lg="1">
                                <v-btn color="dark" fab dark type="submit">
                                    <v-icon title="Iniciar sesión.">mdi-login-variant</v-icon>
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</v-app>

</template>

<script>
    export default {
        props: {
            canResetPassword: Boolean,
            status: String
        },

        data() {
            return {
                max:0,
                form: this.$inertia.form({
                    email: '',
                    password: '',
                    remember: false,
                    
                }),
                validateAdmin:{
                    email: [
                        v => !!v || '* El correo electrónico es requerido.',
                        v => /.+@.+\..+/.test(v) || '* El correo electrónico debe ser válido.',
                        v => (v && v.length <= 50) || '* El correo electrónico debe contener máximo 50 caracteres.',
                        v => (v && v.length >= 15) || '* El correo electrónico debe contener mínimo 15 caracteres.'
                    ],
                    password: [
                        v => !! v || '* La contraseña es requerida.',
                        v => (v && v.length <= 15) || '* La contraseña debe contener máximo 20 caracteres.',
                        v => (v && v.length >= 6) || '* La contraseña debe contener minimo 6 caracteres.'
                    ],
                },
            }
        },
        methods: {
            submit() {
                this.form
                .transform(data => ({
                    ... data,
                    remember: this.form.remember ? 'on' : ''
                }))
                .post(this.route('login'), {
                    onFinish: () => this.form.reset('password'),
                })
            }
        }
    }
</script>

<style>
.imgAdmin{
    border-radius: 5px !important; 
}
</style>