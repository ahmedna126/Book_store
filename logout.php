<?php

        session_start();

            session_unset();

            session_destroy();

                header("LOCATION: login.php");
                exit();