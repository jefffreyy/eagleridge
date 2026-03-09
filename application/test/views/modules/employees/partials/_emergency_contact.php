<div class="form-group">
    <label for="contact_name">Contact Name</label>
    <input type="text" class="form-control" name="fullname" id="contact_name" placeholder="Fullname" value="<?=isset($contact_info["name"])?$contact_info["name"] :'' ?>" required>
</div>
<div class="form-group">
    <label for="relation">Relationship</label>
    <input type="text" class="form-control" name="relation" id="relation" placeholder="Relationship" value="<?=isset($contact_info["relationship"])?$contact_info["relationship"] :'' ?>" required>
</div>
<div class="form-group">
    <label for="mobile_number">Mobile number</label>
    <input type="tel"   pattern="[0-9]{3}-[0-9]{4}-[0-9]{4}" class="form-control"  minlength="13" maxlength="13" name="mobile_number" id="mobile_number" placeholder="091-2345-6789" value="<?=isset($contact_info["mobile_number"])?$contact_info["mobile_number"] :'' ?>" required>
</div>
<div class="form-group">
    <label for="work_phone">Work phone</label>
    <input type="tel"   pattern="[0-9]{3}-[0-9]{4}-[0-9]{4}" class="form-control"  minlength="13" maxlength="13" name="work_phone" id="work_phone" placeholder="091-2345-6789" value="<?=isset($contact_info["work_phone"])?$contact_info["work_phone"] :'' ?>" >
</div>
<div class="form-group">
    <label for="home_phone">Home phone</label>
    <input type="tel"  pattern="[0-9]{3}-[0-9]{4}-[0-9]{4}" class="form-control"  minlength="13" maxlength="13" name="home_phone" id="home_phone" placeholder="091-2345-6789" value="<?=isset($contact_info["home_phone"])?$contact_info["home_phone"] :'' ?>" >
</div>
<div class="form-group">
    <label for="current_add">Current Address</label>
    <input type="text"  class="form-control"  name="current_add" id="current_add" placeholder="Current Address" value="<?=isset($contact_info["current_address"])?$contact_info["current_address"] :'' ?>" required>
</div>