<script setup>
    import { VApp, VMain } from 'vuetify/components'
    import { onMounted } from 'vue';
    import { useStore } from 'vuex';
    const store = useStore()
    const loaded = $ref(false)

    onMounted(async () => {
        const isAuthenticated = localStorage.getItem('USER_AUTHENTICATED');
        
        if (isAuthenticated && isAuthenticated === 'true') {
            await store.dispatch('me');

            loaded = true;
        } else {
            loaded = true;
        }
    });
</script>

<template>
    <v-app>
        <v-main>
            <router-view v-if="loaded"/>
        </v-main>
    </v-app>
</template>