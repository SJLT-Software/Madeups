<div id="outwardform" class="container" hidden>
    <h1>Outward Form</h1>
    <input type="text" id="qrtext_outward" class="form-field" placeholder="QR Text">
    <button onclick="read_qr_outward()">Read QR</button>
    <div id="addheight"></div>

    <form id="form_outward" action="outwardprocess.php" method="post">
        <div id="form_outward_elements">
            <label for="date">Date:</label>
            <input type="date" name="dateoutward" id="dateoutward" class="form-field" required>

            <label for="skuoutward">SKU:</label>
            <input id="skuoutward" name="skuoutward" type="text" class="form-field skuField">

            <label for="nameoutward">Name:</label>
            <input type="text" name="nameoutward" id="nameoutward" class="form-field" placeholder="Name" disabled>
            <input type="hidden" id="outwardvalidationField" name="outwardvalidationField"
                pattern="^(?!.*SKU not found).*$" required>

            <label for="lotnooutward">Lot Number:</label>
            <input type="text" name="lotnooutward" placeholder="Lot Number" id="lotnooutward" class="form-field"
                required>

            <div id="rollinfo">
                <input type="checkbox" name="selectedroll" id="selectedrolldefault" value="0" disabled hidden>
            </div>
            <div id="pickedrolls"></div>
            <input type="hidden" name="rollschoosen" id="rollschoosen" value="0" min="0" step="1" required>

            <label for="totalmetersout">Total Meters Selected:</label>
            <input type="number" name="totalmetersout" placeholder="Total meters" id="totalmetersout" disabled min="0"
                value="0" class="form-field">
        </div>
        <input type="submit" value="Submit">
    </form>

    <script>
        function read_qr_outward() {
            if ($('#qrtext_outward').val() == '') {
                alert('Enter QR Text');
                return;
            }
            var qrtext = $('#qrtext_outward').val();
            var qrtextsplit = qrtext.split('_');
            if (qrtextsplit.length != 5) {
                alert('Invalid QR Text');
                $('#qrtext_outward').val('');
                return;
            }
            $.get('fetchRollInfo.php', {
                type: 'QR',
                id: qrtextsplit[0]
            }, function (data) {
                if (data === 'Not Found') {
                    alert('QR code not found in Database');
                    $('#qrtext_outward').val('');
                    return;
                } else {
                    var roll = JSON.parse(data);
                    if (roll.sku != qrtextsplit[1] || roll.name != qrtextsplit[2] || roll.lotno != qrtextsplit[3] || roll.rollno != qrtextsplit[4]) {
                        alert('QR code does not match with Roll Information');
                        $('#qrtext_outward').val('');
                        return;
                    }
                    if (roll.status == 'out') {
                        alert('Roll is already out');
                        $('#qrtext_outward').val('');
                        return;
                    }

                    $('#form_outward_elements').empty();
                    $('#form_outward_elements').append(
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'outward_qr',
                            id: 'outward_qr',
                            value: $('#qrtext_outward').val(),
                            required: true
                        }),
                        $('<label>').attr({
                            for: 'skuoutward',
                            class: 'form-label'
                        }).text('SKU:'),
                        $('<input>').attr({
                            type: 'text',
                            name: 'skuoutward',
                            id: 'skuoutward',
                            class: 'form-field',
                            value: roll.sku,
                            required: true,
                            readonly: true,
                        }),
                        $('<label>').attr({
                            for: 'nameoutward',
                            class: 'form-label'
                        }).text('Name:'),
                        $('<input>').attr({
                            type: 'text',
                            name: 'nameoutward',
                            id: 'nameoutward',
                            class: 'form-field',
                            value: roll.name,
                            required: true,
                            readonly: true,
                        }),
                        $('<label>').attr({
                            for: 'lotnooutward',
                            class: 'form-label'
                        }).text('Lot Number:'),
                        $('<input>').attr({
                            name: 'lotnooutward',
                            id: 'lotnooutward',
                            class: 'form-field',
                            required: true,
                            value: roll.lotno,
                            readonly: true
                        }),
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'selectedrolloutward',
                            id: 'selectedrolloutward',
                            value: roll.id,
                            required: true
                        }),
                    );
                }
            });
        }

        $(document).ready(function () {
            $('#skuoutward').on('change', function () {
                var skuNumber = $(this).val();

                $.get('fetchName.php', {
                    sku: skuNumber
                }, function (data) {
                    $('#nameoutward').val(data);
                    $('#outwardvalidationField').val(data);
                });
            });

            $('#form_outward').submit(function (e) {
                var nameValidationValue = $('#outwardvalidationField').val();
                var pattern = /^(?!.*SKU not found).*$/;

                if (!pattern.test(nameValidationValue)) {
                    e.preventDefault();
                    alert('Invalid SKU!!');
                } else if ($('#rollschoosen').val() == 0) {
                    e.preventDefault();
                    alert('No rolls selected!!');
                }
            });

            $('#lotnooutward, #skuoutward').on('change', function () {
                var lotNumber = $('#lotnooutward').val();
                var skuNumber = $('#skuoutward').val();

                if (lotNumber && skuNumber) {
                    $.get('fetchRollInfo.php', {
                        lotno: lotNumber,
                        sku: skuNumber
                    }, function (data) {
                        var rolls = JSON.parse(data); // Assuming the data is returned in JSON format
                        var $rollInfoSelect = $('#rollinfo');
                        $rollInfoSelect.empty();

                        $.each(rolls, function (index, roll) {
                            $rollInfoSelect.append($('<input>', {
                                type: 'checkbox',
                                value: roll.id,
                                id: roll.id,
                                name: 'selectedroll',
                                checked: false
                            }));
                            $rollInfoSelect.append($('<label>', {
                                for: roll.id,
                                text: roll.rollno + ' - ' + roll.currentmeters + ' meters'
                            }));
                            $rollInfoSelect.append($('<br>'));
                        });
                    });
                }
            });

            $('#rollinfo').on('click', 'input[name="selectedroll"]', function () {
                var totalmeters = 0;
                var rollschoosen = 0;
                var checkeddiv = $('#pickedrolls');
                var is_checked = $('input[name="selectedroll"]:checked').length;

                $('input[name="selectedroll"]:checked').each(function () {
                    var meters = parseFloat($(this).next('label').text().split(' ')[2]) || 0;
                    totalmeters += meters;
                    checkeddiv.append($('<input>').attr({
                        type: 'hidden',
                        name: 'selectedroll' + rollschoosen,
                        value: $(this).attr('id'),
                        required: true
                    }));
                    rollschoosen++;
                });
                $('#totalmetersout').val(totalmeters);
                $('#rollschoosen').val(is_checked);
            });
        });
    </script>
</div>
