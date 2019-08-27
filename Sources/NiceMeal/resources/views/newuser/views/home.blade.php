@extends('newuser.layouts.app')
@section('content')
@endsection

@push('extra_scripts')
<script>
        $(document).ready(function() {
          var userCheck = '<?php echo $userCheck ?>';
          $('#{{$userCheck == 0 ? 'myModalLocation' : 'myModalLogin'}}').modal({
            backdrop: 'static',
            keyboard: false
          });
        });
    </script>
@endpush
