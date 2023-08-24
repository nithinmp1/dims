<hr />
<div class="row">
	<div class="col-md-12">
    
    	<!------CONTROL TABS START------>
		<ul class="nav nav-tabs bordered">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="entypo-menu"></i> 
					<?php echo get_phrase('task_list');?>
                    	</a></li>
			<li>
            	<a href="#add" data-toggle="tab"><i class="entypo-plus-circled"></i>
					<?php echo get_phrase('add_task');?>
                    	</a></li>
		</ul>
    	<!------CONTROL TABS END------>
        
		<div class="tab-content">
        <br>
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">
				
                <table class="table table-bordered datatable" id="table_export">
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
			</div>
            <!----TABLE LISTING ENDS--->
            
            
			<!----CREATION FORM STARTS---->
			<div class="tab-pane box" id="add" style="padding: 5px">
                <div class="box-content">
                	<?php echo form_open(base_url() . 'index.php?admin/customer_task_list/direct_create' , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'),['status' => 'pending']);?>
                        <div class="padded">
                            <div class="form-group">
                                <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('select_customer');?></label>
                                
                                <div class="col-sm-5">
                                    <select data-validate="required" name="customer_id" class="form-control selectboxit">
                                        <option value=""><?php echo get_phrase('select');?></option>
                                        <?php 
                                        $where = $this->crud_model->setSplitWhere('customer');
                                        
                                        $customer = $this->db->get_where('customer',$where)->result_array();
                                        foreach($customer as $key => $val):
                                        ?>
                                        <option value="<?=$val['customer_id']?>"><?php echo $val['name'];?></option>
                                        <?php endforeach; ?>
                                  </select>
                                </div> 
                            </div>

                            <div class="form-group">
                                <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('select_service_article');?></label>
                                
                                <div class="col-sm-5">
                                    <select data-validate="required" name="customer_service_id" class="form-control selectboxit">
                                        <option value=""><?php echo get_phrase('select');?></option>
                                        <?php 
                                    $where = $this->crud_model->setSplitWhere('customer_service');
                                        
                                        $service = $this->db->get_where('customer_service',$where)->result_array();
                                        foreach($service as $key => $val):
                                        ?>
                                        <option value="<?=$val['customer_service_id']?>"><?php echo $val['name'];?></option>
                                        <?php endforeach; ?>
                                  </select>
                                </div> 
                            </div>

                            <div class="form-group">
                                <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('task');?></label>
                                
                                <div class="col-sm-5">
                                    <select data-validate="required" id="task_id" name="task_id" class="form-control selectboxit">
                                        <option value=""><?php echo get_phrase('select');?></option>
                                        <?php 
                                    $where = $this->crud_model->setSplitWhere('customer_task');
                                        
                                        $task = $this->db->get_where('customer_task',$where)->result_array();
                                        foreach($task as $key => $val):
                                        ?>
                                        <option value="<?=$val['customer_task_id']?>"><?php echo $val['name'];?></option>
                                        <?php endforeach; ?>
                                    </select>
                                  <span id="nottifier" style="color: red; display: none;"></span>
                                </div> 
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('extimate_date');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control datepicker" name="extimate_date" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('article_number');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="article_number"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('notes');?></label>
                                <div class="col-sm-5">
                                <textarea id="notes" class="form-control" name="notes" rows="4" cols="50">

                                </textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('assign_to');?></label>
                                <div class="col-sm-5">
                                <select data-validate="required" name="assign_to" class="form-control selectboxit">
                                    <option value=""><?php echo get_phrase('select');?></option>
                                    <?php 
                                    $where = $this->crud_model->setSplitWhere('staff');
                                    
                                    $staff = $this->db->get_where('staff',$where)->result_array();
                                    foreach($staff as $key => $val):
                                    ?>
                                    <option value="<?=$val['staff_id']?>"><?php echo $val['name'];?></option>
                                    <?php endforeach; ?>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                              <div class="col-sm-offset-3 col-sm-5">
                                  <button type="submit" class="btn btn-info"><?php echo get_phrase('add_task');?></button>
                              </div>
						</div>
                        
                    </form>                
                </div>                
			</div>
			<!----CREATION FORM ENDS-->
		</div>
	</div>
</div>



<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">

	jQuery(document).ready(function($)
	{
		

		var datatable = $("#table_export").dataTable();
		
		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
	});
	$('#task_id').on('change', function() {
      $.get("<?echo base_url(); ?>index.php?admin/getTask/"+this.value, function(data, status){
            data = JSON.parse(data);
            $("#nottifier").html(data.defualt_days_required+' Default Days Required');
            $("#nottifier").show();

      });


    });
</script>