$(document).ready(function () {
    // Checkboxes
    var checkbox = {
        locationPosts: $("input[value='location-posts']"),
        datePosts: $("input[value='date-posts']"),
        threads: $("input[value='threads']"),
        boards: $("input[value='boards']")
    };

    // Radio buttons
    var radiobuttonLocation = {
        locationAll: $("input[value='location-all']"),
        locationThread: $("input[value='location-thread']"),
        locationBoard: $("input[value='location-board']"),
        locationCategory: $("input[value='location-category']")
    };
    var radiobuttonDate = {
        dateAll: $("input[value='date-all']"),
        dateDay: $("input[value='date-day']"),
        dateWeek: $("input[value='date-week']"),
        dateMonth: $("input[value='date-month']"),
        dateYear: $("input[value='date-year']"),
        dateCustom: $("input[value='date-custom']")
    };

    // Text fields
    var textfieldLocation = {
        locationThread: $("#location-thread"),
        locationBoard: $("#location-board"),
        locationCategory: $("#location-category")
    };
    var textfieldDate = {
        dateCustomStartText: $("#date-custom-start"),
        dateCustomEndText: $("#date-custom-end")
    };

    // Methods
    var allChecked = function (element,flag) {
        for (var x in element)
        {
            element[x].prop('checked', flag);
        }
    };
    var allDisabled = function (element,flag) {
        for (var x in element)
        {
            element[x].attr('disabled', flag);
        }
    };
    var emptyValues = function (element) {
        for (var x in element)
        {
            element[x].val('');
        }
    }

    // Initializing

    // Unchecking all checkboxes and radio buttons
    allChecked(checkbox,false);
    allChecked(radiobuttonLocation,false);
    allChecked(radiobuttonDate,false);

    // Checking only main radio buttons
    radiobuttonLocation.locationAll.prop('checked', true);
    radiobuttonDate.dateAll.prop('checked', true);

    // Disabling all radio buttons and text fields
    allDisabled(radiobuttonLocation,true);
    allDisabled(radiobuttonDate,true);
    allDisabled(textfieldLocation,true);
    allDisabled(textfieldDate,true);

    $(".search-list").click(function (e) {
        e.preventDefault();
        $("#search-custom-button").html($(this).text() + ' <span class="caret"></span>');
        if ($(this).text() == $("#search-posts").text())
        {
            $("#search-posts-form").slideDown();
        } else $("#search-posts-form").slideUp();
    });

    checkbox.locationPosts.click(function () {
        if (checkbox.locationPosts.is(':checked'))
        {
            allDisabled(radiobuttonLocation,false);
            radiobuttonLocation.locationAll.prop('checked', true);
        }
        else
        {
            allDisabled(radiobuttonLocation,true);
            allDisabled(textfieldLocation,true);
        }
    });

    checkbox.datePosts.click(function () {
        if (checkbox.datePosts.is(':checked'))
        {
            allDisabled(radiobuttonDate,false);
            radiobuttonDate.dateAll.prop('checked', true);
        }
        else
        {
            allDisabled(radiobuttonDate,true);
            allDisabled(textfieldDate,true);
        }
    });

    for (var x in radiobuttonLocation)
    {
        radiobuttonLocation[x].click(function () {
            allDisabled(textfieldLocation, true);
            emptyValues(textfieldLocation);
            if (radiobuttonLocation.locationBoard.is(':checked')) textfieldLocation.locationBoard.attr('disabled', false);
            if (radiobuttonLocation.locationThread.is(':checked')) textfieldLocation.locationThread.attr('disabled', false);
            if (radiobuttonLocation.locationCategory.is(':checked')) textfieldLocation.locationCategory.attr('disabled', false);
        });
    }

    for (var x in radiobuttonDate)
    {
        radiobuttonDate[x].click(function () {
            allDisabled(textfieldDate, true);
            emptyValues(textfieldDate);
            if (radiobuttonDate.dateCustom.is(':checked')) allDisabled(textfieldDate, false);
        });
    }
});