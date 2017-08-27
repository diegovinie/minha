<?php

function hashPassword(/*string*/ $password, /*string*/ $salt=null){
    
    return md5($password);
}
