<hr />
<div class="row">
	<div class="col-md-12">
    
    	<!------CONTROL TABS START------>
		<ul class="nav nav-tabs bordered">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="entypo-menu"></i> 
					<?php echo get_phrase('package_list');?>
                    	</a></li>
			<li>
            	<a href="#add" data-toggle="tab"><i class="entypo-plus-circled"></i>
					<?php echo get_phrase('add_package');?>
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
                    		<th><div><?php echo get_phrase('package_name');?></div></th>
                    		<th><div><?php echo get_phrase('amount');?></div></th>
                            <th><div><?php echo get_phrase('stream');?></div></th>
                    		<th><div><?php echo get_phrase('desc');?></div></th>
                    		<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php 
                        $count = 1;foreach($package as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>
							<td><?php echo $row['name'];?></td>
							<td><?php echo $row['amount'];?></td>
							<td><?php 
                                $stream = $this->db->get_where('stream',['stream_id' => $row['stream_id']])->row_array();
                                echo $stream['name'];
                            ?>
                            </td>
							<td>
                               <?php
                               $allocatedClass = json_decode( $row['allocatedClass'],true);
                                foreach($allocatedClass as $allocatedClassK => $allocatedClassV) {
                                    $class = $this->db->get_where('class',['class_id' => $allocatedClassK])->row_array();
                                    echo $class['name'].' - '. $allocatedClassV." Classes<br>";
                                    $sections = json_decode($row['section'],true);
                                    foreach ($sections as $sectionsK => $sectionsV) {
                                        if ($allocatedClassK === $sectionsK) {
                                            $this->db->where_in('section_id',$sectionsV);
                                            $sectionDet = $this->db->get('section')->result_array();
                                            echo "Section's are :&nbsp;&nbsp;";
                                            foreach ($sectionDet as $sectionDetK => $sectionDetV) {
                                                echo $sectionDetV['name']." ,";
                                            }
                                        } 
                                    }
                                    echo "<br>";
                                    }

                               ?> 
                            </td>
                            <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                    
                                    <!-- EDITING LINK -->
                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_edit_package/<?php echo $row['package_id'];?>');">
                                            <i class="entypo-pencil"></i>
                                                <?php echo get_phrase('edit');?>
                                            </a>
                                                    </li>
                                    <li class="divider"></li>
                                    
                                    <!-- DELETION LINK -->
                                    <li>
                                        <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/packages/delete/<?php echo $row['package_id'];?>');">
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
                	<?php echo form_open(base_url() . 'index.php?admin/packages/create' , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                        <div class="padded">
                            <?php $this->load->view('backend/admin/stream_form') ?>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('amount');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="amount"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('class Include');?></label>
                            <div class="col-sm-5">
                              <?php 
                $where = $this->crud_model->setSplitWhere('class');
							  	 
								$classes = $this->db->get_where('class',$where)->result_array();
								// echo $this->db->last_query();die;
								foreach($classes as $row):
									$instructor = $this->db->get_where('instructor',['instructor_id' => $row['instructor_id']])->row()->name;
									?>
                            		<input type="checkbox" id="classId<?=$row['class_id']?>" onclick="showSection(<?=$row['class_id']?>)" name="class_id[]" value="<?=$row['class_id']?>">
									<label for="vehicle1"><?=$row['name']?> by <?=$instructor?></label> &nbsp;&nbsp;
                                    <select name="allocatedTiem[<?=$row['class_id']?>]" id="cars">
                                        <option value="">Select Hour</option>
                                        <?php for($i = 1; $i < 100; $i++){ ?>
                                            <option value="<?=$i?>"><?php echo $i; ?> hours</option>
                                        <?php } ?>
                                    </select>
                                    <select name="allocatedClass[<?=$row['class_id']?>]" id="cars">
                                        <option value="">Select No.Of Classes</option>
                                        <?php for($i = 1; $i < 100; $i++){ ?>
                                            <option value="<?=$i?>"><?php echo $i; ?> class</option>
                                        <?php } ?>
                                    </select>
                                    <br>
                                    <div id="section<?=$row['class_id']?>" style="display :none">
                                        <?php 
                                            $section = $this->db->get_where('section',['class_id' => $row['class_id']])->result_array();
                                            foreach ($section as $sectionK => $sectionV) {
                                        ?>
                                            <input checked type="radio" id="selectedSection<?=$sectionV['section_id']?>" name="section[<?=$row['class_id']?>][]" value="<?=$sectionV['section_id']?>">
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
                        </div>
                        <div class="form-group">
                              <div class="col-sm-offset-3 col-sm-5">
                                  <button type="submit" class="btn btn-info"><?php echo get_phrase('add_package');?></button>
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
		function showSection(classId){
            $checked = $('#classId'+classId).is(':checked');
            if ($checked) {
            console.log('hit');

                $('#section'+classId).show();
            } else {
                console.log('hit1');
                $('#section'+classId).hide();
            }
        }
</script>