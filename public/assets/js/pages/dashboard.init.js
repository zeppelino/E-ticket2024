var options = 
{
  series: [
    {
      name: "2020",
      type: "column",
      data: [23, 42, 35, 27, 43, 22, 17, 31, 22, 22, 12, 16],
    },
    {
      name: "2019",
      type: "line",
      data: [23, 32, 27, 38, 27, 32, 27, 38, 22, 31, 21, 16],
    },
  ],
  chart: { height: 350, type: "line", toolbar: { show: !1 } },
  stroke: { width: [0, 2.3], curve: "straight" },
  plotOptions: { bar: { horizontal: !1, columnWidth: "34%" } },
  dataLabels: { enabled: !1 },
  markers: {
    size: [0, 3.5],
    colors: ["#6fd088"],
    strokeWidth: 2,
    strokeColors: "#6fd088",
    hover: { size: 4 },
  },
  legend: { show: !1 },
  yaxis: {
    labels: {
      formatter: function (e) {
        return e + "k";
      },
    },
    tickAmount: 5,
    min: 0,
    max: 50,
  },
  colors: ["#0f9cf3", "#6fd088"],
  labels: [
    "Jan",
    "Feb",
    "Mar",
    "Apr",
    "May",
    "Jun",
    "Jul",
    "Aug",
    "Sep",
    "Oct",
    "Nov",
    "Dec",
  ],
};
(chart = new ApexCharts(
  document.querySelector("#column_line_chart"),
  options
)).render();