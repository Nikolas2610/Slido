<?php
if (mail('npsillou@gmail.com', 'Testing', 'hello', 'psillovits1@gmail.com')) {
    echo "success";
} else {
    echo "fail";
}
