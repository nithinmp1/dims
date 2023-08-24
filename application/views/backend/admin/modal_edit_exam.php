<?php 
$edit_data		=	$this->db->get_where('exam' , array('exam_id' => $param2) )->result_array();
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
				
                <?php echo form_open(base_url() . 'index.php?admin/exam/edit/do_update/'.$row['exam_id'] , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
            <div class="padded">
            <div class="form-group">
                <label class="col-sm-3 control-label"> <?php echo get_phrase('exam');?> </label>
                <div class="col-sm-5">
                <?php 
                $examType = $this->db->get_where('exam_type',['exam_type_id' => $row['exam_type_id']])->row();
                ?>
                    <input type="text" class="form-control" name="venue" value="<?=$examType->name?>" disabled>
                </div>
              </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('date');?></label>
                    <div class="col-sm-5">
                        <input type="text" id="date_due" class="form-control" name="date" value="<?php echo $row['date'];?>" data-start-view="2"/>
                    </div>
                    <script type="text/javascript">
                                $(document).ready(function() {
                                    $('#date_due').datepicker({ format: "dd/mm/yyyy" });
                                }); 
                                </script>
                </div>
                <div class="form-group">
                <label class="col-sm-3 control-label"> <?php echo get_phrase('venue');?> </label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="venue" value="<?=$row['venue']?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label"> <?php echo get_phrase('status');?> </label>
                <div class="col-sm-5">
                  <select name="status" class="form-control" style="width:100%;">
                    <option>Select</option> 
                    <?php 
                    $examType = ['Pass', 'Fail', 'Postponed', 'Slot Allocated'];
                    foreach($examType as $examTypeK=> $examTypeV){
                    ?> 
                        <option value="<?=$examTypeV?>" <?=($examTypeV == $row['status'])?'checked':''?> > <?=$examTypeV?> </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                      <button type="submit" class="btn btn-info"><?php echo get_phrase('edit_exam');?></button>
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





