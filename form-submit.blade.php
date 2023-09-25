<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">.
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Job Application Form</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
        rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

</head>

<body>

    <div class="container mt-5">
        <h1>Job Application Form</h1>
        <form id="job-application-form">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" placeholder="Enter your name">

                <span class="error-message text-danger" id="name-error"></span>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" placeholder="Enter your address">
            </div>
            <div class="form-group">
                <label for="start-date">Starting Date</label>
                <input type="text" class="form-control datepicker" id="start_date">
            </div>
            <div class="form-group">
                <label for="current-salary">Current Salary</label>
                <input type="text" class="form-control" id="current_salary" placeholder="Enter your current salary">
            </div>
            <div class="form-group">
                <label for="expected-salary">Expected Salary</label>
                <input type="text" class="form-control" id="expected_salary"
                    placeholder="Enter your expected salary">

                    <span class="error-message text-danger" id="salary-error"></span>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>


    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script>
        $(document).ready(function() {


            $('.datepicker').datepicker({
                format: 'd-m-Y',
                autoclose: true
            });




            $('#job-application-form').on('submit', function(event) {
                event.preventDefault();

                var formValid = true;
                $('input').css('border-color', '');
                $('input').each(function() {
                    if ($(this).val() === '') {
                        $(this).css('border-color', 'red');
                        formValid = false;
                    }
                });


                if (formValid) {
            var csrf_token = $('meta[name="csrf-token"]').attr('content'); // Retrieve CSRF token
            var formData = {
                _token: csrf_token,
                name: $('#name').val(),
                address: $('#address').val(),
                start_date: $('#start_date').val(),
                current_salary: $('#current_salary').val(),
                expected_salary: $('#expected_salary').val()
            }

            $.ajax({
                type: 'POST',
                url: '{{ route('store') }}',
                data: formData,
                success: function (response) {
                    console.log('Success:', response.success);
                    // Handle success response here
                },
                error: function (xhr, status, error) {
        if (xhr.status === 422) {
            var errors = xhr.responseJSON.errors;
            // Loop through the errors object and display the messages
            for (var key in errors) {
                if (errors.hasOwnProperty(key)) {

                    if (key === 'name') {
                        // Display error message below the input field
                        $('#name-error').text(errors[key][0]);
                    }
                    if (key === 'expected_salary') {
                        // Display error message below the input field
                        $('#salary-error').text(errors[key][0]);
                    }

                    console.log(key, errors[key][0]);
                }
            }
        } else {
            console.error(error);
        }
    }

    // end error
            });
        }
            });

        });
    </script>
</body>

</html>
