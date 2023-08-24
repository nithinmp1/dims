<!-- Attendence from enrol table -->
    <div class="profile-env">
        <header class="row">
            <div class="col-sm-3">
                <a href="#" class="profile-picture">
                    <img src="<?php echo $this->crud_model->get_image_url('customer', $customer_data['customer_id']); ?>" 
                         class="img-responsive img-circle" />
                </a>
            </div>

            <div class="col-sm-9">
                <ul class="profile-info-sections">
                    <li style="padding:0px; margin:0px;">
                        <div class="profile-name">
                            <h3>
                                <?php echo $this->db->get_where('customer', array('customer_id' => $customer_id))->row()->name; ?>                     
                            </h3>
                        </div>
                    </li>
                </ul>
            </div>
        </header>
        <section class="profile-info-tabs">
            <div class="row">
            <table class="table table-bordered datatable">
                <thead>
                    <tr>
                        <th width="80"><div><?php echo get_phrase('SI NO'); ?></div></th>
                        <th><div><?php echo get_phrase('Name'); ?></div></th>
                        <th class="span3"><div><?php echo get_phrase('Status'); ?></div></th>
                        <th><div><?php echo get_phrase('extimate_date'); ?></div></th>
                        <th><div><?php echo get_phrase('options'); ?></div></th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $customerServ = $this->db->order_by('service_list_id','desc')->get_where('customer_service_list',['customer_id' => $customer_id])->result_array();
                $servId = array_column($customerServ,'customer_service_id');
                $this->db->where_in('customer_service_id',$servId);
                $tasks = $this->db->get('customer_task_list')->result_array();
                foreach($tasks as $enroll_dataK => $rowV){

                    $enroll_dataV = $this->db->get_where('customer_task',['customer_task_id'=>$rowV['task_id']])->row_array();
                ?>
                    <tr>
                        <td><?=$enroll_dataK+1?></td>
                        <td><?=$enroll_dataV['name']?></td>
                        <td><?=($enroll_dataV['status'] == '')?'NILL':$enroll_dataV['status']?></td>
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
                                        <a href="<?php echo base_url(); ?>index.php?admin/customer_task/<?php echo $row['customer_id']; ?>">
                                            <i class="entypo-pencil"></i>
                                            <?php echo get_phrase('Edit'); ?>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/customer_task_add/<?=$enroll_dataV['enroll_id'] ?>');">
                                            <i class="entypo-user"></i>
                                            <?php echo get_phrase('Add'); ?>
                                        </a>
                                    </li>
                                    <!-- customer PROFILE LINK -->
                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/customer_task_edit/<?=$enroll_dataV['enroll_id'] ?>');">
                                            <i class="entypo-user"></i>
                                            <?php echo get_phrase('Edit'); ?>
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
        </section>
    </div>