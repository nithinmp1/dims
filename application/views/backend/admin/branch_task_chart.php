    <div class="phppot-container">
        <h1>Task Pie Chart</h1>
        <div>
            <canvas id="pie-chart"></canvas>
        </div>
    </div>
    <?php 
        if (isset($branch_id) && $branch_id != ''){
            $branch = $this->db->get_where('branch',['branch_id' => $branch_id])->row();
        }else{
            $branch = $this->db->select('*')->from('branch')->limit('1')->get()->row();
        }
        $where['branch_id'] = $branch->branch_id;
        $staff = $this->db->order_by('staff_id','desc')->get_where('staff', $where)->result_array();
        $staff_id = array_column($staff,'staff_id');
        $staff_name = array_column($staff,'name');
        foreach($staff_id as $key => $staffId){
            $this->db->select('COUNT(task_list_id) as count');
            $this->db->where('status','success');
            $this->db->where('assign_to',$staffId);
            $this->db->or_where('createdID',$staffId);
            $customer_task = $this->db->get('customer_task_list')->row();
            $labels[] = $staff_name[$key]; 
            $data[] = $customer_task->count;
            $colors[] = $this->crud_model->rand_color();
        }

    ?>
    <script
        src="https://cdn.jsdelivr.net/npm/chart.js@4.0.1/dist/chart.umd.min.js">
    </script>
    <script>
        new Chart(document.getElementById("pie-chart"), {
        	type : 'pie',
        	data : {
        		labels : ["<?=implode('","', $labels)?>"],
        		datasets : [ {
        			backgroundColor : ["<?=implode('","', $colors)?>"],
        			data : [<?=implode(', ', $data)?>]
        		} ]
        	},
        	options : {
        		title : {
        			display : true,
        			text : 'Chart JS Pie Chart Example'
        		}
        	}
        });
	</script>