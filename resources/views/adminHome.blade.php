@extends('layouts.app')
<link rel="stylesheet" type="text/css" href="{{ url('/css/additionalStyles.scss') }}" />
@section('content')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="card card-container-styles">
            <div class="card-body">
                <h5 class="card-title data-title">Welcome {{ auth()->user()->name }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">
                    In this section you'll be able to edit and update your profile and add roles to staff members
                </h6>
                <div class="card-text">
                    <div class="twin-containers">
                        <div class="data-container">
                            <label class="data-title">Personal info</label>
                            <div class="mt-6">
                                <label>Name</label>
                                <span>{{ $userData->name ?? '-' }}</span>
                            </div>
                            <div class="mt-6">
                                <label>Email address</label>
                                <span>{{ $userData->email ?? '-' }}</span>
                            </div>
                            <div class="mt-6">
                                <label>Phone</label>
                                <span>{{ $userData->phone ?? '-' }}</span>
                            </div>
                            <div class="mt-6">
                                <label>Gender</label>
                                <span>{{ \App\Http\Helper\Helper::getGenderWord($userData->gender) }}</span>
                            </div>
                        </div>

                        <div class="data-container ml-5">
                            <label class="data-title">Address info</label>
                            <div class="mt-6">
                                <label>Address</label>
                                <span>{{ $userData->address ?? '-' }}</span>
                            </div>
                            <div class="mt-6">
                                <label>Postcode</label>
                                <span>{{ $userData->postcode ?? '-' }}</span>
                            </div>
                            <div class="mt-6">
                                <label>County</label>
                                <span>{{ $userData->county ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="twin-containers">
                        <div class="data-container">
                            <label class="data-title">Job info</label>
                            <div class="mt-6">
                                <label>Roles assigned</label>
                                <span>Admin</span>
                            </div>
                            <div class="mt-6">
                                <label>Job title</label>
                                <span>{{ $userData->job_title ?? '-' }}</span>
                            </div>
                            <div class="mt-6">
                                <label>Joined Job</label>
                                <span>{{ (new \Carbon\Carbon($userData->created_at))->format('Y-m-d') ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="data-container ml-5">
                            <label class="data-title">About Me</label>
                            <div class="mt-6">
                                <span>{{ $userData->about_me ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="update-btn">
                        <a href="{{ url('/edit') }}" class="btn btn-xs btn-dark mt-4">
                            Edit Profile
                        </a>
                    </div>

                    <div class="user-roles-table">
                        @if(!empty($systemUsers) && $systemUsers->count() > 0)
                            <label class="data-title">Users & Roles</label>
                            <div class="mt-6">
                                <table class="table table-dark">
                                    <thead>
                                    <tr>
                                        <th scope="col">User Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Roles</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($systemUsers as $user)
                                            <tr>
                                                <th scope="row">{{ $user->name }}</th>
                                                <th scope="row">{{ $user->email }}</th>
                                                <th scope="row">
                                                    @if(!empty($user->enabledUserRoles))
                                                        @foreach($user->enabledUserRoles as $role)
                                                            {{ $role->role->name }}
                                                        @endforeach
                                                    @else
                                                        -
                                                    @endif
                                                </th>
                                                <th scope="row">
                                                    <a href="{{ url('/editUserRole/'.$user->id) }}" class="btn btn-xs btn-light">
                                                        Edit Roles
                                                    </a>
                                                </th>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
