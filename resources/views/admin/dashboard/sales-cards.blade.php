<div class="row">
    <!-- Column -->
    <div class="col-md-6 col-lg-2 col-xlg-3">
        <div class="card card-hover">
            <div class="box bg-cyan text-center">
                <h1 class="font-light text-white">
                    <i class="fas fa-user"></i>
                </h1>
                <h6>
                    <a class="text-white" href="{{ route('users.index') }}">
                        Users ({{ @$counts['user'] }})</a>
                </h6>
            </div>
        </div>
    </div>

    <!-- Column -->
    <div class="col-md-6 col-lg-2 col-xlg-3">
        <div class="card card-hover">
            <div class="box bg-danger text-center">
                <h1 class="font-light text-white">
                    <i class="mdi mdi-border-outside"></i>
                </h1>
                <h6>
                    <a class="text-white" href="{{ route('staffs.index') }}">
                        Staffs ({{ @$counts['staff'] }})</a>
                </h6>
            </div>
        </div>
    </div>
    <!-- Column -->
    <div class="col-md-6 col-lg-2 col-xlg-3">
        <div class="card card-hover">
            <div class="box bg-info text-center">
                <h1 class="font-light text-white">
                    <i class="fas fa-list-alt"></i>
                </h1>
                <h6>
                    <a class="text-white" href="{{ route('batches.index') }}">
                        Batches ({{ @$counts['batch'] }})</a>
                </h6>
            </div>
        </div>
    </div>
    <!-- Column -->
    <div class="col-md-6 col-lg-2 col-xlg-3">
        <div class="card card-hover">
            <div class="box bg-cyan text-center">
                <h1 class="font-light text-white">
                    <i class="mdi mdi-relative-scale"></i>
                </h1>
                <h6>
                    <a class="text-white" href="{{ route('student-fees.index') }}">
                         Fees ({{ @$counts['fee'] }})</a>
                </h6>
            </div>
        </div>
    </div>
    <!-- Column -->
    <div class="col-md-6 col-lg-2 col-xlg-3">
        <div class="card card-hover">
            <div class="box bg-success text-center">
                <h1 class="font-light text-white">
                    <i class="mdi mdi-calendar-check"></i>
                </h1>
                <h6><a class="text-white" href="{{ route('events.index') }}">Events ({{ @$counts['event'] }})</a></h6>
            </div>
        </div>
    </div>
    <!-- Column -->
    <div class="col-md-6 col-lg-2 col-xlg-3">
        <div class="card card-hover">
            <div class="box bg-warning text-center">
                <h1 class="font-light text-white">
                    <i class="mdi mdi-alert"></i>
                </h1>
                <h6><a class="text-white" href="{{ route('notifications.index') }}">Notifications
                         ({{ @$counts['notification'] }})</a></h6>
            </div>
        </div>
    </div>
    <!-- Column -->
</div>
