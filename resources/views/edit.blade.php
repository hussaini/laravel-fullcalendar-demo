<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Full Calendar Demo - Edit Event</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- css -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.5.0/fullcalendar.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.min.css">

        <!-- js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.5.0/fullcalendar.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.5.4/ckeditor.js"></script>
        <script>
            var DISPLAY_DATE_FORMAT = 'DD-MMM-YYYY';
            var JSON_DATE_FORMAT = 'YYYY-MM-DD';
            var tempEventObj;

            function setModalDate(startDate, endDate) {
                var displayStartDate, displayEndDate, jsonStartDate, jsonEndDate;

                displayStartDate = moment(startDate).format(DISPLAY_DATE_FORMAT)
                jsonStartDate = moment(startDate).format(JSON_DATE_FORMAT);

                if(endDate != null) {
                    displayEndDate = moment(endDate).format(DISPLAY_DATE_FORMAT);
                    jsonEndDate = moment(endDate).format(JSON_DATE_FORMAT);
                }
                else {
                    displayEndDate = displayStartDate;
                    jsonEndDate = jsonStartDate;
                }

                $('#display-start').val(displayStartDate);
                $('#display-end').val(displayEndDate);
                $('#start').val(jsonStartDate);
                $('#end').val(jsonEndDate);
            }

            function clearModal() {
                $('#id, #title, #details, #display-start, #display-end, #start, #end').val('');
                $('#error').css({'display': 'none'})
            }

            function validateInput() {
                var flag = true;

                flag = $('#title').val() != '' && $('#details').val() != ''
                        && (moment($('#start').val()).isBefore($('#end').val())
                        || moment($('#start').val()).isSame($('#end').val()));

                return flag;
            }

            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#calendar').fullCalendar({
                    displayEventTime: false,
                    allDay: true,
                    events: '/api/events/all',
                    dayClick: function(date, jsEvent, view) {
                        clearModal();
                        setModalDate(date);
                        $('#modalTitle').text('Add New Event');
                        $('#btnDel').css({display: 'none'});
                        $('#modalCalendar').modal('show');
                    },
                    eventClick: function(calEvent, jsEvent, view) {
                        tempEventObj = calEvent;
                        setModalDate(calEvent.start, calEvent.end);
                        $('#modalTitle').text('Edit Event');
                        $('#id').val(calEvent.id);
                        $('#title').val(calEvent.title);
                        $('#details').val(calEvent.details);
                        $('#btnDel').css({display: 'inline'});
                        $('#modalCalendar').modal('show');
                    },
                    eventMouseover: function() {
                        $(this).css({'cursor': 'pointer'});
                    }               
                });

                $('#display-start, #display-end').datepicker({
                    format: 'dd-M-yyyy',
                    todayHighlight:'TRUE',
                    autoclose: true,
                    forceParse: false
                });

                $('#display-start, #display-end').change(function() {
                    var date = moment(this.value).format(JSON_DATE_FORMAT);

                    if(this.id == 'display-start') {
                        $('#start').val(date);
                    }
                    else {
                        $('#end').val(date);
                    }
                });

                $('#btnSave').click(function() {
                    $('#error').css({'display': 'none'})

                    if(!validateInput()) {
                        $('#error').css({'display': 'block'})
                        return;
                    }

                    var data = $('#eventForm').serialize();

                    $.ajax({
                        url: '/api/events/set',
                        method: 'POST',
                        dataType: 'json',
                        data: data,
                        success: function(result) {
                            $('#calendar').fullCalendar('refetchEvents');
                            $('#modalCalendar').modal('hide');
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            $('#error').css({'display': 'block'})
                        }
                    });
                });

                $('#btnDel').click(function() {
                    var data = {id: $('#id').val()};

                    $.ajax({
                        url: '/api/events/delete',
                        method: 'POST',
                        dataType: 'json',
                        data: data,
                        success: function(result) {
                            $('#calendar').fullCalendar('refetchEvents');
                            $('#modalCalendar').modal('hide');
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                        }
                    });
                });

            });
        </script>
    </head>
    <body>
        <div class="container">        
            <div id="calendar"></div>
        </div>
        <div class="modal fade" id="modalCalendar" tabindex="-1" role="dialog" aria-labelledby="modalTitle">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="modalTitle">Title</h4>
                    </div>
                    <div class="modal-body" id="modalBody">
                        <form id="eventForm">
                            <input type="hidden" name="id" id="id">
                            <div class="control-group has-error" id="error" style="display: none">
                                <label class="control-label">Please fill in the form properly!</label>
                            </div>
                            <div class="form-group">
                                <label>Title</label>                    
                                <input type="text" name="title" id="title" class="form-control" placeholder="Title">
                            </div>
                            <div class="form-group">
                                <label>Start Date</label>                    
                                <input type="text" name="display-start" id="display-start" class="form-control" placeholder="Start Date">
                                <input type="hidden" name="start" id="start">
                            </div>
                            <div class="form-group">
                                <label>End Date</label>                    
                                <input type="text" name="display-end" id="display-end" class="form-control" placeholder="End Date">
                                <input type="hidden" name="end" id="end">
                            </div>
                            <div class="form-group">
                                <label>Details</label>                    
                                <textarea name="details" id="details" class="form-control" placeholder="Details" rows="10"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="btnSave">Save</button>
                        <button type="button" class="btn btn-danger" id="btnDel">Delete</button>
                        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>        
    </body>
</html>
