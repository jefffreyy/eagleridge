<?php

if ($EDUCATION) {

    foreach ($EDUCATION as $EDUCATION_ROW) {

        $educ_id                = $EDUCATION_ROW->id; 

        $degree                 = $EDUCATION_ROW->col_educ_degree; 
        $level                  = $EDUCATION_ROW->col_educ_level;

        $school                 = $EDUCATION_ROW->col_educ_school; 

        $address                = $EDUCATION_ROW->address; 

        $from_yr                = $EDUCATION_ROW->col_educ_from_yr; 

        $to_yr                  = $EDUCATION_ROW->col_educ_to_yr; 

        $grade                  = $EDUCATION_ROW->col_educ_grade; 
        $completion             = $EDUCATION_ROW->completion; 


    }

}
?>
<style>
    /* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>
<input type="hidden" name="educ_id" value="<?=isset($educ_id)?$educ_id :''?>" >

<div class="form-group">
    <label for="level">Level</label>
    <select class="form-control" id="level"  name="LEVEL">
      <option value="No Education" is_deg='0' <?=isset($level)? $level=='No Education'? 'selected': '' :''?> >No Education</option>
      <option value="Grade School" is_deg='0' <?=isset($level)? $level=='Grade School'? 'selected': '' :''?>>Grade School</option>
      <option value="High School" is_deg='0' <?=isset($level)? $level=='High School'? 'selected': '' :''?>>High School</option>
      <option value="K12 Primary(G1-G6)" is_deg='0' <?=isset($level)? $level=='K12 Primary(G1-G6)'? 'selected': '' :''?>>K12 Primary(G1-G6)</option>
      <option value="K12 Secondary(G7-G10)" is_deg='0' <?=isset($level)? $level=='K12 Secondary(G7-G10)'? 'selected': '' :''?>>K12 Secondary(G7-G10)</option>
      <option value="K12 Senior High(G11-G12)" is_deg='0' <?=isset($level)? $level=='K12 Senior High(G11-G12)'? 'selected': '' :''?>>K12 Senior High(G11-G12)</option>
      <option value="ALS" is_deg='0' <?=isset($level)? $level=='ALS'? 'selected': '' :''?>>ALS</option>
      <option value="Bachelor Degree" is_deg='1' <?=isset($level)? $level=='Bachelor Degree'? 'selected': '' :''?>>Bachelor Degree</option>
      <option value="Master Degree" is_deg='1' <?=isset($level)? $level=='Master Degree'? 'selected': '' :''?>>Master Degree</option>\
      <option value="Doctorate Degree" is_deg='1' <?=isset($level)? $level=='Doctorate Degree'? 'selected': '' :''?>>Doctorate Degree</option>
    </select>
  </div>
<div class="form-group">

    <label >Degree</label>

    <input class="form-control " id="degree" type="text" name="DEGREE" value="<?=isset($degree)? $degree : ''?>" required  />

</div>
<div class="form-group">

    <label >School</label>

    <input class="form-control " type="text" name="SCHOOL" value="<?=isset($school)?$school :''?>" required />

</div>

<div class="form-group">

    <label >Address</label>

    <input class="form-control " type="text" name="ADDRESS" value="<?=isset($address)?$address :''?>" required />

</div>

<div class="form-group">

    <label >From Year</label>

    <input class="form-control " type="number" name="FROM_YR" value="<?=isset($from_yr)?$from_yr : ''?>" required />

</div>

<div class="form-group">

    <label >To Year</label>

    <input class="form-control " type="number" name="TO_YR" value="<?=isset($to_yr)?$to_yr:''?>" required />

</div>
<div class="form-group">

    <label >Grade</label>

    <input class="form-control " type="number" name="GRADE" value="<?=isset($grade)?$grade :''?>" required />

</div>
<div class="form-group">
    <label for="completion">Completion</label>
    <select class="form-control" id="completion" name="COMPLETION">
      <option value="Incomplete">Incomplete</option>
      <option value="Present">Present</option>
      <option value="Gradute">Graduate</option>
</div>

