<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 16/07/14
 * Time: 8:31 PM
 */

// define some wp stuff needed

define( 'ABSPATH', 'fakepath' );

function add_action( $action, $callback ) {}
function add_filter( $action, $callback, $priority ) {}
function add_shortcode( $tag, $callback ) {}

require_once dirname( __FILE__ ) . '/../biblify/class-biblify.php';

class BiblifyTest extends PHPUnit_Framework_TestCase {

    /** @var $sut Biblify */
    protected $sut;

    public function setUp() {
        $this->sut = new Biblify();
    }

    public static function dataBiblify() {
        $passages = array(
            'Genesis 1', 'Ge 1:2-4a', 'Gen 27:12b-16', 'Gn 3',
'Exodus 3:1-2', 'Exod 5', 'Exo 7:1b', 'Ex 24:1-4,5-7',
'Leviticus 2:5', 'Lev 3:5-18', 'Lv 5',
'Numbers 2', 'Num 5:4', 'Nu 6:7-8',
'Deutoronomy 1:4-5a,8-9', 'Dt 4', 'Deut 5:1',
'Joshua 3:2', 'Jos 5:6b-8,9', 'Josh 7', 'Jsh 7:1b',
        'Judges 4:4-7', 'Judg 6:7-12,8:4-5', 'Jg 3:9', 'Jdg 6:1b',
        'Ruth 2:1-4a', 'Ru 4',
'1 Samuel 3', '2 Samuel 5:7-9', '2 Sam 3:7', '1 Sam 4:5-6a',
        '1 Kings 4:5', '2 Kings 6:4-5,7-9,11', '1 Kgs 3:7-9', '2 Ki 8:9-10', '1 Kings 2-3',
            '1 Chronicles 3:4-4:2', '2 Chron 5', '1 Ch 6:7-9,13', '2 Chr 6:9b-7:1',
'Ezra 2:3', 'Ezr 4:5-7',
'Nehemiah 4:5-6', 'Neh 9', 'Ne 8:9-12',
'Esther 3:1-2', 'Esth 4',
'Job 1', 'Job 1:5,10', 'Jb 5:6-7',
'Ps 5:6', 'Psalm 119', 'Psalms 17', 'Psa 100',
'Proverbs 3:25', 'Prov 6:8', 'Pr 9:10-15', 'Prv 10:5-11:9',
'Ecclesiastes 2', 'Ec 6:1-11',
'Song of Solomon 2:3', 'Song 5:1', 'Song of Songs 1:9-10,13',
'Isaiah 3:4-5', 'Isa 8:9,11',
'Jeremiah 6:10', 'Jer 9:11-15', 'Jr 6:7-10,7:1-5',
'Lamentations 3:6-9,11', 'Lam 1', 'La 2:10',
        'Ezekiel 1', 'Ezek 8:9-10a,10:1-3', 'Eze 10:2', 'Ezk 1:1-5a',
'Daniel 1:2-3', 'Dan 5', 'Da 8:9-10,11:1', 'Dn 7:6b',
'Hosea 4:1a', 'Hos 9', 'Ho 1:2-4b',
'Joel 2', 'Joe 3:12', 'Jl 1:6-12,14-15a',
'Amos 1:2-3,7-9,11-14',
'Obadiah 1:15', 'Obad 1', 'Ob 1:1-12',
'Jonah 2', 'Jon 1:4-5', 'Jnh 3:6,9-11',
'Micah 2:9', 'Mic 3',
'Nahum 1', 'Nah 2:4-5,7-9a', 'Na 3:10-13',
'Habakkuk 3:4', 'Hab 2:5-10',
'Zephaniah 3:10', 'Zeph 2:2-4', 'Zph 1:2-5,6-7',
'Haggai 1:5-7', 'Hag 2', 'Hg 2:5-11,13-15',
'Zechariah 3:4-7', 'Zech 2:5-10,12-13,5:3-12', 'Zec 2', 'Zc 1:6b-9',
'Malachi 2', 'Mal 3:2-16', 'Ml 4:1',

'Matthew 14:5-9', 'Mt 8', 'Matt 14:5-8,15:8-9,21:1-6',
'Mark 5:6', 'Mk 9:10-14', 'Mk 12',
'Luke 13:1-12,14:5-15', 'Lk 5', 'Luk 9:10-12',
'John 1:1-10', 'Jn 3', 'Jn 9:20-35',
'Acts 3:4-17', 'Ac 9',
'Romans 2:3-10,15-23', 'Rom 6:7-8', 'Ro 14', 'Ro 16:12',
'1 Corinthians 7', '1 Cor 16', '1 Cor 14:5-8', '1 Co 11:9',
'2 Corinthians 7', '2 Cor 11', '2 Cor 12:5-8', '2 Co 11:9',
'Galatians 3:10,4:15', 'Gal 2:3-19', 'Ga 5',
'Ephesians 4:17-25', 'Eph 3:9,5:10-15a',
        'Philippians 4:6-19', 'Phil 2', 'Php 4',
'Colossians 2:8-10', 'Col 3',
'1 Thessalonians 4', '1 Thess 4:5-10', '1 Thes 2:3-10a,4:5-7', '1 Th 2,3',
'2 Thessalonians 3', '2 Thess 2:5-10', '2 Thes 2:3-10a,3:5-7', '2 Th 2,3',
'1 Timothy 3:6-14', '1 Tim 2:6', '1 Ti 5',
'2 Timothy 3:6-14', '2 Tim 2:6', '2 Ti 4',
'Titus 3:2-3', 'Ti 2',
'Philemon 1:1', 'Philem 1:2-3', 'Phm 1:3-8',
'Hebrews 13', 'Heb 12:20-24',
'James 3:4', 'Jas 2', 'Jas 2:2-5,10-13',
'1 Peter 3:4-7,11-17', '1 Pet 2:6-7,3:7', '1 Pe 3', '1 Pt 2',
'2 Peter 3:4-7,11-17', '2 Pet 2:6-7,3:7', '2 Pe 3', '2 Pt 2',
'1 John 4', '1 John 2:6', '1 Joh 1:3-5', '1 Jn 2:3-5,4:7-8',
'2 John 1', '2 Joh 1:3-5', '2 Jn 1:3-5,8-9',
'3 John 1', '3 Joh 1:3-5', '3 Jn 1:3-5,8-9',
'Jude 1:3', 'Jud 1:10-14',
'Revelation 16:2-17:5,18:9-15', 'Rev 11:3-18', 'Re 14:1-17:5'
        );

        $tests = array();
        foreach ( $passages as $passage ) {
            $tests[] = array( $passage, self::createLink( $passage ) );
        }

        return $tests;
    }

    protected static function createLink( $bibleref ) {
        return sprintf( '<a href="http://www.biblegateway.com/passage/?search=%s&version=NIVUK" class="bibleref">%s</a>', urlencode( $bibleref ), $bibleref );
    }

    /**
     * @dataProvider dataBiblify
     * @param $content
     * @param $result
     */
    public function testBiblify( $content, $result ) {
        $actual = $this->sut->biblify( $content );
        $this->assertEquals( $result, $actual );
    }

    public function testForceBiblify() {
        // Is isn't automatically converted for Isaiah as it's too common
        $content = 'Is 2:4';
        $actual = $this->sut->force_biblify( array(), $content );
        $this->assertEquals(
            $this->createLink( $content ),
            $actual
        );
    }

    public function testBiblifyIgnore() {
        $content = 'Here is some text to ignore PHP 5';

        // test that we add the link first
        $result = $this->sut->biblify( $content );
        $this->assertEquals(
            'Here is some text to ignore ' . $this->createLink('PHP 5'),
            $result
        );

        // add the ignore, triggered by the biblify-ignore code when running in WP
        $this->sut->add_ignore( array(), 'PHP 5' );

        // test that this time we get the string without the link
        $result = $this->sut->biblify( $content );
        $this->assertEquals( $content, $result );
    }

}
