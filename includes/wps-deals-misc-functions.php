<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Misc Functions
 *
 * @package Social Deals Engine
 * @since 1.0.0
 *
 */  

	/**
	 * Get Currencies
	 *
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_currency_data() {
		 
		$currency_data = array(	
									'USD'	=>	__( 'US Dollars (&#36;)', 'wpsdeals' ),
									'GBP'	=>	__( 'Pounds Sterling (&pound;)', 'wpsdeals' ),
									'EUR'	=>	__( 'Euros (&euro;)', 'wpsdeals' ),
									'AUD' 	=> __('Australian Dollars (&#36;)', 'wpsdeals'),
									'BRL' 	=> __('Brazilian Real (R&#36;)', 'wpsdeals'),
									'CAD' 	=> __('Canadian Dollars (&#36;)', 'wpsdeals'),
									'CZK' 	=> __('Czech Koruna', 'wpsdeals'),
									'DKK'	=> __('Danish Krone', 'wpsdeals'),
									'HKD' 	=> __('Hong Kong Dollar (&#36;)', 'wpsdeals'),
									'HUF' 	=> __('Hungarian Forint', 'wpsdeals'),
									'ILS' 	=> __('Israeli Shekel', 'wpsdeals'),
									'JPY' 	=> __('Japanese Yen (&yen;)', 'wpsdeals'),
									'MYR' 	=> __('Malaysian Ringgits', 'wpsdeals'),
									'MXN' 	=> __('Mexican Peso (&#36;)', 'wpsdeals'),
									'NZD' 	=> __('New Zealand Dollar (&#36;)', 'wpsdeals'),
									'NOK' 	=> __('Norwegian Krone', 'wpsdeals'),
									'PHP' 	=> __('Philippine Pesos', 'wpsdeals'),
									'PLN' 	=> __('Polish Zloty', 'wpsdeals'),
									'SGD' 	=> __('Singapore Dollar (&#36;)', 'wpsdeals'),
									'SEK' 	=> __('Swedish Krona', 'wpsdeals'),
									'CHF' 	=> __('Swiss Franc', 'wpsdeals'),
									'TWD' 	=> __('Taiwan New Dollars', 'wpsdeals'),
									'THB' 	=> __('Thai Baht', 'wpsdeals'),
									'INR' 	=> __('Indian Rupee', 'wpsdeals'),
									'TRY' 	=> __('Turkish Lira', 'wpsdeals'),
									'RIAL' 	=> __('Iranian Rial', 'wpsdeals')
						  		 );
		return $currency_data;
	}

	/**
	 * Get Currencies
	 *
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_update_countries() {
	
		$countries = get_option('wps_deals_countries');
		
		if(empty($countries)) {
			//insert all countries
			$wps_deal_countries = array(
												'1'	=>	array(
																'country_code'	=>	'AX',
																'country_name'	=>	__('Aland Islands','wpsdeals')
																),
												'2'	=>	array(
																'country_code'	=>	'AL',
																'country_name'	=>	__('Albania','wpsdeals')
																),
												'3'	=>	array(
																'country_code'	=>	'DZ',
																'country_name'	=>	__('Algeria','wpsdeals')
																),
												'4'	=>	array(
																'country_code'	=>	'AS',
																'country_name'	=>	__('American Samoa','wpsdeals')
																),
												'5'	=>	array(
																'country_code'	=>	'AD',
																'country_name'	=>	__('Andorra','wpsdeals')
																),
												'6'	=>	array(
																'country_code'	=>	'AO',
																'country_name'	=>	__('Angola','wpsdeals')
																),
												'7'	=>	array(
																'country_code'	=>	'AI',
																'country_name'	=>	__('Anguilla','wpsdeals')
																),
												'8'	=>	array(
																'country_code'	=>	'AQ',
																'country_name'	=>	__('Antarctica','wpsdeals')
																),
												'9'	=>	array(
																'country_code'	=>	'AG',
																'country_name'	=>	__('Antigua and Barbuda','wpsdeals')
																),
												'10'	=>	array(
																'country_code'	=>	'AR',
																'country_name'	=>	__('Argentina','wpsdeals')
																),
												'11'	=>	array(
																'country_code'	=>	'AM',
																'country_name'	=>	__('Armenia','wpsdeals')
																),
												'12'	=>	array(
																'country_code'	=>	'AW',
																'country_name'	=>	__('Aruba','wpsdeals')
																),
												'13'	=>	array(
																'country_code'	=>	'AU',
																'country_name'	=>	__('Australia','wpsdeals')
																),
												'14'	=>	array(
																'country_code'	=>	'AT',
																'country_name'	=>	__('Austria','wpsdeals')
																),
												'15'	=>	array(
																'country_code'	=>	'AZ',
																'country_name'	=>	__('Azerbaijan','wpsdeals')
																),
												'16'	=>	array(
																'country_code'	=>	'BS',
																'country_name'	=>	__('Bahamas','wpsdeals')
																),
												'17'	=>	array(
																'country_code'	=>	'BH',
																'country_name'	=>	__('Bahrain','wpsdeals')
																),
												'18'	=>	array(
																'country_code'	=>	'BD',
																'country_name'	=>	__('Bangladesh','wpsdeals')
																),
												'19'	=>	array(
																'country_code'	=>	'BB',
																'country_name'	=>	__('Barbados','wpsdeals')
															),
											'20'	=>	array(
															'country_code'	=>	'BY',
															'country_name'	=>	__('Belarus','wpsdeals')
															),
											'21'	=>	array(
															'country_code'	=>	'BE',
															'country_name'	=>	__('Belgium','wpsdeals')
															),
											'22'	=>	array(
															'country_code'	=>	'BZ',
															'country_name'	=>	__('Belize','wpsdeals')
															),
											'23'	=>	array(
															'country_code'	=>	'BJ',
															'country_name'	=>	__('Benin','wpsdeals')
															),
											'24'	=>	array(
															'country_code'	=>	'BM',
															'country_name'	=>	__('Bermuda','wpsdeals')
															),
											'25'	=>	array(
															'country_code'	=>	'BT',
															'country_name'	=>	__('Bhutan','wpsdeals')
															),
											'26'	=>	array(
															'country_code'	=>	'BO',
															'country_name'	=>	__('Bolivia','wpsdeals')
															),
											'27'	=>	array(
															'country_code'	=>	'BA',
															'country_name'	=>	__('Bosnia and Herzegovina','wpsdeals')
															),
											'28'	=>	array(
															'country_code'	=>	'BW',
															'country_name'	=>	__('Botswana','wpsdeals')
															),
											'29'	=>	array(
															'country_code'	=>	'BV',
															'country_name'	=>	__('Bouvet Island','wpsdeals')
															),
											'30'	=>	array(
															'country_code'	=>	'BR',
															'country_name'	=>	__('Brazil','wpsdeals')
															),
											'31'	=>	array(
															'country_code'	=>	'IO',
															'country_name'	=>	__('British Indian Ocean Territory','wpsdeals')
															),
											'32'	=>	array(
															'country_code'	=>	'BN',
															'country_name'	=>	__('Brunei Darussalam','wpsdeals')
															),
											'33'	=>	array(
															'country_code'	=>	'BG',
															'country_name'	=>	__('Bulgaria','wpsdeals')
															),
											'34'	=>	array(
															'country_code'	=>	'BF',
															'country_name'	=>	__('Burkina Faso','wpsdeals')
															),
											'35'	=>	array(
															'country_code'	=>	'BI',
															'country_name'	=>	__('Burundi','wpsdeals')
															),
											'36'	=>	array(
															'country_code'	=>	'KH',
															'country_name'	=>	__('Cambodia','wpsdeals')
															),
											'37'	=>	array(
															'country_code'	=>	'CM',
															'country_name'	=>	__('Cameroon','wpsdeals')
															),
											'38'	=>	array(
															'country_code'	=>	'CA',
															'country_name'	=>	__('Canada','wpsdeals')
															),
											'39'	=>	array(
															'country_code'	=>	'CV',
															'country_name'	=>	__('Cape Verde','wpsdeals')
															),
											'40'	=>	array(
															'country_code'	=>	'KY',
															'country_name'	=>	__('Cayman Islands','wpsdeals')
															),
											'41'	=>	array(
															'country_code'	=>	'CF',
															'country_name'	=>	__('Central African Republic','wpsdeals')
															),
											'42'	=>	array(
															'country_code'	=>	'TD',
															'country_name'	=>	__('Chad','wpsdeals')
															),
											'43'	=>	array(
															'country_code'	=>	'CL',
															'country_name'	=>	__('Chile','wpsdeals')
															),
											'44'	=>	array(
															'country_code'	=>	'CN',
															'country_name'	=>	__('China','wpsdeals')
															),
											'45'	=>	array(
															'country_code'	=>	'CX',
															'country_name'	=>	__('Christmas Island','wpsdeals')
															),
											'46'	=>	array(
															'country_code'	=>	'CC',
															'country_name'	=>	__('Cocos (Keeling), Islands','wpsdeals')
															),
											'47'	=>	array(
															'country_code'	=>	'CO',
															'country_name'	=>	__('Colombia','wpsdeals')
															),
											'48'	=>	array(
															'country_code'	=>	'KM',
															'country_name'	=>	__('Comoros','wpsdeals')
															),
											'49'	=>	array(
															'country_code'	=>	'CG',
															'country_name'	=>	__('Congo','wpsdeals')
															),
											'50'	=>	array(
															'country_code'	=>	'CD',
															'country_name'	=>	__('Congo, The Democratic Republic of the','wpsdeals')
															),
											'51'	=>	array(
															'country_code'	=>	'CK',
															'country_name'	=>	__('Cook Islands','wpsdeals')
															),
											'52'	=>	array(
															'country_code'	=>	'CR',
															'country_name'	=>	__('Costa Rica','wpsdeals')
															),
											'53'	=>	array(
															'country_code'	=>	'CI',
															'country_name'	=>	__('Cote D\'Ivoire','wpsdeals')
															),
											'54'	=>	array(
															'country_code'	=>	'HR',
															'country_name'	=>	__('Croatia','wpsdeals')
															),
											'55'	=>	array(
															'country_code'	=>	'CU',
															'country_name'	=>	__('Cuba','wpsdeals')
															),
											'56'	=>	array(
															'country_code'	=>	'CY',
															'country_name'	=>	__('Cyprus','wpsdeals')
															),
											'57'	=>	array(
															'country_code'	=>	'CZ',
															'country_name'	=>	__('Czech Republic','wpsdeals')
															),
											'58'	=>	array(
															'country_code'	=>	'DK',
															'country_name'	=>	__('Denmark','wpsdeals')
															),
											'59'	=>	array(
															'country_code'	=>	'DJ',
															'country_name'	=>	__('Djibouti','wpsdeals')
															),
											'60'	=>	array(
															'country_code'	=>	'DM',
															'country_name'	=>	__('Dominica','wpsdeals')
															),
											'61'	=>	array(
															'country_code'	=>	'DO',
															'country_name'	=>	__('Dominican Republic','wpsdeals')
															),
											'62'	=>	array(
															'country_code'	=>	'EC',
															'country_name'	=>	__('Ecuador','wpsdeals')
															),
											'63'	=>	array(
															'country_code'	=>	'EG',
															'country_name'	=>	__('Egypt','wpsdeals')
															),
											'64'	=>	array(
															'country_code'	=>	'SV',
															'country_name'	=>	__('El Salvador','wpsdeals')
															),
											'65'	=>	array(
															'country_code'	=>	'GQ',
															'country_name'	=>	__('Equatorial Guinea','wpsdeals')
															),
											'66'	=>	array(
															'country_code'	=>	'ER',
															'country_name'	=>	__('Eritrea','wpsdeals')
															),
											'67'	=>	array(
															'country_code'	=>	'EE',
															'country_name'	=>	__('Estonia','wpsdeals')
															),
											'68'	=>	array(
															'country_code'	=>	'ET',
															'country_name'	=>	__('Ethiopia','wpsdeals')
															),
											'69'	=>	array(
															'country_code'	=>	'FK',
															'country_name'	=>	__('Falkland Islands (Malvinas)','wpsdeals')
															),
											'70'	=>	array(
															'country_code'	=>	'FO',
															'country_name'	=>	__('Faroe Islands','wpsdeals')
															),
											'71'	=>	array(
															'country_code'	=>	'FJ',
															'country_name'	=>	__('Fiji','wpsdeals')
															),
											'72'	=>	array(
															'country_code'	=>	'FI',
															'country_name'	=>	__('Finland','wpsdeals')
															),
											'73'	=>	array(
															'country_code'	=>	'FR',
															'country_name'	=>	__('France','wpsdeals')
															),
											'74'	=>	array(
															'country_code'	=>	'GF',
															'country_name'	=>	__('French Guiana','wpsdeals')
															),
											'75'	=>	array(
															'country_code'	=>	'PF',
															'country_name'	=>	__('French Polynesia','wpsdeals')
															),
											'76'	=>	array(
															'country_code'	=>	'TF',
															'country_name'	=>	__('French Southern Territories','wpsdeals')
															),
											'77'	=>	array(
															'country_code'	=>	'GA',
															'country_name'	=>	__('Gabon','wpsdeals')
															),
											'78'	=>	array(
															'country_code'	=>	'GM',
															'country_name'	=>	__('Gambia','wpsdeals')
															),
											'79'	=>	array(
															'country_code'	=>	'GE',
															'country_name'	=>	__('Georgia','wpsdeals')
															),
											'80'	=>	array(
															'country_code'	=>	'DE',
															'country_name'	=>	__('Germany','wpsdeals')
															),
											'81'	=>	array(
															'country_code'	=>	'GH',
															'country_name'	=>	__('Ghana','wpsdeals')
															),
											'82'	=>	array(
															'country_code'	=>	'GI',
															'country_name'	=>	__('Gibraltar','wpsdeals')
															),
											'83'	=>	array(
															'country_code'	=>	'GR',
															'country_name'	=>	__('Greece','wpsdeals')
															),
											'84'	=>	array(
															'country_code'	=>	'GL',
															'country_name'	=>	__('Greenland','wpsdeals')
															),
											'85'	=>	array(
															'country_code'	=>	'GD',
															'country_name'	=>	__('Grenada','wpsdeals')
															),
											'86'	=>	array(
															'country_code'	=>	'GP',
															'country_name'	=>	__('Guadeloupe','wpsdeals')
															),
											'87'	=>	array(
															'country_code'	=>	'GU',
															'country_name'	=>	__('Guam','wpsdeals')
															),
											'88'	=>	array(
															'country_code'	=>	'GT',
															'country_name'	=>	__('Guatemala','wpsdeals')
															),
											'89'	=>	array(
															'country_code'	=>	'GG',
															'country_name'	=>	__('Guernsey','wpsdeals')
															),
											'90'	=>	array(
															'country_code'	=>	'GN',
															'country_name'	=>	__('Guinea','wpsdeals')
															),
											'91'	=>	array(
															'country_code'	=>	'GW',
															'country_name'	=>	__('Guinea-Bissau','wpsdeals')
															),
											'92'	=>	array(
															'country_code'	=>	'GY',
															'country_name'	=>	__('Guyana','wpsdeals')
															),
											'93'	=>	array(
															'country_code'	=>	'HT',
															'country_name'	=>	__('Haiti','wpsdeals')
															),
											'94'	=>	array(
															'country_code'	=>	'HM',
															'country_name'	=>	__('Heard Island and McDonald Islands','wpsdeals')
															),
											'95'	=>	array(
															'country_code'	=>	'VA',
															'country_name'	=>	__('Holy See (Vatican City State)','wpsdeals')
															),
											'96'	=>	array(
															'country_code'	=>	'HN',
															'country_name'	=>	__('Honduras','wpsdeals')
															),
											'97'	=>	array(
															'country_code'	=>	'HK',
															'country_name'	=>	__('Hong Kong','wpsdeals')
															),
											'98'	=>	array(
															'country_code'	=>	'HU',
															'country_name'	=>	__('Hungary','wpsdeals')
															),
											'99'	=>	array(
															'country_code'	=>	'IS',
															'country_name'	=>	__('Iceland','wpsdeals')
															),
											'100'	=>	array(
															'country_code'	=>	'IN',
															'country_name'	=>	__('India','wpsdeals')
															),
											'101'	=>	array(
															'country_code'	=>	'ID',
															'country_name'	=>	__('Indonesia','wpsdeals')
															),
											'102'	=>	array(
															'country_code'	=>	'IR',
															'country_name'	=>	__('Iran, Islamic Republic of','wpsdeals')
															),
											'103'	=>	array(
															'country_code'	=>	'IQ',
															'country_name'	=>	__('Iraq','wpsdeals')
															),
											'104'	=>	array(
															'country_code'	=>	'IE',
															'country_name'	=>	__('Ireland','wpsdeals')
															),
											'105'	=>	array(
															'country_code'	=>	'IM',
															'country_name'	=>	__('Isle of Man','wpsdeals')
															),
											'100'	=>	array(
															'country_code'	=>	'IN',
															'country_name'	=>	__('India','wpsdeals')
															),
											'106'	=>	array(
															'country_code'	=>	'IL',
															'country_name'	=>	__('Israel','wpsdeals')
															),
											'107'	=>	array(
															'country_code'	=>	'IT',
															'country_name'	=>	__('Italy','wpsdeals')
															),
											'108'	=>	array(
															'country_code'	=>	'JM',
															'country_name'	=>	__('Jamaica','wpsdeals')
															),
											'109'	=>	array(
															'country_code'	=>	'JP',
															'country_name'	=>	__('Japan','wpsdeals')
															),
											'110'	=>	array(
															'country_code'	=>	'JE',
															'country_name'	=>	__('Jersey','wpsdeals')
															),
											'111'	=>	array(
															'country_code'	=>	'JO',
															'country_name'	=>	__('Jordan','wpsdeals')
															),
											'112'	=>	array(
															'country_code'	=>	'KZ',
															'country_name'	=>	__('Kazakhstan','wpsdeals')
															),
											'113'	=>	array(
															'country_code'	=>	'KE',
															'country_name'	=>	__('Kenya','wpsdeals')
															),
											'114'	=>	array(
															'country_code'	=>	'KI',
															'country_name'	=>	__('Kiribati','wpsdeals')
															),
											'115'	=>	array(
															'country_code'	=>	'KP',
															'country_name'	=>	__('Korea, Democratic People\'s Republic of','wpsdeals')
															),
											'116'	=>	array(
															'country_code'	=>	'KR',
															'country_name'	=>	__('Korea, Republic of','wpsdeals')
															),
											'117'	=>	array(
															'country_code'	=>	'KW',
															'country_name'	=>	__('Kuwait','wpsdeals')
															),
											'118'	=>	array(
															'country_code'	=>	'KG',
															'country_name'	=>	__('Kyrgyzstan','wpsdeals')
															),
											'119'	=>	array(
															'country_code'	=>	'LA',
															'country_name'	=>	__('Lao People\'s Democratic Republic','wpsdeals')
															),
											'120'	=>	array(
															'country_code'	=>	'LV',
															'country_name'	=>	__('Latvia','wpsdeals')
															),
											'121'	=>	array(
															'country_code'	=>	'LB',
															'country_name'	=>	__('Lebanon','wpsdeals')
															),
											'122'	=>	array(
															'country_code'	=>	'LS',
															'country_name'	=>	__('Lesotho','wpsdeals')
															),
											'123'	=>	array(
															'country_code'	=>	'LR',
															'country_name'	=>	__('Liberia','wpsdeals')
															),
											'124'	=>	array(
															'country_code'	=>	'LY',
															'country_name'	=>	__('Libyan Arab Jamahiriya','wpsdeals')
															),
											'125'	=>	array(
															'country_code'	=>	'LI',
															'country_name'	=>	__('Liechtenstein','wpsdeals')
															),
											'126'	=>	array(
															'country_code'	=>	'LT',
															'country_name'	=>	__('Lithuania','wpsdeals')
															),
											'127'	=>	array(
															'country_code'	=>	'LU',
															'country_name'	=>	__('Luxembourg','wpsdeals')
															),
											'128'	=>	array(
															'country_code'	=>	'MO',
															'country_name'	=>	__('Macao','wpsdeals')
															),
											'129'	=>	array(
															'country_code'	=>	'MK',
															'country_name'	=>	__('Macedonia, The Former Yugoslav Republic of','wpsdeals')
															),
											'130'	=>	array(
															'country_code'	=>	'MG',
															'country_name'	=>	__('Madagascar','wpsdeals')
															),
											'131'	=>	array(
															'country_code'	=>	'MW',
															'country_name'	=>	__('Malawi','wpsdeals')
															),
											'132'	=>	array(
															'country_code'	=>	'MY',
															'country_name'	=>	__('Malaysia','wpsdeals')
															),
											'133'	=>	array(
															'country_code'	=>	'MV',
															'country_name'	=>	__('Maldives','wpsdeals')
															),
											'134'	=>	array(
															'country_code'	=>	'ML',
															'country_name'	=>	__('Mali','wpsdeals')
															),
											'135'	=>	array(
															'country_code'	=>	'MT',
															'country_name'	=>	__('Malta','wpsdeals')
															),
											'136'	=>	array(
															'country_code'	=>	'MH',
															'country_name'	=>	__('Marshall Islands','wpsdeals')
															),
											'137'	=>	array(
															'country_code'	=>	'MQ',
															'country_name'	=>	__('Martinique','wpsdeals')
															),
											'138'	=>	array(
															'country_code'	=>	'MR',
															'country_name'	=>	__('Mauritania','wpsdeals')
															),
											'139'	=>	array(
															'country_code'	=>	'MU',
															'country_name'	=>	__('Mauritius','wpsdeals')
															),
											'140'	=>	array(
															'country_code'	=>	'YT',
															'country_name'	=>	__('Mayotte','wpsdeals')
															),
											'141'	=>	array(
															'country_code'	=>	'MX',
															'country_name'	=>	__('Mexico','wpsdeals')
															),
											'142'	=>	array(
															'country_code'	=>	'FM',
															'country_name'	=>	__('Micronesia, Federated States of','wpsdeals')
															),
											'143'	=>	array(
															'country_code'	=>	'MD',
															'country_name'	=>	__('Moldova, Republic of','wpsdeals')
															),
											'144'	=>	array(
															'country_code'	=>	'MC',
															'country_name'	=>	__('Monaco','wpsdeals')
															),
											'145'	=>	array(
															'country_code'	=>	'MN',
															'country_name'	=>	__('Mongolia','wpsdeals')
															),
											'146'	=>	array(
															'country_code'	=>	'ME',
															'country_name'	=>	__('Montenegro','wpsdeals')
															),
											'147'	=>	array(
															'country_code'	=>	'MS',
															'country_name'	=>	__('Montserrat','wpsdeals')
															),
											'148'	=>	array(
															'country_code'	=>	'MA',
															'country_name'	=>	__('Morocco','wpsdeals')
															),
											'149'	=>	array(
															'country_code'	=>	'MZ',
															'country_name'	=>	__('Mozambique','wpsdeals')
															),
											'150'	=>	array(
															'country_code'	=>	'MM',
															'country_name'	=>	__('Myanmar','wpsdeals')
															),
											'151'	=>	array(
															'country_code'	=>	'NA',
															'country_name'	=>	__('Namibia','wpsdeals')
															),
											'152'	=>	array(
															'country_code'	=>	'NR',
															'country_name'	=>	__('Nauru','wpsdeals')
															),
											'153'	=>	array(
															'country_code'	=>	'NP',
															'country_name'	=>	__('Nepal','wpsdeals')
															),
											'154'	=>	array(
															'country_code'	=>	'NL',
															'country_name'	=>	__('Netherlands','wpsdeals')
															),
											'155'	=>	array(
															'country_code'	=>	'AN',
															'country_name'	=>	__('Netherlands Antilles','wpsdeals')
															),
											'156'	=>	array(
															'country_code'	=>	'NC',
															'country_name'	=>	__('New Caledonia','wpsdeals')
															),
											'157'	=>	array(
															'country_code'	=>	'NZ',
															'country_name'	=>	__('New Zealand','wpsdeals')
															),
											'158'	=>	array(
															'country_code'	=>	'NI',
															'country_name'	=>	__('Nicaragua','wpsdeals')
															),
											'159'	=>	array(
															'country_code'	=>	'NE',
															'country_name'	=>	__('Niger','wpsdeals')
															),
											'160'	=>	array(
															'country_code'	=>	'NG',
															'country_name'	=>	__('Nigeria','wpsdeals')
															),
											'161'	=>	array(
															'country_code'	=>	'NU',
															'country_name'	=>	__('Niue','wpsdeals')
															),
											'162'	=>	array(
															'country_code'	=>	'NF',
															'country_name'	=>	__('Norfolk Island','wpsdeals')
															),
											'163'	=>	array(
															'country_code'	=>	'MP',
															'country_name'	=>	__('Northern Mariana Islands','wpsdeals')
															),
											'164'	=>	array(
															'country_code'	=>	'NO',
															'country_name'	=>	__('Norway','wpsdeals')
															),
											'165'	=>	array(
															'country_code'	=>	'OM',
															'country_name'	=>	__('Oman','wpsdeals')
															),
											'166'	=>	array(
															'country_code'	=>	'PK',
															'country_name'	=>	__('Pakistan','wpsdeals')
															),
											'167'	=>	array(
															'country_code'	=>	'PW',
															'country_name'	=>	__('Palau','wpsdeals')
															),
											'168'	=>	array(
															'country_code'	=>	'PS',
															'country_name'	=>	__('Palestinian Territory, Occupied','wpsdeals')
															),
											'169'	=>	array(
															'country_code'	=>	'PA',
															'country_name'	=>	__('Panama','wpsdeals')
															),
											'170'	=>	array(
															'country_code'	=>	'PG',
															'country_name'	=>	__('Papua New Guinea','wpsdeals')
															),
											'171'	=>	array(
															'country_code'	=>	'PY',
															'country_name'	=>	__('Paraguay','wpsdeals')
															),
											'172'	=>	array(
															'country_code'	=>	'PE',
															'country_name'	=>	__('Peru','wpsdeals')
															),
											'173'	=>	array(
															'country_code'	=>	'PH',
															'country_name'	=>	__('Philippines','wpsdeals')
															),
											'174'	=>	array(
															'country_code'	=>	'PN',
															'country_name'	=>	__('Pitcairn','wpsdeals')
															),
											'175'	=>	array(
															'country_code'	=>	'PL',
															'country_name'	=>	__('Poland','wpsdeals')
															),
											'176'	=>	array(
															'country_code'	=>	'PT',
															'country_name'	=>	__('Portugal','wpsdeals')
															),
											'177'	=>	array(
															'country_code'	=>	'PR',
															'country_name'	=>	__('Puerto Rico','wpsdeals')
															),
											'178'	=>	array(
															'country_code'	=>	'QA',
															'country_name'	=>	__('Qatar','wpsdeals')
															),
											'179'	=>	array(
															'country_code'	=>	'RE',
															'country_name'	=>	__('Reunion','wpsdeals')
															),
											'180'	=>	array(
															'country_code'	=>	'RO',
															'country_name'	=>	__('Romania','wpsdeals')
															),
											'181'	=>	array(
															'country_code'	=>	'RU',
															'country_name'	=>	__('Russian Federation','wpsdeals')
															),
											'182'	=>	array(
															'country_code'	=>	'RW',
															'country_name'	=>	__('Rwanda','wpsdeals')
															),
											'183'	=>	array(
															'country_code'	=>	'BL',
															'country_name'	=>	__('Saint Barthelemy','wpsdeals')
															),
											'184'	=>	array(
															'country_code'	=>	'SH',
															'country_name'	=>	__('Saint Helena','wpsdeals')
															),
											'185'	=>	array(
															'country_code'	=>	'KN',
															'country_name'	=>	__('Saint Kitts and Nevis','wpsdeals')
															),
											'186'	=>	array(
															'country_code'	=>	'LC',
															'country_name'	=>	__('Saint Lucia','wpsdeals')
															),
											'187'	=>	array(
															'country_code'	=>	'MF',
															'country_name'	=>	__('Saint Martin','wpsdeals')
															),
											'188'	=>	array(
															'country_code'	=>	'PM',
															'country_name'	=>	__('Saint Pierre and Miquelon','wpsdeals')
															),
											'189'	=>	array(
															'country_code'	=>	'VC',
															'country_name'	=>	__('Saint Vincent and the Grenadines','wpsdeals')
															),
											'190'	=>	array(
															'country_code'	=>	'WS',
															'country_name'	=>	__('Samoa','wpsdeals')
															),
											'191'	=>	array(
															'country_code'	=>	'SM',
															'country_name'	=>	__('San Marino','wpsdeals')
															),
											'192'	=>	array(
															'country_code'	=>	'ST',
															'country_name'	=>	__('Sao Tome and Principe','wpsdeals')
															),
											'193'	=>	array(
															'country_code'	=>	'SA',
															'country_name'	=>	__('Saudi Arabia','wpsdeals')
															),
											'194'	=>	array(
															'country_code'	=>	'SN',
															'country_name'	=>	__('Senegal','wpsdeals')
															),
											'195'	=>	array(
															'country_code'	=>	'RS',
															'country_name'	=>	__('Serbia','wpsdeals')
															),
											'196'	=>	array(
															'country_code'	=>	'SC',
															'country_name'	=>	__('Seychelles','wpsdeals')
															),
											'197'	=>	array(
															'country_code'	=>	'SL',
															'country_name'	=>	__('Sierra Leone','wpsdeals')
															),
											'198'	=>	array(
															'country_code'	=>	'SG',
															'country_name'	=>	__('Singapore','wpsdeals')
															),
											'199'	=>	array(
															'country_code'	=>	'SK',
															'country_name'	=>	__('Slovakia','wpsdeals')
															),
											'200'	=>	array(
															'country_code'	=>	'SI',
															'country_name'	=>	__('Slovenia','wpsdeals')
															),
											'201'	=>	array(
															'country_code'	=>	'SB',
															'country_name'	=>	__('Solomon Islands','wpsdeals')
															),
											'202'	=>	array(
															'country_code'	=>	'SO',
															'country_name'	=>	__('Somalia','wpsdeals')
															),
											'203'	=>	array(
															'country_code'	=>	'ZA',
															'country_name'	=>	__('South Africa','wpsdeals')
															),
											'204'	=>	array(
															'country_code'	=>	'GS',
															'country_name'	=>	__('South Georgia and the South Sandwich Islands','wpsdeals')
															),
											'205'	=>	array(
															'country_code'	=>	'ES',
															'country_name'	=>	__('Spain','wpsdeals')
															),
											'206'	=>	array(
															'country_code'	=>	'LK',
															'country_name'	=>	__('Sri Lanka','wpsdeals')
															),
											'207'	=>	array(
															'country_code'	=>	'SD',
															'country_name'	=>	__('Sudan','wpsdeals')
															),
											'208'	=>	array(
															'country_code'	=>	'SR',
															'country_name'	=>	__('Suriname','wpsdeals')
															),
											'209'	=>	array(
															'country_code'	=>	'SJ',
															'country_name'	=>	__('Svalbard and Jan Mayen','wpsdeals')
															),
											'210'	=>	array(
															'country_code'	=>	'SZ',
															'country_name'	=>	__('Swaziland','wpsdeals')
															),
											'211'	=>	array(
															'country_code'	=>	'SE',
															'country_name'	=>	__('Sweden','wpsdeals')
															),
											'212'	=>	array(
															'country_code'	=>	'CH',
															'country_name'	=>	__('Switzerland','wpsdeals')
															),
											'213'	=>	array(
															'country_code'	=>	'SY',
															'country_name'	=>	__('Syrian Arab Republic','wpsdeals')
															),
											'214'	=>	array(
															'country_code'	=>	'TW',
															'country_name'	=>	__('Taiwan, Province Of China','wpsdeals')
															),
											'215'	=>	array(
															'country_code'	=>	'TJ',
															'country_name'	=>	__('Tajikistan','wpsdeals')
															),
											'216'	=>	array(
															'country_code'	=>	'TZ',
															'country_name'	=>	__('Tanzania, United Republic of','wpsdeals')
															),
											'217'	=>	array(
															'country_code'	=>	'TH',
															'country_name'	=>	__('Thailand','wpsdeals')
															),
											'218'	=>	array(
															'country_code'	=>	'TL',
															'country_name'	=>	__('Timor-Leste','wpsdeals')
															),
											'219'	=>	array(
															'country_code'	=>	'TG',
															'country_name'	=>	__('Togo','wpsdeals')
															),
											'220'	=>	array(
															'country_code'	=>	'TK',
															'country_name'	=>	__('Tokelau','wpsdeals')
															),
											'221'	=>	array(
															'country_code'	=>	'TO',
															'country_name'	=>	__('Tonga','wpsdeals')
															),
											'222'	=>	array(
															'country_code'	=>	'TT',
															'country_name'	=>	__('Trinidad and Tobago','wpsdeals')
															),
											'223'	=>	array(
															'country_code'	=>	'TN',
															'country_name'	=>	__('Tunisia','wpsdeals')
															),
											'224'	=>	array(
															'country_code'	=>	'TR',
															'country_name'	=>	__('Turkey','wpsdeals')
															),
											'225'	=>	array(
															'country_code'	=>	'TM',
															'country_name'	=>	__('Turkmenistan','wpsdeals')
															),
											'226'	=>	array(
															'country_code'	=>	'TC',
															'country_name'	=>	__('Turks and Caicos Islands','wpsdeals')
															),
											'227'	=>	array(
															'country_code'	=>	'TV',
															'country_name'	=>	__('Tuvalu','wpsdeals')
															),
											'228'	=>	array(
															'country_code'	=>	'UG',
															'country_name'	=>	__('Uganda','wpsdeals')
															),
											'229'	=>	array(
															'country_code'	=>	'UA',
															'country_name'	=>	__('Ukraine','wpsdeals')
															),
											'230'	=>	array(
															'country_code'	=>	'AE',
															'country_name'	=>	__('United Arab Emirates','wpsdeals')
															),
											'231'	=>	array(
															'country_code'	=>	'GB',
															'country_name'	=>	__('United Kingdom','wpsdeals')
															),
											'232'	=>	array(
															'country_code'	=>	'US',
															'country_name'	=>	__('United States','wpsdeals')
															),
											'233'	=>	array(
															'country_code'	=>	'UM',
															'country_name'	=>	__('United States Minor Outlying Islands','wpsdeals')
															),
											'234'	=>	array(
															'country_code'	=>	'UY',
															'country_name'	=>	__('Uruguay','wpsdeals')
															),
											'235'	=>	array(
															'country_code'	=>	'UZ',
															'country_name'	=>	__('Uzbekistan','wpsdeals')
															),
											'236'	=>	array(
															'country_code'	=>	'VU',
															'country_name'	=>	__('Vanuatu','wpsdeals')
															),
											'237'	=>	array(
															'country_code'	=>	'VE',
															'country_name'	=>	__('Venezuela','wpsdeals')
															),
											'238'	=>	array(
															'country_code'	=>	'VN',
															'country_name'	=>	__('Viet Nam','wpsdeals')
															),
											'239'	=>	array(
															'country_code'	=>	'VG',
															'country_name'	=>	__('Virgin Islands, British','wpsdeals')
															),
											'240'	=>	array(
															'country_code'	=>	'VI',
															'country_name'	=>	__('Virgin Islands, U.S.','wpsdeals')
															),
											'241'	=>	array(
															'country_code'	=>	'WF',
															'country_name'	=>	__('Wallis And Futuna','wpsdeals')
															),
											'242'	=>	array(
															'country_code'	=>	'EH',
															'country_name'	=>	__('Western Sahara','wpsdeals')
															),
											'243'	=>	array(
															'country_code'	=>	'YE',
															'country_name'	=>	__('Yemen','wpsdeals')
															),
											'244'	=>	array(
															'country_code'	=>	'ZM',
															'country_name'	=>	__('Zambia','wpsdeals')
															),
											'245'	=>	array(
															'country_code'	=>	'ZW',
															'country_name'	=>	__('Zimbabwe','wpsdeals')
															)
										);
		//store all countries to option
		update_option('wps_deals_countries',serialize($wps_deal_countries));
		}
	}
	/**
	 * Get all countries list
	 * 
	 * Handles to return all contries list
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_get_country_list() { 
		
		$countries = get_option('wps_deals_countries');
		if(!empty($countries)) {
			$countries = unserialize($countries);
		} else {
			$countries = array();
		}
		return $countries;
	}
	/**
	 * Initialize some needed variables
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_initialize() {
		
		global $wps_deals_model,$wps_deals_options;
		
		//facebook app data
		$fb_app_id = isset( $wps_deals_options['fb_app_id'] ) ? $wps_deals_options['fb_app_id'] : '';
		$fb_app_secret = isset( $wps_deals_options['fb_app_secret'] ) ? $wps_deals_options['fb_app_secret'] : '';
		
		//googleplus app data
		$gp_client_id = isset( $wps_deals_options['gplus_client_id'] ) ? $wps_deals_options['gplus_client_id'] : '';
		$gp_client_secret = isset( $wps_deals_options['gplus_client_secret'] ) ? $wps_deals_options['gplus_client_secret'] : '';
		
		//twitter app data
		$tw_consumer_key = isset( $wps_deals_options['tw_consumer_key'] ) ? $wps_deals_options['tw_consumer_key'] : '';
		$tw_consumer_secrets = isset( $wps_deals_options['tw_consumer_secrets'] ) ? $wps_deals_options['tw_consumer_secrets'] : '';
		
		//linkedin app data
		$li_client_id = isset( $wps_deals_options['li_app_id'] ) ? $wps_deals_options['li_app_id'] : '';
		$li_client_secret = isset( $wps_deals_options['li_app_secret'] ) ? $wps_deals_options['li_app_secret'] : '';
		
		//yahoo app data
		$yh_consumer_key = isset( $wps_deals_options['yh_consumer_key'] ) ? $wps_deals_options['yh_consumer_key'] : '';
		$yh_consumer_secrets = isset( $wps_deals_options['yh_consumer_secrets'] ) ? $wps_deals_options['yh_consumer_secrets'] : '';
		$yh_app_id = isset( $wps_deals_options['yh_app_id'] ) ? $wps_deals_options['yh_app_id'] : '';
		
		//foursquare app data
		$fs_client_id = isset( $wps_deals_options['fs_client_id'] ) ? $wps_deals_options['fs_client_id'] : '';
		$fs_client_secrets = isset( $wps_deals_options['fs_client_secrets'] ) ? $wps_deals_options['fs_client_secrets'] : '';
		
		//windowslive app data
		$wl_client_id = isset( $wps_deals_options['wl_client_id'] ) ? $wps_deals_options['wl_client_id'] : '';
		$wl_client_secrets = isset( $wps_deals_options['wl_client_secrets'] ) ? $wps_deals_options['wl_client_secrets'] : '';
			
		$paypalapiuser = isset( $wps_deals_options['paypal_api_user'] ) ? $wps_deals_options['paypal_api_user'] : '';
		$paypalapipass = isset( $wps_deals_options['paypal_api_pass'] ) ? $wps_deals_options['paypal_api_pass'] : '';
		$paypalapisign = isset( $wps_deals_options['paypal_api_sign'] ) ? $wps_deals_options['paypal_api_sign'] : '';
			
		if(isset($wps_deals_options['enable_testmode']) && !empty($wps_deals_options['enable_testmode'])) {
			$paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
			$paypalrefundurl = 'https://api-3t.sandbox.paypal.com/nvp';
		} else {
			$paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
			$paypalrefundurl = 'https://api-3t.paypal.com/nvp';
		}
		
		//if(isset($wps_deals_options['buyer_email_subject']) && !empty($wps_deals_options['buyer_email_subject'])) { //check user email subject
			$buyer_email_subject = isset($wps_deals_options['buyer_email_subject']) ? $wps_deals_options['buyer_email_subject'] : '';
		/*} else {
			$buyer_email_subject = __( 'Purchase Receipt', 'wpsdeals' );
		}*/
		//if(isset($wps_deals_options['seller_email_subject']) && !empty($wps_deals_options['seller_email_subject'])) { //check admin email subject
			$seller_email_subject = isset($wps_deals_options['seller_email_subject']) ? $wps_deals_options['seller_email_subject'] : '';
		//} else {
		//	$seller_email_subject = __( 'New Deal Purchase', 'wpsdeals' );
		//}
		
		if(!defined( 'WPS_DEALS_PAYPAL_URL' )) { //check paypal url is set or not
			define( 'WPS_DEALS_PAYPAL_URL', $paypal_url );
		}
		
		if( !defined( 'WPS_DEALS_BUYER_EMAIL_SUBJECT' )) {
			define( 'WPS_DEALS_BUYER_EMAIL_SUBJECT',$buyer_email_subject ); // buyer email subject
		}
		if( !defined( 'WPS_DEALS_SELLER_EMAIL_SUBJECT' )) {
			define( 'WPS_DEALS_SELLER_EMAIL_SUBJECT',$seller_email_subject ); // seller email subject
		}
		
		
		if( !defined( 'WPS_DEALS_PAYPAL_API_USERNAME' )) {
			define( 'WPS_DEALS_PAYPAL_API_USERNAME', $paypalapiuser ); //paypal api username
		}
		if( !defined( 'WPS_DEALS_PAYPAL_API_PASSWORD' )) {
			define( 'WPS_DEALS_PAYPAL_API_PASSWORD', $paypalapipass ); //paypal api password
		}
		if( !defined( 'WPS_DEALS_PAYPAL_API_SIGNATURE' )) {
			define( 'WPS_DEALS_PAYPAL_API_SIGNATURE', $paypalapisign ); //paypal api signature
		}
		if( !defined( 'WPS_DEALS_PAYPAL_REFUND_URL') ) {
			define('WPS_DEALS_PAYPAL_REFUND_URL',$paypalrefundurl ); //paypal refund url
		}
		/**
		# Version: this is the API version in the request.
		# It is a mandatory parameter for each API request.
		# The only supported value at this time is 2.3
		*/
		if( !defined( 'WPS_DEALS_PAYPAL_REFUND_VERSION') ) {
			define( 'WPS_DEALS_PAYPAL_REFUND_VERSION', '65.1' );
		}
		
		/**
		 * Social Media Application Settings
		 */
		if( !defined( 'WPS_DEALS_FB_APP_ID' ) ){
			define( 'WPS_DEALS_FB_APP_ID', $fb_app_id );
		}
		if( !defined( 'WPS_DEALS_FB_APP_SECRET' ) ){
			define( 'WPS_DEALS_FB_APP_SECRET', $fb_app_secret );
		}
		
		//For GooglePlus Data
		if( !defined( 'WPS_DEALS_GP_CLIENT_ID' ) ){
			define( 'WPS_DEALS_GP_CLIENT_ID', $gp_client_id );
		}
		if( !defined( 'WPS_DEALS_GP_CLIENT_SECRET' ) ){
			define( 'WPS_DEALS_GP_CLIENT_SECRET', $gp_client_secret );
		}
		if( !defined( 'WPS_DEALS_GP_REDIRECT_URL' ) ) {
			$googleurl = add_query_arg( 'wpsocialdeals', 'google', site_url() );
			define( 'WPS_DEALS_GP_REDIRECT_URL', $googleurl );
		}
		//For Twitter Data
		if( !defined( 'WPS_DEALS_TW_CONSUMER_KEY' ) ) {
			define( 'WPS_DEALS_TW_CONSUMER_KEY', $tw_consumer_key );
		}
		if( !defined( 'WPS_DEALS_TW_CONSUMER_SECRET' ) ) {
			define( 'WPS_DEALS_TW_CONSUMER_SECRET', $tw_consumer_secrets );
		}
		//For Linkedin data
		if( !defined( 'WPS_DEALS_LI_APP_ID' ) ) {	
			define( 'WPS_DEALS_LI_APP_ID', $li_client_id );	
		}
		if( !defined( 'WPS_DEALS_LI_APP_SECRET' ) ) {	
			define( 'WPS_DEALS_LI_APP_SECRET', $li_client_secret );	
		}
	
		// For LinkedIn Port http / https
		if( !defined( 'LINKEDIN_PORT_HTTP' ) ) { //http port value
		 	define( 'LINKEDIN_PORT_HTTP', '80' );
		}
		if( !defined( 'LINKEDIN_PORT_HTTP_SSL' ) ) { //ssl port value
		  	define( 'LINKEDIN_PORT_HTTP_SSL', '443' );
		}
		
		//For Yahoo data
		if( !defined( 'WPS_DEALS_YH_CONSUMER_KEY' ) ) {
			define( 'WPS_DEALS_YH_CONSUMER_KEY', $yh_consumer_key );
		}
		if( !defined( 'WPS_DEALS_YH_CONSUMER_SECRET' ) ) {
			define( 'WPS_DEALS_YH_CONSUMER_SECRET', $yh_consumer_secrets );
		}
		if( !defined( 'WPS_DEALS_YH_APP_ID' ) ) {
			define( 'WPS_DEALS_YH_APP_ID', $yh_app_id );
		}
		if( !defined( 'WPS_DEALS_YH_REDIRECT_URL' ) ) {
			$yahoourl = add_query_arg( 'wpsocialdeals', 'yahoo', site_url() );
			define( 'WPS_DEALS_YH_REDIRECT_URL', $yahoourl );
		}
		
		//For foursquare data
		if( !defined( 'WPS_DEALS_FS_CLIENT_ID' ) ) {
			define( 'WPS_DEALS_FS_CLIENT_ID', $fs_client_id );
		}
		if( !defined( 'WPS_DEALS_FS_CLIENT_SECRET' ) ) {
			define( 'WPS_DEALS_FS_CLIENT_SECRET', $fs_client_secrets );
		}
		if( !defined( 'WPS_DEALS_FS_REDIRECT_URL' ) ) {
			$fsredirecturl = add_query_arg( 'wpsocialdeals', 'foursquare', site_url() );
			define( 'WPS_DEALS_FS_REDIRECT_URL', $fsredirecturl );
		}
		
		//For Windows Live Data
		if( !defined( 'WPS_DEALS_WL_CLIENT_ID' ) ){
			define( 'WPS_DEALS_WL_CLIENT_ID', $wl_client_id );
		}
		if( !defined( 'WPS_DEALS_WL_CLIENT_SECRET' ) ){
			define( 'WPS_DEALS_WL_CLIENT_SECRET', $wl_client_secrets );
		}
		if( !defined( 'WPS_DEALS_WL_REDIRECT_URL' ) ) {
			$windowsliveurl = add_query_arg( 'wpsocialdeals', 'windowslive', site_url() );
			define( 'WPS_DEALS_WL_REDIRECT_URL', $windowsliveurl );
		}
	}
	
	/**
	 * Get Settings From Option Page
	 * 
	 * Handles to return all settings value
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_get_settings() {
		
		$settings = is_array(get_option('wps_deals_options')) 	? get_option('wps_deals_options') 	: array();
		
		return $settings;
	}

	/**
	 * Send to Success Page
	 * 
	 * Handles to return success page url
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_send_on_success_page( $queryarg = array() ) {
		
		$options = wps_deals_get_settings();
		
		$sendsuccess = get_permalink( $options['payment_thankyou_page'] );
		
		$sendsuccessurl = add_query_arg( $queryarg, $sendsuccess );
		
		wp_redirect( apply_filters( 'wps_deals_success_page_redirect', $sendsuccessurl, $queryarg) );
		exit;
	}
	/**
	 * Send to Cancel Page
	 * 
	 * Handles to return cancel page url
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_send_on_cancel_page( $queryarg = array() ) {
		
		$options = wps_deals_get_settings();
		
		$sendcancel = get_permalink( $options['payment_cancel_page'] );
	
		$sendcancelurl = add_query_arg( $queryarg, $sendcancel );
		
		wp_redirect( apply_filters( 'wps_deals_cancel_page_redirect', $sendcancelurl, $queryarg) );
		exit;
	}
	/**
	 * Send to Checkout Page
	 * 
	 * Handles to return checkout page url
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_send_on_checkout_page( $queryarg = array() ) {
		
		$options = wps_deals_get_settings();
		
		$sendcheckout = get_permalink($options['payment_checkout_page']);
	
		$sendcheckouturl = add_query_arg( $queryarg, $sendcheckout );
		
		wp_redirect( apply_filters( 'wps_deals_checkout_page_redirect', $sendcheckouturl, $queryarg ) );
		exit;
	}
	/**
 	 * Return Value of IP address
 	 * 
 	 * @package Social Deals Engine
 	 * @since 1.0.0
 	 */
	function wps_deals_getip()
	 { 
	     if (isset($_SERVER)) {
	     	
	         if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
	            $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	         } elseif (isset($_SERVER["HTTP_CLIENT_IP"])) {
	               $realip = $_SERVER["HTTP_CLIENT_IP"];
	         } else {
	              $realip =$_SERVER["REMOTE_ADDR"];
	         }
	         
	     }  else {
	          if ( getenv( 'HTTP_X_FORWARDED_FOR' ) ) {
	               $realip = getenv( 'HTTP_X_FORWARDED_FOR' );
	           } elseif ( getenv( 'HTTP_CLIENT_IP' ) ) {
	               $realip = getenv( 'HTTP_CLIENT_IP' );
	           } else {
	              $realip = getenv( 'REMOTE_ADDR' );
	          }
	     }
	    return $realip;
	 }
	 /**
	  * Get payment Gateways
	  * 
	  * Handles to return all payment gateways
	  * 
	  * @package Social Deals Engine
	  * @since 1.0.0
	  */
	 function wps_deals_get_payment_gateways() {
	 	
	 	$gateways = array(
							'paypal'	=>	array( 'admin_label' => __( 'PayPal Standard','wpsdeals'), 'checkout_label' => __( 'PayPal','wpsdeals') ),
							'cheque'	=>	array( 'admin_label' => __( 'Cheque Payment','wpsdeals'), 'checkout_label' => __( 'Cheque Payment','wpsdeals') ),
							'testmode'	=>	array( 'admin_label' => __( 'Test Mode','wpsdeals'), 'checkout_label' => __( 'Test Mode','wpsdeals') ),
						);
		$gateways = apply_filters('wps_deals_add_more_payment_gateways',$gateways);
		
		return $gateways;
	 }
	 /**
	  * Get enabled payment gateways
	  * 
	  * Handles to return activated payment gateways
	  * 
	  * @package Social Deals Engine
	  * @since 1.0.0
	  */
	 function wps_deals_get_enabled_gateways(){
	 	
	 	global $wps_deals_options;
	 	$gateways = wps_deals_get_payment_gateways();
		$enabled_gateways = isset( $wps_deals_options['payment_gateways'] ) ? $wps_deals_options['payment_gateways'] : false;
	
		$gateway_list = array();
		if(!empty($enabled_gateways)) {
			foreach( $gateways as $key => $gateway ){
				if( array_key_exists( $key, $enabled_gateways ) && isset( $gateway['checkout_label'] ) ) { //check gateway is exist or not
					$gateway_list[ $key ] = $gateway;
				}
		 	}
		}
		return apply_filters( 'wps_deals_enabled_payment_gateways', $gateway_list);
	 	
	 }
	 /**
	 * Get US States List
	 *
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wp_deals_get_states_list() {
		$states = array(
			'AL' => 'Alabama',
			'AK' => 'Alaska',
			'AZ' => 'Arizona',
			'AR' => 'Arkansas',
			'CA' => 'California',
			'CO' => 'Colorado',
			'CT' => 'Connecticut',
			'DE' => 'Delaware',
			'DC' => 'District of Columbia',
			'FL' => 'Florida',
			'GA' => 'Georgia',
			'HI' => 'Hawaii',
			'ID' => 'Idaho',
			'IL' => 'Illinois',
			'IN' => 'Indiana',
			'IA' => 'Iowa',
			'KS' => 'Kansas',
			'KY' => 'Kentucky',
			'LA' => 'Louisiana',
			'ME' => 'Maine',
			'MD' => 'Maryland',
			'MA' => 'Massachusetts',
			'MI' => 'Michigan',
			'MN' => 'Minnesota',
			'MS' => 'Mississippi',
			'MO' => 'Missouri',
			'MT' => 'Montana',
			'NE' => 'Nebraksa',
			'NV' => 'Nevada',
			'NH' => 'New Hampshire',
			'NJ' => 'New Jersey',
			'NM' => 'New Mexico',
			'NY' => 'New York',
			'NC' => 'North Carolina',
			'ND' => 'North Dakota',
			'OH' => 'Ohio',
			'OK' => 'Oklahoma',
			'OR' => 'Oregon',
			'PA' => 'Pennsylvania',
			'RI' => 'Rhode Island',
			'SC' => 'South Carolina',
			'SD' => 'South Dakota',
			'TN' => 'Tennessee',
			'TX' => 'Texas',
			'UT' => 'Utah',
			'VT' => 'Vermont',
			'VA' => 'Virginia',
			'WA' => 'Washington',
			'WV' => 'West Virginia',
			'WI' => 'Wisconsin',
			'WY' => 'Wyoming',
			'AS' => 'American Samoa',
			'CZ' => 'Canal Zone',
			'CM' => 'Commonwealth of the Northern Mariana Islands',
			'FM' => 'Federated States of Micronesia',
			'GU' => 'Guam',
			'MH' => 'Marshall Islands',
			'MP' => 'Northern Mariana Islands',
			'PW' => 'Palau',
			'PI' => 'Philippine Islands',
			'PR' => 'Puerto Rico',
			'TT' => 'Trust Territory of the Pacific Islands',
			'VI' => 'Virgin Islands',
			'AA' => 'Armed Forces - Americas',
			'AE' => 'Armed Forces - Europe, Canada, Middle East, Africa',
			'AP' => 'Armed Forces - Pacific'
		);
	
		return apply_filters( 'wps_deals_us_states', $states );
	}
	
	/**
	 * Get Provinces List
	 *
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_get_provinces_list() {
		$provinces = array(
			'AB' => 'Alberta',
			'BC' => 'British Columbia',
			'MB' => 'Manitoba',
			'NB' => 'New Brunswick',
			'NL' => 'Newfoundland and Labrador',
			'NS' => 'Nova Scotia',
			'NT' => 'Northwest Territories',
			'NU' => 'Nunavut',
			'ON' => 'Ontario',
			'PE' => 'Prince Edward Island',
			'QC' => 'Quebec',
			'SK' => 'Saskatchewan',
			'YT' => 'Yukon'
		);
	
		return apply_filters( 'wps_deals_canada_provinces', $provinces );
	}
	/** Get Payment Statuses
 	 *
 	 * Retrieves all available statuses for payments
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_get_payment_statuses() {
		
		$payment_statuses = array(
			'0'		=> __( 'Pending', 'wpsdeals' ),
			'1'		=> __( 'Completed', 'wpsdeals' ),
			'2'		=> __( 'Refunded', 'wpsdeals' ),
			'3'		=> __( 'Failed', 'wpsdeals' ),
			'4'		=> __( 'Cancelled', 'wpsdeals' ),
			'5'		=> __( 'On-Hold', 'wpsdeals' )
		);

		return apply_filters( 'wps_deals_payment_statuses', $payment_statuses );
	}
	/**
	 * All Social Deals Networks
	 * 
	 * Handles to return all social networks
	 * names
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_social_networks() {
		
		$socialnetworks = array( 
									'facebook'		=>	__( 'Facebook', 'wpsdeals' ),
									'twitter'		=>	__( 'Twitter', 'wpsdeals' ),
									'googleplus'	=>	__( 'Google+', 'wpsdeals' ),
									'linkedin'		=>	__( 'LinkedIn', 'wpsdeals' ),
									'yahoo'			=>	__(	'Yahoo', 'wpsdeals'),
									'foursquare'	=>	__(	'Foursquare', 'wpsdeals'),
									'windowslive'	=>	__(	'Windows Live', 'wpsdeals')
								);
		return apply_filters( 'wps_deals_social_networks', $socialnetworks );
		
	}
	
	/**
	 * Get Social Network Sorted List
	 * as per saved in options
	 * 
	 * Handles to return social networks sorted
	 * array to list in page
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_get_sorted_social_network() {
		
		global $wps_deals_options;
		
		$socials = wps_deals_social_networks();
		
		if( !isset( $wps_deals_options['social_order'] ) || empty( $wps_deals_options['social_order'] )){
			return $socials;
		}
		
		$sorted_socials = $wps_deals_options['social_order'];
		
		$return = array();
		
		for( $i = 0; $i < count( $socials ); $i++ ){
			$return[$sorted_socials[$i]] = $socials[$sorted_socials[$i]];
		}
		return apply_filters( 'wps_deals_sorted_social_network', $return );
	}
	
	/**
	 * Check Anyone Social Login is Enable or not
	 * 
	 * Handles to check anyone social login is enable or not
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_enable_social_login() {
		
		global $wps_deals_options;
		
		$enablesocial = false;
		
		//check if any one social button is enable or not
		if( !empty( $wps_deals_options['enable_facebook'] ) || !empty( $wps_deals_options['enable_gplus'] ) 
			|| !empty( $wps_deals_options['enable_twitter'] ) || !empty( $wps_deals_options['enable_linkedin'] )
			|| !empty( $wps_deals_options['enable_yahoo'] ) || !empty( $wps_deals_options['enable_foursquare'] )
			|| !empty( $wps_deals_options['enable_windowslive'] ) ) {
			//enable social login box
			$enablesocial = true;	
		}
		
		return $enablesocial;
	}
	
	/**
	 * Load Checkout Credit Card Form
	 * 
	 * Handles to show checkout credit card form
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_cart_cc_form() {
		
		//load facebook button template
		wps_deals_get_template( 'checkout/checkout-footer/cc-form.php' );
		
	}
	/**
 	* Get All Capabilities
 	* 
 	* Handles to return all required capabilites 
 	* for social deals engine plugin
 	*
 	* @package Social Deals Engine
 	* @since 1.0.0
 	*/
	function wps_deals_get_capabilities() {
		
		$capabilities = array();
	
		$capability_types = array( WPS_DEALS_POST_TYPE, WPS_DEALS_SALES_POST_TYPE );
	
		foreach( $capability_types as $capability_type ) {
	
			$capabilities[ $capability_type ] = array(
	
				// Post type
				"edit_{$capability_type}",
				"read_{$capability_type}",
				"delete_{$capability_type}",
				"edit_{$capability_type}s",
				"edit_others_{$capability_type}s",
				"publish_{$capability_type}s",
				"read_private_{$capability_type}s",
				"delete_{$capability_type}s",
				"delete_private_{$capability_type}s",
				"delete_published_{$capability_type}s",
				"delete_others_{$capability_type}s",
				"edit_private_{$capability_type}s",
				"edit_published_{$capability_type}s",
	
				// Terms
				"manage_{$capability_type}_terms",
				"edit_{$capability_type}_terms",
				"delete_{$capability_type}_terms",
				"assign_{$capability_type}_terms"
			);
		}
		return $capabilities;
	}
	/**
	 * Assign Capabilities To Roles
	 *
	 * Handles to assign needed capabilites to 
	 * administrator roles
	 * 
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_add_capabilities() {
		
		global $wp_roles;
	
		//check WP_Roles class is exist or not
		if ( class_exists('WP_Roles') )
			if ( ! isset( $wp_roles ) )
				$wp_roles = new WP_Roles();
	
		// check $wp_roles is object or not
		if ( is_object( $wp_roles ) ) {
	
			//get all assigning capabilities of deals engine
			$capabilities = wps_deals_get_capabilities();
	
			foreach( $capabilities as $cap_group ) {
				foreach( $cap_group as $cap ) {
					//assign some capability to administrator for deals engine
					$wp_roles->add_cap( 'administrator', $cap );
				}//for each for adding cap
			} //for each for capablities
			
		} //end if to check $wp_roles
	}
	/**
	 * Remove Capabilities
	 * 
	 * Handles to remove capabilities when 
	 * plugin is getting reset
	 *
	 * @package Social Deals Engine
	 * @since 1.0.0
	 */
	function wps_deals_remove_capabilities() {
		
		global $wp_roles;
	
		//check WP_Roles class is exist or not
		if ( class_exists('WP_Roles') )
			if ( ! isset( $wp_roles ) )
				$wp_roles = new WP_Roles();
	
		// check $wp_roles is object or not
		if ( is_object( $wp_roles ) ) {
	
			//get all assigning capabilities of deals engine
			$capabilities = wps_deals_get_capabilities();
	
			foreach( $capabilities as $cap_group ) {
				foreach( $cap_group as $cap ) {
					//remove added capability to administrator for deals engine
					$wp_roles->remove_cap( 'administrator', $cap );
				}//for each for removing cap
			} //for each for capablities
			
		} //end if to check $wp_roles
	}
?>