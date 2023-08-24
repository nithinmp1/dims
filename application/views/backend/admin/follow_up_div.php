<div class="profile-env">
  <header class="row">
    <?php $this->load->view('backend/admin/customer_profile_pic') ?>
  </header>
  <br />
  <div class="row">
    <div class="col-md-12">
      <ul class="nav nav-tabs bordered">
        <li class="active">
          <a href="#follow_up_list" data-toggle="tab">
            <i class="entypo-menu"></i> <?php echo get_phrase('follow_up_list');?> </a>
        </li>
        <li>
          <a href="#add_follow_up" data-toggle="tab">
            <i class="entypo-plus-circled"></i> <?php echo get_phrase('add_follow_up');?> </a>
        </li>
      </ul>
      <div class="tab-content">
        <br>
        <!----TABLE LISTING STARTS-->
        <div class="tab-pane box active" id="follow_up_list">
          <table class="table table-bordered datatable" id="table_export">
            <thead>
              <tr>
                <th width="80"><div><?php echo get_phrase('SI NO'); ?></div></th>
                <th><div><?php echo get_phrase('Notes'); ?></div></th>
                <th><div><?php echo get_phrase('status'); ?></div></th>
                <th><div><?php echo get_phrase('follow_up_on'); ?></div></th>
                <th><div><?php echo get_phrase('options'); ?></div></th>
              </tr>
            </thead>
                <tbody>
                <?php 

                $where = $this->crud_model->setSplitWhere('follow_up');
                $where['customer_id'] = $customer_id;

                $followup = $this->db->order_by('follow_up_id ','desc')->get_where('follow_up',$where)->result_array();
                foreach($followup as $followupK => $followupV){

                ?>
                    <tr>
                        <td><?=$followupK+1?></td>
                        <td><?=$followupV['remark']?></td>
                        <td><?=($followupV['status'] == '')?'NILL':$followupV['status']?></td>
                        <td>
                            <?=$followupV['follow_up_on']?>
                        </td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                    <!-- customer MARKSHEET LINK  -->
                                    <li>
                                      <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/customer_follow_up_edit/<?=$followupV['follow_up_id'] ?>');">
                                            <i class="entypo-pencil"></i>
                                            <?php echo get_phrase('Edit'); ?>
                                        </a>
                                    </li>
                                    <!-- customer PROFILE LINK -->
                                    <li>
                                        
                                        <a href="<?php echo base_url(); ?>index.php?admin/customer_follow_up/delete/<?php echo $followupV['follow_up_id']; ?>">
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
        <div class="tab-pane box" id="add_follow_up" style="padding: 5px">
          <div class="box-content"> 
            <?php
            echo form_open(base_url() . 'index.php?admin/customer_follow_up/create' , 
            array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'),
            ['customer_id' => $customer_data['customer_id'],'status' => 'Pending']);?> <div class="padded">
              <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo get_phrase('remarks');?></label>
                <div class="col-sm-5">
                  <textarea id="remarks" class="form-control" name="remarks" rows="4" cols="50">
                  </textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label"> <?php echo get_phrase('follow_up_on');?> </label>
                <div class="col-sm-5">
                  <input type="text" class="form-control datepicker" name="follow_up_on" value="" data-start-view="2">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-3 col-sm-5">
                <button type="submit" class="btn btn-info"> <?php echo get_phrase('add_follow_up');?> </button>
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