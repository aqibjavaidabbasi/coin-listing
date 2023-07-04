<template>
    <Layout>
      <div class="page-header">
        <h3 class="page-title">Network Change</h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <router-link to="/admin/network-change">List</router-link>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
          </ol>
        </nav>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Network Change</h4>
              <ValidationObserver v-slot="{ handleSubmit }" ref="observer">
                <form class="form-sample">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-form-label">Name</label>
                        <ValidationProvider rules="required" v-slot="{ errors }">
                          <input type="text" name="Name" class="form-control" v-model="network.name" placeholder="Name" />
                          <span class="text-sm text-danger">{{ errors[0] }}</span>
                        </ValidationProvider>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="col-form-label">Value</label>
                        <ValidationProvider rules="required" v-slot="{ errors }">
                          <input type="text" name="Value" class="form-control" v-model="network.value" placeholder="Value" />
                          <span class="text-sm text-danger">{{ errors[0] }}</span>
                        </ValidationProvider>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <button type="button" class="btn btn-primary float-end" @click="handleSubmit(saveCoin)">Save</button>
                    </div>
                  </div>
                </form>
              </ValidationObserver>
            </div>
          </div>
        </div>
      </div>
    </Layout>
  </template>
  
  <script>
  import Layout from "../layout";
  import axios from "axios";
  import { ValidationObserver, ValidationProvider } from "vee-validate";
  
  export default {
    name: "Dashboard",
    components: {
      Layout,
      ValidationObserver,
      ValidationProvider,
    },
    data() {
      return {
        network: {
          name: "",
          value: "",
        },
      };
    },
    methods: {
      saveCoin() {
        this.$refs.observer.validate().then((success) => {
          if (success) {
            const formData = new FormData();
            formData.append("name", this.network.name);
            formData.append("value", this.network.value);
  
            axios
              .post(process.env.MIX_API_URL + "/network-create", formData)
              .then((res) => {
                if (res.data.success) {
                  this.network = {
                    name: "",
                    value: "",
                  };
                  this.$refs.observer.reset();
                  this.$swal({
                    position: "top-end",
                    icon: "success",
                    title: "Network Change has been added successfully",
                    target: "#custom-target",
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                    toast: true,
                    background:
                      "linear-gradient(to bottom right, #1ea38f 0%, #5cf9e2 100%)",
                  });
                } else {
                  this.showErrorToast();
                }
              })
              .catch(() => {
                this.showErrorToast();
              });
          }
        });
      },
      showErrorToast() {
        this.$swal({
          position: "top-end",
          icon: "error",
          title: "An error occurred. Please try again later.",
          target: "#custom-target",
          showConfirmButton: false,
          timer: 5000,
          timerProgressBar: true,
          toast: true,
          color: "#dedefd",
          background:
            "linear-gradient(to bottom right, #b51b35 0%, #fd4a68 100%)",
        });
      },
    },
  };
  </script>
  
  <style scoped lang="scss">
  /* Add your custom styles here */
  </style>
  