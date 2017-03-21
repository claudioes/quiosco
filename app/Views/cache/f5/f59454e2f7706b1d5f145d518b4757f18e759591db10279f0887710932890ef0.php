<?php

/* pedido/index.twig */
class __TwigTemplate_391d7678206cf57882c7711aa3542eae91250389277ed531de947cca058fd401 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("template/base.twig", "pedido/index.twig", 1);
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
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_jsapp($context, array $blocks = array())
    {
        // line 4
        echo "    <script src=\"";
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('siteUrlWithVersion')->getCallable(), array("js/app/pedido.js")), "html", null, true);
        echo "\"></script>
    <script>
        \$(function () {
            App.Pedido.Index();
        });
    </script>
";
    }

    // line 12
    public function block_content($context, array $blocks = array())
    {
        // line 13
        echo "    <h1>Pedidos</h1>

    <div id=\"toolbar\" class=\"btn-group\" role=\"group\">
        <a href=\"";
        // line 16
        echo twig_escape_filter($this->env, $this->env->getExtension('Slim\Views\TwigExtension')->urlFor("Pedido:create"), "html", null, true);
        echo "\" class=\"btn btn-success\"><span class=\"glyphicon glyphicon-plus\"></span> Nuevo</a>
    </div>

    <div class=\"table-responsive\">
        <table id=\"table\" class=\"table table-bordered table-hover\">
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Nombre</th>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>
";
    }

    public function getTemplateName()
    {
        return "pedido/index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  52 => 16,  47 => 13,  44 => 12,  32 => 4,  29 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends \"template/base.twig\" %}

{% block jsapp %}
    <script src=\"{{ siteUrlWithVersion('js/app/pedido.js') }}\"></script>
    <script>
        \$(function () {
            App.Pedido.Index();
        });
    </script>
{% endblock %}

{% block content %}
    <h1>Pedidos</h1>

    <div id=\"toolbar\" class=\"btn-group\" role=\"group\">
        <a href=\"{{ urlFor('Pedido:create') }}\" class=\"btn btn-success\"><span class=\"glyphicon glyphicon-plus\"></span> Nuevo</a>
    </div>

    <div class=\"table-responsive\">
        <table id=\"table\" class=\"table table-bordered table-hover\">
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Nombre</th>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>
{% endblock %}
", "pedido/index.twig", "G:\\www\\quiosco\\app\\Views\\pedido\\index.twig");
    }
}
