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
                                                <div class="col-sm-12 pt-8 ">
                                                    <form @submit.prevent="update()">

                                                        <div class="form-group">
                                                            <label>{{ $page.props.ActivityTitle }} Start
                                                                Date:</label>
                                                            <Datepicker v-model="start_date" position="left"
                                                                altPosition></Datepicker>
                                                        </div>
                                                        <div class="flex flex-col rounded-md shadow-lg px-3 py-2 pt-3">

                                                            <div v-if="SelectedOne"
                                                                class="flex items-center justify-between space-x-2">
                                                                <input type="number"
                                                                    class="w-full py-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                                                    v-model="form.quantity"  step=".01" placeholder="Quantity Measured">
                                                               <button :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                                                                    class="inline-flex justify-center rounded-md border border-transparent px-3 py-1 bg-blue-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                                                    Save
                                                                </button>
                                                            </div>

                                                            <p class="text-xs text-red-600 mt-2"
                                                                v-if="form.errors.quantity">{{ form.errors.quantity
                                                                }}
                                                            </p>
                                                            <p class="text-xs text-red-600 mt-2"
                                                                v-if="form.errors.truck_number">{{
                                                                form.errors.truck_number
                                                                }}
                                                            </p>

                                                            <div class="table-responsive">
                                                                <table class="table table-hover text-nowrap mt-6">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>No</th>
                                                                            <th>Tree Number</th>
                                                                            <th>Kg Measured</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr v-for="fruit, index in Jobcard.fruits"
                                                                            :key="index">
                                                                            <td>{{ index + 1 }}</td>
                                                                            <td>{{ fruit.tree.tree_number }}</td>
                                                                            <td>
                                                                                <ul v-for="(stock,index) in fruit.stocks" :key="index">
                                                                                    <li class="flex justify-between">{{ stock.quantity }} </li>
                                                                                    <li>{{ format_date(stock.created_at) }}</li>
                                                                                </ul>
                                                                            </td>
                                                                            <td>
                                                                                <i @click="selected(fruit.id)"
                                                                                    class="fas fa-edit cursor-pointer text-green-500 hover:text-green-800"></i>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>


                                                        </div>
                                                    </form>


                                                    <div class="flex justify-center pt-12">
                                                        <div class="block bg-white max-w-sm text-center">
                                                            <div class="py-2 px-6 border-b border-gray-300">
                                                                Signature
                                                            </div>
                                                            <p class="text-xs text-red-600 mt-2"
                                                                v-if="errors.signatures">{{ errors.signatures }}</p>
                                                            <div class="p-6">
                                                                <p class="text-gray-700 text-xs mb-4">
                                                                    Sign to confirm below that you approve
                                                                    document
                                                                </p>
                                                                <div v-for="$role in Jobcard.childactivity.roles"
                                                                    :key="$role.id" class="flex items-center space-x-1">
                                                                    <input type="checkbox" v-model="sign.signatures"
                                                                        :value="$role.id"
                                                                        class="text-green-600 rounded-md focus:ring-0">
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
import axios from 'axios';
export default {
    components: { BreezeAuthenticatedLayout, Head, Link, Datepicker, Record },
    props: {
        Jobcard: Object,
        success: String,
        BeginDate: String,
        Trucks: Object,
        Signed: Object,
        errors: Object,
    },
    data() {
        return {
            form: this.$inertia.form({
                quantity: null,
                SelectedId: null,
            }),
            SelectedOne: false,
            sign: {
             signatures: this.$props.Signed,
            },
            start_date: this.$props.BeginDate,
        }
    },
    methods: {
        update() {
            this.form.patch(`/Fruit-storage/store/after-disinfection/${this.form.SelectedId}`, {
                onSuccess: () => this.SelectedOne = false,
                preserveScroll: true
            });
        },
        complete(id) {
            Inertia.patch(`/Fruit-storage/sign/quality-check/${id}`,this.sign,{
                preserveScroll: true
            });
        },
        destroy(id) {
            this.form.delete(`/destroy/tree-number/${id}`, { 
                onSuccess: () => this.SelectedOne = false,
                preserveScroll: true 
            });
        },
        selected(id) {
            this.form.quantity = null;
            this.SelectedOne = true;
            this.form.SelectedId = id;
        },
        format_date(value) {
            if (value) {
                return moment(String(value)).format('DD-MM-YYYY')
            }
        },
    }
}
</script>