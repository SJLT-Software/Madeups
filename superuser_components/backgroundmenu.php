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
                <button class="droptab" id="showorderdetails" onclick="show_orderdetails()">Order Details</button>
                <div id="drop_orderdetails">
                    <button id="showchecklistitems" onclick="orderdetail_checklistitemsfunc()">Checklist Items</button>
                    <button id="showproductdetails" onclick="orderdetail_productdetailsfunc()">Product Details</button>
                </div>
            </div>
            <button id="accviewbtn" onclick="viewacc()">View Accounts</button>
            <button class="droptab" id="showreps" onclick="show_reports()">Reports</button>
            <div id="drop_reports">
                <button>
                    <a href="reports/overviewreport.php">Overview Report</a>
                </button>
                <button>
                    <a href="reports/detailedreport.php">Warehouse Stock Report</a>
                </button>
                <button>
                    <a href="reports/fabricratereport.php">Fabric Rate Report</a>
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

                function show_orderdetails() {
                    if ($('#drop_orderdetails').is(':visible')) {
                        $('#drop_orderdetails').hide();
                        $('#showorderdetails').text('▼ Order Details');
                    } else {
                        $('#drop_orderdetails').show();
                        $('#showorderdetails').text('▲ Order Details');
                    }
                }

                show_operations();
                show_reports();
                show_orderdetails();
            </script>
        </div>
    </div>
</div>
