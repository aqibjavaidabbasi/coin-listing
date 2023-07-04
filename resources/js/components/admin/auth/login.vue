<template>
  <div class="container-fluid page-body-wrapper full-page-wrapper" style="height:100vh">
    <div class="row w-100 m-0" style="height:100vh">
      <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
        <div class="card col-lg-4 mx-auto">
          <div class="card-body px-5 py-5">
            <h3 class="card-title text-left mb-3">Login</h3>
            <form @submit="login">
              <div class="form-group">
                <label>Username or email *</label>
                <input type="text" class="form-control p_input" v-model="credentials.email" />
              </div>
              <div class="form-group">
                <label>Password *</label>
                <input type="password" class="form-control p_input" v-model="credentials.password" />
              </div>
              <div class="form-group d-flex align-items-center mt-2 justify-content-between">
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" /> Remember me
                  </label>
                </div>
                <a href="#" class="forgot-pass">Forgot password</a>
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-primary btn-block enter-btn">Login</button>
                <div v-if="errorMessage" class="text-danger mt-2">{{ errorMessage }}</div>
                <!-- Display the error message -->
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- row ends -->
  </div>
</template>

<script>


export default {

  name: 'AdminLogin',
  data() {
    return {
      credentials: {
        email: '',
        password: '',
      },
      errorMessage: '', // Add a property to store the error message
    };
  },
  methods: {
    login(event) {
      event.preventDefault();
      // Make the API request to the login endpoint
      // You can use Axios or any other library to send the POST request
      axios
        .post('/api/login', this.credentials)
        .then(response => {
          const token = response.data.token;
          // Save the token to local storage or store it in Vuex for further use
          localStorage.setItem('token', token); // Example of saving the token to local storage
          // Redirect the user to the desired page
          this.$router.push('/admin/dashboard'); 
        })
        .catch(error => {
          // Handle the error, show error message, etc.
          if (error.response.status === 401) {
            this.errorMessage = 'Invalid credentials. Please try again.'; // Set the error message
          } else {
            this.errorMessage = 'An error occurred. Please try again later.';
          }
        });
    },
  },


  created() {
    console.log('admin component');
  },
};
</script>
