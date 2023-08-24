<div style="text-align:center;">
    <h2 style="font-weight:200; margin:0px;color: green;">
    Pending Task Per Branch Table
    </h2>
</div>
                <table class="table table-bordered datatable" id="table_task_export">
                	<thead>
                		<tr>
                    		<th><div>#</div></th>
                    		<th><div><?php echo get_phrase('service');?></div></th>
                    		<th><div><?php echo get_phrase('customer');?></div></th>
                    		<th><div><?php echo get_phrase('task');?></div></th>
                            <th><div><?php echo get_phrase('extimate_date');?></div></th>
                            <th><div><?php echo get_phrase('article_number');?></div></th>
                            <th><div><?php echo get_phrase('notes');?></div></th>
                            <th><div><?php echo get_phrase('status');?></div></th>
                            <th><div><?php echo get_phrase('updated_at');?></div></th>
                            <th><div><?php echo get_phrase('assigned_to');?></div></th>
                    		<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php 

                        if (isset($branch_id) && $branch_id != ''){
                            $branch = $this->db->get_where('branch',['branch_id' => $branch_id])->row();
                        }else{
                            $branch = $this->db->select('*')->from('branch')->limit('1')->get()->row();
                        }
                        $where['branch_id'] = $branch->branch_id;

                        $staffs = $this->db->get_where('staff',$where)->result_array();
                        $staff_id = array_column($staffs,'staff_id');
                        if(!empty($staff_id)){

                        $this->db->where_in('assign_to',$staff_id);
                        $this->db->or_where_in('createdID',$staff_id);
                        $customer_task = $this->db->get_where('customer_task_list',['status' => 'pending'])->result_array();
                        }
                        $customer_task = [];
                        // echo $this->db->last_query();
                        // echo "<pre>";print_r($customer_task);die;
                        $count = 1;foreach($customer_task as $row):
                        ?>
                        <tr>
                            <td><?php echo $count++;?></td>
							<td><?php
                            echo  $this->db->get_where('customer_service',['customer_service_id' => $row['customer_service_id']])->row()->name;
                             ?></td>
							<td><?php 
                            echo  $this->db->get_where('customer',['customer_id' => $row['customer_id']])->row()->name;
                            ?></td>
                            <td><?php 
                            echo  $this->db->get_where('customer_task',['customer_task_id' => $row['task_id']])->row()->name;

                            ?></td>
                            <td><?php echo $row['extimate_date'];?></td>
                            <td><?php echo $row['article_number'];?></td>
                            <td><?php echo $row['notes'];?></td>
                            <td><?php echo $row['status'];?></td>
                            <td><?php echo $row['updated_at'];?></td>
                            <td><?php
                            echo  $this->db->get_where('staff',['staff_id' => $row['assign_to']])->row()->name;
                         ?></td>
							<td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                    
                                    <!-- EDITING LINK -->
                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_edit_customer_task_list/<?php echo $row['task_list_id'];?>');">
                                            <i class="entypo-pencil"></i>
                                                <?php echo get_phrase('edit');?>
                                            </a>
                                                    </li>
                                    <li class="divider"></li>
                                    
                                    <!-- DELETION LINK -->
                                    <li>
                                        <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/customer_task_list/delete/<?php echo $row['customer_task_id'];?>');">
                                            <i class="entypo-trash"></i>
                                                <?php echo get_phrase('delete');?>
                                            </a>
                                                    </li>
                                </ul>
                            </div>
        					</td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>


<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">

    jQuery(document).ready(function ($)
    {


        var datatable = $("#table_task_export").dataTable({
            "sPaginationType": "bootstrap",
            "iDisplayLength" : "4",
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
            "oTableTools": {
                "aButtons": [

                    {
                        "sExtends": "xls",
                        "mColumns": [0, 2, 3, 4]
                    },
                    {
                        "sExtends": "pdf",
                        "mColumns": [0, 2, 3, 4]
                    },
                    {
                        "sExtends": "print",
                        "fnSetText": "Press 'esc' to return",
                        "fnClick": function (nButton, oConfig) {
                            datatable.fnSetColumnVis(1, false);
                            datatable.fnSetColumnVis(5, false);

                            this.fnPrint(true, oConfig);

                            window.print();

                            $(window).keyup(function (e) {
                                if (e.which == 27) {
                                    datatable.fnSetColumnVis(1, true);
                                    datatable.fnSetColumnVis(5, true);
                                }
                            });
                        },

                    },
                ]
            },

        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });
    });
</script>