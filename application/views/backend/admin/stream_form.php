					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('stream');?></label>
                        
						<div class="col-sm-5">
							<select name="stream_id" class="form-control selectboxit">
                              <?php 
                              $stream = $this->db->get('stream')->result_array();
                              foreach ($stream as $key => $value) { ?>
                              <option value="<?=$value['stream_id']?>"
                              	<?=($data['stream_id'] == $value['stream_id'])?'selected':''?>
                              	><?=$value['name']?></option>
                              <?php } ?>
                          </select>
						</div> 
					</div>