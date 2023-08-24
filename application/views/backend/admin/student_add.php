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
				
                <?php echo form_open(base_url() . 'index.php?admin/student/create/' , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'),['customer_id' => $customer_data['customer_id']]);?>
					
					<?php

					 $this->load->view('backend/admin/stream_form',['data' => $customer_data]) ?>
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="name"  data-message-required="<?php echo get_phrase('value_required');?>" value="<?=$customer_data['name']?>" autofocus>
						</div>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('gardian_name');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="gardian_name"  data-message-required="<?php echo get_phrase('gardian_name');?>" value="" autofocus>
						</div>
					</div>
					
						<?php 
						$this->load->view('backend/admin/package_multiselect');

						/*
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('package');?></label>
                        <div class="col-sm-5">
                		$where = $this->crud_model->setSplitWhere('package');
                		$firstStream = $this->crud_model->firstStream();
						$where['stream_id'] = $firstStream['stream_id']; 
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
							$instructor = $this->db->get_where('instructor',['instructor_id' => $row['instructor_id']])->row()->name;
							?>
                            		<input type="checkbox" id="vehicle1" name="package_id[]" <?php if (++$i === $numItems) { echo ' data-message-required="Package Required"'; }?> value="<?=$row['package_id']?>" >
									<label for="vehicle1"><?=$row['name']?></label><br>
							<?php
								endforeach; 
							?>
						</div> 
						<?php
							endforeach;
						</div>
					</div>
						*/
						?>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('birthday');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control datepicker" name="birthday" autocomplete="off" value="<?=$customer_data['birthday']?>" data-start-view="2">
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('gender');?></label>
                        
						<div class="col-sm-5">
							<select name="sex" class="form-control selectboxit">
                              <option value="" <?=($customer_data['sex'] === '')?'selected':''?>><?php echo get_phrase('select');?></option>
                              <option value="male" <?=($customer_data['sex'] === 'male')?'selected':''?>><?php echo get_phrase('male');?></option>
                              <option value="female" <?=($customer_data['sex'] === 'female')?'selected':''?>><?php echo get_phrase('female');?></option>
                              <option value="other" <?=($customer_data['sex'] === 'other')?'selected':''?>><?php echo get_phrase('other');?></option>
                          </select>
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('phone');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="phone" value="<?=$customer_data['phone']?>" placeholder="<?php echo get_phrase('phone');?>">
						</div> 
					</div>
                    
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('whatsapp_number');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="whatsapp_number" value="<?=$customer_data['whatsapp']?>" placeholder="<?php echo get_phrase('whatsapp_number');?>" >
							<label>
								<input type="checkbox" id="same">
									same as above
								</input>
							</label>
						</div> 
					</div>
                    
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('email_address');?></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="email" data-message-required="<?php echo get_phrase('value_required');?>" value="<?=$customer_data['email']?>">
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
                              <option value="<?=$val->blood_id?>" <?=($customer_data['blood_group'] === $val->blood_id)?'selected':''?> ><?=$val->name?></option>
							  <?php } ?>
                          </select>
						</div> 
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('nationality');?></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="nationality"  data-message-required="<?php echo get_phrase('nationality');?>" value="">
						</div>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('adhaar_number');?></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="adhaar_number" value="">
						</div>
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('date_of_admission');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control datepicker" name="date_of_admission" autocomplete="off" value="" data-start-view="2">
						</div> 
					</div>
					<div class="col-md-12">
						<label ><?php echo get_phrase('permenent_address');?></label>
						<div class="form-group">
							<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('address_line_1');?> (House / Flatnumber & name)</label>
							
							<div class="col-md-5">
								<input type="text" class="form-control" name="address_line_1" value="" data-start-view="2">
							</div> 
						</div>
						<div class="form-group">
							<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('address_line_2');?> (Street Name, Post Office)</label>
							
							<div class="col-md-5">
								<input type="text" class="form-control" name="address_line_2" value="" data-start-view="2">
							</div> 
						</div>
						<div class="form-group">
							<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('address_line_3');?> (Place, City)</label>
							
							<div class="col-md-5">
								<input type="text" class="form-control" name="address_line_3" value="" data-start-view="2">
							</div> 
						</div>
						<div class="form-group">
							<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('address_line_4');?> (State, Country)</label>
							
							<div class="col-md-5">
								<input type="text" class="form-control" name="address_line_4" value="" data-start-view="2">
							</div> 
						</div>
						<div class="form-group">
							<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('pincode');?></label>
							
							<div class="col-md-5">
								<input type="text" class="form-control" name="pincode" value="" data-start-view="2">
							</div> 
						</div>
					</div>
					
					<div class="col-md-12">
						<label ><?php echo get_phrase('temporary_address');?>
							
						</label>
						<div class="form-group">
							<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('add same as above');?></label>
							
							<div class="col-md-5">
								<input id="addSame" type="checkbox" name="">
							</div> 
						</div>
						<div class="form-group">
							<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('address_line_1');?> (House / Flatnumber & name)</label>
							
							<div class="col-md-5">
								<input id="address_line_1_temp" type="text" class="form-control" name="address_line_1_temp"  data-message-required="<?php echo get_phrase('address_line_1');?>"
								value="" data-start-view="2">
							</div> 
						</div>
						<div class="form-group">
							<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('address_line_2');?> (Street Name, Post Office)</label>
							
							<div class="col-md-5">
								<input id="address_line_2_temp" type="text" class="form-control" name="address_line_2_temp"  data-message-required="<?php echo get_phrase('address_line_2');?>"
								value="" data-start-view="2">
							</div> 
						</div>
						<div class="form-group">
							<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('address_line_3');?> (Place, City)</label>
							
							<div class="col-md-5">
								<input id="address_line_3_temp" type="text" class="form-control" name="address_line_3_temp"  data-message-required="<?php echo get_phrase('address_line_3');?>" value="" data-start-view="2">
							</div> 
						</div>
						<div class="form-group">
							<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('address_line_4');?> (State, Country)</label>
							
							<div class="col-md-5">
								<input id="address_line_4_temp" type="text" class="form-control" name="address_line_4_temp"  data-message-required="<?php echo get_phrase('address_line_4');?>" value="" data-start-view="2">
							</div> 
						</div>
						<div class="form-group">
							<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('pincode');?></label>
							
							<div class="col-md-5">
								<input type="text" id="pincode_temp" class="form-control" name="pincode_temp"  data-message-required="<?php echo get_phrase('pincode');?>" value="" data-start-view="2">
							</div> 
						</div>
					</div>

					<div class="col-md-12">
						<label ><?php echo get_phrase('other_details');?></label>
						<div class="form-group">
							<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('education_qualification');?></label>
							
							<div class="col-md-5">
								<input type="text" class="form-control" name="education_qualification" value="" >
							</div> 
						</div>
						<div class="form-group">
							<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('operating_rto')?></label>
							
							<div class="col-md-5">
								<input type="text" class="form-control" name="operating_rto" value="" >
							</div> 
						</div>
						<div class="form-group">
							<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('identification_mark 1')?></label>
							
							<div class="col-md-5">
								<input type="text" class="form-control" name="identification_mark[]" value="" >
							</div> 
						</div>
						<div class="form-group">
							<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('identification_mark 2')?></label>
							
							<div class="col-md-5">
								<input type="text" class="form-control" name="identification_mark[]" value="" >
							</div> 
						</div>
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('settings');?></label>
						
						<div class="col-sm-5">
							<textarea id="settings" class="form-control col-sm-5" name="settings" rows="4" cols="50">
							</textarea>
						</div>
					</div> 
					


					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('photo');?></label>
                        
						<div class="col-sm-5">
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="fileinput-new thumbnail" style="width: 100px; height: 100px;" data-trigger="fileinput">
									<img 
									src="
									<?php 
									if (isset($customer_data) && !empty($customer_data)) {
									echo $this->crud_model->get_image_url('customer', $customer_data['customer_id']); 
									} else {
									?>
									http://placehold.it/200x200
									<?php } ?>
									"
									 alt="...">
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
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('documents');?></label>
                        
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
										<input type="file" name="documents[]" multiple="" accept="image/*">
									</span>
									<a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
								</div>
							</div>
						</div>
					</div>
                    

                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo get_phrase('add_student');?></button>
						</div>
					</div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
		<blockquote class="blockquote-blue">
			<p>
				<strong>Student Admission Notes</strong>
			</p>
			<p>
				Admitting new students will automatically create an enrollment to the selected class in the running session.
				Please check and recheck the informations you have inserted because once you admit new student, you won't be able
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


    $("#addSame").change(function(){   // 1st way
    	if($(this).is(":checked")){
    		$("#address_line_1_temp").val($("input[name=address_line_1]").val());
    		$("#address_line_2_temp").val($("input[name=address_line_2]").val());
    		$("#address_line_3_temp").val($("input[name=address_line_3]").val());
    		$("#address_line_4_temp").val($("input[name=address_line_4]").val());
    		$("#pincode_temp").val($("input[name=pincode]").val());

    	}else{
    		$("#address_line_1_temp").val('');
    		$("#address_line_2_temp").val('');
    		$("#address_line_3_temp").val('');
    		$("#address_line_4_temp").val('');
    		$("#pincode_temp").val('');
    	}
    });
    $('#same').change(function () {
    	if($(this).is(':checked')){
    		$("input[name=whatsapp_number]").val($("input[name=phone]").val());
    	}
 	});
</script>