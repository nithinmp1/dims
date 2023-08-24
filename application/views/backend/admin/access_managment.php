<hr />
<div class="row">
	<div class="col-md-12">
    
    	<!------CONTROL TABS START------>
		<ul class="nav nav-tabs bordered">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="entypo-menu"></i> 
					<?php echo get_phrase('access_list');?>
                    	</a></li>
			<li>
            	<a href="#add" data-toggle="tab"><i class="entypo-plus-circled"></i>
					<?php echo get_phrase('add_access');?>
                    	</a></li>
		</ul>
    	<!------CONTROL TABS END------>
        
		<div class="tab-content">
        <br>
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">
				
                <table class="table table-bordered datatable" id="table_export">
                	<thead>
                		<tr>
                    		<th><div>#</div></th>
                    		<th><div><?php echo get_phrase('access_name');?></div></th>
                    		<th><div><?php echo get_phrase('include');?></div></th>
                    		<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php 
                        $count = 1;foreach($access_controller as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>
							<td><?php echo $row['name'];?></td>
							<td><?php
                            $access = json_decode($row['access'],true);
                            foreach ($access as $key => $value) { ?>
                                <label><?=get_phrase($key)?></label>
                                <ul>
                                <?php foreach ($value as $val) { ?>
                                    <li><?=get_phrase($val)?></li>
                                <?php } ?>
                                </ul>
                            <?php }
                            ?></td>
							<td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                    
                                    <!-- EDITING LINK -->
                                    <li>
                                        <a href="<?php echo base_url();?>index.php?admin/access_management/edit/<?php echo $row['id'];?>">
                                            <i class="entypo-pencil"></i>
                                                <?php echo get_phrase('edit');?>
                                            </a>
                                                    </li>
                                    <li class="divider"></li>
                                    
                                    <!-- DELETION LINK -->
                                    <li>
                                        <a href="<?php echo base_url();?>index.php?admin/access_management/delete/<?php echo $row['id'];?>">
                                            <i class="entypo-trash"></i>
                                                <?php echo get_phrase('delete');?>
                                            </a>
                                                    </li>
                                </ul>
                            </div>
        					</td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
			</div>
            <!----TABLE LISTING ENDS--->
            
            
			<!----CREATION FORM STARTS---->
			<div class="tab-pane box" id="add" style="padding: 5px">
                <div class="box-content">
                	<?php echo form_open(base_url() . 'index.php?admin/access_management/create' , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                        <div class="padded">
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo get_phrase('name');?></label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">
                                    <?php echo get_phrase('access');?></label>
                                <div class="col-sm-6">
                                
                                  <?php 
                                  $accessJson = $this->crud_model->accessJson();
                                  $access = json_decode($accessJson,true);
                                  foreach ($access as $key => $value) {
                                   ?>
                                    <div id="faq" role="tablist" aria-multiselectable="true">
                                       <div class="panel panel-default">
                                          <div class="panel-heading" role="tab" id="questionOne">
                                             <h5 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#faq" href="#<?=$key?>" aria-expanded="false" aria-controls="<?=$key?>">
                                              <label class="form-check-label" for="flexCheckIndeterminate">
                                                <?=get_phrase($key)?>
                                              </label>
                                                </a>
                                             </h5>
                                          </div>
                                          <div id="<?=$key?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="questionOne">
                                             <div class="panel-body">
                                                <?php 
                                                foreach ($value as $val) { ?>
                                                    <input class="form-check-input" type="checkbox" value="<?=$val?>" id="flexCheckIndeterminate" name="access[<?=$key?>][]">
                                                    <label class="form-check-label" for="flexCheckIndeterminate">
                                                        <?=get_phrase($val)?>
                                                    </label>
                                                    <br/>
                                                <?php }
                                                ?>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                  <?php }
                                  ?>  
                            </div>
                        <div class="form-group">
                              <div class="col-sm-offset-3 col-sm-5">
                                  <button type="submit" class="btn btn-info"><?php echo get_phrase('add_access');?></button>
                              </div>
							</div>
                    </form>                
                </div>                
			</div>
			<!----CREATION FORM ENDS-->
		</div>
	</div>
</div>



<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">

	jQuery(document).ready(function($)
	{
		

		var datatable = $("#table_export").dataTable();
		
		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
	});
		
</script>