<template>
    <app-layout>
        <template #header v-if="$page.props.user.rol_id === 1">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight ml-6 flex justify-left">
                <b class="mt-1">Bienvenido</b>
                 <span v-if="$page.props.jetstream.managesProfilePhotos">
                    <button>
                        <img class="h-9 w-9 rounded-full object-cover ml-2" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                    </button>
                </span>
                 <b class="ml-1 mt-1">{{$page.props.user.name}}</b> 
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
