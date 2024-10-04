<div id="accview" hidden>
    <h1>Accounts List</h1>
    <div id="acctablediv">
        <table id="acctable" border="1">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>User ID</th>
                    <th>Password</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($acc_list)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['userid']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['password']) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#acctable').DataTable({
                    "order": [[0, "asc"]],
                    "paging": false,
                });
            });
        </script>
    </div>
</div>
