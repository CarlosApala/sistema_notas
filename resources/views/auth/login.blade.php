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
                                <div class="d-flex justify-content-center align-items-center mb-3 pb-1">
                                    <img src="{{ asset('assets/img/logoCOSMOL.jpg') }}" class="img-fluid" style="max-width: 90%;" />
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">

                                    <form action="/login" method="POST" class="formulario">
                                        @csrf
                                        @include('layouts.partials.messages')



                                        <h5 class="fw-normal mb-3 pb-3 text-center" style="letter-spacing: 1px;">
                                            Sistema de Gestión
                                        </h5>


                                        <div class="form-outline mb-4">

                                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                            <label for="email" class="form-label">Correo Electrónico</label>


                                        </div>

                                        <div class="form-outline mb-4">
                                            <input id="password" type="password" class="form-control " name="password"
                                                required autocomplete="current-password">
                                            <label for="password" class="text-md-rightform-label ">Contraseña</label>


                                        </div>

                                        <div class="pt-1 mb-4">
                                            <button type="submit" class="btn btn-dark btn-lg btn-block">
                                                Entrar
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
