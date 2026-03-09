<html>
<?php $this->load->view('templates/css_link'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" />
<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->

<body>
    <!-- Content Starts -->

    <div id="example"></div>
    </div>
    <?php $this->load->view('templates/jquery_link'); ?>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>


    <script>
         // URL of the API or server endpoint
        var url = '<?=base_url()?>'
        const apiUrl = url+'handsontable/get_all_employees';

        // Replace this with your actual data fetching logic
        fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            // Call the function to initialize Handsontable with fetched data
            initializeHandsontable(data);
        })
        .catch(error => {
            console.error('Data fetch error:', error);
        });

        function initializeHandsontable(data) {

            const container = document.querySelector('#example');
            const hot = new Handsontable(container, {
                data: data, // Use the fetched data here
                colHeaders: ['ID', 'Create Date', 'Edit date', 'edit_user', 'is_deleted', 'col_empl_cmid', 'date_regular', 'isRegular', 'disabled'],
                rowHeaders: true,
                height: 'auto',
                licenseKey: 'non-commercial-and-evaluation'
            });
        }

    </script>
</body>

</html>