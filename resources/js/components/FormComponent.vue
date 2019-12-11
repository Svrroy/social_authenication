<template>
    <form @submit.prevent="submit">
        <div class="form-group">
            <label >Name</label>
            <input type="text" class="form-control" v-model="data.name" />
        </div>
    
        <div class="form-group">
            <label >E-mail</label>
            <input type="email" class="form-control" v-model="data.email" />
            <p v-if = "!validEmail" class = "text-danger">invalid already exist</p>
        </div>
    
        <div class="form-group">
            <label >Phone Number</label>
            <input class="form-control" v-model="data.phone_number">
            <p v-if = "duplicate_phone_number" class = "text-danger">phone number already exist</p>
        </div>
         <div class="form-group">
            <label >Password</label>
            <input class="form-control" type = 'password' v-model="data.password">
        </div>
        <button class="btn btn-primary" v-on:click="submit()">Submit</button>
        <div v-if="success" class="alert alert-success mt-3">
            Successfully saved
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
            phone_number:'',
            password:''
          },
          errors: {},
          success: false,
          loaded: true,
          validEmail:true,
          duplicate_phone_number:false,

        }
      },
      methods: {
        validateEmail(){
            if (/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/.test(this.email)) {
                this.validEmail = true;
                this.duplicate_phone_number = false;
            };
        },
        submit() {
          if (this.loaded) {
            this.loaded = false;
            this.success = false;
            this.errors = {};   
            axios.post('/submit', this.data).then(response => {
             if(response.data.duplicate_phone_number !== 1){
                this.data = {}; //Clear input fields.
                this.loaded = true;
                this.success = true;
                this.duplicate_phone_number = false;
             }
             this.duplicate_phone_number = true;
              
            }).catch(error => {
              this.loaded = true;
            });
          }
        },
      },
    }
</script>    