<div id="skuview" hidden>
        <h1>SKU List</h1>
        <div id="detailedskureportdiv">
        <button>
            <a href="reports/detailedskureport.php">SKU Detailed List</a>
        </button>
        </div>
        <div id="skutablediv">
            <table id="skutable" border="1">
                <thead>
                    <th>SKU</th>
                    <th>Name</th>
                    <th>Thread Count</th>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($skus_list)) {
                        echo "<tr>";
                        echo "<td>" . $row['SKU'] . "</td>";
                        echo "<td>" . $row['Name'] . "</td>";
                        echo "<td>" . $row['ThreadCount'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#skutable').DataTable({
                    "order": [
                        [0, "asc"]
                    ],
                    "paging": true,
                    "autowidth": false,                    
                });
            });
        </script>
    </div>