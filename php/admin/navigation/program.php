<?php require("pageHeader.php"); ?>

<?php require("messageSection.php"); ?>

<style>
    #calendar {
        /*max-width: 1000px;*/
        /*max-height: 500px;*/
        /*margin: 0 auto;*/
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="panel-body">
            <div id="calendar"></div>
        </div>
    </div>
</div>

<script type="application/javascript">
    $('#calendar').fullCalendar({
        schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
        defaultView: 'agendaWeek',
        header: false,
        allDayDefault: false,
        // aspectRatio: 1.5,
        allDaySlot: false,
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        hiddenDays: [0],
        slotMinutes: 60,
        minTime: "08:00:00",
        // maxTime: "23:00:00",
        slotLabelFormat: "HH:mm",
        columnFormat: 'dddd',
        dragOpacity: {
            agenda: .5
        }
    });
</script>