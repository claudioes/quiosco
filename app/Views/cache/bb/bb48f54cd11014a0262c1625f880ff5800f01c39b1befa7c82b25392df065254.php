<?php

/* template/sidebar.twig */
class __TwigTemplate_0e35b283a25e9bb42383a1c56de32166ebc5cb026a0b30e92cb4fea7f537b768 extends Twig_Template
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
        if (($context["sidebar"] ?? null)) {
            // line 2
            echo "    <nav class=\"sidebar\">
        <div class=\"center\">
            <ul>
                ";
            // line 5
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["sidebar"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                // line 6
                echo "                    ";
                $context["attr"] = $this->getAttribute($context["item"], "attributes", array());
                // line 7
                echo "                    ";
                $context["permiso"] = twig_trim_filter($this->getAttribute(($context["attr"] ?? null), "permiso", array()));
                // line 8
                echo "
                    ";
                // line 9
                if ($this->getAttribute(($context["usuario"] ?? null), "puede", array(0 => ($context["permiso"] ?? null)), "method")) {
                    // line 10
                    echo "                        ";
                    $context["itemUrl"] = $this->env->getExtension('Slim\Views\TwigExtension')->urlFor($this->getAttribute(($context["attr"] ?? null), "route", array()));
                    // line 11
                    echo "
                        <li ";
                    // line 12
                    echo ((($this->getAttribute(($context["url"] ?? null), "path", array()) == ($context["itemUrl"] ?? null))) ? ("class=\"active\"") : (""));
                    echo ">
                            <a href=\"";
                    // line 13
                    echo twig_escape_filter($this->env, ($context["itemUrl"] ?? null), "html", null, true);
                    echo "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"";
                    echo twig_escape_filter($this->env, $this->getAttribute(($context["attr"] ?? null), "title", array()), "html", null, true);
                    echo "\">
                                <img src=\"";
                    // line 14
                    echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->site($this->getAttribute(($context["attr"] ?? null), "image", array())), "html", null, true);
                    echo "\" height=\"40\" width=\"40\">
                            </a>
                        </li>
                    ";
                }
                // line 18
                echo "                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 19
            echo "            </ul>
        </div>
    </nav>
";
        }
    }

    public function getTemplateName()
    {
        return "template/sidebar.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  70 => 19,  64 => 18,  57 => 14,  51 => 13,  47 => 12,  44 => 11,  41 => 10,  39 => 9,  36 => 8,  33 => 7,  30 => 6,  26 => 5,  21 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% if sidebar %}
    <nav class=\"sidebar\">
        <div class=\"center\">
            <ul>
                {% for item in sidebar %}
                    {% set attr = item.attributes %}
                    {% set permiso = attr.permiso|trim %}

                    {% if usuario.puede(permiso) %}
                        {% set itemUrl = urlFor(attr.route) %}

                        <li {{ url.path == itemUrl ? 'class=\"active\"' }}>
                            <a href=\"{{ itemUrl }}\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"{{ attr.title }}\">
                                <img src=\"{{ siteUrl(attr.image) }}\" height=\"40\" width=\"40\">
                            </a>
                        </li>
                    {% endif %}
                {% endfor %}
            </ul>
        </div>
    </nav>
{% endif %}
", "template/sidebar.twig", "G:\\www\\quiosco\\app\\Views\\template\\sidebar.twig");
    }
}
