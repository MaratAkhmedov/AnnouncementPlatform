@extends('layouts.general_template')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('auth.verify_email') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('auth.verify_email_resent') }}
                        </div>
                    @endif

                    {{ __('auth.verify_email_text') }}
                    <a href="{{ route('verification.resend') }}"><p>{{ __('auth.verify_email_link') }}</p></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
