@extends('layout.layout')
@section('content')
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form" action="{{asset('/login')}}" method="post">
                    @csrf
                    <a href="{{asset('/')}}">
                        <span class="login100-form-title p-b-43 d-sm-block d-md-none custom-logo-name">
						    LooE Chat
					    </span>
                    </a>
                    <span class="login100-form-title p-b-43">
						Войти, чтобы продолжить
					</span>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
                        <input class="input100" type="text" name="login">
                        <span class="focus-input100"></span>
                        <span class="label-input100">Login</span>
                    </div>


                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="password" name="password">
                        <span class="focus-input100"></span>
                        <span class="label-input100">Password</span>
                    </div>

                    <!-- <div class="flex-sb-m w-full p-t-3 p-b-32">
                        <div class="contact100-form-checkbox">
                            <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
                            <label class="label-checkbox100" for="ckb1">
                                Remember me
                            </label>
                        </div>

                        <div>
                            <a href="#" class="txt1">
                                Forgot Password?
                            </a>
                        </div>
                    </div> -->


                    <div class="container-login100-form-btn mt-3">
                        <button class="login100-form-btn">
                            Войти
                        </button>
                    </div>

                    <div class="text-center p-t-46 p-b-20">
						<span class="txt2">
							<a href="{{asset('/register')}}" class="login100-form-link">У вас нет аккаунта ?</a>
						</span>
                    </div>

                    <div class="text-center p-t-46 p-b-20">
                        <img src="{{asset('images/qr.png')}}" alt="">
                    </div>

                    <!--
                    <div class="login100-form-social flex-c-m">
                        <a href="#" class="login100-form-social-item flex-c-m bg1 m-r-5">
                            <i class="fa fa-facebook-f" aria-hidden="true"></i>
                        </a>

                        <a href="#" class="login100-form-social-item flex-c-m bg2 m-r-5">
                            <i class="fa fa-twitter" aria-hidden="true"></i>
                        </a>
                    </div>-->
                </form>

                @include('layout.elements.leftside')
            </div>
        </div>
    </div>
@endsection
