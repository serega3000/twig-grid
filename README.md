#Twig extension for bootstrap grid layout

To write this code

    <div class='row'>
        <div class='col col-lg-4 col-md-8 col-sm-6'>
            some content here ...
        </div>
        <div class='col col-lg-4 col-md-8 col-sm-6'>
            some content here ...
        </div>
    </div>

In twig template you can write

    {% row %}
        {% col "lg4 md8 sm6" %}
            some content here ...
        {% endcol %}
        {% col "lg4 md8 sm6" %}
            some content here ...
        {% endcol %}
    {% endrow %}

class definition in {% col %} tag like "lg4 md8 sm6 xs8" will be automatically converted to "col col-lg-4 col-md-8 col-sm-6 col-sx-8"


You also can add your own CSS class to column, for example, "lg4 md8 sm6 my-class" will be automatically converted to "col col-lg-4 col-md-8 col-sm-6 my-class"

##Installing 

Require in composer

	composer require serega3000/twig-grid:~1.0

Register as twig extension:

    $twig = new Twig_Environment($loader);
    $twig->addExtension('', new \Serega3000\TwigGrid\Extension());
