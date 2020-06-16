<?= $this->extend('index') ?>
<?= $this->section('content') ?>
<div id="app_login">
    <main class="login-form mt-5">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Iniciar Sesión</div>
                        <div class="card-body">
                            <form @submit.prevent="login">
                                <div class="form-group row">
                                    <label for="email_address" class="col-md-4 col-form-label text-md-right">Usuario</label>
                                    <div class="col-md-6">
                                        <input type="text" v-model="form.username" id="user" class="form-control" name="user" required autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Contraseña</label>
                                    <div class="col-md-6">
                                        <input type="password" v-model="form.password" id="password" class="form-control" name="password" required>
                                    </div>
                                </div>
                                <div class="col-md-6 offset-md-4 mb-2">
                                    <button type="submit" class="btn btn-primary">
                                        Ingresar
                                    </button>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<script src="<?php echo base_url('js/vue/vue-source.js'); ?>"></script>
<script src="<?php echo base_url('js/vue/vue.js'); ?>"></script>
<script src="<?php echo base_url('js/source/login.js'); ?>" type="module"></script>
<?= $this->endSection() ?>