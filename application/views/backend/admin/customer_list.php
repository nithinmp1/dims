<hr />
<a href="<?php echo base_url(); ?>index.php?admin/customer_add"
   class="btn btn-primary pull-right">
    <i class="entypo-plus-circled"></i>
    <?php echo get_phrase('add_new_customer'); ?>
</a> 
<br>

<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs bordered">
            <li class="active">
                <a href="#home" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-users"></i></span>
                    <span class="hidden-xs"><?php echo get_phrase('all_customers'); ?></span>
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="home">
                <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                            <th width="80"><div><?php echo get_phrase('roll'); ?></div></th>
                            <th width="80"><div><?php echo get_phrase('code'); ?></div></th>
                            <th width="80"><div><?php echo get_phrase('photo'); ?></div></th>
                            <th><div><?php echo get_phrase('name'); ?></div></th>
                            <th><div><?php echo get_phrase('phone'); ?></div></th>
                            <th><div><?php echo get_phrase('gender'); ?></div></th>
                            <th class="span3"><div><?php echo get_phrase('payable'); ?></div></th>
                            <th><div><?php echo get_phrase('pending'); ?></div></th>
                            <th><div><?php echo get_phrase('options'); ?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $where = $this->crud_model->setSplitWhere('customer');
                        
                        $customers = $this->db->order_by('customer_id','desc')->get_where('customer', $where)->result_array();
                                $i = 0;
                        foreach ($customers as $key => $row):
                            ?>
                            <tr>
                                <td><?=$key+1; ?></td>
                                <td>
                                    <a href="<?=base_url('index.php?customer/profile/'.$row['customer_code'])?>">
                                        <?=$row['customer_code']?></td>
                                    </a>
                                <td><img src="<?php echo $this->crud_model->get_image_url('customer', $row['customer_id']); ?>" class="img-circle" width="30" /></td>
                                <td>
                                    <?php
                                    echo $this->db->get_where('customer', array(
                                        'customer_id' => $row['customer_id']
                                    ))->row()->name;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $this->db->get_where('customer', array(
                                        'customer_id' => $row['customer_id']
                                    ))->row()->phone;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $this->db->get_where('customer', array(
                                        'customer_id' => $row['customer_id']
                                    ))->row()->sex;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $tottalFee = $this->db->select_sum('tottalFee')->get_where('customer_service_list', array(
                                        'customer_id' => $row['customer_id']
                                    ))->row();
                                    echo $tottalFee->tottalFee;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $paidFee = $this->db->select_sum('paidFee')->get_where('customer_service_list', array(
                                        'customer_id' => $row['customer_id']
                                    ))->row();
                                    echo $tottalFee->tottalFee - $paidFee->paidFee;
                                    ?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                            Action <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                            
                                            <!-- customer PROFILE LINK -->
                                            <li>
                                                <a href="<?=base_url('index.php?admin/customer_profile/'.$row["customer_id"])?>" >
                                                    <i class="entypo-user"></i>
                                                    <?php echo get_phrase('profile'); ?>
                                                </a>
                                            </li>

                                            <!-- customer EDITING LINK -->
                                            <li>
                                                <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_customer_edit/<?php echo $row['customer_id']; ?>');">
                                                    <i class="entypo-pencil"></i>
                                                    <?php echo get_phrase('edit'); ?>
                                                </a>
                                            </li>

                                            <!-- customer PROFILE LINK -->
                                            <?php 
                                            $student = $this->db->get_where('student',['customer_id' => $row["customer_id"]])->result_array();
                                            if (empty($student)) {
                                            ?>
                                            <li>
                                                <a href="<?=base_url('index.php?admin/student_add/'.$row["customer_id"])?>" >
                                                    <i class="entypo-user"></i>
                                                    <?php echo get_phrase('add to student'); ?>
                                                </a>
                                            </li>
                                            <?php  
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <?php
            $query = $this->db->get_where('section', array('class_id' => $class_id));
            if ($query->num_rows() > 0):
                $sections = $query->result_array();
                foreach ($sections as $row):
                    ?>
                    <div class="tab-pane" id="<?php echo $row['section_id']; ?>">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="80"><div><?php echo get_phrase('roll'); ?></div></th>
                                    <th width="80"><div><?php echo get_phrase('photo'); ?></div></th>
                                    <th><div><?php echo get_phrase('name'); ?></div></th>
                                    <th class="span3"><div><?php echo get_phrase('address'); ?></div></th>
                                    <th><div><?php echo get_phrase('email'); ?></div></th>
                                    <th><div><?php echo get_phrase('options'); ?></div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $customers = $this->db->get_where('enroll', array(
                                            'class_id' => $class_id, 'section_id' => $row['section_id'], 'year' => $running_year
                                        ))->result_array();
                                foreach ($customers as $row):
                                    ?>
                                    <tr>
                                        <td><?php echo $row['roll']; ?></td>
                                        <td><img src="<?php echo $this->crud_model->get_image_url('customer', $row['customer_id']); ?>" class="img-circle" width="30" /></td>
                                        <td>
                                            <?php
                                            echo $this->db->get_where('customer', array(
                                                'customer_id' => $row['customer_id']
                                            ))->row()->name;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            echo $this->db->get_where('customer', array(
                                                'customer_id' => $row['customer_id']
                                            ))->row()->address;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            echo $this->db->get_where('customer', array(
                                                'customer_id' => $row['customer_id']
                                            ))->row()->email;
                                            ?>
                                        </td>
                                        <td>

                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                                    Action <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                                    <!-- customer PROFILE LINK -->
                                                    <li>
                                                        <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_customer_profile/<?php echo $row['customer_id']; ?>');">
                                                            <i class="entypo-user"></i>
                                                            <?php echo get_phrase('profile'); ?>
                                                        </a>
                                                    </li>

                                                    <!-- customer EDITING LINK -->
                                                    <li>
                                                        <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_customer_edit/<?php echo $row['customer_id']; ?>');">
                                                            <i class="entypo-pencil"></i>
                                                            <?php echo get_phrase('edit'); ?>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">

    jQuery(document).ready(function ($)
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