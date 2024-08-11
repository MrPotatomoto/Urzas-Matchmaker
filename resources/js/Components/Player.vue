<script setup>
import Dropdown from '@/Components/Dropdown.vue'
import DropdownLink from '@/Components/DropdownLink.vue'
import InputError from '@/Components/InputError.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import dayjs from 'dayjs'
import relativeTime from 'dayjs/plugin/relativeTime'
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

dayjs.extend(relativeTime)

const props = defineProps(['player'])

const form = useForm({
    name: props.player.name
})

const editing = ref(false)
</script>
 
<template>
    <div class="p-4 flex space-x-2">
        <div class="flex-1">
            <div class="flex justify-between items-center">
                <form v-if="editing" @submit.prevent="form.put(route('players.update', player.id), { onSuccess: () => editing = false })">
                    <input type="text" v-model="form.name" class="mt-4 w-full text-gray-900 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
                    <InputError :message="form.errors.message" class="mt-2" />
                    <div class="space-x-2">
                        <PrimaryButton class="mt-4">Save</PrimaryButton>
                        <button class="mt-4" @click="editing = false; form.reset(); form.clearErrors()">Cancel</button>
                    </div>
                </form>
                <p v-else class="text-xl text-gray-900">{{ player.name }}</p>
                <Dropdown v-if="player.user.id === $page.props.auth.user.id">
                    <template #trigger>
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                            </svg>
                        </button>
                    </template>
                    <template #content>
                        <button class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:bg-gray-100 transition duration-150 ease-in-out" @click="editing = true">
                            Edit
                        </button>
                        <DropdownLink as="button" :href="route('players.destroy', player.id)" method="delete">
                            Delete
                        </DropdownLink>
                    </template>
                </Dropdown>
            </div>
        </div>
    </div>
</template>