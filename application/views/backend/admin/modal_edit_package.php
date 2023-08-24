<?php 
$edit_data=$this->db->get_where('package' , array('package_id' => $param2) )->result_array();
foreach ( $edit_data as $row):
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
				
                <?php echo form_open(base_url() . 'index.php?admin/packages/do_update/'.$row['package_id'] , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                    <?php 
                    $data['data']  = $row;
                    // var_dump($data);die;
                    $this->load->view('backend/admin/stream_form',['data' => $row]) ?>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="name" value="<?php echo $row['name'];?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('amount');?></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="amount" value="<?php echo $row['amount'];?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('class Include');?></label>
                        <div class="col-sm-5">
                            <?php 
                            $where = $this->crud_model->setSplitWhere('class');
                             
                            $classes = $this->db->get_where('class',$where)->result_array();
                            $assignedClasses = json_decode($row['class_id'],true);
                            $allocatedTiem = json_decode($row['allocatedTiem'],true);
                            $allocatedClass = json_decode($row['allocatedClass'],true);
                            foreach($classes as $classesrow):
                                $instructor = $this->db->get_where('instructor',['instructor_id' => $classesrow['instructor_id']])->row()->name;
                                ?>
                                <input type="checkbox" id="vehicle1" name="class_id[]" value="<?=$classesrow['class_id']?>"
                                <?=(in_array($classesrow['class_id'],$assignedClasses)?'checked':'')?>
                                >
                                <label for="vehicle1"><?=$classesrow['name']?> by <?=$instructor?></label>
                                <br>
                                <br>
                                <select name="allocatedTiem[<?=$classesrow['class_id']?>]" id="cars">
                                    <option value="">select</option>
                                    <?php for($i = 1; $i < 100; $i++){ ?>
                                        <option value="<?=$i?>"
                                        <?=($allocatedTiem[$classesrow['class_id']] == $i)?'selected':''?>
                                        ><?php echo $i; ?> hours</option>
                                    <?php } ?>
                                </select>
                                <br>
                                <br>
                                <select name="allocatedClass[<?=$classesrow['class_id']?>]" id="cars">
                                    <option value="">Select No.Of Classes</option>
                                    <?php for($i = 1; $i < 100; $i++){ ?>
                                        <option value="<?=$i?>"
                                        <?=($allocatedClass[$classesrow['class_id']] == $i)?'selected':''?>
                                        ><?php echo $i; ?> clasess</option>
                                    <?php } ?>
                                </select>
                                <br>
                                <div id="section<?=$classesrow['class_id']?>">
                                    <?php 
                                        $section = $this->db->get_where('section',['class_id' => $classesrow['class_id']])->result_array();
                                        foreach ($section as $sectionK => $sectionV) {
                                    ?>
                                        </br>
                                        <input type="radio" id="selectedSection<?=$sectionV['section_id']?>" name="section[<?=$classesrow['class_id']?>][]" value="<?=$sectionV['section_id']?>"
                                        <?php 
                                        $packageSection = json_decode($row['section'], true);
                                        $packageClassId = json_decode($row['class_id'], true);
                                        if (in_array($classesrow['class_id'],$packageClassId) === true && $packageSection[$classesrow['class_id']][0] === $sectionV['section_id'] ) {
                                            echo "checked";
                                        }
                                        ?>
                                        >
                                        <label for="vehicle1"><?=$sectionV['name']?> </label> &nbsp;&nbsp;
                                    <?php
                                        }
                                    ?>
                                </div>
                            <?php
                            endforeach;
                            ?>
                        </div>
					</div>
            		<div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo get_phrase('edit_class');?></button>
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


