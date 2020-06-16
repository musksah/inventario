<?= $this->extend('index') ?>
<?= $this->section('content') ?>

<!-- component template -->
<script type="text/x-template" id="grid-template">
  <div class="table-responsive mt-3">
  <table class="table table-striped">
    <thead>
      <tr>
        <?php if ($rol === 'Administrador') : ?> 
        <td style="font-weight:bold;">Acciones</td>
        <?php endif ?>  
        <th v-for="key in columns"
          @click="sortBy(key)"
          :class="{ active: sortKey == key }">
          {{ key | capitalize }}
          <span class="arrow" :class="sortOrders[key] > 0 ? 'asc' : 'dsc'">
          </span>
        </th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="entry in filteredData">
      <?php if ($rol === 'Administrador') : ?>  
      <td><button class="btn btn-danger mr-2" @click="deleteRegister(entry)"><i class="fas fa-trash"></i></button><button class="btn btn-primary" @click="updateRegister(entry)"><i class="fas fa-pen"></i></button></td>
      <?php endif ?>  
      <td v-for="key in columns">
          {{entry[key]}}
        </td>
      </tr>
    </tbody>
  </table>
  </div>
</script>
<div id="app_users">
  <div class="card mt-4">
    <div class="card-body mb-3">
      <h4 class="card-title">Usuarios</h4>
      <hr class="mb-5">
      <form id="search">
        Buscar <input name="query" v-model="searchQuery">
      </form>
      <demo-grid :data="gridData" :columns="gridColumns" :filter-key="searchQuery">
      </demo-grid>
    </div>
    <div class="card-footer">
      <?php if ($rol === 'Administrador') : ?>
        <button class="btn btn-primary" id="btn-register-user" data-toggle="modal" data-target="#registerUserModal">Registrar</button>
      <?php endif ?>
      <button class="btn btn-primary" id="btn-update-user" data-toggle="modal" data-target="#updateUserModal" hidden></button>
    </div>
  </div>
  <!-- Modal Registar Usuario -->
  <div class="modal fade" id="registerUserModal" tabindex="-1" role="dialog" aria-labelledby="registerUserModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ modal_title }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="registerUser">
            <div class="form-group">
              <label for="exampleInputEmail1">Usuario</label>
              <input v-model="form.username" type="text" class="form-control" id="exampleInputEmail1" placeholder="Ingresar usuario" required>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Rol</label>
              <select v-model="form.rol" class="custom-select" required>
                <option selected value=null>Seleccionar...</option>
                <option value="Administrador">Administrador</option>
                <option value="Básico">Básico</option>
              </select>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Contraseña</label>
              <input v-model="form.password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Contraseña" required>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
          </form>
        </div>
        <div class="modal-footer">
          <button id="btn-close-modal" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Actualizar Usuario -->
  <div class="modal fade" id="updateUserModal" tabindex="-1" role="dialog" aria-labelledby="registerUserModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ modal_title_update }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="updateUser">
            <div class="form-group">
              <label for="exampleInputEmail1">Usuario</label>
              <input v-model="form_update.username" :value="form_update.username" type="text" class="form-control" id="exampleInputEmail1" placeholder="Ingresar usuario" required>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Rol</label>
              <select v-model="form_update.rol" :value="form_update.rol" class="custom-select" required>
                <option selected value=null>Seleccionar...</option>
                <option value="Administrador">Administrador</option>
                <option value="Básico">Básico</option>
              </select>
            </div>
            <div class="form-check mb-2">
              <input type="checkbox" v-model="form_update.ch_password" class="form-check-input" id="exampleCheck1" :required="form_update.ch_password">
              <label class="form-check-label" for="exampleCheck1">Actualizar contraseña</label>
            </div>
            <div class="form-group" v-if="form_update.ch_password">
              <label for="exampleInputPassword1">Nueva contraseña</label>
              <input v-model="form_update.password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Contraseña" required>
            </div>
            <div class="form-group">
              <label for="InputStateUpdate">Estado</label>
              <select v-model="form_update.state" :value="form_update.state" class="custom-select" required>
                <option selected value=null>Seleccionar...</option>
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
          </form>
        </div>
        <div class="modal-footer">
          <button id="btn-close-modal-update" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url('js/vue/vue-source.js'); ?>"></script>
<script src="<?php echo base_url('js/vue/vue.js'); ?>"></script>
<script src="<?php echo base_url('js/source/user.js'); ?>" type="module"></script>
<?= $this->endSection() ?>