<div id="orderdetail_productdetailsform" hidden>
<form id="form_orderdetail_productdetails" action="orderdetailform_productdetailsprocess.php" method="post">
<label for="sales_order_no">Sales Order No.:</label>
        <input type="text" name="sales_order_no" id="sales_order_no" class="form-field" required>

<h2> Product Details </h2>
        <div id="product_details">
        <table border="1" id="product_details_table">
            <thead>
                <tr>
                    <th>PO No</th>
                    <th>Buyer Product Code</th>
                    <th>Internal Product Code</th>
                    <th>Product Type</th>
                    <th>TC</th>
                    <th>Design/Weave</th>
                    <th>Color</th>
                    <th>Size</th>
                    <th>Order Qty</th>
                    <th>Cut Size</th>
                    <th>Cut Plan Direction</th>
                    <th>Cut Width in Inches</th>
                    <th>Cutting Comments</th>
                    <th>Consumption</th>
                    <th>Thread Code</th>
                    <th>Label</th>
                    <th>Elastic</th>
                    <th>Label Placement</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
        <button type="button" id="addProductRow" class="button">Add Product Row</button>
        </div>
        <button type="submit" class="button">Submit</button>
</form>
<script type="text/javascript">
    $(document).ready(function() {
        $('#addProductRow').click(function() {
                const newRow = $("<tr></tr>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td><input type='text' class='form-field' required></td>");
                newRow.append("<td><button type='button' class='lockRow'>Lock</button></td>");
                newRow.append("<button type='button' class='removeRow'>Remove</button>");
                $('#product_details_table tbody').append(newRow);
            });
        });

</script>
</div>