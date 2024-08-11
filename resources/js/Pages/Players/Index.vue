<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Player from '@/Components/Player.vue'
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Randomizer from '@/Components/Randomizer.vue'

import { useForm, Head } from '@inertiajs/vue3';

defineProps(['players']);
 
const form = useForm({
    name: '',
});
</script>
 
<template>
    <Head title="Players" />
 
    <AuthenticatedLayout>
        <div class="max-w-7xl mx-auto">
            <div class="max-w-100 p-4 sm:p-6 lg:p-8 pt-6">
                
                <form @submit.prevent="form.post(route('players.store'), { onSuccess: () => form.reset() })">   
                    <div>
                        <label for="hs-trailing-button-add-on" class="sr-only">Label</label>
                        <div class="flex rounded-lg shadow-sm">
                            <input v-model="form.name" type="text" id="hs-trailing-button-add-on" name="hs-trailing-button-add-on" placeholder="Add a player..." class="text-lg py-4 px-4 block w-full border-gray-200 shadow-sm rounded-s-lg focus:z-10 focus:border-gray-400 focus:ring-gray-400 disabled:opacity-50 disabled:pointer-events-none dark:bg-white dark:border-neutral-200 dark:text-neutral-900 dark:placeholder-neutral-500 dark:focus:ring-gray-400">
                            <button type="button" class="py-4 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-e-md border border-transparent bg-gray-600 text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 disabled:opacity-50 disabled:pointer-events-none">
                                Add
                            </button>
                        </div>
                    </div>
                    <InputError :message="form.errors.message" class="mt-2" />
                </form>
                <div class="flex space-x-4 mt-4">
                    <a as="button" :href="route('players.clear')" class="shadow_sm text-white text-center w-full block bg-rose-700 hover:bg-rose-800 focus:ring-4 focus:outline-none focus:ring-rose-300 font-medium rounded-md text-lg px-4 py-4 dark:bg-rose-600 dark:hover:bg-rose-700 dark:focus:ring-rose-800">Clear</a>
                    <a as="button" :href="route('players.randomize')" class="shadow-sm text-white text-center w-full block bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-md text-lg px-4 py-4 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">Randomize</a>
                </div>
                <div v-if="players.length > 0" class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                    <Player
                        v-for="player in players"
                        :key="player.id"
                        :player="player"
                    />
                </div>
                <div v-else class=" text-center content-center">
                    <p class="mt-12 text-3xl font-thin text-gray-400 italic">Add players to get started</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>