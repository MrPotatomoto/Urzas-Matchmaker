<script setup>
import Randomizer from '@/Components/Randomizer.vue'
import { useForm, Head } from '@inertiajs/vue3';

const $props = defineProps([
    'groups'
]);

const form = useForm({
    name: '',
});
</script>

<template>
    <Head title="Randomize" />
    <Randomizer
        :groups="groups"
    >
    </Randomizer>
</template>