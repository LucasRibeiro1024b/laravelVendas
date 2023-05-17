<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {
    DynamicTab,
    DynamicTabContent,
    DynamicTabSettings,
} from "vue3-dynamic-tabs";
import {
    ref,
    reactive,
    onMounted
} from 'vue';

defineProps([
    'sales',
]);

const listClientes = ref([]);
const listProdutos = ref([]);

async function getData() {
    const res = await fetch('/api/clientes');
    const finalRes = await res.json();
    listClientes.value = finalRes;

    const res2 = await fetch('/api/produtos');
    const finalRes2 = await res2.json();
    listProdutos.value = finalRes2;
}

onMounted(getData);

const produto = ref(null);
const selectedProdutos = ref([]);

function addSelectedItem() {
    selectedProdutos.value.push(produto.value);
}

const removeFromList = (index) => {
    selectedProdutos.value.splice(index, 1);
};

const form = useForm({
    cliente_id: '',
    produtos: selectedProdutos
});


</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <dynamic-tab-settings :options="{
            defaultTabHash: 'cadastro'
        }" />
        <template #header>
            <dynamic-tab id="cadastro" tag="a" class="sm:ml-10 font-semibold text-xl text-gray-800 leading-tight"
                tabName="Cadastro" />
            <dynamic-tab id="products" tag="a" class="sm:ml-10 font-semibold text-xl text-gray-800 leading-tight"
                tabName="Vendas" />
        </template>

        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            <dynamic-tab-content tabName="Cadastro">
                <form @submit.prevent="form.post(route('sales.store'), { onSuccess: () => form.reset() })">
                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/3">
                            <label class="block text-gray-500 font-bold" for="inline-full-name">
                                Cliente
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <select name="cliente_id"
                                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                <option value="null" selected>Nenhum</option>
                                <option v-for="item in listClientes.clientes" :key="item.id">
                                    {{ item.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/3">
                            <label class="block text-gray-500 font-bold" for="inline-full-name">
                                Produto
                            </label>
                        </div>
                        <div class="md:w-1/3">
                            <select v-model="produto"
                                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                <option value="null" selected>Nenhum</option>
                                <option v-for="item in listProdutos.produtos" :key="item.id">
                                    {{ item.name }}
                                </option>
                            </select>
                        </div>
                        <div class="md:w-1/3">
                            <button @click="addSelectedItem"
                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                Adicionar
                            </button>
                        </div>
                    </div>
                    <div>
                        <table class="table-fixed">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Preço</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in selectedProdutos" :key="item.id">
                                    {{ item }}
                                    <td>{{ item.id }}</td>
                                    <td>{{ item.name }}</td>
                                    <td>
                                        <button @click="removeFromList(index)">Remover</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <InputError :message="form.errors.message" class="mt-2" />
                    <PrimaryButton class="mt-4">Salvar</PrimaryButton>
                </form>
            </dynamic-tab-content>
            <dynamic-tab-content tabName="Vendas">
            </dynamic-tab-content>
        </div>
    </AuthenticatedLayout>
</template>
                