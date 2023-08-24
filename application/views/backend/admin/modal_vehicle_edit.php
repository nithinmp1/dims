<?php 

$edit_data		=	$this->db->get_where('vehicle' , array('id' => $param2) )->result_array();

// echo "<pre>";print_r($edit_data);die;

foreach ( $edit_data as $row):

?>

<div class="row">

	<div class="col-md-12">

		<div class="panel panel-primary" data-collapsed="0">

        	<div class="panel-heading">

            	<div class="panel-title" >

            		<i class="entypo-plus-circled"></i>

					<?php echo get_phrase('edit_vehicle');?>

            	</div>

            </div>

			<div class="panel-body">

                    <?php echo form_open(base_url() . 'index.php?admin/vehicle/do_update/'.$row['id'] , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top', 'enctype' => 'multipart/form-data'));?>

                        		

                                <div class="form-group">

                                <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('photo');?></label>

                                

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

                                <label class="col-sm-3 control-label"><?php echo get_phrase('REG NO');?></label>

                                <div class="col-sm-5">

                                    <input type="text" class="form-control" name="REGNO" value="<?php echo $row['REGNO'];?>"/>

                                </div>

                            </div>

                            

                            <div class="form-group">

                                <label class="col-sm-3 control-label"><?php echo get_phrase('Vehicle Class');?></label>

                                <div class="col-sm-5">

                                    <input type="text" class="form-control" name="vehicleClass" value="<?php echo $row['vehicleClass'];?>"/>

                                </div>

                            </div>

                            <div class="form-group">

                                <label class="col-sm-3 control-label"><?php echo get_phrase('Manufacturer');?></label>

                                <div class="col-sm-5">

                                    <input type="text" class="datepicker form-control" name="manufacturer" value="<?php echo $row['manufacturer'];?>"/>

                                </div>

                            </div>

                            <div class="form-group">

                                <label class="col-sm-3 control-label"><?php echo get_phrase('Fuel');?></label>

                                <div class="col-sm-5">

                                <select name="fuel" class="form-control" data-validate="required" id="fuel" 

                                        data-message-required="<?php echo get_phrase('value_required');?>"

                                            >

                                    <option value=""><?php echo get_phrase('select');?></option>

                                    <?php 

                                        $classes = ['Petrol', 'Diesel', 'LPG', 'Electric' ];

                                        foreach($classes as $clas):

                                            ?>

                                                <option value="<?php echo $clas;?>" <?=($clas == $row['fuel'])?'selected':''?>>

                                                    <?php echo $clas;?>

                                                </option>

                                        <?php

                                        endforeach;

                                    ?>

                                </select>

                                </div>

                            </div>

                            <div class="form-group">

                                <label class="col-sm-3 control-label"><?php echo get_phrase('Registering Authority');?></label>

                                <div class="col-sm-5">

                                    <input type="text" class="form-control" name="registeringAuthority" value="<?php echo $row['registeringAuthority'];?>"/>

                                </div>

                            </div>

                            <div class="form-group">

                                <label class="col-sm-3 control-label"><?php echo get_phrase('Owner Name');?></label>

                                <div class="col-sm-5">

                                    <input type="text" class="form-control" name="ownerName" value="<?php echo $row['ownerName'];?>"/>

                                </div>

                            </div>

                            <div class="form-group">

                                <label class="col-sm-3 control-label"><?php echo get_phrase('Registration Date');?></label>

                                <div class="col-sm-5">

                                    <input type="text" class="form-control datepicker" data-start-view="2" name="registrationDate" value="<?php echo $row['registrationDate'];?>"/>

                                </div>

                            </div>

                            <div class="form-group">

                                <label class="col-sm-3 control-label"><?php echo get_phrase('REGN EXP Date');?></label>

                                <div class="col-sm-5">

                                    <input type="text" class="form-control datepicker" data-start-view="2" name="REGNEXP" value="<?php echo $row['REGNEXP'];?>"/>

                                </div>

                            </div>

                            <div class="form-group">

                                <label class="col-sm-3 control-label"><?php echo get_phrase('MV Tax Date');?></label>

                                <div class="col-sm-5">

                                    <input type="text" class="form-control datepicker" data-start-view="2" name="MVTaxDate" value="<?php echo $row['MVTaxDate'];?>"/>

                                </div>

                            </div>

                            <div class="form-group">

                                <label class="col-sm-3 control-label"><?php echo get_phrase('MV PUCC_date');?></label>

                                <div class="col-sm-5">

                                    <input type="text" class="form-control datepicker" data-start-view="2" name="PUCC_date" value="<?php echo $row['PUCC_date'];?>"/>

                                </div>

                            </div>

                            <div class="form-group">

                                <label class="col-sm-3 control-label"><?php echo get_phrase('Insurance Company');?></label>

                                <div class="col-sm-5">

                                    <input type="text" class="form-control" name="insuranceCompany" value="<?php echo $row['insuranceCompany'];?>"/>

                                </div>

                            </div>

                            <div class="form-group">

                                <label class="col-sm-3 control-label"><?php echo get_phrase('Policy No');?></label>

                                <div class="col-sm-5">

                                    <input type="text" class="form-control" name="policyNo" value="<?php echo $row['policyNo'];?>"/>

                                </div>

                            </div>

                            <div class="form-group">

                                <label class="col-sm-3 control-label"><?php echo get_phrase('Validity');?></label>

                                <div class="col-sm-5">

                                    <input type="text" class="form-control datepicker" data-start-view="2" name="validity" value="<?php echo $row['validity'];?>"/>

                                </div>

                            </div>

                            <div class="form-group">

                                <label class="col-sm-3 control-label"><?php echo get_phrase('Status');?></label>

                                <div class="col-sm-5">

                                <select name="status" class="form-control" data-validate="required" id="status" 

                                        data-message-required="<?php echo get_phrase('value_required');?>"

                                            >

                                    <option value=""><?php echo get_phrase('select');?></option>

                                    <?php 

                                        $classes = ['active', 'in-active'];

                                        foreach($classes as $clas):

                                            ?>

                                                <option value="<?php echo $clas;?>" <?=($clas == $row['status'])?'selected':''?>>

                                                    <?php echo $clas;?>

                                                </option>

                                        <?php

                                        endforeach;

                                    ?>

                                </select>

                                </div>

                            </div>

                        <div class="form-group">

                            <div class="col-sm-offset-3 col-sm-5">

                                <button type="submit" class="btn btn-info"><?php echo get_phrase('edit_vehicle');?></button>

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