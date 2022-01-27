<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Bienvenido  <i class="mdi mdi-account-cog"></i> 
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <index-setting />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import indexSetting from '@/Pages/Admin/Panel/index-setting'

    export default {
        components: {
            AppLayout,
            indexSetting,
        },
    }
</script>
