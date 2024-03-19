<?php
namespace App\Enums;

enum Roles: string{
    case STUDENT='student';
    case TEACHER='teacher';
    case SUPER_ADMIN="super-admin";
}