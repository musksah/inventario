// register the grid component
const url_base = "http://127.0.0.1/inventario/public/admin/sub_categories";
const url_base_category = "http://127.0.0.1/inventario/public/admin/categories";

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
   el: '#app_subcategories',
   data: {
      cargando_tareas: true,
      tarea_nueva: {
         titulo: '',
         descripcion: ''
      },
      form: {
         name: '',
         quantity_products: '',
         id_category: null,
      },
      searchQuery: '',
      gridColumns: ['id','name','quantity_products','id_category'],
      gridData: [],
      modal_title: "Registro de SubCategorías",
      modal_title_update: "Actualizar SubCategoría",
      form_update:{
         id: '',
         name: '',
         quantity_products: '',
         id_category: null,
         state: null,
      },
      options_form_category:"Hola"
   },
   methods: {
      recuperarSubCategorias: function () {
         this.$http.get(`${url_base}/list`).then(function (res) {
            console.log(res.data);
            this.gridData = res.data.data;
         }, function () {
            alert('No se han podido recuperar las subcategorías.');
         });
      },
      getSelectCategorias() {
         this.$http.get(`${url_base_category}/selectb`).then(function (res) {
            console.log(res.data);
            console.log(typeof res.data);
            this.options_form_category = res.data;
         }, function () {
            alert('No se ha podido recuperar el select categorías.');
         });
      },
      registerSubCategory: function () {
         this.$http.post(`${url_base}/store`, this.createParams).then(function (res) {
            console.log(res);
            this.recuperarSubCategorias();
            this.closeModal(document.getElementById('btn-close-modal'), 'click');
            this.resetform();
         }, function () {
            alert('No se ha podido registrar la subcategoría.');
         });
      },
      deleteRegister(data) {
         console.log("Se ha dado click en eliminar");
         console.log(data);
         const params = new FormData();
         params.append("id", data.id)
         this.$http.post(`${url_base}/destroy`, params).then(function (res) {
            console.log(res);
            this.recuperarSubCategorias();
            this.closeModal(document.getElementById('btn-close-modal'), 'click');
            this.resetform();
         }, function () {
            alert('No se ha podido desactivar la subcategoría.');
         });
      },
      updateSubCategory(){
         console.log(this.form_update);
         this.$http.post(`${url_base}/updating`, this.createParamsUpdate).then(function (res) {
            console.log(res);
            this.closeModal(document.getElementById('btn-close-modal-update'), 'click');
            this.recuperarCategorias();
         }, function () {
            alert('No se ha podido actualizar la subcategoría.');
         });
      },
      updateRegister(data) {
         console.log("Se ha dado click en editar");
         console.log(data);
         this.form_update.name = data.name 
         this.form_update.state = data.state 
         this.form_update.id = data.id 
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
         this.form.name = ""
         this.form.quantity_products = ''
         this.form.id_category = 0
      }
   },
   beforeMount() {
      this.recuperarSubCategorias();
      this.getSelectCategorias();
   },
   computed: {
      createParams() {
         const params = new FormData();
         params.append("name", this.form.name);
         params.append("id_category", this.form.id_category);
         params.append("quantity_products", 0);
         params.append("state", 1);
         return params;
      },
      createParamsUpdate() {
         const params = new FormData();
         params.append("id", this.form_update.id);
         params.append("name", this.form_update.name);
         params.append("state", this.form_update.state);
         return params;
      },
   },
})