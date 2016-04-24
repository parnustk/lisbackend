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
                LIS_CREATE: 'Loo',
                LIS_DELETE: 'Kustuta',
                LIS_CLEAR: 'Tühjenda',
                LIS_FILTER: 'Filtreeri',
                LIS_TRASHED: 'Prügikastis',
                LIS_NAME_FILTER: 'Nime filter',
                LIS_DESCRIPTION: 'Kirjeldus',

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
                ABSENCEREASON_GRID_FILTERS: 'Filtreeri puudumise põhjuseid',
                
                LIS_ABSENCE_VIEW: 'Puudumised',
                LIS_CREATE_NEW_ABSENCE: 'Loo uus puudumine',
                SELECT_AN_ABSENCEREASON: 'Vali puudumise põhjus',
                SELECT_A_STUDENT: 'Vali õpilane',
                SELECT_A_CONTACTLESSON: 'Vali kontakttund',
                ABSENCE_GRID_FILTERS: 'Filtreeri puudumisi',
                SELECT_OR_SEARCH_AN_ABSENCEREASON: 'Vali või otsi puudumise põhjus',
                SELECT_OR_SEARCH_A_STUDENT: 'Vali või otsi õpilane',
                SELECT_OR_SEARCH_A_CONTACTLESSON: 'Vali või otsi kontakttund',
                LIS_STUDENT: 'Õpilane'



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
                ABSENCEREASON_GRID_FILTERS: 'Filter absence reason',
                
                LIS_ABSENCE_VIEW: 'Absences',
                LIS_CREATE_NEW_ABSENCE: 'Create new absence',
                SELECT_AN_ABSENCEREASON: 'Select an absence reason',
                SELECT_A_STUDENT: 'Select a student',
                SELECT_A_CONTACTLESSON: 'Select a contact lesson',
                ABSENCE_GRID_FILTERS: 'Filter absences',
                SELECT_OR_SEARCH_AN_ABSENCEREASON: 'Select or search an absence reason',
                SELECT_OR_SEARCH_A_STUDENT: 'Select or search a student',
                SELECT_OR_SEARCH_A_CONTACTLESSON: 'elect or search a contact lesson',
                LIS_STUDENT: 'Student'

            }
        };
        return t;
    });

}());


