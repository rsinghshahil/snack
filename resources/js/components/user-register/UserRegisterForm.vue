<template>
    <div class="col-md-10">
        <!-- <div class="card"> -->
            <!-- <div class="card-header">User Registration</div> -->
            <!-- <div class="card-body"> -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-9 form-group">
                            <label for="">Name</label>
                            <input type="text" v-model="register.name" name="name" class="form-control" id="name" value="">
                        </div>
                        <div class="col-md-9 form-group">
                            <label for="">E-mail Address</label>
                            <input :readonly="edit_id != 0?'true':'false'" type="email" v-model="register.email" name="email" class="form-control" id="email" value="">
                        </div>
                        <div class="col-md-9 form-group">
                            <label for="">Mobile Number</label>
                            <input type="text" v-model="register.mobile" name="mobile" class="form-control" id="mobile" value="">
                        </div>
                        <div v-if="edit_id == 0" class="col-md-9 form-group">
                            <label for="">Password</label>
                            <input type="password" v-model="register.password" name="password" class="form-control" id="password" value="">
                        </div>
                        <div v-if="edit_id == 0" class="col-md-9 form-group">
                            <label for="">Confirm Password</label>
                            <input type="password" v-model="register.password_confirmation" name="password_confirmation" class="form-control" id="password_confirmation" value="">
                        </div>
                        <div class="col-md-9">
                            <button v-if="edit_id != 0" class="btn btn-md btn-info" @click="edit_user">Update</button>
                            <button v-else class="btn btn-md btn-info" @click="register_user">Register</button>
                            <button class="btn btn-md btn-info" @click="reset">Clear</button>
                        </div>
                    </div>
                </div>

            <!-- </div> -->
        <!-- </div> -->
    </div>
</template>

<script>
    export default {
        data(){
            return{
                register: {
                    name:'',
                    email:'',
                    mobile:'',
                    password:'',
                    password_confirmation:''
                }
            }
        },
        props:{
            edit_id:{
                type:Number,
                default:0
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            register_user(){
                let that = this;
                that.axios.post('/api/users',{register : that.register})
                .then((response)=>{
                    if(response.status == 200){
                        swal(response.data);
                        that.reset();
                    }
                })
                .catch((error)=>{
                    if(error.response.status == 422){
                        swal("Opps! Something went wrong.", error.response.statusText, "error");
                    }
                })
            },
            edit_user(){
                let that = this;
                that.axios.patch('/api/users/'+that.edit_id,{register : that.register})
                .then((response)=>{
                    if(response.status == 200){
                        swal(response.data);
                       this.$emit('updated', 1)
                        that.reset();
                    }
                })
                .catch((error) =>{

                })

            },
            reset(){
                let that = this;
                that.register.name = '';
                that.register.email = '';
                that.register.mobile = '';
                that.register.password = '';
                that.register.password_confirmation = '';
            }
        },
        watch:{
			edit_id(){
                let that = this;
                that.reset();
				if(that.edit_id != 0 && that.edit_id != null){
					that.axios.get('/api/users/'+that.edit_id+'/edit')
					.then((response)=>{
						if(response.status == 200){
						that.register.name = response.data.data.name;
						that.register.email = response.data.data.email;
						that.register.mobile = 123123;
						}
					})
					.catch((error)=>{
						if(error.response.status == 409){
							swal("Opps! Something went wrong.", error.response.statusText, "error");
						}
					})
				}
			}
        }

    }
</script>

<style>

</style>
