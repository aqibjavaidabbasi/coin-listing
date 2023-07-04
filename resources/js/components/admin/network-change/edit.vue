<template>
    <Layout>
      <div class="page-header">
        <h3 class="page-title">Edit Network</h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <router-link to="/admin/blogs">List</router-link>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
          </ol>
        </nav>
      </div>
      <div class="row">
        <div class="col-12">
          <ValidationObserver v-slot="{ handleSubmit }" ref="observer">
            <form class="form-sample">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-form-label">Name</label>
                    <ValidationProvider rules="required" v-slot="{ errors }">
                      <input
                        type="text"
                        name="Name"
                        class="form-control"
                        v-model="network.name"
                        placeholder="Name"
                      />
                      <span class="text-sm text-danger">{{ errors[0] }}</span>
                    </ValidationProvider>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-form-label">Value</label>
                    <ValidationProvider rules="required" v-slot="{ errors }">
                      <input
                        type="text"
                        name="Value"
                        class="form-control"
                        v-model="network.value"
                        placeholder="Value"
                      />
                      <span class="text-sm text-danger">{{ errors[0] }}</span>
                    </ValidationProvider>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <button
                    type="button"
                    class="btn btn-primary float-end"
                    @click="handleSubmit(updateNetwork)"
                  >
                    Save
                  </button>
                </div>
              </div>
            </form>
          </ValidationObserver>
        </div>
      </div>
    </Layout>
  </template>
  
  <script>
  import Layout from "../layout";
  import { ValidationObserver, ValidationProvider } from "vee-validate";
  import axios from "axios";
  
  export default {
    name: "Edit",
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
    created() {
      this.fetchNetworkData();
    },
    methods: {
      updateNetwork() {
        const networkId = this.$route.params.id;
        this.$refs.observer.validate().then((success) => {
          if (success) {
            const formData = {
              name: this.network.name,
              value: this.network.value,
            };
  
            axios
              .post(`/api/networks-update/${networkId}`, formData)
              .then((res) => {
                if (res.data.success) {
                  this.showSuccessMessage("Network updated successfully");
                } else {
                  this.showErrorMessage("An error occurred. Please try again later.");
                }
              })
              .catch((err) => {
                this.showErrorMessage("An error occurred. Please try again later.");
              });
          }
        });
      },
      fetchNetworkData() {
        const networkId = this.$route.params.id;
        axios
          .get(`/api/networks-edit/${networkId}`)
          .then((res) => {
            if (res.data.success) {
              const networkData = res.data.data;
              this.network.name = networkData.name;
              this.network.value = networkData.value;
            } else {
              this.showErrorMessage("An error occurred. Please try again later.");
            }
          })
          .catch((err) => {
            this.showErrorMessage("An error occurred. Please try again later.");
          });
      },
      showSuccessMessage(message) {
        this.$swal({
          position: "top-end",
          icon: "success",
          title: message,
          target: "#custom-target",
          showConfirmButton: false,
          timer: 5000,
          timerProgressBar: true,
          toast: true,
          background: "linear-gradient(to bottom right, #1ea38f 0%, #5cf9e2 100%)",
        });
      },
      showErrorMessage(message) {
        this.$swal({
          position: "top-end",
          icon: "error",
          title: message,
          target: "#custom-target",
          showConfirmButton: false,
          timer: 5000,
          timerProgressBar: true,
          toast: true,
          color: "#dedefd",
          background: "linear-gradient(to bottom right, #b51b35 0%, #fd4a68 100%)",
        });
      },
    },
  };
  </script>
  