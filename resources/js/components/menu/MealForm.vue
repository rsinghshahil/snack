<template>

    <div class="col-md-10">
        <div class="row" v-if="loader == 1">
            <div  class="lds-ellipsis" style="left: 50%;top: 40%;"><div></div><div></div><div></div><div></div>
            </div>
        </div>
        <div class="row" v-else>
            <div class="col-md-12">
                <div class="col-md-9 form-group">
                    <label for="">Name</label>
                    <input type="text" v-model="meal.name" name="name" class="form-control" id="name" value="">
                </div>
                <div class="col-md-9 form-group">
                    <label for="">Image</label>
                    <input type="file" accept="image/*" name="image" class="" id="image" @change="onFileSelected">
                    <img v-if="preview != null" :src="meal.image" alt="image" style="height:50px;width:70px">
                </div>
                <div class="col-md-9 form-group">
                    <label for="">Price</label>
                    <input type="text" v-model="meal.price" name="price" class="form-control" id="price" value="">
                </div>
                <div class="col-md-9">
                    <button v-if="edit_id != 0" class="btn btn-md btn-info" @click="edit_meal">Update</button>
                    <button v-else class="btn btn-md btn-info" @click="register_meal">Save</button>
                    <button class="btn btn-md btn-info" @click="reset">Clear</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                preview : null,
                loader : 0,
                file: null,
                meal: {
                    name : '',
                    image : null,
                    price : ''
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
        },
        methods:{
            onFileSelected(event){
                let that = this;
                let image = event.target.files[0];
                that.preview_image(image);
                // let form = new FormData();
                // form.append('image', image);
                // that.file = form;
                // that.meal.image = that.file;
            },
            preview_image(image){
                let that = this;
                let reader = new FileReader();
                reader.readAsDataURL(image);
                reader.onload = event => {
                    that.preview = event.target.result;
                    that.meal.image = event.target.result;
                }

            },
            register_meal(){
                let that = this;
                that.loader = 1;
                that.axios.post('/api/meals',{'meal' : that.meal})
                .then((response)=>{
                    if(response.status == 200){
                        that.loader = 0;
                        swal(response.data);
                        that.reset();
                       this.$emit('updated')
                    }
                })
                .catch((error)=>{
                    if(error.response.status == 422){
                        swal("Opps! Something went wrong.", error.response.statusText, "error");
                    }
                })
            },
            edit_meal(){
                let that = this;
                that.loader = 1;
                that.axios.patch('/api/meals/'+that.edit_id,{meal : that.meal})
                .then((response)=>{
                    if(response.status == 200){
                        swal(response.data);
                        that.reset();
                        that.loader = 0;
                        this.$emit('updated')

                    }
                })
                .catch((error)=>{
                    if(error.response.status == 422){
                        swal("Opps! Something went wrong.", error.response.statusText, "error");
                    }
                })
            },
            reset(){
                let that = this;
                that.meal.name = '';
                that.meal.image = null;
                that.meal.price = '';
            }
        },
        watch:{
			edit_id(){
                let that = this;
                that.reset();
				if(that.edit_id != 0 && that.edit_id != null){
					that.axios.get('/api/meals/'+that.edit_id+'/edit')
					.then((response)=>{
						if(response.status == 200){
						that.meal.name = response.data.data.name;
						that.meal.image = response.data.data.image;
                        that.meal.price = response.data.data.price;
                        that.preview = response.data.data.image;
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
.lds-ellipsis {
  display: inline-block;
  position: relative;
  width: 80px;
  height: 80px;
}
.lds-ellipsis div {
  position: absolute;
  top: 33px;
  width: 13px;
  height: 13px;
  border-radius: 50%;
  background: #fdd;
  animation-timing-function: cubic-bezier(0, 1, 1, 0);
}
.lds-ellipsis div:nth-child(1) {
  left: 8px;
  animation: lds-ellipsis1 0.6s infinite;
}
.lds-ellipsis div:nth-child(2) {
  left: 8px;
  animation: lds-ellipsis2 0.6s infinite;
}
.lds-ellipsis div:nth-child(3) {
  left: 32px;
  animation: lds-ellipsis2 0.6s infinite;
}
.lds-ellipsis div:nth-child(4) {
  left: 56px;
  animation: lds-ellipsis3 0.6s infinite;
}
@keyframes lds-ellipsis1 {
  0% {
    transform: scale(0);
  }
  100% {
    transform: scale(1);
  }
}
@keyframes lds-ellipsis3 {
  0% {
    transform: scale(1);
  }
  100% {
    transform: scale(0);
  }
}
@keyframes lds-ellipsis2 {
  0% {
    transform: translate(0, 0);
  }
  100% {
    transform: translate(24px, 0);
  }
}

</style>
