@extends('layouts.app')
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="{{ url('/css/additionalStyles.scss') }}" />
@section('content')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="card card-container-styles">
            <div class="alert alert-danger" style="display: none" id="warning_container" role="alert">
                <span>Something went wrong!</span><br>
                <p id="error_log"></p>
            </div>

            <div class="card-body">
                <h5 class="card-title data-title">Edit User Roles</h5>
                <div class="card-text">
                    <form id='save-form'>
                        @csrf
                        <div class="form-group">
                            <label>{{ $user->name ?? '-'}}</label>
                            <select class="form-control" name="roles" multiple>
                                <option value="">Select the roles</option>
                                @foreach($roles as $key => $role)
                                        <option {{ !empty($userRoles)&& in_array($key, $userRoles) ? 'selected' : '' }}
                                        value="{{ $key}}">{{ $role }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="route" value="{{ route('updateUserRole') }}">
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <div class="update-btn">
                            <button type="submit" class="btn btn-dark send-data">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script type="text/javascript">

    $(document).ready(function() {

        $(".send-data").click(function (event) {
            event.preventDefault();

            const data = {
                roles: $('select[name=roles]').val(),
                user: $('input[name=user_id]').val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            $.ajax({
                url: $('input[name=route]').val(),
                type: 'POST',
                data: data,
                success:function(response){
                    if (response.status === 'success') {
                        $(location).attr('pathname', response.data)
                    } else {
                        // Show warning
                        let container_parent = document.getElementById('warning_container');
                        container_parent.style.display = 'block';
                        // Add content to warning
                        $.each( response.data, function( key, value ) {
                            let container = document.createElement('div');
                            container.innerHTML = value;
                            let parent = document.getElementById('error_log');
                            parent.appendChild(container);
                        });
                    }
                }
            });
        });
    });
</script>

