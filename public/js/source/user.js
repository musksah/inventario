// register the grid component
const url_base = "http://127.0.0.1/inventario/public/admin/users";

Vue.component('demo-grid', {
   template: '#grid-template',
   props: {
      data: Array,
      columns: Array,
      filterKey: String,
      isActive: true,
      hasError: true
   },
   data: function () {
      var sortOrders = {}
      this.columns.forEach(function (key) {
         sortOrders[key] = 1
      })
      return {
         sortKey: '',
         sortOrders: sortOrders,
      }
   },
   computed: {
      filteredData: function () {
         var sortKey = this.sortKey
         var filterKey = this.filterKey && this.filterKey.toLowerCase()
         var order = this.sortOrders[sortKey] || 1
         var data = this.data
         if (filterKey) {
            data = data.filter(function (row) {
               return Object.keys(row).some(function (key) {
                  return String(row[key]).toLowerCase().indexOf(filterKey) > -1
               })
            })
         }
         if (sortKey) {
            data = data.slice().sort(function (a, b) {
               a = a[sortKey]
               b = b[sortKey]
               return (a === b ? 0 : a > b ? 1 : -1) * order
            })
         }
         return data
      }
   },
   filters: {
      capitalize: function (str) {
         return str.charAt(0).toUpperCase() + str.slice(1)
      }
   },
   methods: {
      sortBy: function (key) {
         this.sortKey = key
         this.sortOrders[key] = this.sortOrders[key] * -1
      },
      deleteRegister(row) {
         this.$parent.deleteRegister(row);
      },
      updateRegister(row) {
         this.$parent.updateRegister(row);
      },
   }
})

Vue.use(VueResource)
// Vue.prototype.$axios = axios

const vue = new Vue({
   // router,
   el: '#app_users',
   data: {
      cargando_tareas: true,
      tarea_nueva: {
         titulo: '',
         descripcion: ''
      },
      form: {
         username: '',
         rol: null,
         password: '',
      },
      searchQuery: '',
      gridColumns: ['id', 'username', 'rol'],
      gridData: [],
      modal_title: "Registro de Usuarios",
      modal_title_update: "Actualizar Usuario",
      form_update:{
         ch_password: false,
         id: '',
         username: '',
         rol: null,
         password: '',
         state: null,
      }
   },
   methods: {
      recuperarUsuarios: function () {
         this.$http.get(`${url_base}/list`).then(function (res) {
            console.log(res.data);
            this.gridData = res.data.data;
         }, function () {
            alert('No se han podido recuperar los estados.');
         });
      },
      registerUser: function () {
         this.$http.post(`${url_base}/store`, this.createParams).then(function (res) {
            console.log(res);
            this.recuperarUsuarios();
            this.closeModal(document.getElementById('btn-close-modal'), 'click');
            this.resetform();
         }, function () {
            alert('No se ha podido registrar el usuario.');
         });
      },
      deleteRegister(data) {
         console.log("Se ha dado click en eliminar");
         console.log(data);
         const params = new FormData();
         params.append("id", data.id)
         this.$http.post(`${url_base}/destroy`, params).then(function (res) {
            console.log(res);
            this.recuperarUsuarios();
            this.closeModal(document.getElementById('btn-close-modal'), 'click');
            this.resetform();
         }, function () {
            alert('No se ha podido registrar el usuario.');
         });
      },
      updateUser(){
         console.log(this.form_update);
         this.$http.post(`${url_base}/updating`, this.createParamsUpdate).then(function (res) {
            console.log(res);
            this.closeModal(document.getElementById('btn-close-modal-update'), 'click');
            this.recuperarUsuarios();
         }, function () {
            alert('No se ha podido registrar el usuario.');
         });
      },
      updateRegister(data) {
         console.log("Se ha dado click en editar");
         console.log(data);
         this.form_update.username = data.username 
         this.form_update.rol = data.rol 
         this.form_update.state = data.state 
         this.form_update.id = data.id 
         this.form_update.password = "" 
         this.form_update.ch_password = false 
         this.closeModal(document.getElementById('btn-update-user'), 'click');
      },
      closeModal: function (el, etype) {
         if (el.fireEvent) {
            el.fireEvent('on' + etype);
         } else {
            var evObj = document.createEvent('Events');
            evObj.initEvent(etype, true, false);
            el.dispatchEvent(evObj);
         }
      },
      resetform() {
         this.form.username = ""
         this.form.rol = null
         this.form.password = ""
      }
   },
   beforeMount() {
      this.recuperarUsuarios();
   },
   computed: {
      createParams() {
         const params = new FormData();
         params.append("username", this.form.username);
         params.append("rol", this.form.rol);
         params.append("password", this.form.password);
         params.append("state", 1);
         return params;
      },
      createParamsUpdate() {
         const params = new FormData();
         if (this.form_update.ch_password) {
            params.append("password", this.form_update.password);
         }
         params.append("id", this.form_update.id);
         params.append("username", this.form_update.username);
         params.append("rol", this.form_update.rol);
         params.append("state", this.form_update.state);
         return params;
      },
   },
})