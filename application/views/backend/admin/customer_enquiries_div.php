<div class="profile-env">
  <header class="row">
    <?php $this->load->view('backend/admin/customer_profile_pic') ?>
  </header>
  <br />
  <div class="row">
    <div class="col-md-12">
      <ul class="nav nav-tabs bordered">
        <li class="active">
          <a href="#enquiry_list" data-toggle="tab">
            <i class="entypo-menu"></i> <?php echo get_phrase('enquiry_list');?> </a>
        </li>
        <li>
          <a href="#add_enquiry" data-toggle="tab">
            <i class="entypo-plus-circled"></i> <?php echo get_phrase('add_enquiry');?> </a>
        </li>
      </ul>
      <div class="tab-content">
        <br>
        <!----TABLE LISTING STARTS-->
        <div class="tab-pane box active" id="enquiry_list">
          <table class="table table-bordered datatable" id="table_export">
            <thead>
              <tr>
                <th width="80"><div><?php echo get_phrase('SI NO'); ?></div></th>
                <th><div><?php echo get_phrase('Enquiry'); ?></div></th>
                <th class="span3"><div><?php echo get_phrase('Status'); ?></div></th>
                <th><div><?php echo get_phrase('extimate_date'); ?></div></th>
                <th><div><?php echo get_phrase('notes'); ?></div></th>
                <th><div><?php echo get_phrase('options'); ?></div></th>
              </tr>
            </thead>
                <tbody>
                <?php 
                $customerServ = $this->db->order_by('customer_enquiry_id','desc')->get_where('customer_enquiry_list',['customer_id' => $customer_id])->result_array();
                foreach($customerServ as $enroll_dataK => $rowV){
                ?>
                    <tr>
                        <td><?=$enroll_dataK+1?></td>
                        <td><?=$rowV['customer_enquiry']?></td>
                        <td><?=($rowV['status'] == '')?'NILL':$rowV['status']?></td>
                        <td><?=$rowV['extimate_date']?></td>
                        <td><?=$rowV['notes']?></td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                    <!-- customer MARKSHEET LINK  -->
                                    <li>
                                      <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/customer_enquiry_edit/<?=$rowV['customer_enquiry_id'] ?>');">
                                            <i class="entypo-pencil"></i>
                                            <?php echo get_phrase('Edit'); ?>
                                        </a>
                                    </li>
                                    <!-- customer PROFILE LINK -->
                                    <li>
                                        
                                        <a href="<?php echo base_url(); ?>index.php?admin/customer_enquiry/delete/<?php echo $rowV['customer_enquiry_id']; ?>">
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
                ?>
                </tbody>            

            </table>
        </div>
        <!----TABLE LISTING ENDS--->
        <!----CREATION FORM STARTS---->
        <div class="tab-pane box" id="add_enquiry" style="padding: 5px">
          <div class="box-content"> 
            <?php
            echo form_open(base_url() . 'index.php?admin/customer_enquiry/profile_create' , 
            array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'),
            ['customer_id' => $customer_data['customer_id'],'status' => 'Pending']);?> <div class="padded">
              <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo get_phrase('enquiry');?></label>
                <div class="col-sm-5">
                  <textarea id="notes" class="form-control" name="enquiry" rows="4" cols="50">
                  </textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label"> <?php echo get_phrase('date');?> </label>
                <div class="col-sm-5">
                  <input type="text" class="form-control datepicker" name="extimate_date_completion" value="" data-start-view="2">
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
                <button type="submit" class="btn btn-info"> <?php echo get_phrase('add_enquiry');?> </button>
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