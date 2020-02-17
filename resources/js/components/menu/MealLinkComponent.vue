<template>
    <div class="container">
        <div class="row justify-content-center">
                <div class="col-md-12" style="display:flex;margin-bottom:1em">
                    <div class="col-md-6">
                        <span><h3> Meal Links </h3></span>
                    </div>
                    <div class="col-md-6">
                        <div>
                            <button class="btn btn-primary" @click="callsubway" style="float:right"> Call Subway</button>

                        </div>
                    </div>
                </div>

            <!-- <Modal :modalId="'meal-list'">
                <template slot="title">New Meal</template>
                <MealForm :edit_id="edit_id" @updated='close_modal'></MealForm>
            </Modal> -->

        </div>
            <div class="col-md-12">
                <table id="meal_link" class="table">
                </table>
            </div>
    </div>

</template>


<script>
    // import Modal from '../common/Modal.vue'
    // import MealForm from './MealForm.vue'
    export default {
        // components:{Modal, MealForm},
        data(){
            return{
                loader : 0,
                edit_id: 0,
                selected_row_ids:[]
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
                $('#meal_link').DataTable().ajax.reload();
            },
            callsubway(){
                let that = this;
                alert('asdf');
            },
			initializeDatatable(data=''){
                let that = this;
				$('#meal_link').DataTable({
					lengthChange: false,
					searching: false,
					processing: true,
					serverSide: false,
					responsive: true,
                    ajax: {
                        url: '/api/meal_link',
                        type : "GET",
                    },
					responsive: false,
					columnDefs: [

                        { responsivePriority: 1, targets: 0 },
						{ responsivePriority: 4, targets: 1 },
                        { responsivePriority: 2, targets: 2 },
						{ responsivePriority: 3, targets: 3 },

         		    ],
					columns: [
						{ data : 'name', title : "Name", width :'3%', targets : 0},
                        {
                        data: 'image',
                            title : 'Image',
                            width : '5%',
                            targets : 1,
                            render: function(data, type, row){
                                return "<img src='"+data+"' alt='img' style='height:60px;width:80px'>"
                            },
                        },
						{ data : 'meal_link', title : "Links", width :'5%', targets : 2},
						{
                            title: "Action",
                            width:'5%',
                            targets:3,
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
													<li class="kt-nav__item" style="curson:no-drop">\
														<a href="javascript:void(0);" style="cursor:no-drop" data-id='+row.id+' class="kt-nav__link link-edit">\
															<i class="kt-nav__link-icon flaticon-edit-1"></i>\
															<span class="kt-nav__link-text">Edit</span>\
														</a>\
													</li>\
													<li class="kt-nav__item">\
														<a href="javascript:void(0);" data-id='+row.id+' class="kt-nav__link link-delete">\
															<i class="kt-nav__link-icon flaticon2-trash"></i>\
															<span class="kt-nav__link-text">Delete</span>\
														</a>\
													</li>\
												</ul>\
											</div>\
										</div>\
								';
							}
                        },
                    ],
					// select: {
                    //     selector: 'td:first-child'
					// },
					order: [[ 1, 'asc' ]],
					"drawCallback": function() {
						// $(".meal-edit").click(function() {
						// 	$("#meal-list").modal('show');
						// 	let id = $(this).data("id");
						// 	that.edit_id = id;
                        // });
						$(".link-delete").click(function() {
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
										that.axios.delete('/api/meal_link/'+id)
										.then((response)=>{
											if(response.status == 200){
												swal(response.data, {icon: "success",timer: 1000, buttons:false});
												$("#meal_link").DataTable().ajax.reload();
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
