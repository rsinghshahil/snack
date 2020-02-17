<template>
    <div class="container">
        <div class="row justify-content-center">
            <!-- <div class="col-md-10"> -->
                <div class="col-md-12" style="display:flex;margin-bottom:1em">
                    <div class="col-md-6">
                        <span><h3>Customers</h3></span>
                    </div>
                    <div class="col-md-6">
                        <div>
                            <button class="btn btn-success" @click="openmodal" style="float:right">Add User</button>

                        </div>
                    </div>
                </div>
            <!-- </div> -->
            <Modal :modalId="'user-list'">
                <template slot="title">User Registration</template>
                <UserRegisterForm :edit_id="edit_id" @updated='close_modal'></UserRegisterForm>
            </Modal>
        </div>
            <div class="col-md-12">
                <table id="customer" class="table">
                </table>
            </div>
    </div>

</template>


<script>
    import Modal from '../common/Modal.vue'
    import UserRegisterForm from './UserRegisterForm.vue'
    export default {
        components:{Modal, UserRegisterForm},
        data(){
            return{
                edit_id:0
            }
        },
        mounted() {
            let that = this;
        },
        created(){
            let that = this;
            $(document).ready(function(){
                that.initializeDatatable();

            })

        },
        methods:{
            openmodal(){
                $('#user-list').modal('show');
            },
            close_modal(){
                $('#user-list').modal('hide');
                $('#customer').DataTable().ajax.reload();
            },
			initializeDatatable(data=''){
                let that = this;
				$('#customer').DataTable({
					lengthChange: false,
					searching: false,
					processing: true,
					serverSide: false,
					responsive: true,
                    ajax: {
                        url: '/api/users',
                        type : "GET",
                    },
					responsive: false,
					columnDefs: [
						{ responsivePriority: 1, targets: 0 },
						{ responsivePriority: 3, targets: 1 },
						{ responsivePriority: 4, targets: 2 },
                        { responsivePriority: 5, targets: 3 },
                        { responsivePriority: 2, targets: 4 },
						{ responsivePriority: 2, targets: 5 },

         		    ],
					columns: [
						{ data: 'name', title: "Name",width:'3%',targets:0},
                        { data: 'email', title:'Email',width:'4%',targets:1},
                        { data: 'phone', title:'Mobile No',width:'4%',targets:2},
                        { data: 'country', title:'Country',width:'4%',targets:3},
                        { data: 'city', title:'City',width:'4%',targets:4},
                        { data: 'state_name', title:'State Name',width:'4%',targets:5},

						{
                            data: 'status',
                            width:'7%',
                            targets:3,
							title: "Status",
							render: function ( data, type, row ) {
								if(data == 0){
                                    return '<span class="text-xs text-primary">pending...</span>\
                                            <button data-id='+row.id+' class="btn btn-bold btn-sm btn-success activate">Activate</button>\
                                            <button data-id='+row.id+' class="btn btn-bold btn-sm btn-danger terminate">Terminate</button>\
                                        ';
								}else if(data == 1){
                                    return '<button data-id='+row.id+' class="btn btn-bold btn-sm btn-danger terminate">Terminate</button>';
								}else{
									return '<button data-id='+row.id+' class="btn btn-bold btn-sm btn-success activate">Active</button>';
								}
                     		}
                        },
						{
                            title: "Action",
                            width:'6%',
                            targets:4,
							sortable: false,
							autoHide: false,
							overflow: 'visible',
							render: function(data, type, row) {
								return '\
										<div class="dropdown">\
											<a href="javascript:void(0);" class="btn btn-sm btn-clean btn-warning" data-toggle="dropdown">\
                                                <i class="flaticon-more-1"></i>\
                                                Options\
											</a>\
											<div class="dropdown-menu dropdown-menu-left">\
												<ul class="kt-nav">\
													<li class="kt-nav__item">\
														<a href="javascript:void(0);" data-id='+row.id+' class="kt-nav__link customer-edit">\
															<i class="kt-nav__link-icon flaticon-edit-1"></i>\
															<span class="kt-nav__link-text">Edit</span>\
														</a>\
													</li>\
													<li class="kt-nav__item">\
														<a href="javascript:void(0);" data-id='+row.id+' class="kt-nav__link customer-delete">\
															<i class="kt-nav__link-icon flaticon2-trash"></i>\
															<span class="kt-nav__link-text">Delete</span>\
														</a>\
													</li>\
												</ul>\
											</div>\
										</div>\
								';
							}
						}
					],
					order: [[ 1, 'asc' ]],
					"drawCallback": function() {
						$(".customer-edit").click(function() {
							$("#user-list").modal('show');
							let id = $(this).data("id");
							that.edit_id = id;
                        });
						$(".activate").click(function() {
							let id = $(this).data("id");
                            that.axios.get('/api/users/activate/'+id)
                            .then((response) => {
                                if(response.status == 200){
                                    swal(response.data, {icon: "success",timer: 1000, buttons:false});
                                    $("#customer").DataTable().ajax.reload();
                                }
                            })
                        });
						$(".terminate").click(function() {
							let id = $(this).data("id");
                            that.axios.get('/api/users/terminate/'+id)
                            .then((response) => {
                                if(response.status == 200){
                                    swal(response.data, {icon: "success",timer: 1000, buttons:false});
                                    $("#customer").DataTable().ajax.reload();
                                }
                            })
						});
						$(".customer-delete").click(function() {
							swal({
								title: "Are you sure?",
								text: "You want to delete unit!",
								icon: "warning",
								buttons: true,
								dangerMode: true,
                     		})
							.then((willDelete) => {
								if (willDelete) {
									let id = $(this).data("id");
									if (id!='') {
										that.axios.delete('/api/users/'+id)
										.then((response)=>{
											if(response.status == 200){
												swal(response.data, {icon: "success",timer: 1000, buttons:false});
												$("#customer").DataTable().ajax.reload();
											}
										})
										.catch((error)=>{
											if(error.response.status == 409){
												swal("Opps! Something went wrong.", error.response.statusText, "error");
											}
										});
									}
								}
							});
						});
					}
				});
			},
        }
    }
</script>
