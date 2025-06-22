<template>
  <section class="vh-100" style="background-color: #1B396A;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-xl-10">
          <div class="card" style="border-radius: 1rem;">
            <div class="row g-0">
              <div class="col-md-6 col-lg-5 d-none d-md-block">
                <div class="d-flex justify-content-center align-items-center mb-3 pb-1">
                  <img src="/assets/img/LogoCOSMOL.jpg" class="img-fluid" style="max-width: 90%;" />
                </div>
              </div>

              <div class="col-md-6 col-lg-7 d-flex align-items-center">
                <div class="card-body p-4 p-lg-5 text-black">
                  <form @submit.prevent="submit">
                    <h5 class="fw-normal mb-3 pb-3 text-center" style="letter-spacing: 1px;">
                      Sistema de Gestión
                    </h5>

                    <div class="form-outline mb-4">
                      <input
                        id="email"
                        v-model="form.email"
                        type="email"
                        class="form-control"
                        required
                        autofocus
                      />
                      <label for="email" class="form-label">Correo Electrónico</label>
                      <div v-if="form.errors.email" class="text-danger">{{ form.errors.email }}</div>
                    </div>

                    <div class="form-outline mb-4">
                      <input
                        id="password"
                        v-model="form.password"
                        type="password"
                        class="form-control"
                        required
                      />
                      <label for="password" class="form-label">Contraseña</label>
                      <div v-if="form.errors.password" class="text-danger">{{ form.errors.password }}</div>
                    </div>

                    <div class="pt-1 mb-4">
                      <button type="submit" class="btn btn-dark btn-lg btn-block">
                        Entrar
                      </button>
                    </div>

                    <div class="d-flex flex-column gap-1">
                      <Link class="small text-muted" :href="route('password.request')">
                        ¿Olvidó su contraseña?
                      </Link>
                      <a href="#!" class="small text-muted">Terms of use</a>
                      <a href="#!" class="small text-muted">Privacy policy</a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { Link, router } from '@inertiajs/vue3'

const form = useForm({
  email: '',
  password: ''
})

function submit() {
  form.post('/login')
}
</script>
