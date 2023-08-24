<div class="row">
	<div class="col-md-8">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('addmission_form');?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(base_url() . 'index.php?admin/customer/create/' , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
					
					<?php $this->load->view('backend/admin/stream_form'); ?>
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus>
						</div>
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('birthday');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control datepicker" name="birthday" autocomplete="off" value="" data-start-view="2">
						</div> 
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('blood_group');?></label>
                        
						<div class="col-sm-5">
							<select name="blood_group" class="form-control selectboxit">
                              <option value=""><?php echo get_phrase('select');?></option>
							  <?php 
							 	$bloodGroups = $this->db->get('blood_group')->result();
								foreach($bloodGroups as $key => $val){ 
							  ?>
                              <option value="<?=$val->blood_id?>"><?=$val->name?></option>
							  <?php } ?>
                          </select>
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('gender');?></label>
                        
						<div class="col-sm-5">
							<select name="sex" class="form-control selectboxit">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <option value="male"><?php echo get_phrase('male');?></option>
                              <option value="female"><?php echo get_phrase('female');?></option>
                              <option value="other"><?php echo get_phrase('other');?></option>
                          </select>
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('address');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="address" value="" >
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('phone');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="phone" value="" >
						</div> 
					</div>
                    
                    <div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('whatsapp');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="whatsapp" value="" >
							<label>
								<input type="checkbox" id="same">
									same as above
								</input>
							</label>
						</div> 
					</div>
                    
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('email');?></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="email"  data-message-required="<?php echo get_phrase('value_required');?>" value="">
						</div>
					</div>
					
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('photo');?></label>
                        
						<div class="col-sm-5">
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="fileinput-new thumbnail" style="width: 100px; height: 100px;" data-trigger="fileinput">
									<img src="http://placehold.it/200x200" alt="...">
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
                    
                    <?php 
                    $this->load->view('backend/admin/service_multiselect');
                    /*
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('select_service_article');?></label>
                        
						<div class="col-sm-5">
							<select name="service" class="form-control selectboxit">
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
					*/ ?>
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('date_of_issue');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control datepicker" name="date_of_issue" autocomplete="off" value="" data-start-view="2">
						</div> 
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('number');?></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="article_number" data-message-required="<?php echo get_phrase('value_required');?>" value="">
						</div>
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('what_to_do');?></label>
                        
						<div class="col-sm-5">
							<select name="task" class="form-control selectboxit">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <?php 
								$where = $this->crud_model->setSplitWhere('customer_task');

								$service = $this->db->get_where('customer_task',$where)->result_array();
								foreach($service as $key => $val):
								?>
							  	<option value="<?=$val['customer_task_id']?>"><?php echo $val['name'];?></option>
								<?php endforeach; ?>
                          </select>
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('Extimate_date_completion');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control datepicker" name="extimate_date" autocomplete="off" value="" data-start-view="2">
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
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo get_phrase('add_customer');?></button>
						</div>
					</div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
		<blockquote class="blockquote-blue" hidden>
			<p>
				<strong>customer Admission Notes</strong>
			</p>
			<p>
				Admitting new customers will automatically create an enrollment to the selected class in the running session.
				Please check and recheck the informations you have inserted because once you admit new customer, you won't be able
				to edit his/her class,roll,section without promoting to the next session.
			</p>
		</blockquote>
	</div>

</div>

<script type="text/javascript">

	function get_class_sections(class_id) {

    	$.ajax({
            url: '<?php echo base_url();?>index.php?admin/get_class_section/' + class_id ,
            success: function(response)
            {
                jQuery('#section_selector_holder').html(response);
            }
        });

    }
    $('#same').change(function () {
    	if($(this).is(':checked')){
    		$("input[name=whatsapp]").val($("input[name=phone]").val());
    	}
 	});
</script>