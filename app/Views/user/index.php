<?= $this->extend('index') ?>
<?= $this->section('content') ?>

<!-- component template -->
<script type="text/x-template" id="grid-template">
  <div class="table-responsive mt-3">
  <table class="table table-striped">
    <thead>
      <tr>
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
      <button class="btn btn-primary" data-toggle="modal" data-target="#registerUserModal">Registrar</button>
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
</div>
<script src="<?php echo base_url('js/vue/vue-source.js'); ?>"></script>
<script src="<?php echo base_url('js/vue/vue.js'); ?>"></script>
<script src="<?php echo base_url('js/source/main.js'); ?>" type="module"></script>
<?= $this->endSection() ?>