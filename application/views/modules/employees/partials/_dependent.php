<div class="form-group">
  <label for="full_name">Fullname</label>
  <input type="text" class="form-control" value="<?= isset($DEPENT_DATA["col_depe_name"]) ? $DEPENT_DATA["col_depe_name"] : '' ?>" name="full_name" id="full_name" placeholder="Fullname">
</div>

<div class="form-group">
  <label for="b_day">Birthday</label>
      <input type="date" class="form-control" name="b_day" id="b_day" value="<?= isset($DEPENT_DATA['col_depe_bday']) ?
                                                                            date_format(date_create($DEPENT_DATA['col_depe_bday']), "Y-m-d") : '' ?>">
</div>

<div class="form-group">
  <label for="gender">Gender</label>
  <select class="form-control" id="gender" name="gender">
  <option value=''>-Select Gender-</option>
    <option value="Male" <?= isset($DEPENT_DATA['col_depe_gndr']) ? $DEPENT_DATA['col_depe_gndr'] == 'Male' ? 'selected' : '' : '' ?>>Male</option>
    <option value="Female" <?= isset($DEPENT_DATA['col_depe_gndr']) ? $DEPENT_DATA['col_depe_gndr'] == 'Female' ? 'selected' : '' : '' ?>>Female</option>
  </select>
</div>

<div class="form-group">
  <label for="gender">Relationship</label>
  <select class="form-control" id="relationship" name="relationship">
  <option value=''>-Select Relationship-</option>
    <option value="Mother" <?= isset($DEPENT_DATA['col_depe_rela']) ? $DEPENT_DATA['col_depe_rela'] == 'Mother' ? 'selected' : '' : '' ?>>Mother</option>
    <option value="Father" <?= isset($DEPENT_DATA['col_depe_rela']) ? $DEPENT_DATA['col_depe_rela'] == 'Father' ? 'selected' : '' : '' ?>>Father</option>
    <option value="Guardian" <?= isset($DEPENT_DATA['col_depe_rela']) ? $DEPENT_DATA['col_depe_rela'] == 'Guardian' ? 'selected' : '' : '' ?>>Guardian</option>
    <option value="Son" <?= isset($DEPENT_DATA['col_depe_rela']) ? $DEPENT_DATA['col_depe_rela'] == 'Son' ? 'selected' : '' : '' ?>>Son</option>
    <option value="Daughter" <?= isset($DEPENT_DATA['col_depe_rela']) ? $DEPENT_DATA['col_depe_rela'] == 'Daughter' ? 'selected' : '' : '' ?>>Daughter</option>
    <option value="Brother" <?= isset($DEPENT_DATA['col_depe_rela']) ? $DEPENT_DATA['col_depe_rela'] == 'Brother' ? 'selected' : '' : '' ?>>Brother</option>
    <option value="Sister" <?= isset($DEPENT_DATA['col_depe_rela']) ? $DEPENT_DATA['col_depe_rela'] == 'Sister' ? 'selected' : '' : '' ?>>Sister</option>
    <option value="Husband" <?= isset($DEPENT_DATA['col_depe_rela']) ? $DEPENT_DATA['col_depe_rela'] == 'Husband' ? 'selected' : '' : '' ?>>Husband</option>
    <option value="Wife" <?= isset($DEPENT_DATA['col_depe_rela']) ? $DEPENT_DATA['col_depe_rela'] == 'Wife' ? 'selected' : '' : '' ?>>Wife</option>
    <option value="Others" <?= isset($DEPENT_DATA['col_depe_rela']) ? $DEPENT_DATA['col_depe_rela'] == 'Others' ? 'selected' : '' : '' ?>>Others</option>
  </select>
  
</div>
