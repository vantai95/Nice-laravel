@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-1">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                <div class="card-header"><h4>{{ __('auth.email.title') }}</h4></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{url('password/create')}}" aria-label="{{ __('auth.email.title') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-12 col-lg-12 col-sm-12 col-form-label text-md-right">{{ __('auth.email.email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('auth.email.button') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
