<?php 

$row		=	$this->db->get_where('enroll' , ['enroll_id' => $param2])->row_array();

?>

<div class="row">

	<div class="col-md-12">

		<div class="panel panel-primary" data-collapsed="0">

        	<div class="panel-heading">

            	<div class="panel-title" >

            		<i class="entypo-plus-circled"></i>

					<?php echo get_phrase('Add Attandance');?>

            	</div>

            </div>

			<div class="panel-body">

				

                <?php echo form_open(base_url() . 'index.php?admin/enroll/do_update/'.$row['enroll_id'] , array('enctype' => 'multipart/form-data'));

                ?>

                    <div class ="row">	

                        <div class="col-sm-6">

                            <a href="#" class="profile-picture">

                                <img src="<?php echo $this->crud_model->get_image_url('student' , $row['student_id']);?>" alt="..." class="img-responsive img-circle">

                            </a>

                        </div>



                        <div class="col-md-6">

                            <label for="field-1" class="col-sm-6 control-label">

                                <?php echo $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->name; ?> 

                            </label>

                        </div>

                        <div class="col-md-6">

                            <label for="field-1" class="col-sm-6 control-label">

                                <?php echo $this->db->get_where('class' , array('class_id' => $row['class_id']))->row()->name; ?>

                            </label>

                        </div>

                        <div class="col-md-6">

                            <label for="field-1" class="col-sm-6 control-label">

                                <?php echo $this->db->get_where('section' , array('section_id' => $row['section_id']))->row()->name; ?>

                            </label>

                        </div>

                        </div>

                        <div class ="row">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('hours');?></label>

                                    

                                    <div class="col-sm-5">

                                        <input type="number" min="0" max="12" class="form-control" name="hours"

                                            value="">

                                    </div>

                                </div>

                                </br>

                                </br>

                                <div class="form-group">

                                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('minutes');?></label>

                                    

                                    <div class="col-sm-5">

                                        <input type="number" min="0" max="60" class="form-control" name="minutes"

                                            value="">

                                        <input type="hidden" name="enrollId"

                                        value="<?=$row['enroll_id']?>">

                                    </div>

                                </div>

                                </br>

                                </br>

                                <div class="form-group">

                                    <label class="col-sm-3 control-label"><?php echo get_phrase('vehicle');?></label>

                                    <div class="col-sm-5">

                                        <select name="vehicle_id" class="form-control" style="width:100%;">

                                            <option value=""><?php echo get_phrase('select_vehicle');?></option>

                                            <?php 

                $where = $this->crud_model->setSplitWhere('vehicle');
                                        
                                            $vehicle = $this->db->get_where('vehicle',$where)->result_array();

                                            foreach($vehicle as $row):

                                            ?>

                                            <option value="<?php echo $row['id'];?>"><?php echo $row['vehicleClass'];?></option>

                                            <?php

                                            endforeach;

                                            ?>

                                        </select>

                                    </div>

                                </div>

                                        </br>

                                        </br>

                                <div class="form-group">

                                    <label class="col-sm-3 control-label"><?php echo get_phrase('instructor');?></label>

                                    <div class="col-sm-5">

                                        <select name="instructor_id" class="form-control " style="width:100%;">

                                            <option value=""><?php echo get_phrase('select_instructor');?></option>

                                            <?php 

                $where = $this->crud_model->setSplitWhere('instructor');
                                        

                                            $instructors = $this->db->get_where('instructor',$where)->result_array();

                                            foreach($instructors as $row):

                                            ?>

                                            <option value="<?php echo $row['instructor_id'];?>"><?php echo $row['name'];?></option>

                                            <?php

                                            endforeach;

                                            ?>

                                        </select>

                                    </div>

                                </div>

                                        </br>

                                        </br>

                                <div class="form-group">

                                    <div class="col-sm-5" style="padding-left: 419px;">

                                        <input type="submit" class="btn btn-info">

                                    </div>

                                </div>

                        </div>

                            

                        

                    </div>

                <?php echo form_close();?>

            </div>

        </div>

    </div>

</div>

