<hr />
<div class="row">
	<div class="col-md-12">
    
    	<!------CONTROL TABS START------>
		<ul class="nav nav-tabs bordered">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="entypo-menu"></i> 
					<?php echo get_phrase('exam_list');?>
                    	</a></li>
			<li>
            	<a href="#add" data-toggle="tab"><i class="entypo-plus-circled"></i>
					<?php echo get_phrase('add_exam');?>
                    	</a></li>
		</ul>
    	<!------CONTROL TABS END------>
		<div class="tab-content">
        <br>
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">
                <!-- <table  class="table table-bordered datatable" id="table_export"> -->
                    <table class="table table-bordered datatable dataTable" id="table_export" aria-describedby="table_export_info">
                	<thead>
                		<tr>
                            <th><div><?php echo get_phrase('SI NO');?></div></th>
                    		<th><div><?php echo get_phrase('student_name');?></div></th>
                            <th><div><?php echo get_phrase('exam_type');?></div></th>
                            <th><div><?php echo get_phrase('phone_number');?></div></th>
                            <th><div><?php echo get_phrase('application_number');?></div></th>
                    		<th><div><?php echo get_phrase('dob');?></div></th>
                    		<th><div><?php echo get_phrase('package');?></div></th>
                    		<th><div><?php echo get_phrase('status');?></div></th>
                    		<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php
                        $i = 1;
                         foreach($exams as $row):?>
                        <tr>
                            <td><?=$i?></td>
							<td><?php
                                $i ++;
                                $student = $this->db->get_where('student',['student_id' => $row['student_id']])->row();
                                echo $student->name;?></td>
							<td><?php 
                                $examType = $this->db->get_where('exam_type',['exam_type_id' => $row['exam_type_id']])->row();
                                echo $examType->name;?></td>
                            <td><?=$student->phone?></td>
                            <td><?=$student->application_number?></td>
							<td><?=$student->birthday?></td>
							<td>
                                <?php 
                                $package_id = json_decode($student->package_id, true);
                                if (!empty($package_id)) {
                                    $this->db->where_in('package_id',$package_id);
                                    $packages = $this->db->get('package')->result_array();
                                    if (!empty($packages)) {
                                        $packgeNames = array_column($packages,'name'); 
                                    }
                                }
                                echo implode(" ,", $packgeNames);
                                ?>
                            </td>
							<td><?php echo $row['status'];?></td>
							<td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                    
                                    <!-- EDITING LINK -->
                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_edit_exam/<?php echo $row['exam_id'];?>');">
                                            <i class="entypo-pencil"></i>
                                                <?php echo get_phrase('edit');?>
                                            </a>
                                                    </li>
                                    <li class="divider"></li>
                                    
                                    <!-- DELETION LINK -->
                                    <li>
                                        <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/exam/delete/<?php echo $row['exam_id'];?>');">
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
                	<?php echo form_open(base_url() . 'index.php?admin/exam/do_create' , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"> <?php echo get_phrase('student');?> </label>
                                <div class="col-sm-5">
                                <select name="student_id" class="form-control select2" style="width:100%;">
                                    <option>Select</option> 
                                    <?php 
                                    $examType = $this->db->get('student')->result();
                                    foreach($examType as $examTypeK=> $examTypeV){
                                    ?> 
                                        <option value="<?=$examTypeV->student_id?>"> <?=$examTypeV->name?> </option>
                                    <?php } ?>
                                </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"> <?php echo get_phrase('exam');?> </label>
                                <div class="col-sm-5">
                                <select name="exam_type_id" class="form-control select2" style="width:100%;">
                                    <option>Select</option> 
                                    <?php 
                                    $examType = $this->db->get('exam_type')->result();
                                    foreach($examType as $examTypeK=> $examTypeV){
                                    ?> 
                                        <option value="<?=$examTypeV->exam_type_id?>"> <?=$examTypeV->name?> </option>
                                    <?php } ?>
                                </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('date');?></label>
                                <div class="col-sm-5">
                                    <input type="text" id= "date_due" class="form-control" name="examDate" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                                </div>

                                <script type="text/javascript">
                                $(document).ready(function() {
                                    $('#date_due').datepicker({ format: "dd/mm/yyyy" });
                                }); 
                                </script>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('venue');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="venue"/>
                                </div>
                            </div>
                        		<div class="form-group">
                              	<div class="col-sm-offset-3 col-sm-5">
                                  <button type="submit" class="btn btn-info"><?php echo get_phrase('add_exam');?></button>
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
		var datatable = $("#table_export").dataTable({
            "sPaginationType": "bootstrap",
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
            "oTableTools": {
                "aButtons": [

                    {
                        "sExtends": "xls",
                        "mColumns": [0, 2, 3, 4]
                    },
                    {
                        "sExtends": "pdf",
                        "mColumns": [0, 2, 3, 4]
                    },
                    {
                        "sExtends": "print",
                        "fnSetText": "Press 'esc' to return",
                        "fnClick": function (nButton, oConfig) {
                            datatable.fnSetColumnVis(1, false);
                            datatable.fnSetColumnVis(5, false);

                            this.fnPrint(true, oConfig);

                            window.print();

                            $(window).keyup(function (e) {
                                if (e.which == 27) {
                                    datatable.fnSetColumnVis(1, true);
                                    datatable.fnSetColumnVis(5, true);
                                }
                            });
                        },

                    },
                ]
            },

        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });
	});
		
</script>
