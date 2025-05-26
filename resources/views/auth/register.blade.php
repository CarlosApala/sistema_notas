@extends('layouts.auth-master')
@section('content')


    <div class="content">
        <section class="vh-100" style="background-color: #1B396A;">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col col-xl-10">
                        <div class="card" style="border-radius: 1rem;">
                            <div class="row g-0">
                                <div class="col-md-6 col-lg-5 d-none d-md-block">
                                    <img src="assets/img/logo_login_tecnm.png" alt="login form" class="img-fluid"
                                        style="border-radius: 1rem 0 0 1rem;" />
                                </div>
                                <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                    <div class="card-body p-4 p-lg-5 text-black">

                                        <form action="/register" method="POST" class="formulario">
                                            @csrf
                                            @include('layouts.partials.messages')

                                            <div class="d-flex align-items-center mb-3 pb-1">
                                                <img src="assets/img/240022_login.png" width="90%" class="img-responsive"
                                                    style="margin:0 auto;" />
                                            </div>

                                            <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Plataforma
                                                Sistema </h5>

                                            <div class="form-outline mb-4">

                                                <input id="name" type="text" class="form-control " name="name"
                                                    value="" required autocomplete="name" autofocus>
                                                <label for="name" class="form-label">Nombre Completo</label>

                                            </div>

                                            <div class="form-outline mb-4">

                                                <input id="username" type="text" class="form-control " name="username"
                                                    value="" required autocomplete="username" autofocus>
                                                <label for="username" class="form-label">Usuario </label>

                                            </div>

                                            <div class="form-outline mb-4">

                                                <input id="email" type="email" class="form-control " name="username"
                                                    value="" required autocomplete="email" autofocus>
                                                <label for="email" class="form-label">Correo
                                                    Electronico</label>

                                            </div>

                                            <div class="form-outline mb-4">

                                                <input id="password" type="password" class="form-control " name="password"
                                                    value="" required autocomplete="password" autofocus>
                                                <label for="password" class="form-label">Contraseña</label>

                                            </div>

                                            <div class="form-outline mb-4">

                                                <input id="password_confirmation" type="password" class="form-control "
                                                    name="password_confirmation" value="" required
                                                    autocomplete="password_confirmation" autofocus>
                                                <label for="password_confirmation" class="form-label">Confirmar
                                                    Contraseña</label>

                                            </div>

                                            <div class="pt-1 mb-4">
                                                <button type="submit" class="btn btn-dark btn-lg btn-block">
                                                    Registrate
                                                </button>
                                            </div>


                                            <a class="small text-muted" href="{{ route('password.request') }}">
                                                ¿Olvidó su contraseña?
                                            </a>

                                            <a href="#!" class="small text-muted">Terms of use. 240022</a>
                                            <a href="#!" class="small text-muted">Privacy policy</a>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </div>




