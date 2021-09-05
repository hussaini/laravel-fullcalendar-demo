<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Full Calendar Demo</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" charset="utf-8">
    </head>
    <body>
        <div class="container">
            <div id="calendar"></div>
        </div>
        <div class="modal fade" id="modalCalendar" tabindex="-1" role="dialog" aria-labelledby="modalTitle">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalTitle"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body" id="modalBody">
                        <form id="eventForm">
                            <input type="hidden" id="inputId">
                            <div class="control-group has-error" id="error" style="display: none">
                                <label class="control-label">Please fill in the form properly!</label>
                            </div>
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" id="inputTitle" class="form-control" placeholder="Title">
                            </div>
                            <div class="form-group">
                                <label for="inputStartDate">Start Date</label>
                                <input class="form-control" id="inputStartDate">
                            </div>
                            <div class="form-group">
                                <label for="inputEndDate">End Date</label>
                                <input class="form-control" id="inputEndDate">
                            </div>
                            <div class="form-group">
                                <label>Details</label>
                                <textarea id="textareaDetails" class="form-control" placeholder="Details" rows="10"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer btn-group">
                        <button type="button" class="btn btn-success" id="btnSave">Save</button>
                        <button type="button" class="btn btn-danger" id="btnDel">Delete</button>
                        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>
