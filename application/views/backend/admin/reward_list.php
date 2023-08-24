<?php 
$segment = $this->uri->segment(2);
?>
<table class="table table-bordered datatable" id="<?=(($segment === 'branch_report') === true)?'reward_table':'table_export'?>">

    <thead>

        <tr>

            <th style="width: 60px;">#</th>

            <th><div><?php echo get_phrase('image');?></div></th>

            <th><div><?php echo get_phrase('name');?></div></th>
            <th><div><?php echo get_phrase('branch');?></div></th>

            <th><div><?php echo get_phrase('total_reward');?></div></th>

        </tr>

    </thead>

    <tbody>

        <?php

        $count = 1;

        $where = $this->crud_model->setSplitWhere('staff');
        // echo $branch_id;die;
        if((isset($branch_id)) == true){
            $where['branch_id'] = $branch_id;
        }
        $staffs   =   $this->db->get_where('staff',$where)->result_array();

        foreach($staffs as $row): ?>

            <tr>

                <td><?php echo $count++;?></td>

                <td><img src="<?php echo base_url($row['image']) ?>" class="img-circle" width="30" /></td>

                <td><?php echo $row['name'];?></td>
                <td><?php 
                $branch = $this->db->get_where('branch',['branch_id' => $row['branch_id']])->row_array();

                echo $branch['name'];?></td>

                <td><?php 
                $where = [];
                if((isset($from)) == true){
                    $where['updated_at >'] = $from;
                }

                if((isset($to)) == true){
                    $where['updated_at <'] = $to;
                }

                if((isset($row['staff_id'])) == true){
                    $where['staff_id'] = $row['staff_id'];
                }

                $this->db->select_sum('point');
                $reward = $this->db->get_where('reward_data',$where)->row_array();

                if (isset($reward['point']) === true && ($reward['point'] !== '') === true){
                    echo round($reward['point']);
                }else{
                    echo 'NILL';
                }
                ?></td>
            </tr>

        <?php endforeach;?>

    </tbody>

</table>







<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      

<script type="text/javascript">



    jQuery(document).ready(function($)

    {

        



        var datatable = $("#<?=(($segment === 'branch_report') === true)?'reward_table':'table_export'?>").dataTable({

            "sPaginationType": "bootstrap",

            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",

            "oTableTools": {

                "aButtons": [

                    

                    {

                        "sExtends": "xls",

                        "mColumns": [0,1,2]

                    },

                    {

                        "sExtends": "pdf",

                        "mColumns": [0,1,2]

                    },

                    {

                        "sExtends": "print",

                        "fnSetText"    : "Press 'esc' to return",

                        "fnClick": function (nButton, oConfig) {

                            datatable.fnSetColumnVis(3, false);

                            

                            this.fnPrint( true, oConfig );

                            

                            window.print();

                            

                            $(window).keyup(function(e) {

                                  if (e.which == 27) {

                                      datatable.fnSetColumnVis(3, true);

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



