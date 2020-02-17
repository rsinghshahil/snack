<template>
    <div class="container">
        <div class="row justify-content-center">
                <div class="col-md-12" style="display:flex;margin-bottom:1em">
                    <div class="col-md-6">
                        <span><h3> Broadcast Daily Meal </h3></span>
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
                <table id="meals" class="table">
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
                $('#meals').DataTable().ajax.reload();
            },
            callsubway(){
                let that = this;
                that.axios.post('/api/broadcast-meal/makecall')
                .then((response) => {

                    alert('asdf');
                })
                .catch((error) => {
                    swal(error.response.statusText,error.response.data,{icon:'error'});
                })
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
                        url: '/api/broadcast-meal',
                        type : "GET",
                    },
					responsive: false,
					columnDefs: [
						{targets: 0,
							orderable: false,
							defaultContent: '',
							className: 'select-checkbox',
							targets:   0,
							responsivePriority: 1,
                            checkboxes:{
                                selectRow: true
                            },
						},
                        { responsivePriority: 2, targets: 1 },

						{ responsivePriority: 7, targets: 2 },
						{ responsivePriority: 6, targets: 3 },
                        { responsivePriority: 5, targets: 4 },

                        { responsivePriority: 4, targets: 5 },
                        { responsivePriority: 3, targets: 6 },
						{ responsivePriority: 8, targets: 7 },
         		    ],
					columns: [
						{ data: 'select1', title: "Check", width: "2%",targets:0},
						{ data: 'name', title: "Name",width:'3%',targets:1},
                        { data: 'price', title:'Price',width:'4%',targets:2},
                        {
                        data: 'image',
                         title:'Image',
                         width:'5%',
                         targets:3,
                            render:function(data, type, row){
                                return "<img src='"+data+"' alt='img' style='height:70px;width:90px'>"
                            },
                         },
						{
                            data: 'mstatus',
                            width:'7%',
                            targets:4,
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
                            targets:5,
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
														<a href="javascript:void(0);" style="curson:no-drop" data-id='+row.id+' class="kt-nav__link meal-edit">\
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
                        },
						{
							title: "Broadcast",
                            width:'3%',
                            targets:6,
							render: function ( data, type, row ) {
                                if(row.bstatus == 1){
                                    return '\
                                    <button data-id='+row.id+' data-date='+ row.bcreated_at +' class="btn btn-bold btn-sm btn-success opened">Opened</button>\
                                    <button data-id='+row.id+' data-date='+ row.bcreated_at +' class="btn btn-bold btn-sm btn-danger close-meal">Close</button>'
                                    ;
                                }else{
                                    return '<button data-id='+row.id+' data-date='+ row.bcreated_at +' class="btn btn-bold btn-sm btn-danger broadcast">Open</button>';
                                }
                     		}
                        },
						{
							title: "Links",
                            width:'3%',
                            targets:6,
							render: function ( data, type, row ) {
                                // if(row.bstatus == 1){
                                    return '<button data-id='+row.id+' class="btn btn-bold btn-sm btn-success generate">Generate Link</button>';
                                // }else{
                                //     return '<button data-id='+row.id+' data-date='+ row.bcreated_at +' class="btn btn-bold btn-sm btn-danger broadcast">Open</button>';
                                // }
                     		}
                        },
                    ],
					select: {
						// style:    'multi',
                        selector: 'td:first-child'
					},
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
                                    $("#customer").DataTable().ajax.reload();
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
						$(".opened").click(function() {
                            swal('The meal has already been Opened !', {icon: "info",timer: 1800, buttons:false});

                        });
						$(".broadcast").click(function() {
                            if(that.selected_row_ids.length == 0){
                                swal('Please select the meal before opening it !', {icon: "warning",timer: 2000, buttons:false});
                                return;
                            }
                            that.axios.get('/api/broadcast-meal/'+that.selected_row_ids)
                            .then((response) => {
                                if(response.status == 200){
                                    swal(response.data, {icon: "success",timer: 1000, buttons:false});
                                    that.selected_row_ids = [];
                                    $("#meals").DataTable().ajax.reload();
                                }
                            })
                        });
						$(".close-meal").click(function() {
                            if(that.selected_row_ids.length == 0){
                                swal('Please select the meal before closing it !', {icon: "warning",timer: 2000, buttons:false});
                                return;
                            }
                            that.axios.get('/api/broadcast-meal/'+that.selected_row_ids+'/edit')
                            .then((response) => {
                                if(response.status == 200){
                                    swal(response.data, {icon: "success",timer: 1000, buttons:false});
                                    that.selected_row_ids = [];
                                    $("#meals").DataTable().ajax.reload();
                                }
                            })
                        });
						$(".generate").click(function() {
							let id = $(this).data("id");
                            that.axios.get('/api/meal_link/'+id)
                            .then((response) => {
                                if(response.status == 200){
                                    swal(response.data, {icon: "success",timer: 1000, buttons:false});
                                    $("#meals").DataTable().ajax.reload();
                                }
                            })
                            .catch((error) => {
                                if(error.response.status == 304){
                                    swal('The link has already been generated. Thanks!', {icon: "warning",timer: 2000, buttons:false});
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
                        // These lines of code are for selecting a row
						$("#meals").DataTable().on('select', function ( e, dt, type, indexes ) {
							if ( type === 'row' ) {
                                that.selected_row_ids = [];
                                let id = $("#meals").DataTable().rows( indexes ).data().pluck( 'id' )[0];
								that.selected_row_ids.push(id);
							}
						});

						$("#meals").DataTable().on( 'deselect', function ( e, dt, type, indexes ) {
							if ( type === 'row' ) {
                                that.selected_row_ids = [];
                                let id = $("#meals").DataTable().rows( indexes ).data().pluck( 'id' )[0];
								if (that.selected_row_ids.length != 0){
									let index = that.selected_row_ids.indexOf(id);
									that.selected_row_ids.splice(index,1)
								}
							}
						});
					}
				});
			},
        }
    }
</script>
