<div class="form-group">
    <label for="contact_name">Contact Name</label>
    <input type="text" class="form-control" name="fullname" id="contact_name" placeholder="Fullname" value="<?= isset($contact_info["name"]) ? $contact_info["name"] : '' ?>" required>
</div>

<div class="form-group">
    <label for="relation">Relationship</label>
    <input type="text" class="form-control" name="relation" id="relation" placeholder="Relationship" value="<?= isset($contact_info["relationship"]) ? $contact_info["relationship"] : '' ?>" required>
</div>

<div class="form-group">
    <label for="mobile_number">Mobile number</label>
    <input type="text" class="form-control" name="mobile_number" id="mobile_number" placeholder="09151234567" value="<?= isset($contact_info["mobile_number"]) ? $contact_info["mobile_number"] : '' ?>" required>
</div>

<div class="form-group">
    <label for="work_phone">Work phone</label>
    <input type="text" class="form-control" name="work_phone" id="work_phone" placeholder="09151234567" value="<?= isset($contact_info["work_phone"]) ? $contact_info["work_phone"] : '' ?>">
</div>

<div class="form-group">
    <label for="home_phone">Home phone</label>
    <input type="tel" class="form-control" name="home_phone" id="home_phone" placeholder="09151234567" value="<?= isset($contact_info["home_phone"]) ? $contact_info["home_phone"] : '' ?>">
</div>

<div class="form-group">
    <label for="current_add">Current Address</label>
    <input type="text" class="form-control" name="current_add" id="current_add" placeholder="Current Address" value="<?= isset($contact_info["current_address"]) ? $contact_info["current_address"] : '' ?>" required>
</div>