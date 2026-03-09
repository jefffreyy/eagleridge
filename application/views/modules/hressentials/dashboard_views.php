<?php $this->load->view('templates/css_link'); ?>
<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->

<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->
<?php
  (($this->input->get('year')) ? $url_year = $this->input->get('year') : $url_year = date('Y'));
  (($this->input->get('month')) ? $url_month = $this->input->get('month') :$url_month = date("n"));
  $year_month = $url_year . '-' . sprintf('%02d', $url_month);
?>
<body>
  <!-- Content Starts -->
  <div class="content-wrapper">
    <div class="container-fluid p-4">
         <h1 class="page-title"><a href="<?= base_url('reports');?>"><i class="fa-duotone fa-circle-left"></i></a>&nbsp;Dashboard<h1>
      <div class=" row container-fluid">
        <div class="col-md-7 mr-2 p-3">
          <div class="card p-3 bg-tansparent">
            <div class="row">
              <!--<h3 class="col-sm-6 col-md-3">Dashboard</h3>-->
              <div class="col-sm col-md-6">
                <div class="d-flex justify-content-start align-items-center">
                  <div class="input-group-prepend input-success">
                    <div class="input-group-text">Date</div>
                  </div>

                  
                  <form action="<?= base_url() ?>hressentials/hrdashboard" method="get" class="form-inline ml-2">
                    <input class = "custom-select " type="month" id="year-month" name="start" min="2022-01" value="<?=$year_month?>">
                  </form>
                   <a href="<?= base_url() . 'hressentials/hrdashboard_print' ?>" class="btn btn-success ml-2" id="print">To Print</a>
                </div>
               
              </div>
              
            </div>

          </div>
          <div class="p-2">
            <div class="row">
              <div class="card col-sm-2 col-md-4 p-2 mr-2" id="total_employees">
                <h6>Total Employees</h6>
                <h2><?= $C_TOTAL_EMPL ?></h2>
              </div>
              <div class=" card col-sm-2 col-md-4 p-2 mr-2" id="joiners">
                <h6>Joiners</h6>
                <h2><?= $C_THIS_MONTH_HIRE ?></h2>
              </div>
              <div class=" card col p-2 mr-2" id="leavers">
                <h6>Leavers</h6>
                <h2><?= $C_LEAVERS ?></h2>
              </div>
            </div>
          </div>
          <div class="p-2">
            <div class="row">
              <div class=" card col-sm-6 col-md-4 p-2 mr-2" id="no_skills">
                <h6>No Skills</h6>
                <h2><?= $C_NO_SKILLS ?></h2>
              </div>
              <div class="card  col-sm col-md-4 p-2 mr-2" id="no_education">
                <h6>No Education</h6>
                <h2><?= $C_NO_EDUC ?></h2>
              </div>
              <div class="card  col p-2 mr-2" id="no_dependent">
                <h6>No Dependent</h6>
                <h2><?= $C_NO_DEPENDENT ?></h2>
              </div>
            </div>
          </div>
          <div class="card p-2" style="background-color:white">
            <canvas id="chart_bar">
            </canvas>
          </div>
          <div class=" card p-2" style="background-color:white">
            <div>
              <canvas id="line_chart"></canvas>
            </div>
          </div>
          <div class=" card p-2">
            <div class="row">
              <div class="col-md-12 text-center">
                <h6>Age report</h6>
                <p style="font-size:16px;font-weight:normal">This is the distribution of employees according to their age</p>
              </div>
              <div class="col-md-6">
                <canvas id="doughnut_chart_ages"></canvas>
              </div>
              <div class="col-md">
                <div class="text-center d-flex justify-content-center h-100 align-items-center">
                  <div>
                    <h6>Age average</h6>
                    <p style="font-size:16px;font-weight:normal">That's the average age at your company</p>
                    <div class="">
                      <h5><?= number_format($C_AVG_AGE, 2) ?></h5>
                      <h6>Years</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class=" card p-2">
            <div class="row">
              <div class="col-md-12 text-center">
                <h6>Salary chart</h6>
                <p style="font-size:16px;font-weight:normal">This is the distribution of different salary ranges in your company</p>
              </div>
              <div class="col-md-6">
                <canvas id="doughnut_chart_salary"></canvas>
              </div>
              <div class="col-md">
                <div class="text-center d-flex justify-content-center h-100 align-items-center">
                  <div>
                    <h6>Salary</h6>
                    <p style="font-size:16px;font-weight:normal">That's the average salary at your company</p>
                    <div class="">
                      <h5><?= number_format($C_AVG_SALARY, 2) ?></h5>
                      <h6>Salary</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class=" card mx-1 p-2">
            <h6>Years of Service</h6>
            <div>
              <canvas id="chart_service"></canvas>
            </div>
          </div>

        </div>
        <div class="col-md  p-2">
          <div class="card mx-1 p-2">
            <h6>Employees</h6>
            <div>
              <canvas id="pie_chart"></canvas>
            </div>
          </div>
          <div class=" card mx-1 p-2 ">
            <h6>Gender</h6>
            <div>
              <canvas id="pie_chart_gender"></canvas>
            </div>
          </div>
          <div class=" card mx-1 p-2">
            <h6>Allowance Type</h6>
            <div>
              <canvas id="pie_allo_type"></canvas>
            </div>
          </div>

          
        </div>
      </div>
      <div class=" container-fluid">
        <div>
          <canvas id="myChart"></canvas>
        </div>
      </div>
    </div>

  </div> <!-- Content ends -->


  <!------------------------------------------------------------- JS Add-ons  --------------------------------------------------------->

  <?php $this->load->view('templates/jquery_link'); ?>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0-rc.1/chartjs-plugin-datalabels.min.js" integrity="sha512-+UYTD5L/bU1sgAfWA0ELK5RlQ811q8wZIocqI7+K0Lhh8yVdIoAMEs96wJAIbgFvzynPm36ZCXtkydxu1cs27w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <!--   
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script> -->
  <script>
    const ctx_doughnut_salary = document.getElementById('doughnut_chart_salary');
    const ctx_doughnut_ages = document.getElementById('doughnut_chart_ages');
    const ctx_bar = document.getElementById('bar_chart');
    const ctx_bar_2 = document.getElementById('chart_bar');
    const ctx_bubble = document.getElementById('bubble_chart');
    const ctx_line = document.getElementById('line_chart');
    const ctx_polar = document.getElementById('polarArea_chart');

    const ctx_scatter = document.getElementById('scatter_chart');
    const ctx_radar = document.getElementById('radar_chart');
    fetch("<?= base_url() ?>hressentials/get_pie_ages")
      .then((response) => response.json())
      .then((response) => {
        data = {
          labels: [...response["labels"]],
          fillTextData: true,
          datasets: [{
            label: 'My First Dataset',
            data: [...response["data"]],
            backgroundColor: ["#FF742F", "#FF4854", "#00B8A6", "#A9ADB2", "#FCC002"],
            hoverOffset: 4,

          }]
        };
        new Chart(ctx_doughnut_ages, {
          type: 'doughnut',
          data: data,
          plugins: [ChartDataLabels],
          options: {
            plugins: {
              datalabels: {
                color: 'white',
                display: function(context) {
                  return context.dataset.data[context.dataIndex] !== 0; // or >= 1 or ...
                },
                formatter: function(value) {
                  return Math.round(value);
                },
                font: {
                  size: 20,
                }
              },
              legend: {
                labels: {
                  usePointStyle: true,
                  boxWidth: 6
                },
                position: 'bottom',
              }
            }
          }
        });
      })
    fetch("<?= base_url() ?>hressentials/get_pie_salary")
      .then((response) => response.json())
      .then((response) => {
        data = {
          labels: [...response["labels"]],
          fillTextData: true,
          datasets: [{
            label: 'My First Dataset',
            data: [...response["data"]],
            backgroundColor: ["#A9ADB2", "#FF4854", "#00B8A6", "#FF742F", "#FCC002"],
            hoverOffset: 4,

          }]
        };
        new Chart(ctx_doughnut_salary, {
          type: 'doughnut',
          data: data,
          plugins: [ChartDataLabels],
          options: {
            plugins: {
              datalabels: {
                color: 'white',
                display: function(context) {
                  return context.dataset.data[context.dataIndex] !== 0; // or >= 1 or ...
                },
                formatter: function(value) {
                  return Math.round(value);
                },
                font: {
                  size: 20,
                }
              },
              legend: {
                labels: {
                  usePointStyle: true,
                  boxWidth: 6
                },
                position: 'bottom',
              }
            }
          }
        });
      })
    fetch("<?= base_url() ?>hressentials/get_data_department").then((res) => res.json()).then((response) => {
      const ctx_bar_2 = document.getElementById('chart_bar');
      new Chart(ctx_bar_2, {
        type: 'bar',
        data: {
          labels: [...response["labels"]],
          datasets: [{
            label: 'Number of Employee per Department',
            data: [...response["amount"]],
            borderWidth: 1,
            barThickness: 20,
            borderRadius: 20,
            borderSkipped: false,
            backgroundColor: "#6226F1",
          }],

        },
        options: {
          barValueSpacing: 20,
          scales: {
            y: {
              min: 0,
              ticks: {
                // forces step size to be 50 units
                stepSize: 1
              }
            }

          },
        }
      });
    }).then(() => {

    }).catch((err) => {
      console.log(err);
    })


    fetch("<?= base_url() ?>hressentials/get_line_graph_data")
      .then((res) => res.json())
      .then((response) => {
        labels = [...response["labels"]];
        data = {
          labels: labels,
          datasets: [{
              label: 'Hired Employees',
              data: [...response["data_hired"]],
              fill: false,
              borderColor: '#42B983',
              tension: 0.1,
              pointRadius: 2,
            },
            {
              label: 'Terminated Employees',
              data: [...response['data_terminated']],
              fill: false,
              borderColor: '#FF4069',
              tension: 0.1,
              pointRadius: 2,
            }

          ]
        };
        new Chart(ctx_line, {
          type: 'line',
          data: data,
          options: {
            barValueSpacing: 20,
            scales: {
              y: {
                min: 0,
                ticks: {
                  // forces step size to be 50 units
                  stepSize: 1
                }
              }

            }
          }
        });
      })
      .catch((err) => {
        console.log(err);
      })
    //Pie

    // For allowance type
    fetch("<?= base_url() ?>hressentials/get_pie_salary_type")
      .then((res) => res.json())
      .then((response) => {
        const ctx_pie = document.getElementById('pie_allo_type');
        data = {
          labels: [...response["labels"]],
          datasets: [{
            label: 'Employee type',
            data: [...response["data"]],
            backgroundColor: [
              'rgb(255, 99, 132)',
              'rgb(54, 162, 235)',
            ],
            hoverOffset: 4
          }]
        };
        new Chart(ctx_pie, {
          type: 'pie',
          data: data,
          plugins: [ChartDataLabels],
          options: {
            plugins: {
              datalabels: {
                color: 'white',
                display: function(context) {
                  return context.dataset.data[context.dataIndex] !== 0; // or >= 1 or ...
                },
                formatter: function(value) {
                  return Math.round(value);
                },
                font: {

                  size: 20,
                }
              }
            }
          }
        });
      }).catch((err) => {
        console.log(err);
      })
    // 
    fetch("<?= base_url() ?>hressentials/get_employee_status").then((res) => res.json()).then((response) => {
      const ctx_pie = document.getElementById('pie_chart');
      data = {
        labels: [...response["label"]],
        datasets: [{
          label: 'Employee type',
          data: [...response["amount"]],
          backgroundColor: [
            'rgb(255, 99, 132)',
            'rgb(54, 162, 235)',
            'rgb(255, 205, 86)'
          ],
          hoverOffset: 4
        }]
      };
      new Chart(ctx_pie, {
        type: 'pie',
        data: data,
        plugins: [ChartDataLabels],
        options: {
          plugins: {
            datalabels: {
              color: 'white',
              display: function(context) {
                return context.dataset.data[context.dataIndex] !== 0; // or >= 1 or ...
              },
              formatter: function(value) {
                return Math.round(value);
              },
              font: {

                size: 20,
              }
            }
          }
        }
      });
    }).catch((err) => {
      console.log(err);
    })

    fetch("<?= base_url() ?>hressentials/get_by_gender_employee").then((res) => res.json()).then((response) => {
      const ctx_pie = document.getElementById('pie_chart_gender');
      data = {
        labels: [...response["labels"]],
        datasets: [{
          label: 'Gender',
          data: [...response["data"]],
          backgroundColor: [
            '#4F81BC',
            'rgb(54, 162, 235)',
          ],
          hoverOffset: 4
        }]
      };
      new Chart(ctx_pie, {
        type: 'pie',
        data: data,
        options: {
          plugins: {
            indexAxis: 'y', // <-- here
            responsive: true,
            title: {
              display: true,
              text: 'Custom Chart Title'
            }
          }
        },
        plugins: [ChartDataLabels],
        options: {
          plugins: {
            datalabels: {
              color: 'white',
              display: function(context) {
                return context.dataset.data[context.dataIndex] !== 0; // or >= 1 or ...
              },
              display: function(context) {
                return context.dataset.data[context.dataIndex] !== 0; // or >= 1 or ...
              },
              formatter: function(value) {
                if (value > 0) {
                  return Math.round(value);
                }
              },
              font: {

                size: 20,
              }
            }
          }
        }
      });
    }).catch((err) => {
      console.log(err);
    })


    const ctx_service = document.getElementById('chart_service');
      new Chart(ctx_service, {
        type: 'bar',
        data: {
          labels: [5,10,15,20,25,],
          datasets: [{
            label: 'Years Of Service',
            data: [1,1,2,0,1],
            borderWidth: 1,
            barThickness: 20,
            borderRadius: 0,
            borderSkipped: false,
            backgroundColor: "#2180ed",
          }],

        },
        options: {
          barValueSpacing: 20,
          scales: {
            y: {
              min: 0,
              ticks: {
                // forces step size to be 50 units
                stepSize: 0.5
              }
            }

          },
        }
      });

      $(document).ready(function() {

      // $("#filter_by_year").on("change", function() {
      //     filter_data();
      // })

      // $("#filter_by_month").on("change", function() {
      //     filter_data();
      // })
    
      $("#year-month").on("change", function(){
        var yearmonth  =$(this).val();
        filter_data(yearmonth);
      })

      function filter_data(yearmonth) {
      var base_url = '<?= base_url(); ?>';

      var parts = yearmonth.split('-');
      let year = parts[0];
      var month = parseInt(parts[1], 10);
       
      window.location = base_url + "hressentials/hrdashboard?year="+year+"&month="+month;
      }

      });
  </script>

</body>