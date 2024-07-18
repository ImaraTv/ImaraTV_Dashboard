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
        width: 19%;
        height: 100vh;
        margin-right: 1%;

        color: gray;

        display: flex;
        background-color: #F9FAFB;
    }

    .nav-list {
        font-family: 'Trebuchet MS', 'sans-serif';
        list-style-type: none;
        line-height: 250%;
        width: 100%;
    }


    .nav-li:hover {
        width: 100%;
        background-color: #F3F4F6;
    }

    .icon {
        width: 40%;
        margin-left: auto;
        margin-right: auto;
        mix-blend-mode: multiply;
    }

    #sponsor-manual {
        width: 60%;
    }

    .cont1 {
        font-family: 'Trebuchet MS', 'sans-serif';
        display: flex;
        width: 90%;
        flex-direction: row;
        justify-content: space-between;
        border: 1px solid #D0D0D0;
        border-radius: 25px;
        flex-wrap: wrap;
        padding: 20px;
        margin-bottom: 10px;

        background: #FFFFFF;

        box-shadow: 0px 2px 5px 4px rgba(0, 0, 0, 0.23);
        -webkit-box-shadow: 0px 2px 5px 4px rgba(0, 0, 0, 0.23);
        -moz-box-shadow: 0px 2px 5px 4px rgba(0, 0, 0, 0.23);
    }

    .cont2 {
        font-family: 'Trebuchet MS', 'sans-serif';
        width: 90%;
        border-radius: 25px;
        border-bottom: 1px solid #D0D0D0;
        padding: 20px;
        margin-bottom: 10px;

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

        .cont1,
        .cont2 {
            width: 100%;
            flex-wrap: wrap;
        }
    }

    @media screen and (max-width: 600px) {

        .cont1,
        .cont2 {
            width: 100%;
            flex-wrap: wrap;
        }
    }

    @media screen and (max-width: 800px) {

        .cont1,
        .cont2 {
            width: 100%;
            flex-wrap: wrap;
        }
    }
</style>
<div class="manual-container">
    <div class="nav-sidebarl">
        <nav class="border-gray-1000 dark:border-gray-6000 dark:bg-gray-9000 text-opacity-50 w-full">
            <ul class="nav-list">
                <li class="nav-li"><a href="#sponsor-manual" class="navlist">
                        <div class="flex">
                            <svg class="h-8 w-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                            </svg>Sponsor
                        </div>
                    </a></li>
                <li class="nav-li"><a href="#s-dashboard" class="navlist">
                        <div class="flex">
                            <svg class="h-8 w-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Dashboard
                        </div>
                    </a></li>
                <li class="nav-li"><a href="#s-project" class="navlist">
                        <div class="flex">
                            <svg class="h-8 w-8 text-gray-500" width="24" height="24" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" />
                                <path d="M18 15l-6-6l-6 6h12" transform="rotate(90 12 12)" />
                            </svg>
                            Film Projects
                        </div>
                    </a></li>
                <li class="nav-li"><a href="#s-creatorprofiles" class="navlist">
                        <div class="flex">
                            <svg class="h-8 w-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Creator Profiles
                        </div>
                    </a></li>
            </ul>
        </nav>
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
                <img src="{{ asset('/images/Sponsor-User-Manual/slide2.png') }}" alt="" class="ssimage">
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
                <img src="{{ asset('/images/Sponsor-User-Manual/slide3.png') }}" alt="" class="ssimage">
            </div>
        </div>
        <div class="cont1">
            <div class="prose" id="s-dashboard">
                <h3 class="text-xl font-bold">Sponsor Dashboard Features</h3>
                <p>On the dashboard, you'll find the following features
                    for easy navigation:</p>
                <ol class="list-disc list-inside">
                    <li>Dashboard: Provides an overview of your account and activities ie Total creators,Projects,and
                        Schedules.</li>
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
                    labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                    nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit
                    esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt
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
                <img src="{{ asset('/images/Sponsor-User-Manual/slide7-2.png') }}" alt="" class="ssimage">
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
                        Navigate to the project film that you want to delete and locate the delete button, highlighted
                        in
                        red. Click on it, and a pop-up will appear, asking you to confirm the deletion. Click "Confirm"
                        to proceed with the deletion.
                    </li>
                    <img src="{{ asset('/images/Sponsor-User-Manual/slide10.png') }}" alt="" class="ssimage">
                    <li>
                        The other option is to Click on the Edit Icon. A page will appear displaying the project film
                        details.
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
                    labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                    nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit
                    esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt
                    in culpa qui officia deserunt mollit anim id est laborum.
                </p>
                <img src="{{ asset('/images/Sponsor-User-Manual/slide9-2.png') }}" alt="" class="ssimage">
            </div>
        </div>

        <div class="cont1">
            <div class="prose" id="s-creatorprofiles">
                <h3 class="text-xl font-bold">Creator Profile</h3>
                <p>
                    The "Creator Profile" feature offers detailed profiles of filmmakers and content creators active on
                    the
                    platform. These profiles provide comprehensive information about the background, portfolio, and
                    contributions
                    of each creator, allowing users to explore their work and connect with them more effectively.
                </p>
            </div>
            <div>
                <img src="{{ asset('/images/Sponsor-User-Manual/slide11.png') }}" alt="" class="ssimage">
            </div>
        </div>
        <div class="cont2">
            <div class="prose">
                <h3 class="text-xl font-bold">How to View a Creator's Profile</h3>
                <img src="{{ asset('/images/Sponsor-User-Manual/slide12-2.png') }}" alt="" class="ssimage">
                <p>
                    To view a creator profile click on the view icon then it will take you to the page where
                    you will be able to view the Creators Details
                </p>
                <img src="{{ asset('/images/Sponsor-User-Manual/slide12.png') }}" alt="" class="ssimage">
            </div>
        </div>
    </div>
</div>
