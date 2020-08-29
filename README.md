**README**

**Camagru**

A social-media website that allows users to upload images in a public
gallery, where other users can like and comment on them.

**Requirements**

-   MAMP V5.7: <https://www.mamp.info/en/downloads/>

**Installation**

**How to download the source code:**

-   Go to <https://github.com/srheede/camagru>

-   Click Clone or Download

**How to set up and configure the database:**

-   Download MAMP

-   Start the MAMP application and click Start Servers

-   Make sure the Apache and MySQL servers are started

-   Copy Camagru to the htdocs folder

-   Open a web browser and go to
    http://localhost:8888/camagru/config/setup.php

**How to run the program:**

-   Open a web browser and go to <http://localhost:8888/camagru/>

**Code Breakdown**

-   Back end technologies:

    -   PHP

    -   JavaScript

-   Front end technologies:

    -   HTML

-   Database Management Systems

    -   MySQL

    -   PhpMyAdmin

-   Config

    -   database.php

        -   Create a connection to the database.

    -   setup.php

        -   Creates the Camagru database with all it's tables.

-   Program Files

    -   account.php

        -   Secure user page after login, where the user can upload
            images to their profile.

    -   activation.php

        -   The page that activates the user with the token from the
            activation email.

    -   changedetails.php

        -   Allows the user to alter their account details.

    -   gallery.php

        -   Here the user can view their personal gallery and delete
            photos from the gallery.

    -   image.php

        -   Displays single image, when the image is selected in the
            gallery.

    -   index.php

        -   Landing page to the website. From here the user can go to
            the registration page, login page or view the public
            gallery.

    -   login.php

        -   Page, where the user can log in to their profile.

    -   logout.php

        -   On logging out from the user profile, the user is redirected
            to this page.

    -   photo.js

        -   Enables web-camera and image capture functionality.

    -   publicgallery.php

        -   Public display of all the images on the website.

    -   register.php

        -   Page, where the user can create a user profile.

    -   reset.php

        -   Sends an email to the user with a link to reset their
            password.

    -   resetpw.php

        -   Page, where the user can enter a new password.

**Testing**

<https://github.com/wethinkcode-students/corrections_42_curriculum/blob/master/camagru.markingsheet.pdf>
