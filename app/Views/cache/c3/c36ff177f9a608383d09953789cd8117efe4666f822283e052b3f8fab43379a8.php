<?php

/* cliente/form.twig */
class __TwigTemplate_d4fd7eb071bdeb3d47ed45a6c210dd78f7c938848f04fbc26ced3fe959ffefa0 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 2
        $this->parent = $this->loadTemplate("template/base.twig", "cliente/form.twig", 2);
        $this->blocks = array(
            'jsapp' => array($this, 'block_jsapp'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "template/base.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $context["form"] = $this->loadTemplate("template/macro/form.twig", "cliente/form.twig", 1);
        // line 2
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 4
    public function block_jsapp($context, array $blocks = array())
    {
        // line 5
        echo "    <script src=\"";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('siteUrlWithVersion')->getCallable(), array("js/app/cliente.js")), "html", null, true);
        echo "\"></script>
    <script>
        \$(function () {
            App.Cliente.Form();
        })
    </script>
";
    }

    // line 13
    public function block_content($context, array $blocks = array())
    {
        // line 14
        echo "    ";
        $context["is_new"] = (null === ($context["cliente"] ?? null));
        // line 15
        echo "
    <h1>";
        // line 16
        echo ((($context["is_new"] ?? null)) ? ("Nuevo") : ("Modificando"));
        echo " cliente</h1>

    <div class=\"alert alert-danger\" role=\"alert\" id=\"mensaje\" style=\"display:none\"></div>

    <div class=\"row\">
        <div class=\"col-md-6\">
            <form class=\"form\" id=\"form\" action=\"";
        // line 22
        echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->urlFor("Cliente:save"), "html", null, true);
        echo "\" method=\"post\" autocomplete=\"off\">
                ";
        // line 23
        if ( !($context["is_new"] ?? null)) {
            // line 24
            echo "                    <input type=\"hidden\" id=\"id\" name=\"id\" value=\"";
            echo twig_escape_filter($this->env, $this->getAttribute(($context["cliente"] ?? null), "id", array()), "html", null, true);
            echo "\">
                ";
        }
        // line 26
        echo "
                <div class=\"panel panel-default\">
                    <div class=\"panel-body\">
                        ";
        // line 29
        $this->loadTemplate("cliente/_tab_detalle.twig", "cliente/form.twig", 29)->display($context);
        // line 30
        echo "                    </div>
                    <div class=\"panel-footer\">
                        <button type=\"submit\" class=\"btn btn-success\" style=\"margin-right: 15px;\">
                            <i class=\"glyphicon glyphicon-ok\"></i> Guardar
                        </button>
                        <a href=\"";
        // line 35
        echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->urlFor("Cliente:index"), "html", null, true);
        echo "\">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
        <div class=\"col-md-6\">
            <div class=\"panel panel-default\">
                <div class=\"panel-heading\">
                    Cuenta corriente
                </div>
                <div class=\"panel-body\">
                    ";
        // line 46
        if ( !($context["is_new"] ?? null)) {
            // line 47
            echo "                        ";
            $this->loadTemplate("cliente/_tab_cc.twig", "cliente/form.twig", 47)->display($context);
            // line 48
            echo "                    ";
        }
        // line 49
        echo "                </div>
            </div>
        </div>
    </div>
";
    }

    public function getTemplateName()
    {
        return "cliente/form.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  113 => 49,  110 => 48,  107 => 47,  105 => 46,  91 => 35,  84 => 30,  82 => 29,  77 => 26,  71 => 24,  69 => 23,  65 => 22,  56 => 16,  53 => 15,  50 => 14,  47 => 13,  35 => 5,  32 => 4,  28 => 2,  26 => 1,  11 => 2,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% import \"template/macro/form.twig\" as form %}
{% extends \"template/base.twig\" %}

{% block jsapp %}
    <script src=\"{{ siteUrlWithVersion('js/app/cliente.js') }}\"></script>
    <script>
        \$(function () {
            App.Cliente.Form();
        })
    </script>
{% endblock %}

{% block content %}
    {% set is_new = cliente is null %}

    <h1>{{ is_new ? 'Nuevo': 'Modificando' }} cliente</h1>

    <div class=\"alert alert-danger\" role=\"alert\" id=\"mensaje\" style=\"display:none\"></div>

    <div class=\"row\">
        <div class=\"col-md-6\">
            <form class=\"form\" id=\"form\" action=\"{{ urlFor('Cliente:save') }}\" method=\"post\" autocomplete=\"off\">
                {% if not is_new %}
                    <input type=\"hidden\" id=\"id\" name=\"id\" value=\"{{ cliente.id }}\">
                {% endif %}

                <div class=\"panel panel-default\">
                    <div class=\"panel-body\">
                        {% include 'cliente/_tab_detalle.twig' %}
                    </div>
                    <div class=\"panel-footer\">
                        <button type=\"submit\" class=\"btn btn-success\" style=\"margin-right: 15px;\">
                            <i class=\"glyphicon glyphicon-ok\"></i> Guardar
                        </button>
                        <a href=\"{{ urlFor('Cliente:index') }}\">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
        <div class=\"col-md-6\">
            <div class=\"panel panel-default\">
                <div class=\"panel-heading\">
                    Cuenta corriente
                </div>
                <div class=\"panel-body\">
                    {% if not is_new %}
                        {% include 'cliente/_tab_cc.twig' %}
                    {% endif %}
                </div>
            </div>
        </div>
    </div>
{% endblock %}
", "cliente/form.twig", "G:\\www\\quiosco\\app\\Views\\cliente\\form.twig");
    }
}
