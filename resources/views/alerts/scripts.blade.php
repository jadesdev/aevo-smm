<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

<script type="text/javascript">
    @if(Session::get('success'))
    toastr.success('{!! Session::get('success') !!}', 'Successful');
    var content2 = document.createElement('div');
    content2.innerHTML = `{!! Session::get('success') !!}`;
    swal({
        title: "Successful",
        content: content2,
        icon: "success"
    });
    @endif
    @if(Session::get('error'))
    toastr.error('{{Session::get('error')}}', 'Error');
    // swal("Error!", '{{Session::get('error')}}', "warning");

    @endif
    @if(count($errors) > 0)
        console.log('{!! implode('<br>', $errors->all()) !!}');
        toastr.error('{!! implode('<br>', $errors->all()) !!}', 'Error');
    @endif

    function copyFunction(element)
    {
        var aux = document.createElement("input");
        // Assign it the value of the specified element
        aux.setAttribute("value", element);
        document.body.appendChild(aux);
        aux.select();
        document.execCommand("copy");
        document.body.removeChild(aux);
        swal("Successful", 'Copied Successfully', "success");
    }
</script>
<script>
    $(document).ready(function() {
        $('.delete-btn').on('click', function(e) {
            e.preventDefault();

            // Get the custom message from the data-message attribute
            var message = "Do you really want to delete this?";

            // Show a confirmation popup with the custom message
            swal({
                title: "Are you sure?",
                text: message,
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    window.location.href = $(this).attr('href');

                } else {
                    swal("You canceled the operation!");
                }
            });
        });

    });

    (function ($) {
        "use strict";
        $(document).on('click','.confirmBtn', function () {
            var modal   = $('#confirmationModal');
            let data    = $(this).data();
            modal.find('.question').text(`${data.question}`);
            modal.find('form').attr('action', `${data.action}`);
            modal.modal('show');
        });
    })(jQuery);
</script>
