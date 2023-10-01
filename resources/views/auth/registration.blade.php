@extends('layout.auth_layout')
@section('meta')
@endsection
@section('title', 'Student Registration')
@push('style')
@endpush
@section('content')
    <div class="card mb-0">
        <div class="card-body">
            <a href="javascript:void(0)"
                class="text-nowrap logo-img text-center d-block py-3 w-100"><strong>{{ env('APP_NAME') }}</strong>
            </a>
            <p class="text-center">{{ env('APP_NAME') }}</p>
            <form id="registration-form" method="post">
                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name :</label>
                    <input type="text" class="form-control" name="first_name" aria-describedby="textHelp"
                        placeholder="Jone" />
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name :</label>
                    <input type="text" class="form-control " id="last_name" name="last_name" aria-describedby="textHelp"
                        placeholder="Doe" />
                </div>
                <div class="mb-3">
                    <label for="user_name" class="form-label">User Name :</label>
                    <input type="text" class="form-control " id="user_name" name="user_name" aria-describedby="textHelp"
                        placeholder="JoneDoe" />
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email :</label>
                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp"
                        placeholder="jone.doe@email.com" name="email" />
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password :</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="********" />
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confim Password :</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                        placeholder="********" />
                </div>

                <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Sign In</button>
                <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-bold">Already have an Account?</p>
                    <a class="text-primary fw-bold ms-2" href="{{ route('auth.login') }}">Sign
                        In</a>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('script')
    <script type="text/javascript">
        $('#registration-form').submit((e) => {
            e.preventDefault();
            var data = $("#registration-form").serialize();

            $.ajax({
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                url: "http://127.0.0.1:8000/api/user/auth/signup",
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
