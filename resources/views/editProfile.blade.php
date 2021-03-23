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
                <h5 class="card-title data-title">Edit Profile Data</h5>
                <div class="card-text">
                    <form id='save-form'>
                        @csrf
                        <div class="form-group">
                            <label for="titleText">Name<span style="color: salmon">*</span></label>
                            <input type="text" value="{{ !empty($userData->name) ? $userData->name : '' }}"
                                   class="form-control" name="name" placeholder="Enter name" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" value="{{ !empty($userData->email) ?$userData->email : '' }}"
                                   class="form-control"
                                   name="email" readonly>
                            <small class="form-text text-muted">You can't edit this field.</small>
                        </div>
                        <div class="form-group">
                            <label>Gender</label>
                            <select class="form-control" name="gender">
                                <option {{ !empty($userData->gender) && $userData->gender === 'M' ? 'selected' : '' }}
                                        value="M" >Male</option>
                                <option {{ !empty($userData->gender) && $userData->gender === 'F' ? 'selected' : '' }}
                                        value="F">Female</option>
                                <option {{ !empty($userData->gender) && $userData->gender === 'O' ? 'selected' : '' }}
                                        value="O">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="titleText">Address</label>
                            <input type="text" value="{{ !empty($userData) ? $userData->address : '' }}"
                                   class="form-control" name="address" placeholder="Enter address">
                        </div>
                        <div class="form-group">
                            <label for="titleText">Postcode</label>
                            <input type="text" value="{{ !empty($userData) ? $userData->postcode : '' }}"
                                   class="form-control" name="postcode" placeholder="Enter postcode">
                        </div>
                        <div class="form-group">
                            <label for="titleText">County</label>
                            <input type="text" value="{{ !empty($userData) ? $userData->county : '' }}"
                                   class="form-control" name="county" placeholder="Enter county">
                        </div>
                        <div class="form-group">
                            <label for="titleText">Phone</label>
                            <input type="text" value="{{ !empty($userData) ? $userData->phone : '' }}"
                                   class="form-control" name="phone" placeholder="Enter phone">
                        </div>
                        <div class="form-group">
                            <label for="titleText">Job Title</label>
                            <input type="text" value="{{ !empty($userData) ? $userData->job_title : '' }}"
                                   class="form-control" name="job_title" placeholder="Enter Job Title">
                        </div>

                        <div class="form-group">
                            <label for="contentText">About me</label>
                            <textarea class="form-control" name="about_me" id="contentText"
                                      rows="10">{{ !empty($userData) ? $userData->about_me : '' }}</textarea>
                            <small id="contentHelp" class="form-text text-muted">Write something about you!</small>
                        </div>
                        <input type="hidden" name="route" value="{{ route('update') }}">
                        <button type="submit" class="btn btn-primary send-data">Submit</button>
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
                name: $('input[name=name]').val(),
                gender: $('select[name=gender]').val(),
                address: $('input[name=address]').val(),
                postcode: $('input[name=postcode]').val(),
                county: $('input[name=county]').val(),
                phone: $('input[name=phone]').val(),
                job_title: $('input[name=job_title]').val(),
                about_me: $('textarea[name=about_me]').val(),
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

