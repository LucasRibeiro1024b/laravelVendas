<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm, Head } from '@inertiajs/vue3';
import Cliente from '@/Components/Cliente.vue';
// import {Tabs, Tab} from 'vue3-tabs-component';
import {
  DynamicTab,
  DynamicTabContent,
  DynamicTabSettings,
} from "vue3-dynamic-tabs";

defineProps([
    'clientes'
]);

const form = useForm({
    name: '',
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <dynamic-tab-settings
            :options="{
                defaultTabHash: 'clientes'
            }"
        />
        <template #header>
            <dynamic-tab id="cadastro" tag="a" class="sm:ml-10 font-semibold text-xl text-gray-800 leading-tight" tabName="Cadastro" />
            <dynamic-tab id="clientes" tag="a" class="sm:ml-10 font-semibold text-xl text-gray-800 leading-tight" tabName="Clientes" />
        </template>

        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            <dynamic-tab-content tabName="Cadastro">
                <form @submit.prevent="form.post(route('clientes.store'), { onSuccess: () => form.reset() })">
                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/3">
                            <label class="block text-gray-500 font-bold" for="inline-full-name">
                                Nome
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <TextInput
                                v-model="form.name"
                                placeholder="John Doe"
                                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            ></TextInput>
                        </div>
                    </div>
                    <InputError :message="form.errors.message" class="mt-2" />
                    <PrimaryButton class="mt-4">Salvar</PrimaryButton>
                </form>
            </dynamic-tab-content>

            <dynamic-tab-content tabName="Clientes">
                <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                    <Cliente
                        v-for="cliente in clientes"
                        :key="cliente.id"
                        :cliente="cliente"
                    />
                </div>
            </dynamic-tab-content>
        </div>
    </AuthenticatedLayout>
</template>
