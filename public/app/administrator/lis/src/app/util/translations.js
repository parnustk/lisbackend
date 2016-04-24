/**
 * LIS development
 *
 * @link      https://github.com/parnustk/lisbackend
 * @copyright Copyright (c) 2016 LIS dev team
 * @license   https://opensource.org/licenses/MIT MIT License
 */

(function () {
    'use strict';

    define([], function () {
        var t = {
            et: {
                LIS_LOGIN_ERROR: 'Sisestatud kasutajanimi või parool on vale. Palun proovige uuesti.',
                LIS_LOGIN_GREETING: 'Sisselogimine',
                LIS_EMAIL: 'E-posti aadress',
                LIS_PASSWORD: 'Salasõna',
                LIS_LOGIN: 'Logi sisse',
                LIS_LOGOUT: 'Logi välja',
                LIS_NAME: 'Nimi',
                LIS_FIRSTNAME: 'Eesnimi',
                LIS_LASTNAME: 'Perekonnanimi',
                LIS_CREATE: 'Loo',
                LIS_DELETE: 'Kustuta',
                LIS_CLEAR: 'Tühjenda',
                LIS_FILTER: 'Filtreeri',
                LIS_TRASHED: 'Prügikastis',
                LIS_NAME_FILTER: 'Nime filter',
                LIS_DESCRIPTION: 'Kirjeldus',
                LIS_PERSONALCODE: 'Kood',

                LIS_ROOM: 'Ruumid',
                LIS_CREATE_NEW_ROOM: 'Uus ruum',
                LIS_ROOM_GRID_FILTERS: 'Ruumide filter',

                LIS_SUBJECTROUND: 'SR', //tõlge?
                LIS_CREATE_NEW_SUBJECTROUND: 'Uus SR',
                LIS_SUBJECTROUND_GRID_FILTERS: 'SR filtrid',

                LIS_CONTACTLESSON: 'Kontakttund',
                LIS_CONTACTLESSON_VIEW: 'Kontakttunnid',

                LIS_STUDENTGROUP: 'Õppegrupid',
                LIS_TEACHER: 'Õpetajad',
                LIS_SUBJECT: 'Teemad',
                
                LIS_ABSENCEREASON_VIEW:'Puudumise põhjused',
                LIS_ABSENCEREASON: 'Puudumise põhjus',
                LIS_CREATE_NEW_ABSENCEREASON: 'Loo uus puudumise põhjus',
                ABSENCEREASON_GRID_FILTERS: 'Puudumise põhjuste filter',
                
                LIS_ABSENCE_VIEW: 'Puudumised',
                LIS_CREATE_NEW_ABSENCE: 'Loo uus puudumine',
                SELECT_AN_ABSENCEREASON: 'Vali puudumise põhjus',
                SELECT_A_STUDENT: 'Vali õpilane',
                SELECT_A_CONTACTLESSON: 'Vali kontakttund',
                ABSENCE_GRID_FILTERS: 'Puudumiste filtrid',
                SELECT_OR_SEARCH_AN_ABSENCEREASON: 'Vali või otsi puudumise põhjus',
                SELECT_OR_SEARCH_A_STUDENT: 'Vali või otsi õpilane',
                SELECT_OR_SEARCH_A_CONTACTLESSON: 'Vali või otsi kontakttund',
                LIS_STUDENT: 'Õpilane',
                
                LIS_VOCATION_VIEW: 'Erialad',
                LIS_CREATE_NEW_VOCATION: 'Loo uus eriala',
                LIS_VOCATIONCODE: 'Eriala kood',
                LIS_DURATIONEKAP: 'Kestus (EKAP)',
                VOCATION_GRID_FILTERS:'Erialade filtrid',
                SEARCH_A_NAME: 'Otsi nime järgi',
                SEARCH_A_VOCATIONCODE: 'Otsi eriala koodi järgi',
                SEARCH_A_DURATIONEKAP: 'Otsi kestuse (EKAP) järgi',

                LIS_GRADECHOICE_VIEW:'Hinde valikud',
                LIS_CREATE_NEW_GRADECHOICE: 'Loo uus hinde valik',
                GRADECHOICE_GRID_FILTERS: 'Hinde valikute filter',
                
                LIS_MODULETYPE_VIEW:'Mooduli tüübid',
                LIS_CREATE_NEW_MODULETYPE:'Loo uus mooduli tüüp',
                MODULETYPE_GRID_FILTERS:'Mooduli tüüpide filter',
                
                LIS_STUDENT_VIEW: 'Õpilased',
                LIS_CREATE_NEW_STUDENT: 'Loo uus õpilane',
                SEARCH_A_FIRSTNAME:'Otsi eesnime järgi',
                SEARCH_A_LASTNAME:'Otsi perekonnanime järgi',
                SEARCH_AN_EMAIL:'Otsi e-posti aadressi järgi',
                SEARCH_A_PERSONALCODE:'Otsi koodi järgi',
                STUDENT_GRID_FILTERS:'Õpilaste filtrid',
                
                LIS_ADMINISTRATOR_VIEW:'Administraatorid',
                LIS_CREATE_NEW_ADMINISTRATOR:'Loo uus administraator',
                ADMINISTRATOR_GRID_FILTERS:'Administraatorite filtrid'


            },
            en: {
                LIS_EMAIL: 'E-mail address',
                LIS_PASSWORD: 'Password',
                LIS_NAME: 'Name',
                LIS_CREATE: 'Create',
                LIS_DELETE: 'Delete',
                LIS_CLEAR: 'Clear',
                LIS_FILTER: 'Filter',
                LIS_TRASHED: 'Trashed',
                LIS_NAME_FILTER: 'Name filter',
                LIS_DESCRIPTION: 'Description',
                LIS_FIRSTNAME: 'First name',
                LIS_LASTNAME: 'Last name',
                LIS_PERSONALCODE: 'Code',

                LIS_LOGIN: 'Log in',
                LIS_LOGOUT: 'Log out',
                LIS_LOGIN_GREETING: 'Please log in',
                LIS_LOGIN_ERROR: 'The entered username or password are incorrect. Please try again',

                LIS_ROOM: 'Rooms',
                LIS_CREATE_NEW_ROOM: 'Create a new room',
                LIS_ROOM_GRID_FILTERS: 'Room filter',

                LIS_SUBJECTROUND: 'Subject round?',
                LIS_CREATE_NEW_SUBJECTROUND: 'New SR',
                LIS_SUBJECTROUND_GRID_FILTERS: 'SR filters',

                LIS_CONTACTLESSON: 'Contact lessons',
                LIS_CONTACTLESSON_VIEW: 'Contactlesson',

                LIS_STUDENTGROUP: 'Student groups',
                LIS_TEACHER: 'Teachers',
                LIS_SUBJECT: 'Subjects',
                
                LIS_ABSENCEREASON: 'Absence reasons',
                LIS_CREATE_NEW_ABSENCEREASON: 'Create new absence reason',
                ABSENCEREASON_GRID_FILTERS: 'Absence reasons filter',
                
                LIS_ABSENCE_VIEW: 'Absences',
                LIS_CREATE_NEW_ABSENCE: 'Create new absence',
                SELECT_AN_ABSENCEREASON: 'Select an absence reason',
                SELECT_A_STUDENT: 'Select a student',
                SELECT_A_CONTACTLESSON: 'Select a contact lesson',
                ABSENCE_GRID_FILTERS: 'Absences filters',
                SELECT_OR_SEARCH_AN_ABSENCEREASON: 'Select or search an absence reason',
                SELECT_OR_SEARCH_A_STUDENT: 'Select or search a student',
                SELECT_OR_SEARCH_A_CONTACTLESSON: 'Select or search a contact lesson',
                LIS_STUDENT: 'Student',
                
                LIS_VOCATION_VIEW: 'Vocations',
                LIS_CREATE_NEW_VOCATION: 'Create new vocation',
                LIS_VOCATIONCODE: 'Vocation code',
                LIS_DURATIONEKAP: 'Duration (EKAP)',
                VOCATION_GRID_FILTERS:'Vocations filters',
                SEARCH_A_NAME: 'Search by name',
                SEARCH_A_VOCATIONCODE: 'Search by vocation code',
                SEARCH_A_DURATIONEKAP: 'Search by duration (EKAP)',
                
                LIS_GRADECHOICE_VIEW:'Grade choices',
                LIS_CREATE_NEW_GRADECHOICE: 'Create new grade choice',
                GRADECHOICE_GRID_FILTERS: 'Grade choices filter',
                
                LIS_MODULETYPE_VIEW:'Module types',
                LIS_CREATE_NEW_MODULETYPE:'Create new module type',
                MODULETYPE_GRID_FILTERS:'Module types filter',
                
                LIS_STUDENT_VIEW: 'Students',
                LIS_CREATE_NEW_STUDENT: 'Create new student',
                SEARCH_A_FIRSTNAME:'Search by first name',
                SEARCH_A_LASTNAME:'Search by last name',
                SEARCH_AN_EMAIL:'Search by e-mail address',
                SEARCH_A_PERSONALCODE:'Search by code'

            }
        };
        return t;
    });

}());


