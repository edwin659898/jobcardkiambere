<template>
    <div class="wrapper">

        <!-- Page Heading -->
        <header class="bg-white shadow" v-if="$slots.header">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <slot name="header" />
            </div>
        </header>
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" :src="$page.props.app.url" alt="AdminLTELogo" height="60" width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <i class="fa fa-user fa-fw"></i>
                        {{ $page.props.auth.user.name }}
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li>
                            <Link class="nav-link" :href="route('logout')" method="post" as="button">
                            LogOut
                            <i class="fas fa-logout"></i>
                            </Link>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img :src="$page.props.app.url" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">JobCard Kiambere</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <Link class="nav-link" :class="{ 'active': route().current() == 'Dashboard' }"
                                :href="route('Dashboard')">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                            </Link>
                        </li>

                        <li class="nav-item">
                            <Link :href="route('operation-planning')" class="nav-link"
                                :class="{ 'active': $page.url.startsWith('/operation-planning') || $page.url.startsWith('/New-Jobcard') }">
                            <i class="nav-icon fas fa-file"></i>
                            <p>
                                Operation Planning
                                <span class="right badge badge-success">1</span>
                            </p>
                            </Link>
                        </li>
                        <li class="nav-item">
                            <Link :href="route('communication')" class="nav-link"
                                :class="{ 'active': $page.url.startsWith('/communication') }">
                            <i class="nav-icon fas fa-envelope"></i>
                            <p>
                                Communication
                                <span class="right badge badge-info">2</span>
                            </p>
                            </Link>
                        </li>
                        <li class="nav-item">
                            <Link :href="route('fruit-collection')" class="nav-link"
                                :class="{ 'active': $page.url.startsWith('/Fruit-collection') }">
                            <i class="nav-icon fas fa-tree"></i>
                            <p>
                                Fruit Collection
                                <span class="right badge badge-warning">3</span>
                            </p>
                            </Link>
                        </li>
                        <li class="nav-item">
                            <Link :href="route('fruit-storage')" class="nav-link"
                                :class="{ 'active': $page.url.startsWith('/Fruit-storage') }">
                            <i class="nav-icon fas fa-store"></i>
                            <p>
                                Fruit Storage
                                <span class="right badge badge-danger">4</span>
                            </p>
                            </Link>
                        </li>
                        <li class="nav-item">
                            <Link :href="route('depulping')" class="nav-link"
                                :class="{ 'active': $page.url.startsWith('/Depulping') }">
                            <i class="nav-icon fas fa-hands"></i>
                            <p>
                                Depulping
                                <span class="right badge bg-purple-600">5</span>
                            </p>
                            </Link>
                        </li>
                        <li class="nav-item">
                            <Link :href="route('seed-extraction')" class="nav-link"
                                :class="{ 'active': $page.url.startsWith('/seed-extraction') }">
                            <i class="nav-icon fas fa-seedling"></i>
                            <p>
                                Seed Extraction
                                <span class="right badge bg-lime-500">6</span>
                            </p>
                            </Link>
                        </li>
                        <li class="nav-item">
                            <Link :href="route('seed-transportation')" class="nav-link"
                                :class="{ 'active': $page.url.startsWith('/transport-to-other-sites') }">
                            <i class="nav-icon fas fa-car"></i>
                            <p>
                                Seed Transport
                                <span class="right badge bg-indigo-500">7</span>
                            </p>
                            </Link>
                        </li>
                        <li class="nav-item">
                            <Link :href="route('bed-preparation')" class="nav-link"
                                :class="{ 'active': $page.url.startsWith('/seed-bed-preparation') }">
                            <i class="nav-icon fas fa-bed"></i>
                            <p>
                                Bed Preparation
                                <span class="right badge bg-orange-900">8</span>
                            </p>
                            </Link>
                        </li>
                        <li class="nav-item">
                            <Link :href="route('seed-propergate')" class="nav-link"
                                :class="{ 'active': $page.url.startsWith('/seed-propergation') }">
                            <i class="nav-icon fas fa-futbol"></i>
                            <p>
                                Seed Propagation
                                <span class="right badge bg-pink-500">9</span>
                            </p>
                            </Link>
                        </li>
                        <li class="nav-item">
                            <Link :href="route('potting')" class="nav-link"
                                :class="{ 'active': $page.url.startsWith('/potting') }">
                            <i class="nav-icon fas fa-futbol"></i>
                            <p>
                                Potting
                                <span class="right badge bg-blue-500">10</span>
                            </p>
                            </Link>
                        </li>
                        <li class="nav-item">
                            <Link :href="route('nurseryShed')" class="nav-link"
                                :class="{ 'active': $page.url.startsWith('/nursery-shed') }">
                            <i class="nav-icon fas fa-building"></i>
                            <p>
                                Nursery shed C
                                <span class="right badge bg-green-500">11</span>
                            </p>
                            </Link>
                        </li>
                        <li class="nav-item">
                            <Link :href="route('SeedlingBedConstruction')" class="nav-link"
                                :class="{ 'active': $page.url.startsWith('/seedling-bed-construction') }">
                            <i class="nav-icon fas fa-building"></i>
                            <p>
                                SB construction
                                <span class="right badge bg-yellow-500">12</span>
                            </p>
                            </Link>
                        </li>
                        <li class="nav-item">
                            <Link :href="route('prickingOut')" class="nav-link"
                                :class="{ 'active': $page.url.startsWith('/pricking-out') }">
                            <i class="nav-icon fas fa-futbol"></i>
                            <p>
                                Pricking Out
                                <span class="right badge bg-red-500">13</span>
                            </p>
                            </Link>
                        </li>
                        <li class="nav-item">
                            <Link :href="route('FirstHardening')" class="nav-link"
                                :class="{ 'active': $page.url.startsWith('/first-hardening') }">
                            <i class="nav-icon fas fa-seedling"></i>
                            <p>
                                First Hardening
                                <span class="right badge bg-indigo-500">14</span>
                            </p>
                            </Link>
                        </li>
                        <li class="nav-item">
                            <Link :href="route('SecondHardening')" class="nav-link"
                                :class="{ 'active': $page.url.startsWith('/second-hardening') }">
                            <i class="nav-icon fas fa-seedling"></i>
                            <p>
                                Second Hardening
                                <span class="right badge bg-lime-500">15</span>
                            </p>
                            </Link>
                        </li>
                        <li class="nav-item">
                            <Link :href="route('SeedlingSelection')" class="nav-link"
                                :class="{ 'active': $page.url.startsWith('/seedling-selection') }">
                            <i class="nav-icon fas fa-seedling"></i>
                            <p>
                                Seed Selection
                                <span class="right badge bg-orange-500">16</span>
                            </p>
                            </Link>
                        </li>
                        <li class="nav-header">Admin Area</li>
                        <li class="nav-item">
                            <Link :href="route('reports.index')" class="nav-link"
                                :class="{ 'active': $page.url.startsWith('/reports') }">
                            <i class="nav-icon fas fa-file"></i>
                            <p>
                                Reports
                                <span class="right badge bg-green-500">P</span>
                            </p>
                            </Link>
                        </li>
                        <li class="nav-item">
                            <Link :href="route('transport.medias')" class="nav-link"
                                :class="{ 'active': $page.url.startsWith('/transport-media') }">
                            <i class="nav-icon fas fa-car"></i>
                            <p>
                                Transport Media
                                <span class="right badge bg-blue-500">T</span>
                            </p>
                            </Link>
                        </li>
                        <li class="nav-header">Roles</li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" :class="{ 'active': $page.url.startsWith('/manage-*') }">
                                <i class="nav-icon fas fa-table"></i>
                                <p>
                                    Roles
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <Link :href="route('user.roles')" class="nav-link">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>
                                        Users Roles
                                        <span class="badge badge-info right">U</span>
                                    </p>
                                    </Link>
                                </li>
                                <li class="nav-item">
                                    <Link :href="route('activity.roles')" class="nav-link">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>
                                        Activity Roles
                                        <span class="badge badge-info right">A</span>
                                    </p>
                                    </Link>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <slot />
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2022 <a href="#">Better Globe Forestry LTD</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Prosperity with purpose</b>
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'

export default {
    components: { Link },
    mounted() {
        this.init();
    },
    methods: {
        init() {
            let SELECTOR_LOADER = '.preloader'
            setTimeout(() => {
                let $loader = $(SELECTOR_LOADER)
                if ($loader) {
                    $loader.css('height', 0)
                    setTimeout(() => {
                        $loader.children().hide()
                    }, 50)
                }
            }, 400)
        }
    }
}
</script>

