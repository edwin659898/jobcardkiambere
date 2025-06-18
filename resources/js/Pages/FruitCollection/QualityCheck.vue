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
                                                <p>Project Name: {{ Jobcard.project_name }}</p>
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
                                                                <!-- start -->
                                                                <div v-if="clickOne"
                                                                class="flex items-center justify-between space-x-2">
                                                                <select class="w-full py-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                                                                v-model="form.start">
                                                                    <option value="" disabled>Select an option</option>
                                                                    <option value="1">Start Time</option>
                                                                    <!-- <option value="0">Do Not Start Time</option> -->
                                                                </select>


                                                                <!-- <input type="number"
                                                                    class="w-full py-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                                                    v-model="form.start" placeholder="Enter (1) to start time or (0) not to start time"> -->
                                                                   

                                                               <button :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                                                                    class="inline-flex justify-center rounded-md border border-transparent px-3 py-1 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-orange-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                                                    Save
                                                                </button>
                                                            </div>
                                                            <!-- end start time -->
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
                                                                    v-model="form.quantityOk" placeholder="Quantity Ok">
                                                                <input type="number"
                                                                    class="w-full py-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                                                    v-model="form.quantityNotOk"
                                                                    placeholder="Quantity Not Ok"> 

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
                                                                            <th>Time Click</th>
                                                                        <th>Start </th>
                                                                            <th>Quantity</th>
                                                                        <th>End </th>
                                                                        <th>Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr v-for="(fruit, index) in Jobcard.fruits"
                                                                            :key="index">
                                                                            <td>{{ index + 1 }}</td>
                                                                            <td>{{ fruit.tree.tree_number }}</td>
                                                                            <td>
                                                                            <i @click="showStartSortingPopup(fruit.id)"
                                                                                  class="fas fa-clock cursor-pointer text-green-500 hover:text-green-800"> 
                                                                             </i>
                                                                        </td>
                                                                        <!-- start -->
                                                                        <td>
                                                                            <!-- <ol v-for="(stocktimer, index) in stockstimer" :key="index">
                                                                                        <li class="flex justify-between">
                                                                                            <p>{{ format_date(stocktimer.created_at) }}</p>
                                                                                        </li>
                                                                                    </ol> -->
                                                                                    <ol v-for="stock, index in fruit.stocks"
                                                                                :key="index">
                                                                                <li class="flex justify-between">
                                                                                    <!-- <p>{{ stock.quantity }}</p> -->
                                                                                    <p>{{ format_date(stock.created_at) }}</p>

                                                                                </li>
                                                                            </ol>
                                                                            </td>
                                                                            <td>
                                                                                <ul class="flex justify-between" v-for="(stock,index) in fruit.stocks" :key="index">
                                                                                    <p><li> Ok: {{ stock.quantity }}</li></p> 
                                                                                    <p><li> Not Ok: {{ stock.damage_seed }}</li></p>
                                                                                    <!-- <li>{{ format_date(stock.created_at) }}</li> -->
                                                                                </ul>
                                                                            </td>
                                                                            <!-- <td>
                                                                                <ul class="flex justify-between" v-for="(stock,index) in fruit.stocks" :key="index">
                                                                                    
                                                                                    <li>{{ format_date(stock.created_at) }}</li>
                                                                                </ul>
                                                                            </td> -->
                                                                            
                                                                            <td>
                                                                                <ul class="flex justify-between" v-for="(stock,index) in fruit.stocks" :key="index">
                                                                                    <!-- <li>Ok: {{ stock.quantity }}</li> -->
                                                                                    <!-- <li>Not Ok: {{ stock.damage_seed }}</li> -->
                                                                                    <li>{{ format_date(stock.updated_at) }}</li>
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
                                                                    Sign Required at this stage
                                                                </p>
                                                                <div v-for="$role in Jobcard.childactivity.roles"
                                                                    :key="$role.id" class="flex justify-center items-center space-x-1">
                                                                    <input type="checkbox"
                                                                              v-model="form.signature"
                                                                              :value="$role.id"
                                                                              class="text-green-600 rounded-md focus:ring-0">
                                                                    <label class="mt-2 text-sm font-bold">{{
                                                                        $role.role
                                                                        }}</label>

                                                                        <!-- <label>{{ $page.props.ActivityTitle }} Start Date:</label> -->
                                                                        <!-- position="left" altPosition (on the Datepicker bellow) -->
                                                                        <Datepicker v-model="form.sign_time" position="left" ></Datepicker>
                                                                               <p class="text-xs text-red-600 mt-2" v-if="form.errors.sign_time">
                                                                                  {{ form.errors.sign_time }}
                                                                                    </p>
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

        <!-- Start Sorting Popup Modal -->
        <div v-if="showPopup" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3 text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                        <i class="fas fa-clock text-green-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mt-2">Start Sorting?</h3>
                    <div class="mt-2 px-7 py-3">
                        <p class="text-sm text-gray-500">
                            Are you ready to start the sorting process for this item?
                        </p>
                        <p class="text-xs text-gray-400 mt-2">
                            Current time: {{ getCurrentDateTime() }}
                        </p>
                    </div>
                    <div class="items-center px-4 py-3">
                        <button 
                            @click="confirmStartSorting" 
                            :disabled="form.processing"
                            :class="{ 'opacity-25': form.processing }"
                            class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                            {{ form.processing ? 'Starting...' : 'Yes' }}
                        </button>
                        <button 
                            @click="cancelStartSorting" 
                            :disabled="form.processing"
                            class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-24 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
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
import { now } from 'lodash';
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
                quantityOk: null,
                quantityNotOk: null,
                SelectedId: null,
                end_date: '',
                start_date: null,
                start: null,
                start_time: null, 
            }),
            SelectedOne: false,
            sign: {
              signatures: this.$props.Signed,
            },
            clickOne: false,
            showPopup: false, 
            pendingFruitId: null, 
            start_date: this.$props.BeginDate,
        }
    },
    methods: {
        update() {
            this.form.patch(`/Fruit-storage/store/quality-check/${this.form.SelectedId}`, {
                onSuccess: () => {
                    this.SelectedOne = false;
                    this.clickOne = false;
                },
                preserveScroll: true
            });
        },
        complete(id) {
            Inertia.patch(`/Fruit-storage/sign/quality-check/${id}`,this.sign,{
                preserveScroll: true
            });
        },
        selected(id) {
            this.form.quantityOk = null;
            this.form.quantityNotOk = null;
            this.SelectedOne = true;
            this.form.SelectedId = id;
        },
        showStartSortingPopup(id) {
            this.pendingFruitId = id;
            this.showPopup = true;
        },
        confirmStartSorting() {
            this.form.start_time = new Date();
            this.form.start = 1; 
            this.form.SelectedId = this.pendingFruitId;
            
            this.update();
            
            this.showPopup = false;
            this.pendingFruitId = null;
        },
        cancelStartSorting() {
            this.showPopup = false;
            this.pendingFruitId = null;
        },
        getCurrentDateTime() {
            return new Date().toLocaleString();
        },
        click(id) {
            this.form.start = null;
            this.clickOne = true;
            this.form.SelectedId = id;
        },
        format_date(value) {
            if (value) {
                return moment(String(value)).format('DD-MM-YYYY || HH:mm:ss')
            }
        },
    }
}
</script>