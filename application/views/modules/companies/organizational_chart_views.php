<html>
<script>
      function setDefaultImage(img) {
        img.src = "<?= base_url() ?>/assets_system/images/default_user.jpg";
        img.alt = 'Default Image';
      }
</script>
<?php $this->load->view('templates/css_link'); ?>
<style>
  td.google-visualization-orgchart-space-medium,
  td.google-visualization-orgchart-linenode {
    border: none !important;
  }

  td.google-visualization-orgchart-linebottom {
    border-bottom: 2px solid #3388DD !important;
  }

  td.google-visualization-orgchart-lineleft {
    border-left: 2px solid #3388DD !important;
  }

  td.google-visualization-orgchart-lineright {
    border-right: 2px solid #3388DD !important;
  }

  td.google-visualization-orgchart-linetop {
    border-top: 2px solid #3388DD !important;
  }

  img.image_profile {
    object-fit: contain;
  }

  .google-visualization-orgchart-node {

    border: none !important;
    -webkit-box-shadow: rgb(0 0 0 / 0%) 0px 0px 0px !important;
    -moz-box-shadow: rgba(0, 0, 0, 0.5) 0px 0px 0px !important;
    background-color: #edf7ff;
  }

  th,
  td {
    font-size: 13px !important;
    border: 5px solid #316E00 !important;
    border-radius: 30px !important;
    vertical-align: middle !important;
  }
</style>

<body>
  <div class="content-wrapper" style="overflow: auto">
    <div class="container-fluid p-4">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="<?= base_url() . 'companies' ?>">Company
            </a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">Organizational Chart
          </li>
        </ol>
      </nav>

      <div class='row'>
        <div class='col-md-8'>
          <h2 style="font-size: 24px;"><a onclick="afterRenderFunction()" href="<?= base_url() . 'companies'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 6px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="">
            </a>&nbsp;Organizational Chart</h2>
        </div>
      </div>
      <div id="chart_div"></div>
    </div>
  </div>

  <?php $this->load->view('templates/jquery_link'); ?>
  <!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> -->
  <script type="text/javascript" src="<?=base_url()?>assets_system/js/charts/loader.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      fetch("<?=base_url()?>companies/get_organizational_chart").then(res => res.json()).then(res_data => {
        console.log('res_data', res_data);
        google.charts.load('current', {
          callback: function() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Name');
            data.addColumn('string', 'Manager');
            data.addColumn('string', 'ToolTip');
            for (let i = 0; i < res_data.length; i++) {
              if (res_data[i].reporting_to) {
                if (!res_data[i].position || res_data[i].position == 0) {
                  res_data[i].position = "";
                }
                if (!res_data[i].superior_position || res_data[i].superior_position == 0) {
                  res_data[i].superior_position = "";
                }
                if (!res_data[i].extra_position || res_data[i].extra_position == 0) {
                  res_data[i].extra_position = "";
                }
                if (!res_data[i].superior_extra_position || res_data[i].superior_extra_position == 0) {
                  res_data[i].superior_extra_position = "";
                }
                res_user_image = res_data[i]["image"];
                res_superior_image = res_data[i]["superior_image"];
                if (!res_user_image) {
                  res_user = "assets_system/images/default_user.jpg";
                } else {
                  res_user = "assets_user/user_profile/" + res_user_image;
                }
                if (!res_superior_image) {
                  res_superior = "assets_system/images/default_user.jpg";
                } else {
                  res_superior = "assets_user/user_profile/" + res_superior_image;
                }
                data.addRows([
                  ['<img class"user_image" onerror="setDefaultImage(this)" src="<?= base_url() ?>' + res_user + '" width=50px height=50px style="object-fit: scale-down; border-radius:100%; border: solid white 2px;">' + '<p>' + res_data[i].name + '</p>' + '<p><b>' + res_data[i].position + '</b></p>' + '<p><b>' + res_data[i].extra_position + '</b></p>',
                    '<img class"user_image" onerror="setDefaultImage(this)" src="<?= base_url() ?>' + res_superior + '" width=50px height=50px style="object-fit: scale-down; border-radius:100%; border: solid white 2px;">' + '<p>' + res_data[i].reporting_to + '</p>' + '<p><b>' + res_data[i].superior_position + '</b></p>' + '<p><b>' + res_data[i].superior_extra_position + '</b></p>', res_data[i].extra_position
                  ],
                ]);
              }
            }

            var container = document.getElementById('chart_div');
            var chart = new google.visualization.OrgChart(container);
            chart.draw(data, {
              allowHtml: true,
              allowCollapse: true
            });
          },
          packages: ['orgchart']
        });
      })
    })
  </script>
</body>

</html>