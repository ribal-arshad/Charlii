@extends('layouts.master')

@section('title', 'Package Option List')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Package Option List</h5>
                <div class="card-body">
                    <form action="{{route('Package.option.add.data')}}" method="POST">
                            @csrf
                            @include('partials.alert')
                        <div class="row">
                        <div class="form-group">
                            <div class="col-9">
                                <label class="form-label">Package Option</label>
                                <input type="text" class="form-control" name="option_name" placeholder="Package Option"/>
                            </div><br>
                            <button type="submit" class="btn btn-danger">save</button>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var title =  $('#title').val().trim();
        var name =  $('#name').val().trim();
        var postURL = "<?php echo url('/role/add/data'); ?>";
        var i = 1;

        $('#add').click(function(){
            i++;
            $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added"><td><input id="title" type="text" name="title[]" placeholder="Enter your Name" class="form-control name_list" /></td>' +
                '<td><input type="text" name="name[]" placeholder="Enter your Name" id="name" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
        });

        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#submit').click(function(){
            // var isValid = true;
            // $('#name, .names').each(function(){
            //     if($(this).val() === ''){
            //         isValid = false;
            //         $(this).addClass('is-invalid');
            //         $(this).siblings('.invalid-feedback').text('This input is invalid.');
            //     } else {
            //         $(this).removeClass('is-invalid');
            //         $(this).siblings('.invalid-feedback').text('');
            //     }
            // });
            if (name ===""||title===""){
                alert('fill all inputs')
            }

            // if(!isValid) {
            //     $('#validationMessage').text('All fields must be filled.').show();
            //     return false;
            // } else {
            //     $('#validationMessage').hide();
            // }
            else {
            $.ajax({
                url: postURL,
                method: "POST",
                data: $('#add_name').serialize(),
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    if(data.error) {
                        printErrorMsg(data.error);
                    } else if (data.success) {
                        i = 1;
                        $('.dynamic-added').remove();
                        $('#add_name')[0].reset();
                        $(".print-success-msg").find("ul").html('');
                        $(".print-success-msg").css('display','block');
                        $(".print-error-msg").css('display','none');
                        $(".print-success-msg").find("ul").append('<li>' + data.success + '</li>');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle AJAX errors, if any
                    console.error(xhr.responseText);
                }
            });
            }
        });

        function printErrorMsg(msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $(".print-success-msg").css('display','none');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
            $(".print-error-msg").find("ul").append('<li>Input is invalid. Please fill out all required fields.</li>');
        }

    });





</script>


