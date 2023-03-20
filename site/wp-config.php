<?php
/**
 * A configuração de base do WordPress
 *
 * Este ficheiro define os seguintes parâmetros: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, e ABSPATH. Pode obter mais informação
 * visitando {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} no Codex. As definições de MySQL são-lhe fornecidas pelo seu serviço de alojamento.
 *
 * Este ficheiro contém as seguintes configurações:
 *
 * * Configurações de  MySQL
 * * Chaves secretas
 * * Prefixo das tabelas da base de dados
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */
define('WPCF7_AUTOP', false);
// ** Definições de MySQL - obtenha estes dados do seu serviço de alojamento** //
/** O nome da base de dados do WordPress */
define( 'DB_NAME', 'granelli' );

/** O nome do utilizador de MySQL */
define( 'DB_USER', 'root' );

/** A password do utilizador de MySQL  */
define( 'DB_PASSWORD', '' );

/** O nome do serviddor de  MySQL  */
define( 'DB_HOST', 'localhost' );

/** O "Database Charset" a usar na criação das tabelas. */
define( 'DB_CHARSET', 'utf8mb4' );

/** O "Database Collate type". Se tem dúvidas não mude. */
define( 'DB_COLLATE', '' );

/**#@+
 * Chaves únicas de autenticação.
 *
 * Mude para frases únicas e diferentes!
 * Pode gerar frases automáticamente em {@link https://api.wordpress.org/secret-key/1.1/salt/ Serviço de chaves secretas de WordPress.org}
 * Pode mudar estes valores em qualquer altura para invalidar todos os cookies existentes o que terá como resultado obrigar todos os utilizadores a voltarem a fazer login
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY', '4|32ZOT#FI:[fq^2-.~t=,tn(5T cd3)O8A#bTR(^xnt08xy-$Fou6j>w~,G*@?^' );
define( 'SECURE_AUTH_KEY', '<53#.N?7nZ|#ow6:t_=?91KQ_wKd@:vFT_L7PI.]DT9[LqaVd~Nly]_X1jwKEg)1' );
define( 'LOGGED_IN_KEY', 'w~l9m=qrib^{`zM(&YMcRN_7Buos)~Cz@k([$kfgq3,<o=+1igiCjUKj!dCv^,oW' );
define( 'NONCE_KEY', 'Q)pq1f3[Q6qW^Q(jH+n</syt;]E!6k+q:3[~Msg4YxLNQx_UN_J1nz1Ktn6}(]Q6' );
define( 'AUTH_SALT', '/&$(ATsQdK.@RN@a_fT7DYS8[0IF%QvQ%]/hE3Q9U:/^w9eyzPjJ/%1.0CTxlCq+' );
define( 'SECURE_AUTH_SALT', 'Nb=;36NpQGpz-zyGhWzl#]rBEJS(~Spx9iiN9e3fLW{vq!@lA1CN*Hj(ne*[`CQ=' );
define( 'LOGGED_IN_SALT', 'gKS&@797qA,pUq@FabHJ91Uuv&+qwKc8 HmqW|aD|ark_Iw /A;4Bsx]PWCCPFGY' );
define( 'NONCE_SALT', '2B<RbiwsJ2.l_.4:Fe%6++(5zLZBi{:N=k7)ciw#FTPTJL|8}QuE[8[t7jXSj=1c' );

/**#@-*/

/**
 * Prefixo das tabelas de WordPress.
 *
 * Pode suportar múltiplas instalações numa só base de dados, ao dar a cada
 * instalação um prefixo único. Só algarismos, letras e underscores, por favor!
 */
$table_prefix = 'wp_';

/**
 * Para developers: WordPress em modo debugging.
 *
 * Mude isto para true para mostrar avisos enquanto estiver a testar.
 * É vivamente recomendado aos autores de temas e plugins usarem WP_DEBUG
 * no seu ambiente de desenvolvimento.
 *
 * Para mais informações sobre outras constantes que pode usar para debugging,
 * visite o Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* E é tudo. Pare de editar! */

/** Caminho absoluto para a pasta do WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Define as variáveis do WordPress e ficheiros a incluir. */
require_once( ABSPATH . 'wp-settings.php' );
