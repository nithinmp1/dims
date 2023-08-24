<div style="text-align:center;">
    <h2 style="font-weight:200; margin:0px;color: green;">
    Staff Per Branch Table
    </h2>
</div>
<footer class="main"></footer>
<table class="table table-bordered datatable" id="table_export">

    <thead>

        <tr>

            <th style="width: 60px;">#</th>

            <th><div><?php echo get_phrase('image');?></div></th>

            <th><div><?php echo get_phrase('name');?></div></th>

            <th><div><?php echo get_phrase('email');?></div></th>

            <th><div><?php echo get_phrase('options');?></div></th>

        </tr>

    </thead>

    <tbody>

        <?php

        $count = 1;

        $where = $this->crud_model->setSplitWhere('staff');
        if (isset($branch_id) && $branch_id != ''){
            $branch = $this->db->get_where('branch',['branch_id' => $branch_id])->row();
        }else{
            $branch = $this->db->select('*')->from('branch')->limit('1')->get()->row();
        }
        $where['branch_id'] = $branch->branch_id;
        if((isset($fromDate)) == true && $fromDate != ''){
            $where['createdOn >'] = $fromDate;
        }

        if((isset($toDate)) == true && $toDate != ''){
            $where['createdOn <'] = $toDate;
        }
        $this->db->order_by('staff_id','desc');
        $staffs   =   $this->db->get_where('staff',$where)->result_array();

        foreach($staffs as $row): ?>

            <tr>

                <td><?php echo $count++;?></td>

                <td><img src="<?php echo base_url($row['image']) ?>" class="img-circle" width="30" /></td>

                <td><?php echo $row['name'];?></td>

                <td><?php echo $row['email'];?></td>

                <td>

                    

                    <div class="btn-group">

                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">

                            Action <span class="caret"></span>

                        </button>

                        <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                            

                            <li>

                                <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/staff_edit/<?php echo $row['staff_id']; ?>');">

                                    <i class="entypo-pencil"></i>

                                    <?php echo get_phrase('edit');?>

                                </a>

                            </li>

                            <li class="divider"></li>

                            

                            <li>

                                <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/staff/delete/<?php echo $row['staff_id']; ?>');">

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
