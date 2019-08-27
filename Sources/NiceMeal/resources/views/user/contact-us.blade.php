@extends('layouts.app')
@section('content')

    <div class="md-content" style="background-image: url('{{ url("/b2c-assets/img/bg/bg-contact.jpg") }}');background-size: 100% 100%; background-repeat: no-repeat;">
        <div style="display: flex;align-items: center;justify-content: center;min-height: inherit;">
            <div class="row text-center">
                <h5 style="color: #ffffff;">Click me</h5>
                <h6 style="color: #ffffff;">We will contact will immediately</h6>
                <a href="/contact" class="btn m-btn md-btn--danger" >SUBMIT RESTAURANT</a>
                <button type="button" class="btn m-btn md-btn--danger" id="btnModalContact">CONTACT NOW</button>
                <button type="button" class="btn m-btn md-btn--danger" style="background-color: inherit; border: #ffffff 2px dashed; width: 127px;">CHAT NOW</button>
            </div>
        </div>
        @include('user.social-tools')
        @include('user.popup-contact-us',['contact_categories' => $contact_categories])
    </div>

@endsection
@section('extra_scripts')
    <script>
        $(document).ready(function(){
            $('footer').removeClass('mg-t-150');
            $('#btnModalContact').click(function () {
                $('#contactModal').modal('show');
            });
            $('#file').change(function () {
                if(this.files[0].size > 2097152) {
                    alert("File is to big!");
                    this.value = "";
                }
            });
        });
    </script>
@endsection
