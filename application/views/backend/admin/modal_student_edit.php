<?php 
$edit_data		=	$this->db->get_where('enroll' , array(
	'student_id' => $param2 , 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
))->result_array();
// echo "<pre>";print_r($edit_data);die;
foreach ($edit_data as $key => $row):
	$studentData = $this->db->get_where('student' , array('student_id' => $row['student_id']))->row_array();
	// echo "<pre>";print_r($studentData);die;
	
	if($key == 1)
	break;
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('edit_student');?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(base_url() . 'index.php?admin/student/do_update/'.$row['student_id'].'/'.$row['class_id'] , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
                
                	
	
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('photo');?></label>
                        
						<div class="col-sm-5">
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="fileinput-new thumbnail" style="width: 100px; height: 100px;" data-trigger="fileinput">
									<img src="<?php echo $this->crud_model->get_image_url('student' , $row['student_id']);?>" alt="...">
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
					$row1['data']['stream_id'] = $studentData['stream_id'];
					$this->load->view('backend/admin/stream_form',['data' => $studentData]) ?>
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" 
								value="<?=$studentData['name']?>">
						</div>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('gardian_name');?></label>
                        
						<div class="col-sm-5">
							<input type="text" value="<?=$studentData['gardian_name']?>" class="form-control" name="gardian_name" data-validate="required" data-message-required="<?php echo get_phrase('gardian_name');?>"autofocus>
						</div>
					</div>

					<div class="form-group">
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
								foreach($packagechunkV as $row):
							$instructor = $this->db->get_where('instructor',['instructor_id' => $row['instructor_id']])->row()->name;
							?>
                            		<input type="checkbox" id="vehicle1" name="package_id[]" data-validate="required" data-message-required="Package Required"value="<?=$row['package_id']?>" <?=(in_array($row['package_id'],json_decode($studentData['package_id'],true)))?'checked':''?>>
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
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('birthday');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control datepicker" name="birthday" 
								value="<?=$studentData['birthday']?>" 
									data-start-view="2">
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('gender');?></label>
                        
						<div class="col-sm-5">
							<select name="sex" class="form-control selectboxit">
							<?php
								$gender = $studentData['sex'];
							?>
                              <option value=""><?php echo get_phrase('select');?></option>
                              <option value="male" <?php if($gender == 'male')echo 'selected';?>><?php echo get_phrase('male');?></option>
                              <option value="female"<?php if($gender == 'female')echo 'selected';?>><?php echo get_phrase('female');?></option>
                              <option value="other"<?php if($gender == 'other')echo 'selected';?>><?php echo get_phrase('other');?></option>
                          </select>
						</div> 
					</div>
										
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('phone');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="phone" 
								value="<?=$studentData['phone']?>" >
						</div> 
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('whatsapp_number');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="whatsapp_number" 
								value="<?=$studentData['whatsapp_number']?>" >
						</div> 
					</div>
                    
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('email_address');?></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="email" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="<?=$studentData['email']?>">
						</div>
					</div>
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('blood_group');?></label>
                        
						<div class="col-sm-5">
							<select name="blood_group" class="form-control ">
                              <option value=""><?php echo get_phrase('select');?></option>
							  <?php 
							 	$bloodGroups = $this->db->get('blood_group')->result();
								foreach($bloodGroups as $key => $val){ 
							  ?>
                              <option value="<?=$val->blood_id?>" <?=($val->blood_id == $studentData['blood_group'])?'selected':''?> ><?=$val->name?></option>
							  <?php } ?>
                          </select>
						</div> 
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('nationality');?></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="nationality" data-validate="required" data-message-required="<?php echo get_phrase('nationality');?>" value="<?=$studentData['nationality']?>">
						</div>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('adhaar_number');?></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="adhaar_number" data-validate="required" data-message-required="<?php echo get_phrase('adhaar_number');?>" value="<?=$studentData['adhaar_number']?>">
						</div>
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('date_of_admission');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control datepicker" name="date_of_admission" data-start-view="2" value="<?=$studentData['date_of_admission']?>" >
						</div> 
					</div>
					<div class="col-md-12">
						<label ><?php echo get_phrase('permenent_address');?></label>
						<div class="form-group">
							<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('address_line_1');?> (House / Flatnumber & name)</label>
							
							<div class="col-md-5">
								<input type="text" class="form-control" name="address_line_1" value="<?=$studentData['address_line_1']?>" data-start-view="2">
							</div> 
						</div>
						<div class="form-group">
							<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('address_line_2');?> (Street Name, Post Office)</label>
							
							<div class="col-md-5">
								<input type="text" class="form-control" name="address_line_2" value="<?=$studentData['address_line_2']?>" data-start-view="2">
							</div> 
						</div>
						<div class="form-group">
							<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('address_line_3');?> (Place, City)</label>
							
							<div class="col-md-5">
								<input type="text" class="form-control" name="address_line_3" value="<?=$studentData['address_line_3']?>" data-start-view="2">
							</div> 
						</div>
						<div class="form-group">
							<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('address_line_4');?> (State, Country)</label>
							
							<div class="col-md-5">
								<input type="text" class="form-control" name="address_line_4" value="<?=$studentData['address_line_4']?>" data-start-view="2">
							</div> 
						</div>
						<div class="form-group">
							<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('pincode');?></label>
							
							<div class="col-md-5">
								<input type="text" class="form-control" name="pincode" value="<?=$studentData['pincode']?>" data-start-view="2">
							</div> 
						</div>
					</div>
					
					<div class="col-md-12">
						<label ><?php echo get_phrase('temporary_address');?></label>
						<div class="form-group">
							<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('address_line_1');?> (House / Flatnumber & name)</label>
							
							<div class="col-md-5">
								<input type="text" class="form-control" name="address_line_1_temp" value="<?=$studentData['address_line_1_temp']?>" data-start-view="2">
							</div> 
						</div>
						<div class="form-group">
							<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('address_line_2');?> (Street Name, Post Office)</label>
							
							<div class="col-md-5">
								<input type="text" class="form-control" name="address_line_2_temp" value="<?=$studentData['address_line_2_temp']?>" data-start-view="2">
							</div> 
						</div>
						<div class="form-group">
							<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('address_line_3');?> (Place, City)</label>
							
							<div class="col-md-5">
								<input type="text" class="form-control" name="address_line_3_temp" value="<?=$studentData['address_line_3_temp']?>" data-start-view="2">
							</div> 
						</div>
						<div class="form-group">
							<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('address_line_4');?> (State, Country)</label>
							
							<div class="col-md-5">
								<input type="text" class="form-control" name="address_line_4_temp" value="<?=$studentData['address_line_4_temp']?>" data-start-view="2">
							</div> 
						</div>
						<div class="form-group">
							<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('pincode');?></label>
							
							<div class="col-md-5">
								<input type="text" class="form-control" name="pincode_temp" value="<?=$studentData['pincode_temp']?>" data-start-view="2">
							</div> 
						</div>
					</div>

					<div class="col-md-12">
						<label ><?php echo get_phrase('other_details');?></label>
						<div class="form-group">
							<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('education_qualification');?></label>
							
							<div class="col-md-5">
								<input type="text" class="form-control" name="education_qualification" value="<?=$studentData['education_qualification']?>" >
							</div> 
						</div>
						<div class="form-group">
							<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('operating_rto')?></label>
							
							<div class="col-md-5">
								<input type="text" class="form-control" name="operating_rto" value="<?=$studentData['operating_rto']?>" >
							</div> 
						</div>
						<div class="form-group">
							<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('identification_mark 1')?></label>
							<?php
							$identification_mark = json_decode($studentData['identification_mark'], true); ?>
							<div class="col-md-5">
								<input type="text" class="form-control" name="identification_mark[]" value="<?=$identification_mark['0']?>" >
							</div> 
						</div>
						<div class="form-group">
							<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('identification_mark 2')?></label>
							
							<div class="col-md-5">
								<input type="text" class="form-control" name="identification_mark[]" value="<?=$identification_mark['1']?>" >
							</div> 
						</div>
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('settings');?></label>
						
						<div class="col-sm-5">
							<textarea id="settings" class="form-control col-sm-5" name="settings" rows="4" cols="50">
							<?=$studentData['settings']?>
							</textarea>
						</div>
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('status');?></label>
						<div class="col-sm-5">
							<select name="status" class="form-control ">
							<?php
								$gender = $studentData['sex'];
							?>
                              <option value=""><?php echo get_phrase('select');?></option>
							  <?php 
							 	$statusArray = $this->db->get('status_table')->result_array();
								foreach ($statusArray as $statusArraykey => $statusArrayvalue) { ?>
                              	<option value="<?=$statusArrayvalue['name']?>"><?=get_phrase($statusArrayvalue['name']);?></option>
								
								<?php
								} 
							  ?>
                          </select>
						</div> 
					</div>

					<div class="form-group">
						<div class="form-group">
							<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('licence_number')?></label>
							
							<div class="col-md-5">
								<input type="text" class="form-control" name="licence_number" value="<?=$row['licence_number']?>" >
							</div> 
						</div>
					</div>

					<div class="form-group">
						<div class="form-group">
							<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('learners_number')?></label>
							
							<div class="col-md-5">
								<input type="text" class="form-control" name="learners_number" value="<?=$row['learners_number']?>" >
							</div> 
						</div>
					</div>

					<div class="form-group">
						<div class="form-group">
							<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('driving_licence_number')?></label>
							
							<div class="col-md-5">
								<input type="text" class="form-control" name="driving_licence_number" value="<?=$row['driving_licence_number']?>" >
							</div> 
						</div>
					</div>

					<div class="form-group">
						<div class="form-group">
							<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('application_number')?></label>
							
							<div class="col-md-5">
								<input type="text" class="form-control" name="application_number" value="<?=$row['application_number']?>" >
							</div> 
						</div>
					</div>

                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo get_phrase('edit_student');?></button>
						</div>
					</div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>

<?php
endforeach;
?>

