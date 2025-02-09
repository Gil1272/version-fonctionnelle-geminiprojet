@extends('layout.template')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <div class="d-flex align-items-center align-self-start">
                                        <h3 class="mb-0">{{ $totalProjects }}</h3>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="icon icon-box-success ">
                                        <span class="mdi mdi-chart-line icon-item"></span>
                                    </div>
                                </div>
                            </div>
                            <h6 class="text-muted font-weight-normal">Total Projets</h6>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <div class="d-flex align-items-center align-self-start">
                                        <h3 class="mb-0">{{ $ongoingProjects }}</h3>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="icon icon-box-success">
                                        <span class="mdi mdi-clock icon-item"></span>
                                    </div>
                                </div>
                            </div>
                            <h6 class="text-muted font-weight-normal">Projets en cours</h6>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <div class="d-flex align-items-center align-self-start">
                                        <h3 class="mb-0">{{ $completedProjects }}</h3>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="icon icon-box-danger">
                                        <span class="mdi mdi-check-circle icon-item"></span>
                                    </div>
                                </div>
                            </div>
                            <h6 class="text-muted font-weight-normal">Projets terminés</h6>
                        </div>
                    </div>
                </div>


            </div>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-row justify-content-between">
                                <h4 class="card-title mb-1">Projets en cours</h4>
                                <p class="text-muted mb-1">Statut de vos données</p>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="preview-list">
                                        @foreach ($openProjects as $project)
                                            <div class="preview-item border-bottom">
                                                <div class="preview-thumbnail">
                                                    <div class="preview-icon bg-primary">
                                                        <i class="mdi mdi-file-document"></i>
                                                    </div>
                                                </div>
                                                <div class="preview-item-content d-sm-flex flex-grow">
                                                    <div class="flex-grow">
                                                        <h6 class="preview-subject">{{ $project->name }}</h6>
                                                        <p class="text-muted mb-0">{{ $project->description }}</p>
                                                    </div>
                                                    <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                                        <p class="text-muted">{{ $project->updated_at->diffForHumans() }}
                                                        </p>
                                                        <p class="text-muted mb-0">{{ $project->taches->count() }} tâches,
                                                        </p> <!-- $project->issues->count()  problèmes-->
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- content-wrapper ends -->
        <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2025 <a
                        href="http://gemini-company.com" target="_blank">Gemini-SGP</a>.
                    All rights
                    reserved.</span>
                <span class="text-muted float-none float-sm-end d-block mt-1 mt-sm-0 text-center"> <span
                        class="text-muted float-none float-sm-end d-block mt-1 mt-sm-0 text-center">Hand-crafted
                        & made with <i class="mdi mdi-heart text-danger"></i></span> <i
                        class="mdi mdi-heart text-danger"></i></span>
            </div>
        </footer>
    </div>
@endsection
