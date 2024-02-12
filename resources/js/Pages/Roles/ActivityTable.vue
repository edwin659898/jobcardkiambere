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
                                {{ route().current() }}
                            </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Home</li>
                                <li class="breadcrumb-item active">{{ route().current() }}
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
                                                class="p-4 mb-4 text-sm text-blue-700 bg-blue-100 rounded-lg"
                                                role="alert">
                                                {{ success }}
                                            </div>
                                            <div class="flex justify-end mt-2 mb-2">
                                                <button @click="openModalRole()"
                                                    class="inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">Edit
                                                    Roles</button>
                                                <button @click="openModalExcel()"
                                                    class="inline-flex ml-2 justify-center rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">Upload
                                                    Activities</button>
                                            </div>
                                            <div class="card-header">
                                                <h3 class="card-title">Job Card Activities</h3>

                                                <div class="card-tools">
                                                    <div class="input-group input-group-sm" style="width: 150px;">
                                                        <input type="text" v-model="search" @keyup="searchUser()"
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
                                                            <th>Activity Name</th>
                                                            <th>Roles</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody v-for="(activity, index) in Activities.data"
                                                        :key="activity.id">
                                                        <tr>
                                                            <td>{{ index + 1 }}</td>
                                                            <td>{{ activity.name }}</td>
                                                            <td>
                                                                <li v-for="$role in activity.roles" :key="$role.id">
                                                                    {{ $role.role }}
                                                                </li>
                                                            </td>
                                                            <td>
                                                                <Link
                                                                    :href="route('Edit.activity.roles', { id: activity.id })">
                                                                <i
                                                                    class="fas fa-edit cursor-pointer text-blue-500 hover:text-blue-700"></i>
                                                                </Link>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.card-body -->
                                            <pagination class="mt-6" :links="Activities.links" />
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
                    <form v-if="isExcel">
                        <div class="bg-white px-4 pt-5 pb-2 sm:p-2 sm:pb-2">
                            <div class="card-header">
                                <h4 class="card-title">Upload Activities</h4>
                            </div>
                            <div class="card-body">
                                <!-- the events -->
                                <div class="pt-3">
                                    <label class="block mb-2 text-sm font-medium">Choose Excel File</label>
                                    <input type="file" @input="form.file = $event.target.files[0]"
                                        accept=".xls,.xlsx" />
                                    <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                        {{ form.progress.percentage }}%
                                    </progress>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <span class="mt-1 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto ml-2">
                                <button type="button"
                                    class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                                    @click="uploadFile()" :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing">
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
                    </form>
                    <form v-if="isRole">
                        <div class="bg-white px-4 pt-5 pb-2 sm:p-2 sm:pb-2">
                            <div class="card-header">
                                <h4 class="card-title">Roles</h4>
                            </div>
                            <div class="card-body">
                                <!-- the events -->
                                <div id="external-events">
                                    <div v-for="$item in CreatedRoles" :key="$item.id"
                                        class="flex justify-between external-event bg-primary">
                                        {{ $item.role }}
                                        <i @click="destroyRole($item.id)"
                                            class="fas fa-trash cursor-pointer text-red-500 hover:text-red-800"></i>
                                    </div>
                                </div>
                                <div class="pt-3">
                                    <label class="block mb-2 text-sm font-medium">Role Name</label>
                                    <input type="text" v-model="form.role"
                                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        placeholder="Role in Caps" required>
                                </div>
                                <div class="text-xs text-red-600 mt-1" v-if="form.errors.role">{{ form.errors.role }}
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <span class="mt-1 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto ml-2">
                                <button type="button"
                                    class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                                    @click="createRole()" :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing">
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
        Activities: Object,
        success: String,
        filters: Object,
        CreatedRoles: Object,
    },
    data() {
        return {
            search: this.$props.filters.search,
            isOpen: false,
            isExcel: false,
            isRole: false,
            form: this.$inertia.form({
                role: null,
                file: '',
            }),
        }
    },
    methods: {
        searchUser() {
            this.$inertia.get('/manage/activity/roles', { search: this.search, }, { preserveState: true, replace: true })
        },
        openModalExcel() {
            this.isOpen = true;
            this.isRole = false;
            this.isExcel = true;
        },
        openModalRole() {
            this.isOpen = true;
            this.isExcel = false;
            this.isRole = true;
        },
        closeModal() {
            this.isOpen = false;
            this.reset();
        },
        createRole() {
            this.form.post('/create-role', {
                onSuccess: () => this.form.role = "",
                onSuccess: () => this.closeModal(),
            });
        },
        destroyRole(id) {
            if (confirm("Are you sure?")) {
                this.form.delete(`/destroy-role/${id}`);
            }
        },
        uploadFile() {
            this.form.post('/upload/activities', {
                onSuccess: () => this.form.file = "",
                onSuccess: () => this.closeModal(),
            });
        }
    }
}
</script>