<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Full Calendar Demo</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" charset="utf-8">

        <!-- css -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.5.0/fullcalendar.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.min.css">

        <!-- js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.5.0/fullcalendar.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#calendar').fullCalendar({                 
                    events: '/api/events/all',
                    eventClick: function(calEvent, jsEvent, view) {

                        $('#modalTitle').text(calEvent.title)
                        if(calEvent.details != null) {
                            $('#modalBody').html(calEvent.details)
                        }

                        $('#modalCalendar').modal('show');
                    },
                    eventMouseover: function() {
                        $(this).css({'cursor': 'pointer'});
                    },
                    customButtons: {
                        editEvent: {
                            text: 'Edit Event',
                            click: function() {
                                location.href = '/edit';
                            }
                        }
                    },
                    header: {
                        right: 'editEvent today prev,next',
                    }                            
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
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>        
    </body>
</html>
