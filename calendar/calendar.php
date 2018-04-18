<?php
    session_start();
    require_once($_SERVER[DOCUMENT_ROOT]."/cfg/core.php");
    $db = new myDB();
    $db->connect();
    $events = $db->getEvents();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Calendar</title>
    <link href="../plugins/fullcalendar/css/fullcalendar.min.css" rel="stylesheet" />
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.css" rel="stylesheet" type="text/css" />

    <script src="assets/js/modernizr.min.js"></script>

</head>

<body>
<header id="topnav">
    <div class="topbar-main">
        <div class="container-fluid">
            <div class="menu-extras topbar-custom">
                <ul class="list-unstyled topbar-right-menu float-right mb-0">

                    <li class="menu-item">
                        <!-- Mobile menu toggle-->
                        <a class="navbar-toggle nav-link">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </li>
                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle waves-effect nav-user" data-toggle="dropdown" href="#" role="button"
                           aria-haspopup="false" aria-expanded="false">
                            <img src="assets/images/users/avatar-1.jpg" alt="user" class="rounded-circle">  <i class="mdi mdi-chevron-down"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown ">


                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="fi-head"></i> <span><?php echo $_SESSION['username']?></span>
                            </a>


                            <!-- item-->
                            <a href="login.html" class="dropdown-item notify-item">
                                <i class="fi-power"></i> <span>Logout</span>
                            </a>

                        </div>
                    </li>
                </ul>
            </div>
            <!-- end menu-extras -->

            <div class="clearfix"></div>

        </div> <!-- end container -->
    </div>
    <!-- end topbar-main -->
</header>
<!-- End Navigation Bar-->


<div class="wrapper">
    <div class="container-fluid">



        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-lg-3">
                            <a href="#" data-toggle="modal" data-target="#add-category" class="btn btn-lg btn-custom btn-block waves-effect m-t-20 waves-light">
                                <i class="fi-circle-plus"></i> Add Event
                            </a>
                            <div id="external-events" class="m-t-20">
                                <br>
                                <p class="text-muted">Drag and drop your event or click in the calendar</p>
                                <div class="external-event bg-success" data-class="bg-success">
                                    <i class="mdi mdi-checkbox-blank-circle mr-2 vertical-middle"></i>New Theme Release
                                </div>
                                <div class="external-event bg-info" data-class="bg-info">
                                    <i class="mdi mdi-checkbox-blank-circle mr-2 vertical-middle"></i>My Event
                                </div>
                                <div class="external-event bg-warning" data-class="bg-warning">
                                    <i class="mdi mdi-checkbox-blank-circle mr-2 vertical-middle"></i>Meet manager
                                </div>
                                <div class="external-event bg-purple" data-class="bg-purple">
                                    <i class="mdi mdi-checkbox-blank-circle mr-2 vertical-middle"></i>Create New theme
                                </div>
                            </div>

                            <!-- checkbox -->
                            <div class="checkbox checkbox-primary mt-3">
                                <input type="checkbox" id="drop-remove">
                                <label for="drop-remove">
                                    Remove after drop
                                </label>
                            </div>

                            <a href="#" class="btn btn-lg btn-custom btn-block waves-effect m-t-20 waves-light" onclick="saveEvents()">
                                <i class="fi-circle-check"></i> Save
                            </a>
                            <a href="#" class="btn btn-lg btn-custom btn-block waves-effect m-t-20 waves-light" onclick="deleteMonth()">
                                <i class="fi-circle-check"></i> Delete
                            </a>
                        </div> <!-- end col-->
                        <div class="col-lg-9">
                            <div id="calendar"></div>
                        </div> <!-- end col -->
                    </div>  <!-- end row -->
                </div>

                <!-- BEGIN MODAL -->
                <div class="modal fade" id="event-modal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header text-center border-bottom-0 d-block">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Edit Event</h4>
                            </div>
                            <div class="modal-body">

                            </div>
                            <div class="modal-footer border-0 pt-0">
                                <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-success save-event waves-effect waves-light">Create event</button>
                                <button type="button" class="btn btn-danger delete-event waves-effect waves-light" data-dismiss="modal">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="add-category" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header text-center border-bottom-0 d-block">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title mt-2">Add a category</h4>
                            </div>
                            <div class="modal-body p-4">
                                <form role="form">
                                    <div class="form-group">
                                        <label class="control-label">Category Name</label>
                                        <input class="form-control form-white" placeholder="Enter name" type="text" name="category-name"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Enter username in case of surprise</label>
                                        <input class="form-control form-white" placeholder="Telegram username" type="text" name="surprise-username"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Choose Category Color</label>
                                        <select class="form-control form-white" data-placeholder="Choose a color..." name="category-color">
                                            <option value="success">Success</option>
                                            <option value="danger">Danger</option>
                                            <option value="info">Info</option>
                                            <option value="pink">Pink</option>
                                            <option value="primary">Primary</option>
                                            <option value="warning">Warning</option>
                                            <option value="inverse">Inverse</option>
                                        </select>
                                    </div>

                                </form>

                                <div class="text-right">
                                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-custom ml-1 waves-effect waves-light save-category" data-dismiss="modal">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col-12 -->
        </div> <!-- end row -->


    </div> <!-- end container -->
</div>
<!-- end wrapper -->

<!-- jQuery  -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/waves.js"></script>
<script src="assets/js/jquery.slimscroll.js"></script>

<!-- Jquery-Ui -->
<script src="../plugins/jquery-ui/jquery-ui.min.js"></script>

<!-- SCRIPTS -->
<script src="../plugins/moment/moment.js"></script>
<script src='../plugins/fullcalendar/js/fullcalendar.min.js'></script>
<script src="assets/pages/jquery.calendar.js"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<!-- App js -->
<script src="assets/js/jquery.core.js"></script>
<script src="assets/js/jquery.app.js"></script>
<script src="core/requestHelper.js"></script>
<script>
    appendEvents();
    function saveEvents(){
        var events = $.CalendarApp.$calendar.fullCalendar('clientEvents');
        var arr = [];
        for(var i = 0; i < events.length; i++){
            arr[i] = {
                title: events[i].title,
                date: events[i].start.toISOString(),
                username: events[i].username,
                className: events[i].className[0]
             };
            console.log(arr[i])
        }

        sendRequest(
            {
                'save': true,
                'save-events': arr
            },
            function () {swal("Good job!", "Your events was successfully saved!", "success");}
        );
    }
    function deleteMonth() {
        swal({
            title: "Are you sure?",
            text: "All events will be deleted from the calendar",
            icon: "warning",
            buttons: [
                'No, cancel it!',
                'Yes, I am sure!'
            ],
            dangerMode: true,
        }).then(function(isConfirm) {
            if (isConfirm) {
                swal({
                    title: 'All events was deleted!',
                    text: '',
                    icon: 'success'
                }).then(function() {
                    $.CalendarApp.$calendar.fullCalendar('removeEvents');
                });
            } else {
                swal("Cancelled", "", "error");
            }
        });
    }
</script>

</body>
</html>