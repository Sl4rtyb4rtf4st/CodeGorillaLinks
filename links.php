<?php
    //index.php

    // Loading:
    $data[] = $_POST['data'];

    // submitting:
    $error = '';
    $subject = '';
    $url = '';
    $linktext = '';
    $password = '';
    // Doesn't really need a md5 hash but here it is
    $md5PassWord = md5('C0d3g0r1ll4');

    function clean_text($string) {
        // Remove any posibilty for SQL injection
        $string = trim($string);
        $string = stripslashes($string);
        $string = htmlspecialchars($string);
        return $string;
    }

    if(isset($_POST["submit"])) {
        if(empty($_POST["name"])) 	{
            $error .= '<p><label class="text-danger">Please Enter your Name</label></p>';
        }
        else {
            $name = clean_text($_POST["name"]);
            if(!preg_match("/^[a-zA-Z ]*$/",$name)) {
                $error .= '<p><label class="text-danger">Only letters and white space allowed</label></p>';
            }
        } 
        if(empty($_POST["url"])) {
            $error .= '<p><label class="text-danger">Please Enter your url</label></p>';
        } else {
            $url = clean_text($_POST["url"]);
            if(!filter_var($url, FILTER_VALIDATE_URL)) {
                $error .= '<p><label class="text-danger">Invalid url format</label></p>';
            }
        }
        if(empty($_POST["link-text"])) {
            $error .= '<p><label class="text-danger">The link text is required</label></p>';
        } else {
            $link-text = clean_text($_POST["link-text"]);
        }
        if(empty($_POST["password"])) {
            $error .= '<p><label class="text-danger">password is required</label></p>';
        } elseif (md5($password) !== $md5PassWord) {
            $error .= '<p><label class="text-danger">password is incorrect</label></p>';
        } else {
            md5($password) == $md5PassWord;
        }
        if($error == '') {
            $data = [$url, $link-text];
            $JSON_str = file_get_contents('data.json');
            $tempArray = json_decode($JSON_str, true);
            array_push($tempArray["$subject"], $data);
            $jsonData = json_encode($tempArray);
            file_put_contents('results.json', $jsonData);
        }
    }

    $JSON_str = file_get_contents('data.json');
    $tempArray = json_decode($JSON_str, true);

    function ulFromJson($subj, $tempArray) {
        // A subject string should be passed to the function together with 
        // the associative array with all the data from the JSON file 
        // An unordered list with all the right list items is returned
        
        $htmlConcat = "<ul>";
        foreach($tempArray["subj"] as $arr) {
            $htmlConcat .= "<li><a href=\"{$arr[0]}>{$arr[1]}</a>";
        }
        return $htmlConcat."</ul>";
    }


?> 

<?php 
$dbhost = 'localhost';
$dbuser = 'zoaqcnkg_gorilla';
$dbpass = 'CodeGorilla';
$db = 'zoaqcnkg_linkdump';
$dbtable = 'links';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);

if(! $conn ) {
   die('Could not connect: ' . mysql_error());
}

$sql = 'SELECT emp_id, emp_name, emp_salary FROM employee';
mysql_select_db('test_db');
$retval = mysql_query( $sql, $conn );

if(! $retval ) {
   die('Could not get data: ' . mysql_error());
}

while($row = mysql_fetch_array($retval, MYSQL_ASSOC)) {
   echo "EMP ID :{$row['emp_id']}  <br> ".
      "EMP NAME : {$row['emp_name']} <br> ".
      "EMP SALARY : {$row['emp_salary']} <br> ".
      "--------------------------------<br>"
      ;
}

echo "Fetched data successfully\n";

mysql_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CodeGorilla Link Dump</title>
    <link rel="apple-touch-icon" sizes="57x57" href="./apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="./apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="./apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="./apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="./apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="./apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="./apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="./apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="./apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="./android-chrome-144x144.png" sizes="144x144">
    <link rel="icon" type="image/png" href="./android-chrome-192x192.png" sizes="192x192">
    <link rel="icon" type="image/png" href="./android-chrome-96x96.png" sizes="96x96">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-TileImage" content="/mstile-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="normalizer.css">
    <link rel="stylesheet" href="bootstrap.min.css">
    <!-- v0.8 -->
    <style type="text/css">
        * {
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }
        html,body {
            width: 100%;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        header{
            padding: 3em 0;
            width: 100%;
            background-color: dimgray;
            background: radial-gradient(circle at top left,#696969, #a5a5a5);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            align-content: center;
        }
        header div {
            max-width: 900px;
            padding: 2em;
        }
        header h1 {
            padding-bottom: 1em;
        }
        main{
            display: grid;
            grid-template-columns: 1fr minmax(200px, 450px) minmax(200px, 450px) 1fr;
        }
        section {
            width: 100vw;
            padding: 1em;
            /* display: flex;
            justify-content: center;
            align-items: center;
            align-content: center; */
            max-width: 900px;
            grid-column: 2 / 4; 
        }
        
        /* Van codegorilla */
        div .logo {
            float: left;
            /* position: absolute; */
            left: 0;
            z-index: 1;
        }
        .logo, .logo a {
            overflow: hidden;
            position: relative;
            display: block;
            height: 100%;
        }
        img, a img {
            border: none;
            padding: 0;
            margin: 0;
            display: inline-block;
            max-width: 100%;
            height: auto;
            image-rendering: optimizeQuality;
        }
        .logo img {
            padding: 0;
            display: block;
            width: auto;
            height: auto;
            max-height: 100%;
            image-rendering: auto;
            position: relative;
            z-index: 2;
            height: 100%\9;
            height: auto\9;
            -webkit-transition: opacity 0.4s ease-in-out;
            transition: opacity 0.4s ease-in-out;
        }
        /* end codegorilla */
        .strong{
            font-weight: 600;
            background-color:rgba(176, 196, 222, 0.27);
        }
        
        .top-buttons {
            display: flex;
            padding: 3em 3em 1em;
            justify-content: center;
            align-items: center;
            align-content: center;
        }
        .top-buttons:first-of-type {
            grid-column: 2/3;
        }
        .top-buttons:last-of-type {
            grid-column: 3/4;
        }

        /* Checkbox */
        input[type=checkbox] {
            visibility: hidden;
        }
        .checkbox {
            top: 10px;
            width: 40px;
            height: 8px;
            background: #555;
            margin: 0 1em;
            position: relative;
            border-radius: 3px;
            display: inline-block;
        }
        .checkbox label {
            display: block;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            transition: all .5s ease;
            cursor: pointer;
            position: absolute;
            top: -3px;
            left: -3px;
            background: #ccc;
        }
        .checkbox input[type=checkbox]:checked + label {
            left: 27px;
        }
        .checkbox-container > .checkbox-one{
            position: relative;
            top: -6px;
        }
        
        
        /* Form styles */
        .form {
            padding: 0;
            height: 0;
            opacity: 0;
            visibility: hidden;
            transition: all 0.5s;
        }
        section.form.showIt {
            height: auto;
            padding: 2em 3em 2em 2em;
            opacity: 1 !important;
            visibility: visible;
        }

        .form form {
            border: 1px solid grey;
            padding: 2em;
        }
        .form label {
            padding-left: 0;
        }
        @media (max-width: 576px) {
            .form {
                padding: 2em 2em 2em 1em;
            }
        }

    </style>
</head>
<body>
    <header>
        <div>
            <span class="logo">
                <a href="https://www.codegorilla.nl/">
                    <img height="100" width="300" src="https://www.codegorilla.nl/wp-content/uploads/2018/04/logo-300x86.png" alt="CodeGorilla">
                </a>
            </span>
            <h1>LinkDump</h1>
            <p>Hierbij lijstjes met handige websites die gepost zijn op de whatsapp (sinds ik erbij zit) en slack en een, hele kleine, selectie links uit mijn web gerelateerde bookmarks. Klik op het vinke/schuifje om een highlight te hebben van linkjes die ik net iets boven de rest uit springen.</p>
        </div>
    </header>
    <main>
        <div class="top-buttons checkbox-container">
            <div class="inner-container"> <!-- This seems super hacky... -->
                <label for="checkboxInput" class="checkbox-one"><b>Andrew's favorieten</b></label> 
                <div class="checkbox">
                    <input type="checkbox" value="1" id="checkboxInput" name="" />
                    <label for="checkboxInput" aria-hidden="true"></label>
                </div>
            </div> 
        </div>
        <div class="top-buttons add-link-button">
            <button class="showform btn btn-primary">Toon Formulier</button>
        </div>

        <section class="form">
            <form action="links.php" method="post">
                <legend>Voeg Link toe</legend>
                <div class="form-group row">
                    <label for="subject" class="col-sm-4 col-form-label">Onderwerp</label>
                    <select name="subject" id="subject" class="col-sm-8 form-control" title="Kies link onderwerp">
                        <option value="html" name="html">HTML</option>
                        <option value="css" name="css">CSS</option>
                        <option value="js" name="js">JS</option>
                        <option value="php" name="php">PHP</option>
                        <option value="youtube" name="youtube">Youtube filmpjes</option>
                        <option value="editors" name="editor">Editors/Tools</option>
                        <option value="learning" name="learning">Learning Resources</option>
                        <option value="misc" name="misc">Misc</option>
                    </select>
                </div>
                <div class="form-group row">
                    <label for="url" class="col-sm-4 col-form-label">Link</label>
                    <input 
                        class="col-sm-8 form-control" 
                        type="url" id="url" name="url" 
                        placeholder="https://www.voorbeeld.nl/"
                        pattern="^(?:https?:\/\/)?(?:www)?\.?.+\.\w{2,3}\.?(?:\w{2-4})?(?:[\/\\\-#?A-Za-z]+)?$" 
                        title="url in de vorm http://iets.nl" required>
                </div>
                <div class="form-group row">
                    <label for="url" class="col-sm-4 col-form-label">Link beschrijving</label>
                    <input 
                        class="col-sm-8 form-control" 
                        type="text" id="link-text" name="link-text" 
                        placeholder="Link beschrijving"
                        title="Link tekst" 
                        required>
                </div>                
                <div class="form-group row">
                    <label for="password" class="col-sm-4 col-form-label">Password</label>
                    <input type="password" class="col-sm-5 form-control" id="password" placeholder="wachtwoord" required>
                    <button type="submit" class="btn btn-primary col-sm-2 offset-sm-1">Send</button>
                </div>
            </form>
        </section>

        <section>
            <h2>HTML</h2>
            <ul>
                <?php 
                    // fetch from the database
                    // use a sql query like:
                    // 
                    SELECT * FROM links WHERE subj = `html`;
                    echo "<li><a href=\"{$url}\">{$link_text}</a>{$desc}</li>"

                ?>
                <?php foreach($html_data as $key => $val): ?>
                <?php  ?>
                <?php endforeach; ?>
                <li><a href="https://developer.mozilla.org/en-US/docs/Learn/HTML/Howto">Use HTML to solve common problems - <abbr title="Mozilla Developer Network">MDN</abbr></a></li>
                <li><a href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element">HTML elements reference - <abbr title="Mozilla Developer Network">MDN</abbr></a></li>
                <li><a href="http://haml.info/">Haml</a> - Haml is a markup language that’s used to cleanly and simply describe the HTML of any web document</li>
                <li class="fav"><a href="http://diveintohtml5.info/semantics.html">Heel basic uitleg over html 5 met wat geschiedenis</a></li>
                <li><a href="https://css-tricks.com/responsive-images-youre-just-changing-resolutions-use-srcset/">Css-tricks</a> - Responsive Images: If you’re just changing resolutions, use srcset.</li>
                <li><a href="https://www.sitepoint.com/how-to-use-aria-effectively-with-html5/">sitepoint</a> - How to Use ARIA Effectively with HTML5</li>
                <li><a href="http://html5doctor.com/using-aria-in-html/">html5 doctor</a> - Using ARIA in HTML</li>
                <li class="fav"><a href="https://html5boilerplate.com/">HTML% boilerplate</a> - Een mooi start punt voor een webpagina</li>
                <!-- <li><a href=""></a></li> -->
            </ul>
        </section>

        <section>
            <h2>CSS</h2>
            <ul>
                <li class="fav"><a href="http://www.csszengarden.com/">Css zen garden</a> - A demonstration of what can be accomplished through CSS-based design.</li>
                <li><a href="http://getbootstrap.com/">Bootstrap</a></li>
                <li><a href="http://www.w3.org/TR/css3-selectors/#selectors">css3 selectors</a></li>
                <li class="fav"><a href="https://developer.mozilla.org/en-US/docs/Web/CSS/Pseudo-classes">css pseudo classes</a></li>
                <li class="fav"><a href="https://code.tutsplus.com/tutorials/the-30-css-selectors-you-must-memorize--net-16048">The 30 CSS Selectors You Must Memorize</a></li>
                <li><a href="https://css-tricks.com/almanac/properties/a/animation/">css-tricks</a> - Css animations</li>
                <li><a href="https://css-tricks.com/bem-101/">css-tricks</a> - BEM naming conventiones</li>
                <li class="fav"><a href="https://css-tricks.com/snippets/css/complete-guide-grid/">css-tricks</a>Acomplete gide to grid</li>
                <li class="fav"><a href="https://css-tricks.com/snippets/css/a-guide-to-flexbox/">Acomplete guide to flex</a></li>
                <li class="fav"><a href="https://css-tricks.com/snippets/css/css-grid-starter-layouts/">Css-tricks</a> - CSS Grid Starter Layouts</li>
                <!-- <li><a href=""></a></li> -->
            </ul>
        </section>

        <section>
            <h2>JavaScript</h2>
            <ul>
                <li class="fav"><a href="https://javascript30.com/">javascript30</a></li>
                <li><a href="https://dev.to/sarah_chima/var-let-and-const--whats-the-difference-69e">Var, let and const- what's the difference?</a></li>
                <li class="fav"><a href="http://eloquentjavascript.net/">eloquent javascript</a></li>
                <li><a href="https://scotch.io/bar-talk/4-javascript-design-patterns-you-should-know">4 JavaScript Design Patterns You Should Know</a></li>
                <li><a href="https://www.sitepoint.com/unit-test-javascript-mocha-chai/">Sitepoint</a> - Unit Test Your JavaScript Using Mocha and Chai</a></li>
                <li><a href="https://code.sololearn.com/W0jt01Ob69QG/?ref=app">10 Javascript Mini-Projects</a></li>
                <li class="fav"><a href="https://wesbos.com/courses/">Wesbos cources</a> - Cursusen door Wes Bos</li>
                <!-- <li><a href=""></a></li>
                    <li><a href=""></a></li> -->
            </ul>
        </section>

        <section>
            <h2>PHP</h2>
            <ul>
                <li><a href="http://www.wampserver.com/en/">Wampserver</a></li>
                <li><a href="https://www.dreamincode.net/downloads/ref_sheets/php_reference_sheet.pdf">PHP scheatsheet</a></li>
                <li class="fav"><a href="https://phptherightway.com/">phptherightway</a> - PHP cursus</li>
                <li><a href="http://ctankersley.com/2016/11/13/developing-on-windows-2016/">Developing on Windows, 2016 Edition</a> - (PHP)Programmeren op windows</li>
                <li class="fav"><a href="https://marketplace.visualstudio.com/items?itemName=brapifra.phpserver">PHP server for VS code</a> - Serveer een PHP bestand meteen uit de editor.</li>
                <!-- <li><a href=""></a></li> -->
            </ul>
        </section>

        <section>
            <h2>Youtube filmpjes</h2>
            <ul>
                <li><a href="https://youtu.be/Wm6CUkswsNw">Build An HTML5 Website With A Responsive Layout</a></li>
                <li><a href="https://youtu.be/Bv_5Zv5c-Ts">JavaScript: Understanding the Weird Parts - The First 3.5 Hours</a></li>
                <li><a href="https://youtu.be/W6NZfCO5SIk">JavaScript Tutorial for Beginners</a></li>
                <li><a href="https://youtu.be/GT8zxD4WXlU">Programming in Haskell chapter 1 First Steps part 1</a></li>
                <li><a href="https://youtu.be/hO7mzO83N1Q">JavaScript Patterns for 2017 - Scott Allen</a></li>
                <!-- <li><a href=""></a></li> -->
            </ul>
        </section>

        <section>
            <h2>Editors/Tools</h2>
            <ul>
                <li><a href="https://www.geany.org/">Geany</a> - Geany is a small and lightweight Integrated Development Environment.</li>
                <li><a href="http://www.sublimetext.com/">Sublime text</a> - A sophisticated text editor for code, markup and prose</li>
                <li class="fav"><a href="https://code.visualstudio.com/">VS Code</a> - Code editing. Redefined. Free. Open source. Runs everywhere.</li>
                <li><a href="https://notepad-plus-plus.org/">Notepad++</a> - Notepad++ is a free source code editor and Notepad replacement that supports several languages.</li>
                <li><a href="https://atom.io/">atom</a> - A hackable text editor for the 21st Century</li>
                <li class="fav"><a href="https://emmet.io/">Emmet</a> - Plugin to generate HTML fast (and way more!)</li>
                <li><a href="https://www.figma.com/">Figma</a> - Design, prototype, and gather feedback all in one place with Figma. (Ontwerptool)</li>
            </ul>
        </section>

        <section>
            <h2>Learning resources</h2>
            <ul>
                <li><a href="https://www.sololearn.com/">Sololearn</a></li>
                <li class="fav"><a href="https://learn.freecodecamp.org/">Freecodecamp</a></li>
                <li class="fav"><a href="https://www.udemy.com">Udemy</a></li>
                <li><a href="https://www.codecademy.com/">codecademy</a></li>
                <li><a href="https://www.edx.org/">edX</a> - Accelerate your future. Learn anytime, anywhere.</li>
                <li><a href="https://matthewjamestaylor.com/">Art and Design by Matthew James Taylor</a></li>
            </ul>
        </section>

        <section>
            <h2>Miscellaneous links</h2>
            <ul>
                <li class="fav"><a href="https://codepen.io/">Codepen.io</a> - A place to try out your html/css/js projects</li>
                <li><a href="http://loodens.org/blog/handleiding-v0-54/">Download hier V0.54 van de handleiding SpeakUP & CheckIN.</a></li>
                <li><a href="https://conemu.github.io/">ConEmu-Maximus5</a> - ConEmu-Maximus5 aims to be handy, comprehensive, fast and reliable terminal window</li>
                <li><a href="http://cmder.net/">Cmder</a> is a software package created out of pure frustration over the absence of nice console emulators on Windows</li>
                <li><a href="https://git-scm.com/doc">Git - Documentation</a></li>
                <li><a href="https://desktop.github.com/">Git desktop</a> - Git desktop a git UI for windows/mac made by github</li>
                <li><a href="https://bitbucket.org/">Bitbucket</a> - A place to leave you git repositories</li>
                <li><a href="https://cgv2018.slack.com">CodeGorilla voortraject slack channel </a></li>
                <li class="fav"><a href="https://alistapart.com/">A list Apart</a> -  A webzine that explores the design, development, and meaning of web content.</li>
                <li class="fav"><a href="https://css-tricks.com/">Css tricks</a> - Niet alleen voor css, maar wel met heel veel css gerelateerde artikelen</li>
                <li><a href="https://www.sitepoint.com/">Sitepoint</a> - Een beetje als css-tricks</li>
                <li><a href="https://developer.microsoft.com/en-us/microsoft-edge/tools/vms/">Download virtual machines</a>Test Microsoft Edge and versions of IE8 through IE11 using free virtual machines you download and manage locally.</li>
                <li><a href="http://pointnorth.io/">North</a> - Align and Guide Your Project</li>
            </ul>
        </section>
    </main>

    <script>
        const checkBox = document.querySelector('#checkboxInput');
         checkBox.addEventListener('click', (e) => {
            const fav = document.querySelectorAll('.fav');
            if(e.target.checked) {
                fav.forEach((el) => {el.classList.add("strong");});
                    // Using .toggle("strong") would have been much easier but that doesn't 
                    // work when going back from having clicked on a link
            } else {
                fav.forEach((el) => {el.classList.remove("strong");});
            }
        });
        
        const form = document.querySelector(".form");
        const showForm = document.querySelector(".showform");
        showForm.addEventListener("click", (e) => {
            form.classList.toggle("showIt");
            if (showForm.innerHTML.startsWith("T")){
                showForm.innerHTML = "Verberg Formulier";
            } else {
                showForm.innerHTML = "Toon Formulier";
            }
        });
        // import md5 from 'md5';  
    </script>
            
</body>
</html>