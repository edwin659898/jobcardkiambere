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
                                Reports
                            </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Home</li>
                                <li class="breadcrumb-item active">Reports</li>
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
                                            <div class="card-header">
                                                <h4 class="card-title">Reports </h4>
                                            </div>
                                            <div class="card-body">
                                                <!-- the events -->
                                                <div id="external-events" v-for="item in items" :key="item.id">
                                                    <div @click="toggleAccordion(item.id)"
                                                        class="external-event mt-2 text-sm text-white cursor-pointer bg-lime-500">
                                                        {{ item.job_card_number }} - {{ item.site }}
                                                    </div>
                                                    <transition name="fade" v-show="item.open">
                                                        <div class="w-full px-5 py-3">
                                                            <div>
                                                                <label>Parent Activity</label>
                                                                <select v-model="parent_id"
                                                                    class="w-full py-1 text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                                                    <option value="">-- Select Main Activity --</option>
                                                                    <option v-for="MainActivity in ParentActivity"
                                                                        :key="MainActivity.id" :value="MainActivity.id">
                                                                        {{ MainActivity.parent_title }}</option>
                                                                </select>
                                                            </div>
                                                            <div class="mt-2 flex justify-end">
                                                                <button @click="getReport(item)"
                                                                    class="btn btn-sm btn-success">Get
                                                                    Report</button>
                                                            </div>
                                                        </div>
                                                    </transition>
                                                </div>

                                            </div>


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

<script >
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { Inertia } from "@inertiajs/inertia";

export default {
    components: { BreezeAuthenticatedLayout, Head },
    props: {
        success: String,
        Jobcards: Object,
        ParentActivity: Object,
        ChildActivity: Object,
    },
    data() {
        return {
            items: this.$props.Jobcards,
            parent_id: '',
        }
    },
    methods: {
        toggleAccordion(id) {
            this.items.forEach(item => {
                if (item.id === id) {
                    item.open = !item.open;
                } else {
                    item.open = false;
                    this.parent_id = '';
                }
            });
        },
        getReport(item) {
            Inertia.get(route("view.report", { id: this.parent_id, item: item }));
        },
    },
    created() {
        this.items.forEach(item => {
            item.open = false;
        });
    }
}
</script>
<style>
.fade-enter-active,
.fade-leave-active {
    transition: all 1s;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}
</style>


