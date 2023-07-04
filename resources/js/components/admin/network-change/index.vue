<template>
    <Layout>
      <div class="page-header">
        <h3 class="page-title">Network</h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">List</li>
          </ol>
        </nav>
      </div>
      <div class="row">
        <div class="col">
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Value</th>
                  <th>Created at</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="network in networks" :key="network.id" :id="'networkRow_' + network.id">
                  <td>{{ network.id }}</td>
                  <td>
                    <h6 class="mb-1 text-light">{{ network.name }}</h6>
                  </td>
                  <td>
                    <h6 class="mb-1 text-light">{{ network.value }}</h6>
                  </td>
                  <td>
                    <h6 class="mb-1 text-light">{{ network.created_at }}</h6>
                  </td>
                  <td>
                    <li class="nav-item dropdown list-style">
                      <a class="nav-link" id="profileDropdown" href="#" data-bs-toggle="dropdown">
                        <div class="navbar-profile action-view">
                          <p class="mb-0 d-none d-sm-block navbar-profile-name text-white">Action</p>
                          <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                        </div>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list dropdown-action" aria-labelledby="profileDropdown">
                        <router-link :to="'/admin/networks/edit/' + network.id" class="list-style">
                          <p class="p-1 mb-0 text-center list-style">Edit</p>
                        </router-link>
                        <div class="dropdown-divider"></div>
                        <p class="p-1 mb-0 text-center" @click.prevent="deleteNetwork(network.id)">Delete</p>
                        <div class="dropdown-divider"></div>
                      </div>
                    </li>
                  </td>
                </tr>
              </tbody>
              <tfoot></tfoot>
            </table>
          </div>
        </div>
      </div>
    </Layout>
  </template>
  
  <script>
  import axios from 'axios'; // Import Axios library
  
  import Layout from '../layout';
  
  export default {
    name: 'NetworkList',
    data() {
      return {
        networks: []
      };
    },
    components: {
      Layout
    },
    created() {
      this.getNetworks(); // Renamed to a more appropriate method name
    },
    methods: {
      getNetworks() {
        axios
          .get('/api/networks') // Assuming the endpoint is '/api/networks'
          .then(response => {
            console.log(response);
            this.networks = response.data.data; // Assign the response data to networks
          })
          .catch(error => {
            console.log(error);
          });
      },
      deleteNetwork(networkId) {
        if (!confirm('Are you sure you want to delete this network?')) {
          return;
        }
  
        axios
          .delete('/api/networks/' + networkId) // Assuming the endpoint is '/api/networks/{id}'
          .then(response => {
            if (response.data.success) {
              // Remove the table row
              const tableRow = document.getElementById('networkRow_' + networkId);
              if (tableRow) {
                tableRow.remove();
              }
  
              // Display success message
              this.$swal({
                position: 'top-end',
                icon: 'success',
                title: 'Network deleted successfully!',
                target: '#custom-target',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                toast: true,
                background: 'linear-gradient(to bottom right, #1ea38f 0%, #5cf9e2 100%)'
              });
            } else {
              this.$swal({
                position: 'top-end',
                icon: 'error',
                title: 'An error occurred. Please try again later.',
                target: '#custom-target',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                toast: true,
                color: '#dedefd',
                background: 'linear-gradient(to bottom right, #b51b35 0%, #fd4a68 100%)'
              });
            }
          })
          .catch(error => {
            this.$swal({
              position: 'top-end',
              icon: 'error',
              title: 'An error occurred. Please try again later.',
              target: '#custom-target',
              showConfirmButton: false,
              timer: 5000,
              timerProgressBar: true,
              toast: true,
              color: '#dedefd',
              background: 'linear-gradient(to bottom right, #b51b35 0%, #fd4a68 100%)'
            });
          });
      }
    }
  };
  </script>
  