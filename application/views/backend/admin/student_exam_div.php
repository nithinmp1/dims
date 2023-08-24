<div class="profile-env">
  <header class="row">
    <div class="col-sm-3">
      <a href="#" class="profile-picture">
        <img src="
					<?php echo $this->crud_model->get_image_url('student', $student_data['student_id']); ?>" class="img-responsive img-circle" />
      </a>
    </div>
    <div class="col-sm-9">
      <ul class="profile-info-sections">
        <li style="padding:0px; margin:0px;">
          <div class="profile-name">
            <h3> <?php echo $this->db->get_where('student', array('student_id' => $param2))->row()->name; ?> </h3>
          </div>
        </li>
      </ul>
    </div>
  </header>
  <br />
  <div class="row">
    <div class="col-md-12">
      <ul class="nav nav-tabs bordered">
        <li class="active">
          <a href="#list" data-toggle="tab">
            <i class="entypo-menu"></i> <?php echo get_phrase('exam_list');?> </a>
        </li>
        <li>
          <a href="#add" data-toggle="tab">
            <i class="entypo-plus-circled"></i> <?php echo get_phrase('add_exam');?> </a>
        </li>
      </ul>
      <div class="tab-content">
        <br>
        <!----TABLE LISTING STARTS-->
        <div class="tab-pane box active" id="list">
          <table class="table table-bordered datatable" id="table_export">
            <thead>
              <tr>
                <th>
                  <div>#</div>
                </th>
                <th>
                  <div> <?php echo get_phrase('exam_name');?> </div>
                </th>
                <th>
                  <div> <?php echo get_phrase('date');?> </div>
                </th>
                <th>
                  <div> <?php echo get_phrase('venue');?> </div>
                </th>
                <th>
                  <div> <?php echo get_phrase('options');?> </div>
                </th>
              </tr>
            </thead>
            <tbody>
                <?php
                $exams = $this->db->get_where('exam',['student_id' => $student_data['student_id']])->result_array();
                $count = 1;foreach($exams as $row):?> <tr>
                <td> <?php echo $count++;?> </td>
                <td> <?php echo $row['exam_type_id'];?> </td>
                <td> <?php echo $row['date'];?> </td>
                <td> <?php echo $row['venue'];?> </td>
                <td>
                  <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"> Action <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                      <!-- EDITING LINK -->
                      <li>
                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_edit_exam/<?php echo $row['exam_id'];?>');">
                          <i class="entypo-pencil"></i> <?php echo get_phrase('edit');?> </a>
                      </li>
                      <li class="divider"></li>
                      <!-- DELETION LINK -->
                      <li>
                        <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/exam/delete/<?php echo $row['exam_id'];?>');">
                          <i class="entypo-trash"></i> <?php echo get_phrase('delete');?> </a>
                      </li>
                    </ul>
                  </div>
                </td>
              </tr> <?php endforeach;?> </tbody>
          </table>
        </div>
        <!----TABLE LISTING ENDS--->
        <!----CREATION FORM STARTS---->
        <div class="tab-pane box" id="add" style="padding: 5px">
          <div class="box-content"> <?php echo form_open(base_url() . 'index.php?admin/exam/create' , 
        array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'),['student_id' => $student_data['student_id']]);?> <div class="padded">
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
                <label class="col-sm-3 control-label"> <?php echo get_phrase('date');?> </label>
                <div class="col-sm-5">
                  <input type="text" class="form-control datepicker" name="examDate" value="" data-start-view="2">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label"> <?php echo get_phrase('venue');?> </label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="venue" value="">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-3 col-sm-5">
                <button type="submit" class="btn btn-info"> <?php echo get_phrase('add_exam');?> </button>
              </div>
            </div>
            </form>
          </div>
        </div>
        <!----CREATION FORM ENDS-->
      </div>
    </div>
  </div>
</div>