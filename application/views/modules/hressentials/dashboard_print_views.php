<html>
<?php $this->load->view('templates/css_link'); ?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->

<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->
<?php
  (($this->input->get('year')) ? $url_year = $this->input->get('year') : $url_year = date('Y'));
  (($this->input->get('month')) ? $url_month = $this->input->get('month') :$url_month = date("n"));
  $year_month = $url_year . '-' . sprintf('%02d', $url_month);
  $month_name = date('F', mktime(0, 0, 0, sprintf('%02d', $url_month), 1));
?>
<body>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background-color: #fff !important;
    }

    /* table {
      margin: 2px 0 10px 0;
      width: 100%;
      font-family: arial, sans-serif;
      border-collapse: collapse;
    }

    table,
    td,
    th {
      border: 2px solid #fff;
    }

    td {
      background-color: #ededed;
    }

    .theader {
      background-color: #c4c4c4;
      color: #fff;
    }

    td,
    th {
      width: 100px;
      text-align: center;
      padding: 8px;
    } */

    /* .company_header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border: 2px solid #c4c4c4;
      width: 100%;
      padding: 5px;
      margin: 15px 0;
      border-radius: 5px;
    } */

    /* .header_date {
      text-align: right;
    } */

    /* .title {
      border: 1px solid #a8a8a8;
      width: 100%;
      font-weight: 500;
      padding: 2px;
      margin-top: 5px;
    }

    .title p {
      margin: auto;
      text-align: center;
    }

    .chart {
      display: flex;
      justify-content: center;
      margin: 0 auto;
      background-color: white;
      width: 100%;
    } */

    .chart_div {
      display: flex;
      justify-content: center;
      margin: 0 auto;
      background-color: white;
      width: 100%;
    }

    .chart_div #chart_div {
        width: 100%; 
        max-width: 1200px; 
        margin: 0 auto; 
    }

    /* .circle_chart {
      padding: 3px;
      display: block;
      background-color: white;
      width: 100%;
      font-weight: 500;
      margin-top: 5px;
      margin: 0 auto;
    }

    .circle_chart h6{
      border: 1px solid #a8a8a8;
      padding: 4px;
      text-align: center;
    }

    .pie_box{
      border: 1px solid #cccccc;
      display: flex;
      justify-content: center;
      margin: 0 auto;
    } */

    .container_print {
      padding: 0;
      margin: 0;
    }

    .btn_box{
      display: flex;
      justify-content: right;
      margin: 20px;
      /* text-align: right; */
    }

    #print {
      width: 150px;
      margin-left: .5rem;
    }


    @media print {
      .btn_box {
        display: none;
      }
      /* @page {
        size: A4;
      } */
    }
    /* *{
      outline: 1px solid lightblue;
    } */
  </style>

  <!-- Content Starts -->
  <div class="container_print ">
    
    <div class="btn_box">
      <div class="input-group-prepend input-success">
        <div class="input-group-text">Date</div>
      </div>
      <!-- <form action="<?= base_url() ?>hressentials/hrdashboard_print" method="get" class="form-inline">

        <select onchange="this.form.submit()" class="form-control color-light ml-2 bg-transparent" name="month" id="month">
          <?php for ($m = 1; $m <= 12; $m++) { ?>
            <option class="text-dark" value="<?= $m ?>" <?= $_GET["month"] == $m ? 'selected' : '' ?>><?= date('F', mktime(0, 0, 0, $m, 1, date('Y'))); ?></option>
          <?php } ?>
        </select>
      </form> -->

      <form action="<?= base_url() ?>hressentials/hrdashboard_print" method="get" class="form-inline ml-2">
        <input class = "custom-select " type="month" id="year-month" name="start" min="2022-01" value="<?=$year_month?>">
      </form>
      <button class="btn btn-success" id="print">Prints</button>
    </div>
    
    <div class=" row d-flex justify-content-center">
      <div class="card col-md-12">
      

      <div class="chart_div">
        <div id="chart_div"></div>
      </div>

        <!-- <div class="company_header">
          <img src="<?= base_url() . 'assets_system/images/header_logo.png' ?>" alt="">
          <div class="header_date">
            <h3>Monthly HR Report (<?=$month_name?>)</h3>
            <p id="graph_date">February 25 - March 7, <?=$url_year?></p>
          </div>
        </div> -->

        <!-- ========================= Employee Summary ============================== -->
        <!-- <div class="title">
          <p>Employee Summary</p>
        </div>

        <table>
          <thead>
            <tr class="theader">
              <th>Item</th>
              <th>Count</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Total Employees</td>
              <td><?= $C_TOTAL_EMPL ?></td>
            </tr>
            <tr>
              <td>Joiners</td>
              <td><?= $C_THIS_MONTH_HIRE ?></td>
            </tr>
            <tr>
              <td>Leavers</td>
              <td><?= $C_LEAVERS ?></td>
            </tr>
          </tbody>
        </table>

        <div class="title">
          <p>Joiners - Leavers Trend (Past 6 Months)</p>
        </div>
        <div class="chart"> 
          <div>
            <canvas id="line_chart"></canvas>
          </div>
        </div> -->

        
        <!-- ========================= Employee By Department ============================== -->
        <!-- <div class="title">
          <p>Employee per Department</p>
        </div>

        <table>
          <thead>
            <tr class="theader">
              <th>Item</th>
              <th>Count</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Production</td>
              <td><?=$C_PRODUCTION ?></td>
            </tr>
            <tr>
              <td>Manufacturing</td>
              <td><?=$C_MANUFACTURING ?></td>
            </tr>
            <tr>
              <td>Administration</td>
              <td><?=$C_ADMINISTRATION ?></td>
            </tr>
            <tr>
              <td>Sales</td>
              <td><?=$C_SALES ?></td>
            </tr>
            <tr>
              <td>Accounting</td>
              <td><?=$C_ACCOUNTING ?></td>
            </tr>
    
          </tbody>
        </table>

        <div class="title">
          <p>Number of Employee per Department</p>
        </div>
        <div class="chart"> 
          <div>
            <canvas id="chart_bar"></canvas>
          </div>
        </div> -->

        <!-- ========================= Leaver ============================== -->
        <!-- <div class="title">
          <p>Leavers By Categories</p>
        </div>

        <table>
          <thead>
            <tr class="theader">
              <th>Item</th>
              <th>Count</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Resigned</td>
              <td><?= $C_TOTAL_RES ?></td>
            </tr>
            <tr>
              <td>End of Contract</td>
              <td><?= $C_TOTAL_END_CON ?></td>
            </tr>
            <tr>
              <td>Terminated</td>
              <td><?= $C_TOTAL_TERMINATED ?></td>
            </tr>
            <tr>
              <td>AWOL</td>
              <td><?= $C_TOTAL_AWOL ?></td>
            </tr>
          </tbody>
        </table>

        <div class="circle_chart">
          <h6>Leavers Pie Chart</h6>
          <div class="pie_box">
            <canvas id="leavers_pie_chart"></canvas>
          </div>
        </div>
         -->
        <!-- ========================= Employee ============================== -->
        <!-- <div class="title">
          <p>Employees Type by Categories</p>
        </div>

        <table>
          <thead>
            <tr class="theader">
              <th>Item</th>
              <th>Count</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Regular</td>
              <td><?=$C_REGULAR?></td>
            </tr>
            <tr>
              <td>Probationary</td>
              <td><?=$C_PROBATIONARY?></td>
            </tr>
            <tr>
              <td>Project Based</td>
              <td><?=$C_PROJ_BASE?></td>
            </tr>
          </tbody>
        </table>

        <div class="circle_chart">
          <h6>Employees Pie Chart</h6>
          <div class="pie_box">
            <canvas id="pie_chart"></canvas>
          </div>
        </div> -->

        <!-- ========================= Gender ============================== -->
        <!-- <div class="title">
          <p>Genders by Categories</p>
        </div>

        <table>
          <thead>
            <tr class="theader">
              <th>Item</th>
              <th>Count</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Male</td>
              <td><?=$C_MALE?></td>
            </tr>
            <tr>
              <td>Female</td>
              <td><?=$C_FEMALE?></td>
            </tr>
          </tbody>
        </table>

        <div class="circle_chart">
          <h6>Genders Pie Chart</h6>
          <div class="pie_box">
            <canvas id="pie_chart_gender"></canvas>
          </div>
        </div> -->

        <!-- ========================= Allowance ============================== -->
        <!-- <div class="title">
          <p>Allowances by Categories</p>
        </div>

        <table>
          <thead>
            <tr class="theader">
              <th>Item</th>
              <th>Count</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Daily</td>
              <td><?=$C_DAILY?></td>
            </tr>
            <tr>
              <td>Monthly</td>
              <td><?=$C_MONTHLY?></td>
            </tr>
     
          </tbody>
        </table>

        <div class="circle_chart">
          <h6>Allowances Pie Chart</h6>
          <div class="pie_box">
            <canvas id="pie_allo_type"></canvas>
          </div>
        </div> -->

        <!-- ========================= Age Report ============================== -->
        <!-- <div class="title">
          <p>Age Report by Categories</p>
        </div>

        <table>
          <thead>
            <tr class="theader">
              <th>Item</th>
              <th>Count</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Age</td>
              <td>2</td>
            </tr>
            <tr>
              <td>Age</td>
              <td>4</td>
            </tr>

          </tbody>
        </table>

        <div class="circle_chart">
          <h6>Age Report Doughnut Chart</h6>
          <div class="pie_box">
            <canvas id="doughnut_chart_ages"></canvas>
          </div>
        </div> -->

        <!-- ========================= Salary Chart ============================== -->
        <!-- <div class="title">
          <p>Salary Chart by Categories</p>
        </div>

        <table>
          <thead>
            <tr class="theader">
              <th>Item</th>
              <th>Count</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Salary</td>
              <td>2</td>
            </tr>
            <tr>
              <td>Salary</td>
              <td>4</td>
            </tr>

          </tbody>
        </table>

        <div class="circle_chart">
          <h6>Salary Doughnut Chart</h6>
          <div class="pie_box">
            <canvas id="doughnut_chart_salary"></canvas>
          </div>
        </div> -->

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
  // google.charts.load('current', {'packages':['corechart']});
  // google.charts.setOnLoadCallback(drawChart);
  // function drawChart() {

  //   // Create the data table.
  //   var data = new google.visualization.DataTable();
  //   data.addColumn('string', 'Topping');
  //   data.addColumn('number', 'Slices');
  //   data.addRows([
  //     ['Mushrooms', 3],
  //     ['Onions', 1],
  //     ['Olives', 1],
  //     ['Zucchini', 1],
  //     ['Pepperoni', 2]
  //   ]);

  //   var options = {'title':'How Much Pizza I Ate Last Night', 'width':400,'height':300};

  //   var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
  //   chart.draw(data, options);
  // }

google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawBasic);

function drawBasic() {

      var data = new google.visualization.DataTable();
      data.addColumn('timeofday', 'Time of Day');
      data.addColumn('number', 'Motivation Level');

      data.addRows([
        [{v: [8, 0, 0], f: '8 am'}, 1],
        [{v: [9, 0, 0], f: '9 am'}, 2],
        [{v: [10, 0, 0], f:'10 am'}, 3],
        [{v: [11, 0, 0], f: '11 am'}, 4],
        [{v: [12, 0, 0], f: '12 pm'}, 5],
        [{v: [13, 0, 0], f: '1 pm'}, 6],
        [{v: [14, 0, 0], f: '2 pm'}, 7],
        [{v: [15, 0, 0], f: '3 pm'}, 8],
        [{v: [16, 0, 0], f: '4 pm'}, 9],
        [{v: [17, 0, 0], f: '5 pm'}, 10],
      ]);

      var options = {
        title: 'Motivation Level Throughout the Day',
        hAxis: {
          title: 'Time of Day',
          format: 'h:mm a',
          viewWindow: {
            min: [7, 30, 0],
            max: [17, 30, 0]
          },
          orientation: 'portrait'
        },
        // vAxis: {
        //   title: 'Rating (scale of 1-10)'
        // },
        width: 1000, 
        height: 1200,
        chartArea: {
          width: '80%',
          height: '80%',
        }
      };

      var chart = new google.visualization.ColumnChart(
        document.getElementById('chart_div'));

      chart.draw(data, options);
    }

  
</script>
  
  <!-- <script>
    const ctx_doughnut_salary         = document.getElementById('doughnut_chart_salary');
    const ctx_doughnut_ages           = document.getElementById('doughnut_chart_ages');
    const ctx_bar                     = document.getElementById('bar_chart');
    const ctx_bar_2                   = document.getElementById('chart_bar');
    const ctx_bubble                  = document.getElementById('bubble_chart');
    const ctx_line                    = document.getElementById('line_chart');
    const ctx_polar                   = document.getElementById('polarArea_chart');
    const ctx_scatter                 = document.getElementById('scatter_chart');
    const ctx_radar                   = document.getElementById('radar_chart');
    const ctx_leaver                  = document.getElementById('leavers_pie_chart');

    ctx_line.width = 1000;
    ctx_line.height = 190;

    ctx_bar_2.width = 1000;
    ctx_bar_2.height = 190;



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
            },
            aspectRatio:7
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
            },
            aspectRatio:7
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

    const graph_date = document.getElementById('graph_date');
    // Get the current date
    const currentDate = new Date();
    // Get the current year
    const currentYear = currentDate.getFullYear();

    fetch("<?= base_url() ?>hressentials/get_line_graph_data")
      .then((res) => res.json())
      .then((response) => {
        
        graph_date.innerText =  `${response.graph_date[0]} - ${response.graph_date[5]}, ${currentYear}`;
       
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
            },
          aspectRatio:7
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
          },
          aspectRatio:7
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
            '#5993f7',
            '#ffa8f8',
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
          },
          aspectRatio:7
        }
      });
    }).catch((err) => {
      console.log(err);
    })

    fetch("<?= base_url() ?>hressentials/get_termination_data")
    .then((res) => res.json())
    .then((response) => {
      console.log(response.labels);
      console.log(response.data);
    data = {
        labels: response.labels,
        datasets: [{
          label: 'Termination Type',
          data: response.data,
          backgroundColor: [
            '#2ed96f',
            '#6931ad',
            '#334db5',
            '#d93d98'
          ],
          hoverOffset: 7
        }]
      };
      new Chart(ctx_leaver, {
        type: 'pie',
        data: data,
        plugins: [ChartDataLabels],
        options: {
          plugins: {
            datalabels: {
              color: 'white',
              font: {
                size: 20,
              }
            }
          },
          aspectRatio:7
        }
      });
    }).catch((error) => {
      console.log(error);
    })

    const print_btn = document.getElementById('print');

    print_btn.addEventListener('click', function() {
      print();
    })


    $(document).ready(function() {

    $("#year-month").on("change", function(){
      var yearmonth  =$(this).val();
      filter_data(yearmonth);
    })

    function filter_data(yearmonth) {
    var base_url = '<?= base_url(); ?>';

    var parts = yearmonth.split('-');
    let year = parts[0];
    var month = parseInt(parts[1], 10);
    
    window.location = base_url + "hressentials/hrdashboard_print?year="+year+"&month="+month;
    }

});
  </script> -->

</body>

</html>