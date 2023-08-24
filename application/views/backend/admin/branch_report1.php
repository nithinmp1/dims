<div class="row" >
<?php
// $tables = ['student','customer'];
$tables = ['student','customer','income','expense'];
foreach ($tables as $key => $table) {
	$where = [];
	$tableName = $table;
	if(in_array($table,['income','expense'])){
		$tableName = 'payment';
		$this->db->select('branch_id, sum(amount) as count');
		if($table == 'income') {
			$where['payment_type'] = 'income';
		}else if ($table == 'expense') {
			$where['payment_type'] = 'expense';
		}
	} else {
		$this->db->select('branch_id, COUNT(branch_id) as count');
	}
	$this->db->group_by('branch_id');
	$datas = $this->db->get_where($tableName,$where)->result();
	$dataPoints = [];
	foreach($datas as $data) {
		$branch = $this->db->get_where('branch',['branch_id' => $data->branch_id])->row();
		if(!empty($branch)){
			$point = [
				"label" => $branch->name,
				"y"	=> $data->count
			];

			array_push($dataPoints, $point);
		}
	}
	$dataPointsFinal[$table] = $dataPoints;
	
?>
	<div class="col-md-3">
		<div id="chartContainer<?=$key?>" style="height: 370px; width: 100%;">
		
		</div>
	</div>
<?php } ?> 
</div>

<script>
window.onload = function() {
<?php 
foreach ($tables as $key => $table) { 
	$title = ucfirst($table).' Chart';
	$text = '';
	if(isset($from) && isset($to) ){
		$text = $from .' To '. $to; 
	}
	?>
var chart<?=$key?> = new CanvasJS.Chart("chartContainer<?=$key?>", {
	animationEnabled: true,
	title: {
		text: "<?=$title?>"
	},
	subtitles: [{
		text: "<?=$text?>"
	}],
	data: [{
		type: "pie",
		// yValueFormatString: "#,##0.00\"%\"",
		yValueFormatString: "#,##0",
		indexLabel: "{label} ({y})",
		dataPoints: <?php echo json_encode($dataPointsFinal[$table], JSON_NUMERIC_CHECK); ?>
	}]
});
<?php } ?>
<?php foreach ($tables as $key => $table) { ?>
	chart<?=$key?>.render();
<?php } ?>
 
}

$(".canvasjs-chart-credit").hide();
</script>

<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
