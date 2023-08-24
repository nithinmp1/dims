<hr />
<div class="row">
	<div class="col-md-12">
    
    	<!------CONTROL TABS START------>
		<ul class="nav nav-tabs bordered">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="entypo-menu"></i> 
					<?php echo get_phrase('enquiry_list');?>
                    	</a></li>
			<li>
            	<a href="#add" data-toggle="tab"><i class="entypo-plus-circled"></i>
					<?php echo get_phrase('add_enquiry');?>
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
                    		<th><div><?php echo get_phrase('customer');?></div></th>
                    		<th><div><?php echo get_phrase('extimate_date');?></div></th>
                            <th><div><?php echo get_phrase('Enquiry');?></div></th>
                            <th><div><?php echo get_phrase('notes');?></div></th>
                            <th><div><?php echo get_phrase('status');?></div></th>
                            <th><div><?php echo get_phrase('updated_at');?></div></th>
                            <th><div><?php echo get_phrase('assigned_to');?></div></th>
                    		<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php
                        $count = 1;foreach($customer_enquiry as $row):
                        ?>
                        <tr>
                            <td><?php echo $count++;?></td>
							<td><?php 
                            echo  $this->db->get_where('customer',['customer_id' => $row['customer_id']])->row()->name;
                            ?></td>
                            <td><?php echo $row['extimate_date'];?></td>
                            <td><?php echo $row['customer_enquiry'];?></td>
                            <td><?php echo $row['notes'];?></td>
                            <td><?php echo $row['status'];?></td>
                            <td><?php echo $row['createdAt'];?></td>
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
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_edit_customer_enquiry/<?php echo $row['customer_enquiry_id'];?>');">
                                            <i class="entypo-pencil"></i>
                                                <?php echo get_phrase('edit');?>
                                            </a>
                                                    </li>
                                    <li class="divider"></li>
                                    
                                    <!-- DELETION LINK -->
                                    <li>
                                        <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/customer_enquiry/delete/<?php echo $row['customer_enquiry_id'];?>');">
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
                	<?php echo form_open(base_url() . 'index.php?admin/customer_enquiry/direct_create' , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'),['status' => 'pending']);?>
                        <div class="padded">
                            <div class="form-group">
                                <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('select_customer');?></label>
                                
                                <div class="col-sm-5">
                                    <select name="customer_id" class="form-control selectboxit">
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
                                <label class="col-sm-3 control-label"><?php echo get_phrase('Date');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control datepicker" name="extimate_date" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('Enquiry');?></label>
                                <div class="col-sm-5">
                                <textarea id="notes" class="form-control" name="customer_enquiry" rows="4" cols="50">

                                </textarea>
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
                                <select name="assign_to" class="form-control selectboxit">
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
                                  <button type="submit" class="btn btn-info"><?php echo get_phrase('add_enquiry');?></button>
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
	$('#enquiry_id').on('change', function() {
      $.get("<?echo base_url(); ?>index.php?admin/getenquiry/"+this.value, function(data, status){
            data = JSON.parse(data);
            $("#nottifier").html(data.defualt_days_required+' Default Days Required');
            $("#nottifier").show();

      });


    });
</script>