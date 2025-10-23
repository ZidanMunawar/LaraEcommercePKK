@extends('admin.layouts.mainLayout')
@section('title', 'Audiences')

@section('content')
    <!--start breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Master Data</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0 align-items-center">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><ion-icon
                                name="home-outline"></ion-icon></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Audiences</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAudienceModal">Add
                Audience</button>
        </div>
    </div>
    <!--end breadcrumb-->

    <!-- Display Alerts -->
    @if (session('success'))
        <div class="alert alert-dismissible fade show py-2 bg-success">
            <div class="d-flex align-items-center">
                <div class="fs-3 text-white"><ion-icon name="checkmark-circle-sharp"></ion-icon></div>
                <div class="ms-3">
                    <div class="text-white">{{ session('success') }}</div>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-dismissible fade show py-2 bg-danger">
            <div class="d-flex align-items-center">
                <div class="fs-3 text-white"><ion-icon name="close-circle-sharp"></ion-icon></div>
                <div class="ms-3">
                    <div class="text-white">{{ session('error') }}</div>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Card with Table -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <h5 class="mb-0">Audiences</h5>
                <form class="ms-auto position-relative">
                    <div class="position-absolute top-50 translate-middle-y search-icon px-3"><ion-icon
                            name="search-sharp"></ion-icon></div>
                    <input class="form-control ps-5" type="text" placeholder="search">
                </form>
            </div>
            <div class="table-responsive mt-3">
                <table class="table align-middle">
                    <thead class="table-secondary">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($audiences as $audience)
                            <tr>
                                <td>{{ $audience->id }}</td>
                                <td>{{ $audience->name }}</td>
                                <td>{{ $audience->created_at }}</td>
                                <td>{{ $audience->updated_at }}</td>
                                <td>
                                    <div class="table-actions d-flex align-items-center gap-2 fs-3">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $audience->id }}"><ion-icon
                                                name="pencil"></ion-icon>Edit</button>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $audience->id }}"><ion-icon
                                                name="trash"></ion-icon>Hapus</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Add Audience -->
    @include('admin.modals.master.audiences.add')

    <!-- Modal Edit Audience -->
    @foreach ($audiences as $audience)
        @include('admin.modals.master.audiences.edit', ['audience' => $audience])
    @endforeach

    <!-- Modal Delete Audience -->
    @foreach ($audiences as $audience)
        @include('admin.modals.master.audiences.delete', ['audience' => $audience])
    @endforeach
@endsection
