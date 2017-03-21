<?php

/* cliente/index.twig */
class __TwigTemplate_9e5830e306cd0190532fb5ec1cc00d399d9cd0e8022a78877f1d5b203e683ffe extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 2
        $this->parent = $this->loadTemplate("template/base.twig", "cliente/index.twig", 2);
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
        $context["form"] = $this->loadTemplate("template/macro/form.twig", "cliente/index.twig", 1);
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
            App.Cliente.Index();
        })
    </script>
";
    }

    // line 13
    public function block_content($context, array $blocks = array())
    {
        // line 14
        echo "    <h1>Clientes</h1>

    <div id=\"toolbar\">
        <a href=\"";
        // line 17
        echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->urlFor("Cliente:create"), "html", null, true);
        echo "\" class=\"btn btn-success\">
            <i class=\"glyphicon glyphicon-plus\"></i> Nuevo
        </a>
    </div>

    <div class=\"table-responsive\">
        <table id=\"table\" class=\"table table-bordered table-hover\" width=\"100%\">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Localidad</th>
                    <th>Saldo</th>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>
";
    }

    public function getTemplateName()
    {
        return "cliente/index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  55 => 17,  50 => 14,  47 => 13,  35 => 5,  32 => 4,  28 => 2,  26 => 1,  11 => 2,);
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
            App.Cliente.Index();
        })
    </script>
{% endblock %}

{% block content %}
    <h1>Clientes</h1>

    <div id=\"toolbar\">
        <a href=\"{{ urlFor('Cliente:create') }}\" class=\"btn btn-success\">
            <i class=\"glyphicon glyphicon-plus\"></i> Nuevo
        </a>
    </div>

    <div class=\"table-responsive\">
        <table id=\"table\" class=\"table table-bordered table-hover\" width=\"100%\">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Localidad</th>
                    <th>Saldo</th>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>
{% endblock %}
", "cliente/index.twig", "G:\\www\\quiosco\\app\\Views\\cliente\\index.twig");
    }
}
