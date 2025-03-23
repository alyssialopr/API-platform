<?php

namespace App\Enum;

enum AppointmentStatus: string
{
        case PROGRAMMED = 'Programmé';
        case ONGOING = 'En cours';
        case FINISHED = 'Terminé';
}