$(document).ready(function(){
// == NOTE ==
// This code uses ES6 promises. If you want to use this code in a browser
// that doesn't supporting promises natively, you'll have to include a polyfill.

    gapi.analytics.ready(function() {

        /**
         * Authorize the user immediately if the user has already granted access.
         * If no access has been created, render an authorize button inside the
         * element with the ID "embed-api-auth-container".
         */

        gapi.analytics.auth.authorize({
            serverAuth: {
                access_token: accessToken
            }
        });


        /**
         * Create a new ActiveUsers instance to be rendered inside of an
         * element with the id "active-users-container" and poll for changes every
         * five seconds.
         */
        var activeUsers = new gapi.analytics.ext.ActiveUsers({
            container: 'active-users-container',
            pollingInterval: 5
        });


        /**
         * Add CSS animation to visually show the when users come and go.
         */
        activeUsers.once('success', function() {
            var element = this.container.firstChild;
            var timeout;

            this.on('change', function(data) {
                var element = this.container.firstChild;
                var animationClass = data.delta > 0 ? 'is-increasing' : 'is-decreasing';
                element.className += (' ' + animationClass);

                clearTimeout(timeout);
                timeout = setTimeout(function() {
                    element.className =
                        element.className.replace(/ is-(increasing|decreasing)/g, '');
                }, 3000);
            });
        });


        /**
         * Create a new ViewSelector2 instance to be rendered inside of an
         * element with the id "view-selector-container".
         */
        var viewSelector = new gapi.analytics.ext.ViewSelector2({
            container: 'view-selector-container',
        }).execute();

        /**
         * Update the activeUsers component, the Chartjs charts, and the dashboard
         * title whenever the user changes the view.
         */
        viewSelector.on('viewChange', function(data) {
            var title = document.getElementById('view-name');
            title.textContent = data.property.name + ' (' + data.view.name + ')';

            // Start tracking active users for this view.
            activeUsers.set(data).execute();

            // Render all the of charts for this view.
            renderWeekOverWeekChart(data.ids);
            renderDeviceTypeChart(data.ids);
            renderTopCountriesChart(data.ids);
            renderLast30DaysSessions(data.ids);
        });

        /**
         * Create a new DataChart instance with the given query parameters
         * and Google chart options.
         */
        function renderLast30DaysSessions(ids) {
            var dataChart = new gapi.analytics.googleCharts.DataChart({
                query: {
                    metrics: 'ga:sessions',
                    dimensions: 'ga:date',
                    'start-date': '30daysAgo',
                    'end-date': 'yesterday'
                },
                chart: {
                    container: 'chart-1-container',
                    type: 'LINE',
                    options: {
                        width: '100%',
                        colors: ['#daa508']
                    }
                }
            }).set({query: {ids: ids}}).execute();
        }

        /**
         * Draw the a chart.js line chart with data from the specified view that
         * overlays session data for the current week over session data for the
         * previous week.
         */
        function renderWeekOverWeekChart(ids) {

            // Adjust `now` to experiment with different days, for testing only...
            var now = moment(); // .subtract(3, 'day');

            var thisWeek = query({
                'ids': ids,
                'dimensions': 'ga:date,ga:nthDay',
                'metrics': 'ga:sessions',
                'start-date': moment(now).subtract(1, 'day').day(0).format('YYYY-MM-DD'),
                'end-date': moment(now).format('YYYY-MM-DD')
            });

            var lastWeek = query({
                'ids': ids,
                'dimensions': 'ga:date,ga:nthDay',
                'metrics': 'ga:sessions',
                'start-date': moment(now).subtract(1, 'day').day(0).subtract(1, 'week')
                    .format('YYYY-MM-DD'),
                'end-date': moment(now).subtract(1, 'day').day(6).subtract(1, 'week')
                    .format('YYYY-MM-DD')
            });

            Promise.all([thisWeek, lastWeek]).then(function(results) {

                var data1 = results[0].rows.map(function(row) { return +row[2]; });
                var data2 = results[1].rows.map(function(row) { return +row[2]; });
                var labels = results[1].rows.map(function(row) { return +row[0]; });

                labels = labels.map(function(label) {
                    return moment(label, 'YYYYMMDD').format('ddd');
                });

                var data = {
                    labels : labels,
                    datasets : [
                        {
                            label: 'Last Week',
                            fillColor : 'rgba(243,206,98,0.5)',
                            strokeColor : 'rgba(243,206,98,1)',
                            pointColor : 'rgba(243,206,98,1)',
                            pointStrokeColor : '#fff',
                            data : data2
                        },
                        {
                            label: 'This Week',
                            fillColor : 'rgba(218,165,8,0.5)',
                            strokeColor : 'rgba(218,165,8,1)',
                            pointColor : 'rgba(218,165,8,1)',
                            pointStrokeColor : '#fff',
                            data : data1
                        }
                    ]
                };

                new Chart(makeCanvas('chart-2-container')).Line(data);
                generateLegend('legend-2-container', data.datasets);
            });
        }

        /**
         * Draw the a chart.js doughnut chart with data from the specified view that
         * show the sessions grouped by device category.
         */
        function renderDeviceTypeChart(ids) {

            query({
                'ids': ids,
                'dimensions': 'ga:deviceCategory',
                'metrics': 'ga:sessions',
                'sort': '-ga:sessions',
                'max-results': 3
            }).then(function(response) {

                var data = [];
                var colors = ['#daa508', '#ffc825', '#ffdb6f'];

                if (typeof response.rows !== "undefined"){
                    response.rows.forEach(function(row, i) {
                        data.push({ value: +row[1], color: colors[i], label: row[0] });
                    });

                    new Chart(makeCanvas('chart-3-container')).Doughnut(data);
                    generateLegend('legend-3-container', data);
                } else {
                    $('#chart-3-container').parents().closest('.chart-container').hide();
                }
            });
        }


        /**
         * Draw the a chart.js doughnut chart with data from the specified view that
         * compares sessions from mobile, desktop, and tablet over the past seven
         * days.
         */
        function renderTopCountriesChart(ids) {
            query({
                'ids': ids,
                'dimensions': 'ga:country',
                'metrics': 'ga:sessions',
                'sort': '-ga:sessions',
                'max-results': 5
            }).then(function(response) {

                var data = [];
                var colors = ['#daa508', '#ffc825', '#ffdb6f','#fde7a6','#fff4d2'];


                if (typeof response.rows !== "undefined"){
                    response.rows.forEach(function(row, i) {
                        data.push({
                            label: row[0],
                            value: +row[1],
                            color: colors[i]
                        });
                    });

                    new Chart(makeCanvas('chart-4-container')).Doughnut(data);
                    generateLegend('legend-4-container', data);
                } else {
                    $('#chart-4-container').parents().closest('.chart-container').hide();
                }
            });
        }


        /**
         * Extend the Embed APIs `gapi.analytics.report.Data` component to
         * return a promise the is fulfilled with the value returned by the API.
         * @param {Object} params The request parameters.
         * @return {Promise} A promise.
         */
        function query(params) {
            return new Promise(function(resolve, reject) {
                var data = new gapi.analytics.report.Data({query: params});
                data.once('success', function(response) { resolve(response); })
                    .once('error', function(response) { reject(response); })
                    .execute();
            });
        }


        /**
         * Create a new canvas inside the specified element. Set it to be the width
         * and height of its container.
         * @param {string} id The id attribute of the element to host the canvas.
         * @return {RenderingContext} The 2D canvas context.
         */
        function makeCanvas(id) {
            var container = document.getElementById(id);
            var canvas = document.createElement('canvas');
            var ctx = canvas.getContext('2d');

            container.innerHTML = '';
            canvas.width = container.offsetWidth;
            canvas.height = container.offsetHeight;
            container.appendChild(canvas);

            return ctx;
        }


        /**
         * Create a visual legend inside the specified element based off of a
         * Chart.js dataset.
         * @param {string} id The id attribute of the element to host the legend.
         * @param {Array.<Object>} items A list of labels and colors for the legend.
         */
        function generateLegend(id, items) {
            var legend = document.getElementById(id);
            legend.innerHTML = items.map(function(item) {
                var color = item.color || item.fillColor;
                var label = item.label;
                return '<li><i style="background:' + color + '"></i>' +
                    escapeHtml(label) + '</li>';
            }).join('');
        }


        // Set some global Chart.js defaults.
        Chart.defaults.global.animationSteps = 60;
        Chart.defaults.global.animationEasing = 'easeInOutQuart';
        Chart.defaults.global.responsive = true;
        Chart.defaults.global.maintainAspectRatio = false;


        /**
         * Escapes a potentially unsafe HTML string.
         * @param {string} str An string that may contain HTML entities.
         * @return {string} The HTML-escaped string.
         */
        function escapeHtml(str) {
            var div = document.createElement('div');
            div.appendChild(document.createTextNode(str));
            return div.innerHTML;
        }

    });
});