					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('branch');?></label>
                        
						<div class="col-sm-5">
							<select id="branch_id" name="branch_id" class="form-control selectboxit">
                              <?php 
                              $branch = $this->db->get('branch')->result_array();
                              foreach ($branch as $key => $value) { ?>
                              <option value="<?=$value['branch_id']?>"
                              	<?=($row['branch_id'] == $value['branch_id'])?'selected':''?>
                              	><?=$value['name']?></option>
                              <?php } ?>
                          </select>
						</div> 
					</div>