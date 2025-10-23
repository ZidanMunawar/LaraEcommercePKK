@extends('admin.layouts.mainLayout')
@section('title', 'Tags')

@section('content')
    <!--start breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Master Data</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0 align-items-center">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><ion-icon
                                name="home-outline"></ion-icon></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tags</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTagModal">Add
                Tag</button>
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

    <!-- Tags Table -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <h5 class="mb-0">Tags</h5>
                <form class="ms-auto position-relative">
                    <div class="position-absolute top-50 translate-middle-y search-icon px-3"><ion-icon
                            name="search-sharp"></ion-icon></div>
                    <input class="form-control ps-5" type="text" placeholder="Search Tags">
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
                        @foreach ($tags as $tag)
                            <tr>
                                <td>{{ $tag->id }}</td>
                                <td>{{ $tag->name }}</td>
                                <td>{{ $tag->created_at }}</td>
                                <td>{{ $tag->updated_at }}</td>
                                <td>
                                    <div class="table-actions d-flex align-items-center gap-2 fs-3">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editTagModal{{ $tag->id }}"><ion-icon
                                                name="pencil"></ion-icon>Edit</button>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteTagModal{{ $tag->id }}"><ion-icon
                                                name="trash"></ion-icon>Delete</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Add Tag -->
    @include('admin.modals.master.tags.add')

    <!-- Modal Edit Tag -->
    @foreach ($tags as $tag)
        @include('admin.modals.master.tags.edit', ['tag' => $tag])
    @endforeach

    <!-- Modal Delete Tag -->
    @foreach ($tags as $tag)
        @include('admin.modals.master.tags.delete', ['tag' => $tag])
    @endforeach
@endsection
