<div class="profile-env">
  <header class="row">
    <?php $this->load->view('backend/admin/customer_profile_pic') ?>
  </header>
  <br />
  <div class="row">
    <div class="col-md-12">
      <ul class="nav nav-tabs bordered">
        <li class="active">
          <a href="#task_lists" data-toggle="tab">
            <i class="entypo-menu"></i> <?php echo get_phrase('task_list');?> </a>
        </li>
        <li>
          <a href="#add_task" data-toggle="tab">
            <i class="entypo-plus-circled"></i> <?php echo get_phrase('add_task');?> </a>
        </li>
      </ul>
      <div class="tab-content">
        <br>
        <!----TABLE LISTING STARTS-->
        <div class="tab-pane box active" id="task_lists">
          <table class="table table-bordered datatable" id="table_export">
            <thead>
              <tr>
                <th width="80"><div><?php echo get_phrase('SI NO'); ?></div></th>
                <th><div><?php echo get_phrase('Name'); ?></div></th>
                <th><div><?php echo get_phrase('article_number'); ?></div></th>
                <th class="span3"><div><?php echo get_phrase('Status'); ?></div></th>
                <th><div><?php echo get_phrase('extimate_date'); ?></div></th>
                <th><div><?php echo get_phrase('options'); ?></div></th>
              </tr>
            </thead>
                <tbody>
                <?php 
                $customerServ = $this->db->order_by('service_list_id','desc')->get_where('customer_service_list',['customer_id' => $customer_id, 'status' => 'pending'])->result_array();
                $servId = array_column($customerServ,'customer_service_id');
                if( !empty($servId)) {
                $this->db->where_in('customer_service_id',$servId);
                $tasks = $this->db->get_where('customer_task_list',['customer_id' => $customer_id])->result_array();
                foreach($tasks as $enroll_dataK => $rowV){
                  // echo "<pre>";print_r($rowV);die;
                    $enroll_dataV = $this->db->get_where('customer_task',['customer_task_id'=>$rowV['task_id']])->row_array();
                ?>
                    <tr>
                        <td><?=$enroll_dataK+1?></td>
                        <td><?=$enroll_dataV['name']?></td>
                        <td><?=$rowV['article_number']?></td>
                        <td><?=($rowV['status'] == '')?'NILL':$rowV['status']?></td>
                        <td>
                            <?=$rowV['extimate_date']?>
                        </td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                    <!-- customer MARKSHEET LINK  -->
                                    <li>
                                      <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/customer_task_edit/<?=$rowV['task_list_id'] ?>');">
                                            <i class="entypo-pencil"></i>
                                            <?php echo get_phrase('Edit'); ?>
                                        </a>
                                    </li>
                                    <!-- customer PROFILE LINK -->
                                    <li>
                                        
                                        <a href="<?php echo base_url(); ?>index.php?admin/customer_task_list/delete/<?php echo $rowV['task_list_id']; ?>">
                                            <i class="entypo-trash"></i>
                                            <?php echo get_phrase('Delete'); ?>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php    
                }
                }
                ?>
                </tbody>            

            </table>
        </div>
        <!----TABLE LISTING ENDS--->
        <!----CREATION FORM STARTS---->
        <div class="tab-pane box" id="add_task" style="padding: 5px">
          <div class="box-content"> 
            <?php
            echo form_open(base_url() . 'index.php?admin/customer_task_list/create' , 
            array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'),
            ['customer_id' => $customer_data['customer_id'],'status' => 'Pending']);?> <div class="padded">
              <div class="form-group">
                <label class="col-sm-3 control-label"> <?php echo get_phrase('service');?> </label>
                <div class="col-sm-5">
                  <select name="customer_service_list_id" class="form-control select2" style="width:100%;">
                    <option>Select</option> 
                    <?php
                    
                    foreach($customerServ as $customer_service_listK=> $customer_service_listV){
                      $sevice = $this->db->get_where('customer_service',['customer_service_id' => $customer_service_listV['customer_service_id']])->row();
                    ?> 
                        <option value="<?=$customer_service_listV['service_list_id']?>"> <?=$sevice->name?> </option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label"> <?php echo get_phrase('task');?> </label>
                <div class="col-sm-5">
                  <select name="task_id" class="form-control select2" style="width:100%;">
                    <option>Select</option> 
                    <?php 
                    $examType = $this->db->get('customer_task')->result();
                    foreach($examType as $examTypeK=> $examTypeV){
                    ?> 
                        <option value="<?=$examTypeV->customer_task_id?>"> <?=$examTypeV->name?> </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label"> <?php echo get_phrase('date');?> </label>
                <div class="col-sm-5">
                  <input type="text" class="form-control datepicker" name="extimate_date" value="" data-start-view="2">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label"> <?php echo get_phrase('article_number');?> </label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="article_number" value="">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo get_phrase('notes');?></label>
                <div class="col-sm-5">
                  <textarea id="notes" class="form-control" name="notes" rows="4" cols="50">
                  </textarea>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-3 col-sm-5">
                <button type="submit" class="btn btn-info"> <?php echo get_phrase('add_task');?> </button>
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