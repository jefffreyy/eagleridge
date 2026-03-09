<?php
    $user_id    = '';

    $skill_id   = '';

    $name       = '';

    $value      ='';
    if ($SKILLS_MATRIX) {

        foreach($SKILLS_MATRIX as $SKILLS_MATRIX_ROW) {

            $skill_id               = $SKILLS_MATRIX_ROW->id;

            $name                   = $SKILLS_MATRIX_ROW->name;

            $value                  = $SKILLS_MATRIX_ROW->value;



        }

    }
?>
<?php if(!empty($skill_id)) {?>
    <input type="hidden" name="skill_id" value="<?=$skill_id?>" >
<?php } ?>
<div class="form-group">

    <label >Title</label>

    <select class="form-control" name="TITLE" >

    <?php 


    foreach($SKILLS_NAME as $SKILLS_NAME_ROW){  ?>  

        <option value="<?=$SKILLS_NAME_ROW->id?>" <?php if($name == $SKILLS_NAME_ROW->id){echo "Selected";} ?>> <?= $SKILLS_NAME_ROW->name; ?></option>

    <?php  }?>

    </select>

</div>

<div class="form-group">

    <label >Level</label>

    <select class="form-control" name="LEVEL" >

    <?php 

    if($SKILLS_LEVEL){

    foreach($SKILLS_LEVEL as $SKILLS_LEVEL_ROW){  ?>  

        <option value="<?=$SKILLS_LEVEL_ROW->id?>"  <?php if($value == $SKILLS_LEVEL_ROW->id){echo "Selected";} ?>> <?= $SKILLS_LEVEL_ROW->name; ?></option>

    <?php  }} ?>

    </select>

</div>