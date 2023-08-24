<div class="profile-env">
  <header class="row">
    <div class="col-sm-3">

                <a href="#" class="profile-picture">

                    <img src="<?php echo $this->crud_model->get_image_url('student', $student_data['student_id']); ?>" 

                         class="img-responsive img-circle" />

                </a>

            </div>



            <div class="col-sm-9">

                <ul class="profile-info-sections">

                    <li style="padding:0px; margin:0px;">

                        <div class="profile-name">

                            <h3>

                                <?php echo $this->db->get_where('student', array('student_id' => $param2))->row()->name; ?>                     

                            </h3>

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
          <a href="#package_lists" data-toggle="tab">
            <i class="entypo-menu"></i> <?php echo get_phrase('package_list');?> </a>
        </li>
      </ul>
      <div class="tab-content">
        <br>
        <!----TABLE LISTING STARTS-->
        <div class="tab-pane box active" id="package_lists">
          <table class="table table-bordered datatable" id="table_export">
            <thead>
              <tr>
                <th width="80"><div><?php echo get_phrase('SI NO'); ?></div></th>
                <th><div><?php echo get_phrase('Name'); ?></div></th>
                <th><div><?php echo get_phrase('tottal_Fee'); ?></div></th>
                <th><div><?php echo get_phrase('paid_Fee'); ?></div></th>
              </tr>
            </thead>
                <tbody>
                <?php 
                $package_id = json_decode($student_data['package_id'], true);
                if( !empty($package_id)) {
                foreach($package_id as $enroll_dataK => $rowV){
                    $enroll_dataV = $this->db->get_where('package',['package_id'=>$rowV])->row_array();
                ?>
                    <tr>
                      <td><?=$enroll_dataK+1?></td>
                      <td><?=$enroll_dataV['name']?></td>
                      <td>
                        <?php
                        $invoice = $this->db->get_where('invoice', ['package_id' => $rowV, 'student_id' => $student_data['student_id']])->row_array();
                        // echo $this->db->last_query();die;
                        echo $invoice['amount'];
                        ?>
                      </td>
                      <td><?=$invoice['amount_paid']?></td>
                    </tr>
                <?php    
                }
                }
                ?>
                </tbody>            

            </table>
        </div>
        <!----TABLE LISTING ENDS--->
      </div>
    </div>
  </div>
</div>