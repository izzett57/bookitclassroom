$(document).ready(function() {
    var initialEndTimeOptions = []; // Store initial "End Time" options

    // Generate initial "End Time" options
    for (var hour = 0; hour < 24; hour++) {
        for (var minute = 0; minute < 60; minute += 30) {
            var timeString = (hour < 10 ? "0" + hour : hour) + ":" + (minute === 0 ? "00" : minute);
            initialEndTimeOptions.push($('<option>', {
                value: timeString,
                text: timeString
            }));
        }
    }

    $('#starttime').change(function() {
        var starttime = $(this).val();
        var currentEndTime = $('#endtime').val(); // Capture the currently selected "End Time"

        var startHoursMinutes = starttime.split(':');
        var startTotalMinutes = parseInt(startHoursMinutes[0]) * 60 + parseInt(startHoursMinutes[1]);

        // Clear current "End Time" options
        $('#endtime').empty();

        // Dynamically generate "End Time" options based on "Start Time"
        $.each(initialEndTimeOptions, function(index, option) {
            var optionTime = $(option).val();
            var optionHoursMinutes = optionTime.split(':');
            var endTotalMinutes = parseInt(optionHoursMinutes[0]) * 60 + parseInt(optionHoursMinutes[1]);

            if (endTotalMinutes > startTotalMinutes) {
                $('#endtime').append($(option).clone()); // Use clone to avoid removing from initialEndTimeOptions
            }
        });

        // Re-select the previously selected "End Time" if still valid
        if ($('#endtime option[value="' + currentEndTime + '"]').length > 0) {
            $('#endtime').val(currentEndTime);
        } else {
            // Optionally, handle the case where the previous "End Time" is no longer valid
            // e.g., select the next valid "End Time" automatically or leave as is
        }

        $('#endtime').removeAttr('disabled');
    });
    $('select').on('focus', function() {
        $(this).children('option').css('font-size', '18px'); // Smaller font size for options
    }).on('blur change', function() {
        $(this).children('option').css('font-size', '16px'); // Revert to original font size
    });
});
