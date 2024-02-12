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
                                                <p>Card No: {{ Jobcard.job_card_number }}</p>
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

                                                    <div class="form-group">
                                                            <label>Departure Time:</label>
                                                            <Datepicker class="w-full" v-model="form.departure_date"
                                                                position="left" altPosition></Datepicker>
                                                            <p class="text-xs text-red-600 mt-2"
                                                                v-if="form.errors.departure_date">
                                                                {{ form.errors.departure_date }}
                                                            </p>
                                                        </div>

                                                    <table class="table table-hover text-nowrap mt-6">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Tree Number</th>
                                                                <th>Quantity</th>
                                                                <th>Transport Media</th>
                                                                <th>Departure Time</th>
                                                                <th>Check</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="(stock, index) in Jobcard.stocks" :key="index">
                                                                <td>{{ index + 1 }}</td>
                                                                <td>{{ stock.fruit.tree.tree_number }}</td>
                                                                <td>{{ stock.quantity }}</td>
                                                                <td>{{ stock.truck.truck_number }} - {{ stock.truck.description }}</td>
                                                                <td><p >{{ format_date(stock.departure_time) }}</p></td>
                                                                <td><input v-if="stock.departure_time == null" type="checkbox" v-model="form.selectedTrucks" :value="stock.id" class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                    <div class="col-sm-12 pt-8 ">

                                                        <div class="flex justify-end">
                                                            <button :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                                                                class="inline-flex justify-center rounded-md border border-transparent px-3 py-1 bg-blue-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                                                Save
                                                            </button>
                                                        </div>

                                                    </div>
                                                </form>
                                                                                                    <div class="flex justify-center pt-12">
                                                        <div class="block bg-white max-w-sm text-center">
                                                            <div class="py-2 px-6 border-b border-gray-300">
                                                                Signature
                                                            </div>
                                                            <div class="p-6">
                                                                <p class="text-gray-700 text-xs mb-4">
                                                                    Signature Required at this stage
                                                                </p>
                                                                <div v-for="$role in Jobcard.childactivity.roles"
                                                                    :key="$role.id" class="flex justify-center items-center space-x-1">
                                                                    <label class="mt-2 text-sm font-bold">{{
                                                                        $role.role
                                                                        }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex justify-end mt-4">
                                                        <button @click="complete(Jobcard.id)"
                                                            class="inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                                            Sign
                                                        </button>
                                                    </div>
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
import Record from '@/Components/Record.vue'
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
export default {
    components: { BreezeAuthenticatedLayout, Head, Link, Datepicker, Record },
    props: {
        Jobcard: Object,
        Trucks: Object,
        success: String,
    },
    data() {
        return {
            form: this.$inertia.form({
                departure_date: '',
                selectedTrucks: [],
                jobcard_id: this.$props.Jobcard.id,
            }),
        }
    },
    methods: {
        update(id) {
            this.form.patch(`/update/truck/departure-time/${id}`,
                {
                    onSuccess: () => this.form.reset(),
                });
        },
        complete(id) {
            Inertia.get(route("complete.labelling", id));
        },
        format_date(value) {
            if (value) {
                return moment(String(value)).format('DD-MM-YYYY HH:mm')
            }
        },
    }
}
</script>