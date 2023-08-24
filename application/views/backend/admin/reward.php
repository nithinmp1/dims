
<a href="javascript:;" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/reward_add/');" 
class="btn btn-primary pull-right">
<i class="entypo-plus-circled"></i>
<?php echo get_phrase('add_new_reward');?>
</a> 
<br><br>
<table class="table table-bordered datatable" id="table_export">
    <thead>
        <tr>
            <th><div>#</div></th>
            <th><div><?php echo get_phrase('name');?></div></th>
            <th><div><?php echo get_phrase('point');?></div></th>
            <th><div><?php echo get_phrase('include');?></div></th>
            <th><div><?php echo get_phrase('action');?></div></th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $count = 1;
            $reward = $this->db->get('reward')->result_array();
            foreach ($reward as $row):
        ?>
        <tr>
            <td><?php echo $count++;?></td>
            <td><?php echo $row['name'];?></td>
            <td><?php echo $row['reward_point'];?></td>
            <td><?php 
            echo 'Rreward Category :'. $row['reward_category'].' for Packages:- ';
            if($row['reward_category'] == 'student'){
                $package_id = json_decode($row['package_id']);
                foreach ($package_id as $key => $value) {
                    $package = $this->db->get_where('package',['package_id' => $value])->row();
                    if(isset($package) === true && !empty($package)) {
                    if (isset($package->name) === true && $package->name != ''){
                        echo $package->name;
                    }

                }else{
                    echo "Package Not Available Now";
                }
                    if ((end(array_keys($package_id)) == $key) === FALSE) {
                        echo ", ";
                    }
                }
            }
            if($row['reward_category'] == 'customer_service'){
                $package_id = json_decode($row['customer_service_id']);
                foreach ($package_id as $key => $value) {
                    $package = $this->db->get_where('customer_service',['customer_service_id' => $value])->row();
                    echo $package->name.', ';
                }
            }
            if($row['reward_category'] == 'customer_task'){
                $package_id = json_decode($row['customer_task_id']);
                foreach ($package_id as $key => $value) {
                    $package = $this->db->get_where('customer_task',['customer_task_id' => $value])->row();
                    echo $package->name.', ';
                }
            }
            if($row['reward_category'] == 'customer_followup'){
                echo $row['customer_followup'];
            }            
            ?>
                
            </td>
            <td>
                
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                        Action <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                        
                        <!-- instructor EDITING LINK -->
                        <li>
                            <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/reward_edit/<?php echo $row['reward_id'];?>');">
                                <i class="entypo-pencil"></i>
                                    <?php echo get_phrase('edit');?>
                                </a>
                                        </li>
                        <li class="divider"></li>
                        
                        <!-- instructor DELETION LINK -->
                        <li>
                            <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/reward_masters/delete/<?php echo $row['reward_id'];?>');">
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
                        "mColumns": [1,2,3,4,5]
                    },
                    {
                        "sExtends": "pdf",
                        "mColumns": [1,2,3,4,5]
                    },
                    {
                        "sExtends": "print",
                        "fnSetText"    : "Press 'esc' to return",
                        "fnClick": function (nButton, oConfig) {
                            datatable.fnSetColumnVis(2, false);
                            
                            this.fnPrint( true, oConfig );
                            
                            window.print();
                            
                            $(window).keyup(function(e) {
                                  if (e.which == 27) {
                                      datatable.fnSetColumnVis(2, true);
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

