<?php 
$edit_data		=	$this->db->get_where('follow_up' , array('follow_up_id ' => $param2) )->result_array();
foreach ( $edit_data as $row):
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('edit_follow_up');?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(base_url() . 'index.php?admin/customer_follow_up/do_update/'.$row['follow_up_id'] , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
            <div class="padded">
                <div class="form-group">
                <label class="col-sm-3 control-label"> <?php echo get_phrase('date');?> </label>
                <div class="col-sm-5">
                  <input type="text" class="form-control datepicker" name="follow_up_on" value="<?=$row['follow_up_on']?>" data-start-view="2">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo get_phrase('remark');?></label>
                <div class="col-sm-5">
                  <textarea id="notes" class="form-control" name="remarks" rows="4" cols="50">
                    <?=$row['remark']?>
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
                        <option value="<?=$examTypeV?>" <?=($examTypeV == $row['status'])?'selected':''?> > <?=$examTypeV?> </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                      <button type="submit" class="btn btn-info"><?php echo get_phrase('edit_follow_up');?></button>
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