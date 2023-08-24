<div class="profile-env">
    <header class="row">
        <?php $this->load->view('backend/admin/customer_profile_pic') ?>
    </header>
    <br/>
    <section class="profile-info-tabs" hidden>
        <?php 
        $where = $this->crud_model->setSplitWhere('customer_service_list');

        $customer_service_list = $this->db->get_where('customer_service_list',['customer_id' => $customer_id])->result_array();
        $customer_service_list = array_chunk($customer_service_list,2);
        foreach($customer_service_list as $packagesChunkK => $packagesChunkV) {
        ?>
        <div class="row">
            <?php 
            foreach($packagesChunkV as $packagesChunkVK => $serv){
                $row = $this->db->get_where('customer_service',['customer_service_id' => $serv['customer_service_id']])->row_array();
                $tasks = $this->db->get_where('customer_task_list',['customer_service_list_id' => $serv['service_list_id']])->result_array();
            ?>
            <div class="col-sm-6">
                <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?=$row['name']?> (<?=$row['amount']?>)</h5>
                    <p class="card-text">
                        status : <?=$serv['status']?></br>
                        task : 
                        <?php 
                        foreach ($tasks as $tasksK => $tasksV) {
                        $task = $this->db->get_where('customer_task',['customer_task_id' => $tasksV['task_id']])->row_array();
                            echo $task['name'].'(extimated days : '.$task['defualt_days_required'].')';

                        }
                        ?>   
                    </p>
                    <a href="#" class="btn btn-success">Added</a>
                </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <?php } ?>    
    </section>

    <section class="profile-info-tabs">
        <label>Add New Service</label>
        <?php 
        $where = $this->crud_model->setSplitWhere('customer_service');

        $customer_service_list = $this->db->get('customer_service')->result_array();
        
        $customer_service_added = $this->db->get_where('customer_service_list',['customer_id' => $customer_id])->result_array();
        $customer_service_added_id = array_column($customer_service_added,'customer_service_id');
        $customer_service_list = array_chunk($customer_service_list,2);
        foreach($customer_service_list as $packagesChunkK => $packagesChunkV) {
        ?>
        <div class="row">
            <?php 
            foreach($packagesChunkV as $packagesChunkVK => $serv){
                $customer_serviceAdded = $this->db->get_where('customer_service_list',['customer_id' => $customer_id, 'customer_service_id' => $serv['customer_service_id']])->row_array();

                // echo "<pre>";print_r($customer_serviceAdded['service_list_id']);die;
                $tasks = $this->db->get_where('customer_task_list',['customer_service_list_id' => $serv['service_list_id']])->result_array();
            ?>
            <div class="col-sm-6">
                <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?=$serv['name']?> (<?=$serv['amount']?>)</h5>
                    <p class="card-text">
                        <?php if(isset($serv['status']) && $serv['status'] !== '') { ?>
                        status : <?=$serv['status']?></br>
                        <?php } ?>
                        <?php 
                        foreach ($tasks as $tasksK => $tasksV) {
                        $task = $this->db->get_where('customer_task',['customer_task_id' => $tasksV['task_id']])->row_array();
                            echo $task['name'].'(extimated days : '.$task['defualt_days_required'].')';

                        }
                        ?>   
                    </p>
                    <?php 
        if( in_array($serv['customer_service_id'],$customer_service_added_id) ){ ?>
                        <a href="#" onclick="showAjaxModal('<?=base_url() . 'index.php?modal/popup/model_edit_customer_service/'.$customer_serviceAdded['service_list_id']?>');" class="btn btn-success">Edit</a>
                    <?php } else { ?>
                        <a href="<?=base_url() . 'index.php?admin/customer_service_list/create/'.$customer_id.'/'.$serv['customer_service_id']?>" class="btn btn-success">Add</a>
                    <?php } ?>
                </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <?php } ?>    
    </section>
</div>