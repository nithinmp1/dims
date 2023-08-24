<?php 
$edit_data		=	$this->db->get_where('customer_service' , array('customer_service_id' => $param2) )->result_array();
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
				
                <?php echo form_open(base_url() . 'index.php?admin/customer_service/do_update/'.$row['customer_service_id'] , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                    <?php $this->load->view('backend/admin/stream_form',['data' => $row]) ?>

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


