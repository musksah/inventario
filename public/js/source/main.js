// register the grid component
const url_base = "http://127.0.0.1/inventario/public";

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
         sortOrders: sortOrders
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
      modal_title: "Registro de Usuarios"
   },
   methods: {
      recuperarUsuarios: function () {
         this.$http.get(`${url_base}/admin/users/list`).then(function (res) {
            console.log(res.data);
            this.gridData = res.data.data;
         }, function () {
            alert('No se han podido recuperar los estados.');
         });
      },
      recuperarTareas: function () {
         this.cargando_tareas = true;
         this.$http.get('recuperar_tareas').then(function (respuesta) {
            this.tareas = respuesta.body;
            this.cargando_tareas = false;
         }, function () {
            alert('No se han podido recuperar los estados.');
            this.cargando_tareas = false;
         });
      },
      registerUser: function () {
         this.$http.post(`${url_base}/admin/users/store`, this.createParams).then(function (res) {
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
         this.$http.post(`${url_base}/admin/users/destroy`, this.createParams).then(function (res) {
            console.log(res);
            this.recuperarUsuarios();
            this.closeModal(document.getElementById('btn-close-modal'), 'click');
            this.resetform();
         }, function () {
            alert('No se ha podido registrar el usuario.');
         });
      },
      updateRegister: function (p_tarea) {
         console.log("Se ha dado click en editar");
         console.log(data);
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
      }
   },
})