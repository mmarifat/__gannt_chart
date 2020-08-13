<!--
  - Author mmarifat<mma.rifat66@gmail.com>
  - Email: mma.rifat66@gmail.com
  - Created on : Wednesday 13 Aug, 2020 09:46:43 BDT
  -->
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Gannt</title>
    <script type="text/javascript" src="/g/js/moment-with-locales.min.js"></script>
</head>
<body>
<div class="chart-wrapper">
    <ul id="chart-headers"></ul>
    <ul id="chart-data"></ul>
</div>
<footer class="page-footer">
    <small>
        mma
    </small>
</footer>
</body>
</html>

<script>
    //dynamic data
    let dynamicData = [
        {
            "tasks": ["Rigging", "Animation", "LookDev"],
            "startDate": "9 Jul 2020",
            "endDate": "23 Jul 2020"
        },
        {
            "tasks": ["Animation", "LookDev"],
            "startDate": "9 Jul 2020",
            "endDate": "23 Jul 2020"
        },
        {
            "tasks": ["Design", "Texturing", "Lighting", "Compositing"],
            "startDate": "16 Jul 2020",
            "endDate": "23 Jul 2020"
        },
        {
            "tasks": ["Compositing"],
            "startDate": "16 Jul 2020",
            "endDate": "23 Jul 2020"
        },
        {
            "tasks": ["Texturing", "Rigging", "LookDev"],
            "startDate": "15 Jul 2020",
            "endDate": "23 Jul 2020"
        }
    ]

    let colors = ['#b03532', '#33a8a5', '#30997a', '#6a478f', '#da6f2b', '#3d8bb1', '#e03f3f', '#59a627', '#4464a1']

    let endDate = new Date(Math.max.apply(null, dynamicData.map(function (e) {
        return new Date(e.endDate);
    })));
    let startDate = new Date(Math.min.apply(null, dynamicData.map(function (e) {
        return new Date(e.startDate);
    })));

    Date.prototype.addDays = function (days) {
        var date = new Date(this.valueOf());
        date.setDate(date.getDate() + days);
        return date;
    }

    function createRange(startDate, stopDate) {
        var dateArray = new Array();
        var currentDate = startDate;
        while (currentDate <= stopDate) {
            dateArray.push(new Date(currentDate));
            currentDate = currentDate.addDays(1);
        }
        return dateArray.map(e => moment(e).format('DD MMM YYYY'));
    }

    document.getElementById('chart-headers').innerHTML = createRange(startDate, endDate).map(date =>
        '<li>' + date + '</li>'
    ).join('')

    document.getElementById('chart-data').innerHTML = dynamicData.map(d => '<li data-duration="' +
        moment(d.startDate).format('DD MMM YYYY') + '-' +
        moment(d.endDate).format('DD MMM YYYY') +
        '" data-color="' + colors[Math.floor(Math.random() * colors.length)] + '">' + d.tasks.join(',') + '</li>'
    ).join('')

    function createChart(e) {
        const daysArray = [...document.querySelectorAll("#chart-headers li")];
        const tasks = document.querySelectorAll("#chart-data li");
        tasks.forEach(el => {
            const duration = el.dataset.duration.split("-");
            let left = 0, width = 0;

            let filteredArray = daysArray.filter(day => day.textContent == duration[0]);
            left = filteredArray[0].offsetLeft;

            filteredArray = daysArray.filter(day => day.textContent == duration[1]);
            width = filteredArray[0].offsetLeft + filteredArray[0].offsetWidth - left;

            el.style.left = `${left}px`;
            el.style.width = `${width}px`;
            if (e.type == "load") {
                el.style.backgroundColor = el.dataset.color;
                el.style.opacity = 1;
            }
        });
    }

    window.addEventListener("load", createChart);
    window.addEventListener("resize", createChart);
</script>


<style>
    :root {
        --white: #fff;
        --divider: lightgrey;
        --body: #f5f7f8;
    }

    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    ul {
        list-style: none;
    }

    a {
        text-decoration: none;
        color: inherit;
    }

    body {
        background: var(--body);
        font-size: 16px;
        font-family: sans-serif;
        padding-top: 40px;
    }

    .chart-wrapper {
        max-width: 1150px;
        padding: 0 10px;
        margin: 0 auto;
    }

    .chart-wrapper #chart-headers {
        position: relative;
        display: flex;
        margin-bottom: 20px;
        font-weight: bold;
        font-size: 1.2rem;
    }

    .chart-wrapper #chart-headers li {
        flex: 1;
        min-width: 80px;
        text-align: center;
    }

    .chart-wrapper #chart-headers li:not(:last-child) {
        position: relative;
    }

    .chart-wrapper #chart-headers li:not(:last-child)::before {
        content: '';
        position: absolute;
        right: 0;
        height: 510px;
        border-right: 1px solid var(--divider);
    }

    .chart-wrapper #chart-data li {
        position: relative;
        color: white;
        margin-bottom: 15px;
        font-size: 16px;
        border-radius: 20px;
        padding: 10px 20px;
        width: 0;
        opacity: 0;
        transition: all 0.65s linear 0.2s;
    }

    @media screen and (max-width: 600px) {
        .chart-wrapper #chart-data li {
            padding: 10px;
        }
    }

    .page-footer {
        font-size: 0.85rem;
        padding: 10px;
        text-align: center;
        color: black;
    }

    .page-footer span {
        color: #e31b23;
    }
</style>