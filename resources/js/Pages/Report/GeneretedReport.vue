

<template>

    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">
                                Dashboard
                            </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Home</li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
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
                                                class="p-2 mb-4 text-sm text-blue-700 bg-blue-100 rounded-lg dark:bg-blue-200 dark:text-blue-800"
                                                role="alert">
                                                {{ success }}
                                            </div>

                                            <div class="border-b px-4 py-3 flex justify-between">
                                                <h4 class="card-title">{{ ParentActivity.parent_title }}</h4>
                                                <button @click.prevent="ExcelExport()"
                                                    class="btn  btn-success mr-1 cursor-pointer">Export</button>
                                                <!-- <select v-model="tree" @change="search()"
                                                    class="form-control text-sm w-64">
                                                    <option value="">-- Filter by Tree --</option>
                                                    <option v-for="tree in Trees" :key="tree.id" :value="tree.id">{{
                                                        tree.tree_number
                                                    }}</option>
                                                </select> -->

                                                <h3 class="card-title">Job Card Review</h3>
                                                <!-- <p>Site: {{ Jobcard.site }}</p>
                                                <p>Project Name: {{ Jobcard.project_name }}</p>
                                                <p> Card No:{{ Jobcard.job_card_number }}</p> -->

                                            </div>

                                            
                                            <div class="card-body">
                                                <div v-for="activity in ParentActivity.childs" :key="activity.id"
                                                    class="block p-6 bg-white border border-gray-200 rounded-lg shadow mt-2">
                                                    <div>
                                                        {{ activity.child_title }}
                                                        <span v-if="activity.timelines.length" class="text-xs mt-1">
    <span class="text-blue-500">Start Date: </span>
    <span class=" text-green-500">{{ format_date(activity.timelines[0].start_date) }}</span> 
    <span class="text-blue-500"> End Date: </span>
    <span class="text-green-500">{{ format_date(activity.timelines[0].updated_at) }}</span>
</span>
                                                        <span v-else class="text-xs mt-1 text-red-500">
                                                            This activity has not been done yet
                                                        </span>
                                                    </div>

                                                    <div class="mt-1 px-3 py-2" v-if="activity.stocks.length">
                                                        <div class="table-responsive">
                                                            <table class="table table-hover text-nowrap mt-6">
                                                                <thead>
                                                                    <tr>
                                                                        <th>ID</th>
                                                                        <th>Tree Number</th>
                                                                         <th>Quantity Issued (Kgs)</th>
                                                                       <th>Bad(Kgs)</th>
                                                                        <!-- <th>Nuts (Kgs)</th> -->
                                                                        <!--to be retuned after the meeting-->
                                                                         <th>Means of Transport</th> 
                                                                        <th>starting Time</th> 
                                                                         <th>Ending Time</th> 
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr v-for="(stock, index) in activity.stocks"
                                                                        :key="index">
                                                                        <td>{{ index + 1 }}</td>
                                                                        <td>{{ stock.fruit.tree.tree_number }}</td>
                                                                        <td>
                                                                             {{ stock.quantity }}<br>
                                                                             
                                                                        </td>
                                                                        <td>
                                                                            {{ stock.damage_seed }}
                                                                          
                                                                        </td>
                                                                        
                                                                        
                                                                             <!-- transport -->
                                                                        <td>
                                                                            {{ stock.transport }} <br>- {{ stock.description }}
                                                                             <!--{{ stock.truck.truck_number }} - {{ stock.truck.description }} -->
                                                                        </td>
                                                                          <!-- time aspect -->
                                                                        <td>
                                                                            <!-- {{ stock.quantity }} -->
                                                                            <!--to be retuned after the meeting-->
                                                                             {{ format_date (activity.timelines[0].updated_at) }} 
                                                                        </td>
                                                                        <td>
                                                                            <!-- {{ stock.damage_seed }} -->
                                                                            <!--to be retuned after the meeting-->
                                                                             {{ format_date (activity.timelines[0].created_at) }} 
                                                                        </td>                                                                        
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div class="mt-1 px-3 py-2" v-if="activity.bed_preparation.length">
                                                        <div class="table-responsive">
                                                            <table class="table table-hover text-nowrap mt-6">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No</th>
                                                                        <th>Name/Tree/Seed Bed Number</th>
                                                                        <th>Quantity</th>
                                                                        <th>UOM</th>
                                                                        <th>Area</th>
                                                                        <!--  -->
                                                                        <!--<th>Seed Bed Number</th>-->
                                                                        <th>Tree Quantity</th>
                                                                        <!--  -->
                                                                        <th>Starting time</th>
                                                                        <th>clossing time</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr v-for="(comp, index) in activity.bed_preparation"
                                                                        :key="index">
                                                                        <td>{{ index + 1 }}</td>
                                                                        <!-- <td>{{ comp.tree.tree_number }}</td> -->
                                                                        <td>{{ comp.name }}</td>
                                                                        <td>{{ comp.quantity }}</td>
                                                                        <td>{{ comp.uom }}</td>
                                                                        <td>{{ comp.area_amount }}</td>
                                                                        <!-- 3 -->
                                                                        <!--<td>{{ comp.seed_bed_name }}</td>-->
                                                                        <td>{{ comp.tree_number_uom }}</td>
                                                                        <!-- <td>{{ comp.tree_number }}</td> -->
                                                                        <!-- 3 -->
                                                                        <td>{{ format_date (comp.created_at )}}</td>
                                                                        <td>{{ format_date (comp.updated_at) }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div class="flex justify-center" v-if="activity.timelines.length">
                                                        <div class="block bg-white text-center">

                                                            <div class="p-6">
                                                                <p class="text-gray-700 text-xs mb-2"> All Documents</p>
                                                                <!-- <p class="text-gray-400">Email: BUHBUHBUH<br>Meeting Minutes: BUHBUHBUH<br>Work Plans: BUHBUHBUH<br>Budgets: BUHBUHBUH<br></p> -->

                                                                <p class="text-gray-400">{{ activity.timelines[0].sign_time }} </p>

                                                                <div v-for="$record in activity.record"
                                                                    :key="$record.id">
                                                                    <div v-if="activity.id == $record.child_activity_id"
                                                                        class="flex justify-between items-center space-x-2">
                                                                        <label class="mt-2.5 text-xs font-bold"
                                                                            v-html="$record.record"></label>
                                                                        <p class="text-gray-400"
                                                                            v-html="collectRecords.record.id"></p>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="p-6">
                                                                <p class="text-gray-700 text-xs mb-2">
                                                                    Persons who signed
                                                                </p>
                                                                <div v-for="$signature in activity.signatures"
                                                                    :key="$signature.id">
                                                                    <div v-if="activity.id == $signature.child_activity_id"
                                                                        class="flex justify-between items-center space-x-2">
                                                                        <label class="mt-2.5 text-xs font-bold"
                                                                            v-html="$signature.role.role"></label>
                                                                        <p class="text-gray-400"
                                                                            v-html="$signature.user.name"></p> 
                                                                            <p class="text-xs mt-1 text-green-500">
                                                                            {{ format_date(activity.timelines[0].updated_at) }}
                                                                                <!-- {{ activity.timelines[0].sign_time }} -->
                                                                                </p>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                            <!-- <Pivot toolbar :report="report" /> -->
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
import { Head } from '@inertiajs/inertia-vue3';
import { Inertia } from "@inertiajs/inertia";
//import Pivot from "vue-flexmonster/vue3";
// import "flexmonster/flexmonster.css";
// import Pivot from '@/Components/Pivot.vue';
// import 'webdatarocks/webdatarocks.css';

export default {
    components: { BreezeAuthenticatedLayout, Head },
    props: {
        success: String,
        ParentActivity: Object,
        Trees: Object,
        Tree: String,
        JobCard: Object,
    },
    data() {
        return {
            tree: this.$props.Tree,
        }
    },
    methods: {
        search() {
            Inertia.get(route("view.report",
                { id: this.$props.ParentActivity.id, item: this.$props.JobCard, Tree: this.tree },
                { preserveState: true, replace: true }));
        },
        ExcelExport() {
            Inertia.get(route("excel.export",
                { id: this.$props.ParentActivity.id, item: this.$props.JobCard, Tree: this.tree },
                { preserveState: true, replace: true }));
        },

        format_date(value) {
            if (value) {
                return moment(String(value)).format('Y-m-d || H:mm:s')
            }
        },

    }
}
</script>