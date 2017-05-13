<?php

// Here you can initialize variables that will be available to your tests
\sonrac\relations\tests\application\boot\StartYii2Application::getInstance()->stop();
\sonrac\relations\tests\application\boot\StartYii2Application::getInstance()->start();
\sonrac\relations\tests\application\boot\StartSelenium::getInstance()->stop();
\sonrac\relations\tests\application\boot\StartSelenium::getInstance()->start();
sleep(4);