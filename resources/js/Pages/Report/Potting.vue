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
                                                <select v-model="tree" @change="search()"
                                                    class="form-control text-sm w-64">
                                                    <option value="">-- Filter by Tree --</option>
                                                    <option v-for="tree in Trees" :key="tree.id" :value="tree.id">{{
                                                        tree.tree_number
                                                    }}</option>
                                                </select>
                                            </div>
                                            <div class="card-body">
                                                <div v-for="activity in ParentActivity.childs" :key="activity.id"
                                                    class="block p-6 bg-white border border-gray-200 rounded-lg shadow mt-2">
                                                    <div>
                                                        {{ activity.child_title }}
                                                        <span v-if="activity.timelines.length"
                                                            class="text-xs mt-1 text-blue-500">
                                                            Start Date: {{ activity.timelines[0].start_date }}
                                                            End Date: {{ activity.timelines[0].end_date }}
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
                                                                        <th>Quantity (Kg)</th>
                                                                        <th>Start time</th>
                                                                        <th>End time</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr v-for="(stock, index) in activity.stocks"
                                                                        :key="index">
                                                                        <td>{{ index + 1 }}</td>
                                                                        <td>{{ stock.fruit.tree.tree_number }}</td>
                                                                        <td>
                                                                            {{ stock.quantity }}
                                                                        </td>
                                                                        <td>
                                                                            {{ format_date(stock.created_at) }}
                                                                        </td>
                                                                        <td>
                                                                            {{ format_date(stock.updated_at) }}
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
                                                                        <th>ID</th>
                                                                        <th>Name</th>
                                                                        <th>Quantity</th>
                                                                        <th>uom</th>
                                                                        <th>Start time</th>
                                                                        <th>End time</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr v-for="(bedPrep, index) in activity.bed_preparation"
                                                                        :key="index">
                                                                        <td>{{ index + 1 }}</td>
                                                                        <td>{{ bedPrep.name }}</td>
                                                                        <td>{{ bedPrep.quantity }}</td>
                                                                        <td>
                                                                            {{ bedPrep.uom }}
                                                                        </td>
                                                                        <td>
                                                                            {{ format_date(bedPrep.created_at) }}
                                                                        </td>
                                                                        <td>
                                                                            {{ format_date(bedPrep.updated_at) }}
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div class="flex justify-center" v-if="activity.timelines.length">
                                                        <div class="block bg-white text-center">
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
                return moment(String(value)).format('DD-MM-YYYY, HH:mm')
            }
        },
    }
}
</script>