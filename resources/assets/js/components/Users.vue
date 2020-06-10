<template>
  <div class="container">
    <div class="row mt-5">
      <div class="col-md-12">
        <div class="card" v-if="$gate.isAdminOrAuthor() && !editMode && !createMode">
          <div class="card-header">
            <h3 class="card-title">Lista de clientes</h3>

            <div class="card-tools">
              <button class="btn btn-success" @click="showForm">
                Nuevo cliente
                <i class="fas fa-user-plus fa-fw"></i>
              </button>
            </div>
            <!-- <div class="card-tools">

              <button class="btn btn-success" @click="newModal">
                Nuevo cliente
                <i class="fas fa-user-plus fa-fw"></i>
              </button>
            </div>-->
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <tbody>
                <tr>
                  <th></th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Telefono</th>
                  <th>Facturado</th>
                  <th>Deuda</th>
                  <th></th>
                </tr>

                <tr v-for="user in users.data" :key="user.id">
                  <td></td>
                  <td>{{user.name}}</td>
                  <td>{{user.email}}</td>
                  <td>{{ user.client_cellphone }}</td>
                  <td></td>
                  <td></td>

                  <td>
                    <a href="#" @click="editModeOn(user)">
                      <i class="fa fa-edit blue"></i>
                    </a>

                    <a href="#" @click="deleteUser(user.id)">
                      <i class="fa fa-trash red"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <pagination :data="users" @pagination-change-page="getResults"></pagination>
          </div>
        </div>

        <div class="card" v-if="$gate.isAdminOrAuthor() && createMode">
          <div class="card-header">
            <h3 class="card-title">Nuevo Cliente</h3>
            <div class="card-tools">
              <button class="btn btn-danger" @click="closeForm">
                Salir
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <form @submit.prevent="createMode? createUser():updateClient()">
              <div class="modal-body">
                <div class="form-group">
                  <h5>
                    <strong>Informacion de la cliente</strong>
                  </h5>
                </div>
                <div class="row">
                  <div class="form-group col-md-6">
                    <!-- RUC -->
                    <input
                      v-model="form.ruc"
                      type="text"
                      name="ruc"
                      placeholder="RUC o DNI"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('ruc') }"
                    >
                    <has-error :form="form" field="ruc"></has-error>
                  </div>

                  <!-- SITUACION SUNAT -->
                  <div class="form-group col-md-6">
                    <input
                      v-model="form.sunat_situation"
                      type="text"
                      name="sunat_situation"
                      placeholder="Situacion con el Sunat"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('sunat_situation') }"
                    >
                    <has-error :form="form" field="sunat_situation"></has-error>
                  </div>
                </div>

                <div class="row">
                  <!-- NOMBRE -->
                  <div class="form-group col-md-8">
                    <input
                      v-model="form.name"
                      type="text"
                      name="name"
                      placeholder="Nombre"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('name') }"
                    >
                    <has-error :form="form" field="name"></has-error>
                  </div>

                  <!-- EMAIL -->
                  <div class="form-group col-md-4">
                    <input
                      v-model="form.email"
                      type="email"
                      name="email"
                      placeholder="Email de registro"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('email') }"
                    >
                    <has-error :form="form" field="email"></has-error>
                  </div>
                </div>
                <div class="form-group">
                  <h5>
                    <strong>Direccion fiscal</strong>
                  </h5>
                </div>
                <!-- DOMICIO FISCAL - DIRECCION -->
                <div class="row">
                  <div class="form-group col-md-6">
                    <input
                      v-model="form.client_adress"
                      type="text"
                      name="client_adress"
                      placeholder="Dirección"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('client_adress') }"
                    >
                    <has-error :form="form" field="client_adress"></has-error>
                  </div>
                  <!-- DOMICIO FISCAL - DEPARTAMENTO -->
                  <div class="form-group col-md-2">
                    <select
                      name="client_department_id"
                      v-model="form.client_department_id"
                      @change="getProvinces"
                      id="client_department_id"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('client_department_id') }"
                    >
                      <option value>Region</option>
                      <option
                        v-for="department in departments"
                        :key="department.id"
                        :value="department.id"
                      >{{ department.name }}</option>
                    </select>
                    <has-error :form="form" field="client_department_id"></has-error>
                  </div>
                  <!-- DOMICIO FISCAL - PROVINCIA -->
                  <div class="form-group col-md-2">
                    <select
                      name="client_province_id"
                      v-model="form.client_province_id"
                      @change="getDistricts"
                      id="client_province_id"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('client_province_id') }"
                    >
                      <option value>Provincia</option>
                      <option
                        v-for="provinces in provinces"
                        :key="provinces.id"
                        :value="provinces.id"
                      >{{ provinces.name }}</option>
                    </select>

                    <has-error :form="form" field="client_province_id"></has-error>
                  </div>
                  <!-- DOMICIO FISCAL - DISTRITO -->
                  <div class="form-group col-md-2">
                    <select
                      name="client_district_id"
                      v-model="form.client_district_id"
                      id="client_district_id"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('client_district_id') }"
                    >
                      <option value>Distrito</option>
                      <option
                        v-for="districts in districts"
                        :key="districts.id"
                        :value="districts.id"
                      >{{ districts.name }}</option>
                    </select>
                    <has-error :form="form" field="client_district_id"></has-error>
                  </div>
                  <!-- <div class="form-group ml-4">
                    <a href>Agregar mas domicilo</a>
                  </div>-->
                </div>

                <div class="form-group">
                  <h5>
                    <strong>Informacion de contacto</strong>
                  </h5>
                </div>
                <div class="row">
                  <!-- CONTACTO - NOMBRE -->
                  <div class="form-group col-md-3">
                    <input
                      v-model="form.client_contact_name"
                      type="text"
                      name="client_contact_name"
                      placeholder="Nombre y Apellido"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('client_contact_name') }"
                    >
                    <has-error :form="form" field="client_contact_name"></has-error>
                  </div>

                  <!-- CONTACTO - CELULAR -->
                  <div class="form-group col-md-3">
                    <input
                      v-model="form.client_contact_cellphone"
                      type="text"
                      name="client_contact_cellphone"
                      placeholder="Celular"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('client_contact_cellphone') }"
                    >
                    <has-error :form="form" field="client_contact_cellphone"></has-error>
                  </div>
                  <!-- CONTACTO - TELEFONO -->
                  <div class="form-group col-md-3">
                    <input
                      v-model="form.client_contact_phone"
                      type="text"
                      name="client_contact_phone"
                      placeholder="Telefono"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('client_contact_phone') }"
                    >
                    <has-error :form="form" field="client_contact_phone"></has-error>
                  </div>
                  <!-- CONTACTO - ANEXO -->
                  <div class="form-group col-md-3">
                    <input
                      v-model="form.client_contact_anexo"
                      type="text"
                      name="client_contact_anexo"
                      placeholder="Anexo"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('client_contact_anexo') }"
                    >
                    <has-error :form="form" field="client_contact_anexo"></has-error>
                  </div>
                </div>

                <div class="row">
                  <!-- CONTACTO - EMAIL -->
                  <div class="form-group col-md-3">
                    <input
                      v-model="form.client_contact_email"
                      type="text"
                      name="client_contact_email"
                      placeholder="Correo"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('client_contact_email') }"
                    >
                    <has-error :form="form" field="client_contact_email"></has-error>
                  </div>
                  <!-- CONTACTO - CARGO -->
                  <div class="form-group col-md-3">
                    <input
                      v-model="form.client_contact_charge"
                      type="text"
                      name="client_contact_charge"
                      placeholder="Cargo"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('client_contact_charge') }"
                    >
                    <has-error :form="form" field="client_contact_charge"></has-error>
                  </div>
                  <!-- CONTACTO - CUMPLEAÑOS -->
                  <div class="form-group col-md-3">
                    <input
                      v-model="form.client_contact_birthday"
                      type="date"
                      name="client_contact_birthday"
                      placeholder="Nombre"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('client_contact_birthday') }"
                    >
                    <has-error :form="form" field="client_contact_birthday"></has-error>
                  </div>
                  <!-- CONTACTO - RESPONSABLE POR -->
                  <div class="form-group col-md-3">
                    <input
                      v-model="form.client_contact_responsableFor"
                      type="text"
                      name="client_contact_responsableFor"
                      placeholder="Responsable Por"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('client_contact_responsableFor') }"
                    >
                    <has-error :form="form" field="client_contact_responsableFor"></has-error>
                  </div>
                </div>
                <div class="form-group">
                  <h5>
                    <strong>Acuerdos</strong>
                  </h5>
                </div>
                <div class="row">
                  <!-- ACUERDOS - CONDICIONES DE PAGO -->
                  <div class="form-group col-md-4">
                    <select
                      name="conditions"
                      v-model="form.conditions"
                      id="conditions"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('conditions') }"
                    >
                      <option value>Condiciones de pago</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                    </select>
                    <has-error :form="form" field="conditions"></has-error>
                  </div>
                  <!-- ACUERDOS - LINEA DE CREDITO -->
                  <div class="form-group col-md-4">
                    <select
                      name="credit_line"
                      v-model="form.credit_line"
                      id="credit_line"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('credit_line') }"
                    >
                      <option value>Condiciones de pago</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                    </select>
                    <has-error :form="form" field="credit_line"></has-error>
                  </div>
                  <!-- ACUERDOS - MEDIO DE PAGO PREFERIDO -->
                  <div class="form-group col-md-4">
                    <select
                      name="pay_method"
                      v-model="form.pay_method"
                      id="pay_method"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('pay_method') }"
                    >
                      <option value>Condiciones de pago</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                    </select>
                    <has-error :form="form" field="pay_method"></has-error>
                  </div>
                </div>
                <div class="form-group">
                  <h5>
                    <strong>Deuda</strong>
                  </h5>
                </div>
                <div class="row">
                  <!-- DEUDA - TIPO DE DOCUMENTO -->
                  <div class="form-group col-md-2">
                    <input
                      v-model="form.document_type"
                      type="text"
                      name="document_type"
                      placeholder="Tipo de documento"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('document_type') }"
                    >
                    <has-error :form="form" field="document_type"></has-error>
                  </div>
                  <!-- DEUDA - TIPO DE DOCUMENTO -->
                  <div class="form-group col-md-3">
                    <input
                      v-model="form.document_number"
                      type="text"
                      name="document_number"
                      placeholder="Nro. Documento"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('document_number') }"
                    >
                    <has-error :form="form" field="document_number"></has-error>
                  </div>
                  <!-- DEUDA - FECHA EMISION -->
                  <div class="form-group col-md-3">
                    <input
                      v-model="form.document_emission"
                      type="date"
                      name="document_emission"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('document_emission') }"
                    >
                    <has-error :form="form" field="document_emission"></has-error>
                  </div>
                  <!-- DEUDA - FECHA VENCIMIENTO -->
                  <div class="form-group col-md-2">
                    <input
                      v-model="form.document_expiration"
                      type="date"
                      name="document_expiration"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('document_expiration') }"
                    >
                    <has-error :form="form" field="document_expiration"></has-error>
                  </div>
                  <!-- DEUDA - SALDO DEUDA -->
                  <div class="form-group col-md-2">
                    <input
                      v-model="form.debt"
                      type="text"
                      name="debt"
                      placeholder="Saldo deuda"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('debt') }"
                    >
                    <has-error :form="form" field="debt"></has-error>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-10"></div>
                  <div class="form-group col-md-2">
                    <input
                      v-model="form.total_debt"
                      type="text"
                      name="total_debt"
                      placeholder="TOTAL"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('total_debt') }"
                    >
                    <has-error :form="form" field="total_debt"></has-error>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button v-show="createMode" type="submit" class="btn btn-primary">Create</button>
                <button v-show="editMode" type="submit" class="btn btn-success">Update</button>
                <button type="button" class="btn btn-warning" @click="clean">Limpiar</button>
              </div>
            </form>
          </div>
          <!-- /.card-body -->
          <div class="card-footer"></div>
        </div>
        <!-- /.card -->
        <!-- /.card -->
      </div>
    </div>

    <div v-if="!$gate.isAdminOrAuthor()">
      <not-found></not-found>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      editMode: false,
      createMode: false,
      user_id: "",
      users: {},
      departments: {},
      districts: {},
      provinces: {},

      form: new Form({
        id: "",
        name: "",
        email: "",
        ruc: "",
        sunat_situation: "",
        user_id: "",
        client_adress: "",
        client_department_id: "",
        client_province_id: "",
        client_district_id: "",
        client_contact_name: "",
        client_contact_cellphone: "",
        client_contact_phone: "",
        client_contact_anexo: "",
        client_contact_email: "",
        client_contact_charge: "",
        client_contact_birthday: "",
        client_contact_responsableFor: "",
        conditions: "",
        credit_line: "",
        pay_method: "",
        document_type: "",
        document_number: "",
        document_emission: "",
        document_expiration: "",
        debt: ""
      })
    };
  },
  methods: {
    getDepartment() {
      axios
        .get("api/departments")
        .then(({ data }) => (this.departments = data))
        // .then(response => (this.regions = response.data))
        .catch(error => console.log(error));
    },
    getProvinces() {
      axios
        .get("api/provinces/" + this.form.client_department_id)
        .then(({ data }) => (this.provinces = data))
        // .then(response => (this.provinces = response.data))
        .catch(error => console.log(error));
    },
    getDistricts() {
      axios
        .get("api/districts/" + this.form.client_province_id)
        .then(({ data }) => (this.districts = data))
        // .then(response => (this.provinces = response.data))
        .catch(error => console.log(error));
    },

    createUser() {
      this.$Progress.start();
      this.form
        .post("api/client")
        .then(() => {
          Fire.$emit("AfterCreate");
          toast({
            type: "success",
            title: "User Created in successfully"
          });
          this.$Progress.finish();
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },

    getResults(page = 1) {
      axios.get("api/user?page=" + page).then(response => {
        this.users = response.data;
      });
    },
    updateUser() {
      this.$Progress.start();
      // console.log('Editing data');
      this.form
        .put("api/user/" + this.form.id)
        .then(() => {
          // success
          $("#addNew").modal("hide");
          swal("Updated!", "Information has been updated.", "success");
          this.$Progress.finish();
          Fire.$emit("AfterCreate");
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
    editModal(user) {
      this.editMode = true;
      this.form.reset();
      $("#addNew").modal("show");
      this.form.fill(user);
    },
    newModal() {
      this.editMode = false;
      this.form.reset();
      $("#addNew").modal("show");
    },
    deleteUser(id) {
      swal({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then(result => {
        // Send request to the server
        if (result.value) {
          this.form
            .delete("api/user/" + id)
            .then(() => {
              swal("Deleted!", "Your file has been deleted.", "success");
              Fire.$emit("AfterCreate");
            })
            .catch(() => {
              swal("Failed!", "There was something wronge.", "warning");
            });
        }
      });
    },
    loadUsers() {
      if (this.$gate.isAdminOrAuthor()) {
        axios.get("api/user").then(({ data }) => (this.users = data));
      }
    },

    editModeOn(user) {
      this.createMode = true;
      this.form.reset();
      this.getDepartment();
      axios
        .get("/api/client/" + user.id)
        .then(({ data }) => this.form.fill(data));
    },
    editModeOff() {
      this.editMode = false;
    },

    clean() {
      this.form.reset();
    },
    showForm() {
      this.createMode = true;
      this.form.reset();
      this.getDepartment();
    },
    closeForm() {
      this.createMode = false;
    }
  },
  created() {
    Fire.$on("searching", () => {
      let query = this.$parent.search;
      axios
        .get("api/findUser?q=" + query)
        .then(data => {
          this.users = data.data;
        })
        .catch(() => {});
    });
    this.loadUsers();
    Fire.$on("AfterCreate", () => {
      this.loadUsers();
    });
    //    setInterval(() => this.loadUsers(), 3000);
  }
};
</script>
