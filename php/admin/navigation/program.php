<?php require("pageHeader.php"); ?>

<?php require("messageSection.php"); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="panel-body">
            <div id="dp"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var dp = new DayPilot.Calendar("dp");
    dp.viewType = "Week";
    dp.onEventMoved = function (args) {
        console.log("Moved.");
        // $.post("backend_move.php",
        //     {
        //         id: args.e.id(),
        //         newStart: args.newStart.toString(),
        //         newEnd: args.newEnd.toString()
        //     },
        //     function () {
        //         console.log("Moved.");
        //     });
    };

    dp.onEventResized = function (args) {
        console.log("Resized.");
        // $.post("backend_resize.php",
        //     {
        //         id: args.e.id(),
        //         newStart: args.newStart.toString(),
        //         newEnd: args.newEnd.toString()
        //     },
        //     function () {
        //         console.log("Resized.");
        //     });
    };

    // event creating
    dp.onTimeRangeSelected = function (args) {
        console.log("Created.");
        // var name = prompt("New event name:", "Event");
        // dp.clearSelection();
        // if (!name) return;
        // var e = new DayPilot.Event({
        //     start: args.start,
        //     end: args.end,
        //     id: DayPilot.guid(),
        //     resource: args.resource,
        //     text: name
        // });
        // dp.events.add(e);
        //
        // $.post("backend_create.php",
        //     {
        //         start: args.start.toString(),
        //         end: args.end.toString(),
        //         name: name
        //     },
        //     function () {
        //         console.log("Created.");
        //     });

    };

    dp.onEventClick = function (args) {
        alert("clicked: " + args.e.id());
    };

    dp.init();

    loadEvents();

    function loadEvents() {
        var start = dp.visibleStart();
        var end = dp.visibleEnd();
        console.log('load events')
        // $.post("backend_events.php",
        //     {
        //         start: start.toString(),
        //         end: end.toString()
        //     },
        //     function (data) {
        //         //console.log(data);
        //         dp.events.list = data;
        //         dp.update();
        //     });
    }
</script>