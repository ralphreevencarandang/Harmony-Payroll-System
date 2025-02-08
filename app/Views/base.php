<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harmony</title>
    <base href="/">
    <link rel="icon" type="image/x-icon" href="<?= base_url('images/HarmonyLogo.jpg'); ?>">
    <!-- BOOTSTRAP LINK -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="assets/bootstrap-5.0.2-dist/css/bootstrap.min.css"> -->

    <!-- DATA TABLE CSS -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.bootstrap5.css">


    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>



    <!-- DATA TABLE JS -->
    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.bootstrap5.js"></script>



    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/fa5bb6b8d5.js" crossorigin="anonymous"></script>







    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        ::after,
        ::before {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }


        * {
            box-sizing: border-box;
        }



        a {
            text-decoration: none;
        }

        li {
            list-style: none;
        }

        h1 {
            font-weight: 600;
            font-size: 1.5rem;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;

            height: 100vh;
        }

        .wrapper {
            display: flex;
        }

        .main {
            min-height: 100vh;
            width: 100%;
            overflow: hidden;
            transition: all 0.35s ease-in-out;
            background-color: #fafbfe;
        }

        #sidebar {
            width: 70px;
            min-width: 70px;
            z-index: 1000;
            transition: all .25s ease-in-out;
            background-color: #0e2238;
            display: flex;
            flex-direction: column;
        }

        #sidebar.expand {
            width: 260px;
            min-width: 260px;
        }

        .toggle-btn {
            background-color: transparent;
            cursor: pointer;
            border: 0;
            padding: 1rem 1.5rem;
        }

        .toggle-btn i {
            font-size: 1.5rem;
            color: #FFF;
        }

        .sidebar-logo {
            margin: auto 0;
        }

        .sidebar-logo a {
            color: #FFF;
            font-size: 1.15rem;
            font-weight: 600;
        }

        #sidebar:not(.expand) .sidebar-logo,
        #sidebar:not(.expand) a.sidebar-link span {
            display: none;
        }

        .sidebar-nav {
            padding: 2rem 0;
            flex: 1 1 auto;
        }

        a.sidebar-link {
            padding: .625rem 1.625rem;
            color: #FFF;
            display: block;
            font-size: 0.9rem;
            white-space: nowrap;
            border-left: 3px solid transparent;


        }



        .sidebar-link i {
            font-size: 1.1rem;
            margin-right: .75rem;
        }

        a.sidebar-link:hover {
            background-color: rgba(255, 255, 255, .075);
            border-left: 3px solid #3b7ddd;
        }

        .sidebar-item {
            position: relative;
        }



        #sidebar:not(.expand) .sidebar-item .sidebar-dropdown {
            position: absolute;
            top: 0;
            left: 70px;
            background-color: #0e2238;
            padding: 0;
            min-width: 15rem;
            display: none;
        }

        #sidebar:not(.expand) .sidebar-item:hover .has-dropdown+.sidebar-dropdown {
            display: block;
            max-height: 15em;
            width: 100%;
            opacity: 1;
        }

        #sidebar.expand .sidebar-link[data-bs-toggle="collapse"]::after {
            border: solid;
            border-width: 0 .075rem .075rem 0;
            content: "";
            display: inline-block;
            padding: 2px;
            position: absolute;
            right: 1.5rem;
            top: 1.4rem;
            transform: rotate(-135deg);
            transition: all .2s ease-out;
        }

        #sidebar.expand .sidebar-link[data-bs-toggle="collapse"].collapsed::after {
            transform: rotate(45deg);
            transition: all .2s ease-out;
        }

        /* HEADER  */
        header {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 15px 20px;
            background-color: #0e2238;
            color: #fff;
            width: 100%;


        }

        .logo {
            font-size: 1.5em;
        }

        .profile-menu {
            position: relative;
        }

        .profile-icon {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .profile-icon img {
            border-radius: 50%;
            margin-right: 10px;
        }

        .username {
            margin-right: 5px;
        }

        .arrow {
            font-size: 0.8em;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            background-color: #fff;
            color: #333;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            overflow: hidden;
            z-index: 1000;
            min-width: 160px;
        }

        .dropdown-menu a {
            display: block;
            padding: 12px 16px;
            text-decoration: none;
            color: #333;
            border-bottom: 1px solid #eee;
        }

        .dropdown-menu a:last-child {
            border-bottom: none;
        }

        .dropdown-menu a:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn text-light" type="button">

                    <strong>MPC</strong>
                </button>
                <div class="sidebar-logo">
                    <a href="/dashboard">Harmony</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="/dashboard" class="sidebar-link">
                        <i class="lni lni-grid-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/attendance" class="sidebar-link">
                        <i class="lni lni-agenda"></i>
                        <span>Attendance</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#authEmployee" aria-expanded="false" aria-controls="auth">
                        <i class="fa-solid fa-user" style="color: #ffffff;"></i>
                        <span>Employee</span>
                    </a>
                    <ul id="authEmployee" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="manageEmployee" class="sidebar-link" style="text-indent: 15px;
"><i class="fa-solid fa-arrow-right fa-beat"></i> Manage Employee</a>
                        </li>

                        <li class="sidebar-item">
                            <a href="/employeeForm" class="sidebar-link" style="text-indent: 15px;
"><i class="fa-solid fa-arrow-right fa-beat"></i> Add Employee</a>
                        </li>


                    </ul>
                </li>





                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#authDepartment" aria-expanded="false" aria-controls="auth">
                        <i class="fa-solid fa-building" style="color: #ffffff;"></i>
                        <span>Department</span>
                    </a>
                    <ul id="authDepartment" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="/department" class="sidebar-link" style="text-indent: 15px;"><i class="fa-solid fa-arrow-right fa-beat"></i> Add Deparment</a>
                        </li>

                        <li class="sidebar-item">
                            <a href="/position" class="sidebar-link" style="text-indent: 15px;"><i class="fa-solid fa-arrow-right fa-beat"></i> Add Position</a>
                        </li>

                    </ul>
                </li>



                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#authContribution" aria-expanded="false" aria-controls="auth">
                        <i class="fa-solid fa-dollar" style="color: #ffffff;"></i>
                        <span>Contribution</span>
                    </a>

                    <ul id="authContribution" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="/SSSList" class="sidebar-link" style="text-indent: 15px;
"> <i class="fa-solid fa-arrow-right fa-beat"></i> SSS</a>
                        </li>

                        <li class="sidebar-item">
                            <a href="/pagibigList" class="sidebar-link" style="text-indent: 15px;
"><i class="fa-solid fa-arrow-right fa-beat"></i> Pagibig</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/philhealthList" class="sidebar-link" style="text-indent: 15px;
"><i class="fa-solid fa-arrow-right fa-beat"></i> Philhealth</a>
                        </li>


                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="/payroll" class="sidebar-link">
                        <i class="lni lni-layout"></i>
                        <span>Payroll</span>
                    </a>
                </li>
    
                <li class="sidebar-item">
                    <a href="/leave" class="sidebar-link">
                        <i class="lni lni-calendar"></i>
                        <span>Leaves</span>
                    </a>
                </li>


                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#authPayhead" aria-expanded="false" aria-controls="auth">
                        <i class="fa-solid fa-dollar" style="color: #ffffff;"></i>
                        <span>Payheads</span>
                    </a>

                    <ul id="authPayhead" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="/manual_payhead" class="sidebar-link" style="text-indent: 15px"> <i class="fa-solid fa-arrow-right fa-beat"></i> Manual Inputs</a>
                        </li>

                        <li class="sidebar-item">
                            <a href="/payhead" class="sidebar-link" style="text-indent: 15px"> <i class="fa-solid fa-arrow-right fa-beat"></i> Default Payheads</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/assignPayhead" class="sidebar-link" style="text-indent: 15px"> <i class="fa-solid fa-arrow-right fa-beat"></i> Assign Payheads</a>
                        </li>


                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="/holiday" class="sidebar-link">
                        <i class="lni lni-calendar"></i>
                        <span>Holidays List</span>
                    </a>
                </li>
                <!-- <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="fa-solid fa-calendar" style="color: #ffffff;"></i>
                        <span>Leave Management</span>
                    </a>
                </li> -->


                <li class="sidebar-item">
                    <a href="/archive" class="sidebar-link">
                        <i class="fa-solid fa-box-archive" style="color: #ffffff;"></i>
                        <span>Archive</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/activityLog" class="sidebar-link">
                        <i class="fa-regular fa-clock" style="color: #ffffff;"></i>
                        <span>Activity Log</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/settings" class="sidebar-link">
                        <i class="fa-solid fa-gear" style="color: #ffffff;"></i>
                        <span>Settings</span>
                    </a>
                </li>




            </ul>

        </aside>

        <!-- <div class="main-container w-100"> -->


        <div class="main">
            <div class="header-section">
                <?= $this->renderSection('header_content'); ?>
            </div>

            <div class="container-fluid p-3">
                <?= $this->renderSection('main_content'); ?>
            </div>

        </div>




    </div>

    <script>

        const hamBurger = document.querySelector(".toggle-btn");

        hamBurger.addEventListener("click", function () {
            document.querySelector("#sidebar").classList.toggle("expand");
        });

        // HEADER


    </script>



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>

    <!-- <script src="assets/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script> -->



</body>

</html>