<hr />

<div class="row">
    <div class="col-md-12">
    <?php 
    $types = [
        'student' => ['total_student','today_registerd','last_7days_registerd'], 
        'customer' => ['total_customer','today_registerd','last_7days_registerd'],
        'payment' => ['total_income', 'today_income', 'last_7days_income', 'total_expense', 'today_expense', 'last_7days_expense']
    ];
    ?>
    <div class="row" >
        <div class="col-sm-6">
            <select class="form-control" name="table" id="table">
            <?php foreach ($types as $table => $type) { ?>
              <option value="<?=$table?>" <?=($table == 'student')?'':'select'?>><?=get_phrase($table)?> Reports</option>
            <?php } ?>
            </select>
        </div>
        <?php foreach ($types as $table => $type) { ?>
        <div class="col-sm-6 reportControllers" <?=($table == 'student')?'':'style = "display: none;"'?> data-type="<?=$table?>">
            <select class="form-control" name="<?=$table?>Type" id="<?=$table?>Type">
            <?php foreach ($type as $typein) { ?>
              <option value="<?=$typein?>" <?=in_array($typein,['total_student', 'total_customer', 'total_income'])?'selected':''?>><?=get_phrase($typein)?></option>
            <?php } ?>
            </select>
        </div>
        <?php } ?>
    </div>
    <?php
    foreach ($types as $table => $type) { ?>
        <h3 class="cardHead" data-table="<?=$table?>" style="<?=($table == 'student')?'':'display :none'?>"><?=get_phrase($table)?> Report</h3>
    <?php
        foreach($type as $type) {
    ?>
        <div class="row card" style="<?=(($table == 'student') && ($type == 'total_student')) ?'':'display :none'?>" data-type="<?=$type?>" data-table="<?=$table?>">
            <?php 
            $stream = $this->crud_model->getAllStream();
            foreach ($stream as $key => $value) { ?>
            <div class="col-md-2" data-type="<?=$type?>" data-table="<?=$table?>" style="width: 229px; ">
                <div class="tile-stats" style="background-color: <?=$this->crud_model->rand_color()?>; height: 159px;">
                    <h3><?php echo get_phrase($value['name']);?></h3>
                    <div class="icon"><i class="fa fa-group"></i></div>
                    <div class="num" data-start="0" data-end="
                    <?php 
                    $where = ['stream_id'=>$value['stream_id']];
                    if ($table == 'student'){
                        if($type == 'today_registerd') {
                            $this->db->where('created BETWEEN DATE_SUB(NOW(), INTERVAL 1 DAY) AND NOW()');
                        }else if ($type == 'last_7days_registerd'){
                            $this->db->where('created BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()');
                        }
                    } else if ($table == 'customer') {
                        if($type == 'today_registerd') {
                            $this->db->where('updated_at BETWEEN DATE_SUB(NOW(), INTERVAL 1 DAY) AND NOW()');
                        }else if ($type == 'last_7days_registerd'){
                            $this->db->where('updated_at BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()');
                        }
                    } else if ($table == 'payment') {
                        if (strpos($type,'income') ){
                            $where['payment_type'] = 'income'; 
                        }else if(strpos($type,'expense')) {
                            $where['payment_type'] = 'expense'; 
                        }
                        if($type == 'today_registerd') {
                            $this->db->where('created BETWEEN DATE_SUB(NOW(), INTERVAL 1 DAY) AND NOW()');
                        }else if ($type == 'created'){
                            $this->db->where('updated_at BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()');
                        }
                    }

                    if ($table != 'payment') {
                        echo $this->db->get_where($table,$where)->num_rows();
                    }else {
                        $this->db->select_sum('amount');
                        $data = $this->db->get_where($table,$where)->row();
                        echo $data->amount;
                    }
                    ?>" 
                            data-postfix="" data-duration="1500" data-delay="0">0</div>
                   <p><a href="<?php echo base_url(); ?>index.php?admin/<?=$table?>_stream_list/<?=$value['stream_id']?>"> <?=get_phrase($type)?></a></p>
                </div>
            </div>
            <?php } ?>
        </div>
    <?php }} ?>  
    </div>

    <div class="col-md-8">
    	<div class="row">
            <!-- CALENDAR-->
            <div class="col-md-12 col-xs-12">    
                <div class="panel panel-primary " data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="fa fa-calendar"></i>
                            <?php echo get_phrase('event_schedule');?>
                        </div>
                    </div>
                    <div class="panel-body" style="padding:0px;">
                        <div class="calendar-env">
                            <div class="calendar-body">
                                <div id="notice_calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
	<div class="col-md-4">
		<div class="row">
            <div class="col-md-12">
            
                <div class="tile-stats tile-red">
                    <div class="icon"><i class="fa fa-group"></i></div>
                    <div class="num" data-start="0" data-end="<?php echo $this->db->count_all('student');?>" 
                    		data-postfix="" data-duration="1500" data-delay="0">0</div>
                    
                    <h3><?php echo get_phrase('student');?></h3>
                   <p>Total students</p>
                </div>
                
            </div>
            <div class="col-md-12">
            
                <div class="tile-stats tile-green">
                    <div class="icon"><i class="entypo-users"></i></div>
                    <div class="num" data-start="0" data-end="<?php echo $this->db->count_all('instructor');?>" 
                    		data-postfix="" data-duration="800" data-delay="0">0</div>
                    
                    <h3><?php echo get_phrase('instructor');?></h3>
                   <p>Total instructors</p>
                </div>
                
            </div>
            <div class="col-md-12">
            
                <div class="tile-stats tile-aqua">
                    <div class="icon"><i class="entypo-user"></i></div>
                    <div class="num" data-start="0" data-end="<?php echo $this->db->count_all('vehicle');?>" 
                    		data-postfix="" data-duration="500" data-delay="0">0</div>
                    
                    <h3><?php echo get_phrase('vehicle');?></h3>
                   <p>Total Vehicles</p>
                </div>
                
            </div>
            <div class="col-md-12">
            
                <div class="tile-stats tile-blue">
                    <div class="icon"><i class="entypo-chart-bar"></i></div>
                    <?php 
						$check	=	array(	'timestamp' => strtotime(date('Y-m-d')) , 'status' => '1' );
						$query = $this->db->get_where('attendance' , $check);
						$present_today		=	$query->num_rows();
						?>
                    <div class="num" data-start="0" data-end="<?php echo $present_today;?>" 
                    		data-postfix="" data-duration="500" data-delay="0">0</div>
                    
                    <h3><?php echo get_phrase('attendance');?></h3>
                   <p>Total present student today</p>
                </div>
                
            </div>
    	</div>
    </div>
	
</div>



    <script>
  $(document).ready(function() {
	  
	  var calendar = $('#notice_calendar');
				
				$('#notice_calendar').fullCalendar({
					header: {
						left: 'title',
						right: 'today prev,next'
					},
					
					//defaultView: 'basicWeek',
					
					editable: false,
					firstDay: 1,
					height: 530,
					droppable: false,
					
					events: [
						<?php 
						$notices	=	$this->db->get('noticeboard')->result_array();
						foreach($notices as $row):
						?>
						{
							title: "<?php echo $row['notice_title'];?>",
							start: new Date(<?php echo date('Y',$row['create_timestamp']);?>, <?php echo date('m',$row['create_timestamp'])-1;?>, <?php echo date('d',$row['create_timestamp']);?>),
							end:	new Date(<?php echo date('Y',$row['create_timestamp']);?>, <?php echo date('m',$row['create_timestamp'])-1;?>, <?php echo date('d',$row['create_timestamp']);?>) 
						},
						<?php 
						endforeach
						?>
						
					]
				});
	});

    $("#table").change(function (event) {
        filter();
    });

    $("#studentType").change(function (event) {
        filter();
    });

    $("#customerType").change(function (event) {
        filter();
    });

    $("#paymentType").change(function (event) {
        filter();
    });

    function filter() {
        var table = type = '';
        table = $("#table").val();
        
        $(".reportControllers").each(function() {
          if($( this ).data( "type" ) === table) {
            $( this ).show();
          } else {
            $( this ).hide();
          }
        });

        type = $("#"+table+"Type").val();
        $(".card").each(function() {
            if($( this ).data( "table" ) === table && $( this ).data( "type" ) === type) {
                $( this ).show();
            } else {
                $( this ).hide();
            } 
        });
        $(".cardHead").each(function() {
            if($( this ).data( "table" ) === table) {
                $( this ).show();
            } else {
                $( this ).hide();
            } 
        });
    }

  </script>

  
