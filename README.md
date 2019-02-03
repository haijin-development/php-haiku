# Haijin Haiku

The most simple template engine possible, inspired in Ruby's Slim.

[![Latest Stable Version](https://poser.pugx.org/haijin/haiku/version)](https://packagist.org/packages/haijin/haiku)
[![Latest Unstable Version](https://poser.pugx.org/haijin/haiku/v/unstable)](https://packagist.org/packages/haijin/haiku)
[![Build Status](https://travis-ci.org/haijin-development/php-haiku.svg?branch=master)](https://travis-ci.org/haijin-development/php-haiku)
[![License](https://poser.pugx.org/haijin/haiku/license)](https://packagist.org/packages/haijin/haiku)

### Version 0.0.1

This library is under active development and no stable version was released yet.

If you like it a lot you may contribute by [financing](https://github.com/haijin-development/support-haijin-development) its development.

## Table of contents

1. [Installation](#c-1)
2. [Example](#c-2)
3. [Usage](#c-3)
    1. [Haiku sintax](#c-3-1)
        1. [Html tags](#c-3-1-1)
        2. [Tags attributes](#c-3-1-2)
        3. [Tags id and classes shortcuts](#c-3-1-3)
        4. [Text](#c-3-1-4)
        5. [PHP code evaluation](#c-3-1-5)
        6. [PHP code interpolation](#c-3-1-6)
        7. [Loops](#c-3-1-7)
        8. [Conditionals](#c-3-1-8)
        9. [Variables](#c-3-1-9)
    2. [Rendering](#c-3-2)
4. [Running the specs](#c-4)

<a name="c-1"></a>
## Installation

Include this library in your project `composer.json` file:

```json
{
    ...

    "require-dev": {
        ...
        "haijin/haiku": "^0.0.1",
        ...
    },

    ...
}
```
<a name="c-2"></a>
## Example

Example of a haiku template:

```
html
    head
    body.container
        div#haiku.poem data-id= "1"
            = "Entrar al ciruelo"
            br
            = "en base a ternura"
            br
            = "en base a olfato."
        div.source data-id= "1", data-author= "Alberto Silva"
            = "Traducción de Alberto Silva - El libro del haiku"
```

<a name="c-3"></a>
## Usage

<a name="c-3-1"></a>
### Haiku sintax

Haiku is a minimalist html template that uses indentation to avoid closing tags explictely.

<a name="c-3-1-1"></a>
#### Html tags

Add the correct indentation and declare the tag name with no delimiter characters:

Example:

```
html lang = "en"
    head
        meta charset = "utf-8"
        meta name = "viewport", content="width=device-width, initial-scale=1, shrink-to-fit=no"

    link rel = "stylesheet",
        href = "https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"

    title
        = "Haiku template"

    body
        p
            = "Este camino"
        p
            = "ya nadie lo recorre"
        p
            = "ni siquiera el ocaso."

    script src = "https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
```

<a name="c-3-1-2"></a>
#### Tags attributes

The atrribute name, the symbol `=` and the attribute value can have any number of optional spaces:

```
html lang = "en"
html lang= "en"
html lang="en"
```

Separate tag attributes by with a  `,` char:

```
meta name = "viewport", content="width=device-width, initial-scale=1, shrink-to-fit=no"
```

Continue the attribute list in the line below after a `,` char.
The continued line can have any indentation.

```
meta name = "viewport",
        content="width=device-width, initial-scale=1, shrink-to-fit=no"
```

<a name="c-3-1-3"></a>
#### Tags id and classes shortcuts

Declare a tag `id` using the jquery shortcut:

```
body
    div#title
```

or even

```
body
    #title
```


Declare a tag `class` using the jquery shortcut:

```
body
    div.row
        div.col.col-lg-2
```

or even

```
body
    .row
        .col.col-lg-2
```

When declaring both a tag `id` and `class`, the tag `id` must go before the `class`:

```
div.row
    h1#title.col-lg-2
```

If the tag defines an `id` with both the jquery shortcut and its `id` attribute, the attribute has priority.

If the tag defines a `class` with both the jquery sortcut and its `class` attribute, the attribute `class` is merged into the jquery shorcut:

```
div.row
    h1#title.col-lg-2 id = "main-title", class = "main-title"
```

will render

```
<div class="row">
    <h1 id="main-title" class="col-lg-2 main-title">
    </h1>
<div>
```

<a name="c-3-1-4"></a>
#### Text

Everything after operands `=` and `==` is plain PHP code that is evaluated and its result is rendered into the html.

Render text with operand `=`:

```
body
    p
        = "Este camino"
    p
        = "ya nadie lo recorre"
    p
        = "ni siquiera el ocaso."
```

`=` will escape html characters, so it's safe to render dynamic input from external sources like query parameters and databases.


Render unescaped text with operand `==`:

```
body
    h1
        == "Haiku template"
```

Use unescaped text to render the contents of another template or dynamically generated html:

```
body
    == $view->render_template( "subtemplate.haiku" )
```

<a name="c-3-1-5"></a>
#### PHP code evaluation

Evaluate a PHP line without rendering its result into the html with the `-` operand:

```
- $title = "Haiku template"
body
    h1
        = $title
```

<a name="c-3-1-6"></a>
#### PHP code interpolation

Interpolate PHP code in the tag or attributes declarations with `#{}`:

```
div.user-#{ $user->get_id(); }
```

will output

```
<div class="user-1">
</div>
```

Use interpolation to evaluate multiple lines of PHP code:

```
- #{
    $title = "Haiku template";
    $haiku = [ "Este camino", "ya nadie lo recorre", "ni siquiera el ocaso." ];
}

body
    h1
        = $title

    .poem
        - foreach( $haiku as $verse ) do
            p
                = $verse
```


<a name="c-3-1-7"></a>
#### Loops

```
- foreach( $users as $user ) do
    tr
        td
            = $user->get_name()
        td
            = $user->get_lastname()
```

<a name="c-3-1-8"></a>
#### Conditionals

```
- if( $user != null ) do
    div = $user->get_name() . $user->get_lastname()
```

```
- if( $user == null ) do

    = "No user id logged in"

- elseif( $user->is_admin() ) do

    = "Admin: " . $user->get_name() . $user->get_lastname()

- else do

    = "User: " . $user->get_name() . $user->get_lastname()

```
<a name="c-3-1-9"></a>
#### Variables

<a name="c-3-2"></a>
### Rendering


<a name="c-4"></a>
## Running the specs

```
composer specs
```