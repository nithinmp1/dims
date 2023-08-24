<div class="profile-env">
  <header class="row">
    <?php $this->load->view('backend/admin/customer_profile_pic') ?>
  </header>
  <br />
  <div class="row">
    <div class="col-md-12">
      <ul class="nav nav-tabs bordered">
        <li class="active">
          <a href="#expence_list" data-toggle="tab">
            <i class="entypo-menu"></i> <?php echo get_phrase('expence_list');?> </a>
        </li>
        <li>
          <a href="#add_expence" data-toggle="tab">
            <i class="entypo-plus-circled"></i> <?php echo get_phrase('add_expence');?> </a>
        </li>
      </ul>
      <div class="tab-content">
        <br>
        <!----TABLE LISTING STARTS-->
        <div class="tab-pane box active" id="expence_list">
          <table class="table table-bordered datatable" id="table_export">
            <thead>
              <tr>
                <th>
                  <div>#</div>
                </th>
                <th>
                  <div> <?php echo get_phrase('payment_name');?> </div>
                </th>
                <th>
                  <div> <?php echo get_phrase('date');?> </div>
                </th>
                <th>
                  <div> <?php echo get_phrase('method');?> </div>
                </th>
                <th>
                  <div> <?php echo get_phrase('amount');?> </div>
                </th>
                <th>
                  <div> <?php echo get_phrase('description');?> </div>
                </th>
              </tr>
            </thead>
            <tbody>
                <?php
                $payments = $this->db->get_where('payment',['customer_id' => $customer_data['customer_id'], 'payment_type' => 'expense'])->result_array();
                $count = 1;foreach($payments as $row):?> <tr>
                <td> <?php echo $count++;?> </td>
                <td> <?php echo $row['title'];?> </td>
                <td> <?php echo $row['idate'];?> </td>
                <td> <?php echo $this->db->get_where('payment_mode',['payment_mode_id' => $row['method']])->row()->name;?> </td>
                <td> <?php echo $row['amount'];?> </td>
                <td> <?php echo $row['description'];?> </td>
                <td hidden>
                  <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"> Action <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                      <!-- EDITING LINK -->
                      <li>
                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_edit_payment/<?php echo $row['payment_id'];?>');">
                          <i class="entypo-pencil"></i> <?php echo get_phrase('edit');?> </a>
                      </li>
                      <li class="divider"></li>
                      <!-- DELETION LINK -->
                      <li>
                        <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/payment/delete/<?php echo $row['payment_id'];?>');">
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
        <div class="tab-pane box" id="add_expence" style="padding: 5px">
          <div class="box-content"> 
            <?php
            $dueAmount = 1000;
            echo form_open(base_url() . 'index.php?admin/expense/customer_create' , 
            array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'),
            ['customer_id' => $customer_data['customer_id'],'title' => 'Expence On customer','status' => 'paid']);?> <div class="padded">
              <div class="form-group">
                <label class="col-sm-3 control-label"> <?php echo get_phrase('expense');?> </label>
                <div class="col-sm-5">
                  <select name="expense_category_id" class="form-control select2" style="width:100%;">
                    <option>Select</option> 
                    <?php 
                    $examType = $this->db->get('expense_category')->result();
                    foreach($examType as $examTypeK=> $examTypeV){
                    ?> 
                        <option value="<?=$examTypeV->expense_category_id?>"> <?=$examTypeV->name?> </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label"> <?php echo get_phrase('date');?> </label>
                <div class="col-sm-5">
                  <input type="text" class="form-control datepicker" name="date" value="" data-start-view="2">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label"> <?php echo get_phrase('amount');?> </label>
                <div class="col-sm-5">
                  <input type="number" class="form-control" name="amount" value="">
                </div>
              </div>
              <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo get_phrase('method');?></label>
                                    <div class="col-sm-5">
                                        <select name="method" class="form-control selectboxit">
                                            <option value="1"><?php echo get_phrase('cash');?></option>
                                            <option value="2"><?php echo get_phrase('check');?></option>
                                            <option value="3"><?php echo get_phrase('card');?></option>
                                        </select>
                                    </div>
                                </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-3 col-sm-5">
                <button type="submit" class="btn btn-info"> <?php echo get_phrase('add_expence');?> </button>
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