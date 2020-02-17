<template>
    <div class="container">
        <div class="row justify-content-center">
            <!-- <div class="col-md-10"> -->
                <div class="col-md-12" style="display:flex;margin-bottom:1em">
                    <div class="col-md-6">
                        <span><h3>Meals</h3></span>
                    </div>
                    <div class="col-md-6">
                        <div>
                            <button class="btn btn-success" @click="openmodal" style="float:right">Add Meal</button>

                        </div>
                    </div>
                </div>
            <!-- </div> -->
            <Modal :modalId="'meal-list'">
                <template slot="title">New Meal</template>
                <MealForm :edit_id="edit_id" @updated='close_modal'></MealForm>
            </Modal>

        </div>
            <div class="col-md-12">
                <table id="meals" class="table">
                </table>
            </div>
    </div>

</template>


<script>
    import Modal from '../common/Modal.vue'
    import MealForm from './MealForm.vue'
    export default {
        components:{Modal, MealForm},
        data(){
            return{
                loader : 0,
                edit_id: 0
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
                $('#meal-list').modal('show');
            },
            close_modal(){
                let that = this;
                $('#meal-list').modal('hide');
                that.edit_id = 0;
                $('#meals').DataTable().ajax.reload();
            },
			initializeDatatable(data=''){
                let that = this;
				$('#meals').DataTable({
					lengthChange: false,
					searching: false,
					processing: true,
					serverSide: false,
					responsive: true,
                    ajax: {
                        url: '/api/meals',
                        type : "GET",
                    },
					responsive: false,
					columnDefs: [
						{ responsivePriority: 1, targets: 0 },
						{ responsivePriority: 3, targets: 1 },
						{ responsivePriority: 5, targets: 2 },
                        { responsivePriority: 4, targets: 3 },
						{ responsivePriority: 2, targets: 4 },
         		    ],
					columns: [
						{ data: 'name', title: "Name",width:'3%',targets:0},
                        { data: 'price', title:'Price',width:'4%',targets:1},
                        {
                        data: 'image',
                         title:'Image',
                         width:'5%',
                         targets:2,
                            render:function(data, type, row){
                                return "<img src='"+data+"' alt='img' style='height:70px;width:90px'>"
                            },
                         },
						{
                            data: 'status',
                            width:'7%',
                            targets:3,
							title: "Status",
							render: function ( data, type, row ) {
								if(data == 0){
                                    return '<span class="text-xs text-primary">pending meal...</span>\
                                            <button data-id='+row.id+' class="btn btn-bold btn-sm btn-success available">Available</button>\
                                            <button data-id='+row.id+' class="btn btn-bold btn-sm btn-danger unavailable">H O L D</button>\
                                        ';
								}else if(data == 1){
                                    return '<button data-id='+row.id+' class="btn btn-bold btn-sm btn-danger unavailable">H O L D</button>';
								}else{
									return '<button data-id='+row.id+' class="btn btn-bold btn-sm btn-success available">Available</button>';
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
														<a href="javascript:void(0);" data-id='+row.id+' class="kt-nav__link meal-edit">\
															<i class="kt-nav__link-icon flaticon-edit-1"></i>\
															<span class="kt-nav__link-text">Edit</span>\
														</a>\
													</li>\
													<li class="kt-nav__item">\
														<a href="javascript:void(0);" data-id='+row.id+' class="kt-nav__link meal-delete">\
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
						$(".meal-edit").click(function() {
							$("#meal-list").modal('show');
							let id = $(this).data("id");
							that.edit_id = id;
                        });
						$(".available").click(function() {
							let id = $(this).data("id");
                            that.axios.get('/api/meals/activate/'+id)
                            .then((response) => {
                                if(response.status == 200){
                                    swal(response.data, {icon: "success",timer: 1000, buttons:false});
                                    $("#meals").DataTable().ajax.reload();
                                }
                            })
                        });
						$(".unavailable").click(function() {
							let id = $(this).data("id");
                            that.axios.get('/api/meals/deactivate/'+id)
                            .then((response) => {
                                if(response.status == 200){
                                    swal(response.data, {icon: "success",timer: 1000, buttons:false});
                                    $("#meals").DataTable().ajax.reload();
                                }
                            })
						});
						$(".meal-delete").click(function() {
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
										that.axios.delete('/api/meals/'+id)
										.then((response)=>{
											if(response.status == 200){
												swal(response.data, {icon: "success",timer: 1000, buttons:false});
												$("#meals").DataTable().ajax.reload();
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
