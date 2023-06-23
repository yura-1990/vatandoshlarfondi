<?php

namespace Database\Seeders;

use App\Models\Public\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $countries = [
            [
                "name" => 'Afghanistan',
                "code" => 'AF',
                "locale" => 'en'
            ],
            [
                "name" => 'Åland Islands',
                "code" => 'AX',
                "locale" => 'en'
            ],
            [
                "name" => 'Albania',
                "code" => 'AL',
                "locale" => 'en'
            ],
            [
                "name" => 'Algeria',
                "code" => 'DZ',
                "locale" => 'en'
            ],
            [
                "name" => 'American Samoa',
                "code" => 'AS',
                "locale" => 'en'
            ],
            [
                "name" => 'AndorrA',
                "code" => 'AD',
                "locale" => 'en'
            ],
            [
                "name" => 'Angola',
                "code" => 'AO',
                "locale" => 'en'
            ],
            [
                "name" => 'Anguilla',
                "code" => 'AI',
                "locale" => 'en'
            ],
            [
                "name" => 'Antarctica',
                "code" => 'AQ',
                "locale" => 'en'
            ],
            [
                "name" => 'Antigua and Barbuda',
                "code" => 'AG',
                "locale" => 'en'
            ],
            [
                "name" => 'Argentina',
                "code" => 'AR',
                "locale" => 'en'
            ],
            [
                "name" => 'Armenia',
                "code" => 'AM',
                "locale" => 'en'
            ],
            [
                "name" => 'Aruba',
                "code" => 'AW',
                "locale" => 'en'
            ],
            [
                "name" => 'Australia',
                "code" => 'AU',
                "locale" => 'en'
            ],
            [
                "name" => 'Austria',
                "code" => 'AT',
                "locale" => 'en'
            ],
            [
                "name" => 'Azerbaijan',
                "code" => 'AZ',
                "locale" => 'en'
            ],
            [
                "name" => 'Bahamas',
                "code" => 'BS',
                "locale" => 'en'
            ],
            [
                "name" => 'Bahrain',
                "code" => 'BH',
                "locale" => 'en'
            ],
            [
                "name" => 'Bangladesh',
                "code" => 'BD',
                "locale" => 'en'
            ],
            [
                "name" => 'Barbados',
                "code" => 'BB',
                "locale" => 'en'
            ],
            [
                "name" => 'Belarus',
                "code" => 'BY',
                "locale" => 'en'
            ],
            [
                "name" => 'Belgium',
                "code" => 'BE',
                "locale" => 'en'
            ],
            [
                "name" => 'Belize',
                "code" => 'BZ',
                "locale" => 'en'
            ],
            [
                "name" => 'Benin',
                "code" => 'BJ',
                "locale" => 'en'
            ],
            [
                "name" => 'Bermuda',
                "code" => 'BM',
                "locale" => 'en'
            ],
            [
                "name" => 'Bhutan',
                "code" => 'BT',
                "locale" => 'en'
            ],
            [
                "name" => 'Bolivia',
                "code" => 'BO',
                "locale" => 'en'
            ],
            [
                "name" => 'Bosnia and Herzegovina',
                "code" => 'BA',
                "locale" => 'en'
            ],
            [
                "name" => 'Botswana',
                "code" => 'BW',
                "locale" => 'en'
            ],
            [
                "name" => 'Bouvet Island',
                "code" => 'BV',
                "locale" => 'en'
            ],
            [
                "name" => 'Brazil',
                "code" => 'BR',
                "locale" => 'en'
            ],
            [
                "name" => 'British Indian Ocean Territory',
                "code" => 'IO',
                "locale" => 'en'
            ],
            [
                "name" => 'Brunei Darussalam',
                "code" => 'BN',
                "locale" => 'en'
            ],
            [
                "name" => 'Bulgaria',
                "code" => 'BG',
                "locale" => 'en'
            ],
            [
                "name" => 'Burkina Faso',
                "code" => 'BF',
                "locale" => 'en'
            ],
            [
                "name" => 'Burundi',
                "code" => 'BI',
                "locale" => 'en'
            ],
            [
                "name" => 'Cambodia',
                "code" => 'KH',
                "locale" => 'en'
            ],
            [
                "name" => 'Cameroon',
                "code" => 'CM',
        "locale" => 'en'
            ],
            [
                "name" => 'Canada',
                "code" => 'CA',
                "locale" => 'en'
            ],
            [
                "name" => 'Cape Verde',
                "code" => 'CV',
                "locale" => 'en'
            ],
            [
                "name" => 'Cayman Islands',
                "code" => 'KY',
                "locale" => 'en'
            ],
            [
                "name" => 'Central African Republic',
                "code" => 'CF',
                "locale" => 'en'
            ],
            [
                "name" => 'Chad',
                "code" => 'TD',
                "locale" => 'en'
            ],
            [
                "name" => 'Chile',
                "code" => 'CL',
                "locale" => 'en'
            ],
            [
                "name" => 'China',
                "code" => 'CN',
                "locale" => 'en'
            ],
            [
                "name" => 'Christmas Island',
                "code" => 'CX',
        "locale" => 'en'
            ],
            [
                "name" => 'Cocos (Keeling) Islands',
                "code" => 'CC',
                "locale" => 'en'
            ],
            [
                "name" => 'Colombia',
                "code" => 'CO',
                "locale" => 'en'
            ],
            [
                "name" => 'Comoros',
                "code" => 'KM',
                "locale" => 'en'
            ],
            [
                "name" => 'Congo',
                "code" => 'CG',
                "locale" => 'en'
            ],
            [
                "name" => 'Congo, The Democratic Republic of the',
                "code" => 'CD',
                "locale" => 'en'
            ],
            [
                "name" => 'Cook Islands',
                "code" => 'CK',
        "locale" => 'en'
            ],
            [
                "name" => 'Costa Rica',
                "code" => 'CR',
        "locale" => 'en'
            ],
            [
                "name" => 'Cote D\'Ivoire',
                "code" => 'CI',
                "locale" => 'en'
            ],
            [
                "name" => 'Croatia',
                "code" => 'HR',
        "locale" => 'en'
            ],
            [
                "name" => 'Cuba',
                "code" => 'CU',
                "locale" => 'en'
            ],
            [
                "name" => 'Cyprus',
                "code" => 'CY',
                "locale" => 'en'
            ],
            [
                "name" => 'Czech Republic',
                "code" => 'CZ',
                "locale" => 'en'
            ],
            [
                "name" => 'Denmark',
                "code" => 'DK',
        "locale" => 'en'
            ],
            [
                "name" => 'Djibouti',
                "code" => 'DJ',
                "locale" => 'en'
            ],
            [
                "name" => 'Dominica',
                "code" => 'DM',
                "locale" => 'en'
            ],
            [
                "name" => 'Dominican Republic',
                "code" => 'DO',
                "locale" => 'en'
            ],
            [
                "name" => 'Ecuador',
                "code" => 'EC',
                "locale" => 'en'
            ],
            [
                "name" => 'Egypt',
                "code" => 'EG',
                "locale" => 'en'
            ],
            [
                "name" => 'El Salvador',
                "code" => 'SV',
                "locale" => 'en'
            ],
            [
                "name" => 'Equatorial Guinea',
                "code" => 'GQ',
        "locale" => 'en'
            ],
            [
                "name" => 'Eritrea',
                "code" => 'ER',
                "locale" => 'en'
            ],
            [
                "name" => 'Estonia',
                "code" => 'EE',
                "locale" => 'en'
            ],
            [
                "name" => 'Ethiopia',
                "code" => 'ET',
                "locale" => 'en'
            ],
            [
                "name" => 'Falkland Islands (Malvinas)',
                "code" => 'FK',
                "locale" => 'en'
            ],
            [
                "name" => 'Faroe Islands',
                "code" => 'FO',
                "locale" => 'en'
            ],
            [
                "name" => 'Fiji',
                "code" => 'FJ',
                "locale" => 'en'
            ],
            [
                "name" => 'Finland',
                "code" => 'FI',
                "locale" => 'en'
            ],
            [
                "name" => 'France',
                "code" => 'FR',
                "locale" => 'en'
            ],
            [
                "name" => 'French Guiana',
                "code" => 'GF',
                "locale" => 'en'
            ],
            [
                "name" => 'French Polynesia',
                "code" => 'PF',
                "locale" => 'en'
            ],
            [
                "name" => 'French Southern Territories',
                "code" => 'TF',
                "locale" => 'en'
            ],
            [
                "name" => 'Gabon',
                "code" => 'GA',
        "locale" => 'en'
            ],
            [
                "name" => 'Gambia',
                "code" => 'GM',
                "locale" => 'en'
            ],
            [
                "name" => 'Georgia',
                "code" => 'GE',
                "locale" => 'en'
            ],
            [
                "name" => 'Germany',
                "code" => 'DE',
                "locale" => 'en'
            ],
            [
                "name" => 'Ghana',
                "code" => 'GH',
                "locale" => 'en'
            ],
            [
                "name" => 'Gibraltar',
                "code" => 'GI',
                "locale" => 'en'
            ],
            [
                "name" => 'Greece',
                "code" => 'GR',
                "locale" => 'en'
            ],
            [
                "name" => 'Greenland',
                "code" => 'GL',
                "locale" => 'en'
            ],
            [
                "name" => 'Grenada',
                "code" => 'GD',
                "locale" => 'en'
            ],
            [
                "name" => 'Guadeloupe',
                "code" => 'GP',
                "locale" => 'en'
            ],
            [
                "name" => 'Guam',
                "code" => 'GU',
                "locale" => 'en'
            ],
            [
                "name" => 'Guatemala',
                "code" => 'GT',
                "locale" => 'en'
            ],
            [
                "name" => 'Guernsey',
                "code" => 'GG',
                "locale" => 'en'
            ],
            [
                "name" => 'Guinea',
                "code" => 'GN',
                "locale" => 'en'
            ],
            [
                "name" => 'Guinea-Bissau',
                "code" => 'GW',
                "locale" => 'en'
            ],
            [
                "name" => 'Guyana',
                "code" => 'GY',
                "locale" => 'en'
            ],
            [
                "name" => 'Haiti',
                "code" => 'HT',
                "locale" => 'en'
            ],
            [
                "name" => 'Heard Island and Mcdonald Islands',
                "code" => 'HM',
                "locale" => 'en'
            ],
            [
                "name" => 'Holy See (Vatican City State)',
                "code" => 'VA',
                "locale" => 'en'
            ],
            [
                "name" => 'Honduras',
                "code" => 'HN',
                "locale" => 'en'
            ],
            [
                "name" => 'Hong Kong',
                "code" => 'HK',
                "locale" => 'en'
            ],
            [
                "name" => 'Hungary',
                "code" => 'HU',
        "locale" => 'en'
            ],
            [
                "name" => 'Iceland',
                "code" => 'IS',
                "locale" => 'en'
            ],
            [
                "name" => 'India',
                "code" => 'IN',
        "locale" => 'en'
            ],
            [
                "name" => 'Indonesia',
                "code" => 'ID',
        "locale" => 'en'
            ],
            [
                "name" => 'Iran, Islamic Republic Of',
                "code" => 'IR',
                "locale" => 'en'
            ],
            [
                "name" => 'Iraq',
                "code" => 'IQ',
                "locale" => 'en'
            ],
            [
                "name" => 'Ireland',
                "code" => 'IE',
                "locale" => 'en'
            ],
            [
                "name" => 'Isle of Man',
                "code" => 'IM',
                "locale" => 'en'
            ],
            [
                "name" => 'Israel',
                "code" => 'IL',
                "locale" => 'en'
            ],
            [
                "name" => 'Italy',
                "code" => 'IT',
                "locale" => 'en'
            ],
            [
                "name" => 'Jamaica',
                "code" => 'JM',
                "locale" => 'en'
            ],
            [
                "name" => 'Japan',
                "code" => 'JP',
                "locale" => 'en'
            ],
            [
                "name" => 'Jersey',
                "code" => 'JE',
                "locale" => 'en'
            ],
            [
                "name" => 'Jordan',
                "code" => 'JO',
                "locale" => 'en'
            ],
            [
                "name" => 'Kazakhstan',
                "code" => 'KZ',
                "locale" => 'en'
            ],
            [
                "name" => 'Kenya',
                "code" => 'KE',
                "locale" => 'en'
            ],
            [
                "name" => 'Kiribati',
                "code" => 'KI',
                "locale" => 'en'
            ],
            [
                "name" => 'Korea, Democratic People\'S Republic of',
                "code" => 'KP',
                "locale" => 'en'
            ],
            [
                "name" => 'Korea, Republic of',
                "code" => 'KR',
                "locale" => 'en'
            ],
            [
                "name" => 'Kuwait',
                "code" => 'KW',
                "locale" => 'en'
            ],
            [
                "name" => 'Kyrgyzstan',
                "code" => 'KG',
                "locale" => 'en'
            ],
            [
                "name" => 'Lao People\'S Democratic Republic',
                "code" => 'LA',
                "locale" => 'en'
            ],
            [
                "name" => 'Latvia',
                "code" => 'LV',
                "locale" => 'en'
            ],
            [
                "name" => 'Lebanon',
                "code" => 'LB',
                "locale" => 'en'
            ],
            [
                "name" => 'Lesotho',
                "code" => 'LS',
                "locale" => 'en'
            ],
            [
                "name" => 'Liberia',
                "code" => 'LR',
                "locale" => 'en'
            ],
            [
                "name" => 'Libyan Arab Jamahiriya',
                "code" => 'LY',
                "locale" => 'en'
            ],
            [
                "name" => 'Liechtenstein',
                "code" => 'LI',
                "locale" => 'en'
            ],
            [
                "name" => 'Lithuania',
                "code" => 'LT',
                "locale" => 'en'
            ],
            [
                "name" => 'Luxembourg',
                "code" => 'LU',
                "locale" => 'en'
            ],
            [
                "name" => 'Macao',
                "code" => 'MO',
                "locale" => 'en'
            ],
            [
                "name" => 'Macedonia, The Former Yugoslav Republic of',
                "code" => 'MK',
                "locale" => 'en'
            ],
            [
                "name" => 'Madagascar',
                "code" => 'MG',
                "locale" => 'en'
            ],
            [
                "name" => 'Malawi',
                "code" => 'MW',
                "locale" => 'en'
            ],
            [
                "name" => 'Malaysia',
                "code" => 'MY',
                "locale" => 'en'
            ],
            [
                "name" => 'Maldives',
                "code" => 'MV',
                "locale" => 'en'
            ],
            [
                "name" => 'Mali',
                "code" => 'ML',
                "locale" => 'en'
            ],
            [
                "name" => 'Malta',
                "code" => 'MT',
                "locale" => 'en'
            ],
            [
                "name" => 'Marshall Islands',
                "code" => 'MH',
                "locale" => 'en'
            ],
            [
                "name" => 'Martinique',
                "code" => 'MQ',
                "locale" => 'en'
            ],
            [
                "name" => 'Mauritania',
                "code" => 'MR',
                "locale" => 'en'
            ],
            [
                "name" => 'Mauritius',
                "code" => 'MU',
                "locale" => 'en'
            ],
            [
                "name" => 'Mayotte',
                "code" => 'YT',
                "locale" => 'en'
            ],
            [
                "name" => 'Mexico',
                "code" => 'MX',
                "locale" => 'en'
            ],
            [
                "name" => 'Micronesia, Federated States of',
                "code" => 'FM',
                "locale" => 'en'
            ],
            [
                "name" => 'Moldova, Republic of',
                "code" => 'MD',
                "locale" => 'en'
            ],
            [
                "name" => 'Monaco',
                "code" => 'MC',
                "locale" => 'en'
            ],
            [
                "name" => 'Mongolia',
                "code" => 'MN',
                "locale" => 'en'
            ],
            [
                "name" => 'Montserrat',
                "code" => 'MS',
        "locale" => 'en'
            ],
            [
                "name" => 'Morocco',
                "code" => 'MA',
                "locale" => 'en'
            ],
            [
                "name" => 'Mozambique',
                "code" => 'MZ',
                "locale" => 'en'
            ],
            [
                "name" => 'Myanmar',
                "code" => 'MM',
                "locale" => 'en'
            ],
            [
                "name" => 'Namibia',
                "code" => 'NA',
                "locale" => 'en'
            ],
            [
                "name" => 'Nauru',
                "code" => 'NR',
                "locale" => 'en'
            ],
            [
                "name" => 'Nepal',
                "code" => 'NP',
                "locale" => 'en'
            ],
            [
                "name" => 'Netherlands',
                "code" => 'NL',
 "locale" => 'en'
            ],
            [
                "name" => 'Netherlands Antilles',
                "code" => 'AN',
                "locale" => 'en'
            ],
            [
                "name" => 'New Caledonia',
                "code" => 'NC',
                "locale" => 'en'
            ],
            [
                "name" => 'New Zealand',
                "code" => 'NZ',
                "locale" => 'en'
            ],
            [
                "name" => 'Nicaragua',
                "code" => 'NI',
                "locale" => 'en'
            ],
            [
                "name" => 'Niger',
                "code" => 'NE',
                "locale" => 'en'
            ],
            [
                "name" => 'Nigeria',
                "code" => 'NG',
                "locale" => 'en'
            ],
            [
                "name" => 'Niue',
                "code" => 'NU',
                "locale" => 'en'
            ],
            [
                "name" => 'Norfolk Island',
                "code" => 'NF',
                "locale" => 'en'
            ],
            [
                "name" => 'Northern Mariana Islands',
                "code" => 'MP',
        "locale" => 'en'
            ],
            [
                "name" => 'Norway',
                "code" => 'NO',
                "locale" => 'en'
            ],
            [
                "name" => 'Oman',
                "code" => 'OM',
                "locale" => 'en'
            ],
            [
                "name" => 'Pakistan',
                "code" => 'PK',
                "locale" => 'en'
            ],
            [
                "name" => 'Palau',
                "code" => 'PW',
                "locale" => 'en'
            ],
            [
                "name" => 'Palestinian Territory, Occupied',
                "code" => 'PS',
                "locale" => 'en'
            ],
            [
                "name" => 'Panama',
                "code" => 'PA',
                "locale" => 'en'
            ],
            [
                "name" => 'Papua New Guinea',
                "code" => 'PG',
        "locale" => 'en'
            ],
            [
                "name" => 'Paraguay',
                "code" => 'PY',
                "locale" => 'en'
            ],
            [
                "name" => 'Peru',
                "code" => 'PE',
                "locale" => 'en'
            ],
            [
                "name" => 'Philippines',
                "code" => 'PH',
                "locale" => 'en'
            ],
            [
                "name" => 'Pitcairn',
                "code" => 'PN',
                "locale" => 'en'
            ],
            [
                "name" => 'Poland',
                "code" => 'PL',
                "locale" => 'en'
            ],
            [
                "name" => 'Portugal',
                "code" => 'PT',
                "locale" => 'en'
            ],
            [
                "name" => 'Puerto Rico',
                "code" => 'PR',
                "locale" => 'en'
            ],
            [
                "name" => 'Qatar',
                "code" => 'QA',
                "locale" => 'en'
            ],
            [
                "name" => 'Reunion',
                "code" => 'RE',
                "locale" => 'en'
            ],
            [
                "name" => 'Romania',
                "code" => 'RO',
                "locale" => 'en'
            ],
            [
                "name" => 'Russian Federation',
                "code" => 'RU',
        "locale" => 'en'
            ],
            [
                "name" => 'RWANDA',
                "code" => 'RW',
                "locale" => 'en'
            ],
            [
                "name" => 'Saint Helena',
                "code" => 'SH',
                "locale" => 'en'
            ],
            [
                "name" => 'Saint Kitts and Nevis',
                "code" => 'KN',
                "locale" => 'en'
            ],
            [
                "name" => 'Saint Lucia',
                "code" => 'LC',
                "locale" => 'en'
            ],
            [
                "name" => 'Saint Pierre and Miquelon',
                "code" => 'PM',
                "locale" => 'en'
            ],
            [
                "name" => 'Saint Vincent and the Grenadines',
                "code" => 'VC',
                "locale" => 'en'
            ],
            [
                "name" => 'Samoa',
                "code" => 'WS',
                "locale" => 'en'
            ],
            [
                "name" => 'San Marino',
                "code" => 'SM',
                "locale" => 'en'
            ],
            [
                "name" => 'Sao Tome and Principe',
                "code" => 'ST',
                "locale" => 'en'
            ],
            [
                "name" => 'Saudi Arabia',
                "code" => 'SA',
                "locale" => 'en'
            ],
            [
                "name" => 'Senegal',
                "code" => 'SN',
                "locale" => 'en'
            ],
            [
                "name" => 'Serbia and Montenegro',
                "code" => 'CS',
                "locale" => 'en'
            ],
            [
                "name" => 'Seychelles',
                "code" => 'SC',
        "locale" => 'en'
            ],
            [
                "name" => 'Sierra Leone',
                "code" => 'SL',
                "locale" => 'en'
            ],
            [
                "name" => 'Singapore',
                "code" => 'SG',
                "locale" => 'en'
            ],
            [
                "name" => 'Slovakia',
                "code" => 'SK',
                "locale" => 'en'
            ],
            [
                "name" => 'Slovenia',
                "code" => 'SI',
                "locale" => 'en'
            ],
            [
                "name" => 'Solomon Islands',
                "code" => 'SB',
                "locale" => 'en'
            ],
            [
                "name" => 'Somalia',
                "code" => 'SO',
                "locale" => 'en'
            ],
            [
                "name" => 'South Africa',
                "code" => 'ZA',
        "locale" => 'en'
            ],
            [
                "name" => 'South Georgia and the South Sandwich Islands',
                "code" => 'GS',
                "locale" => 'en'
            ],
            [
                "name" => 'Spain',
                "code" => 'ES',
                "locale" => 'en'
            ],
            [
                "name" => 'Sri Lanka',
                "code" => 'LK',
                "locale" => 'en'
            ],
            [
                "name" => 'Sudan',
                "code" => 'SD',
                "locale" => 'en'
            ],
            [
                "name" => 'Suriname',
                "code" => 'SR',
                "locale" => 'en'
            ],
            [
                "name" => 'Svalbard and Jan Mayen',
                "code" => 'SJ',
                "locale" => 'en'
            ],
            [
                "name" => 'Swaziland',
                "code" => 'SZ',
                "locale" => 'en'
            ],
            [
                "name" => 'Sweden',
                "code" => 'SE',
                "locale" => 'en'
            ],
            [
                "name" => 'Switzerland',
                "code" => 'CH',
                "locale" => 'en'
            ],
            [
                "name" => 'Syrian Arab Republic',
                "code" => 'SY',
                "locale" => 'en'
            ],
            [
                "name" => 'Taiwan, Province of China',
                "code" => 'TW',
                "locale" => 'en'
            ],
            [
                "name" => 'Tajikistan',
                "code" => 'TJ',
                "locale" => 'en'
            ],
            [
                "name" => 'Tanzania, United Republic of',
                "code" => 'TZ',
                "locale" => 'en'
            ],
            [
                "name" => 'Thailand',
                "code" => 'TH',
        "locale" => 'en'
            ],
            [
                "name" => 'Timor-Leste',
                "code" => 'TL',
                "locale" => 'en'
            ],
            [
                "name" => 'Togo',
                "code" => 'TG',
        "locale" => 'en'
            ],
            [
                "name" => 'Tokelau',
                "code" => 'TK',
                "locale" => 'en'
            ],
            [
                "name" => 'Tonga',
                "code" => 'TO',
                "locale" => 'en'
            ],
            [
                "name" => 'Trinidad and Tobago',
                "code" => 'TT',
                "locale" => 'en'
            ],
            [
                "name" => 'Tunisia',
                "code" => 'TN',
        "locale" => 'en'
            ],
            [
                "name" => 'Turkey',
                "code" => 'TR',
                "locale" => 'en'
            ],
            [
                "name" => 'Turkmenistan',
                "code" => 'TM',
                "locale" => 'en'
            ],
            [
                "name" => 'Turks and Caicos Islands',
                "code" => 'TC',
                "locale" => 'en'
            ],
            [
                "name" => 'Tuvalu',
                "code" => 'TV',
                "locale" => 'en'
            ],
            [
                "name" => 'Uganda',
                "code" => 'UG',
                "locale" => 'en'
            ],
            [
                "name" => 'Ukraine',
                "code" => 'UA',
                "locale" => 'en'
            ],
            [
                "name" => 'United Arab Emirates',
                "code" => 'AE',
                "locale" => 'en'
            ],
            [
                "name" => 'United Kingdom',
                "code" => 'GB',
                "locale" => 'en'
            ],
            [
                "name" => 'United States',
                "code" => 'US',
                "locale" => 'en'
            ],
            [
                "name" => 'United States Minor Outlying Islands',
                "code" => 'UM',
                "locale" => 'en'
            ],
            [
                "name" => 'Uruguay',
                "code" => 'UY',
                "locale" => 'en'
            ],
            [
                "name" => 'Uzbekistan',
                "code" => 'UZ',
                "locale" => 'en'
            ],
            [
                "name" => 'Vanuatu',
                "code" => 'VU',
                "locale" => 'en'
            ],
            [
                "name" => 'Venezuela',
                "code" => 'VE',
                "locale" => 'en'
            ],
            [
                "name" => 'Viet Nam',
                "code" => 'VN',
        "locale" => 'en'
            ],
            [
                "name" => 'Virgin Islands, British',
                "code" => 'VG',
                "locale" => 'en'
            ],
            [
                "name" => 'Virgin Islands, U.S.',
                "code" => 'VI',
                "locale" => 'en'
            ],
            [
                "name" => 'Wallis and Futuna',
                "code" => 'WF',
                "locale" => 'en'
            ],
            [
                "name" => 'Western Sahara',
                "code" => 'EH',
                "locale" => 'en'
            ],
            [
                "name" => 'Yemen',
                "code" => 'YE',
                "locale" => 'en'
            ],
            [
                "name" => 'Zambia',
                "code" => 'ZM',
                "locale" => 'en'
            ],
            [
                "name" => 'Zimbabwe',
                "code" => 'ZW',
                "locale" => 'en'
            ]
        ];
        Location::query()->insert($countries);

        DB::statement('alter sequence locations_id_seq restart with 244');
    }
}
