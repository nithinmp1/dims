    <div class="phppot-container">
        <h1>Expense Pie Chart</h1>
        <div>
            <canvas id="pie-chart-3">
                No Data
            </canvas>
        </div>
    </div>
    <?php 
        if (isset($branch_id) && $branch_id != ''){
            $branch = $this->db->get_where('branch',['branch_id' => $branch_id])->row();
        }else{
            $branch = $this->db->select('*')->from('branch')->limit('1')->get()->row();
        }
        
        $stream = $this->db->order_by('stream_id','desc')->get_where('stream', $where)->result_array();
        $stream_id = array_column($stream,'stream_id');
        $stream_name = array_column($stream,'name');
        foreach($stream_id as $key => $streamId){
            $this->db->select('payment_type, sum(amount) as amount');
            $this->db->where('stream_id',$streamId);
            $this->db->where('branch_id',$branch->branch_id);
            $this->db->where('payment_type','expense');
            $payment = $this->db->get('payment')->row();
            // echo $this->db->last_query();
            // echo "<pre>";print_r($payment);die;
            $labels[] = $stream_name[$key]; 
            $data[] = isset($payment->amount)?$payment->amount:0;
            $colors[] = $this->crud_model->rand_color();
        }

    ?>
    <script
        src="https://cdn.jsdelivr.net/npm/chart.js@4.0.1/dist/chart.umd.min.js"></script>
    <script>
        new Chart(document.getElementById("pie-chart-3"), {
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