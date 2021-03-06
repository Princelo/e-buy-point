$(function ($)
{
    var month = {
            "number": ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"],
            "short": ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
            "long": ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"]
        },
        today = new Date(),
        todayYear = today.getFullYear(),
        todayMonth = today.getMonth() + 1,
        todayDay = today.getDate();

    generateBirthdayPicker = function ($parent, options)
    {
        // Create the html picker skeleton
        var $fieldset = $("<fieldset class='birthdayPicker'></fieldset>"),
            $year = $("<select class='birthYear "+options.sizeClass+"' name='birth[year]'></select>"),
            $month = $("<select class='birthMonth "+options.sizeClass+"' name='birth[month]'></select>"),
            $day = $("<select class='birthDate "+options.sizeClass+"' name='birth[day]'></select>")
        $birthday = $("<input class='birthDay form-control' name='bdate' type='text' data-date=\"出生日期不正确\" data-error=\"出生日期不正确\" required/>");

        // Add the option placeholders if specified
        if (options.placeholder) {
            $("<option value='0'>年</option>").appendTo($year);
            $("<option value='0'>月</option>").appendTo($month);
            $("<option value='0'>日</option>").appendTo($day);
        }

        // Deal with the various Date Formats
        $fieldset.append($year).append($month).append($day);
        //calculate the year to add to the select options.
        var yearBegin = todayYear - options.minAge;
        var yearEnd = todayYear - options.maxAge;
        if (options.maxYear != todayYear && options.maxYear > todayYear) {
            yearBegin = options.maxYear;
            yearEnd = yearEnd + (options.maxYear - todayYear)
        }
        for (var i = yearBegin; i >= yearEnd; i--) {
            $("<option></option>").attr("value", i).text(i).appendTo($year);
        }
        for (var i = 0; i <= 11; i++) {
            $("<option></option>").attr('value', i + 1).text(month[options.monthFormat][i]).appendTo($month);
        }
        for (var i = 1; i <= 31; i++) {
            var number = (i < 10) ? "0"+i: i;
            $("<option></option>").attr('value', i).text(number).appendTo($day);
        }

        // Set the default date if given
        if (options.defaultDate) {
            var date = new Date(options.defaultDate);
            console.log(date);
            $year.val(date.getFullYear());
            $month.val(date.getMonth() + 1);
            $day.val(date.getDate());
        }
        $fieldset.append($birthday);
        $parent.append($fieldset);
        $fieldset.on('change', function ()
        {
            // currently selected values
            selectedYear = parseInt($year.val(), 10),
                selectedMonth = parseInt($month.val(), 10),
                selectedDay = parseInt($day.val(), 10);
            //rebuild the index for the month. 
            var currentMaxMonth = $month.children(":last").val();
            if (selectedYear > todayYear) {
                if (currentMaxMonth > todayMonth) {
                    while (currentMaxMonth > todayMonth) {
                        $month.children(":last").remove();
                        currentMaxMonth--;
                    }
                }
            } else {
                while (currentMaxMonth < 12) {
                    $("<option></option>").attr('value', parseInt(currentMaxMonth)+1).text(month[options.monthFormat][currentMaxMonth]).appendTo($month);
                    currentMaxMonth++;
                }
            }

            var currentMaxDate = $day.children(":last").val();
            // number of days in currently selected year/month
            var actMaxDay = (new Date(selectedYear, selectedMonth, 0)).getDate();
            if (currentMaxDate > actMaxDay) {
                while (currentMaxDate > actMaxDay) {
                    $day.children(":last").remove();
                    currentMaxDate--;
                }
            } else if (currentMaxDate < actMaxDay ) {
                while (currentMaxDate < actMaxDay)
                {
                    var dateIndex = parseInt(currentMaxDate) + 1;
                    var number = (dateIndex < 10) ? "0"+dateIndex: dateIndex;
                    $("<option></option>").attr('value', dateIndex).text(number).appendTo($day);
                    currentMaxDate++;
                }
            }
            // update the hidden date
            if ((selectedYear * selectedMonth * selectedDay) != 0) {
                if (selectedMonth<10) selectedMonth="0"+selectedMonth;
                if (selectedDay<10) selectedDay="0"+selectedDay;
                hiddenDate = selectedYear + "-" + selectedMonth + "-" + selectedDay;
                $(this).find("input[name=bdate]").val(hiddenDate);
            }
        });
    }

    $.fn.birthdayPicker = function(options)
    {
        return this.each(function () {
            var settings = $.extend($.fn.birthdayPicker.defaults, options );
            generateBirthdayPicker($(this), settings);
        });
    };

    $.fn.birthdayPicker.defaults = {
        "maxAge"        : 100,
        "minAge"        : 0,
        "maxYear"       : todayYear,
        "dateFormat"    : "middleEndian",
        "monthFormat"   : "number",
        "placeholder"   : true,
        "defaultDate"   : false,
        "sizeClass"		: "span2"
    }
}( jQuery ))