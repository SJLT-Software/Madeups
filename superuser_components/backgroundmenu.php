<div id="headerdiv">
    <div id="reportsdiv">
        <a href="https://sjlt.in/" target="_blank">SJLT Group of Mills</a>
        <a href="https://oyvu.in/" target="_blank">OYVU</a>
    </div>
    <div id="logoutbtndiv">
        <a href="logout.php" id="logoutbtn">Logout</a>
    </div>
</div>

<div id="bodydiv">
    <div id="btnsdiv">
        <div id="btns">
            <button onclick="addsku()">ADD SKU</button>
            <button class="droptab" id="showops" onclick="show_operations()">Operations</button>
            <div id="drop_opertations">
                <button onclick="viewsku()">View SKU</button>
                <button onclick="addinward()">Inward Form</button>
                <button onclick="addoutward()">Outward Form</button>
                <button onclick="addreturn()">Return Form</button>
            </div>
            <button id="accviewbtn" onclick="viewacc()">View Accounts</button>
            <button class="droptab" id="showreps" onclick="show_reports()">Reports</button>
            <div id="drop_reports">
                <button>
                    <a href="reports/overviewreport.php">Overview Report</a>
                </button>
                <button>
                    <a href="reports/detailedreport.php">Detailed Report</a>
                </button>
                <button id="showskureport" onclick="skureportfunc()">SKU Report</button>
            </div>
            <script type="text/javascript">
                function show_operations() {
                    if ($('#drop_opertations').is(':visible')) {
                        $('#drop_opertations').hide();
                        $('#showops').text('▼ Operations');
                    } else {
                        $('#drop_opertations').show();
                        $('#showops').text('▲ Operations');
                    }
                }

                function show_reports() {
                    if ($('#drop_reports').is(':visible')) {
                        $('#drop_reports').hide();
                        $('#showreps').text('▼ Reports');
                    } else {
                        $('#drop_reports').show();
                        $('#showreps').text('▲ Reports');
                    }
                }

                show_operations();
                show_reports();
            </script>
        </div>
    </div>
</div>
