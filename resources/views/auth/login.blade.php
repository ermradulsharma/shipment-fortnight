@extends('layouts.frontend')

@section('content')
    <!-- Call To Action -->
		<section class="call-action overlay">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-5 col-12">
						<div class="call-inner text-left">
                            <div class="card">
                                <div class="card-header bg-warning">{{ __('Login') }}</div>
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf
                    
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="email" class="col-md-12 col-form-label text-md-end">{{ __('E-Mail Address') }}</label>
                                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                    
                                            <div class="row mb-4 mt-2">
                                                <div class="col-md-12">
                                                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                    
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-primary btn-block">
                                                        {{ __('Login') }}
                                                    </button>
                                                </div>
                                            </div>
                    
                                            <div class="row">
                                                <div class="col-md-12 text-right">
                                                    <a class="btn btn-link mt-3" href="{{ route('password.request') }}">
                                                        {{ __('Forgot Your Password?') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
