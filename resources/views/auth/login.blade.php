@extends('layout.auth_layout')
@section('meta')
@endsection
@section('title', 'Login')
@push('style')
@endpush
@section('content')
    <div class="card mb-0">
        <div class="card-body">
            <a href="javascript:void(0)"
                class="text-nowrap logo-img text-center d-block py-3 w-100"><strong>{{ env('APP_NAME') }}</strong>
            </a>
            <p class="text-center">{{ env('APP_NAME') }} - Login</p>
            <form id="login-form" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email :</label>
                    <input type="email" class="form-control" id="email" name="email"
                        placeholder="jone.doe@email.com" />
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password :</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="********" />
                </div>
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                        <input class="form-check-input primary" type="checkbox" value="Remember Me" id="remember"
                            value="true" name="remember">
                        <label class="form-check-label text-dark" for="remember">
                            Remember me
                        </label>
                    </div>

                </div>
                <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Sign In</button>
                <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-bold">You don't have a account?</p>
                    <a class="text-primary fw-bold ms-2" href="{{ route('auth.registration') }}">Create an account</a>
                </div>
            </form>
        </div>
    @endsection
    @push('script')
        <script type="text/javascript">
            $('#login-form').submit((e) => {
                e.preventDefault();
                var data = $("#login-form").serialize();

                $.ajax({
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    url: "http://127.0.0.1:8000/api/user/auth/sigin",
                    data: data,
                    type: "POST",
                    beforSend: () => {
                        console.log('requested ...');
                    },
                    success: (res) => {
                        console.log(res);
                    },
                    error: (XMLHttpRequest, textStatus, errorThrown) => {
                        console.error(XMLHttpRequest.responseJSON
                            .message);
                    }
                });

            });
        </script>
    @endpush
