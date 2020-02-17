<template>
    <div class="container">
        <div class="row justify-content-center">
            <!-- <div class="col-md-10"> -->
                <div class="col-md-12" style="display:flex;margin-bottom:1em">
                    <div class="col-md-6">
                        <span><h3> Daily Meal Orders </h3></span>
                    </div>
                </div>
            <!-- </div> -->
        </div>
            <div class="col-md-12">
                <table id="orders" class="table">
                </table>
            </div>
    </div>

</template>


<script>
    export default {
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
                $('#orders').DataTable().ajax.reload();
            },
			initializeDatatable(data=''){
                let that = this;
				$('#orders').DataTable({
					lengthChange: false,
					searching: false,
					processing: true,
					serverSide: false,
					responsive: true,
                    ajax: {
                        url: '/api/manage_orders',
                        type : "GET",
                    },
					responsive: true,
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
                        { responsivePriority: 3, targets: 1 },
                        { responsivePriority: 4, targets: 2 },

						{ responsivePriority: 5, targets: 3 },
                        { responsivePriority: 6, targets: 4 },
                        { responsivePriority: 7, targets: 5 },
                        { responsivePriority: 8, targets: 6 },
						{ responsivePriority: 9, targets: 7 },
						{ responsivePriority: 10, targets: 8 },
						{ responsivePriority: 11, targets: 9 },
						{ responsivePriority: 12, targets: 10},
						{ responsivePriority: 2, targets: 11},
						{ responsivePriority: 1, targets: 12},
         		    ],
					columns: [
						{ data: 'select1', title: "Check", width: "2%",targets:0},
						{ data: 'm_name', title: "Meal",width:'2%',targets:1},
                        { data: 'user_name', title:'Customer',width:'2%',targets:2},
                        { data: 'bt_name', title:'BreadType',width:'2%',targets:3},
                        { data: 'bs_size', title:'Size(cm)',width:'2%',targets:4},
                        { data: 'fl_name', title:'Taste',width:'2%',targets:5},
                        { data: 'vg_name', title:'Vegies',width:'2%',targets:6},
                        { data: 'sc_name', title:'Sauce',width:'2%',targets:7},
						{
                            data: 'extras',
                            width:'8%',
                            targets: 8,
							title: "Extras",
							render: function ( data, type, row ) {
								if(data == 100){
                                    return
                                        '<button data-id='+row.id+' class="btn btn-bold btn-sm btn-warning">Extra Bacon</button>';
								}else if(data == 200){
                                    return '<button data-id='+row.id+' class="btn btn-bold btn-sm btn-warning">Double Meat</button>';
								}else{
									return '<button data-id='+row.id+' class="btn btn-bold btn-sm btn-warning">Extra Cheese</button>';
								}
                     		}
                        },
						{
                            data: 'non_baked',
                            width:'8%',
                            targets: 9,
							title: "Baking",
							render: function ( data, type, row ) {
                                console.log(data)
								if(data == 101){
                                    return '<button data-id='+row.id+' class="btn btn-bold btn-sm btn-warning">Baked</button>';
                                }else{
									return '<button data-id='+row.id+' class="btn btn-bold btn-sm btn-warning">Non-Baked</button>';
								}
                     		}
                        },
                        { data: 'total_cost', title:'Cost',width:'2%',targets:10},
                        // {
                        //     data: 'image',
                        //     title:'Image',
                        //     width:'5%',
                        //     targets:3,
                        //     render:function(data, type, row){
                        //         return "<img src='"+data+"' alt='img' style='height:70px;width:90px'>"
                        //     },
                        //  },
						{
                            data: 'status',
                            width:'5%',
                            targets: 11,
							title: "Status",
							render: function ( data, type, row ) {
								if(data == 0){
                                    return '<span class="text-xs text-primary">pending meal...</span>\
                                            <button data-id='+row.id+' class="btn btn-bold btn-sm btn-success take">Take</button>';
								}else if(data == 100){
                                    return '<button style="cursor:not-allowed" data-id='+row.id+' class="btn btn-bold btn-sm btn-success disabled">Taken</button>\
                                            <button data-id='+row.id+' class="btn btn-bold btn-sm btn-primary ready">Ready</button>\
                                            <button data-id='+row.id+' class="btn btn-bold btn-sm btn-primary deliver">Deliver</button>\
                                    ';
                                }else if(data == 200){
                                    return '<button style="cursor:not-allowed" data-id='+row.id+' class="btn btn-bold btn-sm btn-success disabled">Ready</button>\
                                            <button data-id='+row.id+' class="btn btn-bold btn-sm btn-primary deliver">Deliver</button>\
                                    ';
                                }else if(data == 300){
                                    return '<button style="cursor:not-allowed" data-id='+row.id+' class="btn btn-bold btn-sm btn-success disabled">Delivered</button>';
								}else{
									return '<button style="cursor:not-allowed" data-id='+row.id+' class="btn btn-bold btn-sm btn-success disabled">Eaten</button>';
								}
                     		}
                        },
						{
                            title: "Action",
                            width:'5%',
                            targets:12,
							sortable: false,
							autoHide: false,
							overflow: 'visible',
							render: function(data, type, row) {
								return '\
										<div class="dropdown">\
											<a href="javascript:void(0);" class="btn btn-sm btn-clean btn-danger" data-toggle="dropdown">\
                                                <i class="flaticon-more-1"></i>\
                                                Options\
											</a>\
											<div class="dropdown-menu dropdown-menu-left">\
												<ul class="kt-nav">\
													<li class="kt-nav__item">\
														<a href="javascript:void(0);" style="cursor:not-allowed" data-id='+row.id+' class="kt-nav__link meal-edit">\
															<i class="kt-nav__link-icon flaticon-edit-1"></i>\
															<span class="kt-nav__link-text">Edit</span>\
														</a>\
													</li>\
													<li class="kt-nav__item">\
														<a href="javascript:void(0);" data-id='+row.id+' class="kt-nav__link order-delete">\
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
						$(".take").click(function() {
							let id = $(this).data("id");
                            that.axios.get('/api/manage_orders/take/'+id)
                            .then((response) => {
                                if(response.status == 200){
                                    swal(response.data, {icon: "success",timer: 1000, buttons:false});
                                    $("#orders").DataTable().ajax.reload();
                                }
                            })
                        });
						$(".ready").click(function() {
							let id = $(this).data("id");
                            that.axios.get('/api/manage_orders/ready/'+id)
                            .then((response) => {
                                if(response.status == 200){
                                    swal(response.data, {icon: "success",timer: 1000, buttons:false});
                                    $("#orders").DataTable().ajax.reload();
                                }
                            })
                        });
						$(".deliver").click(function() {
							let id = $(this).data("id");
                            that.axios.get('/api/manage_orders/deliver/'+id)
                            .then((response) => {
                                if(response.status == 200){
                                    swal(response.data, {icon: "success",timer: 1000, buttons:false});
                                    $("#orders").DataTable().ajax.reload();
                                }
                            })
                        });
						$(".order-delete").click(function() {
							swal({
								title: "Are you sure?",
								text: "You want to delete order!",
								icon: "warning",
								buttons: true,
								dangerMode: true,
                     		})
							.then((willDelete) => {
								if (willDelete) {
									let id = $(this).data("id");
									if (id!='') {
										that.axios.delete('/api/manage_orders/'+id)
										.then((response)=>{
											if(response.status == 200){
												swal(response.data, {icon: "success",timer: 1000, buttons:false});
												$("#orders").DataTable().ajax.reload();
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
						$("#orders").DataTable().on('select', function ( e, dt, type, indexes ) {
							if ( type === 'row' ) {
                                that.selected_row_ids = [];
                                let id = $("#orders").DataTable().rows( indexes ).data().pluck( 'id' )[0];
								that.selected_row_ids.push(id);
							}
						});

						$("#orders").DataTable().on( 'deselect', function ( e, dt, type, indexes ) {
							if ( type === 'row' ) {
                                that.selected_row_ids = [];
                                let id = $("#orders").DataTable().rows( indexes ).data().pluck( 'id' )[0];
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
