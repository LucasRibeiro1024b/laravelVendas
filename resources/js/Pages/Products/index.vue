<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Item from '@/Components/Item.vue';

import {
  DynamicTab,
  DynamicTabContent,
  DynamicTabSettings,
} from "vue3-dynamic-tabs";

defineProps([
    'products'
]);

const form = useForm({
    name: '',
    price: '',
});

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <dynamic-tab-settings
            :options="{
                defaultTabHash: 'cadastro'
            }"
        />
        <template #header>
            <dynamic-tab id="cadastro" tag="a" class="sm:ml-10 font-semibold text-xl text-gray-800 leading-tight" tabName="Cadastro" />
            <dynamic-tab id="products" tag="a" class="sm:ml-10 font-semibold text-xl text-gray-800 leading-tight" tabName="Produtos" />
        </template>

        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            <dynamic-tab-content tabName="Cadastro">
                <form @submit.prevent="form.post(route('products.store'), { onSuccess: () => form.reset() })">
                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/3">
                            <label class="block text-gray-500 font-bold" for="inline-full-name">
                                Nome
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <TextInput
                                v-model="form.name"
                                placeholder="Potato"
                                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            ></TextInput>
                        </div>
                    </div>
                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/3">
                            <label class="block text-gray-500 font-bold" for="inline-full-name">
                                Price
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <input
                                type="number"
                                v-model="form.price"
                                placeholder="20,5"
                                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            />
                        </div>
                    </div>
                    <InputError :message="form.errors.message" class="mt-2" />
                    <PrimaryButton class="mt-4">Salvar</PrimaryButton>
                </form>
            </dynamic-tab-content>

            <dynamic-tab-content tabName="Produtos">
                <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                    <Item
                        v-for="item in products"
                        :key="item.id"
                        :item="item"
                    />
                </div>
            </dynamic-tab-content>
        </div>
    </AuthenticatedLayout>
</template>
