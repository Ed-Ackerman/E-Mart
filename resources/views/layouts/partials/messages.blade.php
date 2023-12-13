@if(Session::has('success') || Session::has('info') || Session::has('error'))
    <?php
    $data = [];

    if (Session::has('success')) {
        $data = array_merge($data, is_array(Session::get('success')) ? Session::get('success') : [Session::get('success')]);
    }

    if (Session::has('info')) {
        $data = array_merge($data, is_array(Session::get('info')) ? Session::get('info') : [Session::get('info')]);
    }

    if (Session::has('error')) {
        $data = array_merge($data, is_array(Session::get('error')) ? Session::get('error') : [Session::get('error')]);
    }
    ?>

    @foreach ($data as $msg)
        @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                <i class="fa fa-check"></i>
                {{ $msg }}
            </div>
        @elseif (Session::has('info'))
            <div class="alert alert-info" role="alert">
                <i class="fa fa-info-circle"></i>
                {{ $msg }}
            </div>
        @elseif (Session::has('error'))
            <div class="alert alert-error" role="alert">
                <i class="fa fa-times-circle"></i>
                {{ $msg }}
            </div>
        @endif
    @endforeach
@endif


<script>
    $(document).ready(function() {
        // Display the alert with fadeIn
        $('.alert').fadeIn('slow');

        // Set a timer to fade out the alert after 5 seconds (5000 milliseconds)
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 3000);
    });
</script>
