<div id="inwardform" hidden>
    <h1>Inward Form</h1>
    <form id="form_inward" action="inwardprocess.php" method="post">

        <label for="date">Date:</label>
        <input type="date" name="date" id="date" class="form-field" required>

        <label for="skuinward">SKU:</label>
        <input id="skuinward" name="skuinward" type="text" class="form-field skuField">

        <label for="nameinward">Name:</label>
        <input type="text" name="nameinward" id="nameinward" class="form-field" placeholder="Name" disabled>
        <input type="hidden" id="namevalidationField" name="namevalidationField"
            pattern="^(?!.*SKU not found).*$" required>

        <label for="width">Width:</label>
        <input id="width" name="width" type="number" min=0 step=0.001 class="form-field" placeholder="Width" required>

        <label for="lotno">Lot Number:</label>
        <input type="text" name="lotno" placeholder="Lot Number" id="lotno" class="form-field" required>

        <label for="construction">Construction:</label>
        <input id="construction" name="construction" type="text" class="form-field" required>

        <label for="qty">No. of rolls:</label>
        <input type="number" placeholder="No. of rolls" name="qty" id="qty" class="form-field" min=0 max=100
            placeholder="Enter no. of Rolls" required>

        <div id="fieldsContainer"></div>

        <label for="totalmeters">Total Meters:</label>
        <input type="number" name="totalmeters" placeholder="Total meters" id="totalmeters" disabled min="0"
            step="0.0001" class="form-field">
        <input type="hidden" id="totalmetersfield" name="totalmetersfield" required>

        <input type="submit" value="Submit">

    </form>
    <script>
        $(document).ready(function() {
            $('#qty').change(function() {
                var qty = $('#qty').val();
                // Add validation for qty( hard limit for norolls)
                var container = $('#fieldsContainer');
                container.empty(); // Clear previous fields

                for (var i = 1; i <= qty; i++) {
                    var div = $('<div id="inwardpair"></div>');
                    var labelRollNumber = $('<label for="rollnumber' + i + '" class="form-label">Roll Number:</label>');
                    var inputRollNumber = $('<input id="rollnumber' + i + '" name="rollnumber' + i + '" type="text" class="form-field" placeholder="Roll Number" required>');
                    var labelRollMeters = $('<label for="rollmeters' + i + '" class="form-label2">Roll Meters:</label>');
                    var inputRollMeters = $('<input id="rollmeters' + i + '" name="rollmeters' + i + '" type="number" class="form-field roll-meters" min="0" step="0.0001" placeholder="Roll Meters" required>');

                    div.append(labelRollNumber, inputRollNumber, labelRollMeters, inputRollMeters);
                    container.append(div);
                }
                $('.roll-meters').on('change', function() {
                    var totalMeters = 0;
                    $('.roll-meters').each(function() {
                        var meters = parseFloat($(this).val()) || 0;
                        totalMeters += meters;
                    });
                    $('#totalmeters').val(totalMeters); // Update the total meters field
                    $('#totalmetersfield').val(totalMeters);
                });
            });
            $('#skuinward').on('change', function() {
                var skuNumber = $(this).val();

                $.get('fetchName.php', {
                    sku: skuNumber
                }, function(data) {
                    $('#nameinward').val(data);
                    $('#namevalidationField').val(data);
                });
            });
            $('#form_inward').submit(function(e) {
                var nameValidationValue = $('#namevalidationField').val();
                var pattern = /^(?!.*SKU not found).*$/;

                if (!pattern.test(nameValidationValue)) {
                    e.preventDefault();
                    alert('Invalid SKU!!');
                }
            });
        });
    </script>
</div>
