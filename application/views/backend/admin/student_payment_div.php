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

          <a href="#payment_list" data-toggle="tab">

            <i class="entypo-menu"></i> <?php echo get_phrase('payment_list');?> </a>

        </li>
        <?php
          $package_id = json_decode($student_data['package_id'], true);
          $package = $this->db->get_where('payment',['student_id' => $student_data['student_id']])->result_array();
          $invoice_package_id = [];
          if (isset($package) && !empty($package)) {
            $invoice_package_id = array_column($package, 'package_id');
          }

          $customer_service_list = $this->db->get_where('customer_service_list',['student_id' => $student_id])->result_array();
          $invoice_service_id = $service_id = [];
          if (!empty($customer_service_list)) {
            $service_id = array_column($customer_service_list, 'service_list_id');
            $invoice_service_id = array_column($package, 'customer_service_list_id');
          }

         if (!empty(array_diff($package_id, $invoice_package_id)) === true || !empty(array_diff($service_id, $invoice_service_id)) === true) {?>
        <li>

          <a href="#add_payment" data-toggle="tab">

            <i class="entypo-plus-circled"></i> <?php echo get_phrase('add_payment');?> </a>

        </li>
        <?php } ?>
      </ul>

      <div class="tab-content">

        <br>

        <!----TABLE LISTING STARTS-->

        <div class="tab-pane box active" id="payment_list">

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

                  <div> <?php echo get_phrase('package/Service');?> </div>

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
                <th>

                  <div> <?php echo get_phrase('action');?> </div>

                </th>                

              </tr>

            </thead>

            <tbody>

                <?php

                $payments = $this->db->get_where('payment',['student_id' => $student_data['student_id'], 'payment_type' => 'income'])->result_array();

                $count = 1;foreach($payments as $row):?> <tr>

                <td> <?php echo $count++;?> </td>

                <td> <?php echo $row['title'];?> </td>
                <td>
                  <?php 
                  if (isset($row['package_id']) && $row['package_id'] !== null) {
                    $package = $this->db->get_where('package', ['package_id' => $row['package_id']])->row_array();
                    echo $package['name'];
                  } else if(isset($row['customer_service_list_id']) && $row['customer_service_list_id'] !== null) {
                    $serviceList = $this->db->get_where('customer_service_list', ['service_list_id' => $row['customer_service_list_id']])->row_array();
                    $service = $this->db->get_where('customer_service',['customer_service_id' => $serviceList['customer_service_id']])->row_array();
                    echo $service['name'];
                  }

                  ?>
                </td>

                <td> <?php echo $row['idate'];?> </td>

                <td> <?php echo $this->db->get_where('payment_mode',['payment_mode_id' => $row['method']])->row()->name;?> </td>

                <td> <?php echo $row['amount'];?> </td>

                <td> <?php echo $row['description'];?> </td>

                <td >
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                            <?php echo get_phrase('action'); ?> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                            <?php 
                            $invoice = $this->db->get_where('invoice',['invoice_id' => $row['invoice_id']])->row_array();
                            if ($invoice['due'] != 0): ?>

                                <li>
                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_take_payment/<?php echo $invoice['invoice_id']; ?>');">
                                        <i class="entypo-bookmarks"></i>
                                        <?php echo get_phrase('take_payment'); ?>
                                    </a>
                                </li>
                                <li class="divider"></li>
                            <?php endif; ?>

                            <!-- VIEWING LINK -->
                            <li>
                                <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_view_invoice/<?php echo $invoice['invoice_id']; ?>');">
                                    <i class="entypo-credit-card"></i>
                                    <?php echo get_phrase('view_invoice'); ?>
                                </a>
                            </li>
                            <li class="divider"></li>

                            <!-- EDITING LINK -->
                            <li>
                                <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_edit_invoice/<?php echo $invoice['invoice_id']; ?>');">
                                    <i class="entypo-pencil"></i>
                                    <?php echo get_phrase('edit'); ?>
                                </a>
                            </li>
                            <li class="divider"></li>

                            <!-- DELETION LINK -->
                            <li>
                                <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?admin/invoice/delete/<?php echo $invoice['invoice_id']; ?>');">
                                    <i class="entypo-trash"></i>
                                    <?php echo get_phrase('delete'); ?>
                                </a>
                            </li>
                        </ul>
                    </div>                  
                </td>

              </tr> <?php endforeach;?> </tbody>

          </table>

        </div>

        <!----TABLE LISTING ENDS--->

        <!----CREATION FORM STARTS---->

        <div class="tab-pane box" id="add_payment" style="padding: 5px">

          <div class="box-content"> 

            <?php



            $dueAmount = $student_data['tottalFee'] - $student_data['paidFee'];

            echo form_open(base_url() . 'index.php?admin/invoice/student_create' , 

            array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'),

            ['student_id' => $student_data['student_id'],'title' => 'Payment From Student','amount' => $dueAmount,'status' => 'paid']);?> <div class="padded">
              <div class="form-group">
                <label class="col-sm-3 control-label"> <?php echo get_phrase('payment for');?> </label>
                <div class="col-sm-2">
                  <input type="radio" id="html" name="paymentFor" value="package" checked>
                  <label for="html">Package</label><br>
                </div>
                <div class="col-sm-2">
                  <input type="radio" id="css" name="paymentFor" value="service">
                  <label for="css">Service</label><br>
                </div>
              </div>

              <div class="form-group package">
                <label class="col-sm-3 control-label"> <?php echo get_phrase('package');?> </label>
                <div class="col-sm-5">
                  <select name="package_id" class="form-control " style="width:100%;">
                    <option>Select</option> 
                    <?php 
                    $package_id = json_decode($student_data['package_id'], true);
                    foreach($package_id as $packageId){
                      $payment = $this->db->get_where('payment',['package_id' => $packageId,'student_id' => $student_data['student_id']])->row_array();
                      if (empty($payment)) {
                      $package = $this->db->get_where('package',['package_id' => $packageId])->row_array();
                    ?> 
                        <option value="<?=$package['package_id']?>"> <?=$package['name']?> </option>
                    <?php }
                      }
                     ?>
                  </select>
                </div>
              </div>

              <div class="form-group service" style="display:none">
                <label class="col-sm-3 control-label"> <?php echo get_phrase('service');?> </label>
                <div class="col-sm-5">
                  <select name="customer_service_id" class="form-control " style="width:100%;">
                    <option>Select</option> 
                    <?php 
                    foreach($customer_service_list as $serviceList){
                      if (in_array($serviceList['service_list_id'], $invoice_service_id)) {
                        continue;
                      }
                      $service = $this->db->get_where('customer_service', ['customer_service_id' => $serviceList['customer_service_id']])->row_array();
                    ?> 
                        <option value="<?=$serviceList['service_list_id']?>"> <?=$service['name']?> </option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <div class="form-group">

                <label class="col-sm-3 control-label"> <?php echo get_phrase('payment');?> </label>

                <div class="col-sm-5">

                  <select name="income_category_id" class="form-control " style="width:100%;">

                    <option>Select</option> 

                    <?php 

                    $examType = $this->db->get('income_category')->result();

                    foreach($examType as $examTypeK=> $examTypeV){

                    ?> 

                        <option value="<?=$examTypeV->income_category_id?>"> <?=$examTypeV->name?> </option>

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

                  <input type="number" class="form-control" name="amount_paid" value="">

                </div>

              </div>

              <div class="form-group">

                                    <label class="col-sm-3 control-label"><?php echo get_phrase('method');?></label>

                                    <div class="col-sm-5">
                                      <?php 
                                      $payment_mode = $this->db->get('payment_mode')->result_array();
                                      ?>
                                        <select name="method" class="form-control selectboxit">
                                          <?php foreach($payment_mode as $key => $val) { ?>
                                            <option value="<?=$val['payment_mode_id']?>"><?=$val['name']?></option>
                                          <?php } ?>
                                        </select>

                                    </div>

                                </div>

            </div>

            <div class="form-group">

              <div class="col-sm-offset-3 col-sm-5">

                <button type="submit" class="btn btn-info"> <?php echo get_phrase('add_payment');?> </button>

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
<script type="text/javascript">
  $('input[type=radio][name=paymentFor]').change(function() {
    if (this.value == 'package') {
        $(".package").show();
        $(".service").hide();
    } else if (this.value == 'service') {
        $(".package").hide();
        $(".service").show();        
    }
});
</script>