<html>

<?php $this->load->view('templates/css_link'); ?>
<style>
    td.google-visualization-orgchart-space-medium,td.google-visualization-orgchart-linenode{
        border:none !important;
        
    }
    td.google-visualization-orgchart-linebottom{
        border-bottom:2px solid #3388DD !important;
    }
    td.google-visualization-orgchart-lineleft{
        border-left:2px solid #3388DD !important;
    }
    td.google-visualization-orgchart-lineright{
        border-right:2px solid #3388DD !important;
    }
    td.google-visualization-orgchart-linetop{
        border-top:2px solid #3388DD !important;
    }
    img.image_profile{
        object-fit:contain;
    }

    .google-visualization-orgchart-node {
        /* text-align: center;
        vertical-align: middle;
        font-family: arial,helvetica;
        cursor: default; */
        border: none !important;
        /* border-radius: 30px; */
        -webkit-box-shadow: rgb(0 0 0 / 0%) 0px 0px 0px !important;
        -moz-box-shadow: rgba(0, 0, 0, 0.5) 0px 0px 0px !important;
        background-color: #edf7ff; 
        background: #F4BE20;
    }

    th, td {
        font-size: 13px !important;
        border: 5px solid #316E00 !important;
        border-radius: 30px !important;
        vertical-align: middle !important;
    }
</style>
<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->

<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->

<body>

  <!-- Content Starts -->

  <div class="content-wrapper">

    <div class="container-fluid p-4">
      <!--<nav aria-label="breadcrumb">-->
      <!--    <ol class="breadcrumb">-->
      <!--      <li class="breadcrumb-item">-->
      <!--        <a href="<?=base_url()?>selfservices">Self-Services-->
      <!--        </a>-->
      <!--      </li>-->
      <!--      <li class="breadcrumb-item active" aria-current="page">My Team-->
      <!--      </li>-->
      <!--    </ol>-->
      <!--</nav>-->
      <div class='row'>
           <div class='col-md-8'>
            <h2>My Team</h2>
           </div>
           <div class='col text-right'>
                <a href="<?=base_url('selfservices/setup_my_teams')?>" class='btn technos-button-blue'>Setup My Team</a>
           </div>
      </div>
     
    <div id="chart_div"></div>
    </div>

  </div> <!-- Content ends -->


  <!------------------------------------------------------------- JS Add-ons  --------------------------------------------------------->

  <?php $this->load->view('templates/jquery_link'); ?>


 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    fetch("/selfservices/get_my_team").then(res=>res.json()).then(res_data=>{
      console.log(res_data);
      google.charts.load('current', {
        callback: function () {
          var data = new google.visualization.DataTable();
          data.addColumn('string', 'Name');
          data.addColumn('string', 'Manager');
          data.addColumn('string', 'ToolTip');
          for(let i=0;i<res_data.length;i++){
            if(res_data[i].reporting_to){
              if(!res_data[i].position){
                res_data[i].position="";
              }

              res_user_image = res_data[i]["image"];
              res_superior_image = res_data[i]["superior_image"];

              if(res_user_image == ""){
                res_user = "assets_system/images/default_user.jpg";
              }
              else{
                res_user = "assets_user/user_profile/" + res_user_image;
              }

              if(res_superior_image == ""){
                res_superior = "assets_system/images/default_user.jpg";
              }
              else{
                res_superior = "assets_user/user_profile/" + res_superior_image;
              }

              data.addRows([
                ['<img class"user_image" src="<?=base_url()?>'+res_user+'" width=50px height=50px style="object-fit: scale-down; border-radius:100%; border: solid white 2px;">'+'<p>'+res_data[i].name+'</p>'+'<p>'+res_data[i].position+'</p>',
                '<img class"user_image" src="<?=base_url()?>'+res_superior+'" width=50px height=50px style="object-fit: scale-down; border-radius:100%; border: solid white 2px;">'+'<p>'+res_data[i].reporting_to+'</p>'+'<p>'+res_data[i].superior_position+'</p>',res_data[i].position ],
              ]);
          }
          }
          // $.get("/organizational_charts/getOrg",function(res){
        
            
          // },'json')
          var container = document.getElementById('chart_div');
          var chart = new google.visualization.OrgChart(container);

         

          chart.draw(data, {allowHtml:true, allowCollapse:true});
        },
        packages: ['orgchart']
      });
    })
  })
 
   </script>
</body>

</html>