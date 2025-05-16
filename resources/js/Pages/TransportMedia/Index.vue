<template>
    <Head title="Roles Management" />

    <BreezeAuthenticatedLayout>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">
                                <!-- {{ route().current() }} -->
                                Transport Medias
                            </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Home</li>
                                <li class="breadcrumb-item active">
                                    <!-- {{ route().current() }} -->Transport Medias
                                </li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content text-sm">
                <div class="container-fluid">
                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-12 connectedSortable">
                            <!-- start your code here -->
                            <div class="py-6">
                                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                        <div class="p-4 bg-white border-b border-gray-200">
                                            <div v-if="success"
                                                class="p-4 mb-4 text-sm text-blue-700 bg-blue-100 rounded-lg" role="alert">
                                                {{ success }}
                                            </div>
                                            <div class="flex justify-end mt-2">
                                                <button @click="openModal()"
                                                    class="inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                                Add
                                                </button>
                                            </div>
                                            <div class="card-header">
                                                <h3 class="card-title">Transport Medias</h3>

                                                <div class="card-tools">
                                                    <div class="input-group input-group-sm" style="width: 150px;">
                                                        <input type="text" v-model="search" @keyup="searchmedia()"
                                                            class="border-gray-200 focus:border-green-300 focus:ring-0  form-control float-right"
                                                            placeholder="Search...">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body table-responsive p-0">
                                                <table class="table table-hover text-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Name</th>
                                                            <th>Mode of Transport</th>
                                                            <th>Registration</th>
                                                            <th>Site</th>
                                                            <th>Driver Phone No.</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody v-for="$media in TransportMedias.data" :key="$media.id">
                                                        <tr>
                                                            <td>{{ $media.id }}</td>
                                                            <td>{{ $media.transport }}</td>
                                                            <td>{{ $media.name }}</td>
                                                            <td>{{ $media.description }}</td>
                                                            <td>{{ $media.site }}</td>
                                                            <td>{{ $media.phone }}</td>
                                                            <td>
                                                                <i @click="destroyMedia($media.id)"
                                                                    class="fas fa-trash text-red-500 hover:text-red-700 cursor-pointer"></i>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.card-body -->
                                            <pagination class="mt-6" :links="TransportMedias.links" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- /.Left col -->

                    </div>
                    <!-- /.row (main row) -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>

        <div class="fixed z-0 inset-0 overflow-y-auto ease-out duration-400 text-xs" v-if="isOpen">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                <div class="fixed inset-0 transition-opacity">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
                <div class="inline-block align-center bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                    role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                    <form @submit.prevent="createMedia()">
                        <div class="bg-white px-4 pt-5 pb-2 sm:p-2 sm:pb-2">
                            <div class="card-header">
                                <h4 class="card-title">Add Transport Media</h4>
                            </div>
                            <div class="card-body">
                                <!-- the events -->
                                <div class="pt-3">
                                    <label class="block mb-2 text-sm font-medium">Name</label>
                                    <input type="text" v-model="form.transport"
                                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        placeholder="Name of the Person" required>
                                </div>
                                <div class="pt-3">
                                    <label class="block mb-2 text-sm font-medium">Mode of Transport</label>
                                    <!-- <select v-model="form.name" -->
                                        <input type="text" v-model="form.name"
                                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        placeholder="Donkey/Motor Bike/Vehicle/Worker" required>
                                    <!-- </select> -->
                                </div>
                                <div class="text-xs text-red-600 mt-1" v-if="form.errors.name">{{ form.errors.name }}
                                </div>
                                <div class="pt-3">
                                    <label class="block mb-2 text-sm font-medium">Registration</label>
                                    <input type="text" v-model="form.description"
                                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        placeholder="KCH 008H" required>
                                </div>
                                <div class="text-xs text-red-600 mt-1" v-if="form.errors.description">{{ form.errors.description }}
                                </div>
                                <div class="pt-3">
                                    <label class="block mb-2 text-sm font-medium">Site</label>
                                    <select v-model="form.site"
                                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        placeholder="Role in Caps" required>
                                        <option value="7 Forks">7 Forks</option>
                                        <option value="Head Office">Head Office</option>
                                        <option value="Kiambere">Kiambere</option>
                                        <option value="Nyongoro">Nyongoro</option>
                                    </select>
                                </div>
<!-- utf8mb4_unicode_ci	 -->
                                <div class="pt-3">
                                    <label class="block mb-2 text-sm font-medium">Driver's phone Number</label>
                                    <input type="text" v-model="form.phone"
                                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        placeholder="Driver's phone Number" required>
                                </div>

                                <div class="text-xs text-red-600 mt-1" v-if="form.errors.name">{{ form.errors.name }}
                                </div>
                                <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <span class="mt-1 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto ml-2">
                                        <button type="submit"
                                            class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                                            :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                            Save
                                        </button>
                                    </span>
                                    <span class="mt-1 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">

                                        <button @click="closeModal()" type="button"
                                            class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                            Cancel
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import Pagination from '@/Components/pagination.vue'
export default {
    components: { BreezeAuthenticatedLayout, Head, Link, Pagination },
    props: {
        TransportMedias: Object,
        success: String,
    },
    data() {
        return {
            isOpen: false,
            form: this.$inertia.form({
                transport: null,
                name: null,
                description: null,
                site: null,
                phone: null,
            }),
        }
    },
    methods: {
        openModal() {
            this.isOpen = true;
        },
        closeModal() {
            this.isOpen = false;
        },
        createMedia() {
            this.form.post('/create-media', {
                onSuccess: () => form.reset('transport'),
                onSuccess: () => form.reset('name'),
                onSuccess: () => form.reset('phone'),
                onSuccess: () => form.reset('description','site'),
                onSuccess: () => this.closeModal(),
            });
        },
        destroyMedia(id) {
            if (confirm("Are you sure?")) {
                this.form.delete(`/destroy-media/${id}`, {
                    onSuccess: () => this.closeModal(),
                });
            }
        },
    }
}
</script>