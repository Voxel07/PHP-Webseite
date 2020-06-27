<?php
echo' <link rel="stylesheet" href="../Styles/style_Join_us_popUp.css">';
echo' <script src="../Skripte/Join_us.js"></script>';
?>





<div id="popUp" class="joinus_box">

    <div class="login-div">
        <div class="logo_log"></div>
        <div class="titel">Registrierung</div>

        <form action="includes/signeup.inc.php" method="POST" enctype ="multipart/form-data">
        <div class="SignUp-Box">
            <!-- Vorname -->
                <div class="felder">
                    <div class="input-box">
                            <div class="input-svg"> 
                                <svg class="svg-icon" viewBox="0 0 20 20"><path d="M8.749,9.934c0,0.247-0.202,0.449-0.449,0.449H4.257c-0.247,0-0.449-0.202-0.449-0.449S4.01,9.484,4.257,9.484H8.3C8.547,9.484,8.749,9.687,8.749,9.934 M7.402,12.627H4.257c-0.247,0-0.449,0.202-0.449,0.449s0.202,0.449,0.449,0.449h3.145c0.247,0,0.449-0.202,0.449-0.449S7.648,12.627,7.402,12.627 M8.3,6.339H4.257c-0.247,0-0.449,0.202-0.449,0.449c0,0.247,0.202,0.449,0.449,0.449H8.3c0.247,0,0.449-0.202,0.449-0.449C8.749,6.541,8.547,6.339,8.3,6.339 M18.631,4.543v10.78c0,0.248-0.202,0.45-0.449,0.45H2.011c-0.247,0-0.449-0.202-0.449-0.45V4.543c0-0.247,0.202-0.449,0.449-0.449h16.17C18.429,4.094,18.631,4.296,18.631,4.543 M17.732,4.993H2.46v9.882h15.272V4.993z M16.371,13.078c0,0.247-0.202,0.449-0.449,0.449H9.646c-0.247,0-0.449-0.202-0.449-0.449c0-1.479,0.883-2.747,2.162-3.299c-0.434-0.418-0.714-1.008-0.714-1.642c0-1.197,0.997-2.246,2.133-2.246s2.134,1.049,2.134,2.246c0,0.634-0.28,1.224-0.714,1.642C15.475,10.331,16.371,11.6,16.371,13.078M11.542,8.137c0,0.622,0.539,1.348,1.235,1.348s1.235-0.726,1.235-1.348c0-0.622-0.539-1.348-1.235-1.348S11.542,7.515,11.542,8.137 M15.435,12.629c-0.214-1.273-1.323-2.246-2.657-2.246s-2.431,0.973-2.644,2.246H15.435z"></path></svg>
                            </div>
                            <div class="input-text">
                                <input  id="Vorname" onfocus="JoinInpuTest(this)" onblur="fu(this)" type="text" name="vName"  placeholder="Vorname" maxlength ="25" autofocus required />
                                <label id="label-Vorname" >Vorname</label>    
                            </div>
                            <div id="input-Vorname" class="input-check"></div>
                    </div>
                    <div id="hint-Vorname" class="hint-text"></div>
                </div>
            <!-- Nachname -->
                <div class="felder">
                    <div class="input-box">
                            <div class="input-svg"> 
                                <svg class="svg-icon" viewBox="0 0 20 20"><path d="M8.749,9.934c0,0.247-0.202,0.449-0.449,0.449H4.257c-0.247,0-0.449-0.202-0.449-0.449S4.01,9.484,4.257,9.484H8.3C8.547,9.484,8.749,9.687,8.749,9.934 M7.402,12.627H4.257c-0.247,0-0.449,0.202-0.449,0.449s0.202,0.449,0.449,0.449h3.145c0.247,0,0.449-0.202,0.449-0.449S7.648,12.627,7.402,12.627 M8.3,6.339H4.257c-0.247,0-0.449,0.202-0.449,0.449c0,0.247,0.202,0.449,0.449,0.449H8.3c0.247,0,0.449-0.202,0.449-0.449C8.749,6.541,8.547,6.339,8.3,6.339 M18.631,4.543v10.78c0,0.248-0.202,0.45-0.449,0.45H2.011c-0.247,0-0.449-0.202-0.449-0.45V4.543c0-0.247,0.202-0.449,0.449-0.449h16.17C18.429,4.094,18.631,4.296,18.631,4.543 M17.732,4.993H2.46v9.882h15.272V4.993z M16.371,13.078c0,0.247-0.202,0.449-0.449,0.449H9.646c-0.247,0-0.449-0.202-0.449-0.449c0-1.479,0.883-2.747,2.162-3.299c-0.434-0.418-0.714-1.008-0.714-1.642c0-1.197,0.997-2.246,2.133-2.246s2.134,1.049,2.134,2.246c0,0.634-0.28,1.224-0.714,1.642C15.475,10.331,16.371,11.6,16.371,13.078M11.542,8.137c0,0.622,0.539,1.348,1.235,1.348s1.235-0.726,1.235-1.348c0-0.622-0.539-1.348-1.235-1.348S11.542,7.515,11.542,8.137 M15.435,12.629c-0.214-1.273-1.323-2.246-2.657-2.246s-2.431,0.973-2.644,2.246H15.435z"></path></svg>
                            </div>
                            <div class="input-text">
                                <input  id="Nachname" onfocus="JoinInpuTest(this)" onblur="fu(this)" type="text" name="nName"  placeholder="Nachname" maxlength ="25"  required />
                                <label  id="label-Nachname">Nachname</label>
                            </div>
                            <div id="input-Nachname" class="input-check"></div>
                    </div>
                    <div  id="hint-Nachname" class="hint-text"></div>
                </div>
            <!-- Nick -->
                <div class="felder">
                <div class="input-box">
                        <div class="input-svg">
                            <svg class="svg-icon" viewBox="0 0 20 20"><path d="M12.075,10.812c1.358-0.853,2.242-2.507,2.242-4.037c0-2.181-1.795-4.618-4.198-4.618S5.921,4.594,5.921,6.775c0,1.53,0.884,3.185,2.242,4.037c-3.222,0.865-5.6,3.807-5.6,7.298c0,0.23,0.189,0.42,0.42,0.42h14.273c0.23,0,0.42-0.189,0.42-0.42C17.676,14.619,15.297,11.677,12.075,10.812 M6.761,6.775c0-2.162,1.773-3.778,3.358-3.778s3.359,1.616,3.359,3.778c0,2.162-1.774,3.778-3.359,3.778S6.761,8.937,6.761,6.775 M3.415,17.69c0.218-3.51,3.142-6.297,6.704-6.297c3.562,0,6.486,2.787,6.705,6.297H3.415z"></path></svg>
                        </div>
                        <div class="input-text">
                            <input id="Nick" type="text" onfocus="JoinInpuTest(this)" onblur="fu(this)" name="nick" placeholder ="Nick" maxlength="15" requierd>
                            <label id="label-Nick">Nick</label>
                        </div>
                        <div id="input-Nick" class="input-check"></div>
                </div>
                <div id="hint-Nick" class="hint-text"></div>
                </div>
            <!-- Email -->
                <div class="felder">
                    <div class="input-box">
                            <div class="input-svg"> 
                                <svg class="svg-icon" viewBox="0 0 20 20">
                                <path d="M17.388,4.751H2.613c-0.213,0-0.389,0.175-0.389,0.389v9.72c0,0.216,0.175,0.389,0.389,0.389h14.775c0.214,0,0.389-0.173,0.389-0.389v-9.72C17.776,4.926,17.602,4.751,17.388,4.751 M16.448,5.53L10,11.984L3.552,5.53H16.448zM3.002,6.081l3.921,3.925l-3.921,3.925V6.081z M3.56,14.471l3.914-3.916l2.253,2.253c0.153,0.153,0.395,0.153,0.548,0l2.253-2.253l3.913,3.916H3.56z M16.999,13.931l-3.921-3.925l3.921-3.925V13.931z"></path></svg>
                            </div>
                            <div class="input-text">
                                <input  id="Email" type="E-Mail" onfocus="JoinInpuTest(this)" onblur="fu(this)" name="mail" placeholder="E-Mail" required/>
                                <label id=label-Email>E-Mail</label>
                            </div>
                            <div id=input-Email class="input-check"></div>
                    </div>
                    <div id="hint-Email" class="hint-text"></div>
                </div>
            <!-- Geburtstag -->
                <div class="felder">
                    <div class="input-box">
                            <div class="input-svg"> 
                                <svg class="svg-icon" viewBox="0 0 20 20"><path d="M13.889,11.611c-0.17,0.17-0.443,0.17-0.612,0l-3.189-3.187l-3.363,3.36c-0.171,0.171-0.441,0.171-0.612,0c-0.172-0.169-0.172-0.443,0-0.611l3.667-3.669c0.17-0.17,0.445-0.172,0.614,0l3.496,3.493C14.058,11.167,14.061,11.443,13.889,11.611 M18.25,10c0,4.558-3.693,8.25-8.25,8.25c-4.557,0-8.25-3.692-8.25-8.25c0-4.557,3.693-8.25,8.25-8.25C14.557,1.75,18.25,5.443,18.25,10 M17.383,10c0-4.07-3.312-7.382-7.383-7.382S2.618,5.93,2.618,10S5.93,17.381,10,17.381S17.383,14.07,17.383,10"></path></svg>
                            </div>
                            <div class="input-text">
                                <input  type="date"  id="Geburtstag" onfocus="JoinInpuTest(this)" onblur="fu(this)"  name="geb"  placeholder="Geburtstag" required min="1900-01-01" max="3000-12-31"/>
                                <label id="label-Geburtstag">Geburtstag</label>
                            </div>
                            <div id=input-Geburtstag class="input-check"></div>
                    </div>
                    <div id="hint-Geburtstag" class="hint-text"></div>
                </div>
            <!-- Passwort -->
                <div class="felder">
                    <div class="input-box">
                            <div class="input-svg">
                                <svg class="svg-icon" viewBox="0 0 20 20"><path d="M17.308,7.564h-1.993c0-2.929-2.385-5.314-5.314-5.314S4.686,4.635,4.686,7.564H2.693c-0.244,0-0.443,0.2-0.443,0.443v9.3c0,0.243,0.199,0.442,0.443,0.442h14.615c0.243,0,0.442-0.199,0.442-0.442v-9.3C17.75,7.764,17.551,7.564,17.308,7.564 M10,3.136c2.442,0,4.43,1.986,4.43,4.428H5.571C5.571,5.122,7.558,3.136,10,3.136 M16.865,16.864H3.136V8.45h13.729V16.864z M10,10.664c-0.854,0-1.55,0.696-1.55,1.551c0,0.699,0.467,1.292,1.107,1.485v0.95c0,0.243,0.2,0.442,0.443,0.442s0.443-0.199,0.443-0.442V13.7c0.64-0.193,1.106-0.786,1.106-1.485C11.55,11.36,10.854,10.664,10,10.664 M10,12.878c-0.366,0-0.664-0.298-0.664-0.663c0-0.366,0.298-0.665,0.664-0.665c0.365,0,0.664,0.299,0.664,0.665C10.664,12.58,10.365,12.878,10,12.878"></path></svg>
                            </div>
                            <div class="input-text">
                                <input type="password" id="Passwort" autocomplete="new-password" onfocus="JoinInpuTest(this)" onblur="fu(this)" name="passwort" placeholder="Passwort" required/>
                                <label id="label-Passwort">Passwort</label>
                            </div>
                            <div id="input-Passwort" class="input-check"></div>
                    </div>
                    <div id="hint-Passwort" class="hint-text"></div>
                </div>
            <!-- Passwort wdh -->
                <div class="felder">
                    <div class="input-box">
                            <div class="input-svg" onclick="test()">
                                <svg class="svg-icon" viewBox="0 0 20 20"><path d="M17.308,7.564h-1.993c0-2.929-2.385-5.314-5.314-5.314S4.686,4.635,4.686,7.564H2.693c-0.244,0-0.443,0.2-0.443,0.443v9.3c0,0.243,0.199,0.442,0.443,0.442h14.615c0.243,0,0.442-0.199,0.442-0.442v-9.3C17.75,7.764,17.551,7.564,17.308,7.564 M10,3.136c2.442,0,4.43,1.986,4.43,4.428H5.571C5.571,5.122,7.558,3.136,10,3.136 M16.865,16.864H3.136V8.45h13.729V16.864z M10,10.664c-0.854,0-1.55,0.696-1.55,1.551c0,0.699,0.467,1.292,1.107,1.485v0.95c0,0.243,0.2,0.442,0.443,0.442s0.443-0.199,0.443-0.442V13.7c0.64-0.193,1.106-0.786,1.106-1.485C11.55,11.36,10.854,10.664,10,10.664 M10,12.878c-0.366,0-0.664-0.298-0.664-0.663c0-0.366,0.298-0.665,0.664-0.665c0.365,0,0.664,0.299,0.664,0.665C10.664,12.58,10.365,12.878,10,12.878"></path></svg>
                            </div>
                            <div class="input-text">
                                <input type="password" id="Passwort-WDH" autocomplete="new-password" onfocus="JoinInpuTest(this)" onblur="fu(this)" name="passwort-wdh"  placeholder="Passwort wiederholen" required/>
                                <label id="label-Passwort-WDH">Passwort-WDH</label>
                            </div>
                            <div id="input-Passwort-WDH" class="input-check"></div>
                    </div>
                    <div id="hint-Passwort-WDH" class="hint-text"></div>
                </div>
            </div>
            <!-- Felder zu -->

            <div class="upload">
                <label for="file">Wähle dein Profielbild</label>
                <input type="file" name="DateiZumHochladen" accept=".jpg,.png">
            </div> 
            <button class="signin-button" type="submit" name ="signeup-submit">SIGN UP</button>
        </form>
       
        </div> 
      
        
    </div> 
    <!-- Login zu -->
</div>




