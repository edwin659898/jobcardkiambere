<template>

    <Head title="Operational Planning" />

    <BreezeAuthenticatedLayout>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">
                                Job Card for Mukau Production
                            </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Home</li>
                                <li class="breadcrumb-item active">job-card
                                </li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid text-sm">
                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-12 connectedSortable">
                            <!-- start your code here -->
                            <div class="py-6">
                                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                        <div class="p-4 bg-white border-b border-gray-200">

                                            <div class="card-header flex justify-between">
                                                <h3 class="card-title">Job Card Review</h3>
                                                <p>Site: {{ Jobcard.site }}</p>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                <div v-if="success"
                                                    class="p-2 mb-1 text-sm text-blue-700 bg-blue-100 rounded-lg"
                                                    role="alert">
                                                    {{ success }}
                                                </div>
                                                <form @submit.prevent="update(Jobcard.id)">
                                                    <div class="col-sm-12 pt-8 ">
                                                        <div class="form-group">
                                                            <label>{{ $page.props.ActivityTitle }}</label>
                                                            <Datepicker v-model="form.start_date" position="left"
                                                                altPosition></Datepicker>
                                                            <p class="text-xs text-red-600 mt-2"
                                                                v-if="form.errors.start_date">
                                                                {{ form.errors.start_date }}
                                                            </p>
                                                        </div>

                                                        <div
                                                            class="form-group flex items-center justify-between space-x-2">
                                                            <div class="w-full">
                                                                <VueMultiselect v-model="form.treeNumber" track-by="id" :options="Trees" label="tree_number"
                                                                    :searchable="true" />
                                                                <p class="text-xs text-red-600 mt-2"
                                                                    v-if="form.errors.treeNumber">
                                                                    {{ form.errors.treeNumber }}
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div
                                                            class="form-group flex items-center justify-between space-x-2">
                                                           
                                                            <div class="w-full">
                                                                <select v-model="form.uom" required
                                                                    class="w-full py-1 text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                                                    <option v-for="(unit, index) in  $page.props.uom" :key="index" :value="unit">{{ unit}}</option>
                                                                </select>
                                                                <p class="text-xs text-red-600 mt-2"
                                                                    v-if="form.errors.uom">
                                                                    {{ form.errors.uom }}
                                                                </p>
                                                            </div>
                                                            <div class="w-full">
                                                                <input type="number" v-model="form.quantity"  step=".01"
                                                                    placeholder="quantity" required
                                                                    class="w-full py-1 text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                                                <p class="text-xs text-red-600 mt-2"
                                                                    v-if="form.errors.quantity">
                                                                    {{ form.errors.quantity }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="flex justify-end">
                                                            <button :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                                                                class="inline-flex justify-center rounded-md border border-transparent px-3 py-1 bg-blue-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                                                Save
                                                            </button>
                                                        </div>

                                                        <div class="table-responsive">
                                                            <table class="table table-hover text-nowrap mt-6">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No</th>
                                                                        <th>Tree Number</th>
                                                                        <th>Quantity</th>
                                                                        <th>UOM</th>
                                                                        <th>Date</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr v-for="(comp, index) in Jobcard.bed_prep"
                                                                        :key="index">
                                                                        <td>{{ index + 1 }}</td>
                                                                        <td>{{ comp.tree.tree_number }}</td>
                                                                        <td>{{ comp.quantity }}</td>
                                                                        <td>{{ comp.uom }}</td>
                                                                        <td>
                                                                           {{ format_date(comp.created_at) }}
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <div class="flex flex-col justify-between pt-12">

                                                            <div class="flex justify-center">
                                                                <div class="block bg-white max-w-sm text-center">
                                                                    <div class="py-2 px-6 border-b border-gray-300">
                                                                        Signature
                                                                    </div>
                                                                    <div class="p-6">
                                                                        <p class="text-gray-700 text-xs mb-4">
                                                                            Activity Owner
                                                                        </p>
                                                                        <div v-for="$role in Jobcard.childactivity.roles"
                                                                            :key="$role.id"
                                                                            class="flex items-center space-x-1">
                                                                            <p class="mt-2 text-sm font-bold">{{
                                                                            $role.role }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="flex justify-end mt-4">
                                                            <button @click.prevent="complete(Jobcard.id)"
                                                                class="inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">Sign
                                                                and Save</button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                            <!-- /.card-body -->
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

    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { Inertia } from "@inertiajs/inertia";
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import VueMultiselect from 'vue-multiselect';

export default {
    components: { BreezeAuthenticatedLayout, Head, Link, Datepicker, VueMultiselect },
    props: {
        Jobcard: Object,
        success: String,
        BeginDate: String,
        Trees: Object,
        BedNumbers: Object,
    },
    data() {
        return {
            form: this.$inertia.form({
                start_date: this.$props.BeginDate,
                uom: '',
                treeNumber: '',
                quantity: '',
            }),
        }
    },
    methods: {
        update(id) {
            this.form.patch(`/seed-propergation/seed-sowing/${id}`,
                {
                    onSuccess: () => {
                        this.form.uom = ''
                        this.form.quantity = ''
                        this.form.treeNumber = ''
                    },
                    preserveScroll: true
                });
        },
        complete(id) {
            Inertia.get(route("complete.labelling", id));
        },
        destroy(id) {
            if (confirm("Are you sure you want to remove")) {
                Inertia.delete(route("destroy.compartment", id));
            }
        },
        format_date(value) {
            if (value) {
                return moment(String(value)).format('DD-MM-YYYY')
            }
        },
    }
}
</script>