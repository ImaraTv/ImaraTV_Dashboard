<style>
    html,
    body {
        margin: 0;
        padding: 0;
        border: 0;
        outline: 0;
        font-size: 100%;
        vertical-align: baseline;
        background: #F9FAFB;
    }

    body {
        min-height: 100vh;
    }

    .a,
    h2 {
        font-family: 'Trebuchet MS', 'sans-serif';
    }


    .manual-container {
        width: 100%;
        display: flex;
    }

    .nav-sidebarl {
        font-family: 'Trebuchet MS', 'sans-serif';
        position: -webkit-sticky;
        position: sticky;
        top: 70px;
        width: 24%;
        height: 100vh;
        margin-right: 1%;

        display: flex;
        background-color: #F9FAFB;
    }

    .nav-list {
        font-family: 'Trebuchet MS', 'sans-serif';
        list-style-type: none;
        line-height: 300%;
        width: 100%;
        list-style-position: inside;
    }


    .nav-li:hover {
        width: 150%;
        background-color: #F3F4F6;
    }

    .nav-container {
        text-align: center;
    }

    .icon {
        width: 40%;
        margin-left: auto;
        margin-right: auto;
        mix-blend-mode: multiply;
    }

    .manual-content {
        width: 50%;
    }

    .cont1 {
        font-family: 'Trebuchet MS', 'sans-serif';
        display: flex;
        width: 100%;
        flex-direction: row;
        justify-content: space-between;
        border: 1px solid #D0D0D0;
        border-radius: 10px;
        flex-wrap: wrap;
        padding: 20px;
        margin-bottom: 15px;
        background: #FFFFFF;
        box-shadow: 0px 2px 5px 4px rgba(0, 0, 0, 0.23);
        -webkit-box-shadow: 0px 2px 5px 4px rgba(0, 0, 0, 0.23);
        -moz-box-shadow: 0px 2px 5px 4px rgba(0, 0, 0, 0.23);
    }

    .cont2 {
        font-family: 'Trebuchet MS', 'sans-serif';
        width: 100%;
        border-radius: 10px;
        border-bottom: 1px solid #D0D0D0;
        padding: 20px;
        margin-bottom: 15px;
        background: #FFFFFF;
        box-shadow: 0px 2px 5px 4px rgba(0, 0, 0, 0.23);
        -webkit-box-shadow: 0px 2px 5px 4px rgba(0, 0, 0, 0.23);
        -moz-box-shadow: 0px 2px 5px 4px rgba(0, 0, 0, 0.23);
    }

    .ssimage {
        padding: 3.5px;
        max-width: 100%;
        max-height: 90%;
    }


    @media screen and (max-width: 400px) {
        .nav-list {
            font-size: 12px;
        }

        .manual-content {
            width: 90%;
        }

        .cont1,
        .cont2 {
            width: 90%;
            flex-wrap: wrap;
            border-bottom: 100%
        }
    }

    @media screen and (max-width: 600px) {
        .nav-list {
            min-height: 100vh;
        }

        .manual-content {
            width: 90%;
        }

        .cont1,
        .cont2 {
            width: 90%;
            flex-wrap: wrap;
            border-bottom: 100%
        }
    }

    @media screen and (max-width: 800px) {
        .manual-content {
            width: 90%;
        }

        .cont1,
        .cont2 {
            width: 90%;
            flex-wrap: wrap;
            border-bottom: 100%
        }
    }
</style>

<div class="manual-container">
    <div class="nav-sidebarl">
        <nav class="border-gray-1000 dark:border-gray-6000 dark:bg-gray-9000 text-opacity-50 w-75px">
            <ul class="nav-list">
                <li><a href="#admin">
                        <div class="flex align-middle"><svg class="h-8 w-8 text-gray-500" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                <line x1="19" y1="7" x2="19" y2="10" />
                                <line x1="19" y1="14" x2="19" y2="14.01" />
                            </svg> Administrators</div>
                    </a>
                    <ul class="nav-list">
                        <li class="nav-li"><a href="#a-dashboard" class="navlist">
                                <div class="flex"><svg class="h-8 w-8 text-gray-500" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg> Dashboard</div>
                            </a></li>
                        <li class="nav-li"><a href="#films" class="navlist">
                                <div class="flex"><svg class="h-8 w-8 text-gray-500" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z" />
                                        <circle cx="12" cy="13" r="4" />
                                    </svg>
                                    Films Projects
                                </div>
                            </a></li>
                        <li class="nav-li"><a href="#schedules" class="navlist">
                                <div class="flex">
                                    <svg class="h-8 w-8 text-gray-500" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                        <line x1="16" y1="2" x2="16" y2="6" />
                                        <line x1="8" y1="2" x2="8" y2="6" />
                                        <line x1="3" y1="10" x2="21" y2="10" />
                                    </svg> Film Schedules
                                </div>
                            </a></li>
                        <li class="nav-li"><a href="#users" class="navlist">
                                <div class="flex"><svg class="h-8 w-8 text-gray-500" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg> Users</div>
                            </a>
                        </li>
                        <li class="nav-li"><a href="#sponsors" class="navlist"></i>
                                <div class="flex"><svg class="h-8 w-8 text-gray-500" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" />
                                        <line x1="3" y1="21" x2="21" y2="21" />
                                        <line x1="3" y1="10" x2="21" y2="10" />
                                        <polyline points="5 6 12 3 19 6" />
                                        <line x1="4" y1="10" x2="4" y2="21" />
                                        <line x1="20" y1="10" x2="20" y2="21" />
                                        <line x1="8" y1="14" x2="8" y2="17" />
                                        <line x1="12" y1="14" x2="12" y2="17" />
                                        <line x1="16" y1="14" x2="16" y2="17" />
                                    </svg> Sponsor Profiles</div>
                            </a></li>
                        <li class="nav-li"><a href="#creators" class="navlist"></i>
                                <div class="flex"><svg class="h-8 w-8 text-gray-500" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" />
                                        <circle cx="12" cy="13" r="3" />
                                        <path
                                            d="M5 7h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h2m9 7v7a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" />
                                        <line x1="15" y1="6" x2="21" y2="6" />
                                        <line x1="18" y1="3" x2="18" y2="9" />
                                    </svg> Creator Profiles</div>
                            </a></li>
                    </ul>
                </li>
                <li>
                    <div class="flex"><svg class="h-8 w-8 text-gray-500" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3" />
                            <path
                                d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z" />
                        </svg> Settings</div>
                    <ul class="nav-list">
                        <li class="nav-li"><a href="#film-genre">
                                <div class="flex"> Film Genre</div>
                            </a></li>
                        <li class="nav-li"><a href="#film-topic">
                                <div class="flex"> Film Topic</div>
                            </a></li>
                        <li class="nav-li"><a href="#locations">
                                <div class="flex"> Locations</div>
                            </a></li>
                        <li class="nav-li"><a href="#proposal-status">
                                <div class="flex"> Proposal Status</div>
                            </a></li>
                    </ul>
                </li>
                <li class="nav-li"><a href="#roles" class="navlist"></i>
                        <div class="flex"><svg class="h-8 w-8 text-gray-500" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                            </svg> Role</div>
                    </a></li>
                <li><a href="#creator-manual"></i>
                        <div class="flex"><svg class="h-8 w-8 text-gray-500" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <polygon points="10 8 16 12 10 16 10 8" />
                            </svg> Creators</div>
                    </a>
                </li>
                <li><a href="#sponsor-manual"><i class="bi bi-bank2"></i>
                        <div class="flex"><svg class="h-8 w-8 text-gray-500" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" />
                                <path d="M6 5h12l3 5l-8.5 9.5a.7 .7 0 0 1 -1 0l-8.5 -9.5l3 -5" />
                                <path d="M10 12l-2 -2.2l.6 -1" />
                            </svg> Sponsors</div>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="manual-content">
        <h2 id="admin" class="text-2xl font-bold">Admin User Manual</h2>
        <div>
            <div class="cont1">
                <article class="prose">
                    <h3 class="text-xl font-bold">Sign Up</h3>
                    <p>To access the Imara TV dashboard, you'll need to create and account.
                        Follow these steps.
                    </p>
                    <ol class="list-disc list-inside">
                        <li>Navigate to Imara TV Sing Up page.</li>
                        <li>Input your details into the provided fields.</li>
                        <li>Click the "Sign Up" button.</li>
                        <li>Your account will be created, granting you access to the Imara TV dashboard.</li>
                    </ol>
                </article>
                <div>
                    <img src="{{ asset('/images/Admin-User-Manual/slide2.png') }}" alt="">
                </div>
            </div>
            <div class="cont1">
                <div class="prose" class="prose">
                    <h3 class="text-xl font-bold">Login</h3>
                    <p>To log in, follow these steps:</p>
                    <ol class="list-disc list-inside">
                        <li>Enter the email address associated with your account.</li>
                        <li>Input your password in the designated field.</li>
                        <li>Click the "Sign in" button to access your account.</li>
                    </ol>
                </div>
                <div>
                    <img src="{{ asset('/images/Admin-User-Manual/slide3.png') }}" alt="">
                </div>
            </div>
            <div class="cont1">
                <div class="prose" id="a-dashboard">
                    <h3 class="text-xl font-bold">Admin Dashboard Features</h3>
                    <p>On the dashboard, you'll find the following features for easy navigation:</p>
                    <ol class="list-disc list-inside">
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
                    <img src="{{ asset('/images/Admin-User-Manual/slide4.png') }}" alt="">
                </div>
            </div>
            <div class="cont1">
                <div class="prose">
                    <h3 class="text-xl font-bold">Admin Dashboard Features</h3>
                    <ol class="list-disc list-inside">
                        <li>Film Schedules: Shows the schedule for film screenings or releases.</li>
                        <li>Sponsor Profiles: Profiles of sponsors and partners.</li>
                        <li>Users and Roles: Manages user accounts and their roles on the platform.</li>
                    </ol>
                    <p>These features are designed to help you easily navigate and utilize the platform's resources.</p>
                </div>
                <div>
                    <img src="{{ asset('/images/Admin-User-Manual/slide5.png') }}" alt="">
                </div>
            </div>
            <div class="cont1">
                <div class="prose">
                    <h3 class="text-xl font-bold">Dashboard</h3>
                    <p>On the dashboard feature, you gain a comprehensive view of the platform, encompassing
                        sponsors, creators, various films, and their schedules.</p>
                </div>
                <div>
                    <img src="{{ asset('/images/Admin-User-Manual/slide6.png') }}" alt="" class="ssimage">
                </div>
            </div>
            <div class="cont1">
                <div class="prose" id="film-genre">
                    <h3 class="text-xl font-bold">Film Genre</h3>
                    <p>Within the Film Genre feature, you can explore all the different types of film genres
                        available on the platform. Additionally, you have the ability to add new genres, delete
                        existing ones, and edit their details as needed.</p>
                </div>
                <div>
                    <img src="{{ asset('/images/Admin-User-Manual/slide7.png') }}" alt="" class="ssimage">
                </div>
            </div>
            <div class="cont2">
                <div class="prose">
                    <h3 class="text-xl font-bold">How to Add Film Genre</h3>
                    <img src="{{ asset('/images/Admin-User-Manual/slide8.png') }}" alt="" class="ssimage">
                    <p>
                        To add a new film genre, click on the "New" button as indicated above. A pop-up window will
                        appear, as illustrated below, where you can enter the genre name. Once you've entered the
                        genre name, click the "Create" button to finalize the addition.
                    </p>
                    <img src="{{ asset('/images/Admin-User-Manual/slide8-2.png') }}" alt="" class="ssimage">
                </div>
            </div>
            <div class="cont2">
                <div class="prose">
                    <h3 class="text-xl font-bold">How to Edit Film Genre</h3>
                    <img src="{{ asset('/images/Admin-User-Manual/slide9.png') }}" alt="" class="ssimage">
                    <p>
                        To edit a film genre, simply click on the edit icon as shown above. Once clicked, a pop-up
                        window will appear, as illustrated in the image below. In this window, input the new name
                        for the film genre. After entering the new name, click on "Save Changes" to update and save the
                        changes.
                    </p>
                    <img src="{{ asset('/images/Admin-User-Manual/slide9-2.png') }}" alt="" class="ssimage">
                </div>
            </div>
            <div class="cont2">
                <div class="prose">
                    <h3 class="text-xl font-bold">How to Delete a Film Genre</h3>
                    <ol class="list-disc list-inside">
                        <p>To delete a Film Genre, you have two options:</p>
                        <li>
                            Navigate to the Film feature and locate the delete button, highlighted in red.
                            Click on it, and a pop-up will appear, asking you to confirm the deletion.
                            Click "Confirm" to proceed with the deletion.
                        </li>
                        <img src="{{ asset('/images/Admin-User-Manual/slide10.png') }}" alt=""
                            class="ssimage">
                        <li>
                            Alternatively, you can click on the Film Genre itself. Select the number of
                            films you want to delete, then click on "Bulk Actions."
                            From the dropdown menu, choose "Delete Selected" to remove them.
                        </li>
                        <img src="{{ asset('/images/Admin-User-Manual/slide10-2.png') }}" alt=""
                            class="ssimage">
                    </ol>
                </div>
            </div>
            <div class="cont2">
                <div class="prose" id="film-topic">
                    <h3 class="text-xl font-bold">How to Add Film Topic</h3>
                    <img src="{{ asset('/images/Admin-User-Manual/slide11.png') }}" alt="" class="ssimage">
                    <p>
                        To add a new film topic, click on the "New" button as indicated above. A pop-up window will
                        appear,
                        as illustrated below, where you can enter the genre name. Once you've entered the Topic name,
                        click the "Create" button to finalize the addition.
                    </p>
                    <img src="{{ asset('/images/Admin-User-Manual/slide11-2.png') }}" alt=""
                        class="ssimage">
                </div>
            </div>
            <div class="cont2">
                <div class="prose">
                    <h3 class="text-xl font-bold">How to Edit Film Topic</h3>
                    <img src="{{ asset('/images/Admin-User-Manual/slide12.png') }}" alt="" class="ssimage">
                    <p>
                        To edit a film topic, simply click on the edit icon as shown above. Once clicked,
                        a pop-up window will appear, as illustrated in the image below. In this window,
                        input the new name for the film topic. After entering the new name, click on
                        "Save Changes" to update and save the changes.
                    </p>
                    <img src="{{ asset('/images/Admin-User-Manual/slide12-2.png') }}" alt=""
                        class="ssimage">
                </div>
            </div>
            <div class="cont2">
                <div class="prose">
                    <h3 class="text-xl font-bold">How to Delete a Film Topic</h3>
                    <ol class="list-disc list-inside">
                        <p>To delete a Film Topic, you have two options:</p>
                        <li>
                            Navigate to the Film Topic feature and locate the delete button, highlighted in red.
                            Click on it, and a pop-up will appear, asking you to confirm the deletion.
                            Click "Confirm" to proceed with the deletion.
                        </li>
                        <img src="{{ asset('/images/Admin-User-Manual/slide13.png') }}" alt=""
                            class="ssimage">
                        <li>
                            Alternatively, you can click on the Film Topic itself. Select the number of films
                            you want to delete, then click on "Bulk Actions." From the dropdown menu, choose
                            "Delete Selected" to remove them.
                        </li>
                        <img src="{{ asset('/images/Admin-User-Manual/slide13-2.png') }}" alt=""
                            class="ssimage">
                    </ol>
                </div>
            </div>
            <div class="cont1">
                <div class="prose">
                    <h3 id="locations" class="text-xl font-bold">Locations</h3>
                    <p>The "Locations" feature provides comprehensive information regarding different
                        filming locations available on the platform.</p>
                </div>
                <div>
                    <img src="{{ asset('/images/Admin-User-Manual/slide14.png') }}" alt="" class="ssimage">
                </div>
            </div>
            <div class="cont2">
                <div class="prose">
                    <h3 class="text-xl font-bold">How to Add Film Location</h3>
                    <img src="{{ asset('/images/Admin-User-Manual/slide15.png') }}" alt="" class="ssimage">
                    <p>
                        To add a new location, click on the "New" button as indicated above. A pop-up window
                        will appear, as illustrated below, where you can enter the Location Name.
                        Once you've entered the genre name, click the "Create" button to finalize the addition.
                    </p>
                    <img src="{{ asset('/images/Admin-User-Manual/slide15-2.png') }}" alt=""
                        class="ssimage">
                </div>
            </div>

            <div class="cont2">
                <div class="prose">
                    <h3 class="text-xl font-bold">How to Edit Location Name</h3>
                    <img src="{{ asset('/images/Admin-User-Manual/slide16.png') }}" alt="" class="ssimage">
                    <p>
                        To edit a location name, simply click on the edit icon as shown above. Once clicked,
                        a pop-up window will appear, as illustrated in the image below. In this window,
                        input the new name for the location the film was taken at. After entering the new name,
                        click on "Save Changes" to update and save the changes.
                    </p>
                    <img src="{{ asset('/images/Admin-User-Manual/slide16-2.png') }}" alt=""
                        class="ssimage">
                </div>
            </div>
            <div class="cont2">
                <div class="prose">
                    <h3 class="text-xl font-bold">How to Delete a Location</h3>
                    <ol class="list-disc list-inside">
                        <p>To delete a Location, you have two options:</p>
                        <li>
                            Navigate to the Location feature and locate the delete button, highlighted in red.
                            Click on it, and a pop-up will appear, asking you to confirm the deletion.
                            Click "Confirm" to proceed with the deletion.
                        </li>
                        <img src="{{ asset('/images/Admin-User-Manual/slide17.png') }}" alt=""
                            class="ssimage">
                        <li>
                            Alternatively, you can click on the Location Name itself. Select the number of
                            Locations you want to delete, then click on "Bulk Actions." From the dropdown menu,
                            choose "Delete Selected" to remove them.
                        </li>
                        <img src="{{ asset('/images/Admin-User-Manual/slide17-2.png') }}" alt=""
                            class="ssimage">
                    </ol>
                </div>
            </div>
            <div class="cont1">
                <div class="prose" id="proposal-status">
                    <h3 class="text-xl font-bold">Proposal Status</h3>
                    <p>The "Proposal Status" feature enables users to monitor the progress and current status of film
                        proposals
                        submitted on the platform.Additionally, you can use this feature to publish the proposals,
                        making them
                        accessible to the intended audience.</p>
                </div>
                <div>
                    <img src="{{ asset('/images/Admin-User-Manual/slide18.png') }}" alt="" class="ssimage">
                </div>
            </div>
            <div class="cont2">
                <div class="prose">
                    <h3 class="text-xl font-bold">How to Add Proposal Status</h3>
                    <img src="{{ asset('/images/Admin-User-Manual/slide19.png') }}" alt="" class="ssimage">
                    <p>
                        To add a new Proposal Status, click on the "New" button as indicated above.
                        A pop-up window will appear, as illustrated below, where you can enter the
                        Proposal Status. Once you've entered the Proposal Status, click the "Create" button to finalize
                        the addition.
                    </p>
                    <img src="{{ asset('/images/Admin-User-Manual/slide19-2.png') }}" alt=""
                        class="ssimage">
                </div>
            </div>

            <div class="cont2">
                <div class="prose">
                    <h3 class="text-xl font-bold">How to Edit Proposal Status</h3>
                    <img src="{{ asset('/images/Admin-User-Manual/slide20.png') }}" alt="" class="ssimage">
                    <p>
                        To edit Proposal Status, simply click on the edit icon as shown above. Once clicked,
                        a pop-up window will appear, as illustrated in the image below. In this window, input
                        the new name for the proposal status. After entering the new name, click on
                        "Save Changes" to update and save the changes.
                    </p>
                    <img src="{{ asset('/images/Admin-User-Manual/slide20-2.png') }}" alt=""
                        class="ssimage">
                </div>
            </div>
            <div class="cont2">
                <div>
                    <h3 class="text-xl font-bold">How to Delete a Proposal Status</h3>
                    <ol class="list-disc list-inside">
                        <p>To delete a Proposal Status, you have two options:</p>
                        <li>
                            Navigate to the Proposal Status feature and locate the delete button, highlighted in red.
                            Click on it, and a pop-up will appear, asking you to confirm the deletion.
                            Click "Confirm" to proceed with the deletion.
                        </li>
                        <img src="{{ asset('/images/Admin-User-Manual/slide21.png') }}" alt=""
                            class="ssimage">
                        <li>
                            Alternatively, you can click on the Film Genre itself. Select the number of
                            Locations you want to delete, then click on "Bulk Actions." From the dropdown menu,
                            choose "Delete Selected" to remove them.
                        </li>
                        <img src="{{ asset('/images/Admin-User-Manual/slide21-2.png') }}" alt=""
                            class="ssimage">
                    </ol>
                </div>
            </div>
            <div class="cont1">
                <div class="prose" id="films">
                    <h3 class="text-xl font-bold">Film Projects</h3>
                    <p>The "Film Projects" feature displays essential details such as sponsors, project status, titles,
                        genres, and more, providing comprehensive information about each film endeavor.</p>
                </div>
                <div>
                    <img src="{{ asset('/images/Admin-User-Manual/slide22.png') }}" alt="" class="ssimage">
                </div>
            </div>
            <div class="cont1">
                <div class="prose">
                    <h3 class="text-xl font-bold">How to Search Film Projects</h3>
                    <p>TTo search for specific film projects, utilize the filter feature. You can filter films
                        based on sponsors, genre, status, and dates. Once you've entered the desired details, click on
                        "Reset" to apply the filters.</p>
                </div>
                <div>
                    <img src="{{ asset('/images/Admin-User-Manual/slide23.png') }}" alt="" class="ssimage">
                </div>
            </div>
            <div class="cont2">
                <div class="prose">
                    <h3 class="text-xl font-bold">How to Update Film Project</h3>
                    <img src="{{ asset('/images/Admin-User-Manual/slide24.png') }}" alt="" class="ssimage">
                    <p>
                        To update Film Project, simply click on the edit icon as shown above. Once clicked, a pop-up
                        window will appear, as illustrated
                        in the image below. In this window, input the new name for the Film Project. After entering the
                        new name,
                        click on "Save Changes" to update and save the changes.
                    </p>
                    <img src="{{ asset('/images/Admin-User-Manual/slide24-2.png') }}" alt=""
                        class="ssimage">
                </div>
            </div>

            <div class="cont2">
                <div class="prose">
                    <h3 class="text-xl font-bold">How to Delete a Film Projects</h3>
                    <ol class="list-disc list-inside">
                        <p>To delete Film Projects, you have two options:</p>
                        <li>
                            Navigate to the Film Project feature and locate the delete button, highlighted in red.
                            Click on it, and a pop-up will appear, asking you to confirm the deletion.
                            Click "Confirm" to proceed with the deletion.
                        </li>
                        <img src="{{ asset('/images/Admin-User-Manual/slide25.png') }}" alt=""
                            class="ssimage">
                        <li>
                            Alternatively, you can click on the Film Project Name itself. Select the number of
                            Locations you want to delete, then click on "Bulk Actions." From the dropdown menu,
                            choose "Delete Selected" to remove them.
                        </li>
                        <img src="{{ asset('/images/Admin-User-Manual/slide25-2.png') }}" alt=""
                            class="ssimage">
                    </ol>
                </div>
            </div>
            <div class="cont1">
                <div class="prose" id="creators">
                    <h3 class="text-xl font-bold">Creator Profiles</h3>
                    <p>The "Creator Profiles" feature offers detailed profiles of filmmakers and content creators,
                        providing users with valuable insights into their backgrounds, portfolios, and contributions to
                        the platform.</p>
                </div>
                <div>
                    <img src="{{ asset('/images/Admin-User-Manual/slide26.png') }}" alt="" class="ssimage">
                </div>
            </div>
            <div class="cont2">
                <div class="prose">
                    <h3 class="text-xl font-bold">How to Add New Creator Profile</h3>
                    <img src="{{ asset('/images/Admin-User-Manual/slide27.png') }}" alt="" class="ssimage">
                    <p>
                        To add a new Proposal Creator Profile, click on the "New Creator Profile" button as indicated
                        above.
                        A pop-up window will appear, as illustrated below, where you can enter the new Creator. Once
                        you've
                        entered the New Creator, click the "Create" button to finalize the addition.
                    </p>
                    <img src="{{ asset('/images/Admin-User-Manual/slide27-2.png') }}" alt=""
                        class="ssimage">
                </div>
            </div>
            <div class="cont2">
                <div class="prose">
                    <h3 class="text-xl font-bold">How to Edit Creator Profile</h3>
                    <img src="{{ asset('/images/Admin-User-Manual/slide28.png') }}" alt="" class="ssimage">
                    <p>
                        To Edit Creator Profile, simply click on the edit icon as shown above. Once clicked, a pop-up
                        window
                        will appear, as illustrated in the image below. In this window, input the new name for the new
                        Creator.
                        After entering the new name, click on "Save Changes" to update and save the changes.
                    </p>
                    <img src="{{ asset('/images/Admin-User-Manual/slide28-2.png') }}" alt=""
                        class="ssimage">
                </div>
            </div>
            <div class="cont2">
                <div class="prose">
                    <h3 class="text-xl font-bold">How to View Creator Profile</h3>
                    <img src="{{ asset('/images/Admin-User-Manual/slide29.png') }}" alt="" class="ssimage">
                    <p>
                        To view a creator profile click on the view icon then it will take you to the page where you
                        will be able to view the Creators Details.
                    </p>
                    <img src="{{ asset('/images/Admin-User-Manual/slide29-2.png') }}" alt=""
                        class="ssimage">
                </div>
            </div>
            <div class="cont1">
                <div class="prose" id="schedules">
                    <h3 class="text-xl font-bold">Film Schedules</h3>
                    <p>The "Film Schedules" feature offers detailed profiles of filmmakers and content creators,
                        providing users with valuable insights into their backgrounds, portfolios, and contributions to
                        the platform.</p>
                </div>
                <div>
                    <img src="{{ asset('/images/Admin-User-Manual/slide30.png') }}" alt="" class="ssimage">
                </div>
            </div>
            <div class="cont2">
                <div class="prose">
                    <h3 class="text-xl font-bold">How to Create New Film Schedule</h3>
                    <img src="{{ asset('/images/Admin-User-Manual/slide31.png') }}" alt="" class="ssimage">
                    <p>
                        To add a new Film Schedule, click on the "Film Schedule" button as indicated above.
                        A pop-up window will appear, as illustrated below, where you can enter the new Creator. Once
                        you've
                        entered the New Creator, click the "Create" button to finalize the addition.
                    </p>
                    <img src="{{ asset('/images/Admin-User-Manual/slide31-2.png') }}" alt=""
                        class="ssimage">
                </div>
            </div>
            <div class="cont2">
                <div class="prose">
                    <h3 class="text-xl font-bold">How to Edit Film Schedules</h3>
                    <img src="{{ asset('/images/Admin-User-Manual/slide32.png') }}" alt="" class="ssimage">
                    <p>
                        To Edit Film Schedule, simply click on the edit icon as shown above. Once clicked, a pop-up
                        window
                        will appear, as illustrated in the image below. In this window, input the new name for the new
                        Creator.
                        After entering the new name, click on "Save Changes" to update and save the changes.
                    </p>
                    <img src="{{ asset('/images/Admin-User-Manual/slide32-2.png') }}" alt=""
                        class="ssimage">
                </div>
            </div>
            <div class="cont2">
                <div class="prose">
                    <h3 class="text-xl font-bold">How to View Film Schedules</h3>
                    <img src="{{ asset('/images/Admin-User-Manual/slide33.png') }}" alt="" class="ssimage">
                    <p>
                        To view a Film Schedule click on the view icon then it will take you to the page where you will
                        be able to view the Creators Details.
                    </p>
                    <img src="{{ asset('/images/Admin-User-Manual/slide33-2.png') }}" alt=""
                        class="ssimage">
                </div>
            </div>
            <div class="cont2">
                <div class="prose">
                    <h3 class="text-xl font-bold">Upload to Vimeo</h3>
                    <img src="{{ asset('/images/Admin-User-Manual/slide34.png') }}" alt="" class="ssimage">
                    <p>
                        The Upload to Video allows you to edit or upload the new video that you want incase changes have
                        been made in the
                        the current video Once you click on it a pop up will appear asking you if you want to overwrite
                        the video that had been previously been uploaded.
                    </p>
                    <img src="{{ asset('/images/Admin-User-Manual/slide34-2.png') }}" alt=""
                        class="ssimage">
                </div>
            </div>
            <div class="cont2">
                <div class="prose" id="sponsors">
                    <h3 class="text-xl font-bold">Sponsor Profiles</h3>
                    <p>
                        The "Sponsor Profiles" feature offers detailed profiles of sponsors and partnering entities
                        associated with the platform.
                        These profiles provide admin users with insights into the background, contributions, and
                        affiliations of each sponsor,
                        fostering transparency and trust within the community.
                    </p>
                    <img src="{{ asset('/images/Admin-User-Manual/slide36.png') }}" alt="" class="ssimage">
                </div>
            </div>
            <div class="cont2">
                <div class="prose">
                    <h3 class="text-xl font-bold">How to Add Sponsor Profiles</h3>
                    <img src="{{ asset('/images/Admin-User-Manual/slide35.png') }}" alt="" class="ssimage">
                    <p>
                        To add a new Sponsor Profile, click on the "New Sponsor Profile" button as indicated above. A
                        pop-up window will appear, as illustrated
                        below, where you can add the new Sponsor. Once you've entered the Sponsor Details, click the
                        "Create" button to finalize the addition.
                    </p>
                    <img src="{{ asset('/images/Admin-User-Manual/slide35-2.png') }}" alt=""
                        class="ssimage">
                </div>
            </div>
            <div class="cont2">
                <div class="prose">
                    <h3 class="text-xl font-bold">How to Edit Sponsor's Profiles</h3>
                    <img src="{{ asset('/images/Admin-User-Manual/slide37.png') }}" alt="" class="ssimage">
                    <p>
                        Click on the Edit Icon as depicted above. A page will appear displaying the sponsor profile
                        details, where you can select which part of the
                        profile you wish to modify. Once you've made the desired changes, click "Save Changes" to apply
                        them.
                    </p>
                    <img src="{{ asset('/images/Admin-User-Manual/slide37-2.png') }}" alt=""
                        class="ssimage">
                </div>
            </div>
            <div class="cont2">
                <div class="prose" id="users">
                    <h3 class="text-xl font-bold">Users</h3>
                    <p>
                        The "Users and Roles" feature facilitates the management of user accounts and their respective
                        roles within the platform.
                        Administrators can assign specific roles to users, such as sponsor, creator,and users,
                        controlling their access levels and
                        permissions. This feature ensures smooth and efficient operation of the platform by regulating
                        user activities and responsibilities.
                    </p>
                    <img src="{{ asset('/images/Admin-User-Manual/slide38.png') }}" alt="" class="ssimage">
                </div>
            </div>
            <div class="cont2">
                <div class="prose">
                    <h3 class="text-xl font-bold">How to Add a New User</h3>
                    <img src="{{ asset('/images/Admin-User-Manual/slide39.png') }}" alt="" class="ssimage">
                    <p>
                        To add a new user, click on the "New user" button as indicated above. A pop-up window will
                        appear, as illustrated below, where you
                        can enter the user name. Once you've entered the user name, click the "Create" button to
                        finalize the addition.
                    </p>
                    <img src="{{ asset('/images/Admin-User-Manual/slide39-2.png') }}" alt=""
                        class="ssimage">
                </div>
            </div>
            <div class="cont2">
                <div class="prose">
                    <h3 class="text-xl font-bold">How to Search Through Users</h3>
                    <p>
                        To search for specific users, utilize the filter feature. You can filter films based on sponsor,
                        creator, admin, and dates.
                        Once you've entered the desired details, click on "Reset" to apply the filters.
                    </p>
                    <img src="{{ asset('/images/Admin-User-Manual/slide40.png') }}" alt="" class="ssimage">
                </div>
            </div>
            <div class="cont2">
                <div class="prose">
                    <h3 class="text-xl font-bold">How to Edit User Details</h3>
                    <img src="{{ asset('/images/Admin-User-Manual/slide41.png') }}" alt="" class="ssimage">
                    <p>
                        Click on the Edit Icon as depicted above. A page will appear displaying the user profile
                        details, where you can select which part of
                        the profile you wish to modify. Once you've made the desired changes, click "Save Changes" to
                        apply them.
                    </p>
                    <img src="{{ asset('/images/Admin-User-Manual/slide41-2.png') }}" alt=""
                        class="ssimage">
                </div>
            </div>
            <div class="cont2">
                <div class="prose">
                    <h3 class="text-xl font-bold">How to Delete User Details</h3>
                    <img src="{{ asset('/images/Admin-User-Manual/slide42.png') }}" alt="" class="ssimage">
                    <p>
                        Click on the Edit Icon as depicted above. A page will appear displaying the user profile
                        details.On top of the page there is a delete
                        button click on it.A pop up will appear asking you to confirm if you want to delete it.Once you
                        have confirmed the user will be deleted.
                    </p>
                    <img src="{{ asset('/images/Admin-User-Manual/slide42-2.png') }}" alt=""
                        class="ssimage">
                </div>
            </div>
            <div class="cont2">
                <div class="prose" id="roles">
                    <h3 class="text-xl font-bold">How to Add a New Role</h3>
                    <img src="{{ asset('/images/Admin-User-Manual/slide43.png') }}" alt="" class="ssimage">
                    <p>
                        To add a new role, click on the "New Role" button as depicted above. This action will direct you
                        to a page where you can input the role's
                        name and guard name. Additionally, you have the option to enable all permissions for that role
                        or selectively choose which permissions to allow.
                    </p>
                    <img src="{{ asset('/images/Admin-User-Manual/slide43-2.png') }}" alt=""
                        class="ssimage">
                </div>
            </div>
            <div class="cont2">
                <div class="prose">
                    <h3 class="text-xl font-bold">How to Edit a Specific Role Information</h3>
                    <img src="{{ asset('/images/Admin-User-Manual/slide44.png') }}" alt="" class="ssimage">
                    <p>
                        To Edit a certain role details click on the Edit icon as shown above.Once clicked it will take
                        you to a page of the role’s details,
                        you can either choose to edit the role’s name or the permissions.Once done click on Save
                        changes.
                    </p>
                    <img src="{{ asset('/images/Admin-User-Manual/slide44-2.png') }}" alt=""
                        class="ssimage">
                </div>
            </div>
            <div class="cont2">
                <div class="prose">
                    <h3 class="text-xl font-bold">How to Delete a Certain Role</h3>
                    <ol class="list-disc list-inside">
                        <p>To delete a Role, you have two options:</p>
                        <li>
                            Navigate to the Role feature and locate the delete button, highlighted in red.
                            Click on it, and a pop-up will appear, asking you to confirm the deletion.
                            Click "Confirm" to proceed with the deletion.
                        </li>
                        <img src="{{ asset('/images/Admin-User-Manual/slide45.png') }}" alt=""
                            class="ssimage">
                        <li>
                            The other option is to Click on the Edit Icon. A page will appear displaying the role
                            profile details.On top of the page there is a delete button click on it.A pop up will
                            appear asking you to confirm if you want to delete it.Once you have confirmed the role will
                            be deleted.
                        </li>
                        <img src="{{ asset('/images/Admin-User-Manual/slide45-2.png') }}" alt=""
                            class="ssimage">
                    </ol>
                </div>
            </div>
        </div>
        <div id="creator-manual">
            <h2 id="creator" class="text-2xl font-bold">Imara TV Creator Guide</h2>
            <div>
                <div class="cont1">
                    <div class="prose">
                        <h3 class="text-xl font-bold">Sign Up</h3>
                        <p>To access the Imara TV Creator dashboard, you'll need to create and account.
                            Follow these steps.
                        </p>
                        <ol class="list-disc list-inside">
                            <li>Go to www.imara.tv and click on “Create On Imara” to sign up.</li>
                            <li>Input your details into the provided fields.</li>
                            <li>Click the "Sign Up" button.</li>
                            <li>Your account will be created, granting you access to the Imara TV Creator dashboard.
                            </li>
                        </ol>
                    </div>
                    <div>
                        <img src="{{ asset('/images/Creator-User-Manual/slide2.png') }}" alt="">
                    </div>
                </div>
                <div class="cont1">
                    <div class="prose">
                        <h3 class="text-xl font-bold">Login</h3>
                        <p>To log in, follow these steps:
                        </p>
                        <ol class="list-disc list-inside">
                            <li>Enter the email address associated with your account.</li>
                            <li>Input your password in the designated field.</li>
                            <li>Click the "Sign in" button to access your account.</li>
                        </ol>
                    </div>
                    <div>
                        <img src="{{ asset('/images/Creator-User-Manual/slide3.png') }}" alt="">
                    </div>
                </div>
                <div class="cont1">
                    <div class="prose" id="c-projects">
                        <h3 class="text-xl font-bold">Film Projects</h3>
                        <p>The "Film Projects" feature displays essential details such as sponsors, project status,
                            titles, genres, and more, providing comprehensive information about each film endeavor.
                        </p>

                    </div>
                    <div>
                        <img src="{{ asset('/images/Creator-User-Manual/slide4.png') }}" alt=""
                            class="ssimage">
                    </div>
                </div>

                <div class="cont2">
                    <div class="prose">
                        <h3 class="text-xl font-bold">How To Update Film Projects</h3>
                        <img src="{{ asset('/images/Creator-User-Manual/slide5.png') }}" alt=""
                            class="ssimage">
                        <p>To update Film Project, simply click on the edit icon as shown above. Once clicked, a pop-up
                            window will appear, as illustrated in the image below. In this window, input the new name
                            for
                            the Film Project. After entering the new name, click on "Save Changes" to update and save
                            the changes
                        </p>

                    </div>
                    <div>
                        <img src="{{ asset('/images/Creator-User-Manual/slide5-2.png') }}" alt=""
                            class="ssimage">
                    </div>
                </div>
                <div class="cont2">
                    <div class="prose">
                        <h3 class="text-xl font-bold">How To Search Film Projects</h3>
                        <p>To search for specific film projects, utilize the filter feature. You can filter films based
                            on sponsors, genre, status, and dates. Once you've entered the desired details, click on
                            "Reset" to apply the filters.
                        </p>
                        <img src="{{ asset('/images/Creator-User-Manual/slide6.png') }}" alt=""
                            class="ssimage">
                    </div>
                </div>
                <div class="cont2">
                    <div class="prose">
                        <h3 class="text-xl font-bold">How To Delete Film Projects</h3>
                        <p>To delete a film project, you have to options:</p>
                        <ul>
                            <li>Navigate to the Film Project Feature and locate the delete button, highlighted
                                in red. Click on it, and a pop-up will appear, asking you to confirm the deletion.
                                Click "Confirm" to proceed with the deletion.</li>
                            <img src="{{ asset('/images/Creator-User-Manual/slide7.png') }}" alt=""
                                class="ssimage">
                            <li>Alternatively, you can click on the Film Project Name itself.
                                Select the number of films you want to delete, then click on "Bulk Actions."
                                From the dropdown menu, choose "Delete Selected" to remove them</li>
                            <img src="{{ asset('/images/Creator-User-Manual/slide7-2.png') }}" alt=""
                                class="ssimage">
                        </ul>
                    </div>
                </div>
                <div class="cont1">
                    <div class="prose" id="c-schedules">
                        <h3 class="text-xl font-bold">Film Schedules</h3>
                        <p>The "Film Schedules" feature presents creators with a comprehensive
                            schedule detailing upcoming film screenings or release dates. This
                            allows users to stay informed about when and where they can expect to
                            view or experience the latest films on the platform.
                    </div>
                    <div>
                        <img src="{{ asset('/images/Creator-User-Manual/slide8.png') }}" alt=""
                            class="ssimage">
                    </div>
                </div>
                <div class="cont2">
                    <div>
                        <h3 class="text-xl font-bold">How to Search Film Schedules</h3>
                        <p>To search for specific film schedules, utilize the filter feature. You can filter films based
                            on
                            sponsors, genre, status, and dates. Once you've entered the desired details, click on
                            "Reset" to
                            allows users to stay informed about when and where they can expect to
                            apply the filters.
                    </div>
                    <div>
                        <img src="{{ asset('/images/Creator-User-Manual/slide9.png') }}" alt=""
                            class="ssimage">
                    </div>
                </div>
                <div class="cont2">
                    <h3 class="text-xl font-bold">How to View Film Schedules</h3>
                    <img src="{{ asset('/images/Creator-User-Manual/slide10.png') }}" alt=""
                        class="ssimage">
                    <p>To view Film Schedules click on View as shown above.Once you click on it a pop up will appear
                        with the film title,type,synopsis,creator,release date and sponsor</p>
                    <img src="{{ asset('/images/Creator-User-Manual/slide10-2.png') }}" alt=""
                        class="ssimage">
                </div>
            </div>
        </div>
        <div id="sponsor-manual">
            <h2 id="sponsor" class="text-2xl font-bold">Imara TV Sponsor User Manual</h2>
            <div class="cont1">
                <div class="prose">
                    <h3 class="text-xl font-bold">Sign Up</h3>
                    <p>To access the Imara TV Sponsor dashboard, you'll need to create and account.
                        Follow these steps.
                    </p>
                    <ol class="list-disc list-inside">
                        <li>Navigate to Imara TV Sing Up page.</li>
                        <li>Input your details into the provided fields.</li>
                        <li>Click the "Sign Up" button.</li>
                        <li>Your account will be created, granting you access to the Imara TV Sponsor dashboard.</li>
                    </ol>
                </div>
                <div>
                    <img src="{{ asset('/images/Sponsor-User-Manual/slide2.png') }}" alt="">
                </div>
            </div>
            <div class="cont1">
                <div class="prose">
                    <h3 class="text-xl font-bold">Login</h3>
                    <p>To log in, follow these steps:</p>
                    <ol class="list-disc list-inside">
                        <li>Enter the email address associated with your account.</li>
                        <li>Input your password in the designated field.</li>
                        <li>Click the "Sign in" button to access your account.</li>
                    </ol>
                </div>
                <div>
                    <img src="{{ asset('/images/Sponsor-User-Manual/slide3.png') }}" alt="">
                </div>
            </div>
            <div class="cont1">
                <div class="prose" id="s-dashboard">
                    <h3 class="text-xl font-bold">Sponsor Dashboard Features</h3>
                    <p>On the dashboard, you'll find the following features
                        for easy navigation:</p>
                    <ol class="list-disc list-inside">
                        <li>Dashboard: Provides an overview of your account and activities ie Total
                            creators,Projects,and Schedules.</li>
                        <li>Film Projects: Lists ongoing and completed film projects.You can also update and delete
                            projects.</li>
                        <li>Creator Profile: Profiles of filmmakers and content creators.</li>
                    </ol>
                </div>
                <div>
                    <img src="{{ asset('/images/Sponsor-User-Manual/slide4.png') }}" alt="" class="ssimage">
                </div>
            </div>
            <div class="cont1">
                <div class="prose">
                    <h3 class="text-xl font-bold">Dashboard</h3>
                    <p>
                        The Dashboard serves as a centralized hub, offering sponsors an overview of their account and
                        related activities. It provides key metrics such as the total number of creators, projects,
                        and schedules associated with the particular sponsor. This concise summary allows sponsors
                        to quickly assess their engagement and progress within the platform
                    </p>
                </div>
                <div>
                    <img src="{{ asset('/images/Sponsor-User-Manual/slide5.png') }}" alt="" class="ssimage">
                </div>
            </div>
            <div class="cont1">
                <div class="prose" id="s-project">
                    <h3 class="text-xl font-bold">Film Project</h3>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                        laboris
                        nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                        velit
                        esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                        sunt
                        in culpa qui officia deserunt mollit anim id est laborum.
                    </p>
                </div>
                <div>
                    <img src="{{ asset('/images/Sponsor-User-Manual/slide6.png') }}" alt="" class="ssimage">
                </div>
            </div>
            <div class="cont2">
                <div class="prose">
                    <h3 class="text-xl font-bold">How to Add a New Film Project</h3>
                    <img src="{{ asset('/images/Sponsor-User-Manual/slide7.png') }}" alt="" class="ssimage">
                    <p>
                        To add a New Film Project , click on the "Create New Proposal" button as depicted above.
                        This action will direct you to a page where you can input the Project details from title,
                        synopsis,budget ,Film length and so on.Once you are done with that click on the create button
                    </p>
                    <img src="{{ asset('/images/Sponsor-User-Manual/slide7-2.png') }}" alt=""
                        class="ssimage">
                </div>
            </div>

            <div class="cont2">
                <div class="prose">
                    <h3 class="text-xl font-bold">How to Search For a Particular Film Project</h3>
                    <p>
                        To search for specific film project , utilize the filter feature. You can filter films based on
                        sponsor, creator, admin, and dates. Once you've entered the desired details, click on "Reset"
                        to apply the filters
                    </p>
                    <img src="{{ asset('/images/Sponsor-User-Manual/slide8.png') }}" alt="" class="ssimage">
                </div>
            </div>
            <div class="cont2">
                <div class="prose">
                    <h3 class="text-xl font-bold">How to Delete Film Project</h3>
                    <p>
                        To delete A Certain Project Film, you have two options:
                    </p>
                    <ul>
                        <li>
                            Navigate to the project film that you want to delete and locate the delete button,
                            highlighted in
                            red. Click on it, and a pop-up will appear, asking you to confirm the deletion. Click
                            "Confirm"
                            to proceed with the deletion.
                        </li>
                        <img src="{{ asset('/images/Sponsor-User-Manual/slide10.png') }}" alt=""
                            class="ssimage">
                        <li>
                            The other option is to Click on the Edit Icon. A page will appear displaying the project
                            film details.
                            On top of the page there is a delete button click on it.A pop up will appear asking you to
                            confirm if
                            you want to delete it.Once you have confirmed the role will be deleted
                        </li>
                        <img src="{{ asset('/images/Sponsor-User-Manual/slide10-2.png') }}" alt=""
                            class="ssimage">
                    </ul>
                </div>
            </div>
            <div class="cont2">
                <div class="prose">
                    <h3 class="text-xl font-bold">How to Edit A Film Project</h3>
                    <img src="{{ asset('/images/Sponsor-User-Manual/slide9.png') }}" alt="" class="ssimage">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                        laboris
                        nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                        velit
                        esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                        sunt
                        in culpa qui officia deserunt mollit anim id est laborum.
                    </p>
                    <img src="{{ asset('/images/Sponsor-User-Manual/slide9-2.png') }}" alt=""
                        class="ssimage">
                </div>
            </div>

            <div class="cont1">
                <div class="prose" id="s-creatorprofiles">
                    <h3 class="text-xl font-bold">Creator Profile</h3>
                    <p>
                        The "Creator Profile" feature offers detailed profiles of filmmakers and content creators active
                        on the
                        platform. These profiles provide comprehensive information about the background, portfolio, and
                        contributions
                        of each creator, allowing users to explore their work and connect with them more effectively.
                    </p>
                </div>
                <div>
                    <img src="{{ asset('/images/Sponsor-User-Manual/slide11.png') }}" alt=""
                        class="ssimage">
                </div>
            </div>
            <div class="cont2">
                <div class="prose">
                    <h3 class="text-xl font-bold">How to View a Creator's Profile</h3>
                    <img src="{{ asset('/images/Sponsor-User-Manual/slide12-2.png') }}" alt=""
                        class="ssimage">
                    <p>
                        To view a creator profile click on the view icon then it will take you to the page where
                        you will be able to view the Creators Details
                    </p>
                    <img src="{{ asset('/images/Sponsor-User-Manual/slide12.png') }}" alt=""
                        class="ssimage">
                </div>
            </div>
        </div>
    </div>
</div>
