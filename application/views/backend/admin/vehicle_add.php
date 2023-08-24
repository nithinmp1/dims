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

				

                <?php echo form_open(base_url() . 'index.php?admin/vehicle/create/' , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>

	

					<div class="form-group">

						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('REG NO');?></label>

                        

						<div class="col-sm-5">

							<input type="text" class="form-control" name="REGNO" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus>

						</div>

					</div>



					<div class="form-group">

						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Vehicle Class');?></label>

                        

						<div class="col-sm-5">

							<input type="text" class="form-control" name="vehicleClass" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus>

						</div>

					</div>

					

					<div class="form-group">

						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('Fuel');?></label>

                        

						<div class="col-sm-5">

							<select name="fuel" class="form-control" data-validate="required" id="fuel" 

								data-message-required="<?php echo get_phrase('value_required');?>"

									>

                              <option value=""><?php echo get_phrase('select');?></option>

                              <?php 

								$classes = ['Petrol', 'Diesel', 'LPG', 'Electric','CNG' ];

								foreach($classes as $row):

									?>

                            		<option value="<?php echo $row;?>">

											<?php echo $row;?>

                                            </option>

                                <?php

								endforeach;

							  ?>

                          </select>

						</div> 

					</div>



					<div class="form-group">

						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Model Name');?></label>

                        

						<div class="col-sm-5">

							<input type="text" class="form-control" name="modelName" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus>

						</div>

					</div>



                    <div class="form-group">

						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Manufacturer Name');?></label>

                        

						<div class="col-sm-5">

							<input type="text" class="form-control" name="manufacturer" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus>

						</div>

					</div>

					

					<div class="form-group">

						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Registering Authority');?></label>

                        

						<div class="col-sm-5">

							<input type="text" class="form-control" name="registeringAuthority" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus>

						</div>

					</div>

					

                    <div class="form-group">

						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Owner Name');?></label>

                        

						<div class="col-sm-5">

							<input type="text" class="form-control" name="ownerName" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus>

						</div>

					</div>



                    <div class="form-group">

						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Registration Date');?></label>

                        

						<div class="col-sm-5">

							<input type="text" class="form-control datepicker" name="registrationDate"  autocomplete="off"  value="" data-start-view="2">

						</div>

					</div>



					<div class="form-group">

						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Fitness/REGN Date');?></label>

                        

						<div class="col-sm-5">

							<input type="text" class="form-control datepicker" name="REGNEXP" autocomplete="off"  value="" data-start-view="2">

						</div>

					</div>



                    <div class="form-group">

						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('MV Tax Date');?></label>

                        

						<div class="col-sm-5">

							<input type="text" class="form-control datepicker" name="MVTaxDate" autocomplete="off"  value="" data-start-view="2">

						</div>

					</div>

					<div class="form-group">

						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('PUCC_date');?></label>

                        

						<div class="col-sm-5">

							<input type="text" class="form-control datepicker" name="PUCC_date" autocomplete="off"  value="" data-start-view="2">

						</div>

					</div>



                    <div class="form-group">

						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Insurance Company');?></label>

                        

						<div class="col-sm-5">

							<input type="text" class="form-control" name="insuranceCompany"  data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus>

						</div>

					</div>



                    <div class="form-group">

						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Policy No');?></label>

                        

						<div class="col-sm-5">

							<input type="text" class="form-control" name="policyNo" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus>

						</div>

					</div>



                    <div class="form-group">

						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Validity');?></label>

                        

						<div class="col-sm-5">

							<input type="text" class="form-control datepicker" name="validity" autocomplete="off"  value="" data-start-view="2">

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



                    <div class="form-group">

						<div class="col-sm-offset-3 col-sm-5">

							<button type="submit" class="btn btn-info"><?php echo get_phrase('add_vehicle');?></button>

						</div>

					</div>

                <?php echo form_close();?>

            </div>

        </div>

    </div>

    <div class="col-md-4">

		<blockquote class="blockquote-blue">

			<p>

				<strong>Vehicle Admission Notes</strong>

			</p>

			<p>

				Admitting new vehicle will automatically create an enrollment to the selected class in the running session.

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



</script>