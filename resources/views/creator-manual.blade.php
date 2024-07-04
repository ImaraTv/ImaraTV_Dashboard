<!DOCTYPE html>
<html lang="en">
    <style>
        .cont1{
            display: flex;
            width:50%;
            flex-direction: row;
            justify-content: space-between;
            border-bottom: solid;
            flex-wrap: wrap;
        }

        .cont2{
            width:50%;
            border-bottom: solid;
        }

        .ssimage{
            max-width: 100%;
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
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">>
        <div style="text-align:center;">
            <title id="#top">Imara.TV User Manual</title>
            <h1>Imara.TV User Manual</h1>
            <img src="{{asset('/images/imara_tv_logo_r.png')}}" alt="" style="width:30%; display:block; margin-left:auto; margin-right:auto;"> 
        </div>
    </head>

    <body>
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
                        <img src="{{asset('/images/Creator User Manual/slide2.png')}}" alt="">
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
                        <img src="{{asset('/images/Creator User Manual/slide3.png')}}" alt="">
                    </div>
                </div>

                <div  class="cont1">
                    <div>
                        <h3>Film Projects</h3>
                        <p>The "Film Projects" feature displays essential details such as sponsors, project status,<br>
                            titles, genres, and more, providing comprehensive information about each film endeavor.
                        </p>
                        
                    </div>
                    <div>
                        <img src="{{asset('/images/Creator User Manual/slide4.png')}}" alt="" class="ssimage">
                    </div>
                </div>
                
                <div  class="cont2">
                    <div>
                        <h3>How To Update Film Projects</h3>
                        <img src="{{asset('/images/Creator User Manual/slide5.png')}}" alt="" class="ssimage">
                        <p>To update Film Project, simply click on the edit icon as shown above. Once clicked, a pop-up <br>
                            window will appear, as illustrated in the image below. In this window, input the new name for <br>
                            the Film Project. After entering the new name, click on "Save Changes" to update and save <br>
                            the changes
                        </p>
                        
                    </div>
                    <div>
                        <img src="{{asset('/images/Creator User Manual/slide5-2.png')}}" alt="" class="ssimage">
                    </div>
                </div>

                <div  class="cont2">
                    <div>
                        <h3>How To Search Film Projects</h3>
                        <p>To search for specific film projects, utilize the filter feature. You can filter films based <br>
                            on sponsors, genre, status, and dates. Once you've entered the desired details, click on <br>
                            "Reset" to apply the filters.
                        </p>
                        <img src="{{asset('/images/Creator User Manual/slide6.png')}}" alt="" class="ssimage">
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
                                <img src="{{asset('/images/Creator User Manual/slide7.png')}}" alt="" class="ssimage">
                            <li>Alternatively, you can click on the Film Project Name itself. <br>
                                Select the number of films you want to delete, then click on "Bulk Actions." <br>
                                From the dropdown menu, choose "Delete Selected" to remove them</li>
                                <img src="{{asset('/images/Creator User Manual/slide7-2.png')}}" alt="" class="ssimage">
                        </ul>
                    </div>
                </div>

                <div  class="cont1">
                    <div>
                        <h3>Film Schedules</h3>
                        <p>The "Film Schedules" feature presents creators with a comprehensive <br>
                            schedule detailing upcoming film screenings or release dates. This <br>
                            allows users to stay informed about when and where they can expect to <br>
                            view or experience the latest films on the platform.
                    </div>
                    <div>
                        <img src="{{asset('/images/Creator User Manual/slide8.png')}}" alt="" class="ssimage">
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
                        <img src="{{asset('/images/Creator User Manual/slide9.png')}}" alt="" class="ssimage">
                    </div>
                </div>

                <div  class="cont2">
                    <h3>How to View Film Schedules</h3>
                    <img src="{{asset('/images/Creator User Manual/slide10.png')}}" alt="" class="ssimage">
                    <p>To view Film Schedules click on View as shown above.Once you click on it a pop up will appear <br>
                        with the film title,type,synopsis,creator,release date and sponsor</p>
                    <img src="{{asset('/images/Creator User Manual/slide10-2.png')}}" alt="" class="ssimage">
                </div>
            </div> 
            <a href="#top"><h3>Back to Top</h3></a>
        </div>
    
    </body>
</html>