<?php

use Haijin\Haiku\Parser\Parser;
use Haijin\Haiku\Haiku_Parser_Definition;

$spec->describe( "When parsing an invalid expression", function() {

    $this->let( "parser", function() {

        return new Parser( Haiku_Parser_Definition::$definition );

    });

    $this->let( "haiku", function() {
        return
"div@invalid-expression
";
    });

    $this->it( "raises an UnexpectedExpressionError error", function() {

        $this->expect( function() {

            $this->parser->parse_string( $this->haiku );

        }) ->to() ->raise(
            \Haijin\Haiku\UnexpectedExpressionError::class,
            function($error) {

                $this->expect( $error->getMessage() ) ->to() ->equal(
                    'Unexpected expression "@invalid-expression". At line: 1 column: 4.'
                );
        });

    });

});