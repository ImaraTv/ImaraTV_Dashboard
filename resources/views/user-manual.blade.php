<!DOCTYPE html>
<html lang="en">
    <style>
        .top-cont{
            text-align: left;
            display:flex;
            background-color: #383961;
        }
       
        .top-label{
            width: 100;
            text-align:center;
        }

        #spacer{
            height: 70px;
            font-size: 0px;
            background: linear-gradient(0deg, rgba(124,164,220,0.9233894241290266) 24%, rgba(56,57,97,1) 82%);
            top:15%;
        }

        .container{
            width:100%;
            display:flex;
            background-color: #7ca4dc;    
        }

        .nav-sidebarl{
            position: -webkit-sticky;
            position: sticky;
            top:25%;
            width: 24%;
            height: 50%;
            margin-right:1%;
            display:flex;
        }

        .nav-container{
            text-align: center;
        }

        .icon{
            width:40%;
            margin-left: auto;
            margin-right: auto;
            mix-blend-mode: multiply;
        }

        .manual-content{
            padding-left: 20px;
            width:50%;
        }

        .cont1{
            display: flex;
            width:100%;
            flex-direction: row;
            justify-content: space-between;
            border-bottom: 5px solid;
            border-image: linear-gradient(90deg, rgba(124,164,220,1) 10%, rgba(56,57,97,1) 50%, rgba(124,164,220,1) 90%) 1;
            flex-wrap: wrap;
        }

        .cont2{
            width:100%;
            border-bottom: 5px solid;
            border-image: linear-gradient(90deg, rgba(124,164,220,1) 10%, rgba(56,57,97,1) 50%, rgba(124,164,220,1) 90%) 1;
        }

        .ssimage{
            padding-top: 3.5px;
            padding-bottom: 3.5px;
            max-width: 100%;
        }


        .nav-sidebar-r{
            position: -webkit-sticky;
            position: sticky;
            top:94%;
            left:0;
            width: 20%;
            height:100%;
        }

        #home-button{
            width:15%;
            font-size: 20px;
            mix-blend-mode: multiply;
        }

        .navbar {
            position: -webkit-sticky;
            position: sticky; 
            top: 0;
        }

        .navigator {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #7ca4dc;
        }

        .navigate {
            float: left;
        }

        .navigate a,
        .mDrop {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        .mDrop li:nth-of-type(-n + 1) {
            float: down;
        }
        .mDrop {
            position: relative;
            top: 13.6rem;
        }

        li .mDrop {
            visibility: hidden;
            opacity: 0;
            width: 8rem;
            position: absolute;
            top: 40px;
            transition: all 0.5s ease;
            margin-top: 1.5rem;
            display: none;
        }

        .navigate a:hover,
        .mDrop:hover .li:hover {
            background-color: #383961;
        }

        .navigate:hover > ul,
        .navigate:focus-within > ul,
        .navigate .navigator:hover {
            visibility: visible;
            opacity: 1;
            display: block;
        }

        .navigator .navigate .navigator .navigate {
            clear: both;
            width: 100%;
        }

        @media screen and (max-width: 400px){
            .cont1, .cont2 {
                width:100%;
                flex-wrap: wrap;
                border-bottom: 100%
            }
        }

        @media screen and (max-width: 600px){
            .cont1, .cont2 {
                width:100%;
                flex-wrap: wrap;
                border-bottom: 100%
            }
        }

        @media screen and (max-width: 800px){
            .cont1, .cont2 {
                width:100%;
                flex-wrap: wrap;
                border-bottom: 100%
            }
        }

    </style>
    <script>
        document.getElementById("admin-button").onClick = functon(){appear()};

        function appear(){
            document.getElementById("dropdown").classList.toggle("show");
        }
    </script>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <div class='top-cont'>
            <title id="#top">Imara.TV User Manual</title>
            <div class="nav-topbar">
                
            </div>
            <div class="top-label" id="top">
                <img src="{{asset('/images/imara-tv-logo-neg.png')}}" alt="" style="width:20%; margin-left:auto; margin-right:auto;">
            </div>
        </div>
        <div id="spacer">
        </div>
    </head>

    <body>
        <div class="container">
            <div class="nav-sidebarl">
                <nav class="navbar">
                    <ul class="navigator">
                        <li class="navigate"><a href="#admin"><img src="{{asset('/images/Admin-User-Manual/admin-icon.png')}}" alt="" class="icon"></a>
                            <ul class="mDrop">
                                <li><a href="#a-dashboard" class="navlist">Dashboard</a></li>
                                <li><a href="#films" class="navlist">Films</a></li>
                                <li><a href="#topics" class="navlist">Topics</a></li>
                                <li><a href="#locations" class="navlist">Locations</a></li>
                                <li><a href="#proposals" class="navlist">Proposals</a></li>
                                <li><a href="#projects" class="navlist">Projects</a></li>
                                <li><a href="#creators" class="navlist">Creators</a></li>
                                <li><a href="#schedules" class="navlist">Schedules</a></li>
                                <li><a href="#sponsors" class="navlist">Sponsors</a></li>
                                <li><a href="#users" class="navlist">Users</a></li>
                                <li><a href="#roles" class="navlist">Role</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <nav class="navbar">
                    <ul class="navigator">
                        <li class="navigate"><a href="#creator"><img src="{{asset('/images/Admin-User-Manual/content-creator-icon.png')}}" alt="" class="icon" ></a>
                            <ul class="mDrop">
                                <li><a href="#c-projects" class="navlist">Film Projects</a></li>
                                <li><a href="#c-schedules" class="navlist">Film Schedules</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <nav class="navbar">
                        <ul class="navigator">
                            <li class="navigate"><a href="#sponsor"><img src="{{asset('/images/Admin-User-Manual/sponsor-icon.png')}}" alt="" class="icon"></a>
                                <ul class="mDrop">
                                    <li><a href="#s-dashboard" class="navlist">Dashboard</a></li>
                                    <li><a href="#s-project" class="navlist">Film Projects</a></li>
                                    <li><a href="#s-creatorprofiles" class="navlist">Creator Profiles</a></li>
                                </ul>
                            </li>
                        </ul>
                    </ul>
                </nav>
            </div>

            <div class="manual-content">
        
                <div>
                    <div  class="cont1">
                        
                        <div>
                            <h2 id=admin>Admin User Manual</h2>
                            <h3>Sign Up</h3>
                            <p>To access the Imara TV  dashboard, you'll need  to create and account.
                                Follow these steps.
                            </p>
                            <ol>
                                <li>Navigate to Imara TV Sing Up page.</li>
                                <li>Input your details into the provided fields.</li>
                                <li>Click the "Sign Up" button.</li>
                                <li>Your account will be created, granting you access to the Imara TV dashboard.</li>
                            </ol>
                        </div>
                        <div>
                            <img src="{{asset('/images/Admin-User-Manual/slide2.png')}}" alt="">
                        </div>
                    </div>
                    <div  class="cont1">
                        <div>
                            <h3>Login</h3>
                            <p>To log in, follow these steps:</p>
                            <ol>
                                <li>Enter the email address associated with your account.</li>
                                <li>Input your password in the designated field.</li>
                                <li>Click the "Sign in" button to access your account.</li>
                            </ol>
                        </div>
                        <div>
                            <img src="{{asset('/images/Admin-User-Manual/slide3.png')}}" alt="">
                        </div>
                    </div>
                    <div  class="cont1">
                        <div id="a-dashboard">
                            <h3>Admin Dashboard Features</h3>
                            <p>On the dashboard, you'll find the following features for easy navigation:</p>
                            <ol>
                                <li>Dashboard: Provides an overview of your account and activities.</li>
                                <li>Film Genre: Organizes films based on their genre.</li>
                                <li>Film Topic: Categorizes films by their themes or subjects.</li>
                                <li>Locations: Displays information about various filming locations.</li>
                                <li>Proposal Status: Tracks the status of film proposals.</li>
                                <li>Film Projects: Lists ongoing and completed film projects.</li>
                                <li>Creator Profiles: Profiles of filmmakers and content creators.</li>
                            </ol>
                        </div>
                        <div>
                            <img src="{{asset('/images/Admin-User-Manual/slide4.png')}}" alt="">
                        </div>
                    </div>
                    <div  class="cont1">
                        <div>
                            <h3>Admin Dashboard Features</h3>
                            <ol>
                                <li>DFilm Schedules: Shows the schedule for film screenings or releases.</li>
                                <li>Sponsor Profiles: Profiles of sponsors and partners.</li>
                                <li>Users and Roles: Manages user accounts and their roles on the platform.</li>
                            </ol>
                            <p>These features are designed to help you easily navigate and utilize the platform's resources.</p>
                        </div>
                        <div>
                            <img src="{{asset('/images/Admin-User-Manual/slide5.png')}}" alt="">
                        </div>
                    </div>
                    <div  class="cont1">
                        <div>
                            <h3>Dashboard</h3>
                            <p>On the dashboard feature, you gain a comprehensive view of the platform, encompassing
                                sponsors, creators, various films, and their schedules.</p>
                        </div>
                        <div>
                            <img src="{{asset('/images/Admin-User-Manual/slide6.png')}}" alt="" class="ssimage">
                        </div>
                    </div>
                    <div  class="cont1">
                        <div id="films">
                            <h3>Film Genre</h3>
                            <p>Within the Film Genre feature, you can explore all the different types of film genres
                                available on the platform. Additionally, you have the ability to add new genres, delete
                                existing ones, and edit their details as needed.</p>
                        </div>
                        <div>
                            <img src="{{asset('/images/Admin-User-Manual/slide7.png')}}" alt="" class="ssimage">
                        </div>
                    </div>
                    <div  class="cont2">
                        <div>
                            <h3>How to Add Film Genre</h3>
                            <img src="{{asset('/images/Admin-User-Manual/slide8.png')}}" alt="" class="ssimage">
                            <p>
                                To add a new film genre, click on the "New" button as indicated above. A pop-up window will
                                appear, as illustrated below, where you can enter the genre name. Once you've entered the
                                genre name, click the "Create" button to finalize the addition.
                            </p>
                            <img src="{{asset('/images/Admin-User-Manual/slide8-2.png')}}" alt="" class="ssimage">
                        </div>
                    </div>
                    <div  class="cont2">
                        <div>
                            <h3>How to Edit Film Genre</h3>
                            <img src="{{asset('/images/Admin-User-Manual/slide9.png')}}" alt="" class="ssimage">
                            <p>
                                To edit a film genre, simply click on the edit icon as shown above. Once clicked, a pop-up
                                window will appear, as illustrated in the image below. In this window, input the new name
                                for the film genre. After entering the new name, click on "Save Changes" to update and save the changes.
                            </p>
                            <img src="{{asset('/images/Admin-User-Manual/slide9-2.png')}}" alt="" class="ssimage">
                        </div>
                    </div>
                    <div  class="cont2">
                        <div>
                            <h3>How to Delete a Film Genre</h3>
                            <ol>
                                <p>To delete a Film Genre, you have two options:</p>
                                <li>
                                    Navigate to the Film feature and locate the delete button, highlighted in red.
                                    Click on it, and a pop-up will appear, asking you to confirm the deletion.
                                    Click "Confirm" to proceed with the deletion.
                                </li>
                                <img src="{{asset('/images/Admin-User-Manual/slide10.png')}}" alt="" class="ssimage">
                                <li>
                                    Alternatively, you can click on the Film Genre itself. Select the number of
                                    films you want to delete, then click on "Bulk Actions."
                                    From the dropdown menu, choose "Delete Selected" to remove them.
                                </li>
                                <img src="{{asset('/images/Admin-User-Manual/slide10-2.png')}}" alt="" class="ssimage">
                            </ol>
                        </div>
                    </div>
                    <div  class="cont2">
                        <div id="topics">
                            <h3>How to Add Film Topic</h3>
                            <img src="{{asset('/images/Admin-User-Manual/slide11.png')}}" alt="" class="ssimage">
                            <p>
                                To add a new film topic, click on the "New" button as indicated above. A pop-up window will appear,
                                as illustrated below, where you can enter the genre name. Once you've entered the Topic name,
                                click the "Create" button to finalize the addition.
                            </p>
                            <img src="{{asset('/images/Admin-User-Manual/slide11-2.png')}}" alt="" class="ssimage">
                        </div>
                    </div>
                    <div  class="cont2">
                        <div>
                            <h3>How to Edit Film Topic</h3>
                            <img src="{{asset('/images/Admin-User-Manual/slide12.png')}}" alt="" class="ssimage">
                            <p>
                                To edit a film topic, simply click on the edit icon as shown above. Once clicked,
                                a pop-up window will appear, as illustrated in the image below. In this window,
                                input the new name for the film topic. After entering the new name, click on
                                "Save Changes" to update and save the changes.
                            </p>
                            <img src="{{asset('/images/Admin-User-Manual/slide12-2.png')}}" alt="" class="ssimage">
                        </div>
                    </div>
                </div>
                <div  class="cont2">
                    <div>
                        <h3>How to Delete a Film Topic</h3>
                        <ol>
                            <p>To delete a Film Topic, you have two options:</p>
                            <li>
                                Navigate to the Film Topic feature and locate the delete button, highlighted in red.
                                Click on it, and a pop-up will appear, asking you to confirm the deletion.
                                Click "Confirm" to proceed with the deletion.
                            </li>
                            <img src="{{asset('/images/Admin-User-Manual/slide13.png')}}" alt="" class="ssimage">
                            <li>
                                Alternatively, you can click on the Film Topic  itself. Select the number of films
                                you want to delete, then click on "Bulk Actions." From the dropdown menu, choose
                                "Delete Selected" to remove them.
                            </li>
                            <img src="{{asset('/images/Admin-User-Manual/slide13-2.png')}}" alt="" class="ssimage">
                        </ol>
                    </div>
                </div>
                <div  class="cont1">
                    <div>
                        <h3 id="locations">Locations</h3>
                        <p>The "Locations" feature provides comprehensive information regarding different
                            filming locations available on the platform.</p>
                    </div>
                    <div>
                        <img src="{{asset('/images/Admin-User-Manual/slide14.png')}}" alt="" class="ssimage">
                    </div>
                </div>
                <div  class="cont2">
                    <div>
                        <h3>How to Add Film Location</h3>
                        <img src="{{asset('/images/Admin-User-Manual/slide15.png')}}" alt="" class="ssimage">
                        <p>
                            To add a new location, click on the "New" button as indicated above. A pop-up window
                            will appear, as illustrated below, where you can enter the Location Name.
                            Once you've entered the genre name, click the "Create" button to finalize the addition.
                        </p>
                        <img src="{{asset('/images/Admin-User-Manual/slide15-2.png')}}" alt="" class="ssimage">
                    </div>
                </div>
            
                <div  class="cont2">
                    <div>
                        <h3>How to Edit Location Name</h3>
                        <img src="{{asset('/images/Admin-User-Manual/slide16.png')}}" alt="" class="ssimage">
                        <p>
                            To edit a location name, simply click on the edit icon as shown above. Once clicked,
                            a pop-up window will appear, as illustrated in the image below. In this window,
                            input the new name for the location the film was taken at. After entering the new name,
                            click on "Save Changes" to update and save the changes.
                        </p>
                        <img src="{{asset('/images/Admin-User-Manual/slide16-2.png')}}" alt="" class="ssimage">
                    </div>
                </div>
                <div  class="cont2">
                    <div>
                        <h3>How to Delete a Location</h3>
                        <ol>
                            <p>To delete a Location, you have two options:</p>
                            <li>
                                Navigate to the Location feature and locate the delete button, highlighted in red.
                                Click on it, and a pop-up will appear, asking you to confirm the deletion.
                                Click "Confirm" to proceed with the deletion.
                            </li>
                            <img src="{{asset('/images/Admin-User-Manual/slide17.png')}}" alt="" class="ssimage">
                            <li>
                                Alternatively, you can click on the Location Name itself. Select the number of
                                Locations you want to delete, then click on "Bulk Actions." From the dropdown menu,
                                choose "Delete Selected" to remove them.
                            </li>
                            <img src="{{asset('/images/Admin-User-Manual/slide17-2.png')}}" alt="" class="ssimage">
                        </ol>
                    </div>
                </div>
                <div  class="cont1">
                    <div id="proposals">
                        <h3>Proposal Status</h3>
                        <p>The "Proposal Status" feature enables users to monitor the progress and current status of film proposals
                            submitted on the platform.Additionally, you can use this feature to publish the proposals, making them
                            accessible to the intended audience.</p>
                    </div>
                    <div>
                        <img src="{{asset('/images/Admin-User-Manual/slide18.png')}}" alt="" class="ssimage">
                    </div>
                </div>
                <div  class="cont2">
                    <div>
                        <h3>How to Add Proposal Status</h3>
                        <img src="{{asset('/images/Admin-User-Manual/slide19.png')}}" alt="" class="ssimage">
                        <p>
                            To add a new Proposal Status, click on the "New" button as indicated above.
                            A pop-up window will appear, as illustrated below, where you can enter the
                            Proposal Status. Once you've entered the Proposal Status, click the "Create" button to finalize the addition.
                        </p>
                        <img src="{{asset('/images/Admin-User-Manual/slide19-2.png')}}" alt="" class="ssimage">
                    </div>
                </div>
            
                <div  class="cont2">
                    <div>
                        <h3>How to Edit Proposal Status</h3>
                        <img src="{{asset('/images/Admin-User-Manual/slide20.png')}}" alt="" class="ssimage">
                        <p>
                            To edit Proposal Status, simply click on the edit icon as shown above. Once clicked,
                            a pop-up window will appear, as illustrated in the image below. In this window, input
                            the new name for the proposal status. After entering the new name, click on
                            "Save Changes" to update and save the changes.
                        </p>
                        <img src="{{asset('/images/Admin-User-Manual/slide20-2.png')}}" alt="" class="ssimage">
                    </div>
                </div>
                <div  class="cont2">
                    <div>
                        <h3>How to Delete a Proposal Status</h3>
                        <ol>
                            <p>To delete a Proposal Status, you have two options:</p>
                            <li>
                                Navigate to the Proposal Status feature and locate the delete button, highlighted in red.
                                Click on it, and a pop-up will appear, asking you to confirm the deletion.
                                Click "Confirm" to proceed with the deletion.
                            </li>
                            <img src="{{asset('/images/Admin-User-Manual/slide21.png')}}" alt="" class="ssimage">
                            <li>
                                Alternatively, you can click on the Film Genre itself. Select the number of
                                Locations you want to delete, then click on "Bulk Actions." From the dropdown menu,
                                choose "Delete Selected" to remove them.
                            </li>
                            <img src="{{asset('/images/Admin-User-Manual/slide21-2.png')}}" alt="" class="ssimage">
                        </ol>
                    </div>
                </div>
                <div  class="cont1">
                    <div id="projects">
                        <h3>Film Projects</h3>
                        <p>The "Film Projects" feature displays essential details such as sponsors, project status, titles,
                            genres, and more, providing comprehensive information about each film endeavor.</p>
                    </div>
                    <div>
                        <img src="{{asset('/images/Admin-User-Manual/slide22.png')}}" alt="" class="ssimage">
                    </div>
                </div>
                <div  class="cont1">
                    <div>
                        <h3>How to Search Film Projects</h3>
                        <p>TTo search for specific film projects, utilize the filter feature. You can filter films
                            based on sponsors, genre, status, and dates. Once you've entered the desired details, click on "Reset" to apply the filters.</p>
                    </div>
                    <div>
                        <img src="{{asset('/images/Admin-User-Manual/slide23.png')}}" alt="" class="ssimage">
                    </div>
                </div>
                <div  class="cont2">
                    <div>
                        <h3>How to Update Film Project</h3>
                        <img src="{{asset('/images/Admin-User-Manual/slide24.png')}}" alt="" class="ssimage">
                        <p>
                            To update Film Project, simply click on the edit icon as shown above. Once clicked, a pop-up window will appear, as illustrated
                            in the image below. In this window, input the new name for the Film Project. After entering the new name,
                            click on "Save Changes" to update and save the changes.
                        </p>
                        <img src="{{asset('/images/Admin-User-Manual/slide24-2.png')}}" alt="" class="ssimage">
                    </div>
                </div>
            
                <div  class="cont2">
                    <div>
                        <h3>How to Delete a Film Projects</h3>
                        <ol>
                            <p>To delete Film Projects, you have two options:</p>
                            <li>
                                Navigate to the Film Project feature and locate the delete button, highlighted in red.
                                Click on it, and a pop-up will appear, asking you to confirm the deletion.
                                Click "Confirm" to proceed with the deletion.
                            </li>
                            <img src="{{asset('/images/Admin-User-Manual/slide25.png')}}" alt="" class="ssimage">
                            <li>
                                Alternatively, you can click on the Film Project Name itself. Select the number of
                                Locations you want to delete, then click on "Bulk Actions." From the dropdown menu,
                                choose "Delete Selected" to remove them.
                            </li>
                            <img src="{{asset('/images/Admin-User-Manual/slide25-2.png')}}" alt="" class="ssimage">
                        </ol>
                    </div>
                </div>
                <div  class="cont1">
                    <div id="creators">
                        <h3>Creator Profiles</h3>
                        <p>The "Creator Profiles" feature offers detailed profiles of filmmakers and content creators,
                            providing users with valuable insights into their backgrounds, portfolios, and contributions to the platform.</p>
                    </div>
                    <div>
                        <img src="{{asset('/images/Admin-User-Manual/slide26.png')}}" alt="" class="ssimage">
                    </div>
                </div>
                <div  class="cont2">
                    <div>
                        <h3>How to Add New Creator Profile</h3>
                        <img src="{{asset('/images/Admin-User-Manual/slide27.png')}}" alt="" class="ssimage">
                        <p>
                            To add a new Proposal Creator Profile, click on the "New Creator Profile" button as indicated above.
                            A pop-up window will appear, as illustrated below, where you can enter the new Creator. Once you've
                            entered the New Creator, click the "Create" button to finalize the addition.
                        </p>
                        <img src="{{asset('/images/Admin-User-Manual/slide27-2.png')}}" alt="" class="ssimage">
                    </div>
                </div>
                <div  class="cont2">
                    <div>
                        <h3>How to Edit Creator Profile</h3>
                        <img src="{{asset('/images/Admin-User-Manual/slide28.png')}}" alt="" class="ssimage">
                        <p>
                            To Edit Creator Profile, simply click on the edit icon as shown above. Once clicked, a pop-up window
                            will appear, as illustrated in the image below. In this window, input the new name for the new Creator.
                            After entering the new name, click on "Save Changes" to update and save the changes.
                        </p>
                        <img src="{{asset('/images/Admin-User-Manual/slide28-2.png')}}" alt="" class="ssimage">
                    </div>
                </div>
                <div  class="cont2">
                    <div>
                        <h3>How to View Creator Profile</h3>
                        <img src="{{asset('/images/Admin-User-Manual/slide29.png')}}" alt="" class="ssimage">
                        <p>
                            To view a creator profile click on the view icon then it will take you to the page where you will be able to view the Creators Details.
                        </p>
                        <img src="{{asset('/images/Admin-User-Manual/slide29-2.png')}}" alt="" class="ssimage">
                    </div>
                </div>
                <div  class="cont1">
                    <div id="schedules">
                        <h3>Film Schedules</h3>
                        <p>The "Film Schedules" feature offers detailed profiles of filmmakers and content creators,
                            providing users with valuable insights into their backgrounds, portfolios, and contributions to the platform.</p>
                    </div>
                    <div>
                        <img src="{{asset('/images/Admin-User-Manual/slide30.png')}}" alt="" class="ssimage">
                    </div>
                </div>
                <div  class="cont2">
                    <div>
                        <h3>How to Create New Film Schedule</h3>
                        <img src="{{asset('/images/Admin-User-Manual/slide31.png')}}" alt="" class="ssimage">
                        <p>
                            To add a new Film Schedule, click on the "Film Schedule" button as indicated above.
                            A pop-up window will appear, as illustrated below, where you can enter the new Creator. Once you've
                            entered the New Creator, click the "Create" button to finalize the addition.
                        </p>
                        <img src="{{asset('/images/Admin-User-Manual/slide31-2.png')}}" alt="" class="ssimage">
                    </div>
                </div>
                <div  class="cont2">
                    <div>
                        <h3>How to Edit Film Schedules</h3>
                        <img src="{{asset('/images/Admin-User-Manual/slide32.png')}}" alt="" class="ssimage">
                        <p>
                            To Edit Film Schedule, simply click on the edit icon as shown above. Once clicked, a pop-up window
                            will appear, as illustrated in the image below. In this window, input the new name for the new Creator.
                            After entering the new name, click on "Save Changes" to update and save the changes.
                        </p>
                        <img src="{{asset('/images/Admin-User-Manual/slide32-2.png')}}" alt="" class="ssimage">
                    </div>
                </div>
                <div  class="cont2">
                    <div>
                        <h3>How to View Film Schedules</h3>
                        <img src="{{asset('/images/Admin-User-Manual/slide33.png')}}" alt="" class="ssimage">
                        <p>
                            To view a Film Schedule click on the view icon then it will take you to the page where you will be able to view the Creators Details.
                        </p>
                        <img src="{{asset('/images/Admin-User-Manual/slide33-2.png')}}" alt="" class="ssimage">
                    </div>
                </div>
                <div  class="cont2">
                    <div>
                        <h3>Upload to Vimeo</h3>
                        <img src="{{asset('/images/Admin-User-Manual/slide34.png')}}" alt="" class="ssimage">
                        <p>
                            The Upload to Video allows you to edit or upload the new video that you want incase changes have been made in the
                            the current video Once you click on it a pop up will appear asking you if you want to overwrite the video that had been previously been uploaded.
                        </p>
                        <img src="{{asset('/images/Admin-User-Manual/slide34-2.png')}}" alt="" class="ssimage">
                    </div>
                </div>
                <div  class="cont2">
                    <div id="sponsors">
                        <h3>Sponsor Profiles</h3>
                        <p>
                            The "Sponsor Profiles" feature offers detailed profiles of sponsors and partnering entities associated with the platform.
                            These profiles provide admin users with insights into the background, contributions, and affiliations of each sponsor,
                            fostering transparency and trust within the community.
                        </p>
                        <img src="{{asset('/images/Admin-User-Manual/slide36.png')}}" alt="" class="ssimage">
                    </div>
                </div>
                <div  class="cont2">
                    <div>
                        <h3>How to Add Sponsor Profiles</h3>
                        <img src="{{asset('/images/Admin-User-Manual/slide35.png')}}" alt="" class="ssimage">
                        <p>
                            To add a new Sponsor Profile, click on the "New Sponsor Profile" button as indicated above. A pop-up window will appear, as illustrated
                            below, where you can add the new Sponsor. Once you've entered the Sponsor Details, click the "Create" button to finalize the addition.
                        </p>
                        <img src="{{asset('/images/Admin-User-Manual/slide35-2.png')}}" alt="" class="ssimage">
                    </div>
                </div>
                <div  class="cont2">
                    <div>
                        <h3>How to Edit Sponsor's Profiles</h3>
                        <img src="{{asset('/images/Admin-User-Manual/slide37.png')}}" alt="" class="ssimage">
                        <p>
                            Click on the Edit Icon as depicted above. A page will appear displaying the sponsor profile details, where you can select which part of the
                            profile you wish to modify. Once you've made the desired changes, click "Save Changes" to apply them.
                        </p>
                        <img src="{{asset('/images/Admin-User-Manual/slide37-2.png')}}" alt="" class="ssimage">
                    </div>
                </div>
                <div  class="cont2">
                    <div id="users">
                        <h3>Users</h3>
                        <p>
                            The "Users and Roles" feature facilitates the management of user accounts and their respective roles within the platform.
                            Administrators can assign specific roles to users, such as sponsor, creator,and users, controlling their access levels and
                            permissions. This feature ensures smooth and efficient operation of the platform by regulating user activities and responsibilities.
                        </p>
                        <img src="{{asset('/images/Admin-User-Manual/slide38.png')}}" alt="" class="ssimage">
                    </div>
                </div>
                <div  class="cont2">
                    <div>
                        <h3>How to Add a New User</h3>
                        <img src="{{asset('/images/Admin-User-Manual/slide39.png')}}" alt="" class="ssimage">
                        <p>
                            To add a new user, click on the "New user" button as indicated above. A pop-up window will appear, as illustrated below, where you
                        can enter the user name. Once you've entered the user name, click the "Create" button to finalize the addition.
                        </p>
                        <img src="{{asset('/images/Admin-User-Manual/slide39-2.png')}}" alt="" class="ssimage">
                    </div>
                </div>
                <div  class="cont2">
                    <div>
                        <h3>How to Search Through Users</h3>
                        <p>
                            To search for specific users, utilize the filter feature. You can filter films based on sponsor, creator, admin, and dates.
                            Once you've entered the desired details, click on "Reset" to apply the filters.
                        </p>
                        <img src="{{asset('/images/Admin-User-Manual/slide40.png')}}" alt="" class="ssimage">
                    </div>
                </div>
                <div  class="cont2">
                    <div>
                        <h3>How to Edit User Details</h3>
                        <img src="{{asset('/images/Admin-User-Manual/slide41.png')}}" alt="" class="ssimage">
                        <p>
                            Click on the Edit Icon as depicted above. A page will appear displaying the user profile details, where you can select which part of
                            the profile you wish to modify. Once you've made the desired changes, click "Save Changes" to apply them.
                        </p>
                        <img src="{{asset('/images/Admin-User-Manual/slide41-2.png')}}" alt="" class="ssimage">
                    </div>
                </div>
                <div  class="cont2">
                    <div>
                        <h3>How to Delete User Details</h3>
                        <img src="{{asset('/images/Admin-User-Manual/slide42.png')}}" alt="" class="ssimage">
                        <p>
                            Click on the Edit Icon as depicted above. A page will appear displaying the user profile details.On top of the page there is a delete
                            button click on it.A pop up will appear asking you to confirm if you want to delete it.Once you have confirmed the user will be deleted.
                        </p>
                        <img src="{{asset('/images/Admin-User-Manual/slide42-2.png')}}" alt="" class="ssimage">
                    </div>
                </div>
                <div  class="cont2">
                    <div id="roles">
                        <h3>How to Add a New Role</h3>
                        <img src="{{asset('/images/Admin-User-Manual/slide43.png')}}" alt="" class="ssimage">
                        <p>
                            To add a new role, click on the "New Role" button as depicted above. This action will direct you to a page where you can input the role's
                            name and guard name. Additionally, you have the option to enable all permissions for that role or selectively choose which permissions to allow.
                        </p>
                        <img src="{{asset('/images/Admin-User-Manual/slide43-2.png')}}" alt="" class="ssimage">
                    </div>
                </div>
                <div  class="cont2">
                    <div>
                        <h3>How to Edit a Specific Role Information</h3>
                        <img src="{{asset('/images/Admin-User-Manual/slide44.png')}}" alt="" class="ssimage">
                        <p>
                            To Edit a certain role details click on the Edit icon as shown above.Once clicked it will take you to a page of the role’s details,
                            you can either choose to edit the role’s name or the permissions.Once done click on Save changes.
                        </p>
                        <img src="{{asset('/images/Admin-User-Manual/slide44-2.png')}}" alt="" class="ssimage">
                    </div>
                </div>
                <div  class="cont2">
                    <div>
                        <h3>How to Delete a Certain Role</h3>
                        <ol>
                            <p>To delete a Role, you have two options:</p>
                            <li>
                                Navigate to the Role feature and locate the delete button, highlighted in red.
                                Click on it, and a pop-up will appear, asking you to confirm the deletion.
                                Click "Confirm" to proceed with the deletion.
                            </li>
                            <img src="{{asset('/images/Admin-User-Manual/slide45.png')}}" alt="" class="ssimage">
                            <li>
                                The other option is to Click on the Edit Icon. A page will appear displaying the role
                                profile details.On top of the page there is a delete button click on it.A pop up will
                                appear asking you to confirm if you want to delete it.Once you have confirmed the role will be deleted.
                            </li>
                            <img src="{{asset('/images/Admin-User-Manual/slide45-2.png')}}" alt="" class="ssimage">
                        </ol>
                    </div>
                </div>
                <div id="creator-manual">
                    <br>
                    <br>
                    <br>
                    <h2 id="creator">Imara TV Creator Guide</h2>
                    <div>
                        <div class="cont1">
                            <div>
                                <h3>Sign Up</h3>
                                <p>To access the Imara TV Creator dashboard, you'll need  to create and account.
                                    Follow these steps.
                                </p>
                                <ol>
                                    <li>Go to www.imara.tv and click on “Create On Imara” to sign up.</li>
                                    <li>Input your details into the provided fields.</li>
                                    <li>Click the "Sign Up" button.</li>
                                    <li>Your account will be created, granting you access to the Imara TV Creator dashboard.</li>
                                </ol>
                            </div>
                            <div>
                                <img src="{{asset('/images/Creator-User-Manual/slide2.png')}}" alt="">
                            </div>
                        </div>
                        <div  class="cont1">
                            <div>
                                <h3>Login</h3>
                                <p>To log in, follow these steps:
                                </p>
                                <ol>
                                    <li>Enter the email address associated with your account.</li>
                                    <li>Input your password in the designated field.</li>
                                    <li>Click the "Sign in" button to access your account.</li>
                                </ol>
                            </div>
                            <div>
                                <img src="{{asset('/images/Creator-User-Manual/slide3.png')}}" alt="">
                            </div>
                        </div>
                        <div  class="cont1">
                            <div id="c-projects">
                                <h3>Film Projects</h3>
                                <p>The "Film Projects" feature displays essential details such as sponsors, project status,<br>
                                    titles, genres, and more, providing comprehensive information about each film endeavor.
                                </p>
            
                            </div>
                            <div>
                                <img src="{{asset('/images/Creator-User-Manual/slide4.png')}}" alt="" class="ssimage">
                            </div>
                        </div>
            
                        <div  class="cont2">
                            <div>
                                <h3>How To Update Film Projects</h3>
                                <img src="{{asset('/images/Creator-User-Manual/slide5.png')}}" alt="" class="ssimage">
                                <p>To update Film Project, simply click on the edit icon as shown above. Once clicked, a pop-up <br>
                                    window will appear, as illustrated in the image below. In this window, input the new name for <br>
                                    the Film Project. After entering the new name, click on "Save Changes" to update and save <br>
                                    the changes
                                </p>
            
                            </div>
                            <div>
                                <img src="{{asset('/images/Creator-User-Manual/slide5-2.png')}}" alt="" class="ssimage">
                            </div>
                        </div>
                        <div  class="cont2">
                            <div>
                                <h3>How To Search Film Projects</h3>
                                <p>To search for specific film projects, utilize the filter feature. You can filter films based <br>
                                    on sponsors, genre, status, and dates. Once you've entered the desired details, click on <br>
                                    "Reset" to apply the filters.
                                </p>
                                <img src="{{asset('/images/Creator-User-Manual/slide6.png')}}" alt="" class="ssimage">
                            </div>
                        </div>
                        <div  class="cont2">
                            <div>
                                <h3>How To Delete Film Projects</h3>
                                <p>To delete a film project, you have to options:</p>
                                <ul>
                                    <li>Navigate to the Film Project Feature and locate the delete button, highlighted <br>
                                        in red. Click on it, and a pop-up will appear, asking you to confirm the deletion. <br>
                                        Click "Confirm" to proceed with the deletion.</li>
                                        <img src="{{asset('/images/Creator-User-Manual/slide7.png')}}" alt="" class="ssimage">
                                    <li>Alternatively, you can click on the Film Project Name itself. <br>
                                        Select the number of films you want to delete, then click on "Bulk Actions." <br>
                                        From the dropdown menu, choose "Delete Selected" to remove them</li>
                                        <img src="{{asset('/images/Creator-User-Manual/slide7-2.png')}}" alt="" class="ssimage">
                                </ul>
                            </div>
                        </div>
                        <div  class="cont1">
                            <div id="c-schedules">
                                <h3>Film Schedules</h3>
                                <p>The "Film Schedules" feature presents creators with a comprehensive <br>
                                    schedule detailing upcoming film screenings or release dates. This <br>
                                    allows users to stay informed about when and where they can expect to <br>
                                    view or experience the latest films on the platform.
                            </div>
                            <div>
                                <img src="{{asset('/images/Creator-User-Manual/slide8.png')}}" alt="" class="ssimage">
                            </div>
                        </div>
                        <div  class="cont2">
                            <div>
                                <h3>How to Search Film Schedules</h3>
                                <p>To search for specific film schedules, utilize the filter feature. You can filter films based on  <br>
                                    sponsors, genre, status, and dates. Once you've entered the desired details, click on "Reset" to  <br>
                                    allows users to stay informed about when and where they can expect to <br>
                                    apply the filters.
                            </div>
                            <div>
                                <img src="{{asset('/images/Creator-User-Manual/slide9.png')}}" alt="" class="ssimage">
                            </div>
                        </div>
                        <div  class="cont2">
                            <h3>How to View Film Schedules</h3>
                            <img src="{{asset('/images/Creator-User-Manual/slide10.png')}}" alt="" class="ssimage">
                            <p>To view Film Schedules click on View as shown above.Once you click on it a pop up will appear <br>
                                with the film title,type,synopsis,creator,release date and sponsor</p>
                            <img src="{{asset('/images/Creator-User-Manual/slide10-2.png')}}" alt="" class="ssimage">
                        </div>
                    </div>
                </div>
                <div id="sponsor-manual">
                    <h2 id="sponsor">Imara TV Sponsor User Manual</h2>
                    <div>
                        <div  class="cont1">
                            <div>
                                <h3>Sign Up</h3>
                                <p>To access the Imara TV Sponsor dashboard, you'll need  to create and account.
                                    Follow these steps.
                                </p>
                                <ol>
                                    <li>Navigate to Imara TV Sing Up page.</li>
                                    <li>Input your details into the provided fields.</li>
                                    <li>Click the "Sign Up" button.</li>
                                    <li>Your account will be created, granting you access to the Imara TV Sponsor dashboard.</li>
                                </ol>
                            </div>
                            <div>
                                <img src="{{asset('/images/Sponsor-User-Manual/slide2.png')}}" alt="">
                            </div>
                        </div>
                        <div  class="cont1">
                            <div>
                                <h3>Login</h3>
                                <p>To log in, follow these steps:</p>
                                <ol>
                                    <li>Enter the email address associated with your account.</li>
                                    <li>Input your password in the designated field.</li>
                                    <li>Click the "Sign in" button to access your account.</li>
                                </ol>
                            </div>
                            <div>
                                <img src="{{asset('/images/Sponsor-User-Manual/slide3.png')}}" alt="">
                            </div>
                        </div>
                        <div  class="cont1">
                            <div id="s-dashboard">
                                <h3>Sponsor Dashboard Features</h3>
                                <p>On the dashboard, you'll find the following features <br>
                                    for easy navigation:</p>
                                <ol>
                                    <li>Dashboard: Provides an overview of your account and activities ie Total creators,Projects,and Schedules.</li>
                                    <li>Film Projects: Lists ongoing and completed film projects.You can also update and delete projects.</li>
                                    <li>Creator Profile: Profiles of filmmakers and content creators.</li>
                                </ol>
                            </div>
                            <div>
                                <img src="{{asset('/images/Sponsor-User-Manual/slide4.png')}}" alt="" class="ssimage">
                            </div>
                        </div>
                        <div  class="cont1">
                            <div>
                                <h3>Dashboard</h3>
                                <p>
                                    The Dashboard serves as a centralized hub, offering sponsors an overview of their account and <br>
                                    related activities. It provides key metrics such as the total number of creators, projects, <br>
                                    and schedules associated with the particular sponsor. This concise summary allows sponsors <br>
                                    to quickly assess their engagement and progress within the platform
                                </p>
                            </div>
                            <div>
                                <img src="{{asset('/images/Sponsor-User-Manual/slide5.png')}}" alt="" class="ssimage">
                            </div>
                        </div>
                        <div  class="cont1">
                            <div id="s-project">
                                <h3>Film Project</h3>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                                    labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                                    nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit
                                    esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt
                                    in culpa qui officia deserunt mollit anim id est laborum.
                                </p>
                            </div>
                            <div>
                                <img src="{{asset('/images/Sponsor-User-Manual/slide6.png')}}" alt="" class="ssimage">
                            </div>
                        </div>
                        <div  class="cont2">
                            <div>
                                <h3>How to Add a New Film Project</h3>
                                <img src="{{asset('/images/Sponsor-User-Manual/slide7.png')}}" alt="" class="ssimage">
                                <p>
                                    To add a New Film Project , click on the "Create New Proposal" button as depicted above.
                                    This action will direct you to a page where you can input the Project details from title,
                                    synopsis,budget ,Film length and so on.Once you are done with that click on the create button
                                </p>
                                <img src="{{asset('/images/Sponsor-User-Manual/slide7-2.png')}}" alt="" class="ssimage">
                            </div>
                        </div>
            
                        <div  class="cont2">
                            <div>
                                <h3>How to Search For a Particular Film Project</h3>
                                <p>
                                    To search for specific film project , utilize the filter feature. You can filter films based on
                                    sponsor, creator, admin, and dates. Once you've entered the desired details, click on "Reset"
                                    to apply the filters
                                </p>
                                <img src="{{asset('/images/Sponsor-User-Manual/slide8.png')}}" alt="" class="ssimage">
                            </div>
                        </div>
                        <div  class="cont2">
                            <div>
                                <h3>How to Delete Film Project</h3>
                                <p>
                                    To delete A Certain Project Film, you have two options:
                                </p>
                                <ul>
                                    <li>
                                        Navigate to the project film that you want to delete and locate the delete button, highlighted in
                                        red. Click on it, and a pop-up will appear, asking you to confirm the deletion. Click "Confirm"
                                        to proceed with the deletion.
                                    </li>
                                    <img src="{{asset('/images/Sponsor-User-Manual/slide10.png')}}" alt="" class="ssimage">
                                    <li>
                                        The other option is to Click on the Edit Icon. A page will appear displaying the project film details.
                                        On top of the page there is a delete button click on it.A pop up will appear asking you to confirm if
                                        you want to delete it.Once you have confirmed the role will be deleted
                                    </li>
                                    <img src="{{asset('/images/Sponsor-User-Manual/slide10-2.png')}}" alt="" class="ssimage">
                                </ul>
                            </div>
                        </div>
                        <div  class="cont2">
                            <div>
                                <h3>How to Edit A Film Project</h3>
                                <img src="{{asset('/images/Sponsor-User-Manual/slide9.png')}}" alt="" class="ssimage">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                                    labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                                    nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit
                                    esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt
                                    in culpa qui officia deserunt mollit anim id est laborum.
                                </p>
                                <img src="{{asset('/images/Sponsor-User-Manual/slide9-2.png')}}" alt="" class="ssimage">
                            </div>
                        </div>
            
                        <div  class="cont1">
                            <div id="s-creatorprofiles">
                                <h3>Creator Profile</h3>
                                <p>
                                    The "Creator Profile" feature offers detailed profiles of filmmakers and content creators active on the
                                    platform. These profiles provide comprehensive information about the background, portfolio, and contributions
                                    of each creator, allowing users to explore their work and connect with them more effectively.
                                </p>
                            </div>
                            <div>
                                <img src="{{asset('/images/Sponsor-User-Manual/slide11.png')}}" alt="" class="ssimage">
                            </div>
                        </div>
                        <div  class="cont2">
                            <div>
                                <h3>How to View a Creator's Profile</h3>
                                <img src="{{asset('/images/Sponsor-User-Manual/slide12-2.png')}}" alt="" class="ssimage">
                                <p>
                                    To view a creator profile click on the view icon then it will take you to the page where
                                    you will be able to view the Creators Details
                                </p>
                                <img src="{{asset('/images/Sponsor-User-Manual/slide12.png')}}" alt="" class="ssimage">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nav-sidebar-r">
                <a href="#top">
                    <img src="{{asset('/images/Admin-User-Manual/top-icon.png')}}" alt="" id="home-button">
                    
                </a>
            </div>
        </div>
    </body>
</html>