<template>
  <div class="container">
    <div class="row">
      <div class="col-12 mt-5">
        <div
          class="alert alert-success alert-dismissible fade show"
          role="alert"
          v-for="(msg, index) in message"
          :key="index"
        >
          {{ msg }}
          <button
            type="button"
            class="close"
            data-dismiss="alert"
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">User List</h3>

            <div class="card-tools">
              <!-- Button trigger modal -->
              <button type="button" class="btn btn-success" @click="newModal">
                Add New <i class="fas fa-user-plus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Type</th>
                  <th>Resister At</th>
                  <th>Modify</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(user, index) in users" :key="index">
                  <td>{{ ++index }}</td>
                  <td>{{ user.name | upText }}</td>
                  <td>{{ user.email }}</td>
                  <td>{{ user.type | upText }}</td>
                  <td>{{ user.created_at | dateFormate }}</td>
                  <td>
                    <div>
                      <span @click="editModal(user)" class="text-info pointer"
                        ><i class="fas fa-edit"></i
                      ></span>
                      ||
                      <span
                        class="text-danger pointer"
                        @click="deleteUser(user.id)"
                        ><i class="fas fa-trash-alt"></i
                      ></span>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>

    <!-- create model -->

    <!-- Modal -->
    <div
      class="modal fade"
      id="createModal"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 v-show="editMode" class="modal-title" id="exampleModalLabel">
              Update User Info
            </h5>
            <h5 v-show="!editMode" class="modal-title" id="exampleModalLabel">
              Add User
            </h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editMode ? updateUser() : createUser()">
            <div class="modal-body">
              <div class="form-group">
                <input
                  v-model="form.name"
                  type="text"
                  name="name"
                  placeholder="Name"
                  id="name"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('name') }"
                />
                <has-error :form="form" field="name"></has-error>
              </div>
              <div class="form-group">
                <input
                  v-model="form.email"
                  type="text"
                  name="email"
                  id="email"
                  placeholder="Email"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('email') }"
                />
                <has-error :form="form" field="email"></has-error>
              </div>
              <div class="form-group">
                <textarea
                  v-model="form.bio"
                  name="bio"
                  id="bio"
                  placeholder="Bio"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('bio') }"
                ></textarea>
                <has-error :form="form" field="bio"></has-error>
              </div>

              <div class="form-group">
                <select
                  v-model="form.type"
                  name="type"
                  id="type"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('type') }"
                >
                  <option value="">Select User Role</option>
                  <option value="admin">Admin</option>
                  <option value="user">Standard User</option>
                  <option value="author">Author</option>
                </select>
                <has-error :form="form" field="type"></has-error>
              </div>

              <div class="form-group">
                <input
                  v-model="form.password"
                  type="password"
                  name="password"
                  class="form-control"
                  placeholder="Password"
                  :class="{ 'is-invalid': form.errors.has('password') }"
                />
                <has-error :form="form" field="password"></has-error>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">
                Close
              </button>
              <button v-show="editMode" type="submit" class="btn btn-success">
                Update
              </button>
              <button v-show="!editMode" type="submit" class="btn btn-primary">
                Create
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- end of create model -->
  </div>
</template>
<script>
import { Form, HasError, AlertError } from "vform";
// import VueProgressBar from 'vue-progressbar';

export default {
  data() {
    return {
      editMode: false,
      users: [],
      message: [],
      form: new Form({
        id: "",
        name: "",
        email: "",
        type: "",
        password: "",
        bio: "",
      }),
    };
  },
  methods: {
    newModal() {
      this.editMode = false;
      this.form.reset();
      this.form.clear();
      $("#createModal").modal("show");
    },
    editModal(user) {
      this.editMode = true;
      this.form.reset();
      this.form.clear();
      $("#createModal").modal("show");
      this.form.fill(user);
    },
    loadUsers() {
      axios.get("api/user").then(({ data }) => (this.users = data.data));
    },
    createUser() {
      this.$Progress.start();
      this.form
        .post("api/user")
        .then(() => {
          Fire.$emit("afterCreate");

          $("#createModal").modal("hide");
          Toast.fire({
            icon: "success",
            title: "User Created successfully",
          });
          this.$Progress.finish();
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
    updateUser() {
      this.$Progress.start();
      this.form
        .put('api/user/'+this.form.id)
        .then(() => {
          Fire.$emit("afterCreate");
          $("#createModal").modal("hide");
          Toast.fire({
            icon: "success",
            title: "User Updated successfully",
          });
          this.$Progress.finish();
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
    deleteUser(id) {
      this.$Progress.start();
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          this.form
            .delete("api/user/" + id)
            .then((data) => {
              Swal.fire("Deleted!", "Your Data has been deleted.", "success");
              Fire.$emit("afterCreate");
              this.message = data.data;
              this.$Progress.finish();
            })
            .catch(() => {
              Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Something went wrong!",
              });
              this.$Progress.fail();
            });
        }
      });
    },
  },
  created() {
    this.loadUsers();
    // setInterval(() => this.loadUsers(), 1000);
    Fire.$on("afterCreate", () => {
      this.loadUsers();
      // setTimeout(() => this.loadUsers(), 1000);
    });
  },
};
</script>

