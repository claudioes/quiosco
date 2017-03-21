<?php

/* template/menu.twig */
class __TwigTemplate_fc6a879acfea7a7d835e6d004527d92dab2e82148ec90ca0e3ebde015c6dd956 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<nav class=\"navbar navbar-default navbar-static-top\">
    <div class=\"container-fluid\">
        <div class=\"navbar-header\">
            <button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\" data-target=\"#navbar-menu\" aria-expanded=\"false\">
                <span class=\"sr-only\">Toggle navigation</span>
                <span class=\"icon-bar\"></span>
                <span class=\"icon-bar\"></span>
                <span class=\"icon-bar\"></span>
            </button>
            <a class=\"navbar-brand\" href=\"";
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->urlFor("home"), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["app"] ?? null), "name", array()), "html", null, true);
        echo "</a>
        </div>
        <div class=\"collapse navbar-collapse\" id=\"navbar-menu\">
            <ul class=\"nav navbar-nav\">
                ";
        // line 14
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["menu"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 15
            echo "                    ";
            $context["attr"] = $this->getAttribute($context["item"], "attributes", array());
            // line 16
            echo "                    <li class=\"dropdown\">
                        <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">";
            // line 17
            echo twig_escape_filter($this->env, $this->getAttribute(($context["attr"] ?? null), "title", array()), "html", null, true);
            echo " <span class=\"caret\"></span></a>
                        <ul class=\"dropdown-menu\">
                            ";
            // line 19
            $context["cantidad"] = 0;
            // line 20
            echo "                            ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($context["item"]);
            foreach ($context['_seq'] as $context["_key"] => $context["subitem"]) {
                // line 21
                echo "                                ";
                $context["attr"] = $this->getAttribute($context["subitem"], "attributes", array());
                // line 22
                echo "                                ";
                $context["permiso"] = twig_trim_filter($this->getAttribute(($context["attr"] ?? null), "permiso", array()));
                // line 23
                echo "                                ";
                $context["route"] = $this->getAttribute(($context["attr"] ?? null), "route", array());
                // line 24
                echo "                                ";
                $context["titulo"] = $this->getAttribute(($context["attr"] ?? null), "title", array());
                // line 25
                echo "
                                ";
                // line 26
                if ((($context["titulo"] ?? null) == "-")) {
                    // line 27
                    echo "                                    ";
                    if ((($context["cantidad"] ?? null) > 0)) {
                        // line 28
                        echo "                                        <li role=\"separator\" class=\"divider\"></li>
                                        ";
                        // line 29
                        $context["cantidad"] = 0;
                        // line 30
                        echo "                                    ";
                    }
                    // line 31
                    echo "                                ";
                } else {
                    // line 32
                    echo "                                    ";
                    if ($this->getAttribute(($context["usuario"] ?? null), "puede", array(0 => ($context["permiso"] ?? null)), "method")) {
                        // line 33
                        echo "                                        <li><a href=\"";
                        echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->urlFor(($context["route"] ?? null)), "html", null, true);
                        echo "\">";
                        echo twig_escape_filter($this->env, ($context["titulo"] ?? null), "html", null, true);
                        echo "</a></li>
                                        ";
                        // line 34
                        $context["cantidad"] = (($context["cantidad"] ?? null) + 1);
                        // line 35
                        echo "                                    ";
                    }
                    // line 36
                    echo "                                ";
                }
                // line 37
                echo "                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['subitem'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 38
            echo "                        </ul>
                    </li>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 41
        echo "            </ul>
            <ul class=\"nav navbar-nav navbar-right\">
                <li><p class=\"navbar-text\">";
        // line 43
        echo twig_escape_filter($this->env, $this->getAttribute(($context["usuario"] ?? null), "apellido", array()), "html", null, true);
        echo ", ";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["usuario"] ?? null), "nombre", array()), "html", null, true);
        echo "</p></li>
                <li><a href=\"";
        // line 44
        echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->urlFor("logout"), "html", null, true);
        echo "\">Salir</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
";
    }

    public function getTemplateName()
    {
        return "template/menu.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  134 => 44,  128 => 43,  124 => 41,  116 => 38,  110 => 37,  107 => 36,  104 => 35,  102 => 34,  95 => 33,  92 => 32,  89 => 31,  86 => 30,  84 => 29,  81 => 28,  78 => 27,  76 => 26,  73 => 25,  70 => 24,  67 => 23,  64 => 22,  61 => 21,  56 => 20,  54 => 19,  49 => 17,  46 => 16,  43 => 15,  39 => 14,  30 => 10,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<nav class=\"navbar navbar-default navbar-static-top\">
    <div class=\"container-fluid\">
        <div class=\"navbar-header\">
            <button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\" data-target=\"#navbar-menu\" aria-expanded=\"false\">
                <span class=\"sr-only\">Toggle navigation</span>
                <span class=\"icon-bar\"></span>
                <span class=\"icon-bar\"></span>
                <span class=\"icon-bar\"></span>
            </button>
            <a class=\"navbar-brand\" href=\"{{ urlFor('home') }}\">{{ app.name }}</a>
        </div>
        <div class=\"collapse navbar-collapse\" id=\"navbar-menu\">
            <ul class=\"nav navbar-nav\">
                {% for item in menu %}
                    {% set attr = item.attributes %}
                    <li class=\"dropdown\">
                        <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">{{ attr.title }} <span class=\"caret\"></span></a>
                        <ul class=\"dropdown-menu\">
                            {% set cantidad = 0 %}
                            {% for subitem in item %}
                                {% set attr = subitem.attributes %}
                                {% set permiso = attr.permiso|trim %}
                                {% set route = attr.route %}
                                {% set titulo = attr.title %}

                                {% if titulo == '-' %}
                                    {% if cantidad > 0 %}
                                        <li role=\"separator\" class=\"divider\"></li>
                                        {% set cantidad = 0 %}
                                    {% endif %}
                                {% else %}
                                    {% if usuario.puede(permiso) %}
                                        <li><a href=\"{{ urlFor(route) }}\">{{ titulo }}</a></li>
                                        {% set cantidad = cantidad + 1 %}
                                    {% endif %}
                                {% endif %}
                            {% endfor %}
                        </ul>
                    </li>
                {% endfor %}
            </ul>
            <ul class=\"nav navbar-nav navbar-right\">
                <li><p class=\"navbar-text\">{{ usuario.apellido }}, {{ usuario.nombre }}</p></li>
                <li><a href=\"{{ urlFor('logout') }}\">Salir</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
", "template/menu.twig", "G:\\www\\quiosco\\app\\Views\\template\\menu.twig");
    }
}
