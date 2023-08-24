<?php 
$edit_data		=	$this->db->get_where('follow_up' , array('follow_up_id' => $param2) )->result_array();
foreach ( $edit_data as $row):
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('edit_follow_up');?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(base_url() . 'index.php?admin/customer_follow_up/direct_update/'.$row['follow_up_id'] , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
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
                                        <option value="<?=$val['customer_id']?>" <?=($row['customer_id'] == $val['customer_id'])?"selected":""?> ><?php echo $val['name'];?></option>
                                        <?php endforeach; ?>
                                  </select>
                                </div> 
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('follow_up_on');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control datepicker" name="follow_up_on" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="<?=$row['follow_up_on']?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('remark');?></label>
                                <div class="col-sm-5">
                                <textarea id="customer_enquiry" class="form-control" name="notes" rows="4" cols="50">
                                <?=$row['remark']?>
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
                                    <option value="<?=$val['staff_id']?>" <?=($row['assign_to'] == $val['staff_id'])?"selected":""?>><?php echo $val['name'];?></option>
                                    <?php endforeach; ?>
                                </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('status');?></label>
                                <div class="col-sm-5">
                                <select name="status" class="form-control selectboxit">
                                    <option value=""><?php echo get_phrase('select');?></option>
                                    <?php 
                                    $status = ['pending','Completed','holded','wip'];
                                    foreach($status as $val):
                                    ?>
                                    <option value="<?=$val?>" <?=($row['status'] == $val)?"selected":""?>><?php echo $val;?></option>
                                    <?php endforeach; ?>
                                </select>
                                </div>
                            </div>
                    </div>

                    <div class="form-group">
                      <div class="col-sm-offset-3 col-sm-5">
                          <button type="submit" class="btn btn-info"><?php echo get_phrase('edit_follow_up');?></button>
                      </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
endforeach;
?>





