<template>
    <form @submit.prevent="submit">
        <div class="form-group">
            <label >Name</label>
            <input type="text" class="form-control" v-model="name" />
        </div>
    
        <div class="form-group">
            <label >E-mail</label>
            <input type="email" class="form-control" v-model="email" />
        </div>
    
        <div class="form-group">
            <label >Message</label>
            <textarea class="form-control" rows="5" v-model="message"></textarea>
        </div>
        <button class="btn btn-primary" v-on:click="submit()">Send message</button>
        <div v-if="success" class="alert alert-success mt-3">
            Message sent!
        </div>
    </form>
</template>

<script>
    export default {
      data() {
        return {
          data:{
            name:'',
            email: '',
            message:''
          },
          errors: {},
          success: false,
          loaded: true,
        }
      },
      methods: {
        submit() {
          if (this.loaded) {
            this.loaded = false;
            this.success = false;
            this.errors = {};
            console.log(this.data);
            axios.post('/submit', this.data).then(response => {
              this.fields = {}; //Clear input fields.
              this.loaded = true;
              this.success = true;
            }).catch(error => {
              this.loaded = true;
              if (error.response.status === 422) {
                this.errors = error.response.data.errors || {};
              }
            });
          }
        },
      },
    }
</script>    