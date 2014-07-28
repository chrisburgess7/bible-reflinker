<?php
/**
 * Plugin Name: Bible Reflinker
 * Plugin URI:
 * Description: Automatically converts Bible references into external bible links
 * Version: 0.2
 * Author: Chris Burgess
 * Author URI:
 * License: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

defined( 'ABSPATH' ) or die();

require_once dirname(__FILE__) . '/class-linker.php';

class Bible_Reflinker {

    protected $linker;

    public function __construct() {

        $this->linker = new BBRF_Linker();

        $options = get_option( 'bbrf_settings' );

        $this->linker->set_bible_version( $options['bbrf_bible_version'] );

        add_action( 'init', array( $this, 'register_shortcodes' ) );
        // bump this priority to be after the shortcode is handled
        add_filter( 'the_content', array( $this->linker, 'link' ), 11 );

        if ( is_admin() ) {
            add_action( 'admin_init', array( $this, 'settings_init' ) );
            add_action( 'admin_menu', array( $this, 'build_admin_menu' ) );
        }
    }

    public function register_shortcodes() {
        add_shortcode( 'bibleref-ignore', array( $this->linker, 'add_ignore' ) );
        add_shortcode( 'bibleref', array( $this->linker, 'force_link' ) );
    }

    public function settings_init() {
        register_setting( 'pluginPage', 'bbrf_settings' );

        add_settings_section(
            'bbrf_pluginPage_section',
            __( '', 'bible-reflinker' ),
            array( $this, 'bbrf_settings_section_callback' ),
            'pluginPage'
        );

        add_settings_field(
            'bbrf_bible_version',
            __( 'Bible Version', 'bible-reflinker' ),
            array( $this, 'bbrf_select_field_0_render' ),
            'pluginPage',
            'bbrf_pluginPage_section'
        );
    }

    public function build_admin_menu() {
        add_options_page( 'Bible Reflinker Options', 'Bible Reflinker', 'manage_options', 'bible_reflinker', array( $this, 'bible_reflinker_options_page' ) );
    }

    public function bbrf_select_field_0_render(  ) {

        $options = get_option( 'bbrf_settings' );
        ?>
        <select name='bbrf_settings[bbrf_bible_version]'>
            <option class="lang" value="AMU">—Amuzgo de Guerrero (AMU)—</option>
            <option value="AMU" <?php selected( $options['bbrf_bible_version'], 'AMU' ); ?>>Amuzgo de Guerrero (AMU)</option>
            <option class="spacer" value="AMU">&nbsp;</option>
            <option class="lang" value="ERV-AR">—العربية (AR)—</option>
            <option value="ERV-AR" <?php selected( $options['bbrf_bible_version'], 'ERV-AR' ); ?>>Arabic Bible: Easy-ERV-Read Version (ERV-AR)</option>
            <option value="ALAB">Arabic Life Application Bible (ALAB)</option>
            <option class="spacer" value="ALAB">&nbsp;</option>
            <option class="lang" value="ERV-AWA">—अवधी (AWA)—</option>
            <option value="ERV-AWA" <?php selected( $options['bbrf_bible_version'], 'ERV-AWA' ); ?>>Awadhi Bible: Easy-to-Read Version (ERV-AWA)</option>
            <option class="spacer" value="ERV-AWA">&nbsp;</option>
            <option class="lang" value="BG1940">—Български (BG)—</option>
            <option value="BG1940" <?php selected( $options['bbrf_bible_version'], 'BG1940' ); ?>>1940 Bulgarian Bible (BG1940)</option>
            <option value="BULG" <?php selected( $options['bbrf_bible_version'], 'BULG' ); ?>>Bulgarian Bible (BULG)</option>
            <option value="ERV-BG" <?php selected( $options['bbrf_bible_version'], 'ERV-BG' ); ?>>Bulgarian New Testament: Easy-to-Read Version (ERV-BG)</option>
            <option value="BPB" <?php selected( $options['bbrf_bible_version'], 'BPB'); ?>>Bulgarian Protestant Bible (BPB)</option>
            <option class="spacer" value="BPB">&nbsp;</option>
            <option class="lang" value="CCO">—Chinanteco de Comaltepec (CCO)—</option>
            <option value="CCO" <?php selected( $options['bbrf_bible_version'], 'CCO'); ?>>Chinanteco de Comaltepec (CCO)</option>
            <option class="spacer" value="CCO">&nbsp;</option>
            <option class="lang" value="APSD-CEB">—Cebuano (CEB)—</option>
            <option value="APSD-CEB" <?php selected( $options['bbrf_bible_version'], 'APSD-CEB' ); ?>>Ang Pulong Sa Dios (APSD-CEB)</option>
            <option class="spacer" value="APSD-CEB">&nbsp;</option>
            <option class="lang" value="CHR">—ᏣᎳᎩ ᎦᏬᏂᎯᏍ (CHR)—</option>
            <option value="CHR" <?php selected( $options['bbrf_bible_version'], 'CHR'); ?>>Cherokee New Testament (CHR)</option>
            <option class="spacer" value="CHR">&nbsp;</option>
            <option class="lang" value="CKW">—Cakchiquel Occidental (CKW)—</option>
            <option value="CKW" <?php selected( $options['bbrf_bible_version'], 'CKW'); ?>>Cakchiquel Occidental (CKW)</option>
            <option class="spacer" value="CKW">&nbsp;</option>
            <option class="lang" value="B21">—Čeština (CS)—</option>
            <option value="B21" <?php selected( $options['bbrf_bible_version'], 'B21'); ?>>Bible 21 (B21)</option>
            <option value="SNC" <?php selected( $options['bbrf_bible_version'], 'SNC'); ?>>Slovo na cestu (SNC)</option>
            <option class="spacer" value="SNC">&nbsp;</option>
            <option class="lang" value="BPH">—Dansk (DA)—</option>
            <option value="BPH" <?php selected( $options['bbrf_bible_version'], 'BPH'); ?>>Bibelen på hverdagsdansk (BPH)</option>
            <option value="DN1933" <?php selected( $options['bbrf_bible_version'], 'DN1933'); ?>>Dette er Biblen på dansk (DN1933)</option>
            <option class="spacer" value="DN1933">&nbsp;</option>
            <option class="lang" value="HOF">—Deutsch (DE)—</option>
            <option value="HOF" <?php selected( $options['bbrf_bible_version'], 'HOF'); ?>>Hoffnung für Alle (HOF)</option>
            <option value="LUTH1545" <?php selected( $options['bbrf_bible_version'], 'LUTH1545'); ?>>Luther Bibel 1545 (LUTH1545)</option>
            <option value="NGU-DE" <?php selected( $options['bbrf_bible_version'], 'NGU-DE'); ?>>Neue Genfer Übersetzung (NGU-DE)</option>
            <option value="SCH1951" <?php selected( $options['bbrf_bible_version'], 'SCH1951'); ?>>Schlachter 1951 (SCH1951)</option>
            <option value="SCH2000" <?php selected( $options['bbrf_bible_version'], 'SCH2000'); ?>>Schlachter 2000 (SCH2000)</option>
            <option class="spacer" value="SCH2000">&nbsp;</option>
            <option class="lang" value="KJ21">—English (EN)—</option>
            <option value="KJ21" <?php selected( $options['bbrf_bible_version'], 'KJ21'); ?>>21st Century King James Version (KJ21)</option>
            <option value="ASV" <?php selected( $options['bbrf_bible_version'], 'ASV'); ?>>American Standard Version (ASV)</option>
            <option value="AMP" <?php selected( $options['bbrf_bible_version'], 'AMP'); ?>>Amplified Bible (AMP)</option>
            <option value="CEB" <?php selected( $options['bbrf_bible_version'], 'CEB'); ?>>Common English Bible (CEB)</option>
            <option value="CJB" <?php selected( $options['bbrf_bible_version'], 'CJB'); ?>>Complete Jewish Bible (CJB)</option>
            <option value="CEV" <?php selected( $options['bbrf_bible_version'], 'CEV'); ?>>Contemporary English Version (CEV)</option>
            <option value="DARBY" <?php selected( $options['bbrf_bible_version'], 'DARBY'); ?>>Darby Translation (DARBY)</option>
            <option value="DRA" <?php selected( $options['bbrf_bible_version'], 'DRA'); ?>>Douay-Rheims 1899 American Edition (DRA)</option>
            <option value="ERV" <?php selected( $options['bbrf_bible_version'], 'ERV'); ?>>Easy-to-Read Version (ERV)</option>
            <option value="ESV" <?php selected( $options['bbrf_bible_version'], 'ESV'); ?>>English Standard Version (ESV)</option>
            <option value="ESVUK" <?php selected( $options['bbrf_bible_version'], 'ESVUK'); ?>>English Standard Version Anglicised (ESVUK)</option>
            <option value="EXB" <?php selected( $options['bbrf_bible_version'], 'EXB'); ?>>Expanded Bible (EXB)</option>
            <option value="GNV" <?php selected( $options['bbrf_bible_version'], 'GNV'); ?>>1599 Geneva Bible (GNV)</option>
            <option value="GW" <?php selected( $options['bbrf_bible_version'], 'GW'); ?>>GOD’S WORD Translation (GW)</option>
            <option value="GNT" <?php selected( $options['bbrf_bible_version'], 'GNT'); ?>>Good News Translation (GNT)</option>
            <option value="HCSB" <?php selected( $options['bbrf_bible_version'], 'HCSB'); ?>>Holman Christian Standard Bible (HCSB)</option>
            <option value="PHILLIPS" <?php selected( $options['bbrf_bible_version'], 'PHILLIPS'); ?>>J.B. Phillips New Testament (PHILLIPS)</option>
            <option value="JUB" <?php selected( $options['bbrf_bible_version'], 'JUB'); ?>>Jubilee Bible 2000 (JUB)</option>
            <option value="KJV" <?php selected( $options['bbrf_bible_version'], 'KJV'); ?>>King James Version (KJV)</option>
            <option value="AKJV" <?php selected( $options['bbrf_bible_version'], 'AKJV'); ?>>Authorized (King James) Version (AKJV)</option>
            <option value="LEB" <?php selected( $options['bbrf_bible_version'], 'LEB'); ?>>Lexham English Bible (LEB)</option>
            <option value="TLB" <?php selected( $options['bbrf_bible_version'], 'TLB'); ?>>Living Bible (TLB)</option>
            <option value="MSG" <?php selected( $options['bbrf_bible_version'], 'MSG'); ?>>The Message (MSG)</option>
            <option value="MOUNCE" <?php selected( $options['bbrf_bible_version'], 'MOUNCE'); ?>>Mounce Reverse-Interlinear New Testament (MOUNCE)</option>
            <option value="NOG" <?php selected( $options['bbrf_bible_version'], 'NOG'); ?>>Names of God Bible (NOG)</option>
            <option value="NABRE" <?php selected( $options['bbrf_bible_version'], 'NABRE'); ?>>New American Bible (Revised Edition) (NABRE)</option>
            <option value="NASB" <?php selected( $options['bbrf_bible_version'], 'NASB'); ?>>New American Standard Bible (NASB)</option>
            <option value="NCV" <?php selected( $options['bbrf_bible_version'], 'NCV'); ?>>New Century Version (NCV)</option>
            <option value="NET" <?php selected( $options['bbrf_bible_version'], 'NET'); ?>>New English Translation (NET Bible)</option>
            <option value="NIRV" <?php selected( $options['bbrf_bible_version'], 'NIRV'); ?>>New International Reader's Version (NIRV)</option>
            <option value="NIV" <?php selected( $options['bbrf_bible_version'], 'NIV'); ?>>New International Version (NIV)</option>
            <option value="NIVUK" <?php selected( $options['bbrf_bible_version'], 'NIVUK'); ?>>New International Version - UK (NIVUK)</option>
            <option value="NKJV" <?php selected( $options['bbrf_bible_version'], 'NKJV'); ?>>New King James Version (NKJV)</option>
            <option value="NLV" <?php selected( $options['bbrf_bible_version'], 'NLV'); ?>>New Life Version (NLV)</option>
            <option value="NLT" <?php selected( $options['bbrf_bible_version'], 'NLT'); ?>>New Living Translation (NLT)</option>
            <option value="NRSV" <?php selected( $options['bbrf_bible_version'], 'NRSV'); ?>>New Revised Standard Version (NRSV)</option>
            <option value="NRSVA" <?php selected( $options['bbrf_bible_version'], 'NRSVA'); ?>>New Revised Standard Version, Anglicised (NRSVA)</option>
            <option value="NRSVACE" <?php selected( $options['bbrf_bible_version'], 'NRSVACE'); ?>>New Revised Standard Version, Anglicised Catholic Edition (NRSVACE)</option>
            <option value="NRSVCE" <?php selected( $options['bbrf_bible_version'], 'NRSVCE'); ?>>New Revised Standard Version Catholic Edition (NRSVCE)</option>
            <option value="OJB" <?php selected( $options['bbrf_bible_version'], 'OJB'); ?>>Orthodox Jewish Bible (OJB)</option>
            <option value="RSV" <?php selected( $options['bbrf_bible_version'], 'RSV'); ?>>Revised Standard Version (RSV)</option>
            <option value="RSVCE" <?php selected( $options['bbrf_bible_version'], 'RSVCE'); ?>>Revised Standard Version Catholic Edition (RSVCE)</option>
            <option value="VOICE" <?php selected( $options['bbrf_bible_version'], 'VOICE'); ?>>The Voice (VOICE)</option>
            <option value="WEB" <?php selected( $options['bbrf_bible_version'], 'WEB'); ?>>World English Bible (WEB)</option>
            <option value="WE" <?php selected( $options['bbrf_bible_version'], 'WE'); ?>>Worldwide English (New Testament) (WE)</option>
            <option value="WYC" <?php selected( $options['bbrf_bible_version'], 'WYC'); ?>>Wycliffe Bible (WYC)</option>
            <option value="YLT" <?php selected( $options['bbrf_bible_version'], 'YLT'); ?>>Young's Literal Translation (YLT)</option>
            <option class="spacer" value="YLT">&nbsp;</option>
            <option class="lang" value="LBLA">—Español (ES)—</option>
            <option value="LBLA" <?php selected( $options['bbrf_bible_version'], 'LBLA'); ?>>La Biblia de las Américas (LBLA)</option>
            <option value="DHH" <?php selected( $options['bbrf_bible_version'], 'DHH'); ?>>Dios Habla Hoy (DHH)</option>
            <option value="JBS" <?php selected( $options['bbrf_bible_version'], 'JBS'); ?>>Jubilee Bible 2000 (Spanish) (JBS)</option>
            <option value="NBLH" <?php selected( $options['bbrf_bible_version'], 'NBLH'); ?>>Nueva Biblia Latinoamericana de Hoy (NBLH)</option>
            <option value="NTV" <?php selected( $options['bbrf_bible_version'], 'NTV'); ?>>Nueva Traducción Viviente (NTV)</option>
            <option value="NVI" <?php selected( $options['bbrf_bible_version'], 'NVI'); ?>>Nueva Versión Internacional (NVI)</option>
            <option value="CST" <?php selected( $options['bbrf_bible_version'], 'CST'); ?>>Nueva Versión Internacional (Castilian) (CST)</option>
            <option value="PDT" <?php selected( $options['bbrf_bible_version'], 'PDT'); ?>>Palabra de Dios para Todos (PDT)</option>
            <option value="BLP" <?php selected( $options['bbrf_bible_version'], 'BLP'); ?>>La Palabra (España) (BLP)</option>
            <option value="BLPH" <?php selected( $options['bbrf_bible_version'], 'BLPH'); ?>>La Palabra (Hispanoamérica) (BLPH)</option>
            <option value="RVC" <?php selected( $options['bbrf_bible_version'], 'RVC'); ?>>Reina Valera Contemporánea (RVC)</option>
            <option value="RVR1960" <?php selected( $options['bbrf_bible_version'], 'RVR1960'); ?>>Reina-Valera 1960 (RVR1960)</option>
            <option value="RVR1977" <?php selected( $options['bbrf_bible_version'], 'RVR1977'); ?>>Reina Valera 1977 (RVR1977)</option>
            <option value="RVR1995" <?php selected( $options['bbrf_bible_version'], 'RVR1995'); ?>>Reina-Valera 1995 (RVR1995)</option>
            <option value="RVA" <?php selected( $options['bbrf_bible_version'], 'RVA'); ?>>Reina-Valera Antigua (RVA)</option>
            <option value="TLA" <?php selected( $options['bbrf_bible_version'], 'TLA'); ?>>Traducción en lenguaje actual (TLA)</option>
            <option class="spacer" value="TLA">&nbsp;</option>
            <option class="lang" value="R1933">—Suomi (FI)—</option>
            <option value="R1933" <?php selected( $options['bbrf_bible_version'], 'R1933'); ?>>Raamattu 1933/38 (R1933)</option>
            <option class="spacer" value="R1933">&nbsp;</option>
            <option class="lang" value="BDS">—Français (FR)—</option>
            <option value="BDS" <?php selected( $options['bbrf_bible_version'], 'BDS'); ?>>La Bible du Semeur (BDS)</option>
            <option value="LSG" <?php selected( $options['bbrf_bible_version'], 'LSG'); ?>>Louis Segond (LSG)</option>
            <option value="NEG1979" <?php selected( $options['bbrf_bible_version'], 'NEG1979'); ?>>Nouvelle Edition de Genève – NEG1979 (NEG1979)</option>
            <option value="SG21" <?php selected( $options['bbrf_bible_version'], 'SG21'); ?>>Segond 21 (SG21)</option>
            <option class="spacer" value="SG21">&nbsp;</option>
            <option class="lang" value="TR1550">—Κοινη (GRC)—</option>
            <option value="TR1550" <?php selected( $options['bbrf_bible_version'], 'TR1550'); ?>>1550 Stephanus New Testament (TR1550)</option>
            <option value="WHNU" <?php selected( $options['bbrf_bible_version'], 'WHNU'); ?>>1881 Westcott-Hort New Testament (WHNU)</option>
            <option value="TR1894" <?php selected( $options['bbrf_bible_version'], 'TR1894'); ?>>1894 Scrivener New Testament (TR1894)</option>
            <option value="SBLGNT" <?php selected( $options['bbrf_bible_version'], 'SBLGNT'); ?>>SBL Greek New Testament (SBLGNT)</option>
            <option class="spacer" value="SBLGNT">&nbsp;</option>
            <option class="lang" value="HHH">—עברית (HE)—</option>
            <option value="HHH" <?php selected( $options['bbrf_bible_version'], 'HHH'); ?>>Habrit Hakhadasha/Haderekh (HHH)</option>
            <option value="WLC" <?php selected( $options['bbrf_bible_version'], 'WLC'); ?>>The Westminster Leningrad Codex (WLC)</option>
            <option class="spacer" value="WLC">&nbsp;</option>
            <option class="lang" value="ERV-HI">—हिन्दी (HI)—</option>
            <option value="ERV-HI" <?php selected( $options['bbrf_bible_version'], 'ERV-HI' ); ?>>Hindi Bible: Easy-to-Read Version (ERV-HI)</option>
            <option class="spacer" value="ERV-HI">&nbsp;</option>
            <option class="lang" value="HLGN">—Ilonggo (HIL)—</option>
            <option value="HLGN" <?php selected( $options['bbrf_bible_version'], 'HLGN'); ?>>Ang Pulong Sang Dios (HLGN)</option>
            <option class="spacer" value="HLGN">&nbsp;</option>
            <option class="lang" value="CRO">—Hrvatski (HR)—</option>
            <option value="CRO" <?php selected( $options['bbrf_bible_version'], 'CRO'); ?>>Knijga O Kristu (CRO)</option>
            <option class="spacer" value="CRO">&nbsp;</option>
            <option class="lang" value="HCV">—Kreyòl ayisyen (HT)—</option>
            <option value="HCV" <?php selected( $options['bbrf_bible_version'], 'HCV'); ?>>Haitian Creole Version (HCV)</option>
            <option class="spacer" value="HCV">&nbsp;</option>
            <option class="lang" value="KAR">—Magyar (HU)—</option>
            <option value="KAR" <?php selected( $options['bbrf_bible_version'], 'KAR'); ?>>Hungarian Károli (KAR)</option>
            <option value="ERV-HU" <?php selected( $options['bbrf_bible_version'], 'ERV-HU' ); ?>>Hungarian Bible: Easy-to-Read Version (ERV-HU)</option>
            <option value="NT-HU" <?php selected( $options['bbrf_bible_version'], 'NT-HU' ); ?>>Hungarian New Translation (NT-HU)</option>
            <option class="spacer" value="NT-HU">&nbsp;</option>
            <option class="lang" value="HWP">—Hawai‘i Pidgin (HWC)—</option>
            <option value="HWP" <?php selected( $options['bbrf_bible_version'], 'HWP'); ?>>Hawai‘i Pidgin (HWP)</option>
            <option class="spacer" value="HWP">&nbsp;</option>
            <option class="lang" value="ICELAND">—Íslenska (IS)—</option>
            <option value="ICELAND" <?php selected( $options['bbrf_bible_version'], 'ICELAND'); ?>>Icelandic Bible (ICELAND)</option>
            <option class="spacer" value="ICELAND">&nbsp;</option>
            <option class="lang" value="BDG">—Italiano (IT)—</option>
            <option value="BDG" <?php selected( $options['bbrf_bible_version'], 'BDG'); ?>>La Bibbia della Gioia (BDG)</option>
            <option value="CEI" <?php selected( $options['bbrf_bible_version'], 'CEI'); ?>>Conferenza Episcopale Italiana (CEI)</option>
            <option value="LND" <?php selected( $options['bbrf_bible_version'], 'LND'); ?>>La Nuova Diodati (LND)</option>
            <option value="NR1994" <?php selected( $options['bbrf_bible_version'], 'NR1994'); ?>>Nuova Riveduta 1994 (NR1994)</option>
            <option value="NR2006" <?php selected( $options['bbrf_bible_version'], 'NR2006'); ?>>Nuova Riveduta 2006 (NR2006)</option>
            <option class="spacer" value="NR2006">&nbsp;</option>
            <option class="lang" value="JAC">—Jacalteco, Oriental (JAC)—</option>
            <option value="JAC" <?php selected( $options['bbrf_bible_version'], 'JAC'); ?>>Jacalteco, Oriental (JAC)</option>
            <option class="spacer" value="JAC">&nbsp;</option>
            <option class="lang" value="KEK">—Kekchi (KEK)—</option>
            <option value="KEK" <?php selected( $options['bbrf_bible_version'], 'KEK'); ?>>Kekchi (KEK)</option>
            <option class="spacer" value="KEK">&nbsp;</option>
            <option class="lang" value="VULGATE">—Latina (LA)—</option>
            <option value="VULGATE" <?php selected( $options['bbrf_bible_version'], 'VULGATE'); ?>>Biblia Sacra Vulgata (VULGATE)</option>
            <option class="spacer" value="VULGATE">&nbsp;</option>
            <option class="lang" value="MAORI">—Māori (MI)—</option>
            <option value="MAORI" <?php selected( $options['bbrf_bible_version'], 'MAORI'); ?>>Maori Bible (MAORI)</option>
            <option class="spacer" value="MAORI">&nbsp;</option>
            <option class="lang" value="MNT">—Македонски (MK)—</option>
            <option value="MNT" <?php selected( $options['bbrf_bible_version'], 'MNT'); ?>>Macedonian New Testament (MNT)</option>
            <option class="spacer" value="MNT">&nbsp;</option>
            <option class="lang" value="ERV-MR">—मराठी (MR)—</option>
            <option value="ERV-MR" <?php selected( $options['bbrf_bible_version'], 'ERV-MR' ); ?>>Marathi Bible: Easy-to-Read Version (ERV-MR)</option>
            <option class="spacer" value="ERV-MR">&nbsp;</option>
            <option class="lang" value="MVC">—Mam, Central (MVC)—</option>
            <option value="MVC" <?php selected( $options['bbrf_bible_version'], 'MVC'); ?>>Mam, Central (MVC)</option>
            <option class="spacer" value="MVC">&nbsp;</option>
            <option class="lang" value="MVJ">—Mam, Todos Santos (MVJ)—</option>
            <option value="MVJ" <?php selected( $options['bbrf_bible_version'], 'MVJ'); ?>>Mam de Todos Santos Chuchumatán (MVJ)</option>
            <option class="spacer" value="MVJ">&nbsp;</option>
            <option class="lang" value="REIMER">—Plautdietsch (NDS)—</option>
            <option value="REIMER" <?php selected( $options['bbrf_bible_version'], 'REIMER'); ?>>Reimer 2001 (REIMER)</option>
            <option class="spacer" value="REIMER">&nbsp;</option>
            <option class="lang" value="ERV-NE">—नेपाली (NE)—</option>
            <option value="ERV-NE" <?php selected( $options['bbrf_bible_version'], 'ERV-NE' ); ?>>Nepali Bible: Easy-to-Read Version (ERV-NE)</option>
            <option class="spacer" value="ERV-NE">&nbsp;</option>
            <option class="lang" value="NGU">—Náhuatl de Guerrero (NGU)—</option>
            <option value="NGU" <?php selected( $options['bbrf_bible_version'], 'NGU'); ?>>Náhuatl de Guerrero (NGU)</option>
            <option class="spacer" value="NGU">&nbsp;</option>
            <option class="lang" value="HTB">—Nederlands (NL)—</option>
            <option value="HTB" <?php selected( $options['bbrf_bible_version'], 'HTB'); ?>>Het Boek (HTB)</option>
            <option class="spacer" value="HTB">&nbsp;</option>
            <option class="lang" value="DNB1930">—Norsk (NO)—</option>
            <option value="DNB1930" <?php selected( $options['bbrf_bible_version'], 'DNB1930'); ?>>Det Norsk Bibelselskap 1930 (DNB1930)</option>
            <option value="LB" <?php selected( $options['bbrf_bible_version'], 'LB'); ?>>En Levende Bok (LB)</option>
            <option class="spacer" value="LB">&nbsp;</option>
            <option class="lang" value="ERV-OR">—ଓଡ଼ିଆ (OR)—</option>
            <option value="ERV-OR" <?php selected( $options['bbrf_bible_version'], 'ERV-OR' ); ?>>Oriya Bible: Easy-to-Read Version (ERV-OR)</option>
            <option class="spacer" value="ERV-OR">&nbsp;</option>
            <option class="lang" value="ERV-PA">—ਪੰਜਾਬੀ (PA)—</option>
            <option value="ERV-PA" <?php selected( $options['bbrf_bible_version'], 'ERV-PA' ); ?>>Punjabi Bible: Easy-to-Read Version (ERV-PA)</option>
            <option class="spacer" value="ERV-PA">&nbsp;</option>
            <option class="lang" value="NP">—Polski (PL)—</option>
            <option value="NP" <?php selected( $options['bbrf_bible_version'], 'NP'); ?>>Nowe Przymierze (NP)</option>
            <option value="SZ-PL" <?php selected( $options['bbrf_bible_version'], 'SZ-PL' ); ?>>Słowo Życia (SZ-PL)</option>
            <option value="UBG" <?php selected( $options['bbrf_bible_version'], 'UBG'); ?>>Updated Gdańsk Bible (UBG)</option>
            <option class="spacer" value="UBG">&nbsp;</option>
            <option class="lang" value="NBTN">—Nawat (PPL)—</option>
            <option value="NBTN" <?php selected( $options['bbrf_bible_version'], 'NBTN'); ?>>Ne Bibliaj Tik Nawat (NBTN)</option>
            <option class="spacer" value="NBTN">&nbsp;</option>
            <option class="lang" value="AA">—Português (PT)—</option>
            <option value="AA" <?php selected( $options['bbrf_bible_version'], 'AA'); ?>>João Ferreira de Almeida Atualizada (AA)</option>
            <option value="NVI-PT" <?php selected( $options['bbrf_bible_version'], 'NVI-PT' ); ?>>Nova Versão Internacional (NVI-PT)</option>
            <option value="OL" <?php selected( $options['bbrf_bible_version'], 'OL'); ?>>O Livro (OL)</option>
            <option value="VFL" <?php selected( $options['bbrf_bible_version'], 'VFL'); ?>>Portuguese New Testament: Easy-to-Read Version (VFL)</option>
            <option class="spacer" value="VFL">&nbsp;</option>
            <option class="lang" value="MTDS">—Quichua (QU)—</option>
            <option value="MTDS" <?php selected( $options['bbrf_bible_version'], 'MTDS'); ?>>Mushuj Testamento Diospaj Shimi (MTDS)</option>
            <option class="spacer" value="MTDS">&nbsp;</option>
            <option class="lang" value="QUT">—Quiché, Centro Occidenta (QUT)—</option>
            <option value="QUT" <?php selected( $options['bbrf_bible_version'], 'QUT'); ?>>Quiché, Centro Occidental (QUT)</option>
            <option class="spacer" value="QUT">&nbsp;</option>
            <option class="lang" value="RMNN">—Română (RO)—</option>
            <option value="RMNN" <?php selected( $options['bbrf_bible_version'], 'RMNN'); ?>>Cornilescu (RMNN)</option>
            <option value="NTLR" <?php selected( $options['bbrf_bible_version'], 'NTLR'); ?>>Nouă Traducere În Limba Română (NTLR)</option>
            <option class="spacer" value="NTLR">&nbsp;</option>
            <option class="lang" value="ERV-RU">—Русский (RU)—</option>
            <option value="ERV-RU" <?php selected( $options['bbrf_bible_version'], 'ERV-RU' ); ?>>Russian New Testament: Easy-to-Read Version (ERV-RU)</option>
            <option value="RUSV" <?php selected( $options['bbrf_bible_version'], 'RUSV'); ?>>Russian Synodal Version (RUSV)</option>
            <option value="SZ" <?php selected( $options['bbrf_bible_version'], 'SZ'); ?>>Slovo Zhizny (SZ)</option>
            <option class="spacer" value="SZ">&nbsp;</option>
            <option class="lang" value="NPK">—Slovenčina (SK)—</option>
            <option value="NPK" <?php selected( $options['bbrf_bible_version'], 'NPK'); ?>>Nádej pre kazdého (NPK)</option>
            <option class="spacer" value="NPK">&nbsp;</option>
            <option class="lang" value="SOM">—Somali (SO)—</option>
            <option value="SOM" <?php selected( $options['bbrf_bible_version'], 'SOM'); ?>>Somali Bible (SOM)</option>
            <option class="spacer" value="SOM">&nbsp;</option>
            <option class="lang" value="ALB">—Shqip (SQ)—</option>
            <option value="ALB" <?php selected( $options['bbrf_bible_version'], 'ALB'); ?>>Albanian Bible (ALB)</option>
            <option class="spacer" value="ALB">&nbsp;</option>
            <option class="lang" value="ERV-SR">—Српски (SR)—</option>
            <option value="ERV-SR" <?php selected( $options['bbrf_bible_version'], 'ERV-SR' ); ?>>Serbian New Testament: Easy-to-Read Version (ERV-SR)</option>
            <option class="spacer" value="ERV-SR">&nbsp;</option>
            <option class="lang" value="SVL">—Svenska (SV)—</option>
            <option value="SVL" <?php selected( $options['bbrf_bible_version'], 'SVL'); ?>>Nya Levande Bibeln (SVL)</option>
            <option value="SV1917" <?php selected( $options['bbrf_bible_version'], 'SV1917'); ?>>Svenska 1917 (SV1917)</option>
            <option value="SFB" <?php selected( $options['bbrf_bible_version'], 'SFB'); ?>>Svenska Folkbibeln (SFB)</option>
            <option class="spacer" value="SFB">&nbsp;</option>
            <option class="lang" value="SNT">—Kiswahili (SW)—</option>
            <option value="SNT" <?php selected( $options['bbrf_bible_version'], 'SNT'); ?>>Neno: Bibilia Takatifu (SNT)</option>
            <option class="spacer" value="SNT">&nbsp;</option>
            <option class="lang" value="ERV-TA">—தமிழ் (TA)—</option>
            <option value="ERV-TA" <?php selected( $options['bbrf_bible_version'], 'ERV-TA' ); ?>>Tamil Bible: Easy-to-Read Version (ERV-TA)</option>
            <option class="spacer" value="ERV-TA">&nbsp;</option>
            <option class="lang" value="TNCV">—ภาษาไทย (TH)—</option>
            <option value="TNCV" <?php selected( $options['bbrf_bible_version'], 'TNCV'); ?>>Thai New Contemporary Bible (TNCV)</option>
            <option value="ERV-TH" <?php selected( $options['bbrf_bible_version'], 'ERV-TH' ); ?>>Thai New Testament: Easy-to-Read Version (ERV-TH)</option>
            <option class="spacer" value="ERV-TH">&nbsp;</option>
            <option class="lang" value="SND">—Tagalog (TL)—</option>
            <option value="SND" <?php selected( $options['bbrf_bible_version'], 'SND'); ?>>Ang Salita ng Diyos (SND)</option>
            <option class="spacer" value="SND">&nbsp;</option>
            <option class="lang" value="NA-TWI">—Twi (TWI)—</option>
            <option value="NA-TWI" <?php selected( $options['bbrf_bible_version'], 'NA-TWI' ); ?>>Nkwa Asem (NA-TWI)</option>
            <option class="spacer" value="NA-TWI">&nbsp;</option>
            <option class="lang" value="UKR">—Українська (UK)—</option>
            <option value="UKR" <?php selected( $options['bbrf_bible_version'], 'UKR'); ?>>Ukrainian Bible (UKR)</option>
            <option value="ERV-UK" <?php selected( $options['bbrf_bible_version'], 'ERV-UK' ); ?>>Ukrainian New Testament: Easy-to-Read Version (ERV-UK)</option>
            <option class="spacer" value="ERV-UK">&nbsp;</option>
            <option class="lang" value="ERV-UR">—اردو (UR)—</option>
            <option value="ERV-UR" <?php selected( $options['bbrf_bible_version'], 'ERV-UR' ); ?>>Urdu Bible: Easy-to-Read Version (ERV-UR)</option>
            <option class="spacer" value="ERV-UR">&nbsp;</option>
            <option class="lang" value="USP">—Uspanteco (USP)—</option>
            <option value="USP" <?php selected( $options['bbrf_bible_version'], 'USP'); ?>>Uspanteco (USP)</option>
            <option class="spacer" value="USP">&nbsp;</option>
            <option class="lang" value="VIET">—Tiêng Viêt (VI)—</option>
            <option value="VIET" <?php selected( $options['bbrf_bible_version'], 'VIET'); ?>>1934 Vietnamese Bible (VIET)</option>
            <option value="BD2011" <?php selected( $options['bbrf_bible_version'], 'BD2011'); ?>>Bản Dịch 2011 (BD2011)</option>
            <option value="BPT" <?php selected( $options['bbrf_bible_version'], 'BPT'); ?>>Vietnamese Bible: Easy-to-Read Version (BPT)</option>
            <option class="spacer" value="BPT">&nbsp;</option>
            <option class="lang" value="CCB">—汉语 (ZH)—</option>
            <option value="CCB" <?php selected( $options['bbrf_bible_version'], 'CCB'); ?>>Chinese Contemporary Bible (CCB)</option>
            <option value="ERV-ZH" <?php selected( $options['bbrf_bible_version'], 'ERV-ZH' ); ?>>Chinese New Testament: Easy-to-Read Version (ERV-ZH)</option>
            <option value="CNVT" <?php selected( $options['bbrf_bible_version'], 'CNVT'); ?>>Chinese New Version (Traditional) (CNVT)</option>
            <option value="CSBS" <?php selected( $options['bbrf_bible_version'], 'CSBS'); ?>>Chinese Standard Bible (Simplified) (CSBS)</option>
            <option value="CSBT" <?php selected( $options['bbrf_bible_version'], 'CSBT'); ?>>Chinese Standard Bible (Traditional) (CSBT)</option>
            <option value="CUVS" <?php selected( $options['bbrf_bible_version'], 'CUVS'); ?>>Chinese Union Version (Simplified) (CUVS)</option>
            <option value="CUV" <?php selected( $options['bbrf_bible_version'], 'CUV'); ?>>Chinese Union Version (Traditional) (CUV)</option>
            <option value="CUVMPS" <?php selected( $options['bbrf_bible_version'], 'CUVMPS'); ?>>Chinese Union Version Modern Punctuation (Simplified) (CUVMPS)</option>
            <option value="CUVMPT" <?php selected( $options['bbrf_bible_version'], 'CUVMPT'); ?>>Chinese Union Version Modern Punctuation (Traditional) (CUVMPT)</option>
        </select>

    <?php

    }


    public function bbrf_settings_section_callback(  ) {

        //echo __( 'This section description', 'bible-reflinker' );

    }


    public function bible_reflinker_options_page(  ) {

        ?>
        <form action='options.php' method='post'>

            <h2>Bible Reflinker</h2>

            <?php
            settings_fields( 'pluginPage' );
            do_settings_sections( 'pluginPage' );
            submit_button();
            ?>

        </form>
    <?php

    }
}

new Bible_Reflinker();
