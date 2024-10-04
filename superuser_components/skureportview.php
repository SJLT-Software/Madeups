<div id="skuReportview" hidden>
    <h1>SKU Report</h1>
    <div>
        <form id="form_sku_report" action="reports/skureportgenerate.php" method="post">
            <label for="skureportsku">SKU:</label>
            <input id="skureportsku" name="skureportsku" type="text" class="form-field" required pattern="^(KJB|H|SA|B)[0-9]+$" title="SKU must start with 'KJB' or 'H' or 'B' or 'SA." onchange="this.reportValidity();" oninput="this.value = this.value.toUpperCase()">
            <label for="nameskureport">Name:</label>
            <input id="nameskureport" name="nameskureport" type="text" class="form-field" required disabled>
            <input type="hidden" id="skureportvalidationField" name="skureportvalidationField" pattern="^(?!.*SKU not found).*$" required>
            <input type="submit" value="Submit">
            <?php if (isset($_SESSION['skureport_pdfgenerate'])) { 
                echo "<button><a href='reports/skureportgeneratepdf.php'>Download PDF</a></button>";
            }
            ?>
        </form>
    </div>
    <div id="addheight"></div>
    <div id="skureporttablediv">
        <table id="skureporttable" border="1">
            <thead>
                <tr>
                    <!-- <th>Date</th> -->
                    <th>Lot Number</th>
                    <th>Width</th>
                    <th>Construction</th>
                    <!-- <th>Total Meters</th> -->
                    <th>Roll Number</th>
                    <th>Roll Meters</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_SESSION['skureport'])) {
                    $skureport = $_SESSION['skureport'];
                    foreach ($skureport as $row) {
                        echo "<tr>";
                        // echo "<td>" . $row['date'] . "</td>";
                        echo "<td>" . $row['lotno'] . "</td>";
                        echo "<td>" . $row['width'] . "</td>";
                        echo "<td>" . $row['construction'] . "</td>";
                        // echo "<td>" . $row['totalmeters'] . "</td>";
                        echo "<td>" . $row['rollno'] . "</td>";
                        echo "<td>" . $row['currentmeters'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "</tr>";
                    
                    }
                                }
                ?>
                    
            </tbody>
        </table>
    </div>
    
    <script type="text/javascript">
        $(document).ready(function() {
            $('#skureporttable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "columnDefs": [
                    // { "orderable": false, "targets": -1 } // Disable ordering on the last column (Operation)
                ]
            });
            $('#skureportsku').on('change', function() {
                var skuNumber = $(this).val();

                $.get('fetchName.php', { sku: skuNumber }, function(data) {
                    $('#nameskureport').val(data);
                    $('#skureportvalidationField').val(data);
                });
            });

            $('#form_sku_report').submit(function(e) {
                var nameValidationValue = $('#skureportvalidationField').val();
                var pattern = /^(?!.*SKU not found).*$/;

                if (!pattern.test(nameValidationValue)) {
                    e.preventDefault();
                    alert('Invalid SKU!!');
                }
            });
        });
    </script>
</div>
