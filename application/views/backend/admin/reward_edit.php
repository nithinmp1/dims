<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('edit_reward');?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php 
                $reward = $this->db->get_where('reward',['reward_id' => $param2])->row_array();
                // echo "<pre>";print_r($reward);die;
                echo form_open(base_url() . 'index.php?admin/reward_masters/do_update/'.$reward['reward_id'] , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
	
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                        
						<div class="col-sm-6">
							<input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="<?=$reward['name']?>" autofocus>
						</div>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('point');?></label>
                        
						<div class="col-sm-6">
							<input type="number" class="form-control" name="reward_point" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="<?=$reward['reward_point']?>" autofocus>
						</div>
					</div>
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('reward_on');?></label>
						<div class="col-sm-6">
                        
						<input type="radio" id="vehicle1" name="reward_category" value="student" <?=($reward['reward_category'] === 'student')?'checked':''?> >
						<label for="vehicle1">Student Based</label>
						<br>
						<input type="radio" id="vehicle1" name="reward_category" value="customer_service" >
						<label for="vehicle1" <?=($reward['reward_category'] === 'customer_service')?'checked':''?>>Customer Service Based</label>
						<br>

						<input type="radio" id="vehicle1" name="reward_category" value="customer_task" >
						<label for="vehicle1" <?=($reward['reward_category'] === 'customer_task')?'checked':''?>>Customer Task Based</label>
						<br>
						<input type="radio" id="vehicle1" name="reward_category" <?=($reward['reward_category'] === 'customer_followup')?'checked':''?> value="customer_followup" >
						<label for="vehicle1">Customer Task Follow-Up</label>
						</div>
					</div>
					
					<div class="form-group category" id="student">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('package');?></label>
                        <div class="row">
						<?php 
                		$where = $this->crud_model->setSplitWhere('package');
						 
						$package = $this->db->get_where('package',$where)->result_array();
						$divident = 2;
						if(count($package)/2 > 2)
							$divident = count($package)/2;

						$packagechunk = array_chunk($package,$divident);
						foreach($packagechunk as $packagechunkV):
							?>
						<div class="col-sm-4">
							<?php
								$numItems = count($packagechunkV);
								$i = 0;
								foreach($packagechunkV as $row):
								?>
                            		<input type="checkbox" id="vehicle1" name="package_id[]" <?php if (++$i === $numItems) { echo 'data-validate="required" data-message-required="Package Required"'; }?> value="<?=$row['package_id']?>" <?=(in_array($row['package_id'],json_decode($reward['package_id'],true)) && $reward['reward_category'] === 'student')?'checked':''?> >
									<label for="vehicle1"><?=$row['name']?></label><br>
							<?php
								endforeach; 
							?>
						</div> 
						<?php
							endforeach;
						?>
						</div>
					</div>
					
					<div class="form-group category" style="display:none;" id="customer_service">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('customer_service');?></label>
                        <div class="row">
						<?php 
                		$where = $this->crud_model->setSplitWhere('customer_service');
						 
						$package = $this->db->get_where('customer_service',$where)->result_array();
						$divident = 2;
						if(count($package)/2 > 2)
							$divident = count($package)/2;

						$packagechunk = array_chunk($package,$divident);
						foreach($packagechunk as $packagechunkV):
							?>
						<div class="col-sm-4">
							<?php
								$numItems = count($packagechunkV);
								$i = 0;
								foreach($packagechunkV as $row):
							?>
                            		<input type="checkbox" id="vehicle1" name="customer_service_id[]" <?php if (++$i === $numItems) { echo 'data-validate="required" data-message-required="Package Required"'; }?> value="<?=$row['customer_service_id']?>" <?=(in_array($row['customer_service_id'], json_decode($reward['customer_service_id'], true)) && $reward['reward_category'] === 'customer_service' )?'checked':''?>>
									<label for="vehicle1"><?=$row['name']?></label><br>
							<?php
								endforeach; 
							?>
						</div> 
						<?php
							endforeach;
						?>
						</div>
					</div>
					
					<div class="form-group category" style="display:none;" id="customer_task">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('customer_task');?></label>
                        <div class="row">
						<?php 
                		$where = $this->crud_model->setSplitWhere('customer_task');
						 
						$package = $this->db->get_where('customer_task',$where)->result_array();
						$divident = 2;
						if(count($package)/2 > 2)
							$divident = count($package)/2;

						$packagechunk = array_chunk($package,$divident);
						foreach($packagechunk as $packagechunkV):
							?>
						<div class="col-sm-4">
							<?php
								$numItems = count($packagechunkV);
								$i = 0;
								foreach($packagechunkV as $row):
							?>
                            		<input type="checkbox" id="vehicle1" name="customer_task_id[]" <?php if (++$i === $numItems) { echo 'data-validate="required" data-message-required="Package Required"'; }?> value="<?=$row['customer_task_id']?>" <?=(in_array($row['customer_task_id'], json_decode($reward['customer_task_id'], true)) && $reward['reward_category'] === 'customer_task' )?'checked':''?>>
									<label for="vehicle1"><?=$row['name']?></label><br>
							<?php
								endforeach; 
							?>
						</div> 
						<?php
							endforeach;
						?>
						</div>
					</div>
					
					<div class="form-group category" style="display:none;" id="customer_followup">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('follow_up');?>
						</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="follow_up" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="<?=$reward['follow_up']?>" autofocus >
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo get_phrase('update_reward');?></button>
						</div>
					</div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	$('input[type=radio][name=reward_category]').change(function() {
    var div = this.value;
    $( ".category" ).each(function() {
	  $( this ).hide();
	});
    $("#"+div).show();
});
</script>