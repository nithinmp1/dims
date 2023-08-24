<?php 
$edit_data		=	$this->db->get_where('customer_enquiry_list' , array('customer_enquiry_id' => $param2) )->result_array();
foreach ( $edit_data as $row):
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('edit_enquiry');?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(base_url() . 'index.php?admin/customer_enquiry/do_update/'.$row['customer_enquiry_id'] , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
            <div class="padded">
              <div class="form-group">
                <label class="col-sm-3 control-label"> <?php echo get_phrase('date');?> </label>
                <div class="col-sm-5">
                  <input type="text" class="form-control datepicker" name="extimate_date" value="<?=$row['extimate_date']?>" data-start-view="2">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo get_phrase('notes');?></label>
                <div class="col-sm-5">
                  <textarea id="notes" class="form-control" name="enquiry" rows="4" cols="50">
                    <?=$row['customer_enquiry']?>
                  </textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo get_phrase('notes');?></label>
                <div class="col-sm-5">
                  <textarea id="notes" class="form-control" name="notes" rows="4" cols="50">
                    <?=$row['notes']?>
                  </textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label"> <?php echo get_phrase('status');?> </label>
                <div class="col-sm-5">
                  <select name="status" class="form-control" style="width:100%;">
                    <option>Select</option> 
                    <?php 
                    $examType = ['Pending', 'Initiated', 'Final Stage', 'Completed'];
                    foreach($examType as $examTypeK=> $examTypeV){
                    ?> 
                        <option value="<?=$examTypeV?>" <?=($examTypeV == $row['status'])?'checked':''?> > <?=$examTypeV?> </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                      <button type="submit" class="btn btn-info"><?php echo get_phrase('edit_enquiry');?></button>
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