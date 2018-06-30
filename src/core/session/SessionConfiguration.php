<?php

final class SessionConfiguration {
    const SESSION_STORAGE = "\\App\\src\\core\\session\\FileSessionStorage";
    const SESSION_STORAGE_DATA = array('./sessions');
    const SESSION_LIFETIME = 3600;

}
