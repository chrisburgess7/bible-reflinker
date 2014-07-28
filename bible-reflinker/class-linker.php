<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 16/07/14
 * Time: 8:12 PM
 */

defined( 'ABSPATH' ) or die();

class BBRF_Linker {
    protected $ignoreList = array();

    protected $version = 'NIV';

    public function set_bible_version( $version ) {
        $this->version = $version;
    }

    /**
     * Handle bibleref-ignore shortcode
     * @param $attr
     * @param null $content
     * @return null
     */
    public function add_ignore( $attr, $content = null ) {
        if ( $content !== null ) {
            // this will cause all instances of text to be ignored, how to identify?
            $this->ignoreList[] = trim( $content );
        }
        return $content;
    }

    /**
     * Handle bibleref shortcode
     * @param $attr
     * @param null $content
     * @return null|string
     */
    public function force_link( $attr, $content = null ) {
        if ( $content !== null ) {
            return $this->get_link( $content );
        }
        return $content;
    }

    /**
     * Run the auto reflinker on the given content
     * @param $content
     * @return mixed
     */
    public function link( $content ) {
        return preg_replace_callback( '%(\b(?:' .
            'Ge|Gn|Gen|Genesis' .
            '|Ex|Exo|Exod|Exodus' .
            '|Lv|Lev|Leviticus' .
            '|Nu|Nm|Nb|Num|Numbers' .
            '|Dt|Deut|Deutoronomy' .
            '|Jos|Jsh|Josh|Joshua' .
            '|Jg|Jdg|Judg|Judges' .
            '|Ruth|Ru' .
            '|1\s+Samuel|1\s+Sam|1\s+Sa' .
            '|2\s+Samuel|2\s+Sam|2\s+Sa' .
            '|1\s+Kings|1\s+Kgs|1\s+Ki' .
            '|2\s+Kings|2\s+Kgs|2\s+Ki' .
            '|1\s+Chronicles|1\s+Chron|1\s+Ch|1\s+Chr' .
            '|2\s+Chronicles|2\s+Chron|2\s+Ch|2\s+Chr' .
            '|Ezra|Ezr' .
            '|Nehemiah|Neh|Ne' .
            '|Esther|Esth' .
            '|Job|Jb' .
            '|Psalm|Psalms|Ps|Psa' .
            '|Proverbs|Prov|Pr|Prv' .
            '|Ecclesiastes|Ec' .
            '|Song\s+of\s+Solomon|Song|Song\s+of\s+Songs' . // 'So' is a valid abbrev. but will match falsely too easily
            '|Isaiah|Isa' . // 'Is' is also a valid abbreviation, but that would cause far too many false matches, so we leave it out
            '|Jeremiah|Jer|Jr' .
            '|Lamentations|Lam|La' .
            '|Ezekiel|Ezek|Eze|Ezk' .
            '|Daniel|Dan|Da|Dn' .
            '|Hosea|Hos|Ho' .
            '|Joel|Joe|Jl' .
            '|Amos' . // 'Am' is a valid abbrev. but too many false matches
            '|Obadiah|Obad|Ob' .
            '|Jonah|Jnh|Jon' .
            '|Micah|Mic' .
            '|Nahum|Nah|Na' .
            '|Habakkuk|Hab' .
            '|Zephaniah|Zeph|Zph' .
            '|Haggai|Hag|Hg' .
            '|Zechariah|Zech|Zec|Zc' .
            '|Malachi|Mal|Ml' .
            '|Matthew|Matt|Mt' .
            '|Mark|Mk' .
            '|Luke|Luk|Lk' .
            '|John|Jn|Jhn' .
            '|Acts|Ac' .
            '|Romans|Rom|Ro|Rm' .
            '|1\s+Corinthians|1\s+Cor|1\s+Co' .
            '|2\s+Corinthians|2\s+Cor|2\s+Co' .
            '|Galatians|Gal|Ga' .
            '|Ephesians|Eph' .
            '|Philippians|Phil|Php' .
            '|Colossians|Col' .
            '|1\s+Thessalonians|1\s+Thess|1\s+Thes|1\s+Th' .
            '|2\s+Thessalonians|2\s+Thess|2\s+Thes|2\s+Th' .
            '|1\s+Timothy|1\s+Tim|1\s+Ti' .
            '|2\s+Timothy|2\s+Tim|2\s+Ti' .
            '|Titus|Ti' .
            '|Philemon|Philem|Phm' .
            '|Hebrews|Heb' .
            '|James|Jas' .
            '|1\s+Peter|1\s+Pet|1\s+Pe|1\s+Pt' .
            '|2\s+Peter|2\s+Pet|2\s+Pe|2\s+Pt' .
            '|1\s+John|1\s+Jn|1\s+Joh' .
            '|2\s+John|2\s+Jn|2\s+Joh' .
            '|3\s+John|3\s+Jn|3\s+Joh' .
            '|Jude|Jud' .
            '|Revelation|Rev|Re' .
            ')\b(?:\s+\d+)(?:(?::\d+[a-c]?)?(?:[-–]\d+[a-c]?)?(?:[,-–]\d+[a-c]?(?::\d+[a-c]?)?(?:[-–]\d+[a-c]?)?)*)?)%i',
            array( $this, 'get_link_text' ),
            $content
        );
    }

    protected function get_link_text( $matches ) {
        if ( in_array( $matches[0], $this->ignoreList ) ) {
            return $matches[0];
        } else {
            return $this->get_link( $matches[0] );
        }
    }

    protected function get_link( $bibleref ) {
        return sprintf(
            '<a href="http://www.biblegateway.com/passage/?search=%s&version=%s" class="bibleref">%s</a>',
            urlencode( $bibleref ),
            $this->version,
            $bibleref
        );
    }
}
