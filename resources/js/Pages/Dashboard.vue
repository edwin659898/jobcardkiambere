

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
                                            <div class="card-header">
                                                <div class="flex justify-between">
                                                    <h4 class="card-title">Jobcards Progress</h4>
                                                </div>
                                            </div>
                                            <div class="card-body p-0 text-sm">
                                                <table class="table table-sm">
                                                    <thead class="font-semibold">
                                                        <tr>
                                                            <th>Jobcard Name</th>
                                                            <th>Site</th>
                                                            <th>Start Date</th>
                                                            <th>Current Main Activity</th>
                                                            <th>Current Sub activity</th>
                                                            <th>Percentage</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="$card in JobCards" :key="$card.id">
                                                            <td>{{ $card.job_card_number }}</td>
                                                            <td>{{ $card.site }}</td>
                                                            <td>{{ $card.childactivity.parent.parent_title }}</td>
                                                            <td>{{ $card.childactivity.child_title }}</td>
                                                            <td>4%</td>
                                                        </tr>
                                                    </tbody>
                                                    <div v-if="JobCards == null"
                                                        class="text-xs font-serif pt-3 text-center">
                                                        No Jobcards in progress. check back soon
                                                    </div>
                                                </table>
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

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
export default {
    components: { BreezeAuthenticatedLayout, Head },
    props: {
        success: String,
        JobCards: Object,
    }
}
</script>