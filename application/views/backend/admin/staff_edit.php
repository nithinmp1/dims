<?php
$edit_data = $this->db->get_where('staff', array('staff_id' => $param2))->result_array();
foreach($edit_data as $row) { ?>	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary" data-collapsed="0">
	        	<div class="panel-heading">
	            	<div class="panel-title">
	            		<i class="entypo-plus-circled"></i>
						<?php echo get_phrase('edit_staff');?>
	            	</div>
	            </div>

				<div class="panel-body">
					
	                <?php echo form_open(base_url() . 'index.php?admin/staff/edit/' . $param2, array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
                		
                		<?php $this->load->view('backend/admin/branch_form',['row' => $row]) ?>
	                    
						<div class="form-group">
							<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
	                        
							<div class="col-sm-5">
								<input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"  autofocus
	                            	value="<?php echo $row['name']; ?>">
							</div>
						</div>
	                    
						<div class="form-group">
							<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('email');?></label>
							<div class="col-sm-5">
								<input type="text" class="form-control" name="email" value="<?php echo $row['email']; ?>">
							</div>
						</div>
	                    
						<div class="form-group">
							<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('access settings');?></label>
							<div class="col-md-5">
							<?php 
								$access = $this->db->get_where('access_controller',['status' => '1'])->result_array();
								foreach($access as $key => $val){
									$givenAccess = (json_decode($row['access'],true)); 
									?>
									<input type="radio" id="<?=$val['name']?>" name="access[]" value="<?=$val['name']?>"
									<?=(in_array($val['name'],$givenAccess))?'checked':''?>
									> 
									<?=ucwords($val['name'])?>
									
									<br>

								<?php }

							?>
							<?php //} ?>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo get_phrase('status');?></label>
								<div class="col-sm-5">
								<select name="status" class="form-control selectboxit">
									<option value="active" <?php if($row['status'] == 'active')echo 'selected';?>><?php echo get_phrase('active');?></option>
									<option value="inactive" <?php if($row['status'] == 'inactive')echo 'selected';?>><?php echo get_phrase('inactive');?></option>
								</select>
							</div>
						</div>
						<div class="form-group" >
							<div class="col-sm-5">
								<div class="fileinput fileinput-new" data-provides="fileinput">
									<div class="fileinput-new thumbnail" style="width: 100px; height: 100px;" data-trigger="fileinput">
										<img src="<?php echo base_url($row['image']);?>" alt="...">
									</div>
									<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
									<div>
										<span class="btn btn-white btn-file">
											<span class="fileinput-new">Select image</span>
											<span class="fileinput-exists">Change</span>
											<input type="file" name="userfile" accept="image/*">
										</span>
										<a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
									</div>
								</div>
							</div>
						</div>
	                    <div class="form-group">
							<div class="col-sm-offset-3 col-sm-5">
								<button type="submit" class="btn btn-info"><?php echo get_phrase('update');?></button>
							</div>
						</div>

	                <?php echo form_close();?>

	            </div>
	        </div>
	    </div>
	</div>
<?php } ?>