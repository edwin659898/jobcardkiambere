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
                                                    <div class="col-sm-12 pt-8 ">
                                                        <div class="form-group">
                                                            <label>{{ $page.props.ActivityTitle }} Start
                                                                Date:</label>
                                                            <Datepicker v-model="form.start_date" position="left"
                                                                altPosition></Datepicker>
                                                            <p class="text-xs text-red-600 mt-2"
                                                                v-if="form.errors.start_date">
                                                                {{ form.errors.start_date }}
                                                            </p>
                                                        </div>

                                                        <div class="form-group flex items-center justify-between space-x-2">
                                                            
                                                            <div class="w-full">
                                                                <select v-model="form.name" required
                                                                    class="w-full py-1 text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                                                    <option v-for="(name, index) in  BedNumbers" :key="index"
                                                                        :value="name">{{ name }}</option>
                                                                </select>
                                                                <p class="text-xs text-red-600 mt-2"
                                                                    v-if="form.errors.name">
                                                                    {{ form.errors.name }}
                                                                </p>
                                                            </div>

                                                        </div>

                                                        <div class="flex justify-end">
                                                            <button :class="{ 'opacity-25': form.processing }"
                                                                :disabled="form.processing"
                                                                class="inline-flex justify-center rounded-md border border-transparent px-3 py-1 bg-blue-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                                                Save
                                                            </button>
                                                        </div>

                                                        <div class="table-responsive">
                                                            <table class="table table-hover text-nowrap mt-6">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No</th>
                                                                        <th>Seed Bed Number</th>
                                                                        <th>Opening Time</th>
                                                                        <th>Closing Time</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr v-for="(comp, index) in Jobcard.bed_prep"
                                                                        :key="index">
                                                                        <td>{{ index + 1 }}</td>
                                                                        <td>{{ comp.name }}</td>
                                                                        <td>{{ format_date(comp.created_at) }}</td>
                                                                        <td><p v-if="comp.created_at != comp.updated_at">{{ format_date(comp.updated_at) }}</p></td>
                                                                        <td>
                                                                            <p v-if="comp.created_at === comp.updated_at">
                                                                                <i @click="close(comp.id)"
                                                                                class="fas fa-save cursor-pointer text-blue-500 hover:text-blue-700"></i>
                                                                            </p>
                                                                            
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
                                                                            Persons to sign
                                                                        </p>
                                                                        <div v-for="$role in Jobcard.childactivity.roles"
                                                                            :key="$role.id"
                                                                            class="flex items-center space-x-1">
                                                                            <p class="mt-2 text-sm font-bold">{{
                                                                                $role.role }}</p>


                                                                                

                                                                            <Datepicker v-model="form.sign_time" position="left" ></Datepicker>
                                                            <p class="text-xs text-red-600 mt-2" v-if="form.errors.sign_time">
                                                                {{ form.errors.sign_time }}
                                                            </p>
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
import Record from '@/Components/Record.vue'
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
export default {
    components: { BreezeAuthenticatedLayout, Head, Link, Datepicker, Record },
    props: {
        Jobcard: Object,
        success: String,
        BeginDate: String,
        BedNumbers: Object,
    },
    data() {
        return {
            form: this.$inertia.form({
                start_date: this.$props.BeginDate,
                name: '',
            }),
        }
    },
    methods: {
        update(id) {
            this.form.patch(`/seed-propergation/regulate-air-and-moisture/${id}`,
                {
                    onSuccess: () => {
                        this.form.name = '';
                    },
                    preserveScroll: true
                });
        },
        close(id) {
            this.form.patch(`/seed-propergation/${id}/close-air-and-moisture-regulation`,
                {
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
                return moment(String(value)).format('DD-MM-YYYY, HH:mm')
            }
        },
    }
}
</script>