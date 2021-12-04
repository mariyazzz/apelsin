
function calendarHeatmap() {
  // defaults
    var selector = 'body';
    var width = 750;
    var SQUARE_LENGTH = 12;
    var height = 110;
  var legendWidth = 190;
  var months = ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'];
  var days = ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'];
  var SQUARE_PADDING = 2;
  var MONTH_LABEL_PADDING = 6;
  var now = moment().endOf('day').toDate();
  var yearAgo = moment().startOf('day').subtract(1, 'year').toDate();
  var data = [];
  var colorRange = ['#D8E6E7', '#218380'];
  var tooltipEnabled = true;
  var tooltipUnit = 'contribution';
  var legendEnabled = true;
  var onClick = null;
  var weekStart = 1; //0 for Sunday, 1 for Monday

  // setters and getters
  chart.data = function (value) {
    if (!arguments.length) { return data; }
    data = value;
    return chart;
  };

  chart.selector = function (value) {
    if (!arguments.length) { return selector; }
    selector = value;
    return chart;
  };

  chart.colorRange = function (value) {
    if (!arguments.length) { return colorRange; }
    colorRange = value;
    return chart;
  };

  chart.tooltipEnabled = function (value) {
    if (!arguments.length) { return tooltipEnabled; }
    tooltipEnabled = value;
    return chart;
  };

  chart.tooltipUnit = function (value) {
    if (!arguments.length) { return tooltipUnit; }
    tooltipUnit = value;
    return chart;
  };

  chart.legendEnabled = function (value) {
    if (!arguments.length) { return legendEnabled; }
    legendEnabled = value;
    return chart;
  };

  chart.onClick = function (value) {
    if (!arguments.length) { return onClick(); }
    onClick = value;
    return chart;
  };

  chart.setWidth = function (value) {
      width = value;
      if (width > 750) {
          width = 750;
      }
      SQUARE_LENGTH = Math.floor((width - SQUARE_PADDING * 52) / 53);
      if (SQUARE_LENGTH > 12) {
          SQUARE_LENGTH = 12;
      }
      height = SQUARE_LENGTH * 7 + 30;
      return chart;
  };

  function chart() {

    d3.select(chart.selector()).selectAll('svg.calendar-heatmap').remove(); // remove the existing chart, if it exists
    if (width < 500) {
        yearAgo = moment().startOf('day').subtract(0.5, 'year').toDate();
        SQUARE_LENGTH = Math.floor((width - SQUARE_PADDING * 26) / 27);
        height = SQUARE_LENGTH * 7 + 30;
    }
    var dateRange = d3.time.days(yearAgo, now); // generates an array of date objects within the specified range
    var monthRange = d3.time.months(moment(yearAgo).startOf('month').toDate(), now); // it ignores the first month if the 1st date is after the start of the month
      dateRange = dateRange.slice(1);
    var firstDate = moment(dateRange[0]);
    var max = 6.5;

    // color range
    var color = d3.scale.linear()
      .range(chart.colorRange())
      .domain([0, max]);

    var tooltip;
    var dayRects;

    drawChart();

    function drawChart() {
      var svg = d3.select(chart.selector())
        .append('svg')
        .attr('width', width)
        .attr('class', 'calendar-heatmap')
        .attr('height', height)
        .style('padding', '15px');

      dayRects = svg.selectAll('.day-cell')
        .data(dateRange);  //  array of days for the last yr

      dayRects.enter().append('rect')
        .attr('class', 'day-cell')
        .attr('width', SQUARE_LENGTH)
        .attr('height', SQUARE_LENGTH)
        .attr('fill', function(d) { return color(countForDate(d)); })
        .attr('x', function (d, i) {
          var cellDate = moment(d);
          var result = cellDate.week() - firstDate.week() + (firstDate.weeksInYear() * (cellDate.weekYear() - firstDate.weekYear()));
          if (cellDate.weekday() == 0) {
              result -= 1;
          }
          return result * (SQUARE_LENGTH + SQUARE_PADDING);
        })
        .attr('y', function (d, i) {
          return MONTH_LABEL_PADDING + formatWeekday(d.getDay()) * (SQUARE_LENGTH + SQUARE_PADDING);
        });

      if (typeof onClick === 'function') {
        dayRects.on('click', function (d) {
          var count = countForDate(d);
          onClick({ date: d, count: count});
        });
      }

      if (chart.tooltipEnabled()) {
        dayRects.on('mouseover', function (d, i) {
          tooltip = d3.select(chart.selector())
            .append('div')
            .attr('class', 'day-cell-tooltip')
            .html(tooltipHTMLForDate(d))
            .style('left', function () { return Math.floor(i / 7) * SQUARE_LENGTH + 'px'; })
            .style('top', function () {
              return formatWeekday(d.getDay()) * (SQUARE_LENGTH + SQUARE_PADDING) + MONTH_LABEL_PADDING * 3 + 'px';
            });
        })
        .on('mouseout', function (d, i) {
          tooltip.remove();
        });
      }

      if (chart.legendEnabled()) {
        var colorRange = [color(0)];
        for (var i = 3; i > 0; i--) {
          colorRange.push(color(max / i));
        }

        var legendGroup = svg.append('g');
        legendGroup.selectAll('.calendar-heatmap-legend')
            .data(colorRange)
            .enter()
          .append('rect')
            .attr('class', 'calendar-heatmap-legend')
            .attr('width', SQUARE_LENGTH)
            .attr('height', SQUARE_LENGTH)
            .attr('x', function (d, i) { return (width - legendWidth) + (i + 1) * (SQUARE_LENGTH + SQUARE_PADDING); })
            .attr('y', height + SQUARE_PADDING)
            .attr('fill', function (d) { return d; });

        legendGroup.append('text')
          .attr('class', 'calendar-heatmap-legend-text')
          .attr('x', width - legendWidth - 13)
          .attr('y', height + SQUARE_LENGTH)
          .text('Меньше');

        legendGroup.append('text')
          .attr('class', 'calendar-heatmap-legend-text')
          .attr('x', (width - legendWidth + SQUARE_PADDING) + (colorRange.length + 3) * 13)
          .attr('y', height + SQUARE_LENGTH)
          .text('Больше');
      }

      dayRects.exit().remove();
      var monthLabels = svg.selectAll('.month')
          .data(monthRange)
          .enter().append('text')
          .attr('class', 'month-name')
          .style()
          .text(function (d) {
            return months[d.getMonth()];
          })
          .attr('x', function (d, i) {
            var matchIndex = 0;
            dateRange.find(function (element, index) {
              matchIndex = index;
              return moment(d).isSame(element, 'month') && moment(d).isSame(element, 'year');
            });

            return Math.floor(matchIndex / 7) * (SQUARE_LENGTH + SQUARE_PADDING);
          })
          .attr('y', 0);  // fix these to the top

      days.forEach(function (day, index) {
        index = formatWeekday(index);
        if (index % 2) {
          svg.append('text')
            .attr('class', 'day-initial')
            .attr('transform', 'translate(-8,' + (SQUARE_LENGTH + SQUARE_PADDING) * (index + 1) + ')')
            .style('text-anchor', 'middle')
            .attr('dy', '2')
            .text(day);
        }
      });
    }

    function tooltipHTMLForDate(d) {
      var dateStr = moment(d).format('DD.MM.YYYY');
      var count = countForDate(d);
      var timers = timersFromDate(d);
      if (timers != '') {
          return '<span><strong>' + count + 'ч.</strong> (' + timersFromDate(d) + ') ' + dateStr + '</span>';
      }
      return '<span><strong>' + count + 'ч.</strong> ' + dateStr + '</span>';
    }

    function countForDate(d) {
      var count = 0;
      var match = chart.data().find(function (element, index) {
        return moment(element.date).isSame(d, 'day');
      });
      if (match) {
        count = match.count;
      }
      return count;
    }

      function timersFromDate(d) {
          var timers = '???';
          var match = chart.data().find(function (element, index) {
              return moment(element.date).isSame(d, 'day');
          });
          if (match) {
              timers = match.timers;
          }
          return timers;
      }

      function pluralize(number, one, two, five) {
          number = Math.abs(Math.floor(number));
          number %= 100;
          if (number >= 5 && number <= 20) {
              return five;
          }
          number %= 10;
          if (number == 1) {
              return one;
          }
          if (number >= 2 && number <= 4) {
              return two;
          }
          return five;
      }

      function formatWeekday(weekDay) {
      if (weekStart === 1) {
        if (weekDay === 0) {
          return 6;
        } else {
          return weekDay - 1;
        }
      }
      return weekDay;
    }

    var daysOfChart = chart.data().map(function (day) {
      return day.date.toDateString();
    });

    dayRects.filter(function (d) {
      return daysOfChart.indexOf(d.toDateString()) > -1;
    }).attr('fill', function (d, i) {
      return color(chart.data()[i].count);
    });
  }

  return chart;
}


// polyfill for Array.find() method
/* jshint ignore:start */
if (!Array.prototype.find) {
  Array.prototype.find = function (predicate) {
    if (this === null) {
      throw new TypeError('Array.prototype.find called on null or undefined');
    }
    if (typeof predicate !== 'function') {
      throw new TypeError('predicate must be a function');
    }
    var list = Object(this);
    var length = list.length >>> 0;
    var thisArg = arguments[1];
    var value;

    for (var i = 0; i < length; i++) {
      value = list[i];
      if (predicate.call(thisArg, value, i, list)) {
        return value;
      }
    }
    return undefined;
  };
}
/* jshint ignore:end */