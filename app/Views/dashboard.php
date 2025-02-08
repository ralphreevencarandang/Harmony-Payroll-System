<?=
    $this->extend('base');
$this->section('main_content');

?>

<style>
    .dash-widget-icon {
        background-color: hsl(211, 60%, 74%);
        border-radius: 100%;
        color: hsl(211, 60%, 24%);
        display: inline-block;
        float: left;
        font-size: 30px;
        height: 60px;
        line-height: 60px;
        margin-right: 10px;
        text-align: center;
        width: 60px;
    }

    .dash-widget-info {
        text-align: right;
    }

    .dash-widget-info>h3 {
        font-size: 30px;
        font-weight: 600;
    }

    .dash-widget-info>span {
        font-size: 16px;
    }
</style>


<div class="container">


    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success alert-dismissible show fade">
            <h4 class="alert-heading">Login Success!</h4>
            <hr />
            <p>
                Hello! <strong><?= session()->getFlashdata('message') ?></strong>, Welcome to the Harmony
                Multi-Purpose-Cooperative
            </p>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible show fade">
            <h4 class="alert-heading"><?= session()->getFlashdata('error') ?></h4>
            <hr />
            <p>
                Hello! <strong>Admin</strong>, Welcome to the Harmony Multi-Purpose-Cooperative
            </p>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

    <?php endif; ?>




    <h1 class="my-3">Welcome to Harmony Multi Purpose Cooperative</h1>
    <div class="pb-2"><strong>Dashboard</strong></div>


    <div class="row">
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3 mb-3">
            <div class="card dash-widget">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="fa fa-users"></i></span>
                    <div class="dash-widget-info">
                        <h3><?= $employee ?></h3>
                        <span>Employees</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3 mb-3">
            <div class="card dash-widget">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="fa fa-cubes"></i></span>
                    <div class="dash-widget-info">
                        <h3><?= $deparment ?></h3>
                        <span>Departments</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3 mb-3">
            <div class="card dash-widget">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="fa fa-diamond"></i></span>
                    <div class="dash-widget-info">
                        <h3><?= $position ?></h3>
                        <span>Position</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3 mb-3">
            <div class="card dash-widget">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="fa fa-calendar"></i></span>
                    <div class="dash-widget-info">
                        <h3><?= $holiday ?></h3>
                        <span>Holiday</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3 mb-3">
            <div class="card dash-widget">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="fa fa-clock"></i></span>
                    <div class="dash-widget-info">
                        <h3><?= $ontime_today ?></h3>
                        <span>On Time Today</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3 mb-3">
            <div class="card dash-widget">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="fa fa-clock"></i></span>
                    <div class="dash-widget-info">
                        <h3><?= $late_today ?></h3>
                        <span>Late Today</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3 mb-3">
            <div class="card dash-widget">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="fa fa-arrow-up"></i></span>
                    <div class="dash-widget-info">
                        <h3><?= $late_percentage ?> %</h3>
                        <span>On Time Percentage</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3 mb-3">
            <div class="card dash-widget">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="fa fa-arrow-down"></i></span>
                    <div class="dash-widget-info">
                        <h3><?= $ontime_percentage ?> %</h3>
                        <span>Late Percentage</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
   




</div>





<?= $this->endSection() ?>