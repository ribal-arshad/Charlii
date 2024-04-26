@extends('layouts.master')

@section('title', 'Coupon')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Coupons add</h5>
                <div class="card-body">
                    <form action="{{route('coupon.add.data')}}" method="POST">
                        <div class="row">
                        <div class="col-md-4">
                            <label class="required" for="coupon_code">Coupon Code</label><br>
                            <input class="form-control" type="text" name="coupon_code" id="coupon_code" value="{{ old('coupon_code', '') }}">
                        </div>
                            <div class="col-md-4">
                                <label class="required" for="coupon_code">Package</label>
                                <select class="form-control select2" id="search_id" tabindex="1" name="package_id">
{{--                                    <option value="0">Select Packages</option>--}}
                                    @foreach ($packages as $package)
                                        <option value="{{ $package->id }}">{{ $package->package_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                                <br>
                                <div class="col-md-4">
                                    <label class="required" for="coupon_code"> Any Package Package Type</label>
                                    <select class="form-control select2" id="search_id" tabindex="1" name="package_type">
                                        <option value="0">Select Package Type</option>
                                        @foreach ($packages as $package)
                                            <option value="{{ $package->id }}">{{ $package->package_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            <br><br><br><br>
                            <div class="col-4">
                                <label class="required" for="coupon_code">Discount Amount</label><br>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupCurrency">$<input class="form-check-input" type="radio" name="currency" id="dollarRadio" value="$" checked></span>
                                    </div>
                                    <input type="number" class="form-control" name="discount_amount" aria-label="Amount (to the nearest dollar)" id="amountInput">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%<input class="form-check-input" type="radio" name="currency" id="percentRadio" value="%"></span>
                                    </div>
                                </div>
                            </div><br><br><br><br>
                            <div class="col-md-4">
                                <label class="form-label">Number Of Usage
                                </label>
                                <input type="text" class="form-control" name="number_of_usage" value="{{old('number_of_usage')}}" placeholder="Enter number_of_usage"/>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Date Of Expiry
                                </label>
                                <input type="date" class="form-control" name="date_of_expiry" value="{{old('date_of_expiry')}}" placeholder="Enter number_of_usage"/>
                            </div>
                            <div class="col-md-4">
                                <label class="required" >Status</label>
                                <select class="form-control select2" name="status">
                                    <option value="">---Select Status----</option>
                                    <option value="1">Enable</option>
                                    <option value="0">Disable</option>
                                </select>
                            </div>

                            @csrf
                            @include('partials.alert')

                        <div class="form-group">

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

    var amountInput = document.getElementById("amountInput");

    // Get the radio buttons
    var dollarRadio = document.getElementById("dollarRadio");
    var percentRadio = document.getElementById("percentRadio");

    // Add event listeners for radio button change
    dollarRadio.addEventListener("change", updateCurrency);
    percentRadio.addEventListener("change", updateCurrency);

    // Function to update currency symbol
    function updateCurrency() {
        if (dollarRadio.checked) {
            document.getElementById("inputGroupCurrency").textContent = "$";
        } else if (percentRadio.checked) {
            document.getElementById("inputGroupCurrency").textContent = "%";
        }
    }

    // Add event listener for input change
    amountInput.addEventListener("input", function() {
        // Get the input value
        var inputValue = this.value;

        // Check if the input contains a dollar sign
        if (dollarRadio.checked) {
            // Format the input as dollars (assuming it's a number)
            this.value = "$" + parseFloat(inputValue).toFixed(2);
        } else if (percentRadio.checked) {
            // Format the input as percentage (assuming it's a number)
            this.value = parseFloat(inputValue).toFixed(2) + "%";
        }
    });

    // Initial update to set default currency
    updateCurrency();


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


