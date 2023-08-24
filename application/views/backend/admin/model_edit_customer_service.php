<?php 
$edit_data=	$this->db->get_where('customer_service_list' , array('service_list_id' => $param2) )->result_array();
foreach ( $edit_data as $row):
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('edit_service');?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(base_url() . 'index.php?admin/customer_service_list/do_update/'.$row['service_list_id'] , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('article_number');?></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="article_number" value="<?php echo $row['article_number'];?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('tottalFee');?></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="tottalFee" value="<?php echo $row['tottalFee'];?>"/>
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

                        <label class="col-sm-3 control-label"> <?php echo get_phrase('date_of_issue');?> </label>

                        <div class="col-sm-5">

                          <input type="text" class="form-control datepicker" name="date_of_issue" value="<?=$row['date_of_issue']?>" data-start-view="2">

                        </div>

                      </div>
                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo get_phrase('customer_service');?></button>
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


