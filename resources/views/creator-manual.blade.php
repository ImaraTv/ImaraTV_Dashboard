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

    .manual-content {
        display: flex;
        width: 100%
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

    #creator-manual {
        width: 60%;
        margin-left: auto;
        margin-right: auto;
    }

    .a,
    h2 {
        font-family: 'Trebuchet MS', 'sans-serif';
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

        .cont1,
        .cont2 {
            width: 100%;
            flex-wrap: wrap;
            border-bottom: 100%
        }
    }

    @media screen and (max-width: 600px) {

        .cont1,
        .cont2 {
            width: 100%;
            flex-wrap: wrap;
            border-bottom: 100%
        }
    }

    @media screen and (max-width: 800px) {

        .cont1,
        .cont2 {
            width: 100%;
            flex-wrap: wrap;
            border-bottom: 100%
        }
    }
</style>

<div class="manual-content">
    <div class="nav-sidebarl">
        <nav class="border-gray-1000 dark:border-gray-6000 dark:bg-gray-9000 text-opacity-50 w-full">
            <ul class="nav-list">
                <li class="nav-li"><a href="#sponsor-manual" class="navlist">
                        <div class="flex"> <svg class="h-8 w-8 text-gray-500" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>Creator</div>
                    </a></li>
                <li class="nav-li"><a href="#c-project" class="navlist">
                        <div class="flex"><svg class="h-8 w-8 text-gray-500" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Film Projects</div>
                    </a></li>
                <li class="nav-li"><a href="#c-schedules" class="navlist">
                        <div class="flex"><svg class="h-8 w-8 text-gray-500" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                <line x1="16" y1="2" x2="16" y2="6" />
                                <line x1="8" y1="2" x2="8" y2="6" />
                                <line x1="3" y1="10" x2="21" y2="10" />
                            </svg>Film Schedules</div>
                    </a></li>
            </ul>
        </nav>
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
                        <li>Your account will be created, granting you access to the Imara TV Creator dashboard.</li>
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
                    <img src="{{ asset('/images/Creator-User-Manual/slide4.png') }}" alt="" class="ssimage">
                </div>
            </div>

            <div class="cont2">
                <div class="prose">
                    <h3 class="text-xl font-bold">How To Update Film Projects</h3>
                    <img src="{{ asset('/images/Creator-User-Manual/slide5.png') }}" alt="" class="ssimage">
                    <p>To update Film Project, simply click on the edit icon as shown above. Once clicked, a pop-up
                        window will appear, as illustrated in the image below. In this window, input the new name for
                        the Film Project. After entering the new name, click on "Save Changes" to update and save
                        the changes
                    </p>

                </div>
                <div>
                    <img src="{{ asset('/images/Creator-User-Manual/slide5-2.png') }}" alt="" class="ssimage">
                </div>
            </div>
            <div class="cont2">
                <div class="prose">
                    <h3 class="text-xl font-bold">How To Search Film Projects</h3>
                    <p>To search for specific film projects, utilize the filter feature. You can filter films based
                        on sponsors, genre, status, and dates. Once you've entered the desired details, click on
                        "Reset" to apply the filters.
                    </p>
                    <img src="{{ asset('/images/Creator-User-Manual/slide6.png') }}" alt="" class="ssimage">
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
                        <img src="{{ asset('/images/Creator-User-Manual/slide7.png') }}" alt="" class="ssimage">
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
                    <img src="{{ asset('/images/Creator-User-Manual/slide8.png') }}" alt="" class="ssimage">
                </div>
            </div>
            <div class="cont2">
                <div>
                    <h3 class="text-xl font-bold">How to Search Film Schedules</h3>
                    <p>To search for specific film schedules, utilize the filter feature. You can filter films based on
                        sponsors, genre, status, and dates. Once you've entered the desired details, click on "Reset" to
                        allows users to stay informed about when and where they can expect to
                        apply the filters.
                </div>
                <div>
                    <img src="{{ asset('/images/Creator-User-Manual/slide9.png') }}" alt="" class="ssimage">
                </div>
            </div>
            <div class="cont2">
                <h3 class="text-xl font-bold">How to View Film Schedules</h3>
                <img src="{{ asset('/images/Creator-User-Manual/slide10.png') }}" alt="" class="ssimage">
                <p>To view Film Schedules click on View as shown above.Once you click on it a pop up will appear
                    with the film title,type,synopsis,creator,release date and sponsor</p>
                <img src="{{ asset('/images/Creator-User-Manual/slide10-2.png') }}" alt="" class="ssimage">
            </div>
        </div>
    </div>
</div>
